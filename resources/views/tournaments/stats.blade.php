<x-app-layout>
    {{-- winner event listener is attached via x-on:champion.window on the root div below --}}

    @php
        // Precompute to keep x-data simple and avoid nested ternaries
        $rounds = $matches->groupBy('round');
        $finalRound = $rounds->keys()->max();
        $finalMatch = $matches->where('round', $finalRound)->first();
        $serverWinner = null;
        if ($finalMatch && $finalMatch->winner) {
            $serverWinner = $finalMatch->winner === 'team_a' ? $finalMatch->team_a : $finalMatch->team_b;
        }
        $participantsCount = $tournament->applications()->count();
        $matchCount = $matches->count();
    @endphp

    <div class="max-w-full mx-auto mt-16 px-4 sm:px-6 lg:px-8" x-data="tournamentBracket(@json($matches), @json($serverWinner))"
        x-on:champion.window="tournamentWinner = $event.detail" x-cloak>
        <!-- ===== Header (Tailwind-only glossy red) ===== -->
        <header class="mb-8">
            <div
                class="relative overflow-hidden rounded-2xl text-white shadow-[0_20px_40px_rgba(185,28,28,0.18)] ring-1 ring-white/20 bg-gradient-to-br from-red-600 via-red-500 to-red-700">
                <!-- soft specular highlights (no pseudo-elements) -->
                <div
                    class="pointer-events-none absolute -top-1/3 -left-1/6 w-3/5 h-[140%] rounded-full blur-2xl opacity-40 bg-white/30 rotate-[-8deg]">
                </div>
                <div
                    class="pointer-events-none absolute -bottom-1/4 -right-1/12 w-2/5 h-[120%] rounded-full blur-2xl opacity-30 bg-white/20 rotate-[12deg]">
                </div>

                <div class="relative grid gap-2 p-5 sm:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black tracking-tight drop-shadow-sm">
                                {{ $tournament->name }} – Bracket</h1>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <div
                                    class="inline-flex items-center gap-2 text-red-100 font-bold text-[0.9rem] rounded-full border border-white/30 bg-white/15 px-3 py-1 backdrop-blur-sm">
                                    <span>
                                        {{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }} –
                                        {{ \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') }}
                                    </span>
                                </div>
                                <div
                                    class="inline-flex items-center gap-2 text-red-100 font-bold text-[0.9rem] rounded-full border border-white/30 bg-white/15 px-3 py-1 backdrop-blur-sm">
                                    Status: {{ ucfirst($tournament->status) }}
                                </div>
                                <div
                                    class="inline-flex items-center gap-2 text-red-100 font-bold text-[0.9rem] rounded-full border border-white/30 bg-white/15 px-3 py-1 backdrop-blur-sm">
                                    Participants: {{ $participantsCount }}
                                </div>
                                <div
                                    class="inline-flex items-center gap-2 text-red-100 font-bold text-[0.9rem] rounded-full border border-white/30 bg-white/15 px-3 py-1 backdrop-blur-sm">
                                    Matches: {{ $matchCount }}
                                </div>

                                @if ($serverWinner)
                                    <div
                                        class="inline-flex items-center gap-2 text-yellow-50 font-bold text-[0.9rem] rounded-full border border-white/30 bg-white/15 px-3 py-1 backdrop-blur-sm">
                                        🏆 Champion: {{ $serverWinner }}
                                    </div>
                                @endif

                                <!-- Client-side fallback champion (until reload persists) -->
                                <div x-show="tournamentWinner && '{{ $serverWinner ?? '' }}' === ''"
                                    class="inline-flex items-center gap-2 text-yellow-50 font-bold text-[0.9rem] rounded-full border border-white/30 bg-white/15 px-3 py-1 backdrop-blur-sm"
                                    x-cloak>
                                    🏆 Champion: <span x-text="tournamentWinner"></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('tournaments.show', $tournament) }}"
                                class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white/10 px-4 py-2 text-white hover:bg-white/15 transition">Overview</a>
                            <a href="{{ route('tournaments.stats', $tournament) }}"
                                class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white/10 px-4 py-2 text-white hover:bg-white/15 transition">Stats</a>
                        </div>
                    </div>
                    <div class="mx-auto mt-1 h-1 rounded-full w-28 sm:w-40 bg-gradient-to-r from-white/50 to-white/0">
                    </div>
                </div>
            </div>
        </header>

        <!-- Start Tournament Button -->
        @if (
            $tournament->status === 'pending' &&
                (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin())))
            <div class="mb-6 text-center">
                <form action="{{ route('tournaments.start', $tournament) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-red-600 text-white font-bold px-4 py-2 shadow-md hover:bg-red-700 hover:shadow-lg transition">
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
                        class="inline-flex items-center justify-center rounded-full bg-red-600 text-white font-bold px-4 py-2 shadow-md hover:bg-red-700 hover:shadow-lg transition">
                        Stop Tournament
                    </button>
                </form>
            </div>
        @endif

        <!-- Legend / Help -->
        <div class="mb-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="rounded-2xl border border-gray-200 bg-white/80 backdrop-blur p-4 shadow-sm">
                <div class="font-extrabold text-gray-900 mb-2">Legend</div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-block h-4 w-8 rounded bg-green-50 ring-1 ring-inset ring-green-200"></span>
                    <span class="text-sm text-gray-700">Row highlighted = winner of the match</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-block h-[2px] w-8 rounded bg-gray-200"></span>
                    <span class="text-sm text-gray-700">Connector indicates advancement to next round</span>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white/80 backdrop-blur p-4 shadow-sm">
                <div class="font-extrabold text-gray-900 mb-2">How to update scores</div>
                <p class="text-sm text-gray-700">
                    As an admin, enter points for Team A and Team B and press <strong>Update</strong>.
                    The bracket auto-advances winners into the next match slots.
                </p>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white/80 backdrop-blur p-4 shadow-sm">
                <div class="font-extrabold text-gray-900 mb-2">Champion</div>
                <p class="text-sm text-gray-700">
                    When the final match has a winner, the champion card will appear automatically below and in the
                    header.
                </p>
            </div>
        </div>

        @if ($matches->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white/80 backdrop-blur p-6 text-center shadow-sm">
                <div class="text-gray-900 font-extrabold text-lg mb-1">No matches yet</div>
                <p class="text-gray-600">Start the tournament to generate the bracket.</p>
            </div>
        @else
            <!-- ===== Bracket Grid ===== -->
            <div
                class="overflow-x-auto rounded-xl p-6 bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.04)_1px,transparent_0)] bg-[size:18px_18px]">
                <div class="grid grid-flow-col auto-cols-max gap-16 justify-center">
                    @foreach ($rounds as $roundNumber => $roundMatches)
                        <div class="flex flex-col justify-center items-center gap-6">
                            <!-- Round Label -->
                            <div
                                class="mb-2 text-red-700 bg-rose-50 ring-1 ring-red-200 rounded-full px-4 py-1 font-extrabold text-[0.95rem]">
                                Round {{ $roundNumber }}
                            </div>

                            <!-- Matches -->
                            @foreach ($roundMatches as $match)
                                @php
                                    $matchPayload = $match->only([
                                        'id',
                                        'team_a',
                                        'team_b',
                                        'team_a_score',
                                        'team_b_score',
                                        'winner',
                                        'round',
                                        'next_match_id',
                                    ]);
                                @endphp

                                <div class="relative flex flex-col items-center group" id="match-{{ $match->id }}"
                                    x-data="matchData(@json($matchPayload), {{ (int) $roundNumber }}, {{ (int) $finalRound }})" x-init="initNextMatch()">
                                    <!-- Match Card -->
                                    <div
                                        class="w-56 rounded-2xl border border-gray-200 bg-white/90 backdrop-blur shadow-sm overflow-hidden">
                                        <div class="flex justify-between items-center px-3 py-2 border-b"
                                            :class="winner === 'team_a' ? 'bg-green-50 font-bold text-green-800' : ''">
                                            <span class="truncate text-gray-900" x-text="team_a"></span>
                                            <span class="font-bold text-gray-700"
                                                x-text="team_a_score !== '' && team_a_score !== null ? team_a_score : '-'"></span>
                                        </div>
                                        <div class="flex justify-between items-center px-3 py-2"
                                            :class="winner === 'team_b' ? 'bg-green-50 font-bold text-green-800' : ''">
                                            <span class="truncate text-gray-900" x-text="team_b"></span>
                                            <span class="font-bold text-gray-700"
                                                x-text="team_b_score !== '' && team_b_score !== null ? team_b_score : '-'"></span>
                                        </div>

                                        <!-- Admin Score Update -->
                                        @if (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin()))
                                            <form
                                                action="{{ url('/tournaments/' . $tournament->id . '/matches/' . $match->id . '/score') }}"
                                                method="POST"
                                                class="flex gap-2 p-3 border-t text-sm bg-white/80 backdrop-blur"
                                                @submit.prevent="updateScore($el)">
                                                @csrf
                                                @method('PATCH')

                                                <input type="number" name="team_a_score" min="0" placeholder="A"
                                                    x-model="team_a_score"
                                                    class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400" />
                                                <input type="number" name="team_b_score" min="0" placeholder="B"
                                                    x-model="team_b_score"
                                                    class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400" />
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-full bg-red-600 text-white font-bold px-3 py-1.5 shadow hover:bg-red-700 transition">
                                                    Update
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Connector (visual only) -->
                                    @if ($match->next_match_id)
                                        <div class="absolute -right-8 top-1/2 w-8 border-t-2 border-gray-200"></div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Winner Card (final column only) -->
                            <template x-if="tournamentWinner && {{ (int) $roundNumber }} === {{ (int) $finalRound }}">
                                <div
                                    class="mt-4 w-56 rounded-xl border border-yellow-300 bg-yellow-50 p-3 text-center text-yellow-900 font-extrabold shadow">
                                    🏆 Champion: <span x-text="tournamentWinner"></span>
                                </div>
                            </template>

                            @if ($serverWinner && (int) $roundNumber === (int) $finalRound)
                                <div
                                    class="mt-4 w-56 rounded-xl border border-yellow-300 bg-yellow-50 p-3 text-center text-yellow-900 font-extrabold shadow">
                                    🏆 Champion: {{ $serverWinner }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        /* Root state */
        function tournamentBracket(matches, initialWinner = '') {
            return {
                matches,
                tournamentWinner: initialWinner || ''
            };
        }

        /* Per-match component using a window event to set champion */
        function matchData(match, roundNumber, finalRound) {
            return {
                id: match.id,
                // Always show a label; fallback to 'BYE' to avoid blank rows
                team_a: match.team_a ?? 'BYE',
                team_b: match.team_b ?? 'BYE',
                team_a_score: (match.team_a_score ?? '') === null ? '' : (match.team_a_score ?? ''),
                team_b_score: (match.team_b_score ?? '') === null ? '' : (match.team_b_score ?? ''),
                winner: match.winner ?? '',
                next_match_id: match.next_match_id,

                initNextMatch() {
                    // Push winner into next match slot (client-side visual)
                    if (this.winner && this.next_match_id) {
                        const nextEl = document.getElementById('match-' + this.next_match_id);
                        if (!nextEl) return;
                        const nextData = nextEl.__x?.$data;
                        if (!nextData) {
                            setTimeout(() => this.initNextMatch(), 300);
                            return;
                        }
                        const nextSlot = !nextData.team_a || nextData.team_a === 'BYE' ? 'team_a' : 'team_b';
                        nextData[nextSlot] = this.winner === 'team_a' ? this.team_a : this.team_b;

                        // Auto-advance BYE
                        if (nextData.team_a === 'BYE' || nextData.team_b === 'BYE') {
                            nextData.winner = nextData.team_a === 'BYE' ? 'team_b' : 'team_a';
                            nextData.initNextMatch();
                        }
                    }

                    // Final round -> announce champion
                    if (roundNumber === finalRound && this.winner) {
                        const name = this.winner === 'team_a' ? this.team_a : this.team_b;
                        window.dispatchEvent(new CustomEvent('champion', {
                            detail: name
                        }));
                    }
                },

                updateScore(form) {
                    // UI preview first (server still validates)
                    const a = parseInt(form.team_a_score.value, 10);
                    const b = parseInt(form.team_b_score.value, 10);

                    this.team_a_score = Number.isFinite(a) ? a : 0;
                    this.team_b_score = Number.isFinite(b) ? b : 0;

                    this.winner =
                        this.team_a_score > this.team_b_score ? 'team_a' :
                        this.team_b_score > this.team_a_score ? 'team_b' : '';

                    this.initNextMatch(); // propagate visually
                    form.submit(); // then send to controller (PATCH)
                }
            }
        }
    </script>
</x-app-layout>
