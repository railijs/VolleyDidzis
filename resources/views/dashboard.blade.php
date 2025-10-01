<x-app-layout>
    <div class="relative min-h-screen pt-24 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        <style>
            /* Watermark word */
            .watermark {
                letter-spacing: -0.02em;
                line-height: .9;
                user-select: none;
            }

            /* Page-load / reveal (no libs, reduced-motion aware) */
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .6s ease, transform .6s ease;
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none;
                }
            }

            /* Scroll cue wiggle (optional) */
            @keyframes nudge {

                0%,
                100% {
                    transform: translateY(0);
                    opacity: .8
                }

                50% {
                    transform: translateY(6px);
                    opacity: 1
                }
            }
        </style>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $calendarEvents = ($tournaments ?? collect())
                    ->map(function ($t) {
                        return [
                            'title' => $t->name,
                            'start' => \Carbon\Carbon::parse($t->start_date)->toDateString(),
                            'end' => \Carbon\Carbon::parse($t->end_date ?? $t->start_date)->toDateString(),
                            'gender_type' => $t->gender_type,
                            'url' => route('tournaments.show', $t),
                        ];
                    })
                    ->values();

                $featured = $news->first();
                $newsBar = $news->skip(1)->take(8);
                $closestTournaments = $tournaments->sortBy('start_date')->take(4);
            @endphp

            @if ($news->isNotEmpty())
                <!-- ===================== HERO / FEATURED ===================== -->
                <section class="relative overflow-hidden rounded-[2rem] shadow-2xl mb-12 group fade-up">
                    <!-- BG image -->
                    <div class="absolute inset-0">
                        @if ($featured->image)
                            <img src="{{ Storage::url($featured->image) }}" alt="{{ $featured->title }}"
                                class="w-full h-[26rem] sm:h-[30rem] object-cover transition duration-700 ease-out group-hover:scale-[1.03]">
                        @else
                            <img src="https://images.unsplash.com/photo-1541494800-b7672acb4c5e?q=80&w=1600&auto=format&fit=crop"
                                alt="Pagaidu attēls"
                                class="w-full h-[26rem] sm:h-[30rem] object-cover transition duration-700 ease-out group-hover:scale-[1.03]">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/10"></div>
                    </div>

                    <!-- Watermark -->
                    <div class="absolute inset-x-0 bottom-[-.35em] px-6 sm:px-10 pointer-events-none">
                        <div
                            class="watermark text-[28vw] sm:text-[20vw] font-extrabold text-white/10 uppercase tracking-tight">
                            volejbols
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 grid md:grid-cols-[1.4fr,.9fr] gap-6 sm:gap-10 p-6 sm:p-10">
                        <!-- Left -->
                        <div class="flex flex-col justify-end">
                            <span class="text-red-300/90 text-xs font-bold uppercase tracking-[0.18em]">Digest</span>
                            <h1
                                class="mt-2 text-white font-extrabold leading-[1.02] text-3xl sm:text-5xl md:text-6xl max-w-2xl">
                                {{ $featured->title }}
                            </h1>
                            <p class="mt-4 text-white/90 max-w-xl text-sm sm:text-base">
                                {{ Str::limit(strip_tags($featured->content), 180) }}
                            </p>
                            <div class="mt-6 flex items-center gap-4">
                                <a href="{{ route('news.show', $featured) }}"
                                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 shadow transition">
                                    Lasīt vairāk
                                </a>
                                <span class="text-white/70 text-xs">{{ $featured->created_at->format('d.m.Y') }}</span>
                            </div>

                            <!-- Scroll cue -->
                            <div class="mt-10 flex items-center gap-2 text-white/80 text-xs">
                                <span
                                    class="inline-block w-3 h-3 rounded-full bg-white/80 animate-[nudge_1.8s_ease-in-out_infinite]"></span>
                                Uz leju
                            </div>
                        </div>

                        <!-- Right: recent card -->
                        <aside class="rounded-2xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-sm">
                            @php $rp = $newsBar->first(); @endphp
                            <div class="p-5 pb-3 text-white/90">
                                <p class="uppercase text-xs tracking-widest text-white/70">Recent Post</p>
                            </div>
                            <div class="px-5">
                                <a href="{{ $rp ? route('news.show', $rp) : '#' }}"
                                    class="block overflow-hidden rounded-xl">
                                    @if ($rp && $rp->image)
                                        <img src="{{ Storage::url($rp->image) }}" alt="{{ $rp->title }}"
                                            class="w-full h-40 object-cover transition duration-500 group-hover:scale-[1.02]">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop"
                                            alt="Pagaidu attēls"
                                            class="w-full h-40 object-cover transition duration-500 group-hover:scale-[1.02]">
                                    @endif
                                </a>
                            </div>
                            <div class="p-5 pt-3 text-white">
                                <p class="text-[11px] uppercase tracking-widest text-white/70">
                                    Trending • {{ $rp?->created_at?->format('M d, Y') }}
                                </p>
                                <h3 class="mt-1 text-lg font-bold leading-snug">
                                    <a href="{{ $rp ? route('news.show', $rp) : '#' }}" class="hover:text-red-300">
                                        {{ $rp->title ?? 'Nosaukums drīzumā' }}
                                    </a>
                                </h3>
                            </div>
                        </aside>
                    </div>
                </section>

                <!-- ===================== GRID (LEFT/RIGHT) ===================== -->
                <div class="grid lg:grid-cols-[2fr,1fr] gap-10 items-start">

                    <!-- LEFT -->
                    <div class="space-y-12">

                        <!-- Tournaments -->
                        @if ($closestTournaments->isNotEmpty())
                            <section class="fade-up">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-5 w-1.5 bg-red-600 rounded"></div>
                                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Tuvākie Turnīri
                                        </h2>
                                    </div>
                                    <a href="{{ route('tournaments.index') }}"
                                        class="text-sm font-semibold text-red-600 hover:text-red-800">Visi turnīri →</a>
                                </div>

                                <div class="space-y-4">
                                    @foreach ($closestTournaments as $tournament)
                                        @php
                                            $gender = $tournament->gender_type;
                                            $badgeColor = match ($gender) {
                                                'men' => 'bg-blue-500',
                                                'women' => 'bg-pink-500',
                                                'mix' => 'bg-purple-500',
                                                default => 'bg-gray-400',
                                            };
                                        @endphp
                                        <div
                                            class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-4 flex items-center justify-between transition hover:shadow-lg hover:border-gray-300">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="flex flex-col items-center justify-center bg-red-600 text-white rounded-lg px-3 py-2 w-16 shadow">
                                                    <span
                                                        class="text-lg font-bold">{{ \Carbon\Carbon::parse($tournament->start_date)->format('d') }}</span>
                                                    <span
                                                        class="text-xs uppercase">{{ \Carbon\Carbon::parse($tournament->start_date)->format('M') }}</span>
                                                </div>
                                                <div>
                                                    <h3 class="text-base sm:text-lg font-bold text-gray-900">
                                                        {{ $tournament->name }}</h3>
                                                    <div class="flex flex-wrap gap-2 mt-1 text-xs text-gray-500">
                                                        <span>📍 {{ $tournament->location ?? 'TBA' }}</span>
                                                        <span
                                                            class="px-2 py-0.5 rounded text-white {{ $badgeColor }}">{{ ucfirst($gender) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('tournaments.show', $tournament) }}"
                                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow">
                                                Skatīt
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        <!-- Calendar -->
                        <section class="mt-12 fade-up">
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-3">
                                <span class="h-5 w-1.5 bg-red-600 rounded"></span>
                                Turnīru Kalendārs
                            </h2>

                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-6">
                                <div class="flex justify-between items-center mb-6">
                                    <button id="prevMonth"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">←</button>
                                    <h2 id="monthYear" class="text-2xl font-semibold text-gray-900"></h2>
                                    <button id="nextMonth"
                                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">→</button>
                                </div>

                                <!-- Week header -->
                                <div class="grid grid-cols-7 gap-3 text-sm mb-2">
                                    @foreach (['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'] as $wd)
                                        <div class="font-bold text-center p-2 bg-red-100 rounded-md">
                                            {{ $wd }}</div>
                                    @endforeach
                                </div>

                                <!-- Grid -->
                                <div id="calendarGrid" class="grid grid-cols-7 gap-3 text-sm"></div>
                            </div>
                        </section>
                    </div>

                    <!-- RIGHT: News Bar -->
                    <aside class="space-y-6 fade-up">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Ziņu josla</h2>
                            <a href="{{ route('news.index') }}"
                                class="text-sm font-semibold text-red-600 hover:text-red-800">Visas ziņas →</a>
                        </div>

                        @foreach ($newsBar as $item)
                            <article
                                class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden transition hover:shadow-lg hover:border-gray-300">
                                <a href="{{ route('news.show', $item) }}" class="flex">
                                    <div class="w-24 h-24 shrink-0 overflow-hidden">
                                        @if ($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                                class="w-24 h-24 object-cover transition duration-500 hover:scale-[1.04]">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop"
                                                alt="Pagaidu attēls"
                                                class="w-24 h-24 object-cover transition duration-500 hover:scale-[1.04]">
                                        @endif
                                    </div>
                                    <div class="p-3 flex-1">
                                        <h3
                                            class="font-semibold text-gray-900 leading-snug line-clamp-2 hover:text-red-600 transition">
                                            {{ $item->title }}
                                        </h3>
                                        <p class="text-[11px] text-gray-500 mt-1">
                                            {{ $item->created_at->format('d.m.Y') }}</p>
                                    </div>
                                </a>
                            </article>
                        @endforeach

                        <div class="pt-2">
                            <a href="{{ route('news.index') }}"
                                class="inline-flex items-center justify-center w-full text-sm font-semibold text-red-700 hover:text-red-900">
                                Visas ziņas →
                            </a>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div id="modalOverlay" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
        <div class="bg-white rounded-2xl p-6 max-w-lg w-full relative shadow-2xl">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 font-bold text-xl">&times;</button>
            <h3 id="modalDate" class="text-2xl font-bold mb-4 text-gray-900"></h3>
            <ul id="modalTournaments" class="space-y-3 max-h-96 overflow-y-auto"></ul>
        </div>
    </div>

    <!-- ========= COMBINED REGISTER + CONTACTS FOOTER ========= -->
    <footer class="bg-gradient-to-r from-red-600 to-red-700 text-white mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Pieteikties (only for guests) --}}
            @guest
                <section class="py-16 fade-up">
                    <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Pieteikties</h2>
                            <p class="text-lg text-red-100 leading-relaxed">
                                Izveido kontu un pievienojies turnīriem vieglāk un ātrāk! Reģistrējoties tu varēsi sekot
                                līdzi
                                turnīru grafikam, pieteikt komandu un iegūt pilnu piekļuvi visām VolleyLV iespējām.
                            </p>
                            <p class="mt-6 text-red-100">
                                Jau ir konts? <a href="{{ route('login') }}"
                                    class="underline font-semibold hover:text-white">Pieslēgties</a>
                            </p>
                        </div>

                        <form method="POST" action="{{ route('register') }}"
                            class="bg-white rounded-2xl shadow-lg p-8 text-left text-gray-900">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Vārds</label>
                                <input id="name" name="name" type="text" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" />
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">E-pasts</label>
                                <input id="email" name="email" type="email" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" />
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Parole</label>
                                <input id="password" name="password" type="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" />
                            </div>
                            <div class="mb-6">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700">Apstiprināt paroli</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" />
                            </div>
                            <button type="submit"
                                class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition">
                                Reģistrēties
                            </button>
                        </form>
                    </div>
                </section>

                {{-- subtle divider to separate from contacts while keeping same element/background --}}
                <div class="h-px bg-white/10"></div>
            @endguest

            {{-- Contacts --}}
            <div class="py-10">
                <div class="grid md:grid-cols-2 gap-8">
                    <div>
                        <p class="uppercase tracking-[0.2em] text-[11px] text-red-100/90 font-bold">Kontakti</p>
                        <h3 class="text-2xl sm:text-3xl font-extrabold mt-1">Sazinies ar VolleyLV</h3>
                        <p class="mt-2 text-red-100">
                            Jautājumi par turnīriem, sadarbības piedāvājumi vai atbalsts — droši raksti vai zvani.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="tel:+37120001234"
                            class="group inline-flex items-center gap-3 rounded-xl border border-white/20 bg-white/10 px-4 py-3 hover:bg-white/15 hover:border-white/30 transition">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-white/90 group-hover:scale-110 transition" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M6.62 10.79a15.05 15.05 0 006.59 6.59l1.82-1.82a1 1 0 011.01-.24c1.1.37 2.28.57 3.5.57a1 1 0 011 1V21a1 1 0 01-1 1C10.07 22 2 13.93 2 3a1 1 0 011-1h3.11a1 1 0 011 1c0 1.22.2 2.4.57 3.5a1 1 0 01-.24 1.01l-1.82 1.82z" />
                            </svg>
                            <span class="font-semibold">+371 20001234</span>
                        </a>

                        <a href="mailto:info@volleylv.example"
                            class="group inline-flex items-center gap-3 rounded-xl border border-white/20 bg-white/10 px-4 py-3 hover:bg-white/15 hover:border-white/30 transition">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-white/90 group-hover:scale-110 transition" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18V8.236l7.386 5.74a1 1 0 001.228 0L20 8.236V18H4z" />
                            </svg>
                            <span class="font-semibold">info@volleylv.example</span>
                        </a>

                        <div class="flex items-center gap-3 pt-1 text-sm text-red-100">
                            <span class="inline-flex items-center gap-1">
                                <span class="h-2 w-2 rounded-full bg-green-300"></span> Atbildam darba dienās
                                09:00–18:00
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-center text-xs text-red-100 mt-6">
                    © {{ date('Y') }} VolleyLV. Visas tiesības aizsargātas.
                </div>
            </div>
        </div>
    </footer>


    <!-- JS: page-load class + calendar -->
    <script>
        // Page-load animation trigger
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });

        // Calendar
        const tournamentsData = @json($calendarEvents);
        let currentDate = new Date();
        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts",
            "Septembris", "Oktobris", "Novembris", "Decembris"
        ];
        const monthYearEl = document.getElementById('monthYear');
        const calendarGrid = document.getElementById('calendarGrid');
        const modalOverlay = document.getElementById('modalOverlay');
        const modalDate = document.getElementById('modalDate');
        const modalTournaments = document.getElementById('modalTournaments');
        const closeModal = document.getElementById('closeModal');

        const parseYMD = (ymd) => {
            const [y, m, d] = ymd.split('-').map(Number);
            return new Date(y, m - 1, d);
        };

        function renderCalendar(date) {
            calendarGrid.innerHTML = '';
            const year = date.getFullYear();
            const month = date.getMonth();
            monthYearEl.textContent = `${monthNames[month]} ${year}`;

            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();

            // Empty cells
            for (let i = 0; i < firstDayIndex; i++) {
                const spacer = document.createElement('div');
                spacer.className = 'p-2';
                calendarGrid.appendChild(spacer);
            }

            for (let day = 1; day <= lastDate; day++) {
                const cell = document.createElement('div');
                cell.className =
                    'border p-2 h-24 rounded-xl bg-white flex flex-col text-xs transition hover:shadow-md hover:ring-1 hover:ring-red-200';

                const label = document.createElement('div');
                label.className = 'font-semibold text-gray-900';
                label.textContent = day;
                cell.appendChild(label);

                const cellDate = new Date(year, month, day);
                const dayEvents = tournamentsData.filter(ev => {
                    const s = parseYMD(ev.start),
                        e = parseYMD(ev.end || ev.start);
                    return cellDate >= s && cellDate <= e;
                });

                if (dayEvents.length > 0) {
                    if (dayEvents.length <= 3) {
                        dayEvents.forEach(ev => {
                            const badge = document.createElement('span');
                            badge.textContent = ev.title;
                            badge.title = ev.title;
                            badge.className =
                                'mt-1 px-2 py-0.5 rounded-full text-white truncate cursor-pointer bg-red-500';
                            badge.onclick = () => ev.url && (window.location.href = ev.url);
                            cell.appendChild(badge);
                        });
                    } else {
                        const more = document.createElement('span');
                        more.textContent = `+${dayEvents.length} turnīri`;
                        more.className = 'mt-auto text-xs font-semibold text-red-600 cursor-pointer';
                        more.onclick = () => {
                            modalDate.textContent =
                                `${String(day).padStart(2,'0')}.${String(month+1).padStart(2,'0')}.${year}`;
                            modalTournaments.innerHTML = '';
                            dayEvents.forEach(ev => {
                                const li = document.createElement('li');
                                li.className =
                                    'p-2 bg-gray-100 rounded cursor-pointer hover:bg-gray-200 flex items-center justify-between gap-3';
                                li.innerHTML = `<span class="font-medium text-gray-800">${ev.title}</span>`;
                                li.onclick = () => ev.url && (window.location.href = ev.url);
                                modalTournaments.appendChild(li);
                            });
                            modalOverlay.classList.remove('hidden');
                            modalOverlay.classList.add('flex');
                        };
                        cell.appendChild(more);
                    }
                }

                calendarGrid.appendChild(cell);
            }
        }

        document.getElementById('prevMonth').onclick = () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        };
        document.getElementById('nextMonth').onclick = () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        };
        closeModal.onclick = () => {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
        };

        renderCalendar(currentDate);
    </script>
</x-app-layout>
