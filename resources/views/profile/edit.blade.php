<x-app-layout>
    {{-- HERO (more breathing room) --}}
    <section class="relative mt-20 mb-10 overflow-hidden">
        <div class="absolute inset-0">
            <div class="h-48 sm:h-56 bg-gradient-to-r from-red-700 via-red-600 to-red-500"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-12 -left-12 w-56 h-56 rounded-full bg-white/10 blur-2xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-48 sm:h-56 flex items-end">
            <div class="pb-6 fade-up">
                <p class="text-red-100/90 text-[11px] font-bold uppercase tracking-[0.22em]">Profils</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">Mans konts</h1>
                <p class="text-red-100/95 text-sm mt-1">Pārvaldi savus datus un pieteikumus vienuviet.</p>
            </div>
        </div>
    </section>

    {{-- PAGE BODY --}}
    <div class="relative bg-gradient-to-b from-white via-red-50/30 to-white pb-16">
        <style>
            /* Load / reveal */
            @media (prefers-reduced-motion: no-preference) {
                .fade-up {
                    opacity: 0;
                    transform: translateY(12px);
                    transition: opacity .55s, transform .55s
                }

                .loaded .fade-up {
                    opacity: 1;
                    transform: none
                }
            }

            /* Glass & form skin */
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
                transform: translateY(-2px)
            }

            .form-skin label {
                color: #111827;
                font-weight: 600;
                font-size: .9rem
            }

            .form-skin input[type=text],
            .form-skin input[type=email],
            .form-skin input[type=password],
            .form-skin input[type=file],
            .form-skin textarea,
            .form-skin select {
                width: 100%;
                border: 1px solid #e5e7eb;
                border-radius: .75rem;
                padding: .65rem .9rem;
                background: #fff;
                color: #111827;
                outline: none;
                box-shadow: inset 0 1px 2px rgba(0, 0, 0, .02);
                transition: border-color .18s, box-shadow .18s;
            }

            .form-skin input:focus,
            .form-skin textarea:focus,
            .form-skin select:focus {
                border-color: #fca5a5;
                box-shadow: 0 0 0 3px rgba(252, 165, 165, .35)
            }

            .btn-muted {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #e5e7eb;
                border-radius: 9999px;
                background: #fff;
                color: #374151;
                padding: .6rem 1rem;
                transition: background .2s, border-color .2s, color .2s
            }

            .btn-muted:hover {
                background: #f9fafb;
                border-color: #d1d5db
            }

            .kpi {
                border-radius: 1rem;
                border: 1px solid rgba(148, 163, 184, .35);
                background: linear-gradient(180deg, rgba(255, 255, 255, .92), rgba(255, 255, 255, .8))
            }

            .kpi h4 {
                font-size: .75rem;
                color: #6b7280;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .08em
            }

            .kpi .v {
                font-size: 1.25rem;
                font-weight: 800;
                color: #111827
            }
        </style>

        @php
            $u = auth()->user();
            $applied = $appliedTournaments ?? collect();
            $today = \Carbon\Carbon::today();
            $upcomingCount = $applied->filter(fn($t) => \Carbon\Carbon::parse($t->start_date)->gte($today))->count();
            $totalCount = $applied->count();
            $memberSince = $u->created_at->diffForHumans(null, true);
        @endphp

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-8 items-start"><!-- comfortable gap -->

                {{-- LEFT: profile summary --}}
                <aside class="lg:col-span-4 fade-up">
                    <div class="glass p-6 sm:p-7">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-red-500 to-red-700 text-white
                                       flex items-center justify-center text-2xl sm:text-3xl font-extrabold shadow-lg">
                                {{ strtoupper(mb_substr($u->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 truncate">{{ $u->name }}
                                </h3>
                                <button type="button" class="text-sm text-red-700 hover:text-red-900 font-semibold"
                                    onclick="navigator.clipboard?.writeText('{{ $u->email }}')">
                                    {{ $u->email }} <span class="opacity-60">• kopēt</span>
                                </button>
                                <p class="text-xs text-gray-500 mt-1">Biedrs: {{ $memberSince }}</p>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="kpi p-3">
                                <h4>Turnīri</h4>
                                <div class="v">{{ $totalCount }}</div>
                            </div>
                            <div class="kpi p-3">
                                <h4>Tuvākie</h4>
                                <div class="v">{{ $upcomingCount }}</div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <a href="{{ route('tournaments.calendar') }}" class="btn-muted">Kalendārs</a>
                            <a href="{{ route('news.index') }}" class="btn-muted">Ziņas</a>
                        </div>
                    </div>

                    <div class="glass p-6 sm:p-7 mt-6">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-extrabold text-gray-900">Mani turnīri</h4>
                            <a href="{{ route('tournaments.calendar') }}"
                                class="text-xs font-semibold text-red-700 hover:text-red-900">Kalendārs →</a>
                        </div>
                        <ul class="mt-3 space-y-2">
                            @forelse($applied as $t)
                                <li>
                                    <a href="{{ route('tournaments.show', $t) }}"
                                        class="group flex items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white/60
                                              hover:bg-white transition px-3 py-2 shadow-sm">
                                        <div class="min-w-0">
                                            <p class="font-semibold text-gray-900 truncate">{{ $t->name }}</p>
                                            <p class="text-[11px] text-gray-500">
                                                {{ \Carbon\Carbon::parse($t->start_date)->format('d.m.Y') }}
                                            </p>
                                        </div>
                                        <span class="text-gray-400 group-hover:text-red-600 transition">→</span>
                                    </a>
                                </li>
                            @empty
                                <li class="text-gray-500 italic text-sm">Vēl nav pieteikumu.</li>
                            @endforelse
                        </ul>
                    </div>
                </aside>

                {{-- RIGHT: stacked forms (no tabs, no modals) --}}
                <main class="lg:col-span-8 space-y-8">

                    {{-- Profile Information --}}
                    <section class="glass p-6 sm:p-8 fade-up">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="text-lg font-extrabold text-gray-900">Profila informācija</h3>
                            <span
                                class="hidden sm:inline text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-700 border border-red-200">
                                VolleyLV
                            </span>
                        </div>
                        <div class="mt-5 form-skin">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </section>

                    {{-- Update Password --}}
                    <section class="glass p-6 sm:p-8 fade-up">
                        <h3 class="text-lg font-extrabold text-gray-900">Mainīt paroli</h3>
                        <p class="text-sm text-gray-500 mt-1">Ieteicams lietot vismaz 12 simbolus.</p>
                        <div class="mt-5 form-skin">
                            @include('profile.partials.update-password-form')
                        </div>
                    </section>

                    {{-- Delete Account (no extra styling — uses partial’s own styles) --}}
                    <section class="fade-up">
                        @include('profile.partials.delete-user-form')
                    </section>

                </main>
            </div>
        </div>
    </div>

    {{-- Load animation trigger --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.documentElement.classList.add('loaded');
        });
    </script>
</x-app-layout>
