<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::with('applications')
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.index', compact('tournaments'));
    }

    public function show(Tournament $tournament)
    {
        $tournament->load([
            'applications',
            'matches'                  => fn($q) => $q->orderBy('round')->orderBy('index_in_round'),
            'matches.participantA',
            'matches.participantB',
        ]);

        $finalMatch = $tournament->matches->sortByDesc('round')->first();
        $winnerName = optional($finalMatch?->winnerApplication())->team_name;

        return view('tournaments.show', [
            'tournament' => $tournament,
            'winnerName' => $winnerName,
        ]);
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('tournaments.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $validated = $this->validateTournament($request);

        $tournament = Tournament::create(array_merge($validated, [
            'creator_id' => auth()->id(),
        ]));

        // FIX: redirect to the newly created tournament, not the dashboard
        return redirect()
            ->route('tournaments.show', $tournament)
            ->with('success', 'Turnīrs veiksmīgi izveidots!');
    }

    public function edit(Tournament $tournament)
    {
        $this->authorizeAdmin();
        return view('tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $this->authorizeAdmin();
        $validated = $this->validateTournament($request, $tournament);
        $tournament->update($validated);

        return redirect()
            ->route('tournaments.show', $tournament)
            ->with('success', 'Turnīra informācija atjaunināta!');
    }

    public function destroy(Tournament $tournament)
    {
        $this->authorizeAdmin();
        $tournament->delete();

        return redirect()->route('tournaments.index')->with('success', 'Turnīrs izdzēsts.');
    }

    public function calendar()
    {
        // Pass gender_type through so the blade can colour chips correctly
        $events = Tournament::all()->map(fn($t) => [
            'title'       => $t->name,
            'start'       => $t->start_date,
            'end'         => $t->end_date,
            'url'         => route('tournaments.show', $t),
            'gender_type' => $t->gender_type,
        ])->toArray();

        return view('tournaments.calendar', compact('events'));
    }

    public function dayTournaments($date)
    {
        $dateObj     = Carbon::parse($date);
        $tournaments = Tournament::whereDate('start_date', '<=', $dateObj)
            ->whereDate('end_date', '>=', $dateObj)
            ->orderBy('start_date')
            ->get();

        return view('tournaments.day', ['tournaments' => $tournaments, 'date' => $dateObj]);
    }

    // ── Statistics ──────────────────────────────────────────────────────────

    public function statistics(Tournament $tournament)
    {
        $matches = \App\Models\TournamentMatch::with(['participantA', 'participantB', 'nextMatch'])
            ->where('tournament_id', $tournament->id)
            ->orderBy('round')->orderBy('index_in_round')
            ->get();

        $totalMatches     = $matches->count();
        $completed        = $matches->where('status', 'completed');
        $completedMatches = $completed->count();
        $completionPct    = $totalMatches ? round(($completedMatches / $totalMatches) * 100) : 0;

        $totPoints = $completed->sum(fn($m) => (int)($m->score_a ?? 0) + (int)($m->score_b ?? 0));
        $avgPoints = $completedMatches ? round($totPoints / $completedMatches, 1) : 0;

        $highestScoring = $completed
            ->filter(fn($m) => $m->score_a !== null && $m->score_b !== null)
            ->sortByDesc(fn($m) => (int)$m->score_a + (int)$m->score_b)
            ->first();

        $biggestWin = $completed
            ->filter(fn($m) => $m->score_a !== null && $m->score_b !== null)
            ->sortByDesc(fn($m) => abs((int)$m->score_a - (int)$m->score_b))
            ->first();

        $winsByAppId = [];
        foreach ($completed as $m) {
            if ($m->winner_slot === 'A' && $m->participant_a_application_id) {
                $winsByAppId[$m->participant_a_application_id] = ($winsByAppId[$m->participant_a_application_id] ?? 0) + 1;
            } elseif ($m->winner_slot === 'B' && $m->participant_b_application_id) {
                $winsByAppId[$m->participant_b_application_id] = ($winsByAppId[$m->participant_b_application_id] ?? 0) + 1;
            }
        }

        $winsTable = collect($winsByAppId)
            ->map(fn($wins, $appId) => [
                'team'           => TournamentApplication::find($appId)?->team_name ?? '—',
                'wins'           => $wins,
                'application_id' => (int) $appId,
            ])
            ->sortByDesc('wins')
            ->values();

        $topThree   = $winsTable->take(3);
        $finalRound = $matches->max('round');
        $finalMatch = $matches->firstWhere('round', $finalRound);
        $champion   = null;

        if ($finalMatch && $finalMatch->winner_slot) {
            $winnerId = $finalMatch->winner_slot === 'A'
                ? $finalMatch->participant_a_application_id
                : $finalMatch->participant_b_application_id;
            $champion = $winnerId ? TournamentApplication::find($winnerId) : null;
        }

        $championPath = collect();
        if ($champion && $finalMatch) {
            $current = $finalMatch;
            $appId   = (int) $champion->id;
            while ($current) {
                $championPath->prepend($current);
                $prev = $matches->first(function ($m) use ($current, $appId) {
                    if ((int)$m->next_match_id !== (int)$current->id) return false;
                    return ($m->winner_slot === 'A' && (int)$m->participant_a_application_id === $appId)
                        || ($m->winner_slot === 'B' && (int)$m->participant_b_application_id === $appId);
                });
                if (!$prev) break;
                $current = $prev;
            }
        }

        return view('tournaments.statistics', compact(
            'tournament',
            'totalMatches',
            'completedMatches',
            'completionPct',
            'totPoints',
            'avgPoints',
            'highestScoring',
            'biggestWin',
            'winsTable',
            'champion',
            'championPath',
            'topThree'
        ));
    }

    // ── Helpers ─────────────────────────────────────────────────────────────

    private function authorizeAdmin(): void
    {
        if (!auth()->user()?->isAdmin()) abort(403);
    }

    private function validateTournament(Request $request, ?Tournament $existing = null): array
    {
        $rules = [
            // FIX: name max bumped from 50 → 150 (50 was too tight for real tournament names)
            'name'            => 'required|string|max:150',
            // FIX: description max aligned with the form UI (was 255, form says 2000)
            'description'     => 'nullable|string|max:2000',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'location'        => ['required', 'string', 'min:3', 'max:255', 'regex:/^(?!\d+$)[\p{L}\p{N}\s,\-\.]+$/u'],
            'max_teams'       => 'required|integer|min:2|max:100',
            'team_size'       => 'required|integer|min:4|max:12',
            'gender_type'     => 'required|in:men,women,mix',
            'min_boys'        => 'nullable|integer|min:0',
            'min_girls'       => 'nullable|integer|min:0',
            'min_age'         => 'nullable|integer|min:0|max:100',
            'max_age'         => 'nullable|integer|min:0|max:100',
            'recommendations' => 'nullable|string|max:2000',
        ];

        // On edit, allow start_date to be today even if unchanged
        if ($existing) {
            $rules['start_date'] = 'required|date';
        }

        if ($request->gender_type === 'mix') {
            $rules['min_boys']  = 'required|integer|min:1|lte:team_size';
            $rules['min_girls'] = 'required|integer|min:1|lte:team_size';
        } else {
            $request->merge(['min_boys' => null, 'min_girls' => null]);
        }

        $messages = [
            'name.required'       => 'Lūdzu ievadi turnīra nosaukumu.',
            'name.max'            => 'Nosaukums nedrīkst pārsniegt 150 rakstzīmes.',
            'description.max'     => 'Apraksts nedrīkst pārsniegt 2000 rakstzīmes.',
            'start_date.required' => 'Lūdzu izvēlies sākuma datumu.',
            'start_date.date'     => 'Sākuma datumam jābūt derīgam datumam.',
            'start_date.after_or_equal' => 'Sākuma datumam jābūt šodien vai vēlāk.',
            'end_date.required'   => 'Lūdzu izvēlies beigu datumu.',
            'end_date.after_or_equal' => 'Beigu datumam jābūt ne agrākam par sākuma datumu.',
            'location.required'   => 'Lūdzu norādi norises vietu.',
            'location.min'        => 'Vietai jāsatur vismaz 3 rakstzīmes.',
            'location.regex'      => 'Vietai jāizskatās pēc reālas vietas (ne tikai cipari).',
            'max_teams.required'  => 'Lūdzu norādi maksimālo komandu skaitu.',
            'max_teams.min'       => 'Komandu skaitam jābūt vismaz 2.',
            'max_teams.max'       => 'Maksimālais komandu skaits nedrīkst pārsniegt 100.',
            'team_size.required'  => 'Lūdzu norādi spēlētāju skaitu komandā.',
            'team_size.min'       => 'Komandā jābūt vismaz 4 spēlētājiem.',
            'team_size.max'       => 'Komandā nedrīkst būt vairāk par 12 spēlētājiem.',
            'gender_type.required' => 'Lūdzu izvēlies dzimuma tipu.',
            'gender_type.in'      => 'Dzimuma tips var būt: vīrieši, sievietes vai mix.',
            'min_boys.required'   => 'Mix gadījumā jānorāda minimālais puišu skaits.',
            'min_boys.min'        => 'Mix turnīrā jābūt vismaz 1 puisim.',
            'min_boys.lte'        => 'Min. puišu skaits nedrīkst pārsniegt kopējo spēlētāju skaitu.',
            'min_girls.required'  => 'Mix gadījumā jānorāda minimālais meiteņu skaits.',
            'min_girls.min'       => 'Mix turnīrā jābūt vismaz 1 meitenei.',
            'min_girls.lte'       => 'Min. meiteņu skaits nedrīkst pārsniegt kopējo spēlētāju skaitu.',
            'min_age.max'         => 'Vecums nedrīkst pārsniegt 100.',
            'max_age.max'         => 'Vecums nedrīkst pārsniegt 100.',
            'recommendations.max' => 'Ieteikumi nedrīkst pārsniegt 2000 rakstzīmes.',
        ];

        return Validator::make($request->all(), $rules, $messages)
            ->after(function ($v) use ($request) {
                if ($request->gender_type === 'mix') {
                    $boys  = (int)($request->min_boys  ?? 0);
                    $girls = (int)($request->min_girls ?? 0);
                    $size  = (int)($request->team_size ?? 0);
                    if ($boys + $girls > $size) {
                        $msg = 'Minimālais puišu + meiteņu skaits nedrīkst pārsniegt spēlētāju skaitu komandā.';
                        $v->errors()->add('min_boys',  $msg);
                        $v->errors()->add('min_girls', $msg);
                    }
                }
                if (
                    $request->min_age && $request->max_age
                    && (int)$request->max_age < (int)$request->min_age
                ) {
                    $v->errors()->add('max_age', 'Maksimālajam vecumam jābūt lielākam vai vienādam ar minimālo.');
                }
            })
            ->validate();
    }
}
