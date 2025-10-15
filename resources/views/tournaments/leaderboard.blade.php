{{-- resources/views/tournaments/leaderboard.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto mt-20 sm:mt-24 px-4 sm:px-6 lg:px-8">

        {{-- ===== Heading ===== --}}
        <header class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between gap-3">
                <div>
                    {{-- small label above title (customize via $pretitle) --}}
                    <p class="uppercase tracking-[0.2em] text-xs text-red-600/80">
                        {{ $pretitle ?? 'Leaderboard' }}
                    </p>

                    {{-- more aggressive title --}}
                    <h1 class="mt-1 text-4xl sm:text-6xl font-black text-gray-900 leading-none tracking-tight">
                        Kopvērtējums
                    </h1>
                    <div class="mt-3 h-2 w-32 sm:w-40 rounded-full bg-gradient-to-r from-red-600 to-transparent"></div>

                    <p class="mt-3 text-sm text-gray-600">
                        Uzvaras = <span class="font-semibold">turnīra tituli</span>
                    </p>
                </div>

                <a href="{{ route('dashboard') }}"
                    class="hidden sm:inline-flex items-center justify-center rounded-full border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50 transition">
                    ← Paneļis
                </a>
            </div>
        </header>

        {{-- ===== Filters (search + sort + direction only) ===== --}}
        <section class="rounded-2xl border bg-white p-4 sm:p-5 shadow-sm mb-6">
            <form method="GET" action="{{ route('leaderboard') }}"
                class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">

                {{-- Meklēt komandu --}}
                <div class="sm:col-span-6 min-w-0">
                    <label class="block text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold mb-1">
                        Meklēt komandu
                    </label>
                    <input type="text" name="q" value="{{ $q }}" placeholder="Komandas nosaukums…"
                        class="h-11 w-full rounded-xl border border-gray-300 bg-white text-gray-800 px-3
                               focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400">
                </div>

                {{-- Kārtot pēc --}}
                <div class="sm:col-span-3 min-w-0">
                    <label class="block text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold mb-1">
                        Kārtot pēc
                    </label>

                    <div class="relative">
                        <select name="sort"
                            class="peer h-11 w-full appearance-none rounded-xl border border-gray-300 bg-white text-gray-800 px-3 pr-10
                                   focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400">
                            <option value="wins" {{ $sort === 'wins' ? 'selected' : '' }}>Tituli</option>
                            <option value="titles" {{ $sort === 'titles' ? 'selected' : '' }}>Tituli (alias)</option>
                            <option value="finals" {{ $sort === 'finals' ? 'selected' : '' }}>Fināli</option>
                            <option value="win_rate" {{ $sort === 'win_rate' ? 'selected' : '' }}>Uzvaru % (spēles)
                            </option>
                            <option value="diff" {{ $sort === 'diff' ? 'selected' : '' }}>Punktu starpība</option>
                            <option value="pf_avg" {{ $sort === 'pf_avg' ? 'selected' : '' }}>Vid. punkti (par)</option>
                            <option value="pa_avg" {{ $sort === 'pa_avg' ? 'selected' : '' }}>Vid. punkti (pret)
                            </option>
                            <option value="played" {{ $sort === 'played' ? 'selected' : '' }}>Spēles</option>
                        </select>

                        {{-- single chevron (no overlap) --}}
                        <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-500 transition-transform peer-focus:rotate-180"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                {{-- Secība (Augoši / Dilstoši) --}}
                <div class="sm:col-span-3 min-w-0">
                    <label class="block text-[11px] uppercase tracking-[0.2em] text-gray-600 font-bold mb-1">
                        Secība
                    </label>

                    <div class="relative">
                        <select name="dir"
                            class="peer h-11 w-full appearance-none rounded-xl border border-gray-300 bg-white text-gray-800 px-3 pr-10
                                   focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400">
                            <option value="desc" {{ $dir === 'desc' ? 'selected' : '' }}>Dilstoši</option>
                            <option value="asc" {{ $dir === 'asc' ? 'selected' : '' }}>Augoši</option>
                        </select>

                        {{-- single chevron for direction --}}
                        <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-500 transition-transform peer-focus:rotate-180"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                {{-- Tikai noslēgtās + Rādīt --}}
                <div class="sm:col-span-12 flex items-center justify-between gap-2 pt-1">


                    <button type="submit"
                        class="h-11 inline-flex items-center justify-center rounded-full
                                   bg-red-600 hover:bg-red-700 text-white font-semibold px-6 shadow transition whitespace-nowrap">
                        Rādīt
                    </button>
                </div>
            </form>
        </section>

        {{-- ===== Top-3 Podium (cards) ===== --}}
        @php
            $ranked = $rows->values();
            $top3 = $ranked->take(3);
            $rest = $ranked->slice(3)->values();
            $medals = ['🥇', '🥈', '🥉'];
        @endphp

        <section class="mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach ($top3 as $idx => $r)
                    <div class="rounded-2xl border shadow-sm bg-white p-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="text-2xl">{{ $medals[$idx] ?? ' ' }}</div>
                                <h3 class="mt-1 font-extrabold text-lg text-gray-900 max-w-[260px] sm:max-w-[360px] truncate"
                                    title="{{ $r['team'] }}">
                                    {{ $r['team'] }}
                                </h3>
                            </div>
                            <div class="text-right">
                                <div class="text-[11px] uppercase tracking-widest text-gray-500">Tituli</div>
                                <div class="text-3xl font-black text-red-600 leading-none">{{ $r['titles'] ?? 0 }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-3 gap-2 text-xs text-gray-600">
                            <div><span class="font-semibold text-gray-900">{{ $r['finals'] ?? 0 }}</span> fināli</div>
                            <div><span
                                    class="font-semibold text-gray-900">{{ number_format((float) $r['win_rate'], 0) }}%</span>
                                uzv. (spēles)</div>
                            <div>diff <span
                                    class="font-semibold {{ (int) $r['diff'] >= 0 ? 'text-emerald-700' : 'text-red-700' }}">{{ $r['diff'] }}</span>
                            </div>
                        </div>

                        @php
                            $maxTitles = max(1, (int) ($rows->max('titles') ?? ($rows->max('wins') ?? 1)));
                            $val = (int) ($r['titles'] ?? ($r['wins'] ?? 0));
                            $pct = min(100, (int) round(($val / $maxTitles) * 100));
                        @endphp
                        <div class="mt-4 h-2 rounded-full bg-gray-100">
                            <div class="h-2 rounded-full bg-red-600" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ===== Standings Table (red sticky header) ===== --}}
        <section class="rounded-2xl border bg-white shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b">
                <p class="uppercase tracking-[0.2em] text-xs text-red-600/90">Pilnais saraksts</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-red-600 text-white">
                            <th class="py-2.5 px-3 text-left font-extrabold">#</th>
                            <th class="py-2.5 px-3 text-left font-extrabold">Komanda</th>
                            <th class="py-2.5 px-3 text-right font-extrabold">Tituli</th>
                            <th class="py-2.5 px-3 text-right font-extrabold">Fināli</th>
                            <th class="py-2.5 px-3 text-right font-extrabold">Uzv.% (spēles)</th>
                            <th class="py-2.5 px-3 text-right font-extrabold">Starpība</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($rest as $i => $r)
                            @php
                                $rank = $i + 4;
                                $titles = (int) ($r['titles'] ?? ($r['wins'] ?? 0));
                                $finals = (int) ($r['finals'] ?? 0);
                            @endphp
                            <tr class="odd:bg-white even:bg-red-50/30 hover:bg-red-50/60 transition-colors">
                                <td class="py-2.5 px-3 text-right font-semibold text-gray-700 tabular-nums">
                                    {{ $rank }}</td>
                                <td class="py-2.5 px-3 font-semibold text-gray-900 max-w-[260px] sm:max-w-[360px] truncate"
                                    title="{{ $r['team'] }}">{{ $r['team'] }}</td>
                                <td class="py-2.5 px-3 text-right font-extrabold text-red-600">{{ $titles }}</td>
                                <td class="py-2.5 px-3 text-right text-gray-900 font-semibold">{{ $finals }}</td>
                                <td class="py-2.5 px-3 text-right text-gray-900 font-semibold">
                                    {{ number_format((float) $r['win_rate'], 0) }}%</td>
                                <td
                                    class="py-2.5 px-3 text-right font-semibold {{ (int) $r['diff'] >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                    {{ $r['diff'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-3 text-center text-gray-600">Nav datu atbilstoši
                                    filtriem.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="h-24"></div>
    </div>
</x-app-layout>
