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

        /* ── Rule ── */
        .cal-rule {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 0;
        }

        /* ── Month header row ── */
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

        /* ── Desktop month grid ── */
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

        /* ── Event chips ── */
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

        /* ── Modal ── */
        .cal-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 15, 14, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 50;
        }

        .cal-modal-overlay.open {
            display: flex;
        }

        .cal-modal {
            background: var(--white);
            max-width: 460px;
            width: 100%;
            margin: 1rem;
            padding: 1.75rem;
            border-top: 4px solid var(--red);
            position: relative;
            animation: calModalIn 0.22s ease both;
        }

        @keyframes calModalIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .cal-modal__title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 1rem;
        }

        .cal-modal__close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: var(--ink-3);
            line-height: 1;
            transition: color 0.15s;
        }

        .cal-modal__close:hover {
            color: var(--ink);
        }

        .cal-modal__list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            max-height: 360px;
            overflow-y: auto;
        }

        .cal-modal__item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 0.75rem;
            border: 1px solid var(--rule);
            cursor: pointer;
            gap: 0.75rem;
            font-size: 0.85rem;
            color: var(--ink);
            transition: background 0.12s;
        }

        .cal-modal__item:hover {
            background: var(--paper-2);
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
                    <div class="cal-legend__dot" style="background:var(--red)"></div>
                    Vispārējs
                </div>
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:var(--men-bg);border:1px solid var(--men)"></div>
                    Vīrieši
                </div>
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:var(--women-bg);border:1px solid var(--women)"></div>
                    Sievietes
                </div>
                <div class="cal-legend__item">
                    <div class="cal-legend__dot" style="background:var(--mix-bg);border:1px solid var(--mix)"></div>
                    Mix
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

    {{-- Modal --}}
    <div id="modalOverlay" class="cal-modal-overlay">
        <div class="cal-modal">
            <button id="closeModal" class="cal-modal__close" aria-label="Aizvērt">✕</button>
            <h3 id="modalDate" class="cal-modal__title"></h3>
            <ul id="modalTournaments" class="cal-modal__list"></ul>
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

        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts",
            "Septembris", "Oktobris", "Novembris", "Decembris"
        ];
        const wdShort = ["Sv", "Pr", "Ot", "Tr", "Ce", "Pk", "Se"];

        let currentDate = new Date();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        function parseDate(d) {
            if (!d) return null;
            const p = String(d).split('-').map(Number);
            if (p.length === 3) return new Date(p[0], p[1] - 1, p[2]);
            const asIs = new Date(d);
            return isNaN(asIs) ? null : new Date(asIs.getFullYear(), asIs.getMonth(), asIs.getDate());
        }
        const monIndex = dow => (dow + 6) % 7;
        const isWeekend = d => [6, 0].includes(d.getDay());

        function chipCls(g) {
            const v = (g || '').toLowerCase();
            if (v === 'men') return 'cal-chip--men';
            if (v === 'women') return 'cal-chip--women';
            if (v === 'mix') return 'cal-chip--mix';
            return 'cal-chip--generic';
        }

        function agendaChipCls(g) {
            const v = (g || '').toLowerCase();
            if (v === 'men') return 'cal-chip--men';
            if (v === 'women') return 'cal-chip--women';
            if (v === 'mix') return 'cal-chip--mix';
            return 'cal-chip--generic';
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
                cell.className = `cal-cell${wknd ? ' cal-cell--weekend' : ''}${isToday ? ' cal-cell--today' : ''}`;

                // Day number
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

                // Chips
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
                row.className = `cal-agenda-item${isToday ? ' cal-agenda-item--today' : ''}`;

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
            document.getElementById('modalDate').textContent =
                `${monthNames[dateObj.getMonth()]} ${String(dateObj.getDate()).padStart(2,'0')}, ${dateObj.getFullYear()}`;
            const list = document.getElementById('modalTournaments');
            list.innerHTML = '';
            items.forEach(ev => {
                const li = document.createElement('li');
                li.className = 'cal-modal__item';
                li.innerHTML =
                    `<span>${ev.title}</span><span class="cal-agenda__chip ${chipCls(ev.gender_type)}" style="font-size:0.6rem;padding:0.15rem 0.45rem;">${genderLabel(ev.gender_type)}</span>`;
                li.onclick = () => ev.url && (window.location.href = ev.url);
                list.appendChild(li);
            });
            document.getElementById('modalOverlay').classList.add('open');
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
