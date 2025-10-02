<?php

// app/Models/TournamentMatch.php
// app/Http/Controllers/TournamentMatchController.php
namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TournamentMatchController extends Controller
{
    public function updateScore(Request $request, Tournament $tournament, TournamentMatch $match)
    {
        if (auth()->id() !== $tournament->creator_id && !auth()->user()?->isAdmin()) abort(403);

        $data = $request->validate([
            'score_a' => ['required', 'integer', 'min:0'],
            'score_b' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($match, $data) {
            $this->recomputeFrom($match->id, (int)$data['score_a'], (int)$data['score_b']);
        });

        return redirect()->route('tournaments.stats', $tournament)->with('success', 'Rezultāts atjaunots.');
    }

    private function recomputeFrom(int $matchId, int $a, int $b): void
    {
        /** @var TournamentMatch $m */
        $m = TournamentMatch::whereKey($matchId)->lockForUpdate()->firstOrFail();

        $updates = ['score_a' => $a, 'score_b' => $b];

        if ($a === $b) {
            // No winner: clear downstream we own
            $updates['winner_slot'] = null;
            $updates['status'] = ($m->participant_a_application_id || $m->participant_b_application_id) ? 'in_progress' : 'pending';
            $this->clearDownstream($m);
            $m->update($updates);
            return;
        }

        $updates['winner_slot'] = $a > $b ? 'A' : 'B';
        $updates['status'] = 'completed';
        $m->update($updates);

        $this->pushForward($m);
    }

    private function clearDownstream(TournamentMatch $m): void
    {
        if (!$m->next_match_id) return;
        $next = TournamentMatch::whereKey($m->next_match_id)->lockForUpdate()->first();
        if (!$next) return;

        $slotField = $m->next_slot === 'A' ? 'participant_a_application_id' : 'participant_b_application_id';

        if ($next->$slotField !== null) {
            $next->update([$slotField => null]);

            if ($next->winner_slot !== null) {
                $next->update([
                    'winner_slot' => null,
                    'status' => ($next->participant_a_application_id || $next->participant_b_application_id) ? 'in_progress' : 'pending'
                ]);
                $this->clearDownstream($next);
            }
        }
    }

    private function pushForward(TournamentMatch $m): void
    {
        if (!$m->next_match_id || !$m->winner_slot) return;

        $winnerId = $m->winner_slot === 'A' ? $m->participant_a_application_id : $m->participant_b_application_id;
        if (!$winnerId) return;

        $next = TournamentMatch::whereKey($m->next_match_id)->lockForUpdate()->first();
        $slotField = $m->next_slot === 'A' ? 'participant_a_application_id' : 'participant_b_application_id';

        $next->update([$slotField => $winnerId]);

        if (($next->participant_a_application_id && !$next->participant_b_application_id) ||
            (!$next->participant_a_application_id && $next->participant_b_application_id)
        ) {
            // Auto advance BYE
            $next->update([
                'winner_slot' => $next->participant_a_application_id ? 'A' : 'B',
                'status'      => 'completed',
                'score_a'     => $next->score_a ?? 0,
                'score_b'     => $next->score_b ?? 0,
            ]);
            $this->pushForward($next);
        } else {
            $next->update(['winner_slot' => null, 'status' => 'in_progress']);
        }
    }
}
