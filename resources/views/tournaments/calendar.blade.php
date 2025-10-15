<x-app-layout>
    <div class="relative min-h-screen pt-24 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        <style>
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .55s, transform .55s;
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none;
                }
            }

            .glass {
                background: rgba(255, 255, 255, .88);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(148, 163, 184, .35);
                border-radius: 1rem;
                box-shadow: 0 10px 20px rgba(0, 0, 0, .06);
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
                white-space: nowrap;
                border-radius: 9999px;
                font-weight: 700;
                font-size: .72rem;
                padding: .15rem .55rem;
                color: #fff;
                max-width: 100%;
                transition: transform .15s ease, box-shadow .2s ease, opacity .15s ease;
            }

            .chip-men {
                background: #3b82f6;
            }

            .chip-women {
                background: #ec4899;
            }

            .chip-mix {
                background: #8b5cf6;
            }

            .chip-generic {
                background: #ef4444;
            }

            /* Only interactive chips show pointer + hover */
            .chip.clickable {
                cursor: pointer;
            }

            .chip.clickable:hover {
                transform: translateY(-1px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, .12);
            }

            .chip:focus {
                outline: 2px solid rgba(239, 68, 68, .6);
                outline-offset: 2px;
            }

            .btn-red {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 9999px;
                background: #dc2626;
                color: #fff;
                font-weight: 700;
                padding: .5rem 1rem;
                box-shadow: 0 8px 16px rgba(220, 38, 38, .18);
                transition: transform .15s, box-shadow .2s, background .2s;
            }

            .btn-red:hover {
                background: #b91c1c;
                box-shadow: 0 10px 18px rgba(185, 28, 28, .22);
                transform: translateY(-1px);
            }

            .btn-muted {
                border: 1px solid #e5e7eb;
                border-radius: 9999px;
                background: #fff;
                color: #374151;
                padding: .5rem 1rem;
            }

            .btn-muted:hover {
                background: #f9fafb;
            }

            .wk-pill {
                padding: .35rem .75rem;
                border-radius: .75rem;
                font-weight: 800;
                text-align: center;
            }

            .wk-work {
                background: #fee2e2;
                color: #991b1b;
            }

            /* red-100/700 */
            .wk-weekend {
                background: #fecaca;
                color: #7f1d1d;
            }

            /* red-200/800 */

            /* Desktop month grid cells */
            .cell {
                border: 1px solid #e5e7eb;
                border-radius: 1rem;
                background: #fff;
                min-height: 6.25rem;
                display: flex;
                flex-direction: column;
                padding: .5rem .6rem;
                transition: box-shadow .2s, border-color .2s;
            }

            .cell:hover {
                box-shadow: 0 8px 16px rgba(0, 0, 0, .06);
                border-color: #fecaca;
            }

            .cell-today {
                box-shadow: inset 0 0 0 2px rgba(252, 165, 165, .8);
                background: #fff1f2;
            }

            .cell-weekend {
                background: #fff5f5;
            }

            .cell-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: .5rem;
            }

            .day-num {
                font-weight: 800;
                color: #111827;
            }

            .badge-count {
                font-size: .65rem;
                font-weight: 800;
                color: #991b1b;
                background: #fee2e2;
                border: 1px solid #fecaca;
                border-radius: 9999px;
                padding: .05rem .4rem;
            }

            .chip-row {
                display: flex;
                flex-direction: column;
                gap: .25rem;
                margin-top: .25rem;
            }

            .chip-row .chip {
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .chip-more {
                margin-top: auto;
                font-size: .72rem;
                font-weight: 800;
                color: #b91c1c;
            }

            .chip-more:hover {
                color: #7f1d1d;
                text-decoration: underline;
            }

            /* --- Dedicated Mobile Agenda (<= md) --- */
            .m-day {
                display: flex;
                gap: .75rem;
                border: 1px solid #e5e7eb;
                border-radius: 1rem;
                background: #fff;
                padding: .6rem .75rem;
                align-items: flex-start;
                transition: box-shadow .2s, border-color .2s;
            }

            .m-day:hover {
                border-color: #fecaca;
                box-shadow: 0 8px 16px rgba(0, 0, 0, .06);
            }

            .m-left {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-width: 3rem;
                /* fits 320px nicely */
            }

            .m-dow {
                font-size: .7rem;
                font-weight: 800;
                color: #7f1d1d;
                line-height: 1;
            }

            .m-num {
                font-size: 1.05rem;
                font-weight: 900;
                color: #111827;
                line-height: 1.15;
            }

            .m-right {
                display: flex;
                flex-direction: column;
                gap: .35rem;
                width: 100%;
                min-width: 0;
            }

            .m-day.today {
                box-shadow: inset 0 0 0 2px rgba(252, 165, 165, .8);
                background: #fff1f2;
            }

            .m-day.weekend {
                background: #fff5f5;
            }

            .m-title {
                font-size: .82rem;
                font-weight: 800;
                color: #374151;
                margin-bottom: .15rem;
            }

            .m-chips {
                display: flex;
                flex-wrap: wrap;
                gap: .3rem .4rem;
            }

            .m-empty {
                text-align: center;
                font-size: .85rem;
                color: #6b7280;
                padding: .75rem 0;
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <!-- Title -->
            <div class="fade-up mb-6 sm:mb-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="h-6 w-1.5 bg-red-600 rounded"></span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Turnīru kalendārs</h1>
                </div>
                <div class="hidden md:flex items-center gap-2">
                    <button id="prevMonth" class="btn-muted" aria-label="Iepriekšējais mēnesis">←</button>
                    <button id="todayBtn" class="btn-red" aria-label="Šodien">Šodien</button>
                    <button id="nextMonth" class="btn-muted" aria-label="Nākamais mēnesis">→</button>
                </div>
            </div>

            <section class="glass p-5 sm:p-6 fade-up">
                <!-- Mobile nav -->
                <div class="md:hidden flex items-center justify-between mb-3">
                    <button id="prevMonth_m" class="btn-muted" aria-label="Iepriekšējais mēnesis">←</button>
                    <button id="todayBtn_m" class="btn-red" aria-label="Šodien">Šodien</button>
                    <button id="nextMonth_m" class="btn-muted" aria-label="Nākamais mēnesis">→</button>
                </div>

                <!-- Month label -->
                <div class="flex items-center justify-center mb-3">
                    <h2 id="monthYear" class="text-2xl sm:text-3xl font-extrabold text-gray-900 text-center"></h2>
                </div>

                <!-- Legend -->
                <div class="flex flex-wrap items-center justify-center gap-2 text-xs mb-4">
                    <span class="chip chip-generic">Turnīrs</span>
                </div>

                <!-- Week header (Mon-first) – desktop only -->
                <div class="hidden md:grid grid-cols-7 gap-3 text-xs sm:text-sm mb-2">
                    @php $wd = ['Pr','Ot','Tr','Ce','Pk','Se','Sv']; @endphp
                    @foreach ($wd as $i => $d)
                        <div class="wk-pill {{ $i >= 5 ? 'wk-weekend' : 'wk-work' }}">{{ $d }}</div>
                    @endforeach
                </div>

                <!-- Desktop Month Grid -->
                <div id="calendarGrid" class="hidden md:grid grid-cols-7 gap-3 text-sm"></div>

                <!-- Mobile Agenda (true mobile UX) -->
                <div id="mobileAgenda" class="md:hidden space-y-3"></div>

                <!-- Footer actions -->
                <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                    <div class="text-xs text-gray-500">Padoms: klikšķini “+N” lai redzētu visas dienas sacensības.</div>
                    <div class="hidden sm:flex items-center gap-2">
                        <button id="prevMonth_btm" class="btn-muted">← Iepriekšējais</button>
                        <button id="nextMonth_btm" class="btn-muted">Nākamais →</button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal (desktop "+N") -->
    <div id="modalOverlay" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full relative shadow-2xl border border-gray-200">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 font-bold text-xl"
                aria-label="Aizvērt">×</button>
            <h3 id="modalDate" class="text-2xl font-bold mb-4 text-gray-900"></h3>
            <ul id="modalTournaments" class="space-y-3 max-h-96 overflow-y-auto"></ul>
        </div>
    </div>

    <script>
        // ---- Data ----
        const events = @json($events); // [{title, start, end?, gender_type?, url?}]

        // ---- DOM refs ----
        const monthYearEl = document.getElementById('monthYear');
        const calendarGrid = document.getElementById('calendarGrid');
        const mobileAgenda = document.getElementById('mobileAgenda');

        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const todayBtn = document.getElementById('todayBtn');

        const prevMonth_m = document.getElementById('prevMonth_m');
        const nextMonth_m = document.getElementById('nextMonth_m');
        const todayBtn_m = document.getElementById('todayBtn_m');

        const prevMonth_btm = document.getElementById('prevMonth_btm');
        const nextMonth_btm = document.getElementById('nextMonth_btm');

        const modalOverlay = document.getElementById('modalOverlay');
        const modalTournaments = document.getElementById('modalTournaments');
        const modalDate = document.getElementById('modalDate');
        const closeModal = document.getElementById('closeModal');

        // ---- Date helpers ----
        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts",
            "Septembris", "Oktobris", "Novembris", "Decembris"
        ];
        const wdShort = ["Sv", "Pr", "Ot", "Tr", "Ce", "Pk", "Se"]; // JS dow indexing
        let currentDate = new Date();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        function parseDate(d) {
            if (!d) return null;
            const asIs = new Date(d);
            if (!isNaN(asIs)) return new Date(asIs.getFullYear(), asIs.getMonth(), asIs.getDate());
            const p = String(d).split('-').map(Number);
            if (p.length === 3) return new Date(p[0], p[1] - 1, p[2]);
            return null;
        }
        const monIndex = (jsDow) => (jsDow + 6) % 7; // 0..6, Mon-first index
        const isWeekend = (date) => [6, 0].includes(date.getDay());

        // ---- Efficient per-month mapping ----
        function buildMonthMap(year, month) {
            const first = new Date(year, month, 1);
            const last = new Date(year, month + 1, 0);
            const map = Object.create(null);

            const clampToMonth = (d) => {
                if (d < first) return first;
                if (d > last) return last;
                return d;
            };

            for (const ev of events) {
                const sRaw = parseDate(ev.start);
                if (!sRaw) continue;
                const eRaw = parseDate(ev.end || ev.start) || sRaw;

                if (eRaw < first || sRaw > last) continue;

                const s = clampToMonth(new Date(sRaw));
                const e = clampToMonth(new Date(eRaw));

                for (let d = new Date(s); d <= e; d.setDate(d.getDate() + 1)) {
                    const key = d.toISOString().slice(0, 10);
                    (map[key] ||= []).push(ev);
                }
            }
            return map;
        }

        // ---- Desktop Month Grid ----
        function renderCalendar(date) {
            if (!calendarGrid) return;
            calendarGrid.innerHTML = '';

            const y = date.getFullYear();
            const m = date.getMonth();
            monthYearEl.textContent = `${monthNames[m]} ${y}`;

            const firstDow = new Date(y, m, 1).getDay(); // 0..6 (Sun..Sat)
            const lead = monIndex(firstDow);
            const lastDate = new Date(y, m + 1, 0).getDate();

            const monthMap = buildMonthMap(y, m);

            // Leading blanks
            for (let i = 0; i < lead; i++) {
                const spacer = document.createElement('div');
                spacer.className = 'p-2';
                calendarGrid.appendChild(spacer);
            }

            for (let d = 1; d <= lastDate; d++) {
                const cellDate = new Date(y, m, d);
                const key = cellDate.toISOString().slice(0, 10);
                const dayEvents = monthMap[key] || [];
                const weekend = isWeekend(cellDate);

                const cell = document.createElement('div');
                cell.className = `cell ${weekend ? 'cell-weekend' : ''}`;

                // Header
                const header = document.createElement('div');
                header.className = 'cell-header';

                const dn = document.createElement('div');
                dn.className = 'day-num';
                dn.textContent = d;
                header.appendChild(dn);

                if (dayEvents.length > 3) {
                    const ct = document.createElement('span');
                    ct.className = 'badge-count';
                    ct.textContent = dayEvents.length;
                    header.appendChild(ct);
                }
                cell.appendChild(header);

                // Chips (max 2), then "+N"
                const maxInline = 2;
                if (dayEvents.length) {
                    const wrap = document.createElement('div');
                    wrap.className = 'chip-row';

                    dayEvents.slice(0, maxInline).forEach(ev => {
                        const chip = document.createElement('span');
                        chip.className = 'chip ' + chipClass(ev.gender_type);
                        chip.classList.add('clickable');
                        chip.setAttribute('tabindex', '0');
                        chip.setAttribute('role', 'button');
                        chip.setAttribute('aria-label', ev.title);

                        chip.textContent = ev.title;
                        chip.title = ev.title;

                        chip.onclick = () => ev.url && (window.location.href = ev.url);
                        chip.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.preventDefault();
                                if (ev.url) window.location.href = ev.url;
                            }
                        });

                        wrap.appendChild(chip);
                    });

                    if (dayEvents.length > maxInline) {
                        const more = document.createElement('button');
                        more.type = 'button';
                        more.className = 'chip-more';
                        const extra = dayEvents.length - maxInline;
                        more.textContent = `+${extra} turnīr${extra === 1 ? 's' : 'i'}`;
                        more.onclick = () => openModalFor(cellDate, dayEvents);
                        wrap.appendChild(more);
                    }
                    cell.appendChild(wrap);
                }

                if (cellDate.getTime() === today.getTime()) {
                    cell.classList.add('cell-today');
                }

                calendarGrid.appendChild(cell);
            }
        }

        // ---- Mobile Agenda (true mobile UX) ----
        function renderMobileAgenda(date) {
            if (!mobileAgenda) return;
            mobileAgenda.innerHTML = '';

            const y = date.getFullYear();
            const m = date.getMonth();
            // keep label in sync
            monthYearEl.textContent = `${monthNames[m]} ${y}`;

            const lastDate = new Date(y, m + 1, 0).getDate();
            const monthMap = buildMonthMap(y, m);

            let hasAny = false;
            for (let d = 1; d <= lastDate; d++) {
                const dayDate = new Date(y, m, d);
                const key = dayDate.toISOString().slice(0, 10);
                const dayEvents = monthMap[key] || [];
                if (!dayEvents.length) continue; // Agenda shows event days only
                hasAny = true;

                const isToday = dayDate.getTime() === today.getTime();
                const weekend = isWeekend(dayDate);

                const wrap = document.createElement('div');
                wrap.className = `m-day ${isToday ? 'today' : ''} ${weekend ? 'weekend' : ''}`;
                wrap.setAttribute('aria-label', `Diena ${d}. ${monthNames[m]} ${y}`);

                // Left (weekday + date)
                const left = document.createElement('div');
                left.className = 'm-left';
                const dow = document.createElement('div');
                dow.className = 'm-dow';
                dow.textContent = wdShort[dayDate.getDay()];
                const num = document.createElement('div');
                num.className = 'm-num';
                num.textContent = String(d).padStart(2, '0');
                left.appendChild(dow);
                left.appendChild(num);

                // Right (title + chips)
                const right = document.createElement('div');
                right.className = 'm-right';

                const title = document.createElement('div');
                title.className = 'm-title';
                title.textContent = `${monthNames[m]} ${String(d).padStart(2,'0')}, ${y}`;
                right.appendChild(title);

                const chips = document.createElement('div');
                chips.className = 'm-chips';

                dayEvents.forEach(ev => {
                    const chip = document.createElement('span');
                    chip.className = 'chip ' + chipClass(ev.gender_type);
                    chip.classList.add('clickable');
                    chip.setAttribute('tabindex', '0');
                    chip.setAttribute('role', 'button');
                    chip.setAttribute('aria-label', ev.title);

                    chip.textContent = ev.title;
                    chip.title = ev.title;

                    chip.onclick = () => ev.url && (window.location.href = ev.url);
                    chip.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            if (ev.url) window.location.href = ev.url;
                        }
                    });

                    chips.appendChild(chip);
                });

                right.appendChild(chips);
                wrap.appendChild(left);
                wrap.appendChild(right);

                mobileAgenda.appendChild(wrap);
            }

            if (!hasAny) {
                const empty = document.createElement('div');
                empty.className = 'm-empty';
                empty.textContent = 'Šajā mēnesī nav turnīru.';
                mobileAgenda.appendChild(empty);
            }
        }

        function chipClass(gender) {
            const g = (gender || '').toLowerCase();
            if (g === 'men') return 'chip-men';
            if (g === 'women') return 'chip-women';
            if (g === 'mix') return 'chip-mix';
            return 'chip-generic';
        }

        function openModalFor(dateObj, items) {
            modalTournaments.innerHTML = '';
            modalDate.textContent =
                `${monthNames[dateObj.getMonth()]} ${String(dateObj.getDate()).padStart(2,'0')}, ${dateObj.getFullYear()}`;

            items.forEach(ev => {
                const li = document.createElement('li');
                li.className =
                    'p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 flex items-center justify-between gap-3 border border-gray-200';
                li.setAttribute('tabindex', '0');
                li.setAttribute('role', 'button');
                li.addEventListener('keydown', (e) => {
                    if ((e.key === 'Enter' || e.key === ' ') && ev.url) {
                        e.preventDefault();
                        window.location.href = ev.url;
                    }
                });

                const title = document.createElement('span');
                title.className = 'font-medium text-gray-800 truncate';
                title.textContent = ev.title;

                const badge = document.createElement('span');
                badge.className = 'chip ' + chipClass(ev.gender_type);
                badge.textContent = labelFromGender(ev.gender_type);

                li.appendChild(title);
                li.appendChild(badge);
                li.addEventListener('click', () => ev.url && (window.location.href = ev.url));

                modalTournaments.appendChild(li);
            });

            modalOverlay.classList.remove('hidden');
            modalOverlay.classList.add('flex');
        }

        function labelFromGender(g) {
            const v = (g || '').toLowerCase();
            if (v === 'men') return 'Vīrieši';
            if (v === 'women') return 'Sievietes';
            if (v === 'mix') return 'Mix';
            return 'Turnīrs';
        }

        function closeTheModal() {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
        }

        // ---- Render helpers ----
        function renderAll() {
            // render both; CSS controls which one is visible for current viewport
            renderCalendar(currentDate);
            renderMobileAgenda(currentDate);
        }

        // ---- Init & events ----
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
            renderAll();
        });

        function prevMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderAll();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderAll();
        }

        function goToday() {
            currentDate = new Date();
            renderAll();
        }

        // Controls
        prevMonthBtn?.addEventListener('click', prevMonth);
        nextMonthBtn?.addEventListener('click', nextMonth);
        todayBtn?.addEventListener('click', goToday);

        prevMonth_m?.addEventListener('click', prevMonth);
        nextMonth_m?.addEventListener('click', nextMonth);
        todayBtn_m?.addEventListener('click', goToday);

        prevMonth_btm?.addEventListener('click', prevMonth);
        nextMonth_btm?.addEventListener('click', nextMonth);

        // Modal + keyboard
        closeModal.addEventListener('click', closeTheModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeTheModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeTheModal();
            if (e.key === 'ArrowLeft') prevMonth();
            if (e.key === 'ArrowRight') nextMonth();
        }, {
            passive: true
        });

        // Keep in sync on resize (e.g., rotate phone)
        let resizeTO;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTO);
            resizeTO = setTimeout(renderAll, 120);
        });
    </script>
</x-app-layout>
