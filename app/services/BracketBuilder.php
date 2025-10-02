<?php

// app/Services/BracketBuilder.php
namespace App\Services;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BracketBuilder
{
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

            // Seeding (seed asc), others randomized if desired
            $seeded   = $apps->filter(fn($a) => $a->seed !== null)->sortBy('seed')->values();
            $unseeded = $apps->filter(fn($a) => $a->seed === null)->values();
            if ($randomizeUnseeded) $unseeded = $unseeded->shuffle();

            $ordered = $seeded->concat($unseeded);

            // Find next power of two
            $n = $ordered->count();
            $size = 1;
            while ($size < $n) $size <<= 1;

            // Snake seeding positions for size
            $positions = $this->seedPositions($size); // [1, size, 3, size-2, ...]
            $slots = array_fill(0, $size, null);
            foreach ($ordered as $i => $app) {
                $pos = $positions[$i] - 1; // 0-based
                $slots[$pos] = $app->id;
            }

            $totalRounds = (int)ceil(log($size, 2));
            $roundMatches = [];

            // Round 1
            $roundMatches[1] = [];
            for ($i = 0; $i < $size; $i += 2) {
                $roundMatches[1][] = TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'round'         => 1,
                    'index_in_round' => $i / 2,
                    'participant_a_application_id' => $slots[$i]   ?? null,
                    'participant_b_application_id' => $slots[$i + 1] ?? null,
                    'status'        => 'pending',
                ]);
            }

            // Higher rounds, empty slots initially
            for ($r = 2; $r <= $totalRounds; $r++) {
                $roundMatches[$r] = [];
                $prev = count($roundMatches[$r - 1]);
                for ($idx = 0; $idx < intdiv($prev, 2); $idx++) {
                    $roundMatches[$r][] = TournamentMatch::create([
                        'tournament_id' => $tournament->id,
                        'round'         => $r,
                        'index_in_round' => $idx,
                        'status'        => 'pending',
                    ]);
                }
            }

            // Cache wiring (deducible, but handy)
            for ($r = 1; $r < $totalRounds; $r++) {
                foreach ($roundMatches[$r] as $m) {
                    $nextIndex = intdiv($m->index_in_round, 2);
                    $slot = ($m->index_in_round % 2 === 0) ? 'A' : 'B';
                    $next = $roundMatches[$r + 1][$nextIndex];
                    $m->update(['next_match_id' => $next->id, 'next_slot' => $slot]);
                }
            }

            // Auto-advance BYEs
            for ($r = 1; $r <= $totalRounds; $r++) {
                foreach ($roundMatches[$r] as $m) $this->tryResolveBye($m);
            }

            $tournament->update(['status' => 'active']);
        });
    }

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

    private function tryResolveBye(TournamentMatch $m): void
    {
        if ($m->winner_slot !== null) return;

        $a = $m->participant_a_application_id;
        $b = $m->participant_b_application_id;

        if ($a && !$b) {
            $m->update(['winner_slot' => 'A', 'score_a' => $m->score_a ?? 0, 'score_b' => $m->score_b ?? 0, 'status' => 'completed']);
            $this->pushWinnerForward($m);
        } elseif ($b && !$a) {
            $m->update(['winner_slot' => 'B', 'score_a' => $m->score_a ?? 0, 'score_b' => $m->score_b ?? 0, 'status' => 'completed']);
            $this->pushWinnerForward($m);
        }
    }

    private function pushWinnerForward(TournamentMatch $m): void
    {
        if (!$m->next_match_id || !$m->winner_slot) return;

        $winnerId = $m->winner_slot === 'A' ? $m->participant_a_application_id : $m->participant_b_application_id;
        if (!$winnerId) return;

        $next = $m->nextMatch()->lockForUpdate()->first();
        if (!$next) return;

        $field = $m->next_slot === 'A' ? 'participant_a_application_id' : 'participant_b_application_id';
        $next->update([$field => $winnerId]);

        // If other side is null, auto-advance further
        if (($next->participant_a_application_id && !$next->participant_b_application_id) ||
            (!$next->participant_a_application_id && $next->participant_b_application_id)
        ) {
            $next->update([
                'winner_slot' => $next->participant_a_application_id ? 'A' : 'B',
                'status'      => 'completed',
                'score_a'     => $next->score_a ?? 0,
                'score_b'     => $next->score_b ?? 0,
            ]);
            $this->pushWinnerForward($next);
        }
    }
}
