<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900&family=Barlow+Condensed:wght@600;700;900&family=DM+Sans:wght@400;500&display=swap');

        .cal * {
            box-sizing: border-box;
        }

        .cal {
            --ink: #0F0F0E;
            --ink-2: #3A3935;
            --ink-3: #7A7770;
            --ink-4: #B8B5AF;
            --paper: #F8F6F1;
            --paper-2: #EFECE5;
            --rule: #D8D4CC;
            --red: #B8241C;
            --red-hover: #961E17;
            --red-tint: #F9EEEE;
            --white: #FFFFFF;
            --men: #1A4F8A;
            --men-bg: #EBF1F9;
            --women: #8A1A5E;
            --women-bg: #FCEEF5;
            --mix: #4A1A8A;
            --mix-bg: #F0EBF9;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            margin-top: 50px;
            padding-bottom: 5rem;
        }

        .cal-wrap {
            max-width: 1160px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        /* ── Masthead ── */
        .cal-masthead {
            border-top: 4px solid var(--ink);
            padding: 1.25rem 0 1rem;
        }

        .cal-masthead__eyebrow {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.4rem;
        }

        .cal-masthead__row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .cal-masthead__title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 900;
            letter-spacing: -0.025em;
            line-height: 1.05;
            color: var(--ink);
            margin: 0;
        }

        /* ── Nav controls ── */
        .cal-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cal-nav__btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: var(--white);
            color: var(--ink-2);
            border: 1px solid var(--rule);
            padding: 0.4rem 0.9rem;
            cursor: pointer;
            transition: all 0.15s;
            border-radius: 0;
        }

        .cal-nav__btn:hover {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        .cal-nav__today {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: var(--red);
            color: var(--white);
            border: 1px solid var(--red);
            padding: 0.4rem 0.9rem;
            cursor: pointer;
            transition: all 0.15s;
            border-radius: 0;
        }

        .cal-nav__today:hover {
            background: var(--red-hover);
            border-color: var(--red-hover);
        }

        .cal-rule {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 0;
        }

        /* ── Month bar ── */
        .cal-month-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 0 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .cal-month-label {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-weight: 900;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: var(--ink);
        }

        .cal-mobile-nav {
            display: none;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 640px) {
            .cal-desktop-nav {
                display: none;
            }

            .cal-mobile-nav {
                display: flex;
            }
        }

        /* ── Legend ── */
        .cal-legend {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--rule);
            margin-bottom: 0;
        }

        .cal-legend__item {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--ink-3);
        }

        .cal-legend__dot {
            width: 8px;
            height: 8px;
            flex-shrink: 0;
        }

        /* ── Weekday header ── */
        .cal-wk-row {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-left: 1px solid var(--rule);
            border-top: 1px solid var(--rule);
        }

        .cal-wk-cell {
            border-right: 1px solid var(--rule);
            border-bottom: 1px solid var(--rule);
            padding: 0.5rem 0.4rem;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--ink-3);
            text-align: center;
            background: var(--paper-2);
        }

        .cal-wk-cell--weekend {
            color: var(--red);
        }

        /* ── Desktop grid ── */
        .cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border-left: 1px solid var(--rule);
        }

        .cal-cell {
            border-right: 1px solid var(--rule);
            border-bottom: 1px solid var(--rule);
            min-height: 100px;
            padding: 0.4rem 0.4rem 0.5rem;
            background: var(--white);
            display: flex;
            flex-direction: column;
            transition: background 0.12s;
            overflow: hidden;
        }

        .cal-cell:hover {
            background: var(--paper);
        }

        .cal-cell--empty {
            background: var(--paper);
        }

        .cal-cell--weekend {
            background: #FDFCFA;
        }

        .cal-cell--today {
            background: var(--red-tint) !important;
            position: relative;
        }

        .cal-cell--today::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--red);
        }

        .cal-cell__day {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--ink-3);
            line-height: 1;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cal-cell--today .cal-cell__day {
            color: var(--red);
        }

        .cal-cell__count {
            font-size: 0.55rem;
            font-weight: 700;
            background: var(--red);
            color: var(--white);
            padding: 0.1rem 0.3rem;
            line-height: 1.4;
        }

        /* ── Chips ── */
        .cal-chip {
            display: block;
            font-size: 0.58rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            padding: 0.15rem 0.3rem;
            margin-bottom: 0.15rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            transition: opacity 0.12s;
            border: none;
            text-align: left;
            width: 100%;
        }

        .cal-chip:hover {
            opacity: 0.8;
        }

        .cal-chip--generic {
            background: var(--red);
            color: var(--white);
        }

        .cal-chip--men {
            background: var(--men-bg);
            color: var(--men);
        }

        .cal-chip--women {
            background: var(--women-bg);
            color: var(--women);
        }

        .cal-chip--mix {
            background: var(--mix-bg);
            color: var(--mix);
        }

        .cal-chip--more {
            background: none;
            color: var(--red);
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.1rem 0;
            cursor: pointer;
            border: none;
            text-align: left;
            display: block;
            margin-top: auto;
        }

        .cal-chip--more:hover {
            color: var(--red-hover);
        }

        /* ── Mobile agenda ── */
        .cal-agenda {
            display: flex;
            flex-direction: column;
        }

        .cal-agenda-item {
            display: flex;
            gap: 0.9rem;
            padding: 0.85rem 0;
            border-bottom: 1px solid var(--rule);
            align-items: flex-start;
        }

        .cal-agenda-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .cal-agenda-item--today {
            background: var(--red-tint);
            margin: 0 -1.25rem;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        .cal-agenda__left {
            flex-shrink: 0;
            width: 48px;
            font-family: 'Barlow Condensed', sans-serif;
            text-align: center;
        }

        .cal-agenda__dow {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
        }

        .cal-agenda__num {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--ink);
            line-height: 1;
        }

        .cal-agenda__chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
            flex: 1;
            padding-top: 0.2rem;
        }

        .cal-agenda__chip {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            padding: 0.2rem 0.55rem;
            cursor: pointer;
            border: none;
            transition: opacity 0.12s;
        }

        .cal-agenda__chip:hover {
            opacity: 0.8;
        }

        .cal-empty {
            text-align: center;
            padding: 3rem 1rem;
            font-size: 0.85rem;
            color: var(--ink-3);
            font-style: italic;
        }

        /* ── Footer hint ── */
        .cal-hint {
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid var(--rule);
            font-size: 0.68rem;
            color: var(--ink-4);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* ── Reveal ── */
        .cal-reveal {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .cal-reveal.in {
            opacity: 1;
            transform: none;
        }

        /* ── Responsive ── */
        @media (max-width: 640px) {

            .cal-grid,
            .cal-wk-row {
                display: none;
            }
        }

        @media (min-width: 641px) {
            .cal-agenda {
                display: none;
            }
        }

        /*
         * ══ MODAL ══════════════════════════════════════════════════════════════
         * The modal sits OUTSIDE .cal in the DOM so CSS variables defined on .cal
         * are NOT inherited. Every color here is a hard-coded hex value to
         * guarantee the modal renders with a solid white background regardless of
         * nesting. This is the root cause of the "invisible" modal bug.
         * ═══════════════════════════════════════════════════════════════════════
         */
        .cal-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 15, 14, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            /* above everything */
            backdrop-filter: blur(3px);
        }

        .cal-modal-overlay.open {
            display: flex;
        }

        .cal-modal {
            background: #FFFFFF;
            /* ← hard-coded, NOT var(--white) */
            max-width: 480px;
            width: calc(100% - 2rem);
            margin: 1rem;
            border-top: 4px solid #B8241C;
            position: relative;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.4), 0 8px 24px rgba(0, 0, 0, 0.25);
            animation: calModalIn 0.22s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes calModalIn {
            from {
                opacity: 0;
                transform: translateY(14px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .cal-modal__header {
            padding: 1.25rem 1.5rem 1rem;
            border-bottom: 1px solid #D8D4CC;
        }

        .cal-modal__date-label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #B8241C;
            margin-bottom: 0.3rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cal-modal__date-label::before {
            content: '';
            display: block;
            width: 14px;
            height: 2px;
            background: #B8241C;
        }

        .cal-modal__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: #0F0F0E;
            margin: 0;
        }

        .cal-modal__subtitle {
            font-size: 0.72rem;
            color: #7A7770;
            margin-top: 0.25rem;
        }

        .cal-modal__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #B8B5AF;
            line-height: 1;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s, background 0.15s;
            border-radius: 50%;
        }

        .cal-modal__close:hover {
            color: #0F0F0E;
            background: #EFECE5;
        }

        .cal-modal__list {
            list-style: none;
            margin: 0;
            padding: 0.4rem 0;
            max-height: 400px;
            overflow-y: auto;
        }

        /* Scrollbar inside modal */
        .cal-modal__list::-webkit-scrollbar {
            width: 4px;
        }

        .cal-modal__list::-webkit-scrollbar-thumb {
            background: #D8D4CC;
        }

        .cal-modal__item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            border-bottom: 1px solid #EFECE5;
            cursor: pointer;
            transition: background 0.12s;
            position: relative;
            text-decoration: none;
        }

        .cal-modal__item:last-child {
            border-bottom: none;
        }

        /* left red hover accent */
        .cal-modal__item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: #B8241C;
            transition: width 0.18s;
        }

        .cal-modal__item:hover {
            background: #F8F6F1;
        }

        .cal-modal__item:hover::before {
            width: 3px;
        }

        .cal-modal__item-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #0F0F0E;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cal-modal__item:hover .cal-modal__item-name {
            color: #B8241C;
        }

        .cal-modal__item-badge {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.15rem 0.5rem;
            border: 1px solid;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* Badge colour variants — hard-coded */
        .cal-badge--generic {
            color: #B8241C;
            border-color: rgba(184, 36, 28, .35);
            background: #F9EEEE;
        }

        .cal-badge--men {
            color: #1A4F8A;
            border-color: #B8CDE8;
            background: #EBF1F9;
        }

        .cal-badge--women {
            color: #8A1A5E;
            border-color: #E8B8D4;
            background: #FCEEF5;
        }

        .cal-badge--mix {
            color: #4A1A8A;
            border-color: #C8B8E8;
            background: #F0EBF9;
        }

        .cal-modal__item-arrow {
            font-size: 0.75rem;
            color: #B8B5AF;
            flex-shrink: 0;
            transition: color 0.15s, transform 0.15s;
        }

        .cal-modal__item:hover .cal-modal__item-arrow {
            color: #B8241C;
            transform: translateX(2px);
        }

        .cal-modal__footer {
            padding: 0.75rem 1.5rem;
            border-top: 1px solid #D8D4CC;
            background: #F8F6F1;
            font-size: 0.68rem;
            color: #B8B5AF;
            text-align: center;
        }
    </style>

    <div class="cal">
        <div class="cal-wrap">

            {{-- Masthead --}}
            <div class="cal-masthead cal-reveal" data-stagger="0">
                <div class="cal-masthead__eyebrow">VolleyLV</div>
                <div class="cal-masthead__row">
                    <h1 class="cal-masthead__title">Turnīru Kalendārs</h1>
                    <div class="cal-nav cal-desktop-nav">
                        <button id="prevMonth" class="cal-nav__btn">← Iepr.</button>
                        <button id="todayBtn" class="cal-nav__today">Šodien</button>
                        <button id="nextMonth" class="cal-nav__btn">Nāk. →</button>
                    </div>
                </div>
            </div>

            <hr class="cal-rule">

            {{-- Month bar --}}
            <div class="cal-month-bar cal-reveal" data-stagger="1">
                <div id="monthYear" class="cal-month-label"></div>
                <div class="cal-mobile-nav">
                    <button id="prevMonth_m" class="cal-nav__btn">←</button>
                    <button id="todayBtn_m" class="cal-nav__today">Šodien</button>
                    <button id="nextMonth_m" class="cal-nav__btn">→</button>
                </div>
            </div>

            {{-- Legend --}}
            <div class="cal-legend cal-reveal" data-stagger="2">
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:#B8241C"></div>Vispārējs
                </div>
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:#EBF1F9;border:1px solid #1A4F8A"></div>Vīrieši
                </div>
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:#FCEEF5;border:1px solid #8A1A5E"></div>Sievietes
                </div>
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:#F0EBF9;border:1px solid #4A1A8A"></div>Mix
                </div>
            </div>

            {{-- Desktop weekday header --}}
            <div class="cal-wk-row cal-reveal" data-stagger="3">
                @foreach (['Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se', 'Sv'] as $i => $d)
                    <div class="cal-wk-cell {{ $i >= 5 ? 'cal-wk-cell--weekend' : '' }}">{{ $d }}</div>
                @endforeach
            </div>

            {{-- Desktop grid --}}
            <div id="calendarGrid" class="cal-grid cal-reveal" data-stagger="3"></div>

            {{-- Mobile agenda --}}
            <div id="mobileAgenda" class="cal-agenda cal-reveal" data-stagger="3"></div>

            {{-- Hint --}}
            <div class="cal-hint cal-reveal" data-stagger="4">
                <span>Klikšķini uz turnīra nosaukuma, lai skatītu sīkāk. Nospied ← → lai mainītu mēnesi.</span>
                <div class="cal-nav" style="gap:0.4rem;">
                    <button id="prevMonth_btm" class="cal-nav__btn" style="font-size:0.65rem;padding:0.3rem 0.6rem;">←
                        Iepr.</button>
                    <button id="nextMonth_btm" class="cal-nav__btn"
                        style="font-size:0.65rem;padding:0.3rem 0.6rem;">Nāk. →</button>
                </div>
            </div>

        </div>
    </div>

    {{--
        Modal is intentionally OUTSIDE .cal so it can escape any overflow:hidden
        on the calendar container. CSS variables from .cal do NOT apply here —
        all modal styles use hard-coded hex values (see the stylesheet above).
    --}}
    <div id="modalOverlay" class="cal-modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="cal-modal">
            <button id="closeModal" class="cal-modal__close" aria-label="Aizvērt">✕</button>
            <div class="cal-modal__header">
                <div class="cal-modal__date-label">Turnīri</div>
                <h3 id="modalTitle" class="cal-modal__title"></h3>
                <div id="modalSubtitle" class="cal-modal__subtitle"></div>
            </div>
            <ul id="modalTournaments" class="cal-modal__list"></ul>
            <div class="cal-modal__footer">Klikšķini uz turnīra, lai skatītu sīkāk</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.cal-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 50 + i * 70);
            });
        });

        const events = @json($events);

        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs",
            "Jūlijs", "Augusts", "Septembris", "Oktobris", "Novembris", "Decembris"
        ];
        const wdShort = ["Sv", "Pr", "Ot", "Tr", "Ce", "Pk", "Se"];

        let currentDate = new Date();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        function parseDate(d) {
            if (!d) return null;
            const p = String(d).split('-').map(Number);
            if (p.length === 3) return new Date(p[0], p[1] - 1, p[2]);
            const a = new Date(d);
            return isNaN(a) ? null : new Date(a.getFullYear(), a.getMonth(), a.getDate());
        }
        const monIndex = dow => (dow + 6) % 7;
        const isWeekend = d => [6, 0].includes(d.getDay());

        /* chip CSS class based on gender — these classes are defined inside .cal
           so they work fine for calendar chips. The modal uses separate badge classes. */
        function chipCls(g) {
            const v = (g || '').toLowerCase();
            if (v === 'men') return 'cal-chip--men';
            if (v === 'women') return 'cal-chip--women';
            if (v === 'mix') return 'cal-chip--mix';
            return 'cal-chip--generic';
        }
        /* Modal badge class — hard-coded, outside .cal scope */
        function badgeCls(g) {
            const v = (g || '').toLowerCase();
            if (v === 'men') return 'cal-badge--men';
            if (v === 'women') return 'cal-badge--women';
            if (v === 'mix') return 'cal-badge--mix';
            return 'cal-badge--generic';
        }

        function genderLabel(g) {
            const v = (g || '').toLowerCase();
            if (v === 'men') return 'Vīrieši';
            if (v === 'women') return 'Sievietes';
            if (v === 'mix') return 'Mix';
            return 'Turnīrs';
        }

        function buildMonthMap(year, month) {
            const first = new Date(year, month, 1);
            const last = new Date(year, month + 1, 0);
            const map = Object.create(null);
            for (const ev of events) {
                const sRaw = parseDate(ev.start);
                if (!sRaw) continue;
                const eRaw = parseDate(ev.end || ev.start) || sRaw;
                if (eRaw < first || sRaw > last) continue;
                const s = sRaw < first ? first : sRaw;
                const e = eRaw > last ? last : eRaw;
                for (let d = new Date(s); d <= e; d.setDate(d.getDate() + 1)) {
                    const key = d.toISOString().slice(0, 10);
                    (map[key] ||= []).push(ev);
                }
            }
            return map;
        }

        function renderCalendar(date) {
            const grid = document.getElementById('calendarGrid');
            if (!grid) return;
            grid.innerHTML = '';

            const y = date.getFullYear(),
                m = date.getMonth();
            document.getElementById('monthYear').textContent = `${monthNames[m]} ${y}`;

            const lead = monIndex(new Date(y, m, 1).getDay());
            const lastDate = new Date(y, m + 1, 0).getDate();
            const map = buildMonthMap(y, m);

            for (let i = 0; i < lead; i++) {
                const s = document.createElement('div');
                s.className = 'cal-cell cal-cell--empty';
                grid.appendChild(s);
            }

            for (let d = 1; d <= lastDate; d++) {
                const dObj = new Date(y, m, d);
                const key = dObj.toISOString().slice(0, 10);
                const evs = map[key] || [];
                const wknd = isWeekend(dObj);
                const isToday = dObj.getTime() === today.getTime();

                const cell = document.createElement('div');
                cell.className = `cal-cell${wknd?' cal-cell--weekend':''}${isToday?' cal-cell--today':''}`;

                const dayRow = document.createElement('div');
                dayRow.className = 'cal-cell__day';
                dayRow.appendChild(Object.assign(document.createElement('span'), {
                    textContent: d
                }));
                if (evs.length > 2) {
                    const ct = document.createElement('span');
                    ct.className = 'cal-cell__count';
                    ct.textContent = evs.length;
                    dayRow.appendChild(ct);
                }
                cell.appendChild(dayRow);

                const maxInline = 2;
                evs.slice(0, maxInline).forEach(ev => {
                    const btn = document.createElement('button');
                    btn.className = `cal-chip ${chipCls(ev.gender_type)}`;
                    btn.textContent = ev.title;
                    btn.title = ev.title;
                    btn.setAttribute('aria-label', ev.title);
                    btn.onclick = () => ev.url && (window.location.href = ev.url);
                    cell.appendChild(btn);
                });

                if (evs.length > maxInline) {
                    const more = document.createElement('button');
                    more.className = 'cal-chip cal-chip--more';
                    more.textContent = `+${evs.length - maxInline} vairāk`;
                    more.onclick = () => openModal(dObj, evs);
                    cell.appendChild(more);
                }

                grid.appendChild(cell);
            }
        }

        function renderAgenda(date) {
            const agenda = document.getElementById('mobileAgenda');
            if (!agenda) return;
            agenda.innerHTML = '';

            const y = date.getFullYear(),
                m = date.getMonth();
            document.getElementById('monthYear').textContent = `${monthNames[m]} ${y}`;

            const lastDate = new Date(y, m + 1, 0).getDate();
            const map = buildMonthMap(y, m);
            let hasAny = false;

            for (let d = 1; d <= lastDate; d++) {
                const dObj = new Date(y, m, d);
                const key = dObj.toISOString().slice(0, 10);
                const evs = map[key] || [];
                if (!evs.length) continue;
                hasAny = true;

                const isToday = dObj.getTime() === today.getTime();
                const row = document.createElement('div');
                row.className = `cal-agenda-item${isToday?' cal-agenda-item--today':''}`;

                const left = document.createElement('div');
                left.className = 'cal-agenda__left';
                left.innerHTML =
                    `<div class="cal-agenda__dow">${wdShort[dObj.getDay()]}</div><div class="cal-agenda__num">${String(d).padStart(2,'0')}</div>`;

                const chips = document.createElement('div');
                chips.className = 'cal-agenda__chips';
                evs.forEach(ev => {
                    const btn = document.createElement('button');
                    btn.className = `cal-agenda__chip ${chipCls(ev.gender_type)}`;
                    btn.textContent = ev.title;
                    btn.title = ev.title;
                    btn.onclick = () => ev.url && (window.location.href = ev.url);
                    chips.appendChild(btn);
                });

                row.append(left, chips);
                agenda.appendChild(row);
            }

            if (!hasAny) {
                agenda.innerHTML = '<div class="cal-empty">Šajā mēnesī nav turnīru.</div>';
            }
        }

        function openModal(dateObj, items) {
            /* Title: "28. Aprīlis 2026" */
            document.getElementById('modalTitle').textContent =
                `${String(dateObj.getDate()).padStart(2,'0')}. ${monthNames[dateObj.getMonth()]} ${dateObj.getFullYear()}`;
            document.getElementById('modalSubtitle').textContent =
                `${items.length} turnīr${items.length === 1 ? 's' : 'i'}`;

            const list = document.getElementById('modalTournaments');
            list.innerHTML = '';

            items.forEach(ev => {
                const li = document.createElement('li');
                li.className = 'cal-modal__item';

                const name = document.createElement('span');
                name.className = 'cal-modal__item-name';
                name.textContent = ev.title;
                name.title = ev.title;

                const badge = document.createElement('span');
                badge.className = `cal-modal__item-badge ${badgeCls(ev.gender_type)}`;
                badge.textContent = genderLabel(ev.gender_type);

                const arrow = document.createElement('span');
                arrow.className = 'cal-modal__item-arrow';
                arrow.textContent = '→';
                arrow.setAttribute('aria-hidden', 'true');

                li.append(name, badge, arrow);
                li.onclick = () => ev.url && (window.location.href = ev.url);
                list.appendChild(li);
            });

            document.getElementById('modalOverlay').classList.add('open');
            document.getElementById('closeModal').focus();
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.remove('open');
        }

        function renderAll() {
            renderCalendar(currentDate);
            renderAgenda(currentDate);
        }

        function prevM() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderAll();
        }

        function nextM() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderAll();
        }

        function goToday() {
            currentDate = new Date();
            renderAll();
        }

        document.getElementById('prevMonth')?.addEventListener('click', prevM);
        document.getElementById('nextMonth')?.addEventListener('click', nextM);
        document.getElementById('todayBtn')?.addEventListener('click', goToday);
        document.getElementById('prevMonth_m')?.addEventListener('click', prevM);
        document.getElementById('nextMonth_m')?.addEventListener('click', nextM);
        document.getElementById('todayBtn_m')?.addEventListener('click', goToday);
        document.getElementById('prevMonth_btm')?.addEventListener('click', prevM);
        document.getElementById('nextMonth_btm')?.addEventListener('click', nextM);
        document.getElementById('closeModal')?.addEventListener('click', closeModal);
        document.getElementById('modalOverlay')?.addEventListener('click', e => {
            if (e.target === document.getElementById('modalOverlay')) closeModal();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
            if (e.key === 'ArrowLeft') prevM();
            if (e.key === 'ArrowRight') nextM();
        }, {
            passive: true
        });

        let rTO;
        window.addEventListener('resize', () => {
            clearTimeout(rTO);
            rTO = setTimeout(renderAll, 120);
        });

        renderAll();
    </script>
</x-app-layout>
