<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TournamentMatch;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // ── Filters ──────────────────────────────────────────────────────────
        $q    = trim((string) $request->get('q', ''));
        $min  = (int) $request->get('min', 0);
        $sort = (string) $request->get('sort', 'wins');
        $dir  = (string) $request->get('dir', 'desc');

        // ── Pull all matches (only completed ones count for stats) ────────────
        $matches = TournamentMatch::with(['participantA', 'participantB'])
            ->orderBy('tournament_id')
            ->orderBy('round')
            ->orderBy('index_in_round')
            ->get();

        // ── Accumulators ─────────────────────────────────────────────────────
        $stats = [];

        $ensure = function (string $key, string $display) use (&$stats) {
            if (!isset($stats[$key])) {
                $stats[$key] = [
                    'team'       => $display ?: '—',
                    'played'     => 0,
                    'losses'     => 0,
                    'pf'         => 0,
                    'pa'         => 0,
                    'diff'       => 0,
                    'titles'     => 0,
                    'finals'     => 0,
                    'best_round' => 0,
                ];
            }
        };

        // Per-match stats
        foreach ($matches as $m) {
            $sa        = (int) ($m->score_a ?? 0);
            $sb        = (int) ($m->score_b ?? 0);
            $completed = $m->status === 'completed';

            if ($m->participant_a_application_id) {
                $aname = (string) ($m->participantA?->team_name ?? '—');
                $akey  = $this->teamKey($aname);
                $ensure($akey, $aname);
                $stats[$akey]['best_round'] = max($stats[$akey]['best_round'], (int) $m->round);
                if ($completed) {
                    $stats[$akey]['played']++;
                    $stats[$akey]['pf']   += $sa;
                    $stats[$akey]['pa']   += $sb;
                    $stats[$akey]['diff'] += ($sa - $sb);
                    if ($m->winner_slot === 'B') $stats[$akey]['losses']++;
                }
            }

            if ($m->participant_b_application_id) {
                $bname = (string) ($m->participantB?->team_name ?? '—');
                $bkey  = $this->teamKey($bname);
                $ensure($bkey, $bname);
                $stats[$bkey]['best_round'] = max($stats[$bkey]['best_round'], (int) $m->round);
                if ($completed) {
                    $stats[$bkey]['played']++;
                    $stats[$bkey]['pf']   += $sb;
                    $stats[$bkey]['pa']   += $sa;
                    $stats[$bkey]['diff'] += ($sb - $sa);
                    if ($m->winner_slot === 'A') $stats[$bkey]['losses']++;
                }
            }
        }

        // Titles + finals appearances
        foreach ($matches->groupBy('tournament_id') as $tmatches) {
            $maxRound = (int) $tmatches->max('round');
            $finals   = $tmatches->where('round', $maxRound)->where('status', 'completed');
            foreach ($finals as $final) {
                $aname = $final->participantA?->team_name;
                $bname = $final->participantB?->team_name;
                $akey  = $aname ? $this->teamKey($aname) : null;
                $bkey  = $bname ? $this->teamKey($bname) : null;

                if ($akey) {
                    $ensure($akey, $aname);
                    $stats[$akey]['finals']++;
                }
                if ($bkey) {
                    $ensure($bkey, $bname);
                    $stats[$bkey]['finals']++;
                }

                // Winner: prefer winner_slot, fallback to score comparison
                $winnerKey = null;
                if ($final->winner_slot === 'A' && $akey)      $winnerKey = $akey;
                elseif ($final->winner_slot === 'B' && $bkey)  $winnerKey = $bkey;
                else {
                    $sa = (int) ($final->score_a ?? 0);
                    $sb = (int) ($final->score_b ?? 0);
                    if ($sa > $sb)      $winnerKey = $akey;
                    elseif ($sb > $sa)  $winnerKey = $bkey;
                }
                if ($winnerKey) $stats[$winnerKey]['titles']++;
            }
        }

        // Derived metrics
        $all = collect($stats)->map(function ($r) {
            $p             = max(1, (int) $r['played']);
            $r['pf_avg']   = $r['played'] > 0 ? round($r['pf'] / $p, 2) : 0.0;
            $r['pa_avg']   = $r['played'] > 0 ? round($r['pa'] / $p, 2) : 0.0;
            $r['win_rate'] = $r['played'] > 0
                ? round((($r['played'] - $r['losses']) / $r['played']) * 100, 2)
                : 0.0;
            $r['wins']     = $r['titles']; // alias kept for template back-compat
            return $r;
        });

        // ── SORT GLOBALLY (before any filtering) ─────────────────────────────
        $allowed = ['wins', 'titles', 'finals', 'win_rate', 'diff', 'pf_avg', 'pa_avg', 'played'];
        if (!in_array($sort, $allowed, true)) $sort = 'wins';

        $sorted = $all->sortBy($sort, SORT_NATURAL, strtolower($dir) === 'desc')->values();

        /*
         * KEY FIX: assign global rank BEFORE applying search/min filters.
         * This means a searched team keeps its true position (e.g. rank 7)
         * and the podium always shows the true top-3, never a search result.
         */
        $globalRanks = []; // teamKey -> 1-based rank
        foreach ($sorted as $pos => $r) {
            // We need the team key — re-derive it from the team name
            $globalRanks[$this->teamKey($r['team'])] = $pos + 1;
        }

        // Store global top-3 separately (unaffected by search)
        $globalTop3 = $sorted->take(3)->values();
        $maxTitles  = max(1, (int) ($sorted->max('titles') ?? 1));

        // ── Now filter for the table ──────────────────────────────────────────
        $filtered = $sorted->filter(function ($r) use ($q, $min) {
            if ($q !== '' && stripos($r['team'], $q) === false) return false;
            if ($min > 0 && (int) $r['played'] < $min) return false;
            return true;
        })->values();

        // ── Pagination ───────────────────────────────────────────────────────
        $perPage  = (int) max(1, min(100, $request->get('per_page', 20)));
        $page     = (int) max(1, $request->get('page', 1));
        $total    = $filtered->count();
        $lastPage = (int) ceil($total / $perPage) ?: 1;
        $page     = min($page, $lastPage);

        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $filtered->forPage($page, $perPage)->values(),
            $total,
            $perPage,
            $page,
            [
                'path'     => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'query'    => $request->query(),
                'pageName' => 'page',
            ]
        );
        $paginated->appends($request->except('page'));

        return view('tournaments.leaderboard', [
            'q'           => $q,
            'min'         => $min,
            'sort'        => $sort,
            'dir'         => $dir,
            'rows'        => $paginated,       // paginated & filtered (table only)
            'globalTop3'  => $globalTop3,      // always true top-3, unfiltered
            'globalRanks' => $globalRanks,     // teamKey -> global rank number
            'maxTitles'   => $maxTitles,
            'totalTeams'  => $total,           // count of filtered teams (for footer)
            'allTeams'    => $sorted->count(), // total unfiltered count
        ]);
    }

    /** Public alias so the blade can call teamKeyPublic() for rank lookup */
    public function teamKeyPublic(?string $name): string
    {
        return $this->teamKey($name);
    }

    private function teamKey(?string $name): string
    {
        $s = trim(preg_replace('/\s+/', ' ', (string) ($name ?? '')));
        if (class_exists(\Transliterator::class)) {
            $tr = \Transliterator::create('Any-Latin; Latin-ASCII;');
            if ($tr) $s = $tr->transliterate($s);
        } else {
            $tmp = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
            if ($tmp !== false) $s = $tmp;
        }
        $s = mb_strtolower($s, 'UTF-8');
        $s = preg_replace('/[^a-z0-9]+/i', ' ', $s);
        return trim(preg_replace('/\s+/', ' ', $s));
    }
}
