{{-- resources/views/tournaments/stats.blade.php --}}
<x-app-layout>
    @php
        $rounds = $matches->groupBy('round');
        $finalRound = $rounds->keys()->max();
        $finalMatch = $matches->where('round', $finalRound)->first();
        $serverWinner = $finalMatch?->winnerApplication()?->team_name;
        $participantsCount = $tournament->applications()->count();
        $matchCount = $matches->count();
    @endphp

    <div class="max-w-full mx-auto mt-20 sm:mt-25 px-4 sm:px-6 lg:px-8">
        {{-- ===== Header (short) ===== --}}
        <header class="mb-8">
            <div
                class="relative overflow-hidden rounded-2xl text-white shadow-2xl ring-1 ring-white/20
                        bg-gradient-to-br from-red-700 via-red-600 to-red-700">
                <div class="relative p-5 sm:p-7">
                    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                        <div>
                            <div class="text-[11px] uppercase tracking-[0.2em] text-red-100/90 font-bold">Turnīrs</div>
                            <div class="mt-1 flex items-center gap-3">
                                <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV"
                                    class="h-10 w-10 sm:h-12 sm:w-12 object-contain select-none" />
                                <h1 class="text-3xl sm:text-5xl font-black leading-tight drop-shadow-sm">
                                    {{ $tournament->name }}
                                </h1>
                            </div>
                            <div class="mt-3 flex flex-wrap items-center gap-2 text-sm">
                                <span
                                    class="inline-flex items-center gap-2 font-bold rounded-full border border-white/25 bg-white/15 text-red-50 px-3 py-1">
                                    🔴 Status: {{ ucfirst($tournament->status) }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 font-bold rounded-full border border-white/25 bg-white/15 text-red-50 px-3 py-1">
                                    👥 Dalībnieki: {{ $participantsCount }}
                                </span>
                                <span
                                    class="inline-flex items-center gap-2 font-bold rounded-full border border-white/25 bg-white/15 text-red-50 px-3 py-1">
                                    🎮 Spēles: {{ $matchCount }}
                                </span>
                                @if ($serverWinner)
                                    <span
                                        class="inline-flex items-center gap-2 font-bold rounded-full border border-yellow-200/50 bg-yellow-50/20 text-yellow-50 px-3 py-1">
                                        🏆 Čempions: {{ $serverWinner }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('tournaments.show', $tournament) }}"
                                class="inline-flex items-center justify-center rounded-full border border-white/35 bg-white/10 px-4 py-2 text-white hover:bg-white/15 transition">
                                Pārskats
                            </a>
                            <a href="{{ route('tournaments.stats', $tournament) }}"
                                class="inline-flex items-center justify-center rounded-full border border-white/35 bg-white/10 px-4 py-2 text-white hover:bg-white/15 transition">
                                Statistika
                            </a>
                        </div>
                    </div>
                    <div class="mx-auto mt-3 h-1 rounded-full w-28 sm:w-40 bg-gradient-to-r from-white/60 to-white/0">
                    </div>
                </div>
            </div>
        </header>

        @if ($matches->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white/80 backdrop-blur p-6 text-center shadow-sm">
                <div class="text-gray-900 font-extrabold text-lg mb-1">No matches yet</div>
                <p class="text-gray-600">Start the tournament to generate the bracket.</p>
            </div>
        @else
            <div
                class="overflow-x-auto rounded-xl p-6 bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.04)_1px,transparent_0)] bg-[size:18px_18px]">
                <div class="grid grid-flow-col auto-cols-max gap-16 justify-center">
                    @foreach ($rounds as $roundNumber => $roundMatches)
                        <div class="flex flex-col justify-center items-center gap-6">
                            <div
                                class="mb-2 text-red-700 bg-rose-50 ring-1 ring-red-200 rounded-full px-4 py-1 font-extrabold text-[0.95rem]">
                                Round {{ $roundNumber }}
                            </div>

                            @foreach ($roundMatches as $match)
                                <div class="relative flex flex-col items-center group w-56">
                                    <div
                                        class="w-full rounded-2xl border border-gray-200 bg-white/90 backdrop-blur shadow-sm overflow-hidden">
                                        <div
                                            class="flex justify-between items-center px-3 py-2 border-b {{ $match->winner_slot === 'A' ? 'bg-green-50 font-bold text-green-800' : '' }}">
                                            <span class="truncate text-gray-900">
                                                {{ $match->participantA?->team_name ?? 'BYE' }}
                                            </span>
                                            <span class="font-bold text-gray-700">
                                                {{ $match->score_a ?? '-' }}
                                            </span>
                                        </div>
                                        <div
                                            class="flex justify-between items-center px-3 py-2 {{ $match->winner_slot === 'B' ? 'bg-green-50 font-bold text-green-800' : '' }}">
                                            <span class="truncate text-gray-900">
                                                {{ $match->participantB?->team_name ?? 'BYE' }}
                                            </span>
                                            <span class="font-bold text-gray-700">
                                                {{ $match->score_b ?? '-' }}
                                            </span>
                                        </div>

                                        @if (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin()))
                                            <form
                                                action="{{ route('tournaments.updateMatchScore', [$tournament, $match]) }}"
                                                method="POST"
                                                class="flex gap-2 p-3 border-t text-sm bg-white/80 backdrop-blur">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="score_a" min="0"
                                                    value="{{ $match->score_a ?? '' }}" placeholder="A"
                                                    class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400" />
                                                <input type="number" name="score_b" min="0"
                                                    value="{{ $match->score_b ?? '' }}" placeholder="B"
                                                    class="w-full rounded-lg border border-gray-300 px-2.5 py-1.5 focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400" />
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-full bg-red-600 text-white font-bold px-3 py-1.5 shadow hover:bg-red-700 transition">
                                                    Update
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    @if ($match->next_match_id)
                                        <div class="absolute -right-8 top-1/2 w-8 border-t-2 border-gray-200"></div>
                                    @endif
                                </div>
                            @endforeach

                            @if ($serverWinner && (int) $roundNumber === (int) $finalRound)
                                <div
                                    class="mt-2 w-56 rounded-xl border border-yellow-300 bg-yellow-50 p-3 text-center text-yellow-900 font-extrabold shadow">
                                    🏆 Champion: {{ $serverWinner }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
