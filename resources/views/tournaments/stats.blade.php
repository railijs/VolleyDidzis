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
                                        class="rounded-full bg-emerald-500/90 hover:bg-emerald-500 text-white px-4 py-2 text-sm font-bold shadow">
                                        ▶️ Sākt
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

        {{-- Final banner (tiny and unobtrusive) --}}
        @if ($finalMatch)
            <section class="mb-6 sm:mb-8 flex justify-center">
                <div class="w-full max-w-3xl" id="final-container">
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
                    @elseif ($finalistsKnown)
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

        {{-- BRACKET: ultra-simple, columns by round, pair highlight --}}
        @if ($matches->isEmpty())
            <div class="rounded-2xl border border-gray-200 bg-white/80 p-6 text-center shadow-sm">
                <div class="text-gray-900 font-extrabold text-lg mb-1">Nav spēļu</div>
                <p class="text-gray-600">Sāc turnīru, lai ģenerētu tīklāju.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-xl p-4 sm:p-6
                    bg-[radial-gradient(circle_at_1px_1px,rgba(0,0,0,0.04)_1px,transparent_0)] bg-[size:18px_18px]
                    snap-x snap-mandatory"
                role="region" aria-label="Turnīra tīklājs">
                <div class="w-fit mx-auto">
                    <div class="grid grid-flow-col auto-cols-[280px] gap-12 justify-center">

                        @foreach ($rounds as $roundNumber => $roundMatches)
                            <div class="w-[280px] flex flex-col items-stretch gap-4 snap-start"
                                data-round="{{ $roundNumber }}">
                                <div
                                    class="sticky top-2 z-10 self-start mb-1 inline-flex items-center gap-2 rounded-full bg-white/80 ring-1 ring-gray-200 px-3 py-1 font-extrabold text-[0.9rem] text-red-700 shadow-sm backdrop-blur">
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
                                            data-next-slot="{{ $m->next_slot ?? '' }}">
                                            <header class="flex items-center justify-between px-3 py-1 border-b">
                                                <div class="text-[11px] font-semibold inline-flex items-center gap-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded-full ring-1 ring-black/5 {{ $cls }}">
                                                        {{ $label }}
                                                    </span>
                                                    @if ($m->winner_slot)
                                                        <span class="text-emerald-700">Uzv.:
                                                            {{ $m->winner_slot }}</span>
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
                                                    class="flex items-center justify-between px-3 py-1 {{ $m->winner_slot === 'A' ? 'bg-emerald-50 font-semibold text-emerald-800' : '' }}">
                                                    <span class="truncate"
                                                        data-team="A">{{ $m->participantA?->team_name ?? ($hasB ? 'Gaida pretinieku' : '—') }}</span>
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
                                                    class="flex items-center justify-between px-3 py-1 {{ $m->winner_slot === 'B' ? 'bg-emerald-50 font-semibold text-emerald-800' : '' }}">
                                                    <span class="truncate"
                                                        data-team="B">{{ $m->participantB?->team_name ?? ($hasA ? 'Gaida pretinieku' : '—') }}</span>
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

                                                {{-- footer: simplest possible "winner goes to" line --}}
                                                <footer
                                                    class="px-3 py-1 text-[12px] flex items-center justify-between">
                                                    <div class="flex items-center gap-2">
                                                        <span class="save-dot hidden"
                                                            id="saving-{{ $m->id }}">Saglabā…</span>
                                                        <span class="save-ok hidden text-emerald-700"
                                                            id="saved-{{ $m->id }}">Saglabāts ✓</span>
                                                        <span class="save-err hidden text-red-700"
                                                            id="error-{{ $m->id }}">Kļūda — pārbaudi
                                                            punktus</span>
                                                    </div>

                                                    @if ($m->next_match_id)
                                                        <span
                                                            class="feed-line text-[11px] text-gray-500 underline decoration-dotted underline-offset-2 select-none cursor-pointer"
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

    {{-- STOP modal (unchanged) --}}
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

    {{-- JS: tiny pair-highlighting + lightweight autosave --}}
    <script>
        (function() {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const finalRoot = document.getElementById('final-container');
            const isEditable = {{ $isEditable ? 'true' : 'false' }};

            // 1) Minimal highlight: just source + destination
            const cards = Array.from(document.querySelectorAll('.match-card'));
            const byId = new Map(cards.map(c => [String(c.dataset.matchId), c]));

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

            // Click a card → show where its winner goes (if any)
            cards.forEach(card => {
                card.addEventListener('click', (e) => {
                    if (e.target.closest('input')) return; // don't clash with editing
                    const to = card.dataset.nextMatchId;
                    if (to) highlightPair(card.dataset.matchId, to);
                });
            });
            // Click the "Winner → #id" line
            document.addEventListener('click', (e) => {
                const feed = e.target.closest('.feed-line');
                if (!feed) return;
                e.preventDefault();
                highlightPair(feed.dataset.from, feed.dataset.to);
            });

            // 2) Lightweight autosave (simple debounce + Enter to commit)
            if (!isEditable) return;

            const inputs = Array.from(document.querySelectorAll('.score-input'));
            const cache = new Map(); // matchId -> {A:null|int, B:null|int}
            const timers = new Map(); // matchId -> timeout

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
                const saving = document.getElementById('saving-' + id);
                const ok = document.getElementById('saved-' + id);
                const err = document.getElementById('error-' + id);
                [saving, ok, err].forEach(el => el && el.classList.add('hidden'));
                if (state === 'saving') saving?.classList.remove('hidden');
                if (state === 'ok') ok?.classList.remove('hidden');
                if (state === 'err') err?.classList.remove('hidden');
            }

            function validPair(p) {
                return Number.isInteger(p.A) && Number.isInteger(p.B);
            }

            async function send(id, url, A, B) {
                setState(id, 'saving');
                try {
                    const res = await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            score_a: A,
                            score_b: B
                        }),
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw data;

                    // update changed cards
                    if (Array.isArray(data.matches)) {
                        data.matches.forEach(m => {
                            const card = byId.get(String(m.id));
                            if (!card) return;

                            const aRow = card.querySelector('[data-team="A"]')?.closest(
                                'div.flex.items-center.justify-between');
                            const bRow = card.querySelector('[data-team="B"]')?.closest(
                                'div.flex.items-center.justify-between');
                            const aLbl = card.querySelector('[data-team="A"]');
                            const bLbl = card.querySelector('[data-team="B"]');
                            const aInp = card.querySelector('input[data-side="A"]');
                            const bInp = card.querySelector('input[data-side="B"]');

                            if (aLbl) aLbl.textContent = m.a_name ?? 'Gaida pretinieku';
                            if (bLbl) bLbl.textContent = m.b_name ?? 'Gaida pretinieku';
                            if (typeof m.score_a !== 'undefined' && aInp) aInp.value = (m.score_a ?? '');
                            if (typeof m.score_b !== 'undefined' && bInp) bInp.value = (m.score_b ?? '');

                            [aRow, bRow].forEach(el => el && el.classList.remove('bg-emerald-50',
                                'text-emerald-800', 'font-semibold'));
                            if (m.winner_slot === 'A' && aRow) aRow.classList.add('bg-emerald-50',
                                'text-emerald-800', 'font-semibold');
                            if (m.winner_slot === 'B' && bRow) bRow.classList.add('bg-emerald-50',
                                'text-emerald-800', 'font-semibold');

                            // disable if missing side
                            const hasA = !!m.a_id,
                                hasB = !!m.b_id;
                            const lock = !(hasA && hasB) || !{{ $isEditable ? 'true' : 'false' }};
                            if (aInp) aInp.disabled = lock;
                            if (bInp) bInp.disabled = lock;
                        });
                    }
                    if (data.final && finalRoot) {
                        // minimal banner refresh (optional, compact)
                        // (kept simple to avoid bloat)
                        // you can ignore if you don't need live final update
                    }

                    setState(id, 'ok');
                    setTimeout(() => setState(id, 'idle'), 900);
                } catch (e) {
                    setState(id, 'err');
                    if (e && e.message) alert(e.message);
                }
            }

            inputs.forEach(inp => {
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
                    timers.set(id, setTimeout(() => send(id, inp.dataset.url, pair.A, pair.B), 400));
                }

                inp.addEventListener('input', (e) => {
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
                inp.addEventListener('keydown', (e) => {
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
