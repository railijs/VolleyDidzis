<x-app-layout>
    <div class="relative min-h-screen pt-24 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
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
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
            <div class="fade-up mb-6 sm:mb-8 flex items-center justify-center gap-3">
                <span class="h-6 w-1.5 bg-red-600 rounded"></span>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Turnīru kalendārs</h1>
            </div>

            <section class="glass p-5 sm:p-6 fade-up">
                <!-- Nav -->
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    <div class="flex items-center gap-2">
                        <button id="prevMonth"
                            class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 shadow transition"
                            aria-label="Iepriekšējais mēnesis">←</button>
                        <button id="todayBtn"
                            class="inline-flex items-center justify-center rounded-full border border-red-200 text-red-700 hover:bg-red-50 font-semibold px-4 py-2 transition"
                            aria-label="Šodien">Šodien</button>
                    </div>
                    <h2 id="monthYear" class="text-2xl sm:text-3xl font-extrabold text-gray-900 text-center flex-1">
                    </h2>
                    <div class="flex items-center">
                        <button id="nextMonth"
                            class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 shadow transition"
                            aria-label="Nākamais mēnesis">→</button>
                    </div>
                </div>

                <!-- Week header (Mon-first) -->
                <div class="grid grid-cols-7 gap-3 text-xs sm:text-sm mb-2">
                    @php $wd = ['Pr','Ot','Tr','Ce','Pk','Se','Sv']; @endphp
                    @foreach ($wd as $i => $d)
                        <div
                            class="font-bold text-center p-2 rounded-md
                            {{ $i >= 5 ? 'bg-red-200 text-red-900' : 'bg-red-100' }}">
                            {{ $d }}
                        </div>
                    @endforeach
                </div>

                <!-- Grid -->
                <div id="calendarGrid" class="grid grid-cols-7 gap-3 text-sm"></div>
            </section>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalOverlay" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full relative shadow-2xl border border-gray-200">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 font-bold text-xl"
                aria-label="Aizvērt">×</button>
            <h3 id="modalDate" class="text-2xl font-bold mb-4 text-gray-900"></h3>
            <ul id="modalTournaments" class="space-y-3 max-h-96 overflow-y-auto"></ul>
        </div>
    </div>

    <script>
        const events = @json($events); // {title, start, end?, gender_type?, url?}
        let currentDate = new Date();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts",
            "Septembris", "Oktobris", "Novembris", "Decembris"
        ];

        const monthYearEl = document.getElementById('monthYear');
        const calendarGrid = document.getElementById('calendarGrid');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const todayBtn = document.getElementById('todayBtn');

        const modalOverlay = document.getElementById('modalOverlay');
        const modalTournaments = document.getElementById('modalTournaments');
        const modalDate = document.getElementById('modalDate');
        const closeModal = document.getElementById('closeModal');

        function parseDate(d) {
            if (!d) return null;
            const asIs = new Date(d);
            if (!isNaN(asIs)) return new Date(asIs.getFullYear(), asIs.getMonth(), asIs.getDate());
            const p = String(d).split('-').map(Number);
            if (p.length === 3) return new Date(p[0], p[1] - 1, p[2]);
            return null;
        }

        // Monday-first helpers
        function getMondayIndex(d) {
            return (d + 6) % 7;
        } // JS: 0=Sun -> 6, 1=Mon -> 0...
        function isWeekend(date) {
            const gd = date.getDay();
            return gd === 6 || gd === 0;
        } // Sat/Sun

        function renderCalendar(date) {
            calendarGrid.innerHTML = '';
            const y = date.getFullYear();
            const m = date.getMonth();

            monthYearEl.textContent = `${monthNames[m]} ${y}`;

            // Monday-first leading blanks
            const jsDowFirst = new Date(y, m, 1).getDay(); // 0..6 (Sun..Sat)
            const lead = getMondayIndex(jsDowFirst); // 0..6 (Mon..Sun)
            const lastDate = new Date(y, m + 1, 0).getDate();

            // Fill blanks before the 1st (Mon-first grid)
            for (let i = 0; i < lead; i++) {
                const spacer = document.createElement('div');
                spacer.className = 'p-2';
                calendarGrid.appendChild(spacer);
            }

            for (let d = 1; d <= lastDate; d++) {
                const cellDate = new Date(y, m, d);
                const cell = document.createElement('div');
                const weekend = isWeekend(cellDate);

                cell.className = [
                    'border p-2 h-24 rounded-xl bg-white flex flex-col text-xs transition',
                    'hover:shadow-md hover:ring-1 hover:ring-red-200',
                    weekend ? 'bg-red-50/60' : ''
                ].join(' ');

                const label = document.createElement('div');
                label.className = 'font-semibold text-gray-900';
                label.textContent = d;
                cell.appendChild(label);

                // Events overlapping this date (range-aware)
                const dayEvents = events.filter(ev => {
                    const s = parseDate(ev.start);
                    const e = parseDate(ev.end || ev.start) || s;
                    if (!s) return false;
                    return cellDate >= s && cellDate <= e;
                });

                if (dayEvents.length > 0) {
                    // Show up to 2 badges; if more, show "+3 turnīri" (fixed label) opening modal
                    const maxInline = 2;
                    dayEvents.slice(0, maxInline).forEach(ev => {
                        const badge = document.createElement('span');
                        badge.textContent = ev.title;
                        badge.title = ev.title;
                        badge.className = 'mt-1 px-2 py-0.5 rounded-full text-white truncate cursor-pointer';
                        const g = (ev.gender_type || '').toLowerCase();
                        if (g === 'men') badge.classList.add('bg-blue-500');
                        else if (g === 'women') badge.classList.add('bg-pink-500');
                        else if (g === 'mix') badge.classList.add('bg-purple-500');
                        else badge.classList.add('bg-red-500');
                        badge.onclick = () => ev.url && (window.location.href = ev.url);
                        cell.appendChild(badge);
                    });

                    if (dayEvents.length > maxInline) {
                        const more = document.createElement('button');
                        more.type = 'button';
                        more.textContent = '+3 turnīri';
                        more.className = 'mt-auto text-xs font-semibold text-red-700 hover:text-red-900';
                        more.onclick = () => openModalFor(cellDate, dayEvents);
                        cell.appendChild(more);
                    }
                }

                // Today highlight
                if (cellDate.getTime() === today.getTime()) {
                    cell.classList.add('ring-2', 'ring-red-300', 'bg-red-50');
                }

                calendarGrid.appendChild(cell);
            }
        }

        function openModalFor(dateObj, items) {
            modalTournaments.innerHTML = '';
            modalDate.textContent =
                `${monthNames[dateObj.getMonth()]} ${String(dateObj.getDate()).padStart(2,'0')}, ${dateObj.getFullYear()}`;

            items.forEach(ev => {
                const li = document.createElement('li');
                li.className =
                    'p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100 flex items-center justify-between gap-3 border border-gray-200';

                const title = document.createElement('span');
                title.className = 'font-medium text-gray-800 truncate';
                title.textContent = ev.title;

                const badge = document.createElement('span');
                badge.className = 'text-[11px] font-semibold px-2 py-0.5 rounded-full text-white';
                const g = (ev.gender_type || '').toLowerCase();
                if (g === 'men') {
                    badge.textContent = 'Vīrieši';
                    badge.classList.add('bg-blue-500');
                } else if (g === 'women') {
                    badge.textContent = 'Sievietes';
                    badge.classList.add('bg-pink-500');
                } else if (g === 'mix') {
                    badge.textContent = 'Mix';
                    badge.classList.add('bg-purple-500');
                } else {
                    badge.textContent = 'Turnīrs';
                    badge.classList.add('bg-gray-600');
                }

                li.appendChild(title);
                li.appendChild(badge);
                li.addEventListener('click', () => ev.url && (window.location.href = ev.url));

                modalTournaments.appendChild(li);
            });

            modalOverlay.classList.remove('hidden');
            modalOverlay.classList.add('flex');
        }

        function closeTheModal() {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
            renderCalendar(currentDate);
        });

        prevMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });
        nextMonthBtn.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });
        todayBtn.addEventListener('click', () => {
            currentDate = new Date();
            renderCalendar(currentDate);
        });

        closeModal.addEventListener('click', closeTheModal);
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeTheModal();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeTheModal();
            if (e.key === 'ArrowLeft') {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
            }
            if (e.key === 'ArrowRight') {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
            }
        }, {
            passive: true
        });
    </script>
</x-app-layout>
