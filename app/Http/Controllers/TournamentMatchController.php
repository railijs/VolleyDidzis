<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;

class TournamentMatchController extends Controller
{
    public function updateScore(Request $request, Tournament $tournament, TournamentMatch $match)
    {
        // Authz: creator or admin can update
        if (auth()->id() !== $tournament->creator_id && !(auth()->user() && auth()->user()->isAdmin())) {
            abort(403);
        }

        // Basic validation
        $data = $request->validate([
            'team_a_score' => ['required', 'integer', 'min:0'],
            'team_b_score' => ['required', 'integer', 'min:0'],
        ]);

        $a = (int) $data['team_a_score'];
        $b = (int) $data['team_b_score'];

        $winner = null;
        if ($a > $b) $winner = 'team_a';
        if ($b > $a) $winner = 'team_b';

        // Update current match
        $match->update([
            'team_a_score' => $a,
            'team_b_score' => $b,
            'winner'       => $winner,
        ]);

        // Propagate to next match if we have a winner
        if ($winner && $match->next_match_id) {
            $next = TournamentMatch::find($match->next_match_id);
            if ($next) {
                $winnerName = $winner === 'team_a' ? $match->team_a : $match->team_b;

                // Choose the slot in the next match
                $slot = (empty($next->team_a) || $next->team_a === 'BYE') ? 'team_a' : 'team_b';

                // If changing results later, we simply overwrite the slot we control
                $next->update([
                    $slot => $winnerName ?: 'BYE',
                ]);

                // Auto-advance BYE if applicable
                $resolvedWinner = null;
                if (($next->team_a === 'BYE' && $next->team_b && $next->team_b !== 'BYE') ||
                    ($next->team_b === 'BYE' && $next->team_a && $next->team_a !== 'BYE')
                ) {
                    $resolvedWinner = $next->team_a === 'BYE' ? 'team_b' : 'team_a';
                }

                if ($resolvedWinner) {
                    $next->update([
                        'winner' => $resolvedWinner,
                        'team_a_score' => $next->team_a === 'BYE' ? 0 : ($next->team_a_score ?? 0),
                        'team_b_score' => $next->team_b === 'BYE' ? 0 : ($next->team_b_score ?? 0),
                    ]);

                    // One-step propagate BYE advancement
                    if ($next->next_match_id) {
                        $afterNext = TournamentMatch::find($next->next_match_id);
                        if ($afterNext) {
                            $winnerName2 = $resolvedWinner === 'team_a' ? $next->team_a : $next->team_b;
                            $slot2 = (empty($afterNext->team_a) || $afterNext->team_a === 'BYE') ? 'team_a' : 'team_b';
                            $afterNext->update([$slot2 => $winnerName2 ?: 'BYE']);
                        }
                    }
                } else {
                    // Clear prior automatic winner if now both teams are present and equal scores
                    if ($next->team_a && $next->team_b && $next->team_a !== 'BYE' && $next->team_b !== 'BYE') {
                        $next->update(['winner' => null]);
                    }
                }
            }
        }

        return redirect()
            ->route('tournaments.stats', $tournament)
            ->with('success', 'Score updated.');
    }
}
