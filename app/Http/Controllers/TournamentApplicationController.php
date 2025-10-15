<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class TournamentApplicationController
{
    public function join(Request $request, Tournament $tournament)
    {
        // Only allow applications while pending
        if ($tournament->status !== 'pending') {
            return back()
                ->withErrors(['team_name' => 'Turnīrs jau ir sācies vai beidzies. Pieteikumi ir slēgti.'])
                ->withInput();
        }

        // Capacity guard
        if (!is_null($tournament->max_teams) && $tournament->applications()->count() >= $tournament->max_teams) {
            return back()
                ->withErrors(['team_name' => 'Turnīrs ir pilns. Pieteikumi slēgti.'])
                ->withInput();
        }

        // Normalize input
        $cleanTeam     = preg_replace('/\s+/', ' ', trim((string) $request->input('team_name')));
        $cleanCaptain  = preg_replace('/\s+/', ' ', trim((string) $request->input('captain_name')));
        $cleanEmail    = preg_replace('/\s+/', '', strtolower((string) $request->input('email')));

        // Unique team name within the tournament
        $teamUnique = Rule::unique('tournament_applications', 'team_name')
            ->where(fn($q) => $q->where('tournament_id', $tournament->id));

        // Validate
        $payload = [
            'team_name'    => $cleanTeam,
            'captain_name' => $cleanCaptain,
            'email'        => $cleanEmail,
        ];

        $validator = Validator::make(
            $payload,
            [
                'team_name'    => ['required', 'string', 'max:255', 'regex:/^(?!\d+$).+$/', $teamUnique],
                'captain_name' => ['required', 'string', 'max:255'],
                'email'        => ['required', 'email', 'max:255'], // email back, not unique
            ],
            [
                'team_name.required'    => 'Lūdzu ievadi komandas nosaukumu.',
                'team_name.max'         => 'Komandas nosaukums nedrīkst pārsniegt 255 rakstzīmes.',
                'team_name.regex'       => 'Komandas nosaukums nevar būt tikai cipari.',
                'team_name.unique'      => 'Šāds komandas nosaukums jau ir pieteikts šajā turnīrā.',
                'captain_name.required' => 'Lūdzu ievadi kapteiņa vārdu.',
                'email.required'        => 'Lūdzu ievadi e-pastu.',
                'email.email'           => 'Ievadi derīgu e-pastu.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput([
                    'team_name'    => $request->input('team_name'),
                    'captain_name' => $request->input('captain_name'),
                    'email'        => $request->input('email'),
                ]);
        }

        // Create the application (users can apply multiple times)
        $tournament->applications()->create([
            'team_name'    => $cleanTeam,
            'captain_name' => $cleanCaptain,
            'email'        => $cleanEmail,
            'user_id'      => auth()->id(),
        ]);

        return back()->with('success', 'Pieteikums veiksmīgi iesniegts!');
    }

    public function destroy(Request $request, Tournament $tournament, TournamentApplication $application)
    {
        // Only pending tournaments can accept withdrawals
        if ($tournament->status !== 'pending') {
            return back()->withErrors(['withdraw' => 'Pieteikumu vairs nevar atsaukt, jo turnīrs nav gaidīšanas režīmā.']);
        }

        // Make sure the application belongs to this tournament
        if ((int) $application->tournament_id !== (int) $tournament->id) {
            abort(404);
        }

        // Only the owner or an admin can delete
        $user = auth()->user();
        $isOwner = $application->user_id === $user->id;
        $isAdmin = method_exists($user, 'isAdmin') && $user->isAdmin();

        if (!$isOwner && !$isAdmin) {
            abort(403);
        }

        $application->delete();

        return back()->with('success', 'Pieteikums veiksmīgi atsaukts.');
    }
}
