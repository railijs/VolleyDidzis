<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;

class TournamentProgressController extends Controller
{
    public function start(Tournament $tournament)
    {
        if (auth()->id() !== $tournament->creator_id && !auth()->user()->isAdmin()) abort(403);

        if ($tournament->status !== 'pending') {
            return back()->with('error', 'Tournament cannot be started.');
        }

        $tournament->update(['status' => 'active']);
        $participants = $tournament->applications()->inRandomOrder()->get();
        $participantsCount = $participants->count();

        $matches = [];
        for ($i = 0; $i < $participantsCount; $i += 2) {
            $teamA = $participants[$i]->team_name;
            $teamB = $participants[$i + 1]->team_name ?? 'BYE';

            $matches[] = TournamentMatch::create([
                'tournament_id' => $tournament->id,
                'team_a' => $teamA,
                'team_b' => $teamB,
                'round' => 1,
            ]);
        }

        // Ensure at least 1 round; use log base 2 safely
        $totalRounds = max(1, (int) ceil(log(max(1, $participantsCount), 2)));
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

            foreach ($previousRoundMatches as $idx => $match) {
                $nextMatchIdx = (int) floor($idx / 2);
                $match->update(['next_match_id' => $newRoundMatches[$nextMatchIdx]->id]);
            }

            $previousRoundMatches = $newRoundMatches;
        }

        return redirect()->route('tournaments.stats', $tournament)
            ->with('success', 'Tournament started and bracket generated!');
    }

    public function stop(Tournament $tournament)
    {
        if (auth()->id() !== $tournament->creator_id && !auth()->user()->isAdmin()) abort(403);

        if ($tournament->status !== 'active') {
            return back()->with('error', 'Only active tournaments can be stopped.');
        }

        $tournament->update(['status' => 'completed']);
        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Tournament has been stopped.');
    }
}
