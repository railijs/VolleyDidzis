<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentApplicationController extends Controller
{
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
}
