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

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => 'required|string|max:255',
            'max_teams' => 'required|integer|min:2|max:100',
            'team_size' => 'required|integer|min:2|max:9',
            'gender_type' => 'required|in:men,women,mix',
            'min_boys' => 'nullable|integer|min:0',
            'min_girls' => 'nullable|integer|min:0',
            'min_age' => 'nullable|integer|min:0|max:100',
            'max_age' => 'nullable|integer|min:0|max:100',
            'recommendations' => 'nullable|string|max:2000',
        ];

        if ($request->gender_type === 'mix') {
            $rules['min_boys'] = 'required|integer|min:0|lte:team_size';
            $rules['min_girls'] = 'required|integer|min:0|lte:team_size';
        } else {
            $request->merge(['min_boys' => null, 'min_girls' => null]);
        }

        $messages = [
            'name.required' => 'Please give your tournament a name.',
            'name.max' => 'Tournament name can’t be longer than 255 characters.',
            'start_date.required' => 'A start date is required.',
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.after_or_equal' => 'End date must be on or after the start date.',
            'location.required' => 'Please provide a tournament location.',
            'max_teams.required' => 'Please specify the maximum number of teams.',
            'team_size.required' => 'Specify how many players per team.',
            'gender_type.required' => 'Please select a gender type.',
            'min_boys.required' => 'Please enter minimum boys count when mixed.',
            'min_girls.required' => 'Please enter minimum girls count when mixed.',
            'min_age.max' => 'Minimum age cannot exceed 100.',
            'max_age.max' => 'Maximum age cannot exceed 100.',
        ];

        $validated = Validator::make($request->all(), $rules, $messages)
            ->after(function ($validator) use ($request) {
                if ($request->gender_type === 'mix') {
                    $totalMin = ($request->min_boys ?? 0) + ($request->min_girls ?? 0);
                    if ($totalMin > $request->team_size) {
                        $validator->errors()->add('min_boys', 'Boys + Girls cannot exceed total team size.');
                        $validator->errors()->add('min_girls', 'Boys + Girls cannot exceed total team size.');
                    }
                }
                if ($request->min_age && $request->max_age && $request->max_age < $request->min_age) {
                    $validator->errors()->add('max_age', 'Maximum age must be greater than or equal to minimum age.');
                }
            })
            ->validate();

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
            'description' => 'nullable|string|max:2000',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'location' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^(?!\d+$)[a-zA-Z0-9\s,\-]+$/', // NEW: not only numbers
            ],
            'max_teams' => 'required|integer|min:2|max:100',
            'team_size' => 'required|integer|min:4|max:12', // UPDATED: realistic volleyball team sizes
            'gender_type' => 'required|in:men,women,mix',
            'min_boys' => 'nullable|integer|min:0',
            'min_girls' => 'nullable|integer|min:0',
            'min_age' => 'nullable|integer|min:0|max:100',
            'max_age' => 'nullable|integer|min:0|max:100',
            'recommendations' => 'nullable|string|max:2000',
        ];

        if ($request->gender_type === 'mix') {
            $rules['min_boys'] = 'required|integer|min:1|lte:team_size'; // UPDATED: must be at least 1
            $rules['min_girls'] = 'required|integer|min:1|lte:team_size'; // UPDATED: must be at least 1
        } else {
            $request->merge(['min_boys' => null, 'min_girls' => null]);
        }

        $messages = [
            // Name
            'name.required' => 'Please give your tournament a name.',
            'name.string' => 'Tournament name must be text.',
            'name.max' => 'Tournament name can’t be longer than 255 characters.',

            // Description
            'description.string' => 'Description must be text.',
            'description.max' => 'Description cannot exceed 2000 characters.',

            // Start Date
            'start_date.required' => 'A start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'start_date.after_or_equal' => 'The start date must be today or later.',

            // End Date
            'end_date.required' => 'An end date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',

            // Location
            'location.required' => 'Please provide a tournament location.',
            'location.string' => 'Location must be text.',
            'location.min' => 'Location must be at least 3 characters long.',
            'location.regex' => 'Location must look like a real place, not just numbers.',
            'location.max' => 'Location can’t be longer than 255 characters.',

            // Max Teams
            'max_teams.required' => 'Please specify the maximum number of teams.',
            'max_teams.integer' => 'Max teams must be a whole number.',
            'max_teams.min' => 'There must be at least 2 teams.',
            'max_teams.max' => 'Maximum teams cannot exceed 100.',

            // Team Size
            'team_size.required' => 'Specify how many players per team.',
            'team_size.integer' => 'Team size must be a whole number.',
            'team_size.min' => 'A volleyball team must have at least 4 players.',
            'team_size.max' => 'Teams cannot have more than 12 players.',

            // Gender
            'gender_type.required' => 'Please select a gender type.',
            'gender_type.in' => 'Gender type must be men, women, or mixed.',

            // Mix
            'min_boys.required' => 'Please enter minimum boys count when mixed.',
            'min_boys.integer' => 'Minimum boys must be a whole number.',
            'min_boys.min' => 'Mixed tournaments must include at least 1 boy.',
            'min_boys.lte' => 'Minimum boys cannot exceed total team size.',
            'min_girls.required' => 'Please enter minimum girls count when mixed.',
            'min_girls.integer' => 'Minimum girls must be a whole number.',
            'min_girls.min' => 'Mixed tournaments must include at least 1 girl.',
            'min_girls.lte' => 'Minimum girls cannot exceed total team size.',

            // Ages
            'min_age.integer' => 'Minimum age must be a whole number.',
            'min_age.min' => 'Minimum age must be zero or higher.',
            'min_age.max' => 'Minimum age cannot exceed 100 years.',
            'max_age.integer' => 'Maximum age must be a whole number.',
            'max_age.min' => 'Maximum age must be zero or higher.',
            'max_age.max' => 'Maximum age cannot exceed 100 years.',

            // Recommendations
            'recommendations.string' => 'Recommendations must be text.',
            'recommendations.max' => 'Recommendations cannot exceed 2000 characters.',
        ];

        return Validator::make($request->all(), $rules, $messages)
            ->after(function ($validator) use ($request) {
                if ($request->gender_type === 'mix') {
                    $totalMin = ($request->min_boys ?? 0) + ($request->min_girls ?? 0);
                    if ($totalMin > $request->team_size) {
                        $validator->errors()->add('min_boys', 'Boys + Girls cannot be more than total team size.');
                        $validator->errors()->add('min_girls', 'Boys + Girls cannot be more than total team size.');
                    }
                }
                if ($request->min_age && $request->max_age && $request->max_age < $request->min_age) {
                    $validator->errors()->add('max_age', 'Maximum age must be greater than or equal to minimum age.');
                }
            })->validate();
    }
}
