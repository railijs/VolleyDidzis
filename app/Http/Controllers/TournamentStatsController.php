<?php

// app/Http/Controllers/TournamentStatsController.php
namespace App\Http\Controllers;

use App\Models\Tournament;

class TournamentStatsController
{
    public function stats(Tournament $tournament)
    {
        $matches = $tournament->matches()
            ->with(['participantA', 'participantB'])
            ->orderBy('round')->orderBy('index_in_round')->get();

        $participants = $tournament->applications;
        return view('tournaments.stats', compact('tournament', 'participants', 'matches'));
    }
}
