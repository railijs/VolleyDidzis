<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .ti * {
            box-sizing: border-box;
        }

        .ti {
            --ink: #0A0A0A;
            --ink-2: #2E2E2C;
            --ink-3: #6B6864;
            --ink-4: #B0ADA8;
            --paper: #F7F5F0;
            --paper-2: #EDEAE3;
            --rule: #D5D1C9;
            --red: #C5231B;
            --red-dark: #9E1C15;
            --red-tint: #FAF0EF;
            --white: #FFFFFF;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Page header ── */
        .ti-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .ti-header::after {
            content: 'TURNĪRI';
            position: absolute;
            right: -0.02em;
            bottom: -0.15em;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: clamp(5rem, 14vw, 11rem);
            color: rgba(255, 255, 255, 0.04);
            line-height: 1;
            pointer-events: none;
            letter-spacing: -0.03em;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.05);
        }

        .ti-header__inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem 2rem;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .ti-header__eyebrow {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .ti-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .ti-header__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2.8rem, 7vw, 5rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -0.01em;
            color: var(--white);
            line-height: 0.95;
            margin: 0;
        }

        .ti-header__count {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 0.35rem 0.9rem;
            align-self: flex-end;
            margin-bottom: 0.5rem;
            white-space: nowrap;
        }

        /* Red accent bar under header */
        .ti-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .ti-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Controls strip ── */
        .ti-controls {
            background: var(--white);
            border-bottom: 1px solid var(--rule);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 20;
            box-shadow: 0 1px 0 var(--rule);
        }

        .ti-controls__inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Search */
        .ti-search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
            max-width: 320px;
        }

        .ti-search-wrap svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            stroke: var(--ink-4);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            pointer-events: none;
        }

        .ti-search {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            background: var(--paper);
            border: 1px solid var(--rule);
            padding: 0.4rem 2rem 0.4rem 2rem;
            outline: none;
            border-radius: 0;
            transition: border-color 0.15s;
        }

        .ti-search:focus {
            border-color: var(--ink-3);
        }

        .ti-search::placeholder {
            color: var(--ink-4);
        }

        .ti-clear {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.7rem;
            color: var(--ink-3);
            padding: 2px 4px;
        }

        .ti-clear:hover {
            color: var(--ink);
        }

        /* Filter pills */
        .ti-filters {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
        }

        .ti-chip {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            padding: 0.3rem 0.8rem;
            border: 1px solid var(--rule);
            background: none;
            color: var(--ink-3);
            cursor: pointer;
            border-radius: 0;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .ti-chip:hover {
            border-color: var(--ink-3);
            color: var(--ink);
        }

        .ti-chip.active {
            background: var(--ink);
            color: var(--white);
            border-color: var(--ink);
        }

        .ti-chip--men.active {
            background: #1A4A8A;
            border-color: #1A4A8A;
        }

        .ti-chip--women.active {
            background: #8A1A5A;
            border-color: #8A1A5A;
        }

        .ti-chip--mix.active {
            background: #4A2A8A;
            border-color: #4A2A8A;
        }

        /* Sort + upcoming */
        .ti-controls__right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-left: auto;
            flex-wrap: wrap;
        }

        .ti-sort {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--ink-2);
            background: var(--paper);
            border: 1px solid var(--rule);
            padding: 0.4rem 1.75rem 0.4rem 0.65rem;
            outline: none;
            border-radius: 0;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' fill='none'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23888' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        .ti-upcoming {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--ink-3);
            cursor: pointer;
            white-space: nowrap;
        }

        .ti-upcoming input {
            accent-color: var(--red);
            cursor: pointer;
        }

        /* ── Flash ── */
        .ti-flash {
            background: #EAF4EE;
            border-left: 3px solid #1E7E34;
            color: #1E7E34;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 1.5rem 0 0;
        }

        /* ── Tournament list ── */
        .ti-list {
            margin-top: 1.5rem;
        }

        /* Each row */
        .ti-row {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 0 1.5rem;
            align-items: center;
            background: var(--white);
            border: 1px solid var(--rule);
            border-top: none;
            padding: 1.25rem 1.5rem;
            transition: background 0.15s;
            position: relative;
        }

        .ti-row:first-child {
            border-top: 1px solid var(--rule);
        }

        .ti-row:hover {
            background: var(--paper);
        }

        .ti-row.past {
            opacity: 0.55;
        }

        /* Left accent on hover */
        .ti-row::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--red);
            transition: width 0.2s;
        }

        .ti-row:hover::before {
            width: 3px;
        }

        /* Date block */
        .ti-date {
            flex-shrink: 0;
            text-align: center;
            min-width: 52px;
        }

        .ti-date__day {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            font-style: italic;
            line-height: 1;
            color: var(--ink);
        }

        .ti-date__mon {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--red);
        }

        .ti-date--past .ti-date__day {
            color: var(--ink-3);
        }

        .ti-date--past .ti-date__mon {
            color: var(--ink-4);
        }

        /* Vertical rule between date and body */
        .ti-vr {
            width: 1px;
            height: 100%;
            background: var(--rule);
            align-self: stretch;
            flex-shrink: 0;
            display: none;
        }

        /* Body */
        .ti-body {
            min-width: 0;
        }

        .ti-body__top {
            display: flex;
            align-items: baseline;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-bottom: 0.3rem;
        }

        .ti-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.01em;
            color: var(--ink);
            line-height: 1.1;
        }

        .ti-row:hover .ti-name {
            color: var(--red);
        }

        /* Gender pill */
        .ti-pill {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.6rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.15rem 0.5rem;
            border: 1px solid;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .ti-pill--men {
            color: #1A4A8A;
            border-color: #B8CDE8;
            background: #EEF3FA;
        }

        .ti-pill--women {
            color: #8A1A5A;
            border-color: #E8B8D4;
            background: #FAEEF5;
        }

        .ti-pill--mix {
            color: #4A2A8A;
            border-color: #C8B8E8;
            background: #F4EEFC;
        }

        .ti-pill--other {
            color: var(--ink-3);
            border-color: var(--rule);
            background: var(--paper);
        }

        /* Meta row */
        .ti-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem 1.1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            color: var(--ink-3);
            margin-bottom: 0.6rem;
        }

        .ti-meta__item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .ti-meta__item svg {
            width: 11px;
            height: 11px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            flex-shrink: 0;
        }

        /* Description */
        .ti-desc {
            font-family: 'Barlow', sans-serif;
            font-size: 0.83rem;
            font-weight: 300;
            line-height: 1.55;
            color: var(--ink-3);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Progress */
        .ti-progress {
            margin-top: 0.65rem;
            max-width: 260px;
        }

        .ti-progress__bar {
            height: 2px;
            background: var(--rule);
            position: relative;
            overflow: hidden;
        }

        .ti-progress__fill {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            background: var(--red);
            transition: width 0.4s;
        }

        .ti-progress__label {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.65rem;
            color: var(--ink-4);
            margin-top: 0.3rem;
        }

        .ti-progress__label strong {
            color: var(--ink-2);
        }

        /* CTA */
        .ti-cta-wrap {
            flex-shrink: 0;
        }

        .ti-cta {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--red);
            border: 1px solid var(--red);
            padding: 0.5rem 1.1rem;
            display: inline-block;
            white-space: nowrap;
            transition: background 0.15s, color 0.15s;
            border-radius: 0;
        }

        .ti-cta:hover {
            background: var(--red);
            color: var(--white);
        }

        @media (max-width: 640px) {
            .ti-row {
                grid-template-columns: auto 1fr;
            }

            .ti-cta-wrap {
                grid-column: 2;
            }
        }

        /* ── Empty state ── */
        .ti-empty {
            text-align: center;
            padding: 4rem 2rem;
            border: 1px solid var(--rule);
            background: var(--white);
            margin-top: 1.5rem;
        }

        .ti-empty__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            margin-bottom: 0.4rem;
        }

        .ti-empty__sub {
            font-size: 0.85rem;
            color: var(--ink-3);
            margin-bottom: 1.25rem;
            font-weight: 300;
        }

        .ti-empty__link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--white);
            background: var(--red);
            padding: 0.55rem 1.25rem;
            display: inline-block;
            transition: background 0.15s;
        }

        .ti-empty__link:hover {
            background: var(--red-dark);
        }

        /* Footer */
        .ti-footer {
            margin-top: 4rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--rule);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            color: var(--ink-4);
            text-align: center;
        }

        /* Reveal */
        .ti-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .ti-reveal.in {
            opacity: 1;
            transform: none;
        }
    </style>

    <div class="ti">

        {{-- ── Page header ── --}}
        <div class="ti-header">
            <div class="ti-header__inner">
                <div>
                    <div class="ti-header__eyebrow">VolleyLV</div>
                    <h1 class="ti-header__title">Turnīri</h1>
                </div>
                @if ($tournaments->count())
                    <div class="ti-header__count">{{ $tournaments->count() }} kopā</div>
                @endif
            </div>
        </div>
        <div class="ti-bar"></div>

        {{-- ── Sticky controls ── --}}
        @if ($tournaments->count())
            <div class="ti-controls">
                <div class="ti-controls__inner">
                    <div class="ti-search-wrap">
                        <svg viewBox="0 0 20 20">
                            <circle cx="8.5" cy="8.5" r="5.5" />
                            <path d="M14 14l4 4" />
                        </svg>
                        <input id="search" type="text" class="ti-search" placeholder="Meklēt…">
                        <button id="clearSearch" class="ti-clear" style="display:none;">✕</button>
                    </div>

                    <div class="ti-filters">
                        <button class="ti-chip active" data-gender="all">Visi</button>
                        <button class="ti-chip ti-chip--men" data-gender="men">Vīrieši</button>
                        <button class="ti-chip ti-chip--women" data-gender="women">Sievietes</button>
                        <button class="ti-chip ti-chip--mix" data-gender="mix">Mix</button>
                    </div>

                    <div class="ti-controls__right">
                        <label class="ti-upcoming">
                            <input type="checkbox" id="onlyUpcoming"> Tikai gaidāmie
                        </label>
                        <select id="sortBy" class="ti-sort">
                            <option value="soonest">Tuvākās</option>
                            <option value="latest">Tālākās</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif

        <div class="ti-wrap">

            {{-- Flash --}}
            @if (session('success'))
                <div class="ti-flash ti-reveal" data-stagger="0">{{ session('success') }}</div>
            @endif

            @if ($tournaments->count())

                <div id="tiList" class="ti-list ti-reveal" data-stagger="1">
                    @php $todayYmd = \Carbon\Carbon::today()->toDateString(); @endphp

                    @foreach ($tournaments as $t)
                        @php
                            $start = \Carbon\Carbon::parse($t->start_date);
                            $end = \Carbon\Carbon::parse($t->end_date ?? $t->start_date);
                            $gender = $t->gender_type ?? 'other';
                            $apps = $t->applications->count();
                            $max = $t->max_teams;
                            $pct = $max ? min(100, round(($apps / max(1, $max)) * 100)) : null;
                            $isPast = $end->toDateString() < $todayYmd;

                            $pillClass = match ($gender) {
                                'men' => 'ti-pill--men',
                                'women' => 'ti-pill--women',
                                'mix' => 'ti-pill--mix',
                                default => 'ti-pill--other',
                            };
                            $pillLabel = match ($gender) {
                                'men' => 'Vīrieši',
                                'women' => 'Sievietes',
                                'mix' => 'Mix',
                                default => 'Turnīrs',
                            };
                        @endphp

                        <div class="ti-row {{ $isPast ? 'past' : '' }}" data-gender="{{ $gender }}"
                            data-start="{{ $start->toDateString() }}" data-end="{{ $end->toDateString() }}"
                            data-name="{{ mb_strtolower($t->name) }}"
                            data-location="{{ mb_strtolower($t->location ?? '') }}"
                            data-desc="{{ mb_strtolower($t->description ?? '') }}">

                            {{-- Date --}}
                            <div class="ti-date {{ $isPast ? 'ti-date--past' : '' }}">
                                <div class="ti-date__day">{{ $start->format('d') }}</div>
                                <div class="ti-date__mon">{{ strtoupper($start->format('M')) }}</div>
                            </div>

                            {{-- Body --}}
                            <div class="ti-body">
                                <div class="ti-body__top">
                                    <span class="ti-name">{{ $t->name }}</span>
                                    <span class="ti-pill {{ $pillClass }}">{{ $pillLabel }}</span>
                                    @if ($isPast)
                                        <span class="ti-pill ti-pill--other">Beidzies</span>
                                    @endif
                                </div>

                                <div class="ti-meta">
                                    <span class="ti-meta__item">
                                        <svg viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="18" height="18" rx="2" />
                                            <path d="M16 2v4M8 2v4M3 10h18" />
                                        </svg>
                                        {{ $start->format('d.m.Y') }}@if ($end->ne($start))
                                            – {{ $end->format('d.m.Y') }}
                                        @endif
                                    </span>
                                    @if ($t->location)
                                        <span class="ti-meta__item">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 22s-8-6.686-8-12a8 8 0 0116 0c0 5.314-8 12-8 12z" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                            {{ $t->location }}
                                        </span>
                                    @endif
                                    @if ($t->team_size)
                                        <span class="ti-meta__item">
                                            <svg viewBox="0 0 24 24">
                                                <circle cx="9" cy="7" r="4" />
                                                <path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                                                <path d="M16 3.13a4 4 0 010 7.75" />
                                                <path d="M21 21v-2a4 4 0 00-3-3.87" />
                                            </svg>
                                            {{ $t->team_size }}
                                        </span>
                                    @endif
                                </div>

                                @if ($t->description)
                                    <p class="ti-desc">{{ $t->description }}</p>
                                @endif

                                @if (!is_null($pct))
                                    <div class="ti-progress">
                                        <div class="ti-progress__bar">
                                            <div class="ti-progress__fill" style="width:{{ $pct }}%"></div>
                                        </div>
                                        <div class="ti-progress__label">
                                            Pieteikumi: <strong>{{ $apps }}/{{ $max }}</strong>
                                            ({{ $pct }}%)
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- CTA --}}
                            <div class="ti-cta-wrap">
                                <a href="{{ route('tournaments.show', $t) }}" class="ti-cta">
                                    Skatīt →
                                </a>
                            </div>

                        </div>
                    @endforeach

                    {{-- Filtered empty --}}
                    <div id="emptyState" class="ti-empty" style="display:none;">
                        <div class="ti-empty__title">Nav atrastu turnīru</div>
                        <p class="ti-empty__sub">Mēģiniet mainīt meklēšanu vai filtrus.</p>
                        <a href="{{ route('tournaments.calendar') }}" class="ti-empty__link">Skatīt kalendāru →</a>
                    </div>
                </div>
            @else
                <div class="ti-empty ti-reveal" data-stagger="1">
                    <div class="ti-empty__title">Pagaidām nav turnīru</div>
                    <p class="ti-empty__sub">Apskatiet kalendāru vai vēlāk atgriezieties.</p>
                    <a href="{{ route('tournaments.calendar') }}" class="ti-empty__link">Turnīru kalendārs →</a>
                </div>

            @endif

            <div class="ti-footer ti-reveal" data-stagger="2">
                &copy; {{ date('Y') }} VolleyLV. Visas tiesības aizsargātas.
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.ti-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 80 + i * 100);
            });

            const $ = id => document.getElementById(id);
            const $$ = sel => Array.from(document.querySelectorAll(sel));

            const search = $('search');
            const clearBtn = $('clearSearch');
            const chips = $$('.ti-chip');
            const onlyUpcoming = $('onlyUpcoming');
            const sortBy = $('sortBy');
            const rows = $$('.ti-row');
            const emptyState = $('emptyState');

            let genderFilter = 'all';

            function applyFilters() {
                const q = (search?.value || '').trim().toLowerCase();
                clearBtn.style.display = q ? '' : 'none';
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                let shown = 0;

                rows.forEach(r => {
                    if (!r.dataset.gender) return; // skip emptyState
                    const matchQ = !q || [r.dataset.name, r.dataset.location, r.dataset.desc].some(v => v
                        ?.includes(q));
                    const matchG = genderFilter === 'all' || r.dataset.gender === genderFilter;
                    const matchDate = !onlyUpcoming?.checked || new Date(r.dataset.end) >= today;
                    const show = matchQ && matchG && matchDate;
                    r.style.display = show ? '' : 'none';
                    if (show) shown++;
                });

                if (emptyState) emptyState.style.display = shown === 0 ? '' : 'none';
            }

            let t;
            search?.addEventListener('input', () => {
                clearTimeout(t);
                t = setTimeout(applyFilters, 110);
            });
            clearBtn?.addEventListener('click', () => {
                search.value = '';
                applyFilters();
            });

            chips.forEach(btn => btn.addEventListener('click', () => {
                genderFilter = btn.dataset.gender;
                chips.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                applyFilters();
            }));

            onlyUpcoming?.addEventListener('change', applyFilters);

            function sortRows() {
                const key = sortBy?.value || 'soonest';
                const container = document.getElementById('tiList');
                if (!container) return;
                const visible = rows.filter(r => r.dataset.gender && r.style.display !== 'none');
                const hidden = rows.filter(r => r.dataset.gender && r.style.display === 'none');
                visible.sort((a, b) => {
                    const da = new Date(a.dataset.start),
                        db = new Date(b.dataset.start);
                    return key === 'soonest' ? da - db : db - da;
                });
                [...visible, ...hidden].forEach(r => container.appendChild(r));
                if (emptyState) container.appendChild(emptyState);
            }
            sortBy?.addEventListener('change', sortRows);

            applyFilters();
            sortRows();
        });
    </script>
</x-app-layout>
