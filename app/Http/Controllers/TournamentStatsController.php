<?php

namespace App\Http\Controllers;

use App\Models\Tournament;

class TournamentStatsController
{
    public function stats(Tournament $tournament)
    {
        $participants = $tournament->applications;
        $matches = $tournament->matches()->orderBy('round')->get();

        return view('tournaments.stats', compact('tournament', 'participants', 'matches'));
    }
}
