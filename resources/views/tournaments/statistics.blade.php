{{-- resources/views/tournaments/statistics.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto mt-20 sm:mt-24 px-4 sm:px-6 lg:px-8">

        {{-- ===== Heading (aligned with leaderboard) ===== --}}
        <header class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="uppercase tracking-[0.2em] text-xs text-red-600/80">
                        Turnīrs • Statistika
                    </p>

                    <h1 class="mt-1 text-4xl sm:text-6xl font-black text-gray-900 leading-none tracking-tight">
                        {{ $tournament->name }}
                    </h1>

                    <div class="mt-3 h-2 w-32 sm:w-40 rounded-full bg-gradient-to-r from-red-600 to-transparent"></div>

                    <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                        <span
                            class="inline-flex items-center gap-2 font-semibold rounded-full border border-gray-300 bg-white text-gray-700 px-3 py-1">
                            Statistika
                        </span>
                        <span
                            class="inline-flex items-center gap-2 font-semibold rounded-full border border-gray-300 bg-white text-gray-700 px-3 py-1">
                            Dalībnieki: {{ $tournament->applications()->count() }}
                        </span>
                        <span
                            class="inline-flex items-center gap-2 font-semibold rounded-full border border-gray-300 bg-white text-gray-700 px-3 py-1">
                            Spēles: {{ $totalMatches }}
                        </span>
                    </div>
                </div>

                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('tournaments.show', $tournament) }}"
                        class="inline-flex items-center justify-center rounded-full border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                        ← Pārskats
                    </a>
                    <a href="{{ route('tournaments.stats', $tournament) }}"
                        class="inline-flex items-center justify-center rounded-full border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                        Brakets
                    </a>
                </div>
            </div>
        </header>

        {{-- ===== Winner Hero (clean; removed confetti/patches) ===== --}}
        @if ($champion)
            @php
                // Optional aggregates for the hero chips (null-safe)
                $winsFor = (int) ($champion->wins_for ?? 0);
                $winsAgainst = (int) ($champion->wins_against ?? 0);
                $pointDiff = (int) ($champion->points_diff ?? 0);

                // Safely determine the final (highest round) from champion path
                $finalMatch =
                    isset($championPath) && $championPath->isNotEmpty()
                        ? $championPath->sortByDesc('round')->first()
                        : null;
            @endphp

            <section class="mb-8">
                <div class="relative overflow-hidden rounded-2xl border bg-white shadow-sm">
                    <div class="px-5 sm:px-7 py-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <div class="flex items-center gap-3">
                                    {{-- trophy (amber accent kept) --}}
                                    <span
                                        class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-amber-100 ring-1 ring-amber-200">
                                        <svg class="h-6 w-6 text-amber-600" viewBox="0 0 24 24" fill="currentColor"
                                            aria-hidden="true">
                                            <path
                                                d="M6 3a1 1 0 0 0-1 1v2a5 5 0 0 0 4 4.9V12a3 3 0 0 1-3 3H5a1 1 0 1 0 0 2h14a1 1 0 1 0 0-2h-1a3 3 0 0 1-3-3V10.9A5 5 0 0 0 19 6V4a1 1 0 0 0-1-1H6Zm1 3V5h10v1a3 3 0 0 1-3 3h-4A3 3 0 0 1 7 6Z" />
                                        </svg>
                                    </span>

                                    <div>
                                        <p class="uppercase tracking-[0.2em] text-[11px] font-black text-red-600/80">
                                            Turnīra uzvarētājs
                                        </p>
                                        <h2 class="mt-1 font-black text-3xl sm:text-4xl text-gray-900 leading-none truncate"
                                            title="{{ $champion->team_name }}">
                                            {{ $champion->team_name }}
                                        </h2>
                                    </div>
                                </div>

                                {{-- compact stat line (chips) --}}
                                <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-gray-600">
                                    @if ($winsFor || $winsAgainst)
                                        <span
                                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-3 py-1 font-semibold">
                                            {{ $winsFor }}–{{ $winsAgainst }}
                                        </span>
                                    @endif
                                    <span
                                        class="inline-flex items-center rounded-full border border-gray-300 bg-white px-3 py-1">
                                        Punktu starpība:
                                        <span
                                            class="ml-1 font-semibold {{ $pointDiff >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                            {{ $pointDiff >= 0 ? '+' : '' }}{{ $pointDiff }}
                                        </span>
                                    </span>
                                    <span
                                        class="inline-flex items-center rounded-full border border-gray-300 bg-white px-3 py-1">
                                        Dalībnieki: <span
                                            class="ml-1 font-semibold">{{ $tournament->applications()->count() }}</span>
                                    </span>
                                    <span
                                        class="inline-flex items-center rounded-full border border-gray-300 bg-white px-3 py-1">
                                        Spēles: <span class="ml-1 font-semibold">{{ $totalMatches }}</span>
                                    </span>
                                </div>
                            </div>

                            {{-- actions --}}
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('tournaments.stats', $tournament) }}"
                                    class="inline-flex h-10 items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 shadow transition">
                                    Skatīt spēles
                                </a>
                                <a href="{{ route('tournaments.show', $tournament) }}"
                                    class="inline-flex h-10 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 font-semibold px-4 transition">
                                    Atpakaļ uz pārskatu
                                </a>
                            </div>
                        </div>

                        {{-- final match summary (uses highest round) --}}
                        @if ($finalMatch)
                            <div class="mt-5">
                                <div class="rounded-xl border bg-white shadow-sm overflow-hidden">
                                    <div class="grid grid-cols-3 text-sm">
                                        <div class="col-span-2 px-4 py-3">
                                            <div class="font-semibold text-gray-900 truncate"
                                                title="{{ $finalMatch->participantA?->team_name }}">
                                                {{ $finalMatch->participantA?->team_name ?? '—' }}
                                            </div>
                                            <div class="text-gray-500 -mt-0.5">pret
                                                {{ $finalMatch->participantB?->team_name ?? '—' }}</div>
                                        </div>
                                        <div class="px-4 py-3 text-right">
                                            <div class="text-2xl font-black text-gray-900 leading-none">
                                                {{ $finalMatch->score_a ?? '–' }}
                                            </div>
                                            <div class="text-gray-500">: {{ $finalMatch->score_b ?? '–' }}</div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-2 border-t bg-red-50/40 flex items-center justify-between">
                                        <span class="text-xs uppercase tracking-[0.18em] text-red-700/80 font-bold">
                                            Fināls • Round {{ $finalMatch->round }}
                                        </span>
                                        <span
                                            class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs font-semibold px-2.5 py-1">
                                            Uzvara
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        {{-- ===== Kopsavilkums (cards like leaderboard) ===== --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold">Kopējais spēļu skaits</div>
                <div class="mt-1 text-3xl font-black text-gray-900">{{ $totalMatches }}</div>
            </div>

            <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold">Noslēgtās spēles</div>
                <div class="mt-1 text-3xl font-black text-gray-900">{{ $completedMatches }}</div>
                <div class="text-xs text-gray-600 mt-1">Pabeigts: <span
                        class="font-semibold">{{ $completionPct }}%</span></div>
            </div>

            <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold">Kopējie punkti (noslēgtajās)
                </div>
                <div class="mt-1 text-3xl font-black text-gray-900">{{ $totPoints }}</div>
            </div>

            <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                <div class="text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold">Vidēji punkti/spēlē</div>
                <div class="mt-1 text-3xl font-black text-gray-900">{{ $avgPoints }}</div>
            </div>
        </section>

        {{-- ===== Top-3 (cards like leaderboard’s podium) ===== --}}
        @if ($topThree->isNotEmpty())
            @php
                $t1 = $topThree->get(0);
                $t2 = $topThree->get(1);
                $t3 = $topThree->get(2);
                $podium = collect([$t1, $t2, $t3])->filter();
                $medals = ['🥇', '🥈', '🥉'];
            @endphp

            <section class="mb-8">
                <div class="mb-3">
                    <p class="uppercase tracking-[0.2em] text-xs text-red-600/80 font-bold">Komandas</p>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Top 3 komandas</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach ($podium as $idx => $r)
                        <div class="rounded-2xl border shadow-sm bg-white p-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-2xl">{{ $medals[$idx] ?? '' }}</div>
                                    <h3 class="mt-1 font-extrabold text-lg text-gray-900 max-w-[260px] sm:max-w-[360px] truncate"
                                        title="{{ $r['team'] ?? '—' }}">
                                        {{ $r['team'] ?? '—' }}
                                    </h3>
                                </div>
                                <div class="text-right">
                                    <div class="text-[11px] uppercase tracking-widest text-gray-500">Uzvaras</div>
                                    <div class="text-3xl font-black text-red-600 leading-none">{{ $r['wins'] ?? 0 }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 grid grid-cols-2 gap-2 text-xs text-gray-600">
                                <div><span class="font-semibold text-gray-900">{{ $r['wins'] ?? 0 }}</span> W</div>
                                <div><span class="font-semibold text-gray-900">{{ $r['team'] ? 1 : 0 }}</span> komanda
                                </div>
                            </div>

                            @php
                                $maxWins = max(1, (int) ($winsTable->max('wins') ?? ($r['wins'] ?? 1)));
                                $val = (int) ($r['wins'] ?? 0);
                                $pct = min(100, (int) round(($val / $maxWins) * 100));
                            @endphp
                            <div class="mt-4 h-2 rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-red-600" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- ===== Rekordi (two white cards) ===== --}}
        <section class="mb-8">
            <div class="mb-3">
                <p class="uppercase tracking-[0.2em] text-xs text-red-600/80 font-bold">Rekordi</p>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Spēļu rekordi</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2">Augstākā punktu summa (spēle)</h3>
                    @if ($highestScoring)
                        <p class="text-[15px] text-gray-800 leading-relaxed">
                            <span class="font-semibold">
                                {{ $highestScoring->participantA?->team_name ?? '—' }}
                                ({{ $highestScoring->score_a ?? '-' }})
                                —
                                {{ $highestScoring->participantB?->team_name ?? '—' }}
                                ({{ $highestScoring->score_b ?? '-' }})
                            </span>
                            <span class="text-gray-500"> • Kopsumma:
                                {{ (int) ($highestScoring->score_a ?? 0) + (int) ($highestScoring->score_b ?? 0) }}</span>
                            <span class="text-gray-500"> • Round {{ $highestScoring->round }}</span>
                        </p>
                    @else
                        <p class="text-gray-500">Nav noslēgtu spēļu.</p>
                    @endif
                </div>

                <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                    <h3 class="text-lg font-extrabold text-gray-900 mb-2">Lielākā uzvara (pēc starpības)</h3>
                    @if ($biggestWin)
                        @php $diff = abs((int) ($biggestWin->score_a ?? 0) - (int) ($biggestWin->score_b ?? 0)); @endphp
                        <p class="text-[15px] text-gray-800 leading-relaxed">
                            <span class="font-semibold">
                                {{ $biggestWin->participantA?->team_name ?? '—' }}
                                ({{ $biggestWin->score_a ?? '-' }})
                                —
                                {{ $biggestWin->participantB?->team_name ?? '—' }}
                                ({{ $biggestWin->score_b ?? '-' }})
                            </span>
                            <span class="text-gray-500"> • Starpība: {{ $diff }}</span>
                            <span class="text-gray-500"> • Round {{ $biggestWin->round }}</span>
                        </p>
                    @else
                        <p class="text-gray-500">Nav noslēgtu spēļu.</p>
                    @endif
                </div>
            </div>
        </section>

        {{-- ===== Komandu uzvaras (sticky red header table like leaderboard) ===== --}}
        <section class="mb-10">
            <div class="mb-3">
                <p class="uppercase tracking-[0.2em] text-xs text-red-600/80 font-bold">Rezultāti</p>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Komandu uzvaras</h2>
            </div>

            @if ($winsTable->isNotEmpty())
                <div class="rounded-2xl border bg-white shadow-sm overflow-hidden">
                    <div class="px-4 py-3 border-b">
                        <p class="uppercase tracking-[0.2em] text-xs text-red-600/90">Pilnais saraksts</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="sticky top-0 z-10">
                                <tr class="bg-red-600 text-white">
                                    <th class="py-2.5 px-3 text-left font-extrabold">#</th>
                                    <th class="py-2.5 px-3 text-left font-extrabold">Komanda</th>
                                    <th class="py-2.5 px-3 text-right font-extrabold">Uzvaras</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($winsTable as $i => $row)
                                    <tr class="odd:bg-white even:bg-red-50/30 hover:bg-red-50/60 transition-colors">
                                        <td class="py-2.5 px-3 text-right font-semibold text-gray-700 tabular-nums">
                                            {{ $i + 1 }}</td>
                                        <td class="py-2.5 px-3 font-semibold text-gray-900 max-w-[260px] sm:max-w-[360px] truncate"
                                            title="{{ $row['team'] }}">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-red-100 text-red-700 flex items-center justify-center text-xs font-bold">
                                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($row['team'], 0, 1)) }}
                                                </div>
                                                <span>{{ $row['team'] }}</span>
                                            </div>
                                        </td>
                                        <td class="py-2.5 px-3 text-right font-extrabold text-red-600">
                                            {{ $row['wins'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-600">Nav uzvaru datu.</p>
            @endif
        </section>

        {{-- ===== Ceļš līdz titulam (timeline) ===== --}}
        @if ($champion && $championPath->isNotEmpty())
            <section class="mb-16">
                <div class="mb-3">
                    <p class="uppercase tracking-[0.2em] text-xs text-red-600/80 font-bold">Ceļš</p>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                        Ceļš līdz titulam — <span class="text-amber-700">{{ $champion->team_name }}</span>
                    </h2>
                </div>

                <div class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm">
                    <div class="relative">
                        <div class="absolute left-3 sm:left-4 top-0 bottom-0 w-1 rounded bg-red-100"></div>

                        <ul class="space-y-4">
                            @foreach ($championPath as $m)
                                <li class="relative pl-10 sm:pl-12">
                                    <div
                                        class="absolute left-1.5 sm:left-2.5 top-2 h-3 w-3 rounded-full bg-red-600 ring-4 ring-red-100">
                                    </div>

                                    <div class="border rounded-xl bg-white shadow-sm hover:bg-red-50/40 transition">
                                        <div class="px-4 py-3 flex items-center justify-between gap-4">
                                            <div class="min-w-0">
                                                <p
                                                    class="uppercase tracking-[0.18em] text-[11px] text-red-600/80 font-bold">
                                                    Round {{ $m->round }}
                                                </p>
                                                <div class="text-sm sm:text-[15px] text-gray-900 truncate">
                                                    {{ $m->participantA?->team_name ?? '—' }}
                                                    <span class="text-gray-500">({{ $m->score_a ?? '-' }})</span>
                                                    <span class="mx-2 text-gray-400">—</span>
                                                    {{ $m->participantB?->team_name ?? '—' }}
                                                    <span class="text-gray-500">({{ $m->score_b ?? '-' }})</span>
                                                </div>
                                            </div>

                                            <div class="shrink-0">
                                                <span
                                                    class="inline-flex items-center rounded-full bg-emerald-600 text-white text-xs font-semibold px-2.5 py-1">
                                                    Uzvara
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        @endif

        <div class="h-24"></div>
    </div>
</x-app-layout>
