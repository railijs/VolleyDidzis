<?php

// app/Http/Controllers/TournamentProgressController.php
namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Services\BracketBuilder;

class TournamentProgressController extends Controller
{
    public function start(Tournament $tournament, BracketBuilder $builder)
    {
        if (auth()->id() !== $tournament->creator_id && !auth()->user()?->isAdmin()) abort(403);

        try {
            $builder->buildSingleElimination($tournament, randomizeUnseeded: true);
        } catch (\Throwable $e) {
            return back()->with('error', 'Cannot start tournament: ' . $e->getMessage());
        }

        return redirect()->route('tournaments.stats', $tournament)
            ->with('success', 'Turnīrs palaists un tīkls izveidots! 🏐');
    }

    public function stop(Tournament $tournament)
    {
        if (auth()->id() !== $tournament->creator_id && !auth()->user()?->isAdmin()) abort(403);
        if ($tournament->status !== 'active') {
            return back()->with('error', 'Only active tournaments can be stopped.');
        }

        $tournament->update(['status' => 'completed']);
        return redirect()->route('tournaments.show', $tournament)->with('success', 'Turnīrs pabeigts.');
    }
}
