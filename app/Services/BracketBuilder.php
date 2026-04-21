<?php

namespace App\Services;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentApplication;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BracketBuilder
{
    /**
     * Build a SINGLE-ELIMINATION bracket with classic snake seeding.
     * - N arbitrary participants (seeded first by seed asc, then unseeded randomized if desired)
     * - If N is not a power of two, create Round 0 (Play-In) feeding into Round 1 slots
     * - Wire every match with next_match_id + next_slot for automatic progression
     */
    public function buildSingleElimination(Tournament $tournament, bool $randomizeUnseeded = true): void
    {
        DB::transaction(function () use ($tournament, $randomizeUnseeded) {
            if ($tournament->status !== 'pending') {
                throw new \RuntimeException('Tournament must be pending to start.');
            }

            /** @var Collection<int,TournamentApplication> $apps */
            $apps = $tournament->applications()->get();
            if ($apps->isEmpty()) {
                throw new \RuntimeException('No participants.');
            }

            // 1) Seed order: seeded (asc), then randomized unseeded if requested
            $seeded   = $apps->filter(fn($a) => $a->seed !== null)->sortBy('seed')->values();
            $unseeded = $apps->filter(fn($a) => $a->seed === null)->values();
            if ($randomizeUnseeded) {
                $unseeded = $unseeded->shuffle();
            }
            $ordered = $seeded->concat($unseeded)->values(); // final order

            // Map seed number -> application_id
            $N = $ordered->count();
            $seedId = [];
            foreach ($ordered as $i => $app) {
                $seedId[$i + 1] = $app->id; // 1-based seeds
            }

            // 2) p = largest power of two <= N
            $p = 1;
            while (($p << 1) <= $N) $p <<= 1;

            $byesToRound1  = (2 * $p) - $N;     // # of seeds directly placed into Round 1
            $prelimMatches = $N - $p;           // # of Round 0 (Play-In) matches

            // 3) Round 1 skeleton with snake positions
            $snakeOrder = $this->seedPositions($p); // e.g., 8 -> [1,8,4,5,3,6,2,7]
            $slotsR1 = array_fill(0, $p, null);

            // Place the top (byesToRound1) seeds directly into Round 1 slots
            foreach ($snakeOrder as $pos => $seedNum) {
                if ($seedNum <= $byesToRound1) {
                    $slotsR1[$pos] = $seedId[$seedNum] ?? null;
                }
            }

            // Create Round 1 matches
            $roundMatches = [];
            $roundMatches[1] = [];
            for ($i = 0; $i < $p; $i += 2) {
                $a = $slotsR1[$i]     ?? null;
                $b = $slotsR1[$i + 1] ?? null;

                $roundMatches[1][] = TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'round'         => 1,
                    'index_in_round' => $i / 2,
                    'participant_a_application_id' => $a,
                    'participant_b_application_id' => $b,
                    // only "in_progress" when BOTH sides present; otherwise keep pending
                    'status'        => ($a && $b) ? 'in_progress' : 'pending',
                ]);
            }

            // 4) Build higher rounds (2..log2(p)), empty for now
            $totalRounds = (int) \log($p, 2);     // e.g., p=8 => 3 rounds: 1,2,3  (Final is round 3)
            for ($r = 2; $r <= $totalRounds; $r++) {
                $roundMatches[$r] = [];
                $prevCount = count($roundMatches[$r - 1]);
                for ($idx = 0; $idx < intdiv($prevCount, 2); $idx++) {
                    $roundMatches[$r][] = TournamentMatch::create([
                        'tournament_id' => $tournament->id,
                        'round'         => $r,
                        'index_in_round' => $idx,
                        'status'        => 'pending',
                    ]);
                }
            }

            // Wire next pointers between rounds 1..(totalRounds-1)
            for ($r = 1; $r < $totalRounds; $r++) {
                foreach ($roundMatches[$r] as $m) {
                    $nextIndex = intdiv($m->index_in_round, 2);
                    $slot      = ($m->index_in_round % 2 === 0) ? 'A' : 'B';
                    $next      = $roundMatches[$r + 1][$nextIndex];
                    $m->update(['next_match_id' => $next->id, 'next_slot' => $slot]);
                }
            }

            // 5) Round 0 (Play-In) if N is not a power of two
            if ($prelimMatches > 0) {
                $roundMatches[0] = [];

                // Seeds that must play Play-In: (byesToRound1 + 1) .. N  (count = 2 * prelimMatches)
                $remainingSeeds = range($byesToRound1 + 1, $N);

                // For each "placeholder" R1 slot (seed > byes), create a Play-In feeding into that slot
                $preIdx = 0;
                foreach ($snakeOrder as $pos => $seedNum) {
                    if ($seedNum <= $byesToRound1) {
                        continue; // this slot already has a top seed
                    }

                    // Pair strongest remaining with weakest remaining to keep bracket fair (e.g., 5 vs 12, 6 vs 11, …)
                    $topSeed = array_shift($remainingSeeds);
                    $botSeed = array_pop($remainingSeeds);

                    $pre = TournamentMatch::create([
                        'tournament_id' => $tournament->id,
                        'round'         => 0,
                        'index_in_round' => $preIdx++,
                        'participant_a_application_id' => $seedId[$topSeed] ?? null,
                        'participant_b_application_id' => $seedId[$botSeed] ?? null,
                        // both sides are present here, so this can start immediately
                        'status'        => 'in_progress',
                    ]);
                    $roundMatches[0][] = $pre;

                    // Wire Play-In winner into the proper Round 1 match + slot
                    $targetMatchIndex = intdiv($pos, 2);
                    $targetSlot       = ($pos % 2 === 0) ? 'A' : 'B';
                    $targetMatch      = $roundMatches[1][$targetMatchIndex];

                    $pre->update([
                        'next_match_id' => $targetMatch->id,
                        'next_slot'     => $targetSlot,
                    ]);
                }
            }

            // IMPORTANT: we do NOT auto-complete any match with a single participant.
            // Round 1 cards will say "Gaida pretinieku" until the paired Play-In finishes.

            $tournament->update(['status' => 'active']);
        });
    }

    /**
     * Snake seeding positions for a power-of-two size.
     * Example: size 8 -> [1,8,4,5,3,6,2,7]
     */
    private function seedPositions(int $size): array
    {
        $build = function ($n) use (&$build) {
            if ($n == 2) return [1, 2];
            $half = $build($n / 2);
            $mir  = array_map(fn($x) => $n + 1 - $x, $half);
            $out = [];
            for ($i = 0; $i < count($half); $i++) {
                $out[] = $half[$i];
                $out[] = $mir[$i];
            }
            return $out;
        };
        return $build($size);
    }
}
