<x-app-layout>
    <div class="max-w-full mx-auto mt-16 px-4 sm:px-6 lg:px-8" x-data="tournamentBracket(@json($matches))">

        <!-- Header -->
        <header class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-indigo-900">{{ $tournament->name }} – Bracket</h1>
            <p class="text-indigo-600">
                {{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }} –
                {{ \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') }}
            </p>
        </header>

        <!-- Start Tournament Button -->
        @if (
            $tournament->status === 'pending' &&
                (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin())))
            <div class="mb-4 text-center">
                <form action="{{ route('tournaments.start', $tournament) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow transition text-sm sm:text-base">
                        Start Tournament
                    </button>
                </form>
            </div>
        @endif

        <!-- Stop Tournament Button -->
        @if (
            $tournament->status === 'active' &&
                (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin())))
            <div class="mb-8 text-center">
                <form action="{{ route('tournaments.stop', $tournament) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow transition text-sm sm:text-base">
                        Stop Tournament
                    </button>
                </form>
            </div>
        @endif

        @php
            $rounds = $matches->groupBy('round');
            $finalRound = $rounds->keys()->max();
        @endphp

        <!-- Bracket Grid -->
        <div class="overflow-x-auto">
            <div class="grid grid-flow-col auto-cols-max gap-16 justify-center">
                @foreach ($rounds as $roundNumber => $roundMatches)
                    <div class="flex flex-col justify-center items-center gap-6">

                        <!-- Round Label -->
                        <div class="mb-4 text-indigo-800 font-semibold bg-indigo-100 px-4 py-1 rounded-full">
                            Round {{ $roundNumber }}
                        </div>

                        <!-- Matches -->
                        @foreach ($roundMatches as $match)
                            <div class="relative flex flex-col items-center group" :id="'match-' + {{ $match->id }}"
                                x-data="matchData({{ $match }}, {{ $roundNumber }}, {{ $finalRound }}, $root)" x-init="initNextMatch()">

                                <!-- Match Card -->
                                <div
                                    class="w-56 bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition relative z-10">
                                    <div class="flex justify-between items-center px-3 py-2 border-b"
                                        :class="{ 'bg-green-50 font-bold': winner === 'team_a' }">
                                        <span class="truncate text-gray-800" x-text="team_a"></span>
                                        <span class="font-bold text-gray-600" x-text="team_a_score || '-'"></span>
                                    </div>
                                    <div class="flex justify-between items-center px-3 py-2"
                                        :class="{ 'bg-green-50 font-bold': winner === 'team_b' }">
                                        <span class="truncate text-gray-800" x-text="team_b"></span>
                                        <span class="font-bold text-gray-600" x-text="team_b_score || '-'"></span>
                                    </div>

                                    <!-- Admin Score Update -->
                                    @if (auth()->id() === $tournament->creator_id || auth()->user()->isAdmin())
                                        <form
                                            :action="'/tournaments/{{ $tournament->id }}/matches/' + {{ $match->id }} +
                                                '/score'"
                                            method="POST" class="flex gap-2 p-3 border-t text-sm"
                                            @submit.prevent="updateScore($el)">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="team_a_score" min="0" placeholder="A"
                                                class="w-1/2 px-2 py-1 border rounded" x-model="team_a_score">
                                            <input type="number" name="team_b_score" min="0" placeholder="B"
                                                class="w-1/2 px-2 py-1 border rounded" x-model="team_b_score">
                                            <button type="submit"
                                                class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                                                ✔
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Simple Connector -->
                                @if ($match->next_match_id)
                                    <div class="absolute right-[-2rem] top-1/2 w-8 border-t-2 border-gray-300"></div>
                                @endif
                            </div>
                        @endforeach

                        <!-- Winner Card (final round) -->
                        <template x-if="tournamentWinner && {{ $roundNumber }} === {{ $finalRound }}">
                            <div
                                class="mt-6 w-56 bg-yellow-100 border border-yellow-300 rounded-lg shadow p-3 text-center text-yellow-800 font-bold">
                                🏆 Champion: <span x-text="tournamentWinner"></span>
                            </div>
                        </template>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function tournamentBracket(matches) {
            return {
                matches,
                tournamentWinner: '', // reactive winner
            };
        }

        function matchData(match, roundNumber, finalRound, root) {
            return {
                id: match.id,
                team_a: match.team_a,
                team_b: match.team_b,
                team_a_score: match.team_a_score ?? '',
                team_b_score: match.team_b_score ?? '',
                winner: match.winner,
                next_match_id: match.next_match_id,
                root, // reference to parent

                initNextMatch() {
                    if (this.winner && this.next_match_id) {
                        const nextEl = document.getElementById('match-' + this.next_match_id);
                        if (!nextEl) return;

                        const nextData = nextEl.__x?.$data;
                        if (!nextData) {
                            setTimeout(() => this.initNextMatch(), 300);
                            return;
                        }

                        // Determine next slot
                        let nextSlot = !nextData.team_a || nextData.team_a === 'BYE' ? 'team_a' : 'team_b';
                        nextData[nextSlot] = this.winner === 'team_a' ? this.team_a : this.team_b;

                        // Auto-win if BYE
                        if (nextData.team_a === 'BYE' || nextData.team_b === 'BYE') {
                            nextData.winner = nextData.team_a === 'BYE' ? 'team_b' : 'team_a';
                            nextData.initNextMatch();
                        }
                    }

                    // Set tournament winner if final round match
                    if (roundNumber === finalRound && this.winner) {
                        this.root.tournamentWinner = this.winner === 'team_a' ? this.team_a : this.team_b;
                    }
                },

                updateScore(form) {
                    this.team_a_score = parseInt(form.team_a_score.value) || 0;
                    this.team_b_score = parseInt(form.team_b_score.value) || 0;
                    this.winner = this.team_a_score > this.team_b_score ? 'team_a' :
                        this.team_b_score > this.team_a_score ? 'team_b' : '';
                    this.initNextMatch();
                    form.submit();
                }
            }
        }
    </script>
</x-app-layout>
