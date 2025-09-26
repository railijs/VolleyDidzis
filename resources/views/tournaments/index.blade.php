<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <div class="flex items-center justify-center gap-3">
            <span class="h-6 w-1.5 bg-red-600 rounded"></span>
            <h2 class="font-extrabold text-3xl sm:text-4xl text-gray-900 leading-tight">
                Turnīri
            </h2>
        </div>
    </x-slot>

    <div class="relative min-h-screen pt-24 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        {{-- Page effects (no libs) --}}
        <style>
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .55s ease, transform .55s ease
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none
                }

                .stagger>* {
                    opacity: 0;
                    transform: translateY(12px)
                }

                .loaded .stagger>* {
                    animation: staggerIn .55s ease forwards
                }

                .loaded .stagger>*:nth-child(2) {
                    animation-delay: .06s
                }

                .loaded .stagger>*:nth-child(3) {
                    animation-delay: .12s
                }

                .loaded .stagger>*:nth-child(4) {
                    animation-delay: .18s
                }

                .loaded .stagger>*:nth-child(5) {
                    animation-delay: .24s
                }

                @keyframes staggerIn {
                    to {
                        opacity: 1;
                        transform: none
                    }
                }
            }
        </style>

        <div class="max-w-5xl mx-auto px-6">

            {{-- Success message --}}
            @if (session('success'))
                <div class="fade-up mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($tournaments->count())
                {{-- Controls --}}
                <section
                    class="fade-up bg-white/80 backdrop-blur-sm border border-gray-200/60 rounded-2xl shadow-sm p-4 sm:p-5 mb-6">
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[1fr,auto,auto] gap-3 sm:gap-4 items-center">
                        {{-- Search --}}
                        <div class="relative">
                            <input id="search" type="text" placeholder="Meklēt pēc nosaukuma / vietas…"
                                class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-gray-900 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-200">
                            <button id="clearSearch"
                                class="hidden absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700">
                                Notīrīt
                            </button>
                        </div>

                        {{-- Gender chips --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <button data-gender="all"
                                class="filter-chip px-3 py-1.5 rounded-full border text-sm font-semibold border-gray-300 text-gray-700 hover:bg-gray-50">Visi</button>
                            <button data-gender="men"
                                class="filter-chip px-3 py-1.5 rounded-full border text-sm font-semibold border-blue-300 text-blue-700 hover:bg-blue-50">Vīrieši</button>
                            <button
                                data-gender="women"class="filter-chip px-3 py-1.5 rounded-full border text-sm font-semibold border-pink-300 text-pink-700 hover:bg-pink-50">Sievietes</button>
                            <button data-gender="mix"
                                class="filter-chip px-3 py-1.5 rounded-full border text-sm font-semibold border-purple-300 text-purple-700 hover:bg-purple-50">Mix</button>
                        </div>

                        {{-- Toggles / sort --}}
                        <div class="relative">
                            <select id="sortBy"
                                class="rounded-xl border border-gray-300 bg-white px-3 pr-9 py-2 text-sm text-gray-900
           focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="soonest">Kārtot: tuvākās</option>
                                <option value="latest">Kārtot: tālākās</option>
                            </select>
                        </div>
                    </div>
                </section>

                {{-- List --}}
                <div id="list"
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden fade-up">
                    @php
                        $todayYmd = \Carbon\Carbon::today()->toDateString();
                    @endphp

                    <div class="divide-y divide-gray-200 stagger">
                        @foreach ($tournaments as $t)
                            @php
                                $start = \Carbon\Carbon::parse($t->start_date);
                                $end = \Carbon\Carbon::parse($t->end_date ?? $t->start_date);
                                $day = $start->format('d');
                                $mon = strtoupper($start->format('M'));
                                $gender = $t->gender_type ?? 'other';
                                $apps = $t->applications->count();
                                $max = $t->max_teams;
                                $pct = $max ? min(100, round(($apps / max(1, $max)) * 100)) : null;
                            @endphp

                            <div class="group p-5 sm:p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-5"
                                data-gender="{{ $gender }}" data-start="{{ $start->toDateString() }}"
                                data-end="{{ $end->toDateString() }}" data-name="{{ mb_strtolower($t->name) }}"
                                data-location="{{ mb_strtolower($t->location ?? '') }}"
                                data-desc="{{ mb_strtolower($t->description ?? '') }}">
                                <div class="flex-1 flex items-start gap-4">
                                    {{-- Date block --}}
                                    <div class="shrink-0">
                                        <div
                                            class="flex flex-col items-center justify-center bg-red-600 text-white rounded-xl w-16 h-16 shadow-sm">
                                            <span class="text-xl font-extrabold leading-none">{{ $day }}</span>
                                            <span class="text-[10px] tracking-widest">{{ $mon }}</span>
                                        </div>
                                    </div>

                                    {{-- Main info --}}
                                    <div class="min-w-0">
                                        <h3 class="text-lg font-bold text-gray-900 leading-snug">
                                            {{ $t->name }}
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                            {{ $t->description }}
                                        </p>

                                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-600">
                                            <span class="inline-flex items-center gap-1">
                                                📅 {{ $start->format('d.m.Y') }}
                                                @if ($end && $end->ne($start))
                                                    – {{ $end->format('d.m.Y') }}
                                                @endif
                                            </span>
                                            @if ($t->location)
                                                <span class="inline-flex items-center gap-1">📍
                                                    {{ $t->location }}</span>
                                            @endif
                                            @if ($t->team_size)
                                                <span class="inline-flex items-center gap-1">👥
                                                    {{ $t->team_size }}</span>
                                            @endif>

                                            {{-- Gender pill --}}
                                            @php
                                                $badge = match ($gender) {
                                                    'men' => 'bg-blue-100 text-blue-700',
                                                    'women' => 'bg-pink-100 text-pink-700',
                                                    'mix' => 'bg-purple-100 text-purple-700',
                                                    default => 'bg-gray-100 text-gray-700',
                                                };
                                                $label = match ($gender) {
                                                    'men' => 'Vīrieši',
                                                    'women' => 'Sievietes',
                                                    'mix' => 'Mix',
                                                    default => 'Turnīrs',
                                                };
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $badge }}">
                                                {{ $label }}
                                            </span>
                                        </div>

                                        {{-- Progress --}}
                                        @if (!is_null($pct))
                                            <div class="mt-3 w-full max-w-sm">
                                                <div class="h-2 bg-gray-200/80 rounded-full overflow-hidden">
                                                    <div class="h-2 bg-lime-500" style="width: {{ $pct }}%">
                                                    </div>
                                                </div>
                                                <p class="mt-1 text-[11px] text-gray-500">
                                                    Pieteikumi: {{ $apps }}/{{ $max }}
                                                    ({{ $pct }}%)
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- CTA --}}
                                <div class="md:pl-4">
                                    <button type="button" onclick="openModal('{{ $t->id }}')"
                                        class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 shadow transition">
                                        Skatīt / Pieteikties
                                    </button>
                                </div>
                            </div>

                            {{-- Modal --}}
                            <div id="modal-{{ $t->id }}" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                                    onclick="closeModal('{{ $t->id }}')"></div>
                                <div class="relative z-10 max-w-3xl mx-auto my-8">
                                    <div
                                        class="bg-white rounded-2xl shadow-2xl border border-gray-200/60 overflow-hidden">
                                        <div class="p-6 sm:p-8">
                                            <div class="flex items-start justify-between gap-4">
                                                <div>
                                                    <h2 class="text-2xl font-extrabold text-gray-900">
                                                        {{ $t->name }}</h2>
                                                    <p class="mt-1 text-sm text-gray-600">
                                                        📅 {{ $start->format('d.m.Y') }}@if ($end && $end->ne($start))
                                                            – {{ $end->format('d.m.Y') }}
                                                        @endif
                                                        @if ($t->location)
                                                            • 📍 {{ $t->location }}
                                                        @endif
                                                        • {{ $label }}
                                                    </p>
                                                </div>
                                                <button class="text-gray-500 hover:text-gray-700"
                                                    onclick="closeModal('{{ $t->id }}')" aria-label="Aizvērt">
                                                    ✕
                                                </button>
                                            </div>

                                            @if ($t->description)
                                                <p class="mt-4 text-gray-800">{{ $t->description }}</p>
                                            @endif

                                            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                                <div class="rounded-xl bg-gray-50 border border-gray-200 p-4">
                                                    <p class="text-gray-500">Komandas lielums</p>
                                                    <p class="font-semibold text-gray-900">{{ $t->team_size ?? '—' }}
                                                    </p>
                                                </div>
                                                <div class="rounded-xl bg-gray-50 border border-gray-200 p-4">
                                                    <p class="text-gray-500">Pieteikumi</p>
                                                    <p class="font-semibold text-gray-900">
                                                        {{ $apps }} / {{ $max ?? 'Bez ierobežojuma' }}
                                                    </p>
                                                </div>
                                            </div>

                                            {{-- Join form (unchanged endpoint) --}}
                                            <div class="mt-6 rounded-xl bg-red-50/60 border border-red-200 p-5">
                                                <h3 class="font-bold text-gray-900 mb-3">Pieteikties</h3>
                                                <form method="POST" action="{{ route('tournaments.join', $t) }}"
                                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    @csrf
                                                    <div class="sm:col-span-2">
                                                        <label for="team_name-{{ $t->id }}"
                                                            class="block text-sm font-medium text-gray-700">Komandas
                                                            nosaukums</label>
                                                        <input id="team_name-{{ $t->id }}" name="team_name"
                                                            type="text" required
                                                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                                    </div>
                                                    <div>
                                                        <label for="captain_name-{{ $t->id }}"
                                                            class="block text-sm font-medium text-gray-700">Kapteinis</label>
                                                        <input id="captain_name-{{ $t->id }}"
                                                            name="captain_name" type="text" required
                                                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                                    </div>
                                                    <div>
                                                        <label for="email-{{ $t->id }}"
                                                            class="block text-sm font-medium text-gray-700">E‑pasts</label>
                                                        <input id="email-{{ $t->id }}" name="email"
                                                            type="email" required
                                                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                                    </div>

                                                    <div
                                                        class="sm:col-span-2 flex items-center justify-between gap-3 mt-1">
                                                        @if (!is_null($pct))
                                                            <div class="flex-1 max-w-xs">
                                                                <div
                                                                    class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                                                    <div class="h-2 bg-lime-500"
                                                                        style="width: {{ $pct }}%"></div>
                                                                </div>
                                                                <p class="mt-1 text-[11px] text-gray-500">
                                                                    Aizpildījums: {{ $pct }}%
                                                                </p>
                                                            </div>
                                                        @else
                                                            <span class="text-[12px] text-gray-500">Vietu skaits nav
                                                                ierobežots</span>
                                                        @endif

                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 shadow transition">
                                                            Pieteikties
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="mt-6 text-right">
                                                <button onclick="closeModal('{{ $t->id }}')"
                                                    class="inline-flex items-center justify-center rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 text-sm font-semibold transition">
                                                    Aizvērt
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- No results (filtered) --}}
                    <div id="emptyState" class="hidden p-10 text-center text-gray-600">
                        <p class="text-lg font-semibold">Nav atrastu turnīru pēc jūsu filtriem.</p>
                        <p class="mt-1 text-sm">Mēģiniet mainīt meklēšanu vai filtrus.</p>
                        <div class="mt-4">
                            <a href="{{ route('tournaments.calendar') }}"
                                class="inline-flex items-center justify-center rounded-full bg-white text-red-700 border border-red-200 px-5 py-2 font-semibold hover:bg-red-50 transition">
                                Skatīt kalendāru →
                            </a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty page state --}}
                <div
                    class="fade-up text-center bg-white/80 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-200/60 p-10">
                    <h3 class="text-xl font-extrabold text-gray-900">Pagaidām nav turnīru.</h3>
                    <p class="mt-2 text-gray-600">Apskatiet kalendāru vai vēlāk atgriezieties.</p>
                    <a href="{{ route('tournaments.calendar') }}"
                        class="mt-4 inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 shadow transition">
                        Turnīru kalendārs
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Minimal footer to match site --}}
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} VolleyLV. Visas tiesības aizsargātas.</p>
        </div>
    </footer>

    {{-- JS: load reveal, filters, sort, modal helpers --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });

        // Helpers
        const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
        const $ = (sel, ctx = document) => ctx.querySelector(sel);

        const search = $('#search');
        const clearBtn = $('#clearSearch');
        const chips = $$('.filter-chip');
        const onlyUpcoming = $('#onlyUpcoming');
        const sortBy = $('#sortBy');
        const list = $('#list');
        const rows = $$('#list .divide-y > .group');
        const emptyState = $('#emptyState');

        let genderFilter = 'all';

        // Build search index from data-* attrs
        function rowMatches(r, q) {
            if (!q) return true;
            q = q.toLowerCase();
            const name = r.dataset.name || '';
            const loc = r.dataset.location || '';
            const desc = r.dataset.desc || '';
            return name.includes(q) || loc.includes(q) || desc.includes(q);
        }

        function rowMatchesGender(r) {
            if (genderFilter === 'all') return true;
            return (r.dataset.gender || '') === genderFilter;
        }

        function rowIsUpcoming(r) {
            if (!onlyUpcoming.checked) return true;
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const end = new Date(r.dataset.end || r.dataset.start);
            end.setHours(0, 0, 0, 0);
            return end >= today;
        }

        function applyFilters() {
            const q = (search.value || '').trim().toLowerCase();
            let shown = 0;

            rows.forEach(r => {
                const show = rowMatches(r, q) && rowMatchesGender(r) && rowIsUpcoming(r);
                r.style.display = show ? '' : 'none';
                if (show) shown++;
            });

            emptyState.classList.toggle('hidden', shown !== 0);
        }

        // Search
        let t;
        search?.addEventListener('input', () => {
            clearTimeout(t);
            t = setTimeout(applyFilters, 110);
            clearBtn.classList.toggle('hidden', !(search.value || '').length);
        });
        clearBtn?.addEventListener('click', () => {
            search.value = '';
            applyFilters();
            clearBtn.classList.add('hidden');
        });

        // Gender chips
        function setChipActive(btn) {
            chips.forEach(b => b.classList.remove('ring-2', 'ring-red-300', 'bg-red-50'));
            btn.classList.add('ring-2', 'ring-red-300', 'bg-red-50');
        }
        chips.forEach(btn => btn.addEventListener('click', () => {
            genderFilter = btn.dataset.gender;
            setChipActive(btn);
            applyFilters();
        }));
        // default active: All
        const allChip = chips.find(c => c.dataset.gender === 'all');
        allChip && setChipActive(allChip);

        // Upcoming toggle
        onlyUpcoming?.addEventListener('change', applyFilters);

        // Sort
        function sortRows() {
            const key = sortBy.value;
            const visible = rows.filter(r => r.style.display !== 'none');
            const hidden = rows.filter(r => r.style.display === 'none');

            visible.sort((a, b) => {
                const da = new Date(a.dataset.start);
                const db = new Date(b.dataset.start);
                return key === 'soonest' ? (da - db) : (db - da);
            });

            const container = list.querySelector('.divide-y');
            visible.forEach(r => container.appendChild(r));
            hidden.forEach(r => container.appendChild(r));
        }
        sortBy?.addEventListener('change', () => {
            sortRows();
        });

        // Initial
        applyFilters();
        sortRows();

        // Modals
        window.openModal = (id) => {
            const m = document.getElementById('modal-' + id);
            if (!m) return;
            m.classList.remove('hidden');
            m.setAttribute('aria-hidden', 'false');
            document.addEventListener('keydown', escClose);
        };
        window.closeModal = (id) => {
            const m = document.getElementById('modal-' + id);
            if (!m) return;
            m.classList.add('hidden');
            m.setAttribute('aria-hidden', 'true');
            document.removeEventListener('keydown', escClose);
        };

        function escClose(e) {
            if (e.key === 'Escape') {
                // close any open modal
                $$('#list [id^="modal-"]').forEach(m => {
                    if (!m.classList.contains('hidden')) m.classList.add('hidden');
                });
            }
        }
    </script>
</x-app-layout>
