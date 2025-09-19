<x-app-layout>
<div class="max-w-7xl mx-auto mt-32 mb-12 px-4 sm:px-6 lg:px-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">
        Tournaments Calendar
    </h1>

    <div class="bg-white rounded-3xl shadow-2xl p-6 border border-gray-200">
        <!-- Month Navigation -->
        <div class="flex justify-between items-center mb-6">
            <button id="prevMonth" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Prev</button>
            <h2 id="monthYear" class="text-3xl font-semibold text-gray-900"></h2>
            <button id="nextMonth" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Next</button>
        </div>

        <!-- Calendar Grid -->
        <div id="calendarGrid" class="grid grid-cols-7 gap-3 text-sm"></div>
    </div>
</div>

<!-- Modal -->
<div id="modalOverlay" class="fixed inset-0 bg-white bg-opacity-50 backdrop-blur-sm hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-lg w-full relative shadow-2xl border border-gray-200">
        <button id="closeModal" class="absolute top-3 right-3 text-gray-600 font-bold text-xl">&times;</button>
        <h3 id="modalDate" class="text-2xl font-bold mb-4 text-gray-900"></h3>
        <ul id="modalTournaments" class="space-y-3 max-h-96 overflow-y-auto"></ul>
    </div>
</div>

<script>
    const tournaments = @json($events);
    let currentDate = new Date();
    const today = new Date();
    const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    const monthYearEl = document.getElementById('monthYear');
    const calendarGrid = document.getElementById('calendarGrid');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');

    const modalOverlay = document.getElementById('modalOverlay');
    const modalTournaments = document.getElementById('modalTournaments');
    const modalDate = document.getElementById('modalDate');
    const closeModal = document.getElementById('closeModal');

    function renderCalendar(date) {
        calendarGrid.innerHTML = '';
        const year = date.getFullYear();
        const month = date.getMonth();
        monthYearEl.textContent = `${monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        // Days of week header
        ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(d => {
            const el = document.createElement('div');
            el.className = 'font-bold text-center p-3 bg-indigo-100 rounded-md';
            el.textContent = d;
            calendarGrid.appendChild(el);
        });

        // Empty cells
        for (let i = 0; i < firstDay; i++) {
            const el = document.createElement('div');
            el.className = 'p-3';
            calendarGrid.appendChild(el);
        }

        for (let day = 1; day <= lastDate; day++) {
            const el = document.createElement('div');
            el.className = 'border p-3 h-36 flex flex-col items-center justify-center rounded-xl shadow-sm hover:shadow-lg transition cursor-pointer bg-white';

            if(day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                el.classList.add('bg-indigo-50');
            }

            const dayNumber = document.createElement('div');
            dayNumber.className = 'font-semibold mb-2 text-gray-900';
            dayNumber.textContent = day;
            el.appendChild(dayNumber);

            const dayEvents = tournaments.filter(ev => {
                const start = new Date(ev.start);
                return (
                    start.getFullYear() === year &&
                    start.getMonth() === month &&
                    start.getDate() === day
                );
            });

            const count = dayEvents.length;
            const countEl = document.createElement('div');
            countEl.className = 'text-xs font-semibold px-3 py-1 rounded-full text-white';
            if(count === 0) {
                countEl.classList.add('bg-gray-300');
                countEl.textContent = '';
            } else {
                countEl.textContent = `${count} tournament${count>1?'s':''}`;
                countEl.style.backgroundColor = '#3b82f6';
            }
            el.appendChild(countEl);

            // Click to open modal
            if(count > 0) {
                el.addEventListener('click', () => {
                    modalTournaments.innerHTML = '';
                    modalDate.textContent = `${monthNames[month]} ${day}, ${year}`;

                    dayEvents.forEach(ev => {
                        const li = document.createElement('li');
                        li.className = 'p-3 rounded-md cursor-pointer flex items-center justify-between bg-gray-50 border border-gray-200 hover:bg-gray-100 transition';

                        // Tournament title
                        const title = document.createElement('span');
                        title.className = 'font-medium text-gray-900';
                        title.textContent = ev.title;

                        // Gender badge
                        const badge = document.createElement('span');
                        badge.className = 'text-xs font-semibold px-2 py-1 rounded-full text-white';

                        if (ev.gender_type === 'mix') {
                            badge.textContent = 'Mixed';
                            badge.style.background = 'linear-gradient(135deg, #3b82f6, #ec4899)';
                        } else if (ev.gender_type === 'men') {
                            badge.textContent = 'Men';
                            badge.classList.add('bg-blue-500');
                        } else if (ev.gender_type === 'women') {
                            badge.textContent = 'Women';
                            badge.classList.add('bg-pink-500');
                        } else {
                            badge.textContent = 'Tournament';
                            badge.classList.add('bg-gray-500');
                        }

                        li.appendChild(title);
                        li.appendChild(badge);

                        li.addEventListener('click', () => window.location.href = ev.url);

                        modalTournaments.appendChild(li);
                    });

                    modalOverlay.classList.remove('hidden');
                    modalOverlay.classList.add('flex');
                });
            }

            calendarGrid.appendChild(el);
        }
    }

    closeModal.addEventListener('click', () => {
        modalOverlay.classList.add('hidden');
        modalOverlay.classList.remove('flex');
    });

    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
</script>
</x-app-layout>
