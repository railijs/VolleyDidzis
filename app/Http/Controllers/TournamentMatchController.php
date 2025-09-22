<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;

class TournamentMatchController extends Controller
{
    public function updateScore(Request $request, Tournament $tournament, TournamentMatch $match)
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

        // Volleyball scoring rules
        if ($teamAScore >= 24 && $teamBScore >= 24 && abs($teamAScore - $teamBScore) < 2) {
            return back()->with('error', 'Winner must lead by at least 2 points after 24-24.');
        }

        $teamAScore = min($teamAScore, 25);
        $teamBScore = min($teamBScore, 25);

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

        // Assign winner to next round
        if ($winnerName && $match->next_match_id) {
            $nextMatch = TournamentMatch::find($match->next_match_id);
            if ($nextMatch) {
                if ($nextMatch->team_a === 'BYE') $nextMatch->update(['team_a' => $winnerName]);
                elseif ($nextMatch->team_b === 'BYE') $nextMatch->update(['team_b' => $winnerName]);
            }
        }

        return back()->with('success', 'Match score updated and next round generated!');
    }
}
