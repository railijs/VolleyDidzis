<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class TournamentController extends Controller
{
    // List upcoming tournaments
    public function index()
    {
        $tournaments = Tournament::where('start_date', '>=', Carbon::today())
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.index', compact('tournaments'));
    }

    // Show single tournament
    public function show(Tournament $tournament)
    {
        return view('tournaments.show', compact('tournament'));
    }

    // Admin: create tournament form
    public function create()
    {
        $this->authorizeAdmin();
        return view('tournaments.create');
    }

    // Admin: store tournament
    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $validated = $this->validateTournament($request);

        $tournament = Tournament::create(array_merge($validated, [
            'creator_id' => auth()->id(),
        ]));

        return redirect()->route('dashboard')->with('success', 'Tournament successfully created!');
    }

    // Admin: edit tournament form
    public function edit(Tournament $tournament)
    {
        $this->authorizeAdmin();
        return view('tournaments.edit', compact('tournament'));
    }

    // Admin: update tournament
    public function update(Request $request, Tournament $tournament)
    {
        $this->authorizeAdmin();
        $validated = $this->validateTournament($request);

        $tournament->update($validated);

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Tournament updated successfully!');
    }

    // Admin: delete tournament
    public function destroy(Tournament $tournament)
    {
        $this->authorizeAdmin();
        $tournament->delete();

        return redirect()->route('dashboard')->with('success', 'Tournament deleted.');
    }

    // Calendar view
    public function calendar()
    {
        $events = Tournament::all()->map(function ($t) {
            return [
                'title' => $t->name,
                'start' => $t->start_date,
                'end' => $t->end_date,
                'url' => route('tournaments.show', $t),
                'color' => match ($t->gender_type) {
                    'men' => '#3b82f6',
                    'women' => '#ec4899',
                    'mix' => '#f59e0b',
                    default => '#6b7280',
                },
            ];
        })->toArray();

        return view('tournaments.calendar', compact('events'));
    }

    // Day-specific tournaments
    public function dayTournaments($date)
    {
        $dateObj = Carbon::parse($date);
        $tournaments = Tournament::whereDate('start_date', '<=', $dateObj)
            ->whereDate('end_date', '>=', $dateObj)
            ->orderBy('start_date', 'asc')
            ->get();

        return view('tournaments.day', ['tournaments' => $tournaments, 'date' => $dateObj]);
    }

    // === Helpers ===
    private function authorizeAdmin()
    {
        if (!auth()->user()?->isAdmin()) abort(403, 'Unauthorized');
    }

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
            })->validate();
    }
}
