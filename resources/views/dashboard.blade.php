<x-app-layout>
    <div class="relative min-h-screen pt-24 pb-0 bg-gradient-to-b from-white via-red-50 to-white overflow-x-hidden">
        <style>
            :root {
                --ease: cubic-bezier(.22, .55, .15, 1);
            }

            @keyframes fadeUp {
                0% {
                    opacity: 0;
                    transform: translateY(18px) scale(.985)
                }

                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1)
                }
            }

            .animate-fade-up {
                animation: fadeUp .7s var(--ease) .05s both;
            }

            @media (max-width: 400px) {
                .xs-center {
                    width: 100%;
                    max-width: 360px;
                    margin-inline: auto;
                }

                .minw0 {
                    min-width: 0 !important;
                }

                .truncate-safe {
                    min-width: 0;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
            }

            .card {
                transition: transform .2s var(--ease), box-shadow .2s var(--ease), border-color .2s;
                will-change: transform;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 16px 32px -20px rgba(0, 0, 0, .35);
            }

            .card:focus-within {
                box-shadow: 0 0 0 3px rgba(239, 68, 68, .20);
            }

            .cal-cell {
                transition: box-shadow .18s var(--ease), transform .18s var(--ease), border-color .18s;
            }

            .cal-cell:hover {
                transform: translateY(-1px);
                box-shadow: 0 12px 26px -18px rgba(0, 0, 0, .35);
            }

            @keyframes modalIn {
                from {
                    opacity: 0;
                    transform: translateY(10px) scale(.98)
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1)
                }
            }

            #modalOverlay .modal-card {
                animation: modalIn .25s var(--ease) both;
            }

            @media (max-width: 360px) {
                .hero-title {
                    font-size: 1.35rem;
                    line-height: 1.15;
                }

                .news-thumb {
                    width: 64px !important;
                    height: 64px !important;
                }

                .date-badge {
                    width: 3rem !important;
                }

                .cta-btn {
                    padding: .6rem .9rem !important;
                }
            }
        </style>

        <div class="max-w-7xl mx-auto px-2 min-[360px]:px-3 sm:px-6 lg:px-8">

            @php
                $calendarEvents = ($tournaments ?? collect())
                    ->map(function ($t) {
                        $appsCount = method_exists($t, 'applications') ? $t->applications()->count() : 0;
                        $isFull = $t->max_teams ? $appsCount >= (int) $t->max_teams : false;

                        return [
                            'title' => $t->name,
                            'start' => \Carbon\Carbon::parse($t->start_date)->toDateString(),
                            'end' => \Carbon\Carbon::parse($t->end_date ?? $t->start_date)->toDateString(),
                            'gender_type' => $t->gender_type,
                            'status' => $t->status,
                            'is_full' => $isFull,
                            'url' => route('tournaments.show', $t),
                        ];
                    })
                    ->values();

                $featured = $news->first();
                $newsBar = $news->skip(1)->take(8);
                $closestTournaments = $tournaments->sortBy('start_date')->take(4);
            @endphp

            @if ($news->isNotEmpty())
                {{-- ===================== HERO / FEATURED ===================== --}}
                <section
                    class="relative overflow-hidden rounded-[1.25rem] sm:rounded-[2rem] shadow-2xl mb-8 sm:mb-12 group">
                    <div class="absolute inset-0">
                        @if ($featured->image_url)
                            <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}"
                                class="w-full h-[18rem] sm:h-[22rem] lg:h-[26rem] object-cover transition duration-700 ease-out group-hover:scale-[1.02]"
                                referrerpolicy="no-referrer" loading="lazy"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1541494800-b7672acb4c5e?q=80&w=1600&auto=format&fit=crop';">
                        @else
                            <img src="https://images.unsplash.com/photo-1541494800-b7672acb4c5e?q=80&w=1600&auto=format&fit=crop"
                                alt="Pagaidu attēls"
                                class="w-full h-[18rem] sm:h-[22rem] lg:h-[26rem] object-cover transition duration-700 ease-out group-hover:scale-[1.02]"
                                loading="lazy">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-black/10"></div>
                    </div>

                    <div class="relative z-10 p-4 sm:p-8 lg:p-10">
                        <div class="grid lg:grid-cols-[1.6fr,1fr] gap-6 lg:gap-10 items-end">
                            <div class="max-w-3xl">
                                <span
                                    class="text-red-300/90 text-[11px] font-bold uppercase tracking-[0.18em]">VolleyLV</span>
                                <h1
                                    class="mt-2 text-white font-extrabold leading-[1.02] text-2xl sm:text-4xl lg:text-5xl">
                                    {{ $featured->title }}
                                </h1>
                                <p
                                    class="mt-3 text-white/90 text-sm sm:text-base line-clamp-3 sm:line-clamp-none max-w-2xl">
                                    {{ Str::limit(strip_tags($featured->content), 200) }}
                                </p>
                                <div class="mt-4 flex items-center gap-4">
                                    <a href="{{ route('news.show', $featured) }}"
                                        class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2.5 shadow transition cta-btn"
                                        data-transition data-prefetch>
                                        Lasīt vairāk
                                    </a>
                                    <span
                                        class="text-white/70 text-xs">{{ $featured->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>

                            <aside class="hidden lg:block">
                                @php $rp = $newsBar->first(); @endphp
                                <div
                                    class="rounded-2xl overflow-hidden border border-white/15 bg-white/10 backdrop-blur-md card">
                                    <div class="p-5 pb-3 text-white/90">
                                        <p class="uppercase text-xs tracking-widest text-white/70">Recent Post</p>
                                    </div>
                                    <div class="px-5">
                                        <a href="{{ $rp ? route('news.show', $rp) : '#' }}"
                                            class="block overflow-hidden rounded-xl" data-transition data-prefetch>
                                            @if ($rp && $rp->image_url)
                                                <img src="{{ $rp->image_url }}" alt="{{ $rp->title }}"
                                                    class="w-full h-40 object-cover transition duration-500 group-hover:scale-[1.02]"
                                                    referrerpolicy="no-referrer" loading="lazy"
                                                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop';">
                                            @else
                                                <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop"
                                                    alt="Pagaidu attēls"
                                                    class="w-full h-40 object-cover transition duration-500 group-hover:scale-[1.02]"
                                                    loading="lazy">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="p-5 pt-3 text-white">
                                        <p class="text-[11px] uppercase tracking-widest text-white/70">
                                            Trending • {{ $rp?->created_at?->format('M d, Y') }}
                                        </p>
                                        <h3 class="mt-1 text-lg font-bold leading-snug">
                                            <a href="{{ $rp ? route('news.show', $rp) : '#' }}"
                                                class="hover:text-red-300 line-clamp-2" data-transition data-prefetch>
                                                {{ $rp->title ?? 'Nosaukums drīzumā' }}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </section>

                {{-- ===================== GRID (LEFT/RIGHT) ===================== --}}
                <div class="grid lg:grid-cols-[2fr,1fr] gap-8 sm:gap-10 items-start">
                    {{-- LEFT (now centered on xs) --}}
                    <div class="space-y-10 sm:space-y-12 xs-center">
                        {{-- Tuvākie Turnīri --}}
                        @if ($closestTournaments->isNotEmpty())
                            <section class="animate-fade-up">
                                <div class="flex items-center justify-between mb-4 sm:mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-4 w-1.5 bg-red-600 rounded sm:h-5"></div>
                                        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900">Tuvākie Turnīri
                                        </h2>
                                    </div>
                                    <a href="{{ route('tournaments.index') }}"
                                        class="text-sm font-semibold text-red-600 hover:text-red-800" data-transition
                                        data-prefetch>Visi turnīri →</a>
                                </div>

                                <div class="space-y-3 sm:space-y-4">
                                    @foreach ($closestTournaments as $tournament)
                                        @php
                                            $gender = $tournament->gender_type;
                                            $badgeColor = match ($gender) {
                                                'men' => 'bg-blue-500',
                                                'women' => 'bg-pink-500',
                                                'mix' => 'bg-purple-500',
                                                default => 'bg-gray-400',
                                            };

                                            $appsCount = method_exists($tournament, 'applications')
                                                ? $tournament->applications()->count()
                                                : 0;
                                            $isFullCard = $tournament->max_teams
                                                ? $appsCount >= (int) $tournament->max_teams
                                                : false;

                                            $status = $tournament->status;
                                            [$statusText, $statusChip] = match ($status) {
                                                'active' => [
                                                    'Aktīvs',
                                                    'bg-emerald-50 text-emerald-800 ring-emerald-200',
                                                ],
                                                'completed' => ['Pabeigts', 'bg-gray-50 text-gray-800 ring-gray-200'],
                                                default => [
                                                    'Gaida sākumu',
                                                    'bg-amber-50 text-amber-800 ring-amber-200',
                                                ],
                                            };

                                            $pct = $tournament->max_teams
                                                ? min(
                                                    100,
                                                    round(($appsCount / max(1, (int) $tournament->max_teams)) * 100),
                                                )
                                                : null;
                                            $barColor =
                                                $pct >= 100
                                                    ? 'bg-red-500'
                                                    : ($pct >= 80
                                                        ? 'bg-amber-500'
                                                        : 'bg-green-500');
                                        @endphp

                                        <div
                                            class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-3 sm:p-4 transition hover:shadow-lg hover:border-gray-300 card">
                                            <div class="flex items-center justify-between gap-3">
                                                <div class="flex items-center gap-3 sm:gap-4 minw0">
                                                    <div
                                                        class="date-badge flex flex-col items-center justify-center bg-red-600 text-white rounded-lg px-2.5 py-2 w-14 sm:px-3 sm:py-2 sm:w-16 shadow">
                                                        <span class="text-base sm:text-lg font-bold">
                                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d') }}
                                                        </span>
                                                        <span class="text-[10px] sm:text-xs uppercase">
                                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('M') }}
                                                        </span>
                                                    </div>
                                                    <div class="minw0">
                                                        <h3 class="text-sm sm:text-lg font-bold text-gray-900 truncate">
                                                            {{ $tournament->name }}</h3>
                                                        <div
                                                            class="mt-1 flex flex-wrap items-center gap-1.5 sm:gap-2 text-[11px] sm:text-xs">
                                                            <span class="text-gray-500 truncate">📍
                                                                {{ $tournament->location ?? 'TBA' }}</span>
                                                            <span
                                                                class="px-2 py-0.5 rounded text-white {{ $badgeColor }}">{{ ucfirst($gender) }}</span>
                                                            <span
                                                                class="inline-flex items-center gap-1 rounded-full ring-1 px-2 py-0.5 {{ $statusChip }}">{{ $statusText }}</span>
                                                            @if ($isFullCard)
                                                                <span
                                                                    class="inline-flex items-center rounded-full bg-red-600 text-white px-2 py-0.5 font-semibold">Pilns</span>
                                                            @endif
                                                        </div>

                                                        @if (!is_null($pct))
                                                            <div class="mt-2 max-w-[12rem]">
                                                                <div
                                                                    class="h-1 w-full rounded-full bg-slate-200/70 overflow-hidden">
                                                                    <div class="h-full {{ $barColor }}"
                                                                        style="width: {{ $pct }}%"></div>
                                                                </div>
                                                                <p class="mt-1 text-[10px] text-gray-500">
                                                                    {{ $appsCount }}/{{ (int) $tournament->max_teams }}
                                                                    ({{ $pct }}%)
                                                                </p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="flex items-center gap-2">
                                                    <a href="{{ route('tournaments.show', $tournament) }}"
                                                        class="px-2.5 py-1.5 sm:px-3 sm:py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs sm:text-sm font-semibold shadow whitespace-nowrap"
                                                        data-transition data-prefetch>
                                                        Skatīt
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endif

                        {{-- Calendar (mobile agenda + md+ grid) --}}
                        <section class="mt-8 sm:mt-12 animate-fade-up">
                            <h2
                                class="text-xl sm:text-3xl font-extrabold text-gray-900 mb-4 sm:mb-6 flex items-center gap-3">
                                <span class="h-4 w-1.5 sm:h-5 bg-red-600 rounded"></span>
                                Turnīru Kalendārs
                            </h2>

                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm p-4 sm:p-6">
                                <div class="flex justify-between items-center mb-4 sm:mb-6 gap-2">
                                    <button id="prevMonth"
                                        class="px-3 py-2 sm:px-4 bg-red-600 text-white rounded-md hover:bg-red-700 shrink-0">←</button>
                                    <h2 id="monthYear"
                                        class="flex-1 minw0 text-center text-lg sm:text-2xl font-semibold text-gray-900 truncate">
                                    </h2>
                                    <button id="nextMonth"
                                        class="px-3 py-2 sm:px-4 bg-red-600 text-white rounded-md hover:bg-red-700 shrink-0">→</button>
                                </div>

                                {{-- Week header (desktop only) --}}
                                <div
                                    class="hidden md:grid grid-cols-7 gap-1.5 sm:gap-3 text-[11px] sm:text-sm mb-1.5 sm:mb-2">
                                    @foreach (['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'] as $wd)
                                        <div class="font-bold text-center p-1.5 sm:p-2 bg-red-100 rounded-md">
                                            {{ $wd }}</div>
                                    @endforeach
                                </div>

                                {{-- Desktop Month Grid --}}
                                <div id="calendarGrid"
                                    class="hidden md:grid grid-cols-7 gap-1.5 sm:gap-3 text-[11px] sm:text-sm"></div>

                                {{-- Mobile Agenda --}}
                                <div id="mobileAgenda" class="md:hidden space-y-2"></div>

                                {{-- Legend --}}
                                <div
                                    class="mt-4 flex flex-wrap items-center justify-center gap-3 text-[11px] text-gray-600">
                                    <span class="inline-flex items-center gap-1"><span
                                            class="inline-block h-2 w-2 rounded-full bg-amber-500"></span> Gaida
                                        sākumu</span>
                                    <span class="inline-flex items-center gap-1"><span
                                            class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                                        Aktīvs</span>
                                    <span class="inline-flex items-center gap-1"><span
                                            class="inline-block h-2 w-2 rounded-full bg-gray-500"></span>
                                        Pabeigts</span>
                                    <span class="inline-flex items-center gap-1"><span
                                            class="inline-block h-2 w-2 rounded-full ring-2 ring-red-500"></span>
                                        Pilns</span>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- RIGHT: News Bar (also centered on xs) --}}
                    <aside class="space-y-4 sm:space-y-6 animate-fade-up xs-center">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg sm:text-2xl font-extrabold text-gray-900">Ziņu josla</h2>
                            <a href="{{ route('news.index') }}"
                                class="text-sm font-semibold text-red-600 hover:text-red-800" data-transition
                                data-prefetch>Visas ziņas →</a>
                        </div>

                        @foreach ($newsBar as $item)
                            <article
                                class="bg-white/80 backdrop-blur-sm rounded-2xl border border-gray-200/60 shadow-sm overflow-hidden transition hover:shadow-lg hover:border-gray-300 card">
                                <a href="{{ route('news.show', $item) }}" class="flex minw0" data-transition
                                    data-prefetch>
                                    <div
                                        class="news-thumb w-20 h-20 max-[360px]:w-16 max-[360px]:h-16 shrink-0 overflow-hidden">
                                        @if ($item->image_url)
                                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                                class="w-full h-full object-cover transition duration-500 hover:scale-[1.04]"
                                                referrerpolicy="no-referrer" loading="lazy"
                                                onerror="this.onerror=null; this.style.display='none';">
                                        @else
                                            <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=800&auto=format&fit=crop"
                                                alt="Pagaidu attēls"
                                                class="w-full h-full object-cover transition duration-500 hover:scale-[1.04]"
                                                loading="lazy">
                                        @endif
                                    </div>
                                    <div class="p-3 flex-1 minw0">
                                        <h3
                                            class="font-semibold text-gray-900 leading-snug hover:text-red-600 transition text-sm line-clamp-2">
                                            {{ $item->title }}
                                        </h3>
                                        <p class="text-[10px] sm:text-[11px] text-gray-500 mt-1">
                                            {{ $item->created_at->format('d.m.Y') }}</p>
                                    </div>
                                </a>
                            </article>
                        @endforeach

                        <div class="pt-1 sm:pt-2">
                            <a href="{{ route('news.index') }}"
                                class="inline-flex items-center justify-center w-full text-sm font-semibold text-red-700 hover:text-red-900"
                                data-transition data-prefetch>
                                Visas ziņas →
                            </a>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal --}}
    <div id="modalOverlay" class="fixed inset-0 bg-black/40 hidden justify-center items-center z-50">
        <div class="modal-card bg-white rounded-2xl p-6 max-w-lg w-full relative shadow-2xl">
            <button id="closeModal" class="absolute top-3 right-3 text-gray-600 font-bold text-xl"
                aria-label="Aizvērt">&times;</button>
            <h3 id="modalDate" class="text-xl sm:text-2xl font-bold mb-4 text-gray-900"></h3>
            <ul id="modalTournaments" class="space-y-3 max-h-96 overflow-y-auto"></ul>
        </div>
    </div>

    {{-- Small spacer between calendar and footer --}}
    <div class="h-4 sm:h-6"></div>

    {{-- Footer (simplified + centered left block, no contacts row) --}}
    <footer class="bg-red-600  text-white">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-8 sm:py-10">
            @guest
                <div class="grid lg:grid-cols-2 gap-6 lg:gap-10 items-center">
                    {{-- Left: centered vertically --}}
                    <section class="flex flex-col justify-center text-center">
                        <h2 class="text-2xl sm:text-3xl font-extrabold">Ienākt — VolleyLV</h2>
                        <p class="mt-2 text-red-100 max-w-xl mx-auto">
                            Ienāc, lai sekotu turnīriem, pārvaldītu komandas un redzētu jaunākās ziņas.
                        </p>
                    </section>

                    {{-- Right: simple login card --}}
                    <section class="xs-center">
                        <div class="bg-white text-neutral-900 rounded-xl shadow-lg ring-1 ring-black/5 p-6 sm:p-7">
                            <h3 class="text-lg font-extrabold text-center">Laipni lūdzam atpakaļ</h3>
                            <p class="text-sm text-neutral-600 mt-1 text-center">Ienāc ar savu e-pastu un paroli.</p>

                            @if ($errors->any())
                                <div
                                    class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div
                                    class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- Login form --}}
                            <form method="POST" action="{{ route('login') }}" class="mt-5 space-y-4">
                                @csrf
                                <div>
                                    <label for="email" class="block text-sm font-medium mb-1">E-pasts</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        required
                                        class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600"
                                        placeholder="you@example.com" />
                                </div>
                                <div>
                                    <label for="password" class="block text-sm font-medium mb-1">Parole</label>
                                    <input id="password" type="password" name="password" required
                                        class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-neutral-900 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600"
                                        placeholder="••••••••" />
                                </div>
                                <div class="flex items-center">
                                    <label for="remember_me" class="inline-flex items-center gap-2">
                                        <input id="remember_me" type="checkbox" name="remember"
                                            class="rounded border-neutral-300 text-red-600 shadow-sm focus:ring-red-600">
                                        <span class="text-sm text-neutral-700">Atcerēties mani</span>
                                    </label>
                                </div>
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                    <a href="{{ route('register') }}"
                                        class="text-sm text-neutral-600 hover:text-neutral-800 underline underline-offset-4"
                                        data-transition data-prefetch>
                                        Vai nav konta? Reģistrējies
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-red-600 text-white font-semibold px-6 py-2.5 shadow hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                                        Ienāc
                                    </button>
                                </div>
                            </form>

                            {{-- Guest CTA --}}
                            @if (Route::has('guest.login'))
                                <form method="POST" action="{{ route('guest.login') }}" class="mt-4">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-full rounded-lg bg-neutral-100 text-neutral-900 font-semibold px-4 py-2.5 shadow hover:bg-neutral-200 transition">
                                        Turpināt kā viesim
                                    </button>
                                </form>
                            @endif
                        </div>
                    </section>
                </div>
            @endguest

            <div class="mt-6 text-center text-white/90 text-sm">
                © {{ now()->year }} VolleyLV — Visi tiesību aizsargāti
            </div>
        </div>
    </footer>

    {{-- JS: page-load flag + calendar + small enhancements --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });

        const tournamentsData = @json($calendarEvents);
        let currentDate = new Date();

        const monthNames = ["Janvāris", "Februāris", "Marts", "Aprīlis", "Maijs", "Jūnijs", "Jūlijs", "Augusts",
            "Septembris", "Oktobris", "Novembris", "Decembris"
        ];
        const wdShort = ["Sv", "Pr", "Ot", "Tr", "Ce", "Pk", "Se"];

        const monthYearEl = document.getElementById('monthYear');
        const calendarGrid = document.getElementById('calendarGrid');
        const mobileAgenda = document.getElementById('mobileAgenda');

        const modalOverlay = document.getElementById('modalOverlay');
        const modalDate = document.getElementById('modalDate');
        const modalTournaments = document.getElementById('modalTournaments');

        const parseYMD = (ymd) => {
            const [y, m, d] = ymd.split('-').map(Number);
            return new Date(y, m - 1, d);
        };
        const statusDotClass = (s) => s === 'active' ? 'bg-emerald-500' : (s === 'completed' ? 'bg-gray-500' :
            'bg-amber-500');
        const statusChipClass = (s) => s === 'active' ? 'bg-emerald-600' : (s === 'completed' ? 'bg-gray-600' :
            'bg-amber-600');

        function buildMonthMap(year, month) {
            const first = new Date(year, month, 1);
            const last = new Date(year, month + 1, 0);
            const map = Object.create(null);

            for (const ev of tournamentsData) {
                const sRaw = parseYMD(ev.start);
                const eRaw = parseYMD(ev.end || ev.start);
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
            if (!calendarGrid) return;
            calendarGrid.innerHTML = '';

            const y = date.getFullYear(),
                m = date.getMonth();
            monthYearEl.textContent = `${monthNames[m]} ${y}`;
            const firstDayIndex = new Date(y, m, 1).getDay();
            const lastDate = new Date(y, m + 1, 0).getDate();
            const monthMap = buildMonthMap(y, m);

            for (let i = 0; i < firstDayIndex; i++) {
                const s = document.createElement('div');
                s.className = 'p-2';
                calendarGrid.appendChild(s);
            }

            for (let d = 1; d <= lastDate; d++) {
                const cell = document.createElement('div');
                cell.className =
                    'cal-cell border p-1.5 sm:p-2 h-16 max-[360px]:h-14 sm:h-24 rounded-xl bg-white flex flex-col text-[11px] sm:text-sm transition hover:shadow-md hover:ring-1 hover:ring-red-200';

                const label = document.createElement('div');
                label.className = 'font-semibold text-gray-900';
                label.textContent = d;
                cell.appendChild(label);

                const cellDate = new Date(y, m, d);
                const key = cellDate.toISOString().slice(0, 10);
                const dayEvents = monthMap[key] || [];

                if (dayEvents.length) {
                    if (dayEvents.length <= 2) {
                        dayEvents.forEach(ev => {
                            const wrap = document.createElement('div');
                            wrap.className = 'mt-1 flex items-center gap-1';
                            const dot = document.createElement('span');
                            dot.className = `inline-block h-2 w-2 rounded-full ${statusDotClass(ev.status)}`;
                            wrap.appendChild(dot);
                            const badge = document.createElement('span');
                            badge.textContent = ev.title;
                            badge.title = ev.title;
                            badge.className =
                                `px-1.5 sm:px-2 py-0.5 rounded-full text-white truncate cursor-pointer ${statusChipClass(ev.status)}`;
                            if (ev.is_full) badge.className += ' ring-2 ring-red-500/80';
                            badge.onclick = () => ev.url && (window.location.href = ev.url);
                            wrap.appendChild(badge);
                            cell.appendChild(wrap);
                        });
                    } else {
                        const more = document.createElement('span');
                        more.textContent = `+${dayEvents.length} turnīri`;
                        more.className = 'mt-auto text-[11px] sm:text-xs font-semibold text-red-600 cursor-pointer';
                        more.onclick = () => openModalFor(cellDate, dayEvents);
                        cell.appendChild(more);
                    }
                }

                calendarGrid.appendChild(cell);
            }
        }

        function renderMobileAgenda(date) {
            if (!mobileAgenda) return;
            mobileAgenda.innerHTML = '';

            const y = date.getFullYear(),
                m = date.getMonth();
            monthYearEl.textContent = `${monthNames[m]} ${y}`;

            const lastDate = new Date(y, m + 1, 0).getDate();
            const monthMap = buildMonthMap(y, m);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let hasAny = false;

            for (let d = 1; d <= lastDate; d++) {
                const dObj = new Date(y, m, d);
                const key = dObj.toISOString().slice(0, 10);
                const events = monthMap[key] || [];
                if (!events.length) continue;
                hasAny = true;

                const isToday = dObj.getTime() === today.getTime();
                const isWeekend = [0, 6].includes(dObj.getDay());

                const card = document.createElement('div');
                card.className =
                    `flex gap-3 border rounded-xl bg-white p-3 items-start transition ${isWeekend ? 'bg-rose-50/60' : ''} ${isToday ? 'ring-2 ring-red-300 bg-rose-50' : ''}`;

                const left = document.createElement('div');
                left.className = 'flex flex-col items-center justify-center min-w-[2.75rem]';
                const dow = document.createElement('div');
                dow.className = 'text-[10px] font-extrabold text-red-800 leading-none';
                dow.textContent = ["Sv", "Pr", "Ot", "Tr", "Ce", "Pk", "Se"][dObj.getDay()];
                const num = document.createElement('div');
                num.className = 'text-base font-black text-gray-900 leading-none mt-0.5';
                num.textContent = String(d).padStart(2, '0');
                left.append(dow, num);

                const right = document.createElement('div');
                right.className = 'flex-1 minw0';
                const title = document.createElement('div');
                title.className = 'text-[13px] font-bold text-gray-800 mb-1 truncate';
                title.textContent = `${monthNames[m]} ${String(d).padStart(2,'0')}, ${y}`;
                const chips = document.createElement('div');
                chips.className = 'flex flex-wrap gap-1.5 w-full';

                events.forEach(ev => {
                    const chip = document.createElement('button');
                    chip.type = 'button';
                    chip.className =
                        `max-w-full px-2 py-1 text-[11px] rounded-full text-white truncate ${statusChipClass(ev.status)} shadow-sm`;
                    if (ev.is_full) chip.className += ' ring-2 ring-red-500/90';
                    chip.title = ev.title;
                    chip.textContent = ev.title;
                    chip.onclick = () => ev.url && (window.location.href = ev.url);
                    chips.appendChild(chip);
                });

                right.append(title, chips);
                card.append(left, right);
                mobileAgenda.appendChild(card);
            }

            if (!hasAny) {
                const empty = document.createElement('div');
                empty.className = 'text-center text-sm text-gray-500 py-2';
                empty.textContent = 'Šajā mēnesī nav turnīru.';
                mobileAgenda.appendChild(empty);
            }
        }

        function openModalFor(dateObj, items) {
            modalDate.textContent =
                `${String(dateObj.getDate()).padStart(2,'0')}.${String(dateObj.getMonth()+1).padStart(2,'0')}.${dateObj.getFullYear()}`;
            modalTournaments.innerHTML = '';
            items.forEach(ev => {
                const li = document.createElement('li');
                li.className =
                    'p-2 bg-gray-100 rounded cursor-pointer hover:bg-gray-200 flex items-center justify-between gap-3';
                li.innerHTML = `
                    <span class="flex items-center gap-2">
                        <span class="inline-block h-2 w-2 rounded-full ${statusDotClass(ev.status)}"></span>
                        <span class="font-medium text-gray-800">${ev.title}</span>
                    </span>
                    ${ev.is_full ? '<span class="inline-flex items-center rounded-full bg-red-600 text-white px-2 py-0.5 text-xs font-semibold">Pilns</span>' : ''}
                `;
                li.onclick = () => ev.url && (window.location.href = ev.url);
                modalTournaments.appendChild(li);
            });
            modalOverlay.classList.remove('hidden');
            modalOverlay.classList.add('flex');
        }

        function renderAll() {
            renderCalendar(currentDate);
            renderMobileAgenda(currentDate);
        }

        document.getElementById('prevMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderAll();
        });
        document.getElementById('nextMonth')?.addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderAll();
        });
        document.getElementById('closeModal')?.addEventListener('click', () => {
            modalOverlay.classList.add('hidden');
            modalOverlay.classList.remove('flex');
        });

        let rTO;
        window.addEventListener('resize', () => {
            clearTimeout(rTO);
            rTO = setTimeout(renderAll, 100);
        });
        renderAll();

        // Prefetch + view transitions for faster nav
        document.addEventListener('mouseover', prefetchHandler, {
            passive: true
        });
        document.addEventListener('touchstart', prefetchHandler, {
            passive: true
        });

        function prefetchHandler(e) {
            const a = e.target.closest('a[data-prefetch]');
            if (!a || a.dataset.prefetched) return;
            const l = document.createElement('link');
            l.rel = 'prefetch';
            l.as = 'document';
            l.href = a.href;
            document.head.appendChild(l);
            a.dataset.prefetched = '1';
        }
        document.addEventListener('click', (e) => {
            const a = e.target.closest('a[data-transition]');
            if (!a) return;
            if (!document.startViewTransition) return;
            e.preventDefault();
            const href = a.href;
            document.startViewTransition(() => {
                window.location.href = href;
            });
        });
    </script>
</x-app-layout>
