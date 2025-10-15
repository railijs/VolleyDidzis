<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TournamentMatch;
use App\Models\TournamentApplication;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // ---- Filters ----
        $q             = trim((string) $request->get('q', ''));
        $min           = (int) $request->get('min', 0);
        $sort          = (string) $request->get('sort', 'wins');  // wins == titles
        $dir           = (string) $request->get('dir', 'desc');   // asc | desc
        $onlyCompleted = $request->boolean('completed', false);

        // ---- Pull matches across ALL tournaments ----
        $matchesQuery = TournamentMatch::with(['participantA', 'participantB']);
        if ($onlyCompleted) {
            $matchesQuery->where('status', 'completed');
        }
        $matches = $matchesQuery
            ->orderBy('tournament_id')
            ->orderBy('round')
            ->orderBy('index_in_round')
            ->get();

        // ---- Accumulators per **team name** (merged) ----
        $stats = []; // key = normalized team name

        $ensureTeam = function (string $key, string $display) use (&$stats) {
            if (!isset($stats[$key])) {
                $stats[$key] = [
                    'team'        => $display ?: '—',  // display name (first seen)
                    'played'      => 0,
                    'wins'        => 0,     // will mirror 'titles'
                    'losses'      => 0,     // per-match losses (for win_rate)
                    'pf'          => 0,
                    'pa'          => 0,
                    'pf_avg'      => 0.0,
                    'pa_avg'      => 0.0,
                    'diff'        => 0,
                    'win_rate'    => 0.0,
                    'best_round'  => 0,
                    'best_single' => 0,
                    'titles'      => 0,     // (whole tournaments)
                    'finals'      => 0,     // finals appearances
                ];
            }
        };

        // ---- Per-match accumulation (by merged name) ----
        foreach ($matches as $m) {
            $sa = (int) ($m->score_a ?? 0);
            $sb = (int) ($m->score_b ?? 0);
            $completed = $m->status === 'completed';

            // Side A
            if ($m->participant_a_application_id) {
                $aname = (string) ($m->participantA?->team_name ?? '—');
                $akey  = $this->teamKey($aname);
                $ensureTeam($akey, $aname);

                if ($completed) {
                    $stats[$akey]['played'] += 1;
                    $stats[$akey]['pf']     += $sa;
                    $stats[$akey]['pa']     += $sb;
                    $stats[$akey]['diff']   += ($sa - $sb);
                    $stats[$akey]['best_single'] = max($stats[$akey]['best_single'], $sa);

                    if ($m->winner_slot === 'B') {
                        $stats[$akey]['losses'] += 1;
                    }
                }
                $stats[$akey]['best_round'] = max($stats[$akey]['best_round'], (int) $m->round);
            }

            // Side B
            if ($m->participant_b_application_id) {
                $bname = (string) ($m->participantB?->team_name ?? '—');
                $bkey  = $this->teamKey($bname);
                $ensureTeam($bkey, $bname);

                if ($completed) {
                    $stats[$bkey]['played'] += 1;
                    $stats[$bkey]['pf']     += $sb;
                    $stats[$bkey]['pa']     += $sa;
                    $stats[$bkey]['diff']   += ($sb - $sa);
                    $stats[$bkey]['best_single'] = max($stats[$bkey]['best_single'], $sb);

                    if ($m->winner_slot === 'A') {
                        $stats[$bkey]['losses'] += 1;
                    }
                }
                $stats[$bkey]['best_round'] = max($stats[$bkey]['best_round'], (int) $m->round);
            }
        }

        // ---- Titles (champions) + finals appearances (by merged name) ----
        $byTournament = $matches->groupBy('tournament_id');

        foreach ($byTournament as $tournamentId => $tmatches) {
            if ($tmatches->isEmpty()) continue;

            $maxRound = (int) $tmatches->max('round');
            $finals   = $tmatches->where('round', $maxRound)->where('status', 'completed');
            if ($finals->isEmpty()) continue;

            foreach ($finals as $final) {
                $aname = $final->participantA?->team_name;
                $bname = $final->participantB?->team_name;
                $akey  = $aname ? $this->teamKey($aname) : null;
                $bkey  = $bname ? $this->teamKey($bname) : null;

                if ($akey) {
                    $ensureTeam($akey, $aname);
                    $stats[$akey]['finals'] = ($stats[$akey]['finals'] ?? 0) + 1;
                }
                if ($bkey) {
                    $ensureTeam($bkey, $bname);
                    $stats[$bkey]['finals'] = ($stats[$bkey]['finals'] ?? 0) + 1;
                }

                // Resolve winner (prefer winner_slot, fallback to score)
                $winnerKey = null;
                if ($final->winner_slot === 'A' && $akey) {
                    $winnerKey = $akey;
                } elseif ($final->winner_slot === 'B' && $bkey) {
                    $winnerKey = $bkey;
                } else {
                    $sa = (int) ($final->score_a ?? 0);
                    $sb = (int) ($final->score_b ?? 0);
                    if ($sa > $sb) $winnerKey = $akey;
                    elseif ($sb > $sa) $winnerKey = $bkey;
                }

                if ($winnerKey) {
                    $stats[$winnerKey]['titles'] = ($stats[$winnerKey]['titles'] ?? 0) + 1;
                }
            }
        }

        // ---- Derived metrics + search + set wins==titles ----
        $rows = collect($stats)->map(function ($r) {
            $p    = max(1, (int) $r['played']);
            $loss = (int) $r['losses'];

            $r['pf_avg']   = $p > 0 ? ($r['pf'] / $p) : 0.0;
            $r['pa_avg']   = $p > 0 ? ($r['pa'] / $p) : 0.0;

            $matchCount    = (int) $r['played'];
            $r['win_rate'] = $matchCount > 0
                ? round((($matchCount - $loss) / $matchCount) * 100, 2)
                : 0.0;

            $r['titles']   = (int) ($r['titles'] ?? 0);
            $r['wins']     = $r['titles']; // back-compat for sorting/UI

            return $r;
        })->filter(function ($r) use ($q, $min) {
            if ($q !== '' && stripos($r['team'], $q) === false) return false;
            if ($min > 0 && (int) $r['played'] < $min) return false;
            return true;
        });

        // ---- Badges (now based on titles) ----
        $maxWins    = (int) ($rows->max('wins') ?? 0);
        $maxWinRate = (float) ($rows->max('win_rate') ?? 0);
        $maxPFavg   = (float) ($rows->max('pf_avg') ?? 0);
        $minPAavg   = $rows->count() ? (float) $rows->min('pa_avg') : null;
        $maxDiff    = (int) ($rows->max('diff') ?? 0);

        // ---- Sorting ----
        $allowedSort = ['wins', 'titles', 'finals', 'win_rate', 'diff', 'pf_avg', 'pa_avg', 'played'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'wins';
        }
        $rows = $rows->sortBy($sort, SORT_NATURAL, strtolower($dir) === 'desc')->values();

        return view('tournaments.leaderboard', [
            'q'             => $q,
            'min'           => $min,
            'sort'          => $sort,
            'dir'           => $dir,
            'onlyCompleted' => $onlyCompleted,

            'rows'       => $rows,
            'maxWins'    => $maxWins,
            'maxWinRate' => $maxWinRate,
            'maxPFavg'   => $maxPFavg,
            'minPAavg'   => $minPAavg,
            'maxDiff'    => $maxDiff,
        ]);
    }

    /**
     * Build a stable, diacritics/case/punctuation-insensitive key for a team name.
     * E.g. "Rīga Spikers", "riga  spikers" -> "riga spikers"
     */
    private function teamKey(?string $name): string
    {
        $s = (string) ($name ?? '');
        $s = trim(preg_replace('/\s+/', ' ', $s));

        // Try transliteration (diacritics -> ASCII). Use intl if available; else iconv; else fallback.
        if (class_exists(\Transliterator::class)) {
            $tr = \Transliterator::create('Any-Latin; Latin-ASCII;');
            if ($tr) {
                $s = $tr->transliterate($s);
            }
        } else {
            $tmp = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
            if ($tmp !== false) {
                $s = $tmp;
            }
        }

        $s = mb_strtolower($s, 'UTF-8');
        $s = preg_replace('/[^a-z0-9]+/i', ' ', $s);      // keep letters/numbers, collapse others to space
        $s = trim(preg_replace('/\s+/', ' ', $s));        // single-space
        return $s;
    }
}
