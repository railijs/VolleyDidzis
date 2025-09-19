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
    /*** List tournaments ***/
    public function index()
    {
        $tournaments = Tournament::where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.index', compact('tournaments'));
    }

    /*** Show single tournament ***/
    public function show(Tournament $tournament)
    {
        return view('tournaments.show', compact('tournament'));
    }

    /*** Create form (Admin only) ***/
    public function create()
    {
        $this->authorizeAdmin();
        return view('tournaments.create');
    }

    /*** Store tournament (Admin only) ***/
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $this->validateTournament($request);

        $tournament = Tournament::create(array_merge($validated, [
            'creator_id' => auth()->id(),
        ]));

        return redirect()->route('dashboard')->with('success', 'Tournament successfully created!');
    }

    /*** Edit form (Admin only) ***/
    public function edit(Tournament $tournament)
    {
        $this->authorizeAdmin();
        return view('tournaments.edit', compact('tournament'));
    }

    /*** Update tournament (Admin only) ***/
    public function update(Request $request, Tournament $tournament)
    {
        $this->authorizeAdmin();

        $validated = $this->validateTournament($request);

        $tournament->update($validated);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Tournament updated successfully!');
    }

    /*** Delete tournament (Admin only) ***/
    public function destroy(Tournament $tournament)
    {
        $this->authorizeAdmin();
        $tournament->delete();
        return redirect()->route('tournaments.index')->with('success', 'Tournament deleted.');
    }

    /*** Apply to join tournament ***/
    public function join(Request $request, Tournament $tournament)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'captain_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        if ($tournament->status !== 'pending') {
            return back()->withErrors(['team_name' => 'Tournament already started or finished.']);
        }

        if (!is_null($tournament->max_teams) && $tournament->applications()->count() >= $tournament->max_teams) {
            return back()->withErrors(['team_name' => 'Tournament is full. Applications closed.']);
        }

        $tournament->applications()->create([
            'team_name' => $request->team_name,
            'captain_name' => $request->captain_name,
            'email' => $request->email,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Your application has been submitted!');
    }

    /*** Start tournament (creator/admin) ***/
    public function start(Tournament $tournament)
{
    if (auth()->id() !== $tournament->creator_id && !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized.');
    }

    if ($tournament->status !== 'pending') {
        return back()->with('error', 'Tournament cannot be started.');
    }

    $tournament->update(['status' => 'active']);

    $participants = $tournament->applications()->inRandomOrder()->get();

    $matches = [];

    // First round matches
    for ($i = 0; $i < $participants->count(); $i += 2) {
        $teamA = $participants[$i]->team_name;
        $teamB = $participants[$i + 1]->team_name ?? 'BYE';

        $matches[] = TournamentMatch::create([
            'tournament_id' => $tournament->id,
            'team_a' => $teamA,
            'team_b' => $teamB,
            'round' => 1,
        ]);
    }

    // Generate placeholders for next rounds using 'BYE' instead of null
    $totalRounds = ceil(log(count($participants), 2));
    $previousRoundMatches = $matches;

    for ($round = 2; $round <= $totalRounds; $round++) {
        $newRoundMatches = [];
        for ($i = 0; $i < ceil(count($previousRoundMatches) / 2); $i++) {
            $newRoundMatches[] = TournamentMatch::create([
                'tournament_id' => $tournament->id,
                'team_a' => 'BYE',
                'team_b' => 'BYE',
                'round' => $round,
            ]);
        }

        // Link previous matches to next round
        foreach ($previousRoundMatches as $idx => $match) {
            $nextMatchIdx = floor($idx / 2);
            $match->update(['next_match_id' => $newRoundMatches[$nextMatchIdx]->id]);
        }

        $previousRoundMatches = $newRoundMatches;
    }

    return redirect()->route('tournaments.stats', $tournament)
        ->with('success', 'Tournament started and bracket generated!');
}

    /*** Stop tournament (creator/admin) ***/
    public function stop(Tournament $tournament)
    {
        if (auth()->id() !== $tournament->creator_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        if ($tournament->status !== 'active') {
            return back()->with('error', 'Only active tournaments can be stopped.');
        }

        $tournament->update(['status' => 'completed']);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Tournament has been stopped.');
    }

    /*** Tournament stats ***/
    public function stats(Tournament $tournament)
    {
        $participants = $tournament->applications;
        $matches = $tournament->matches()->orderBy('round')->get();

        return view('tournaments.stats', compact('tournament', 'participants', 'matches'));
    }

    /*** Update match score & advance winner ***/
    public function updateMatchScore(Request $request, Tournament $tournament, TournamentMatch $match)
{
    if (auth()->id() !== $tournament->creator_id && !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized.');
    }

    $request->validate([
        'team_a_score' => 'required|integer|min:0',
        'team_b_score' => 'required|integer|min:0',
    ]);

    $teamAScore = $request->team_a_score;
    $teamBScore = $request->team_b_score;

    // ===== Volleyball scoring rules =====
    if ($teamAScore >= 24 && $teamBScore >= 24) {
        if (abs($teamAScore - $teamBScore) < 2) {
            return back()->with('error', 'Winner must lead by at least 2 points after 24-24.');
        }
    } else {
        $teamAScore = min($teamAScore, 25);
        $teamBScore = min($teamBScore, 25);
    }

    // Determine winner
    $winner = null;
    $winnerName = null;
    if ((($teamAScore >= 25 || $teamBScore >= 25) && abs($teamAScore - $teamBScore) >= 2)) {
        if ($teamAScore > $teamBScore) {
            $winner = 'team_a';
            $winnerName = $match->team_a;
        } else {
            $winner = 'team_b';
            $winnerName = $match->team_b;
        }
    } else {
        return back()->with('error', 'Cannot set a winner until rules are satisfied.');
    }

    $match->update([
        'team_a_score' => $teamAScore,
        'team_b_score' => $teamBScore,
        'winner' => $winner,
    ]);

    // ===== Dynamically generate next round =====
    if ($winnerName) {
        if ($match->next_match_id) {
            $nextMatch = TournamentMatch::find($match->next_match_id);
            if ($nextMatch) {
                // Assign winner to first empty slot
                if ($nextMatch->team_a === 'BYE') {
                    $nextMatch->update(['team_a' => $winnerName]);
                } elseif ($nextMatch->team_b === 'BYE') {
                    $nextMatch->update(['team_b' => $winnerName]);
                }
            }
        } else {
            // No next match exists yet => dynamically create next round
            $currentRound = $match->round;
            $nextRound = $currentRound + 1;

            // Find all winners in the current round without next_match_id
            $roundWinners = TournamentMatch::where('tournament_id', $tournament->id)
                ->where('round', $currentRound)
                ->whereNotNull('winner')
                ->get()
                ->pluck('winner', 'id');

            $winnerNames = [];
            foreach ($roundWinners as $matchId => $w) {
                $winnerNames[] = $w === 'team_a'
                    ? TournamentMatch::find($matchId)->team_a
                    : TournamentMatch::find($matchId)->team_b;
            }

            // Shuffle winners to randomize next round
            shuffle($winnerNames);

            // Pair winners for next round
            for ($i = 0; $i < count($winnerNames); $i += 2) {
                $teamA = $winnerNames[$i];
                $teamB = $winnerNames[$i + 1] ?? 'BYE';

                $newMatch = TournamentMatch::create([
                    'tournament_id' => $tournament->id,
                    'team_a' => $teamA,
                    'team_b' => $teamB,
                    'round' => $nextRound,
                ]);

                // Link previous matches to new match
                if (isset($winnerNames[$i])) {
                    $prevMatch = TournamentMatch::where('tournament_id', $tournament->id)
                        ->where('winner', '!=', null)
                        ->where(function ($q) use ($winnerNames, $i) {
                            $q->where('team_a', $winnerNames[$i])
                              ->orWhere('team_b', $winnerNames[$i]);
                        })->first();
                    if ($prevMatch) $prevMatch->update(['next_match_id' => $newMatch->id]);
                }
                if (isset($winnerNames[$i + 1])) {
                    $prevMatch = TournamentMatch::where('tournament_id', $tournament->id)
                        ->where('winner', '!=', null)
                        ->where(function ($q) use ($winnerNames, $i) {
                            $q->where('team_a', $winnerNames[$i + 1])
                              ->orWhere('team_b', $winnerNames[$i + 1]);
                        })->first();
                    if ($prevMatch) $prevMatch->update(['next_match_id' => $newMatch->id]);
                }
            }
        }
    }

    return back()->with('success', 'Match score updated and next round generated!');
}

    /*** Admin authorization ***/
    private function authorizeAdmin()
    {
        if (!auth()->user()?->isAdmin()) abort(403, 'Unauthorized');
    }

    /*** Tournament validation ***/
    private function validateTournament(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'max_teams' => 'nullable|integer|min:2',
            'team_size' => 'required|integer|min:1',
            'gender_type' => 'required|in:men,women,mix',
            'min_boys' => 'nullable|integer|min:0',
            'min_girls' => 'nullable|integer|min:0',
            'min_age' => 'nullable|integer|min:0',
            'max_age' => 'nullable|integer|min:0',
            'recommendations' => 'nullable|string',
        ];

        if ($request->gender_type === 'mix') {
            $rules['min_boys'] = 'required|integer|min:0|lte:team_size';
            $rules['min_girls'] = 'required|integer|min:0|lte:team_size';
        } else {
            $request->merge(['min_boys' => null, 'min_girls' => null]);
        }

        return Validator::make($request->all(), $rules)
            ->after(function ($validator) use ($request) {
                if ($request->gender_type === 'mix') {
                    $totalMin = ($request->min_boys ?? 0) + ($request->min_girls ?? 0);
                    if ($totalMin > $request->team_size) {
                        $validator->errors()->add('min_boys', 'Sum of boys and girls cannot exceed team size.');
                        $validator->errors()->add('min_girls', 'Sum of boys and girls cannot exceed team size.');
                    }
                }
            })
            ->validate();
    }

    /*** Calendar view ***/
    public function calendar()
    {
        $events = Tournament::all()->map(function ($tournament) {
            return [
                'title' => $tournament->name,
                'start' => $tournament->start_date,
                'end' => $tournament->end_date,
                'url' => route('tournaments.show', $tournament),
                'color' => match ($tournament->gender_type) {
                    'men' => '#3b82f6',
                    'women' => '#ec4899',
                    'mix' => '#f59e0b',
                    default => '#6b7280',
                },
            ];
        })->toArray();

        return view('tournaments.calendar', compact('events'));
    }

    /*** Day-specific tournaments ***/
    public function dayTournaments($date)
    {
        $dateObj = Carbon::parse($date);
        $tournaments = Tournament::whereDate('start_date', '<=', $dateObj)
            ->whereDate('end_date', '>=', $dateObj)
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.day', ['tournaments' => $tournaments, 'date' => $dateObj]);
    }
}
