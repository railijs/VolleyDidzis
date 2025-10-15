<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use App\Models\TournamentApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.index', compact('tournaments'));
    }

    public function show(Tournament $tournament)
    {
        // Eager-load relations needed to compute/display the winner
        $tournament->load([
            'applications',
            'matches' => fn($q) => $q->orderBy('round')->orderBy('index_in_round'),
            'matches.participantA',
            'matches.participantB',
        ]);

        // Highest round match is the final; winnerApplication() gives us the team
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


        return redirect()->route('dashboard')->with('success', 'Turnīrs veiksmīgi izveidots!');
    }

    public function edit(Tournament $tournament)
    {
        $this->authorizeAdmin();
        return view('tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $this->authorizeAdmin();

        $validated = $this->validateTournament($request);
        $tournament->update($validated);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Turnīra informācija atjaunināta!');
    }

    public function destroy(Tournament $tournament)
    {
        $this->authorizeAdmin();
        $tournament->delete();

        return redirect()->route('dashboard')->with('success', 'Turnīrs izdzēsts.');
    }

    public function calendar()
    {
        $events = Tournament::all()->map(function ($t) {
            return [
                'title' => $t->name,
                'start' => $t->start_date,
                'end'   => $t->end_date,
                'url'   => route('tournaments.show', $t),
                'color' => match ($t->gender_type) {
                    'men'   => '#3b82f6',
                    'women' => '#ec4899',
                    'mix'   => '#f59e0b',
                    default => '#6b7280',
                },
            ];
        })->toArray();

        return view('tournaments.calendar', compact('events'));
    }

    public function dayTournaments($date)
    {
        $dateObj = Carbon::parse($date);
        $tournaments = Tournament::whereDate('start_date', '<=', $dateObj)
            ->whereDate('end_date', '>=', $dateObj)
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.day', ['tournaments' => $tournaments, 'date' => $dateObj]);
    }

    private function authorizeAdmin()
    {
        if (!auth()->user()?->isAdmin()) abort(403, 'Unauthorized');
    }

    private function validateTournament(Request $request)
    {
        $rules = [
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string|max:2000',
            'start_date'     => 'required|date|after_or_equal:today',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'location'       => ['required', 'string', 'min:3', 'max:255', 'regex:/^(?!\d+$)[\p{L}\p{N}\s,\-\.]+$/u'],
            'max_teams'      => 'required|integer|min:2|max:100',
            'team_size'      => 'required|integer|min:4|max:12',
            'gender_type'    => 'required|in:men,women,mix',
            'min_boys'       => 'nullable|integer|min:0',
            'min_girls'      => 'nullable|integer|min:0',
            'min_age'        => 'nullable|integer|min:0|max:100',
            'max_age'        => 'nullable|integer|min:0|max:100',
            'recommendations' => 'nullable|string|max:2000',
        ];

        if ($request->gender_type === 'mix') {
            $rules['min_boys']  = 'required|integer|min:1|lte:team_size';
            $rules['min_girls'] = 'required|integer|min:1|lte:team_size';
        } else {
            $request->merge(['min_boys' => null, 'min_girls' => null]);
        }

        $messages = [
            'name.required' => 'Lūdzu ievadi turnīra nosaukumu.',
            'name.string'   => 'Nosaukumam jābūt tekstam.',
            'name.max'      => 'Nosaukums nedrīkst pārsniegt 255 rakstzīmes.',

            'description.string' => 'Aprakstam jābūt tekstam.',
            'description.max'    => 'Apraksts nedrīkst pārsniegt 2000 rakstzīmes.',

            'start_date.required'       => 'Lūdzu izvēlies sākuma datumu.',
            'start_date.date'           => 'Sākuma datumam jābūt derīgam datumam.',
            'start_date.after_or_equal' => 'Sākuma datumam jābūt šodien vai vēlāk.',
            'end_date.required'         => 'Lūdzu izvēlies beigu datumu.',
            'end_date.date'             => 'Beigu datumam jābūt derīgam datumam.',
            'end_date.after_or_equal'   => 'Beigu datumam jābūt ne agrākam par sākuma datumu.',

            'location.required' => 'Lūdzu norādi norises vietu.',
            'location.string'   => 'Vietai jābūt tekstam.',
            'location.min'      => 'Vietai jāsatur vismaz 3 rakstzīmes.',
            'location.max'      => 'Vieta nedrīkst pārsniegt 255 rakstzīmes.',
            'location.regex'    => 'Vietai jāizskatās pēc reālas vietas (ne tikai cipari).',

            'max_teams.required' => 'Lūdzu norādi maksimālo komandu skaitu.',
            'max_teams.integer'  => 'Maks. komandu skaitam jābūt veselam skaitlim.',
            'max_teams.min'      => 'Komandu skaitam jābūt vismaz 2.',
            'max_teams.max'      => 'Maksimālais komandu skaits nedrīkst pārsniegt 100.',

            'team_size.required' => 'Lūdzu norādi spēlētāju skaitu komandā.',
            'team_size.integer'  => 'Spēlētāju skaitam jābūt veselam skaitlim.',
            'team_size.min'      => 'Komandā jābūt vismaz 4 spēlētājiem.',
            'team_size.max'      => 'Komandā nedrīkst būt vairāk par 12 spēlētājiem.',

            'gender_type.required' => 'Lūdzu izvēlies dzimuma tipu.',
            'gender_type.in'       => 'Dzimuma tips var būt: vīrieši, sievietes vai mix.',

            'min_boys.required' => 'Mix gadījumā jānorāda minimālais puišu skaits.',
            'min_boys.integer'  => 'Min. puišu skaitam jābūt veselam skaitlim.',
            'min_boys.min'      => 'Mix turnīrā jābūt vismaz 1 puisim.',
            'min_boys.lte'      => 'Min. puišu skaits nedrīkst pārsniegt kopējo spēlētāju skaitu.',
            'min_girls.required' => 'Mix gadījumā jānorāda minimālais meiteņu skaits.',
            'min_girls.integer' => 'Min. meiteņu skaitam jābūt veselam skaitlim.',
            'min_girls.min'     => 'Mix turnīrā jābūt vismaz 1 meitenei.',
            'min_girls.lte'     => 'Min. meiteņu skaits nedrīkst pārsniegt kopējo spēlētāju skaitu.',

            'min_age.integer' => 'Minimālajam vecumam jābūt veselam skaitlim.',
            'min_age.min'     => 'Minimālajam vecumam jābūt 0 vai lielākam.',
            'min_age.max'     => 'Minimālais vecums nedrīkst pārsniegt 100.',
            'max_age.integer' => 'Maksimālajam vecumam jābūt veselam skaitlim.',
            'max_age.min'     => 'Maksimālajam vecumam jābūt 0 vai lielākam.',
            'max_age.max'     => 'Maksimālais vecums nedrīkst pārsniegt 100.',
            'recommendations.string' => 'Ieteikumiem jābūt tekstam.',
            'recommendations.max'    => 'Ieteikumi nedrīkst pārsniegt 2000 rakstzīmes.',
        ];

        return Validator::make($request->all(), $rules, $messages)
            ->after(function ($validator) use ($request) {
                if ($request->gender_type === 'mix') {
                    $boys = (int)($request->min_boys ?? 0);
                    $girls = (int)($request->min_girls ?? 0);
                    $size = (int)($request->team_size ?? 0);
                    if ($boys + $girls > $size) {
                        $msg = 'Minimālais puišu + meiteņu skaits nedrīkst pārsniegt spēlētāju skaitu komandā.';
                        $validator->errors()->add('min_boys', $msg);
                        $validator->errors()->add('min_girls', $msg);
                    }
                }
                if ($request->min_age && $request->max_age && (int)$request->max_age < (int)$request->min_age) {
                    $validator->errors()->add('max_age', 'Maksimālajam vecumam jābūt lielākam vai vienādam ar minimālo.');
                }
            })
            ->validate();
    }

    public function statistics(Tournament $tournament)
    {
        // Load matches with ONLY real Eloquent relations
        $matches = \App\Models\TournamentMatch::with(['participantA', 'participantB', 'nextMatch'])
            ->where('tournament_id', $tournament->id)
            ->orderBy('round')
            ->orderBy('index_in_round')
            ->get();

        $totalMatches     = $matches->count();
        $completed        = $matches->where('status', 'completed');
        $completedMatches = $completed->count();
        $completionPct    = $totalMatches ? round(($completedMatches / $totalMatches) * 100) : 0;

        // Totals & averages (completed only)
        $totPoints = $completed->sum(function ($m) {
            return (int) ($m->score_a ?? 0) + (int) ($m->score_b ?? 0);
        });
        $avgPoints = $completedMatches ? round($totPoints / $completedMatches, 1) : 0;

        // Highest scoring game (by combined points)
        $highestScoring = $completed
            ->filter(fn($m) => $m->score_a !== null && $m->score_b !== null)
            ->sortByDesc(fn($m) => (int) $m->score_a + (int) $m->score_b)
            ->first();

        // Biggest win by absolute point difference
        $biggestWin = $completed
            ->filter(fn($m) => $m->score_a !== null && $m->score_b !== null)
            ->sortByDesc(fn($m) => abs((int) $m->score_a - (int) $m->score_b))
            ->first();

        // Wins per application id
        $winsByAppId = [];
        foreach ($completed as $m) {
            if ($m->winner_slot === 'A' && $m->participant_a_application_id) {
                $winsByAppId[$m->participant_a_application_id] = ($winsByAppId[$m->participant_a_application_id] ?? 0) + 1;
            } elseif ($m->winner_slot === 'B' && $m->participant_b_application_id) {
                $winsByAppId[$m->participant_b_application_id] = ($winsByAppId[$m->participant_b_application_id] ?? 0) + 1;
            }
        }

        // Build wins table (team name + wins), sorted desc
        $winsTable = collect($winsByAppId)
            ->map(function ($wins, $appId) {
                $app = \App\Models\TournamentApplication::find($appId);
                return [
                    'team'            => $app?->team_name ?? '—',
                    'wins'            => $wins,
                    'application_id'  => (int) $appId,
                ];
            })
            ->sortByDesc('wins')
            ->values();

        // Top 3 teams by wins (for podium)
        $topThree = $winsTable->take(3);

        // Champion (determine explicitly, not via eager-loading a non-relation)
        $finalRound = $matches->max('round');
        $finalMatch = $matches->firstWhere('round', $finalRound);

        $champion = null;
        if ($finalMatch && $finalMatch->winner_slot) {
            $winnerId = $finalMatch->winner_slot === 'A'
                ? $finalMatch->participant_a_application_id
                : $finalMatch->participant_b_application_id;

            $champion = $winnerId ? \App\Models\TournamentApplication::find($winnerId) : null;
        }

        // Champion path (matches they won from earliest to final)
        $championPath = collect();
        if ($champion && $finalMatch) {
            $current = $finalMatch;
            $appId   = (int) $champion->id;

            while ($current) {
                $championPath->prepend($current);

                $prev = $matches->first(function ($m) use ($current, $appId) {
                    if ((int) $m->next_match_id !== (int) $current->id) return false;

                    $wonA = $m->winner_slot === 'A' && (int) $m->participant_a_application_id === $appId;
                    $wonB = $m->winner_slot === 'B' && (int) $m->participant_b_application_id === $appId;

                    return $wonA || $wonB;
                });

                if (!$prev) break;
                $current = $prev;
            }
        }

        return view('tournaments.statistics', [
            'tournament'       => $tournament,
            'totalMatches'     => $totalMatches,
            'completedMatches' => $completedMatches,
            'completionPct'    => $completionPct,
            'totPoints'        => $totPoints,
            'avgPoints'        => $avgPoints,
            'highestScoring'   => $highestScoring,
            'biggestWin'       => $biggestWin,
            'winsTable'        => $winsTable,
            'champion'         => $champion,
            'championPath'     => $championPath,
            'topThree'         => $topThree,
        ]);
    }
}
