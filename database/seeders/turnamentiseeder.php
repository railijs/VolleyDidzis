<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tournament;
use App\Models\TournamentApplication;
use App\Models\TournamentMatch;
use App\Services\BracketBuilder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TournamentSeeder extends Seeder
{
    public function run(): void
    {
        // Add/adjust as you like. Different sizes test odd and power-of-two brackets.
        $configs = [
            ['name' => 'Rīgas Kauss — Pludmales Volejbols', 'location' => 'Rīga, LV',      'teams' => 12],
            ['name' => 'Liepājas Pludmales Kauss',          'location' => 'Liepāja, LV',   'teams' => 10],
            ['name' => 'Jūrmalas Smiltis Open',             'location' => 'Jūrmala, LV',   'teams' => 16],
            ['name' => 'Ventspils Surf Volley',             'location' => 'Ventspils, LV', 'teams' => 14],
            ['name' => 'Daugavpils Daugavas Kauss',         'location' => 'Daugavpils, LV', 'teams' => 8],
            ['name' => 'Valmieras Meža Kauss',              'location' => 'Valmiera, LV',  'teams' => 12],
        ];

        foreach ($configs as $cfg) {
            DB::transaction(function () use ($cfg) {
                $this->seedAndFinishTournament($cfg['name'], $cfg['location'], (int)$cfg['teams']);
            });
        }
    }

    private function seedAndFinishTournament(string $title, string $location, int $teamCount): void
    {
        // --- Ensure a creator user exists
        $creator = User::first() ?? User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // --- One-day tournament next week
        $start = Carbon::today()->addWeek();
        $end   = $start;

        $tournament = Tournament::create([
            'name'            => $title,
            'description'     => 'Demo turnīrs ar ģenerētu tīklāju, latviskām komandām un rezultātiem.',
            'start_date'      => $start->toDateString(),
            'end_date'        => $end->toDateString(),
            'location'        => $location,
            'max_teams'       => max(8, $teamCount),
            'team_size'       => 6,
            'gender_type'     => 'mix',
            'min_boys'        => 1,
            'min_girls'       => 1,
            'min_age'         => null,
            'max_age'         => null,
            'recommendations' => 'Ierašanās 30 min pirms pirmās spēles.',
            'status'          => 'pending', // MUST be pending before building the bracket
            'winner'          => null,
            'creator_id'      => $creator->id,
        ]);

        // --- Build a pool of Latvian team names and captains
        [$teamNames, $captains] = $this->latvianTeamsAndCaptains($teamCount);

        // Seed top-4 as seeded (if enough teams), rest unseeded
        $seededCount = min(4, $teamCount);
        for ($i = 0; $i < $teamCount; $i++) {
            $team = $teamNames[$i];
            $captain = $captains[$i];

            // Unique email per team via team slug (handles diacritics)
            $email = Str::slug($team) . '@teams.local';

            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $captain, 'password' => bcrypt('password')]
            );

            TournamentApplication::create([
                'tournament_id' => $tournament->id,
                'user_id'       => $user->id,
                'team_name'     => $team,
                'captain_name'  => $captain,
                'email'         => $email,
                'seed'          => $i < $seededCount ? ($i + 1) : null,
            ]);
        }

        // --- Build bracket (BracketBuilder flips status -> active)
        app(BracketBuilder::class)->buildSingleElimination($tournament, true);

        // --- Simulate all rounds to final
        $scoreGen = function (?bool $aFav): array {
            if ($aFav === null) $aFav = (bool) random_int(0, 1);
            $w = random_int(25, 30);
            $l = max(18, $w - 2);
            return $aFav ? [$w, $l] : [$l, $w];
        };

        // Iterate over existing round numbers ascending (works with/without round 0)
        $rounds = TournamentMatch::where('tournament_id', $tournament->id)
            ->select('round')->distinct()->orderBy('round')->pluck('round');

        foreach ($rounds as $r) {
            $roundMatches = TournamentMatch::where('tournament_id', $tournament->id)
                ->where('round', $r)
                ->orderBy('index_in_round')
                ->get();

            foreach ($roundMatches as $m) {
                $m->refresh(); // pick up any newly advanced participants

                $aId = $m->participant_a_application_id;
                $bId = $m->participant_b_application_id;

                // Handle empty shells / byes / normal matches
                if (!$aId && !$bId) {
                    $m->status = 'completed';
                    $m->winner_slot = null;
                    $m->score_a = null;
                    $m->score_b = null;
                    $m->save();
                    continue;
                }

                $aFav = null;
                if ($aId && !$bId) {
                    [$sa, $sb] = [25, 0];
                    $winnerSlot = 'A';
                } elseif (!$aId && $bId) {
                    [$sa, $sb] = [0, 25];
                    $winnerSlot = 'B';
                } else {
                    $aSeed = $aId ? optional(TournamentApplication::find($aId))->seed : null;
                    $bSeed = $bId ? optional(TournamentApplication::find($bId))->seed : null;
                    if ($aSeed !== null && $bSeed !== null) {
                        // lower seed number is stronger
                        $aFav = ($aSeed < $bSeed) ? (random_int(1, 100) <= 70) : (random_int(1, 100) <= 30);
                    }
                    [$sa, $sb] = $scoreGen($aFav);
                    $winnerSlot = ($sa > $sb) ? 'A' : 'B';
                }

                // Save result
                $m->score_a = $sa;
                $m->score_b = $sb;
                $m->winner_slot = $winnerSlot;
                $m->status = 'completed';
                $m->save();

                // Advance winner to the next match
                if ($m->next_match_id) {
                    $winnerAppId = $winnerSlot === 'A' ? $aId : $bId;
                    if ($winnerAppId) {
                        $next = TournamentMatch::find($m->next_match_id);
                        if ($next) {
                            if ($m->next_slot === 'A' && !$next->participant_a_application_id) {
                                $next->participant_a_application_id = $winnerAppId;
                            }
                            if ($m->next_slot === 'B' && !$next->participant_b_application_id) {
                                $next->participant_b_application_id = $winnerAppId;
                            }
                            if (
                                $next->status === 'pending' &&
                                ($next->participant_a_application_id || $next->participant_b_application_id)
                            ) {
                                $next->status = 'in_progress';
                            }
                            $next->save();
                        }
                    }
                }
            }
        }

        // --- Close tournament & store champion name
        $final = TournamentMatch::where('tournament_id', $tournament->id)
            ->orderByDesc('round')->first();

        $champion = $final?->winnerApplication()?->team_name;

        $tournament->update([
            'status' => 'completed',
            'winner' => $champion,
        ]);
    }

    /**
     * Returns [array $teamNames, array $captainNames] in Latvian, count = $n, all unique per tournament.
     */
    private function latvianTeamsAndCaptains(int $n): array
    {
        $cities = [
            'Rīgas',
            'Liepājas',
            'Jūrmalas',
            'Ventspils',
            'Daugavpils',
            'Valmieras',
            'Jelgavas',
            'Cēsu',
            'Ogres',
            'Siguldas',
            'Rēzeknes',
            'Kuldīgas',
            'Talsu',
            'Tukuma',
            'Salaspils',
        ];
        $mascots = [
            'Lūši',
            'Vilki',
            'Lāči',
            'Vanagi',
            'Stārķi',
            'Bebri',
            'Zalkši',
            'Ozoli',
            'Kaijas',
            'Smiltis',
            'Viļņi',
            'Zirgi',
            'Pūces',
            'Spāres',
            'Jūras Lauvas',
            'Mežsargi',
            'Zvejnieki',
            'Kalēji',
        ];

        $firstNames = ['Jānis', 'Mārtiņš', 'Rihards', 'Edgars', 'Andris', 'Roberts', 'Artūrs', 'Ralfs', 'Gustavs', 'Kristers', 'Dāvis', 'Toms', 'Raitis', 'Valters', 'Sandis', 'Ilvars'];
        $surnames   = ['Ozoliņš', 'Kalniņš', 'Bērziņš', 'Zariņš', 'Liepiņš', 'Krauklis', 'Balodis', 'Eglītis', 'Lācis', 'Vilks', 'Dombrovskis', 'Āboliņš', 'Riekstiņš', 'Viļums', 'Grīnbergs'];

        $teams = [];
        $caps  = [];

        // Keep generating unique "City Mascot" combinations
        while (count($teams) < $n) {
            $team = $cities[array_rand($cities)] . ' ' . $mascots[array_rand($mascots)];
            if (!in_array($team, $teams, true)) {
                $teams[] = $team;

                $cap = $firstNames[array_rand($firstNames)] . ' ' . $surnames[array_rand($surnames)];
                // avoid duplicate captain names in the same tournament (not essential, but nice)
                while (in_array($cap, $caps, true)) {
                    $cap = $firstNames[array_rand($firstNames)] . ' ' . $surnames[array_rand($surnames)];
                }
                $caps[] = $cap;
            }
        }
        return [$teams, $caps];
    }
}
