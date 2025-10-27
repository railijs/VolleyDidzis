{{-- resources/views/tournaments/stats.blade.php --}}
<x-app-layout>
    @php
        // Group and order rounds 0..N
        $rounds = $matches->groupBy('round')->sortKeys();
        $finalRound = optional($rounds->keys())->max();
        $finalMatch = $matches->where('round', $finalRound)->first();
        $participants = $tournament->applications()->count();
        $matchCount = $matches->count();

        // Final helpers
        $aTeam = $finalMatch?->participantA?->team_name;
        $bTeam = $finalMatch?->participantB?->team_name;
        $aScr = $finalMatch?->score_a;
        $bScr = $finalMatch?->score_b;
        $finalDone = $finalMatch && $finalMatch->status === 'completed' && $finalMatch->winner_slot;
        $champion = $finalDone ? $finalMatch->winnerApplication()?->team_name : null;
        $finalistsKnown = (bool) ($aTeam || $bTeam);

        $isEditable = $tournament->status === 'active';

        function roundTitle(int $r, int $finalRound): string
        {
            if ($r === 0) {
                return 'Play-In';
            }
            if ($r === $finalRound) {
                return 'Final';
            }
            return "Round {$r}";
        }
        function statusBadge(string $status): array
        {
            return [
                'pending' => ['Gaida', 'bg-gray-100 text-gray-700'],
                'in_progress' => ['Notiek', 'bg-blue-50 text-blue-700'],
                'completed' => ['Pabeigts', 'bg-emerald-50 text-emerald-700'],
            ][$status] ?? ['—', 'bg-gray-100 text-gray-700'];
        }
    @endphp

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ========= BRACKET CSS POLISH (no JS changes needed) ========= --}}
    <style>
        :root {
            --vv-bg: #ffffff;
            --vv-rail: rgba(225, 29, 72, .28);
            /* rose-600 @ 28% */
            --vv-rail-strong: rgba(225, 29, 72, .55);
            --vv-shadow: 0 1px 1px rgba(0, 0, 0, .04), 0 16px 32px -20px rgba(0, 0, 0, .45);
            --vv-shadow-hover: 0 1px 1px rgba(0, 0, 0, .05), 0 18px 44px -16px rgba(225, 29, 72, .35);
        }

        /* Horizontal scroll area: soft edge shadows & nicer scrollbar */
        .bracket-wrap {
            position: relative;
            --edge: 28px;
            scroll-snap-type: x mandatory;
        }

        .bracket-wrap::before,
        .bracket-wrap::after {
            content: "";
            position: sticky;
            top: 0;
            bottom: 0;
            width: var(--edge);
            pointer-events: none;
            z-index: 20;
        }

        .bracket-wrap::before {
            left: 0;
            background: linear-gradient(to right, rgb(248 250 252), rgba(248, 250, 252, 0));
        }

        .bracket-wrap::after {
            right: 0;
            background: linear-gradient(to left, rgb(248 250 252), rgba(248, 250, 252, 0));
        }

        .bracket-wrap::-webkit-scrollbar {
            height: 10px;
        }

        .bracket-wrap::-webkit-scrollbar-track {
            background: transparent;
        }

        .bracket-wrap::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, .15);
            border-radius: 999px;
        }

        .bracket-wrap::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, .22);
        }

        /* The grid holding columns */
        .bracket-grid {
            gap: 3rem;
            /* matches Tailwind gap-12 */
        }

        /* Each round column gets a subtle vertical "rail" that flows into the next column */
        .round-col {
            position: relative;
        }

        .round-col::after {
            /* place the rail into the inter-column gap (half of gap-12 ≈ 24px) */
            content: "";
            position: absolute;
            top: 8px;
            bottom: 8px;
            right: -24px;
            width: 1px;
            background:
                repeating-linear-gradient(to bottom,
                    var(--vv-rail),
                    var(--vv-rail) 12px,
                    transparent 12px,
                    transparent 22px);
            opacity: .85;
        }

        /* Hide rail after the last column (final) */
        .round-col:last-child::after {
            display: none;
        }

        /* Sticky round chips feel more "anchored" and readable */
        .round-chip {
            box-shadow: 0 4px 14px -6px rgba(225, 29, 72, .35);
            border: 1px solid rgba(225, 29, 72, .25);
            backdrop-filter: blur(6px);
        }

        /* Match cards: add status-colored accent, better hover/focus & connector stubs */
        .match-card {
            position: relative;
            background: var(--vv-bg);
            box-shadow: var(--vv-shadow);
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
            isolation: isolate;
            /* keep pseudo elems tucked */
        }

        /* left accent stripe reacts to status */
        .match-card::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 3px;
            background: var(--accent, var(--vv-rail-strong));
        }

        .match-card[data-status="pending"] {
            --accent: #9ca3af;
        }

        /* gray-400 */
        .match-card[data-status="in_progress"] {
            --accent: #2563eb;
        }

        /* blue-600 */
        .match-card[data-status="completed"] {
            --accent: #059669;
        }

        /* emerald-600 */

        /* outbound connector stub (to next column) */
        .match-card::after {
            content: "";
            position: absolute;
            top: 50%;
            right: -24px;
            /* half of gap */
            width: 24px;
            height: 1px;
            background: var(--vv-rail-strong);
            transform: translateY(-50%);
            opacity: .8;
        }

        /* no outbound for final column */
        .round-col:last-child .match-card::after {
            display: none;
        }

        /* inbound stub for non-first columns, purely decorative */
        .round-col:not(:first-child) .match-card>.inbound {
            content: "";
            position: absolute;
            top: 50%;
            left: -24px;
            width: 24px;
            height: 1px;
            background: var(--vv-rail);
            transform: translateY(-50%);
            opacity: .6;
        }

        /* Hover / highlight pairing (works with your JS ring-2 class too) */
        .match-card:hover {
            transform: translateY(-1px);
            box-shadow: var(--vv-shadow-hover);
        }

        .match-card.ring-2 {
            transform: translateY(-1px) scale(1.01);
            box-shadow: 0 0 0 2px rgba(225, 29, 72, .2), 0 18px 44px -16px rgba(225, 29, 72, .45);
        }

        /* Status chip stays tidy on tiny screens */
        .status-chip {
            white-space: nowrap;
        }

        /* Feed line text looks like an inline chip with dotted underline */
        .feed-line {
            padding: 2px 6px;
            border-radius: 999px;
            background: rgba(244, 63, 94, .06);
            border: 1px dashed rgba(244, 63, 94, .35);
        }

        .match-card:hover .feed-line {
            background: rgba(244, 63, 94, .1);
        }

        /* Winner rows get a subtle, consistent look (works with your JS toggling) */
        .match-card .row-A,
        .match-card .row-B {
            transition: background-color .18s ease, color .18s ease;
        }

        .match-card[data-winner-slot="A"] .row-A,
        .match-card .row-A.bg-emerald-50 {
            background: #ecfdf5;
        }

        .match-card[data-winner-slot="B"] .row-B,
        .match-card .row-B.bg-emerald-50 {
            background: #ecfdf5;
        }

        /* Score inputs: remove number spinners, make them feel crisp and tappable */
        .score-input {
            font-variant-numeric: tabular-nums;
            transition: box-shadow .16s ease, border-color .16s ease, background-color .16s ease;
        }

        .score-input:focus {
            box-shadow: 0 0 0 3px rgba(252, 165, 165, .35);
            /* red-300 glow */
            background: #fff;
        }

        .score-input::-webkit-outer-spin-button,
        .score-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .score-input[type=number] {
            -moz-appearance: textfield;
        }

        /* Saving indicator: tiny CSS dot animation */
        .save-dot::after {
            content: " • • •";
            letter-spacing: 2px;
            display: inline-block;
            width: 2.2em;
            animation: ellipses 1.2s infinite steps(4, end);
            overflow: hidden;
            vertical-align: baseline;
        }

        @keyframes ellipses {
            0% {
                width: 0
            }

            100% {
                width: 2.2em
            }
        }

        /* Print: clean bracket for exports */
        @media print {
            .bracket-wrap {
                overflow: visible !important;
            }

            .bracket-wrap::before,
            .bracket-wrap::after {
                display: none;
            }

            .match-card {
                box-shadow: none;
                border-color: #ddd !important;
            }

            header .start,
            header button {
                display: none !important;
            }

            .feed-line {
                color: #666;
                background: transparent;
                border: 0;
                text-decoration: underline dotted;
            }

            .round-chip {
                position: static;
            }
        }
    </style>

    <div class="max-w-full mx-auto mt-20 sm:mt-24 px-4 sm:px-6 lg:px-8">

        {{-- Header (compact) --}}
        <header class="mb-6">
            <div
                class="rounded-2xl text-white shadow-2xl ring-1 ring-white/20 bg-gradient-to-br from-red-700 via-red-600 to-red-700">
                <div class="p-5 sm:p-7 flex flex-col gap-4">
                    <div class="flex items-center gap-3 justify-center md:justify-start">
                        <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV"
                            class="h-10 w-10 sm:h-12 sm:w-12 object-contain select-none" />
                        <h1
                            class="text-3xl sm:text-5xl font-black leading-tight drop-shadow-sm text-center md:text-left">
                            {{ $tournament->name }}
                        </h1>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 text-sm justify-center md:justify-start">
                        <span
                            class="inline-flex items-center gap-2 font-bold rounded-full border border-white/25 bg-white/15 text-white px-3 py-1 shadow-sm">
                            {{ $tournament->status === 'active' ? '🟢' : ($tournament->status === 'completed' ? '⚪' : '🟠') }}
                            Status: {{ ucfirst($tournament->status) }}
                        </span>
                        <span
                            class="inline-flex items-center gap-2 font-bold rounded-full border border-white/25 bg-white/10 text-red-50 px-3 py-1">
                            👥 Dalībnieki: {{ $participants }}
                        </span>
                        <span
                            class="inline-flex items-center gap-2 font-bold rounded-full border border-white/25 bg-white/10 text-red-50 px-3 py-1">
                            🎮 Spēles: {{ $matchCount }}
                        </span>

                        @if (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin()))
                            @if ($tournament->status === 'pending')
                                <form action="{{ route('tournaments.start', $tournament) }}" method="POST"
                                    class="ml-auto">
                                    @csrf
                                    <button type="submit"
                                        class="start rounded-full bg-emerald-500/90 hover:bg-emerald-500 text-white px-4 py-2 text-sm font-bold shadow">
                                        Sākt
                                    </button>
                                </form>
                            @elseif ($tournament->status === 'active')
                                <button type="button"
                                    onclick="document.getElementById('stop-modal').classList.remove('hidden')"
                                    class="ml-auto rounded-full bg-red-500/90 hover:bg-red-500 text-white px-4 py-2 text-sm font-bold shadow">
                                    ⏹ Apturēt
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </header>

        {{-- Final banner --}}
        @if ($finalMatch)
            <section class="mb-6 sm:mb-8 flex justify-center">
                {{-- NB: ieliku data-final-match-id. Ja tas kaut kur iztrūkst, skripts pats atradīs finālu ar fallback. --}}
                <div class="w-full max-w-3xl" id="final-container" data-final-match-id="{{ $finalMatch->id }}">
                    @if ($finalDone && $champion)
                        <div
                            class="rounded-2xl ring-1 ring-yellow-300/60 bg-gradient-to-br from-amber-100 via-yellow-50 to-amber-50 shadow">
                            <div class="px-6 sm:px-8 py-5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl">🏆</span>
                                    <div>
                                        <div
                                            class="text-[11px] sm:text-xs font-black tracking-widest uppercase text-amber-900/80">
                                            Turnīra uzvarētājs</div>
                                        <div class="text-xl sm:text-2xl font-black text-amber-900 truncate"
                                            title="{{ $champion }}">
                                            {{ \Illuminate\Support\Str::limit($champion, 64, '…') }}</div>
                                    </div>
                                </div>
                                <div class="text-amber-900/80 text-sm tabular-nums">{{ $aScr }} –
                                    {{ $bScr }}</div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-2xl border border-gray-200 bg-white/90 shadow-sm overflow-hidden">
                            <div class="px-6 py-3 flex items-center justify-between">
                                <div class="text-[11px] sm:text-xs uppercase tracking-[0.2em] text-gray-600 font-bold">
                                    Fināls</div>
                                <div class="text-xs text-gray-600">⏳ Notiek / gaida</div>
                            </div>
                            <div class="px-6 pb-5 grid grid-cols-5 items-center gap-3">
                                <div class="col-span-2 text-right">
                                    <div class="text-base sm:text-xl font-black text-gray-900 truncate"
                                        title="{{ $aTeam ?? '—' }}">{{ $aTeam ?? '—' }}</div>
                                    <div class="mt-0.5 text-gray-500 tabular-nums">
                                        {{ is_numeric($aScr) ? $aScr : '–' }}</div>
                                </div>
                                <div class="col-span-1 text-center text-[10px] uppercase tracking-widest text-gray-400">
                                    VS</div>
                                <div class="col-span-2 text-left">
                                    <div class="text-base sm:text-xl font-black text-gray-900 truncate"
                                        title="{{ $bTeam ?? '—' }}">{{ $bTeam ?? '—' }}</div>
                                    <div class="mt-0.5 text-gray-500 tabular-nums">
                                        {{ is_numeric($bScr) ? $bScr : '–' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
                <strong>Kļūda:</strong>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <div class="mt-1 text-xs text-red-700">
                    Sets tiek uzvarēts pie 25 ar +2. Ja 24–24, turpina līdz +2 (26–24, 27–25, …).
                </div>
            </div>
        @endif

        {{-- BRACKET --}}
        @if ($matches->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white/80 p-6 text-center shadow-sm">
                <div class="text-gray-900 font-extrabold text-lg mb-1">Nav spēļu</div>
                <p class="text-gray-600">Sāc turnīru, lai ģenerētu tīklāju.</p>
            </div>
        @else
            <div class="bracket-wrap overflow-x-auto rounded-xl p-4 sm:p-6
                        bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.04)_1px,transparent_0)] bg-[size:18px_18px]
                        snap-x snap-mandatory"
                role="region" aria-label="Turnīra tīklājs">
                <div class="w-fit mx-auto">
                    <div class="bracket-grid grid grid-flow-col auto-cols-[280px] gap-12 justify-center">

                        @foreach ($rounds as $roundNumber => $roundMatches)
                            <div class="round-col w-[280px] flex flex-col items-stretch gap-4 snap-start"
                                data-round="{{ $roundNumber }}">
                                <div
                                    class="round-chip sticky top-2 z-10 self-start mb-1 inline-flex items-center gap-2 rounded-full bg-white/80 ring-1 ring-gray-200 px-3 py-1 font-extrabold text-[0.9rem] text-red-700 shadow-sm backdrop-blur">
                                    <span
                                        class="h-1.5 w-1.5 rounded-full {{ $roundNumber === $finalRound ? 'bg-amber-500' : ($roundNumber === 0 ? 'bg-rose-400' : 'bg-rose-500') }}"></span>
                                    {{ roundTitle($roundNumber, $finalRound) }}
                                </div>

                                <div
                                    class="w-[280px] h-[100%] flex flex-col items-stretch gap-4 snap-start justify-around">
                                    @foreach ($roundMatches->sortBy('index_in_round') as $m)
                                        @php
                                            $hasA = (bool) $m->participant_a_application_id;
                                            $hasB = (bool) $m->participant_b_application_id;
                                            $disabled = !($hasA && $hasB) || !$isEditable;
                                            [$label, $cls] = statusBadge($m->status);
                                        @endphp

                                        <article
                                            class="match-card group relative rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden transition"
                                            data-match-id="{{ $m->id }}"
                                            data-next-match-id="{{ $m->next_match_id ?? '' }}"
                                            data-next-slot="{{ $m->next_slot ?? '' }}"
                                            data-status="{{ $m->status }}"
                                            data-winner-slot="{{ $m->winner_slot ?? '' }}">
                                            {{-- decorative inbound stub for non-first columns --}}
                                            <i class="inbound" aria-hidden="true"></i>

                                            <header class="flex items-center justify-between px-3 py-1 border-b">
                                                <div class="text-[11px] font-semibold inline-flex items-center gap-2">
                                                    <span
                                                        class="status-chip inline-flex items-center px-2 py-0.5 rounded-full ring-1 ring-black/5 {{ $cls }}">
                                                        {{ $label }}
                                                    </span>
                                                    @if ($m->winner_slot)
                                                        <span class="winner-chip text-emerald-700">Uzv.:
                                                            {{ $m->winner_slot }}</span>
                                                    @else
                                                        <span class="winner-chip hidden text-emerald-700"></span>
                                                    @endif
                                                    @unless ($isEditable)
                                                        <span class="text-gray-500">· slēgts</span>
                                                    @endunless
                                                </div>
                                                <div class="text-[10px] text-gray-500">#{{ $m->id }}</div>
                                            </header>

                                            <div class="divide-y divide-gray-200 text-[13px]">
                                                {{-- A --}}
                                                <div
                                                    class="row-A flex items-center justify-between px-3 py-1 {{ $m->winner_slot === 'A' ? 'bg-emerald-50 font-semibold text-emerald-800' : '' }}">
                                                    <span class="truncate" data-team="A">
                                                        {{ $m->participantA?->team_name ?? ($hasB ? 'Gaida pretinieku' : '—') }}
                                                    </span>
                                                    <input type="number" inputmode="numeric" min="0"
                                                        max="{{ \App\Http\Controllers\TournamentMatchController::MAX_POINTS }}"
                                                        class="score-input w-12 rounded-md border border-gray-300 px-2 py-1 text-right tabular-nums focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400 disabled:bg-gray-50 disabled:text-gray-400"
                                                        value="{{ is_numeric($m->score_a) ? $m->score_a : '' }}"
                                                        placeholder="0"
                                                        data-url="{{ route('tournaments.updateMatchScore', [$tournament, $m]) }}"
                                                        data-match-id="{{ $m->id }}" data-side="A"
                                                        {{ $disabled ? 'disabled' : '' }}
                                                        title="{{ $disabled ? ($isEditable ? 'Gaida pretinieku' : 'Turnīrs slēgts') : 'Ievadi punktus' }}" />
                                                </div>
                                                {{-- B --}}
                                                <div
                                                    class="row-B flex items-center justify-between px-3 py-1 {{ $m->winner_slot === 'B' ? 'bg-emerald-50 font-semibold text-emerald-800' : '' }}">
                                                    <span class="truncate" data-team="B">
                                                        {{ $m->participantB?->team_name ?? ($hasA ? 'Gaida pretinieku' : '—') }}
                                                    </span>
                                                    <input type="number" inputmode="numeric" min="0"
                                                        max="{{ \App\Http\Controllers\TournamentMatchController::MAX_POINTS }}"
                                                        class="score-input w-12 rounded-md border border-gray-300 px-2 py-1 text-right tabular-nums focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400 disabled:bg-gray-50 disabled:text-gray-400"
                                                        value="{{ is_numeric($m->score_b) ? $m->score_b : '' }}"
                                                        placeholder="0"
                                                        data-url="{{ route('tournaments.updateMatchScore', [$tournament, $m]) }}"
                                                        data-match-id="{{ $m->id }}" data-side="B"
                                                        {{ $disabled ? 'disabled' : '' }}
                                                        title="{{ $disabled ? ($isEditable ? 'Gaida pretinieku' : 'Turnīrs slēgts') : 'Ievadi punktus' }}" />
                                                </div>

                                                <footer
                                                    class="px-3 py-1 text-[12px] flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <span class="save-dot hidden"
                                                            id="saving-{{ $m->id }}">Saglabā</span>
                                                        <span class="save-ok hidden text-emerald-700"
                                                            id="saved-{{ $m->id }}">Saglabāts ✓</span>
                                                        <span class="save-err hidden text-red-700"
                                                            id="error-{{ $m->id }}">Kļūda — pārbaudi
                                                            punktus</span>
                                                    </div>

                                                    @if ($m->next_match_id)
                                                        <span
                                                            class="feed-line text-[11px] text-rose-700 underline decoration-dotted underline-offset-2 select-none cursor-pointer"
                                                            data-from="{{ $m->id }}"
                                                            data-to="{{ $m->next_match_id }}"
                                                            data-slot="{{ $m->next_slot }}">
                                                            → Winner → #{{ $m->next_match_id }} ({{ $m->next_slot }})
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400 text-[11px]">—</span>
                                                    @endif
                                                </footer>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- STOP modal --}}
    @if (
        $tournament->status === 'active' &&
            (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin())))
        <div id="stop-modal" class="fixed inset-0 z-50 hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                onclick="document.getElementById('stop-modal').classList.add('hidden')"></div>
            <div class="relative z-10 max-w-md mx-auto my-10">
                <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden">
                    <form action="{{ route('tournaments.stop', $tournament) }}" method="POST">
                        @csrf
                        <div class="p-6">
                            <h2 class="text-xl font-extrabold text-red-700 mb-2">Apstiprināt apturēšanu</h2>
                            <p class="text-gray-700 text-sm">Vai tiešām apturēt
                                <strong>{{ $tournament->name }}</strong>? Pēc apturēšanas turnīrs tiks atzīmēts kā
                                <strong>pabeigts</strong>.
                            </p>
                            <div class="mt-5 flex items-center justify-end gap-2">
                                <button type="button"
                                    class="rounded-full border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 text-sm font-semibold"
                                    onclick="document.getElementById('stop-modal').classList.add('hidden')">Atcelt</button>
                                <button type="submit"
                                    class="rounded-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 text-sm font-semibold shadow">Apturēt</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- JS: autosave + live winner propagation + robust final banner sync with fallback --}}
    <script>
        (function() {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const finalRoot = document.getElementById('final-container');
            const isEditable = {{ $isEditable ? 'true' : 'false' }};

            const STATUS_MAP = {
                pending: {
                    label: 'Gaida',
                    cls: 'bg-gray-100 text-gray-700'
                },
                in_progress: {
                    label: 'Notiek',
                    cls: 'bg-blue-50 text-blue-700'
                },
                completed: {
                    label: 'Pabeigts',
                    cls: 'bg-emerald-50 text-emerald-700'
                },
            };

            const cards = Array.from(document.querySelectorAll('.match-card'));
            const byId = new Map(cards.map(c => [String(c.dataset.matchId), c]));

            function el(q, root = document) {
                return root.querySelector(q);
            }

            function els(q, root = document) {
                return Array.from(root.querySelectorAll(q));
            }

            // --- FINAL ID: read from container OR auto-detect (fallback) ---
            function findFinalMatchId() {
                const explicit = finalRoot?.dataset?.finalMatchId;
                if (explicit && String(explicit).trim() !== '') return String(explicit);
                const noNext = cards.filter(c => !(c.dataset.nextMatchId && c.dataset.nextMatchId.trim()));
                if (noNext.length === 1) return String(noNext[0].dataset.matchId);
                if (noNext.length > 1) {
                    let best = null,
                        bestRound = -Infinity;
                    noNext.forEach(c => {
                        const col = c.closest('[data-round]');
                        const r = col ? parseInt(col.dataset.round, 10) : 0;
                        if (r > bestRound) {
                            bestRound = r;
                            best = c;
                        }
                    });
                    if (best) return String(best.dataset.matchId);
                }
                let best = null,
                    bestRound = -Infinity;
                cards.forEach(c => {
                    const col = c.closest('[data-round]');
                    const r = col ? parseInt(col.dataset.round, 10) : 0;
                    if (r > bestRound) {
                        bestRound = r;
                        best = c;
                    }
                });
                return best ? String(best.dataset.matchId) : '';
            }
            const FINAL_ID = findFinalMatchId();

            // --- Highlight wiring (unchanged) ---
            function clearHL() {
                cards.forEach(c => c.classList.remove('ring-2', 'ring-red-400', 'bg-red-50/50'));
            }

            function highlightPair(fromId, toId) {
                clearHL();
                const a = byId.get(String(fromId));
                const b = byId.get(String(toId));
                if (a) a.classList.add('ring-2', 'ring-red-400', 'bg-red-50/50');
                if (b) b.classList.add('ring-2', 'ring-red-400', 'bg-red-50/50');
                if (b) b.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                    inline: 'center'
                });
            }
            cards.forEach(card => {
                card.addEventListener('click', e => {
                    if (e.target.closest('input')) return;
                    const to = card.dataset.nextMatchId;
                    if (to) highlightPair(card.dataset.matchId, to);
                });
            });
            document.addEventListener('click', e => {
                const feed = e.target.closest('.feed-line');
                if (!feed) return;
                e.preventDefault();
                highlightPair(feed.dataset.from, feed.dataset.to);
            });

            // --- UI helpers ---
            function updateStatusUI(card, status) {
                card.dataset.status = status || '';
                const chip = el('.status-chip', card);
                const map = STATUS_MAP[status] || STATUS_MAP.pending;
                if (chip) {
                    chip.className =
                        'status-chip inline-flex items-center px-2 py-0.5 rounded-full ring-1 ring-black/5';
                    chip.classList.add(...map.cls.split(' '));
                    chip.textContent = map.label;
                }
            }

            function setRowWinnerUI(card, slotOrNull) {
                const aRow = el('.row-A', card);
                const bRow = el('.row-B', card);
                [aRow, bRow].forEach(r => r && r.classList.remove('bg-emerald-50', 'text-emerald-800',
                    'font-semibold'));
                card.dataset.winnerSlot = slotOrNull || '';
                let chip = el('.winner-chip', card);
                if (!chip) {
                    chip = document.createElement('span');
                    chip.className = 'winner-chip text-emerald-700';
                    const headerLeft = card.querySelector('header div');
                    if (headerLeft) headerLeft.appendChild(chip);
                }
                if (slotOrNull === 'A') {
                    aRow && aRow.classList.add('bg-emerald-50', 'text-emerald-800', 'font-semibold');
                    chip.textContent = 'Uzv.: A';
                    chip.classList.remove('hidden');
                } else if (slotOrNull === 'B') {
                    bRow && bRow.classList.add('bg-emerald-50', 'text-emerald-800', 'font-semibold');
                    chip.textContent = 'Uzv.: B';
                    chip.classList.remove('hidden');
                } else {
                    chip.textContent = '';
                    chip.classList.add('hidden');
                }
            }

            function setTeamLabel(nextCard, slot, name) {
                const lbl = el(`[data-team="${slot}"]`, nextCard);
                if (lbl) lbl.textContent = name ?? '—';
            }

            function enableDisableInputs(card) {
                const aLbl = el('[data-team="A"]', card)?.textContent?.trim() || '';
                const bLbl = el('[data-team="B"]', card)?.textContent?.trim() || '';
                const hasA = !!aLbl && aLbl !== '—' && aLbl !== 'Gaida pretinieku';
                const hasB = !!bLbl && bLbl !== '—' && bLbl !== 'Gaida pretinieku';
                const lock = !(hasA && hasB) || !isEditable;
                const aInp = el('input[data-side="A"]', card);
                const bInp = el('input[data-side="B"]', card);
                if (aInp) aInp.disabled = lock;
                if (bInp) bInp.disabled = lock;
            }

            // --- Final banner render (DOM-driven) ---
            function renderFinalBannerFromDOM() {
                if (!finalRoot || !FINAL_ID) return;
                const finalCard = byId.get(String(FINAL_ID));
                if (!finalCard) return;

                const aName = (el('[data-team="A"]', finalCard)?.textContent || '—').trim();
                const bName = (el('[data-team="B"]', finalCard)?.textContent || '—').trim();
                const aScore = el('input[data-side="A"]', finalCard)?.value || '–';
                const bScore = el('input[data-side="B"]', finalCard)?.value || '–';
                const winnerSlot = finalCard.dataset.winnerSlot || '';

                if (winnerSlot) {
                    const champion = winnerSlot === 'A' ? aName : bName;
                    finalRoot.innerHTML = `
                        <div class="rounded-2xl ring-1 ring-yellow-300/60 bg-gradient-to-br from-amber-100 via-yellow-50 to-amber-50 shadow">
                            <div class="px-6 sm:px-8 py-5 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl">🏆</span>
                                    <div>
                                        <div class="text-[11px] sm:text-xs font-black tracking-widest uppercase text-amber-900/80">Turnīra uzvarētājs</div>
                                        <div class="text-xl sm:text-2xl font-black text-amber-900 truncate" title="${champion}">${champion}</div>
                                    </div>
                                </div>
                                <div class="text-amber-900/80 text-sm tabular-nums">${aScore || '–'} – ${bScore || '–'}</div>
                            </div>
                        </div>
                    `;
                } else if ((aName && aName !== '—') || (bName && bName !== '—')) {
                    finalRoot.innerHTML = `
                        <div class="rounded-2xl border border-gray-200 bg-white/90 shadow-sm overflow-hidden">
                            <div class="px-6 py-3 flex items-center justify-between">
                                <div class="text-[11px] sm:text-xs uppercase tracking-[0.2em] text-gray-600 font-bold">Fināls</div>
                                <div class="text-xs text-gray-600">⏳ Notiek / gaida</div>
                            </div>
                            <div class="px-6 pb-5 grid grid-cols-5 items-center gap-3">
                                <div class="col-span-2 text-right">
                                    <div class="text-base sm:text-xl font-black text-gray-900 truncate" title="${aName || '—'}">${aName || '—'}</div>
                                    <div class="mt-0.5 text-gray-500 tabular-nums">${aScore || '–'}</div>
                                </div>
                                <div class="col-span-1 text-center text-[10px] uppercase tracking-widest text-gray-400">VS</div>
                                <div class="col-span-2 text-left">
                                    <div class="text-base sm:text-xl font-black text-gray-900 truncate" title="${bName || '—'}">${bName || '—'}</div>
                                    <div class="mt-0.5 text-gray-500 tabular-nums">${bScore || '–'}</div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    finalRoot.innerHTML =
                        `<div class="rounded-2xl border border-gray-200 bg-white/90 shadow-sm px-6 py-4 text-sm text-gray-500">Finālisti drīzumā…</div>`;
                }
            }

            (function attachFinalObservers() {
                if (!FINAL_ID) return;
                const card = byId.get(String(FINAL_ID));
                if (!card) return;

                const attrObserver = new MutationObserver(renderFinalBannerFromDOM);
                attrObserver.observe(card, {
                    attributes: true,
                    attributeFilter: ['data-winner-slot']
                });

                const textObserver = new MutationObserver(renderFinalBannerFromDOM);
                textObserver.observe(card, {
                    subtree: true,
                    characterData: true,
                    childList: true
                });

                els('input[data-side]', card).forEach(inp => {
                    inp.addEventListener('input', renderFinalBannerFromDOM);
                    inp.addEventListener('change', renderFinalBannerFromDOM);
                });

                renderFinalBannerFromDOM();
            })();

            // --- Autosave + server sync (unchanged) ---
            if (!isEditable) return;

            const inputs = els('.score-input');
            const cache = new Map(); // matchId -> {A:null|int, B:null|int}
            const timers = new Map();

            // seed cache
            inputs.forEach(inp => {
                const id = inp.dataset.matchId,
                    side = inp.dataset.side;
                const v = inp.value === '' ? null : Number(inp.value);
                const prev = cache.get(id) || {
                    A: null,
                    B: null
                };
                prev[side] = v;
                cache.set(id, prev);
            });

            function setState(id, state) {
                const saving = el('#saving-' + id),
                    ok = el('#saved-' + id),
                    err = el('#error-' + id);
                [saving, ok, err].forEach(x => x && x.classList.add('hidden'));
                if (state === 'saving') saving?.classList.remove('hidden');
                if (state === 'ok') ok?.classList.remove('hidden');
                if (state === 'err') err?.classList.remove('hidden');
            }

            function validPair(p) {
                return Number.isInteger(p.A) && Number.isInteger(p.B);
            }

            function updateStatus(card, status) {
                updateStatusUI(card, status);
            }

            function applyMatchUpdate(m) {
                const card = byId.get(String(m.id));
                if (!card) return;

                const aLbl = el('[data-team="A"]', card);
                const bLbl = el('[data-team="B"]', card);
                if (aLbl && typeof m.a_name !== 'undefined') aLbl.textContent = m.a_name ?? 'Gaida pretinieku';
                if (bLbl && typeof m.b_name !== 'undefined') bLbl.textContent = m.b_name ?? 'Gaida pretinieku';

                const aInp = el('input[data-side="A"]', card);
                const bInp = el('input[data-side="B"]', card);
                if (aInp && typeof m.score_a !== 'undefined') aInp.value = (m.score_a ?? '');
                if (bInp && typeof m.score_b !== 'undefined') bInp.value = (m.score_b ?? '');

                if (m.status) updateStatus(card, m.status);
                setRowWinnerUI(card, m.winner_slot || null);
                enableDisableInputs(card);

                // Propagate to next
                if (m.winner_slot && m.next_match_id && m.next_slot) {
                    const nextCard = byId.get(String(m.next_match_id));
                    if (nextCard) {
                        const winnerName = m.winner_slot === 'A' ?
                            (m.a_name ?? aLbl?.textContent) :
                            (m.b_name ?? bLbl?.textContent);
                        setTeamLabel(nextCard, m.next_slot, (winnerName || '—'));
                        enableDisableInputs(nextCard);
                        if (String(m.next_match_id) === String(FINAL_ID)) renderFinalBannerFromDOM();
                    }
                }

                if (String(m.id) === String(FINAL_ID)) renderFinalBannerFromDOM();
            }

            function syncFromResponse(data) {
                if (Array.isArray(data.matches)) {
                    data.matches.forEach(applyMatchUpdate);
                } else if (data.match) {
                    applyMatchUpdate(data.match);
                } else if (typeof data.id !== 'undefined') {
                    applyMatchUpdate(data);
                }

                if (data.final && finalRoot) {
                    const f = data.final;
                    if (f.done && f.champion) {
                        finalRoot.innerHTML = `
                            <div class="rounded-2xl ring-1 ring-yellow-300/60 bg-gradient-to-br from-amber-100 via-yellow-50 to-amber-50 shadow">
                                <div class="px-6 sm:px-8 py-5 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span class="text-3xl">🏆</span>
                                        <div>
                                            <div class="text-[11px] sm:text-xs font-black tracking-widest uppercase text-amber-900/80">Turnīra uzvarētājs</div>
                                            <div class="text-xl sm:text-2xl font-black text-amber-900 truncate" title="${f.champion}">${f.champion}</div>
                                        </div>
                                    </div>
                                    <div class="text-amber-900/80 text-sm tabular-nums">${(f.a_scr ?? '–')} – ${(f.b_scr ?? '–')}</div>
                                </div>
                            </div>
                        `;
                    } else {
                        renderFinalBannerFromDOM();
                    }
                } else {
                    renderFinalBannerFromDOM();
                }
            }

            async function send(id, url, A, B) {
                setState(id, 'saving');
                try {
                    const res = await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            score_a: A,
                            score_b: B
                        }),
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw data;
                    syncFromResponse(data);
                    setState(id, 'ok');
                    setTimeout(() => setState(id, 'idle'), 900);
                } catch (e) {
                    setState(id, 'err');
                    if (e && e.message) alert(e.message);
                }
            }

            // Initial render
            renderFinalBannerFromDOM();

            // Inputs wiring
            els('.score-input').forEach(inp => {
                if (inp.disabled) return;
                const id = inp.dataset.matchId;
                const side = inp.dataset.side;

                function schedule() {
                    const pair = cache.get(id) || {
                        A: null,
                        B: null
                    };
                    if (!validPair(pair)) return;
                    clearTimeout(timers.get(id));
                    timers.set(id, setTimeout(() => send(id, inp.dataset.url, pair.A, pair.B), 350));
                }
                inp.addEventListener('input', e => {
                    const raw = e.currentTarget.value;
                    const val = raw === '' ? null : Number(raw);
                    const pair = cache.get(id) || {
                        A: null,
                        B: null
                    };
                    pair[side] = val;
                    cache.set(id, pair);
                    setState(id, 'saving');
                    schedule();
                });
                inp.addEventListener('keydown', e => {
                    const pair = cache.get(id) || {
                        A: null,
                        B: null
                    };
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(timers.get(id));
                        if (validPair(pair)) send(id, inp.dataset.url, pair.A, pair.B);
                    } else if (e.key === 'Escape') {
                        e.preventDefault();
                        e.currentTarget.blur();
                    }
                });
            });
        })();
    </script>
</x-app-layout>
