<x-app-layout>
    <div class="max-w-6xl mx-auto mt-24 mb-24 px-4 sm:px-6 lg:px-8">

        {{-- ===== Styles (local) ===== --}}
        <style>
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .55s ease, transform .55s ease;
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none;
                }
            }

            .glass {
                background: rgba(255, 255, 255, .85);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(148, 163, 184, .35);
                border-radius: 1rem;
                box-shadow: 0 10px 20px rgba(0, 0, 0, .05);
                transition: border-color .25s, box-shadow .25s, transform .25s;
            }

            .glass:hover {
                border-color: rgba(148, 163, 184, .55);
                box-shadow: 0 16px 32px rgba(0, 0, 0, .08);
                transform: translateY(-2px);
            }

            .chip {
                display: inline-flex;
                align-items: center;
                gap: .4rem;
                font-weight: 700;
                padding: .3rem .6rem;
                border-radius: 9999px;
                font-size: .75rem
            }

            .chip-status-pending {
                background: #fff7ed;
                color: #9a3412;
                border: 1px solid #fed7aa
            }

            .chip-status-active {
                background: #ecfdf5;
                color: #065f46;
                border: 1px solid #a7f3d0
            }

            .chip-status-completed {
                background: #f3f4f6;
                color: #374151;
                border: 1px solid #e5e7eb
            }

            .pill-red {
                background: #dc2626;
                color: #fff
            }

            .pill-blue {
                background: #3b82f6;
                color: #fff
            }

            .pill-pink {
                background: #ec4899;
                color: #fff
            }

            .pill-purple {
                background: #8b5cf6;
                color: #fff
            }

            .progress-track {
                height: .45rem;
                background: rgba(203, 213, 225, .7);
                border-radius: 9999px;
                overflow: hidden
            }

            .progress-fill {
                height: 100%;
                background: linear-gradient(90deg, #22c55e, #16a34a)
            }

            .progress-fill.warning {
                background: linear-gradient(90deg, #f59e0b, #d97706)
            }

            .progress-fill.danger {
                background: linear-gradient(90deg, #ef4444, #dc2626)
            }

            /* Big champion banner */
            .champion {
                position: relative;
                overflow: hidden;
                border-radius: 1.25rem;
                border: 1px solid rgba(250, 204, 21, .45);
                background: radial-gradient(120% 120% at 0% 0%, rgba(250, 204, 21, .25), transparent 40%),
                    radial-gradient(120% 120% at 100% 0%, rgba(217, 119, 6, .2), transparent 45%),
                    linear-gradient(135deg, #fef3c7, #fffbeb);
                box-shadow: 0 12px 28px rgba(250, 204, 21, .15);
            }

            .champion .title {
                font-weight: 900;
                letter-spacing: .02em;
                text-transform: uppercase;
                color: #78350f;
            }

            .champion .name {
                font-weight: 900;
                color: #92400e;
                text-shadow: 0 1px 0 rgba(255, 255, 255, .6);
            }

            /* details/summary styling */
            details.card {
                border-radius: 1rem;
                border: 1px solid rgba(148, 163, 184, .35);
                background: rgba(255, 255, 255, .85);
                box-shadow: 0 10px 20px rgba(0, 0, 0, .05);
                overflow: hidden;
            }

            details.card>summary {
                list-style: none;
                cursor: pointer;
                padding: .9rem 1.1rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-weight: 800;
                color: #111827;
                background: rgba(249, 250, 251, .8);
            }

            details.card>summary::-webkit-details-marker {
                display: none;
            }

            .summary-pill {
                display: inline-flex;
                align-items: center;
                gap: .4rem;
                padding: .25rem .6rem;
                border-radius: 9999px;
                background: #ef4444;
                color: #fff;
                font-weight: 700;
                font-size: .75rem;
            }

            .summary-icon {
                transition: transform .25s ease;
            }

            details[open] .summary-icon {
                transform: rotate(180deg);
            }
        </style>

        @php
            $start = \Carbon\Carbon::parse($tournament->start_date);
            $end = \Carbon\Carbon::parse($tournament->end_date ?? $tournament->start_date);
            $showRange = $end && $end->ne($start);

            $apps = $tournament->applications->count();
            $max = $tournament->max_teams;
            $remaining = $max ? max(0, $max - $apps) : null;
            $isFull = $max ? $apps >= $max : false;

            $pct = $max ? min(100, round(($apps / max(1, $max)) * 100)) : null;
            $barClass = 'progress-fill';
            if (!is_null($pct)) {
                if ($pct >= 100) {
                    $barClass .= ' danger';
                } elseif ($pct >= 80) {
                    $barClass .= ' warning';
                }
            }

            $gender = $tournament->gender_type;
            $genderClass = match ($gender) {
                'men' => 'pill-blue',
                'women' => 'pill-pink',
                'mix' => 'pill-purple',
                default => 'pill-red',
            };
            $genderLabel = match ($gender) {
                'men' => 'Vīrieši',
                'women' => 'Sievietes',
                'mix' => 'Mix',
                default => 'Turnīrs',
            };

            $status = $tournament->status; // pending / active / completed
            $statusClass = match ($status) {
                'active' => 'chip chip-status-active',
                'completed' => 'chip chip-status-completed',
                default => 'chip chip-status-pending',
            };
            $statusLabel = match ($status) {
                'active' => 'Aktīvs',
                'completed' => 'Pabeigts',
                default => 'Gaida sākumu',
            };
        @endphp

        {{-- ===== HERO ===== --}}
        <section class="relative overflow-hidden rounded-2xl shadow-2xl mb-8 fade-up">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/45 to-black/20"></div>
            <div class="absolute inset-0">
                <div class="w-full h-48 sm:h-56 bg-gradient-to-r from-red-700 via-red-600 to-red-500"></div>
            </div>

            <div class="relative z-10 p-5 sm:p-7">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div class="text-white">
                        <h1 class="text-2xl sm:text-4xl font-extrabold leading-tight">
                            {{ $tournament->name }}
                        </h1>

                        <div class="mt-2 flex flex-wrap items-center gap-2 text-sm">
                            <span class="inline-flex items-center gap-1">
                                📅 {{ $start->format('d.m.Y') }}@if ($showRange)
                                    – {{ $end->format('d.m.Y') }}
                                @endif
                            </span>
                            @if ($tournament->location)
                                <span class="inline-flex items-center gap-1">• 📍 {{ $tournament->location }}</span>
                            @endif
                            <span class="inline-flex items-center gap-1">• 👥 {{ $tournament->team_size }}
                                spēlētāji</span>
                        </div>

                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                            <span class="chip {{ $genderClass }}">{{ $genderLabel }}</span>
                            @if ($isFull)
                                <span class="chip pill-red" title="Maksimālais komandu skaits sasniegts">Pilns</span>
                            @endif
                        </div>
                    </div>

                    {{-- Admin actions --}}
                    @if (auth()->user()?->isAdmin())
                        <div class="flex items-center gap-2">
                            <a href="{{ route('tournaments.edit', $tournament) }}"
                                class="inline-flex items-center rounded-full bg-white/90 hover:bg-white text-gray-900 px-4 py-2 text-sm font-semibold shadow">
                                Rediģēt
                            </a>

                            <button type="button"
                                onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                                class="inline-flex items-center rounded-full bg-white/90 hover:bg-white text-red-700 px-4 py-2 text-sm font-semibold shadow">
                                Dzēst
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- ===== BIG CHAMPION BANNER ===== --}}
        @if (!empty($winnerName))
            <section class="champion p-6 sm:p-8 mb-8 fade-up">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 text-4xl sm:text-5xl">🏆</div>
                    <div>
                        <div class="title text-sm tracking-widest">TURNĪRA UZVARĒTĀJS</div>
                        <div class="name text-2xl sm:text-4xl mt-1">{{ $winnerName }}</div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ===== Start / Stop controls (creator or admin) ===== --}}
        @if ($tournament->status === 'pending' && (auth()->id() === $tournament->creator_id || auth()->user()?->isAdmin()))
            <div class="mb-6 text-center fade-up">
                <form action="{{ route('tournaments.start', $tournament) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2.5 shadow transition">
                        Sākt turnīru
                    </button>
                </form>
            </div>
        @endif

        @if ($tournament->status === 'active' && (auth()->id() === $tournament->creator_id || auth()->user()?->isAdmin()))
            <div class="mb-6 text-center fade-up">
                <button type="button" onclick="document.getElementById('stop-modal').classList.remove('hidden')"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 shadow transition">
                    Apturēt turnīru
                </button>
            </div>
        @endif

        {{-- ===== DETAILS ===== --}}
        <div class="glass p-5 sm:p-7 mb-6 fade-up">
            <div class="grid grid-cols-1 lg:grid-cols-[2fr,1fr] gap-6">
                {{-- Left: description + info --}}
                <div>
                    <h2 class="text-lg font-extrabold text-gray-900 mb-3">Par turnīru</h2>
                    <p class="text-gray-800 leading-relaxed">
                        {{ $tournament->description ?? 'Apraksts nav pievienots.' }}
                    </p>

                    <div class="mt-5 grid gap-3 sm:grid-cols-2 text-sm text-gray-800">
                        <p><strong>Atrašanās vieta:</strong> {{ $tournament->location ?? 'TBA' }}</p>
                        <p>
                            <strong>Pieteikumi:</strong>
                            {{ $apps }} / {{ $max ?? 'Bez ierobežojuma' }}
                            @if ($remaining !== null && $remaining > 0)
                                (brīvas {{ $remaining }})
                            @elseif($isFull)
                                — <span class="font-semibold text-red-600">PILNS</span>
                            @endif
                        </p>
                        <p>
                            <strong>Dzimums:</strong>
                            @if ($tournament->gender_type === 'men')
                                Vīrieši
                            @elseif ($tournament->gender_type === 'women')
                                Sievietes
                            @else
                                Mix
                                @if ($tournament->min_boys || $tournament->min_girls)
                                    (min {{ $tournament->min_boys ?? 0 }} puiši, {{ $tournament->min_girls ?? 0 }}
                                    meitenes)
                                @endif
                            @endif
                        </p>
                        <p><strong>Spēlētāju skaits laukumā:</strong> {{ $tournament->team_size }}</p>

                        <p class="sm:col-span-2">
                            <strong>Vecuma ierobežojums:</strong>
                            @if ($tournament->min_age && $tournament->max_age)
                                {{ $tournament->min_age }}–{{ $tournament->max_age }} gadi
                            @elseif ($tournament->min_age)
                                Minimums {{ $tournament->min_age }} gadi
                            @elseif ($tournament->max_age)
                                Maksimums {{ $tournament->max_age }} gadi
                            @else
                                Nav
                            @endif
                        </p>

                        @if ($tournament->recommendations)
                            <p class="sm:col-span-2">
                                <strong>Ieteikumi:</strong> {{ $tournament->recommendations }}
                            </p>
                        @endif
                    </div>

                    @if (!is_null($pct))
                        <div class="mt-5 max-w-md">
                            <div class="progress-track" aria-hidden="true">
                                <div class="{{ $barClass }}" style="width: {{ $pct }}%"></div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Aizpildījums: {{ $apps }}/{{ $max }} ({{ $pct }}%)
                                @if ($isFull)
                                    — <span class="text-red-600 font-semibold">Maksimālais skaits sasniegts</span>
                                @endif
                            </p>
                        </div>
                    @endif

                    @if ($isFull && $tournament->status === 'pending')
                        <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            Pieteikumi ir <strong>slēgti</strong>: sasniegts maksimālais komandu skaits.
                        </div>
                    @endif
                </div>

                {{-- Right: quick facts --}}
                <aside class="rounded-xl border border-gray-200 bg-white/60 p-4 shadow-sm">
                    <h3 class="text-sm font-extrabold text-gray-900 mb-2">Ātrā informācija</h3>
                    <ul class="space-y-2 text-sm text-gray-800">
                        <li class="flex items-center justify-between">
                            <span>Datums</span>
                            <span class="font-semibold">
                                {{ $start->format('d.m.Y') }}@if ($showRange)
                                    – {{ $end->format('d.m.Y') }}
                                @endif
                            </span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Statuss</span>
                            <span class="font-semibold">{{ $statusLabel }}</span>
                        </li>
                        @if (!empty($winnerName))
                            <li class="flex items-center justify-between">
                                <span>Uzvarētājs</span>
                                <span class="font-semibold">{{ $winnerName }}</span>
                            </li>
                        @endif
                        <li class="flex items-center justify-between">
                            <span>Dzimums</span>
                            <span class="font-semibold">{{ $genderLabel }}</span>
                        </li>
                        @if ($tournament->location)
                            <li class="flex items-center justify-between">
                                <span>Vieta</span>
                                <span class="font-semibold">{{ $tournament->location }}</span>
                            </li>
                        @endif
                        <li class="flex items-center justify-between">
                            <span>Komandas</span>
                            <span class="font-semibold">
                                {{ $apps }} / {{ $max ?? '∞' }}
                                @if ($isFull)
                                    <span class="ml-2 chip pill-red">Pilns</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>

        {{-- ===== Applicants (collapsible) ===== --}}
        @if ($tournament->applications->count())
            @php
                // Ja turnīrs pabeigts -> noklusēti aizvērts; citādi atvērts
                $openAttr = $tournament->status === 'completed' ? '' : 'open';
            @endphp
            <details class="card mb-6 fade-up" {{ $openAttr }}>
                <summary>
                    <span>Pieteikušās komandas</span>
                    <span class="flex items-center gap-2">
                        <span class="summary-pill">{{ $tournament->applications->count() }}</span>
                        <svg class="summary-icon w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </summary>

                <div class="p-5 sm:p-7">
                    <ul class="divide-y divide-gray-200 text-sm">
                        @foreach ($tournament->applications as $applicant)
                            <li class="py-3 flex items-center justify-between">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $applicant->team_name }}</p>
                                    <p class="text-xs text-gray-500">Kapteinis: {{ $applicant->captain_name }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </details>
        @endif

        {{-- ===== Join Form (only when pending AND NOT full) ===== --}}
        @php $isFull = $max ? $apps >= $max : false; @endphp
        @if ($tournament->status === 'pending' && !$isFull)
            <div class="glass p-5 sm:p-7 mb-6 border-red-200 fade-up" style="border-color: rgba(248,113,113,.55);">
                <h2 class="text-lg font-extrabold text-gray-900 mb-3">Pieteikties</h2>

                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('tournaments.join', $tournament) }}"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div class="sm:col-span-2">
                        <label for="team_name" class="block text-sm font-semibold text-gray-800">Komandas
                            nosaukums</label>
                        <input id="team_name" name="team_name" type="text" required
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>
                    <div>
                        <label for="captain_name" class="block text-sm font-semibold text-gray-800">Kapteiņa
                            vārds</label>
                        <input id="captain_name" name="captain_name" type="text" required
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-800">E-pasts
                            saziņai</label>
                        <input id="email" name="email" type="email" required
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>
                    <div class="sm:col-span-2 flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 shadow transition">
                            Iesniegt pieteikumu
                        </button>
                    </div>
                </form>
            </div>
        @elseif ($tournament->status === 'pending' && $isFull)
            <div class="glass p-5 sm:p-7 mb-6 fade-up bg-yellow-50/80 border border-yellow-300 text-yellow-900">
                Maksimālais komandu skaits ir sasniegts — pieteikumi <strong>slēgti</strong>.
            </div>
        @else
            <div class="glass p-5 sm:p-7 mb-6 fade-up bg-yellow-50/80 border border-yellow-300 text-yellow-900">
                Turnīrs ir sācies vai beidzies — pieteikumi slēgti.
            </div>
        @endif

        {{-- ===== Bottom Actions ===== --}}
        <div class="mt-8 mb-16 flex flex-col sm:flex-row items-center justify-center gap-3 fade-up">
            <a href="{{ route('tournaments.stats', $tournament) }}"
                class="inline-flex items-center justify-center rounded-full bg-white text-red-700 border border-red-200 px-5 py-2 font-semibold hover:bg-red-50 transition">
                Turnīra statistika →
            </a>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 shadow transition">
                ← Atpakaļ uz turnīriem
            </a>
        </div>

        <div class="h-8"></div>

        {{-- ===== Delete Modal ===== --}}
        @if (auth()->user()?->isAdmin())
            <div id="delete-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                    onclick="document.getElementById('delete-modal').classList.add('hidden')"></div>
                <div class="relative z-10 max-w-md mx-auto my-10">
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-extrabold text-red-700 mb-2">Apstiprināt dzēšanu</h2>
                            <p class="text-gray-700 text-sm">Vai tiešām dzēst
                                <strong>{{ $tournament->name }}</strong>? Šī darbība ir neatgriezeniska.
                            </p>
                            <div class="mt-5 flex items-center justify-end gap-2">
                                <button type="button"
                                    class="rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 text-sm font-semibold"
                                    onclick="document.getElementById('delete-modal').classList.add('hidden')">
                                    Atcelt
                                </button>
                                <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="rounded-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-semibold shadow">
                                        Dzēst
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== Stop Modal ===== --}}
        @if ($tournament->status === 'active' && (auth()->id() === $tournament->creator_id || auth()->user()?->isAdmin()))
            <div id="stop-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                    onclick="document.getElementById('stop-modal').classList.add('hidden')"></div>
                <div class="relative z-10 max-w-md mx-auto my-10">
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-extrabold text-red-700 mb-2">Apstiprināt apturēšanu</h2>
                            <p class="text-gray-700 text-sm">Vai tiešām apturēt
                                <strong>{{ $tournament->name }}</strong>? Pēc apturēšanas turnīrs tiks atzīmēts kā
                                <strong>pabeigts</strong>.
                            </p>
                            <div class="mt-5 flex items-center justify-end gap-2">
                                <button type="button"
                                    class="rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 text-sm font-semibold"
                                    onclick="document.getElementById('stop-modal').classList.add('hidden')">
                                    Atcelt
                                </button>
                                <form action="{{ route('tournaments.stop', $tournament) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="rounded-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-semibold shadow">
                                        Apturēt
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- Load animation --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });
    </script>
</x-app-layout>
