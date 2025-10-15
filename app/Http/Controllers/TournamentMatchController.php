<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TournamentMatchController extends Controller
{
    /** Max atļautais ievades punkts skaitlis formā (UI limitam) */
    public const MAX_POINTS = 50;

    public function updateScore(Request $request, Tournament $tournament, TournamentMatch $match)
    {
        // 1) Block edits unless ACTIVE
        if ($tournament->status !== 'active') {
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'message' => 'Turnīrs ir pabeigts — rezultātus vairs nevar mainīt.'], 422);
            }
            return back()->withErrors(['general' => 'Turnīrs ir pabeigts — rezultātus vairs nevar mainīt.']);
        }

        // Only creator/admin
        if (! (auth()->id() === $tournament->creator_id || auth()->user()?->isAdmin())) {
            abort(403);
        }

        // 2) Validation
        $v = Validator::make(
            $request->all(),
            [
                'score_a' => ['required', 'integer', 'min:0', 'max:' . self::MAX_POINTS],
                'score_b' => ['required', 'integer', 'min:0', 'max:' . self::MAX_POINTS],
            ],
            [
                'score_a.required' => 'Ievadi A punktus.',
                'score_b.required' => 'Ievadi B punktus.',
                'score_a.integer'  => 'Punktiem jābūt veselam skaitlim.',
                'score_b.integer'  => 'Punktiem jābūt veselam skaitlim.',
                'score_a.min'      => 'Punkti nevar būt negatīvi.',
                'score_b.min'      => 'Punkti nevar būt negatīvi.',
                'score_a.max'      => 'Punkti nedrīkst pārsniegt ' . self::MAX_POINTS . '.',
                'score_b.max'      => 'Punkti nedrīkst pārsniegt ' . self::MAX_POINTS . '.',
            ]
        );

        // 3) Volleyball rules
        $v->after(function ($validator) use ($request) {
            $a = (int) $request->input('score_a');
            $b = (int) $request->input('score_b');

            $winner = max($a, $b);
            $loser  = min($a, $b);
            $diff   = $winner - $loser;

            if ($winner < 25) {
                $msg = 'Setu nevar pabeigt zem 25 punktiem.';
                $validator->errors()->add('score_a', $msg);
                $validator->errors()->add('score_b', $msg);
                return;
            }

            if ($winner === 25) {
                if ($diff < 2) {
                    $msg = 'Pie 25 punktiem uzvarētājam jābūt vismaz +2.';
                    $validator->errors()->add('score_a', $msg);
                    $validator->errors()->add('score_b', $msg);
                }
                return;
            }

            if ($winner > 25) {
                if ($diff !== 2 || $loser < 24) {
                    $msg = 'Pēc 24–24 spēle turpinās līdz +2 (26–24, 27–25, …).';
                    $validator->errors()->add('score_a', $msg);
                    $validator->errors()->add('score_b', $msg);
                }
            }
        });

        if ($v->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['ok' => false, 'errors' => $v->errors()], 422);
            }
            return back()->withErrors($v)->withInput();
        }

        $data = $v->validated();

        // 4) Save & collect all affected matches for live re-render
        $touchedIds = [];
        $finalSummary = null;

        DB::transaction(function () use ($match, $data, $tournament, &$touchedIds, &$finalSummary) {
            $this->recomputeFrom($match->id, (int) $data['score_a'], (int) $data['score_b'], $touchedIds);

            // reload affected
            $affected = TournamentMatch::with(['participantA', 'participantB'])
                ->whereIn('id', $touchedIds ?: [$match->id])
                ->get();

            // pack for response
            $touchedIds = $affected->map(function ($m) {
                return [
                    'id'          => $m->id,
                    'winner_slot' => $m->winner_slot,
                    'status'      => $m->status,
                    'score_a'     => $m->score_a,
                    'score_b'     => $m->score_b,
                    'a_id'        => $m->participant_a_application_id,
                    'b_id'        => $m->participant_b_application_id,
                    'a_name'      => $m->participantA?->team_name,
                    'b_name'      => $m->participantB?->team_name,
                    'next_match_id' => $m->next_match_id,
                ];
            })->values()->all();

            // final summary (for header auto-update)
            $final = TournamentMatch::where('tournament_id', $tournament->id)
                ->orderByDesc('round')->orderBy('index_in_round')->with(['participantA', 'participantB'])->first();

            if ($final) {
                $finalSummary = [
                    'has'          => true,
                    'a_name'       => $final->participantA?->team_name,
                    'b_name'       => $final->participantB?->team_name,
                    'a_score'      => $final->score_a,
                    'b_score'      => $final->score_b,
                    'winner_slot'  => $final->winner_slot,
                    'winner_name'  => $final->winnerApplication()?->team_name,
                    'completed'    => ($final->status === 'completed' && $final->winner_slot !== null),
                ];
            } else {
                $finalSummary = ['has' => false];
            }
        });

        // 5) JSON / fallback
        if ($request->expectsJson()) {
            return response()->json([
                'ok'      => true,
                'matches' => $touchedIds,
                'final'   => $finalSummary,
            ]);
        }

        return back()->with('success', 'Rezultāts atjaunots.');
    }

    /** Uzliek rezultātu konkrētam mačam un pārpošojas koku; savāc skartos ID */
    private function recomputeFrom(int $matchId, int $a, int $b, array &$touch): void
    {
        /** @var TournamentMatch $m */
        $m = TournamentMatch::whereKey($matchId)->lockForUpdate()->firstOrFail();

        $updates = ['score_a' => $a, 'score_b' => $b];

        if ($a === $b) {
            $updates['winner_slot'] = null;
            $updates['status'] = ($m->participant_a_application_id || $m->participant_b_application_id)
                ? 'in_progress'
                : 'pending';
            $m->update($updates);
            $touch[] = $m->id;
            $this->clearDownstream($m, $touch);
            return;
        }

        $updates['winner_slot'] = $a > $b ? 'A' : 'B';
        $updates['status'] = 'completed';
        $m->update($updates);
        $touch[] = $m->id;

        $this->pushForward($m, $touch);
    }

    /** Notīra nākamo maču no šī mača “ieguldījuma” un, ja vajag, kaskadē tālāk */
    private function clearDownstream(TournamentMatch $m, array &$touch): void
    {
        if (! $m->next_match_id) return;

        $next = TournamentMatch::whereKey($m->next_match_id)->lockForUpdate()->first();
        if (! $next) return;

        $slotField = $m->next_slot === 'A' ? 'participant_a_application_id' : 'participant_b_application_id';

        if ($next->$slotField !== null) {
            $next->update([$slotField => null]);

            if ($next->winner_slot !== null) {
                $next->update([
                    'winner_slot' => null,
                    'status' => ($next->participant_a_application_id || $next->participant_b_application_id)
                        ? 'in_progress'
                        : 'pending',
                ]);
            }
            $touch[] = $next->id;
            $this->clearDownstream($next, $touch);
        }
    }

    /**
     * Pārnes uzvarētāju uz nākamo maču.
     * Nekad neatzīmējam nākamo kā “completed”, ja tajā ir tikai viena komanda.
     */
    private function pushForward(TournamentMatch $m, array &$touch): void
    {
        if (! $m->next_match_id || ! $m->winner_slot) return;

        $winnerId = $m->winner_slot === 'A' ? $m->participant_a_application_id : $m->participant_b_application_id;
        if (! $winnerId) return;

        $next = TournamentMatch::whereKey($m->next_match_id)->lockForUpdate()->first();
        if (! $next) return;

        $slotField = $m->next_slot === 'A' ? 'participant_a_application_id' : 'participant_b_application_id';
        $next->update([$slotField => $winnerId]);

        $hasA = (bool) $next->participant_a_application_id;
        $hasB = (bool) $next->participant_b_application_id;

        $next->update([
            'winner_slot' => null,
            'status'      => 'in_progress',
        ]);

        $touch[] = $next->id;

        // Do NOT auto-complete if only one side present
        if ($hasA && $hasB) {
            // nothing else to do here; winner decided when that match is played
        }
    }
}
