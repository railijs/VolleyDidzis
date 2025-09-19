<x-app-layout>
<div class="max-w-7xl mx-auto mt-24 mb-12 px-4 sm:px-6 lg:px-8" 
     x-data="tournamentBracket(@json($matches))">

    <!-- Header -->
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">{{ $tournament->name }} – Bracket</h1>
        <p class="text-gray-500">
            {{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }} – 
            {{ \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') }}
        </p>
    </div>

    <!-- Participants -->
    <div class="bg-white border border-gray-200 rounded-xl shadow p-4 mb-8">
        <h2 class="text-lg font-semibold mb-2">👥 Registered Teams</h2>
        @if($participants->count())
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($participants as $participant)
                    <li class="flex justify-between bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        <div>
                            <p class="font-medium">{{ $participant->team_name }}</p>
                            <p class="text-gray-500">Captain: {{ $participant->captain_name }}</p>
                        </div>
                        <span class="italic text-gray-400">{{ $participant->email }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="italic text-gray-500">No teams have applied yet.</p>
        @endif
    </div>

    @if($tournament->status === 'completed')
        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 text-center text-yellow-800 shadow-sm mb-8">
            Tournament completed. Bracket is closed.
        </div>
    @else
        <!-- Bracket -->
        @php
            $rounds = $matches->groupBy('round');
            $totalRounds = $rounds->keys()->max() ?? 1;
        @endphp

        <div class="bg-white border border-gray-200 rounded-xl shadow p-6 mb-8 overflow-x-auto">
            <h2 class="text-lg font-bold text-gray-900 mb-6">🏆 Tournament Bracket</h2>

            <div class="flex items-start gap-12 min-w-max">
                @foreach($rounds as $roundNumber => $roundMatches)
                    @php
                        // Compute base slot height
                        $baseHeight = pow(2, $roundNumber - 1) * 100;
                        // Bigger spacing for first round
                        $slotHeight = ($roundNumber === 1) ? 180 : $baseHeight;
                        $topOffset = ($roundNumber > 1) ? $baseHeight / 2 : 0;
                    @endphp
                    <div class="flex flex-col items-center relative">
                        <div class="text-gray-700 font-semibold mb-4 bg-gray-100 px-4 py-1 rounded">
                            Round {{ $roundNumber }}
                        </div>

                        @foreach($roundMatches as $idx => $match)
                            <div class="relative flex flex-col justify-center items-center"
                                 style="height: {{ $slotHeight }}px; {{ $roundNumber > 1 ? 'margin-top: '.$topOffset.'px;' : '' }}"
                                 :id="'match-'+{{ $match->id }}"
                                 x-data="matchData({{ $match }})"
                                 x-init="initNextMatch()">

                                <!-- Match Card -->
                                <div class="w-56 p-3 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
                                    <!-- Team A -->
                                    <div class="flex justify-between items-center mb-1">
                                        <span :class="winner==='team_a' ? 'bg-green-100 text-green-800' : 'bg-indigo-100 text-indigo-800'" 
                                              class="px-2 py-1 rounded font-bold w-full text-center truncate" 
                                              x-text="team_a"></span>
                                        <span class="ml-2 text-gray-600 font-semibold" x-text="team_a_score || '-'"></span>
                                    </div>
                                    <!-- VS -->
                                    <div class="text-center text-gray-400 font-bold mb-1">VS</div>
                                    <!-- Team B -->
                                    <div class="flex justify-between items-center">
                                        <span :class="winner==='team_b' ? 'bg-green-100 text-green-800' : 'bg-pink-100 text-pink-800'" 
                                              class="px-2 py-1 rounded font-bold w-full text-center truncate" 
                                              x-text="team_b !== 'BYE' ? team_b : '(BYE)'"></span>
                                        <span class="ml-2 text-gray-600 font-semibold" x-text="team_b_score || '-'"></span>
                                    </div>

                                    <!-- Admin update -->
                                    @if(auth()->id() === $tournament->creator_id || auth()->user()->isAdmin())
                                        <form :action="'/tournaments/{{ $tournament->id }}/matches/'+{{ $match->id }}+'/score'" 
                                              method="POST" class="mt-2 flex gap-2 text-sm"
                                              @submit.prevent="updateScore($el)">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="team_a_score" min="0" placeholder="A" class="w-1/2 px-2 py-1 border rounded" x-model="team_a_score">
                                            <input type="number" name="team_b_score" min="0" placeholder="B" class="w-1/2 px-2 py-1 border rounded" x-model="team_b_score">
                                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">Update</button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Connector to next match -->
                                @if($match->next_match_id)
                                    <div class="absolute right-[-3rem] top-1/2 w-12 h-0.5 bg-gray-300"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back -->
    <div class="text-center">
        <a href="{{ route('tournaments.show', $tournament) }}" 
           class="bg-indigo-600 text-white px-5 py-2 rounded-md shadow hover:bg-indigo-700 transition text-sm">
           ← Back to Tournament
        </a>
    </div>
</div>

<script>
function tournamentBracket(matches) {
    return { matches };
}

function matchData(match) {
    return {
        id: match.id,
        team_a: match.team_a,
        team_b: match.team_b,
        team_a_score: match.team_a_score ?? '',
        team_b_score: match.team_b_score ?? '',
        winner: match.winner,
        next_match_id: match.next_match_id,

        initNextMatch() {
            if (this.winner && this.next_match_id) {
                let nextEl = document.getElementById('match-' + this.next_match_id);
                if (!nextEl) return;
                let nextData = nextEl.__x?.$data;
                if (!nextData) {
                    setTimeout(() => this.initNextMatch(), 300);
                    return;
                }
                let nextSlot = nextData.team_a ? 'team_b' : 'team_a';
                nextData[nextSlot] = this.winner === 'team_a' ? this.team_a : this.team_b;
                if (nextData.team_a === 'BYE' || nextData.team_b === 'BYE') {
                    nextData.winner = nextData.team_a === 'BYE' ? 'team_b' : 'team_a';
                    nextData.initNextMatch();
                }
            }
        },

        updateScore(form) {
            this.team_a_score = parseInt(form.team_a_score.value) || 0;
            this.team_b_score = parseInt(form.team_b_score.value) || 0;
            this.winner = this.team_a_score > this.team_b_score ? 'team_a'
                        : this.team_b_score > this.team_a_score ? 'team_b' : '';
            this.initNextMatch();
            form.submit();
        }
    }
}
</script>
</x-app-layout>
