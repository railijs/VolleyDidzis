{{-- resources/views/tournaments/show.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto mt-24 mb-64 px-4 sm:px-6 lg:px-8">
        @php
            $start = \Carbon\Carbon::parse($tournament->start_date);
            $end = \Carbon\Carbon::parse($tournament->end_date ?? $tournament->start_date);
            $showRange = $end && $end->ne($start);

            $apps = $tournament->applications->count();
            $max = $tournament->max_teams;
            $remaining = $max ? max(0, $max - $apps) : null;
            $isFull = $max ? $apps >= $max : false;

            $pct = $max ? min(100, round(($apps / max(1, $max)) * 100)) : null;
            $barColor = $pct >= 100 ? 'bg-red-500' : ($pct >= 80 ? 'bg-amber-500' : 'bg-green-500');

            $gender = $tournament->gender_type;
            $genderClass = match ($gender) {
                'men' => 'bg-blue-600 text-white',
                'women' => 'bg-pink-600 text-white',
                'mix' => 'bg-violet-600 text-white',
                default => 'bg-red-600 text-white',
            };
            $genderLabel = match ($gender) {
                'men' => 'Vīrieši',
                'women' => 'Sievietes',
                'mix' => 'Mix',
                default => 'Turnīrs',
            };

            $status = $tournament->status; // pending / active / completed
            $statusClass = match ($status) {
                'active' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
                'completed' => 'bg-gray-50 text-gray-800 ring-gray-200',
                default => 'bg-amber-50 text-amber-800 ring-amber-200',
            };
            $statusLabel = match ($status) {
                'active' => 'Aktīvs',
                'completed' => 'Pabeigts',
                default => 'Gaida sākumu',
            };

            // Champion
            $finalMatch = $tournament->matches()->orderByDesc('round')->first();
            $winnerName = $finalMatch?->winnerApplication()?->team_name;
        @endphp

        {{-- ===== HERO ===== --}}
        <section class="relative overflow-hidden rounded-2xl shadow-2xl mb-8">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/45 to-black/20"></div>
            <div class="absolute inset-0">
                <div class="w-full h-48 sm:h-56 bg-gradient-to-r from-red-700 via-red-600 to-red-500"></div>
            </div>

            <div class="relative z-10 p-5 sm:p-7">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                    <div class="text-white">
                        <p class="uppercase tracking-[0.2em] text-[11px] text-red-100/90 font-bold">Turnīrs</p>
                        <h1 class="mt-1 text-2xl sm:text-4xl font-extrabold leading-tight">
                            {{ $tournament->name }}
                        </h1>

                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-white/90">
                            <span>{{ $start->format('d.m.Y') }}@if ($showRange)
                                    – {{ $end->format('d.m.Y') }}
                                @endif
                            </span>
                            @if ($tournament->location)
                                <span class="opacity-70">•</span>
                                <span>{{ $tournament->location }}</span>
                            @endif
                            <span class="opacity-70">•</span>
                            <span>{{ $tournament->team_size }} spēlētāji</span>
                        </div>

                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-2 font-bold rounded-full ring-1 px-3 py-1 {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                            <span
                                class="inline-flex items-center gap-2 font-bold rounded-full px-3 py-1 {{ $genderClass }}">
                                {{ $genderLabel }}
                            </span>
                            @if ($isFull)
                                <span
                                    class="inline-flex items-center gap-2 font-bold rounded-full px-3 py-1 bg-red-600 text-white">
                                    Pilns
                                </span>
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

        {{-- ===== WINNER (slim ribbon under hero) ===== --}}
        @if (!empty($winnerName))
            <section class="mb-8">
                <div
                    class="rounded-2xl border border-amber-200/70 bg-gradient-to-br from-amber-50 via-yellow-50 to-amber-50 shadow-sm">
                    <div class="px-6 sm:px-8 py-5">
                        <p class="uppercase tracking-[0.2em] text-xs text-amber-700/90 font-black">
                            Turnīra uzvarētājs
                        </p>
                        <div class="mt-1 flex flex-wrap items-end justify-between gap-3">
                            <h3 class="text-2xl sm:text-3xl font-black text-amber-800">
                                {{ $winnerName }}
                            </h3>
                            <div
                                class="h-1 w-40 sm:w-56 rounded-full bg-gradient-to-r from-amber-300/70 via-yellow-300/60 to-amber-300/70">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ===== CONTROLS ===== --}}
        @if ($tournament->status === 'pending' && (auth()->id() === $tournament->creator_id || auth()->user()?->isAdmin()))
            <div class="mb-6 text-center">
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
            <div class="mb-6 text-center">
                <button type="button" onclick="document.getElementById('stop-modal').classList.remove('hidden')"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2.5 shadow transition">
                    Apturēt turnīru
                </button>
            </div>
        @endif

        {{-- ===== DETAILS ===== --}}
        <div class="rounded-2xl border border-slate-300/50 bg-white/80 backdrop-blur p-5 sm:p-7 mb-6 shadow">
            <div class="grid grid-cols-1 lg:grid-cols-[2fr,1fr] gap-6">
                {{-- Left: description + info --}}
                <div>
                    <p class="uppercase tracking-[0.2em] text-xs text-red-600/80 font-bold">Apraksts</p>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-3">Par turnīru</h2>
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
                            <div class="h-1.5 w-full rounded-full bg-slate-200/70 overflow-hidden">
                                <div class="h-full {{ $barColor }}" style="width: {{ $pct }}%"></div>
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
                    <p class="uppercase tracking-[0.2em] text-[11px] text-gray-600/90 font-bold">Kopsavilkums</p>
                    <h3 class="text-base font-extrabold text-gray-900 mb-2">Ātrā informācija</h3>
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
                                    <span
                                        class="ml-2 inline-flex items-center rounded-full bg-red-600 text-white px-2.5 py-0.5 text-xs font-bold">Pilns</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </aside>
            </div>
        </div>

        {{-- ===== Applicants (collapsible) ===== --}}
        @if ($tournament->applications->count())
            @php $startOpen = $tournament->status !== 'completed'; @endphp

            <div id="apps-collapsible" data-open="{{ $startOpen ? '1' : '0' }}"
                class="rounded-2xl border border-slate-300/50 bg-white/85 backdrop-blur shadow mb-6">
                <button type="button"
                    class="w-full px-4 py-3 sm:px-5 sm:py-4 flex items-center justify-between bg-slate-50/80"
                    onclick="window.__toggleApplicants()">
                    <div>
                        <p class="uppercase tracking-[0.2em] text-[11px] text-red-600/80 font-bold">Komandas</p>
                        <span class="text-sm font-extrabold text-gray-900">Pieteikušās komandas</span>
                    </div>
                    <span class="flex items-center gap-2">
                        <span
                            class="inline-flex items-center rounded-full bg-red-600 text-white px-2.5 py-0.5 text-xs font-bold">
                            {{ $tournament->applications->count() }}
                        </span>
                        <svg id="apps-arrow" class="w-4 h-4 text-gray-500 transition-transform duration-200 ease-out"
                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>

                <div id="apps-panel" class="{{ $startOpen ? '' : 'hidden' }}">
                    <div class="p-5 sm:p-7">
                        <ul class="divide-y divide-gray-200 text-sm">
                            @foreach ($tournament->applications as $applicant)
                                @php
                                    $canWithdraw =
                                        $tournament->status === 'pending' &&
                                        auth()->check() &&
                                        ($applicant->user_id === auth()->id() ||
                                            (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()));
                                @endphp
                                <li class="py-3 flex items-center justify-between">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">{{ $applicant->team_name }}</p>
                                        <p class="text-xs text-gray-500">
                                            Kapteinis: {{ $applicant->captain_name }}
                                            @if ($applicant->email)
                                                • <span class="text-gray-400">{{ $applicant->email }}</span>
                                            @endif
                                        </p>
                                    </div>

                                    @if ($canWithdraw)
                                        <button type="button"
                                            class="ml-3 inline-flex items-center rounded-full border border-red-200 text-red-700 hover:bg-red-50 px-3 py-1.5 text-xs font-semibold"
                                            onclick="window.__openWithdrawModal('{{ route('tournaments.applications.destroy', [$tournament, $applicant]) }}')">
                                            Atteikt
                                        </button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== Join Form (pending & not full) ===== --}}
        @php $isFull = $max ? $apps >= $max : false; @endphp

        @if ($tournament->status === 'pending' && !$isFull)
            <div id="join"
                class="rounded-2xl border border-red-300/60 bg-white/85 backdrop-blur p-5 sm:p-7 mb-8 shadow">
                <p class="uppercase tracking-[0.2em] text-xs text-red-600/80 font-bold">Pieteikums</p>
                <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-3">Pieteikties</h2>

                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('tournaments.join', $tournament) }}"
                    class="grid grid-cols-1 sm:grid-cols-2 gap-4" novalidate onsubmit="window.__rememberScroll()">
                    @csrf
                    <div class="sm:col-span-2">
                        <label for="team_name" class="block text-sm font-semibold text-gray-800">Komandas
                            nosaukums</label>
                        <input id="team_name" name="team_name" type="text" required
                            value="{{ old('team_name') }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>
                    <div>
                        <label for="captain_name" class="block text-sm font-semibold text-gray-800">Kapteiņa
                            vārds</label>
                        <input id="captain_name" name="captain_name" type="text" required
                            value="{{ old('captain_name') }}"
                            class="mt-1 w-full rounded-md border border-gray-300 px-3 py-2 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-800">E-pasts</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
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
            <div class="rounded-2xl border border-yellow-300 bg-yellow-50/80 p-5 sm:p-7 mb-8 text-yellow-900 shadow">
                Maksimālais komandu skaits ir sasniegts — pieteikumi <strong>slēgti</strong>.
            </div>
        @else
            <div class="rounded-2xl border border-yellow-300 bg-yellow-50/80 p-5 sm:p-7 mb-8 text-yellow-900 shadow">
                Turnīrs ir sācies vai beidzies — pieteikumi slēgti.
            </div>
        @endif

        {{-- ===== Bottom Actions ===== --}}
        <div class="mt-8 mb-40 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('tournaments.stats', $tournament) }}"
                class="inline-flex items-center justify-center rounded-full bg-white text-red-700 border border-red-200 px-5 py-2 font-semibold hover:bg-red-50 transition">
                Brakets →
            </a>
            <a href="{{ route('tournaments.statistics', $tournament) }}"
                class="inline-flex items-center justify-center rounded-full bg-white text-red-700 border border-red-200 px-5 py-2 font-semibold hover:bg-red-50 transition">
                Statistika →
            </a>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 shadow transition">
                ← Atpakaļ uz turnīriem
            </a>
        </div>

        {{-- Extra spacer --}}
        <div class="h-24"></div>

        {{-- ===== Withdraw Modal ===== --}}
        <div id="withdraw-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                onclick="document.getElementById('withdraw-modal').classList.add('hidden')"></div>
            <div class="relative z-10 max-w-md mx-auto my-10">
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <form id="withdraw-form" method="POST" action="#" onsubmit="window.__rememberScroll()">
                        @csrf
                        @method('DELETE')
                        <div class="p-6">
                            <h2 class="text-xl font-extrabold text-red-700 mb-2">Apstiprināt atteikšanos</h2>
                            <p class="text-gray-700 text-sm">
                                Vai tiešām <strong>atteikt</strong> šo pieteikumu? Šo darbību nevar atsaukt.
                            </p>
                            <div class="mt-5 flex items-center justify-end gap-2">
                                <button type="button"
                                    class="rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 text-sm font-semibold"
                                    onclick="document.getElementById('withdraw-modal').classList.add('hidden')">
                                    Atcelt
                                </button>
                                <button type="submit"
                                    class="rounded-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-semibold shadow">
                                    Atteikt
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== Delete Tournament Modal (admin) ===== --}}
        @if (auth()->user()?->isAdmin())
            <div id="delete-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                    onclick="document.getElementById('delete-modal').classList.add('hidden')"></div>
                <div class="relative z-10 max-w-md mx-auto my-10">
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-extrabold text-red-700 mb-2">Apstiprināt dzēšanu</h2>
                            <p class="text-gray-700 text-sm">
                                Vai tiešām dzēst <strong>{{ $tournament->name }}</strong>? Šī darbība ir
                                neatgriezeniska.
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
                            <p class="text-gray-700 text-sm">
                                Vai tiešām apturēt <strong>{{ $tournament->name }}</strong>? Pēc apturēšanas turnīrs
                                tiks atzīmēts kā <strong>pabeigts</strong>.
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

    {{-- JS: collapsible arrow + withdraw modal + scroll restore --}}
    <script>
        // Applicants collapsible
        window.__toggleApplicants = function() {
            const root = document.getElementById('apps-collapsible');
            const panel = document.getElementById('apps-panel');
            const arrow = document.getElementById('apps-arrow');
            const isOpen = root.getAttribute('data-open') === '1';
            if (isOpen) {
                panel.classList.add('hidden');
                arrow.classList.remove('rotate-180');
                root.setAttribute('data-open', '0');
            } else {
                panel.classList.remove('hidden');
                arrow.classList.add('rotate-180');
                root.setAttribute('data-open', '1');
            }
        };

        // Initialize arrow rotation based on default state
        (function initArrow() {
            const root = document.getElementById('apps-collapsible');
            const arrow = document.getElementById('apps-arrow');
            if (root && arrow && root.getAttribute('data-open') === '1') {
                arrow.classList.add('rotate-180');
            }
        })();

        // Withdraw modal open
        window.__openWithdrawModal = function(actionUrl) {
            const modal = document.getElementById('withdraw-modal');
            const form = document.getElementById('withdraw-form');
            form.setAttribute('action', actionUrl);
            modal.classList.remove('hidden');
        };

        // Preserve scroll position across POST redirect
        window.__rememberScroll = function() {
            try {
                sessionStorage.setItem('scrollY', String(window.scrollY || window.pageYOffset || 0));
            } catch (e) {}
        };

        document.addEventListener('DOMContentLoaded', () => {
            try {
                const y = sessionStorage.getItem('scrollY');
                if (y !== null) {
                    window.scrollTo({
                        top: parseInt(y, 10) || 0,
                        behavior: 'instant'
                    });
                    sessionStorage.removeItem('scrollY');
                }
            } catch (e) {}
        });
    </script>
</x-app-layout>
