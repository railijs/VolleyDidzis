<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&family=DM+Sans:wght@400;500&display=swap');

        .pr * {
            box-sizing: border-box;
        }

        .pr {
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
            --green: #1E6A3A;
            --green-tint: #EAF4EE;

            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            min-height: 100vh;
            color: var(--ink);
            padding-bottom: 6rem;
        }

        /* ── Masthead ── */
        .pr-header {
            background: var(--ink);
            padding: clamp(3.5rem, 8vh, 5.5rem) 0 0;
            position: relative;
            overflow: hidden;
            margin-top: 30px;
        }

        .pr-header__bg {
            position: absolute;
            right: -0.02em;
            bottom: -0.12em;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            font-size: clamp(5rem, 14vw, 11rem);
            color: rgba(255, 255, 255, 0.04);
            line-height: 1;
            pointer-events: none;
            letter-spacing: -0.03em;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.05);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .pr-header__inner {
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

        .pr-header__eyebrow {
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

        .pr-header__eyebrow::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--red);
        }

        .pr-header__title {
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

        .pr-header__meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.4rem 1rem;
            margin-top: 0.85rem;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .pr-header__meta-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        .pr-bar {
            height: 3px;
            background: var(--red);
        }

        /* ── Wrap ── */
        .pr-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* ── Layout ── */
        .pr-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 0;
            border-top: 1px solid var(--rule);
            margin-top: 2rem;
        }

        @media (max-width: 900px) {
            .pr-layout {
                grid-template-columns: 1fr;
            }
        }

        .pr-aside {
            border-right: 1px solid var(--rule);
            padding: 2rem 2rem 2rem 0;
        }

        @media (max-width: 900px) {
            .pr-aside {
                border-right: none;
                padding-right: 0;
                border-bottom: 1px solid var(--rule);
                padding-bottom: 2rem;
            }
        }

        .pr-main {
            padding: 2rem 0 2rem 2rem;
        }

        @media (max-width: 900px) {
            .pr-main {
                padding-left: 0;
            }
        }

        /* ── Avatar block ── */
        .pr-avatar {
            width: 72px;
            height: 72px;
            background: var(--ink);
            border: 3px solid var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            font-style: italic;
            color: var(--white);
            text-transform: uppercase;
            flex-shrink: 0;
            position: relative;
        }

        .pr-avatar::after {
            content: '';
            position: absolute;
            bottom: -3px;
            right: -3px;
            width: 12px;
            height: 12px;
            background: var(--green);
            border: 2px solid var(--paper);
        }

        .pr-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.4rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .pr-email {
            font-size: 0.75rem;
            color: var(--ink-3);
            cursor: pointer;
            border-bottom: 1px dashed var(--rule);
            display: inline-block;
            transition: color 0.15s;
        }

        .pr-email:hover {
            color: var(--ink);
        }

        .pr-since {
            font-size: 0.65rem;
            color: var(--ink-4);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-top: 0.35rem;
        }

        /* ── KPI grid ── */
        .pr-kpis {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            margin-top: 1.5rem;
            border: 1px solid var(--rule);
            background: var(--white);
        }

        .pr-kpi {
            padding: 0.85rem 1rem;
            border-right: 1px solid var(--rule);
            border-bottom: 1px solid var(--rule);
        }

        .pr-kpi:nth-child(2n) {
            border-right: none;
        }

        .pr-kpi:nth-last-child(-n+2) {
            border-bottom: none;
        }

        .pr-kpi__label {
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--ink-4);
            margin-bottom: 0.2rem;
        }

        .pr-kpi__value {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.6rem;
            font-weight: 900;
            font-style: italic;
            color: var(--ink);
            line-height: 1;
        }

        .pr-kpi__value--red {
            color: var(--red);
        }

        /* ── Quick nav links ── */
        .pr-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-top: 1.25rem;
        }

        .pr-link {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--ink-2);
            border: 1px solid var(--rule);
            background: var(--white);
            padding: 0.5rem 0.75rem;
            text-align: center;
            transition: all 0.15s;
        }

        .pr-link:hover {
            background: var(--paper-2);
            color: var(--ink);
            border-color: var(--ink-4);
        }

        .pr-aside-sep {
            border: none;
            border-top: 1px solid var(--rule);
            margin: 1.75rem 0;
        }

        .pr-aside-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 0.85rem;
        }

        .pr-aside-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--ink);
        }

        .pr-aside-link {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--red);
            text-decoration: none;
            border-bottom: 1px solid rgba(197, 35, 27, 0.3);
            padding-bottom: 1px;
        }

        .pr-aside-link:hover {
            border-color: var(--red);
        }

        /* ── Tournament list ── */
        .pr-tourn-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0;
            border-bottom: 1px solid var(--rule);
            text-decoration: none;
            color: inherit;
            position: relative;
            transition: background 0.12s;
        }

        .pr-tourn-item:first-child {
            border-top: 1px solid var(--rule);
        }

        .pr-tourn-item::before {
            content: '';
            position: absolute;
            left: -0.5rem;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--red);
            transition: width 0.18s;
        }

        .pr-tourn-item:hover::before {
            width: 2px;
        }

        .pr-tourn-item:hover {
            background: var(--paper-2);
            margin: 0 -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .pr-tourn-item__date {
            flex-shrink: 0;
            text-align: center;
            min-width: 36px;
        }

        .pr-tourn-item__day {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            font-style: italic;
            color: var(--ink);
            line-height: 1;
        }

        .pr-tourn-item__mon {
            font-size: 0.55rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--red);
        }

        .pr-tourn-item__name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--ink);
            line-height: 1.1;
            flex: 1;
            min-width: 0;
        }

        .pr-tourn-item:hover .pr-tourn-item__name {
            color: var(--red);
        }

        .pr-tourn-empty {
            font-family: 'Barlow', sans-serif;
            font-size: 0.85rem;
            color: var(--ink-3);
            font-weight: 300;
            font-style: italic;
            padding: 0.75rem 0;
        }

        /* ── Form section cards ── */
        .pr-section {
            margin-bottom: 1.75rem;
            border: 1px solid var(--rule);
            background: var(--white);
        }

        .pr-section:last-child {
            margin-bottom: 0;
        }

        .pr-section__head {
            background: var(--ink);
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .pr-section__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.05rem;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--white);
        }

        .pr-section__badge {
            font-size: 0.58rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
        }

        .pr-section--danger {
            border-top: 3px solid var(--red);
        }

        .pr-section--danger .pr-section__head {
            background: var(--red-tint);
        }

        .pr-section--danger .pr-section__title {
            color: var(--red-dark);
        }

        .pr-section--danger .pr-section__badge {
            color: rgba(158, 28, 21, 0.55);
        }

        .pr-section__body {
            padding: 1.5rem 1.25rem;
        }

        /* ── Form skin applied to partials ── */
        .pr-form-skin label {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.62rem !important;
            font-weight: 500 !important;
            letter-spacing: 0.12em !important;
            text-transform: uppercase !important;
            color: var(--ink-2) !important;
            margin-bottom: 0.4rem !important;
        }

        .pr-form-skin input[type=text],
        .pr-form-skin input[type=email],
        .pr-form-skin input[type=password],
        .pr-form-skin input[type=file],
        .pr-form-skin textarea,
        .pr-form-skin select {
            width: 100%;
            font-family: 'DM Sans', sans-serif !important;
            font-size: 0.92rem !important;
            color: var(--ink) !important;
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid var(--rule) !important;
            padding: 0.5rem 0 !important;
            outline: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            transition: border-color 0.2s !important;
        }

        .pr-form-skin input:focus,
        .pr-form-skin textarea:focus,
        .pr-form-skin select:focus {
            border-bottom-color: var(--ink) !important;
            box-shadow: none !important;
        }

        .pr-form-skin input::placeholder {
            color: var(--ink-4) !important;
        }

        /* Rewrite submit buttons */
        .pr-form-skin button[type=submit] {
            font-family: 'DM Sans', sans-serif !important;
            font-size: 0.78rem !important;
            font-weight: 500 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            background: var(--ink) !important;
            color: var(--white) !important;
            border: 1px solid var(--ink) !important;
            padding: 0.6rem 1.75rem !important;
            cursor: pointer !important;
            border-radius: 0 !important;
            transition: background 0.15s !important;
            box-shadow: none !important;
        }

        .pr-form-skin button[type=submit]:hover {
            background: var(--ink-2) !important;
            border-color: var(--ink-2) !important;
        }

        .pr-section--danger .pr-form-skin button[type=submit] {
            background: var(--red) !important;
            border-color: var(--red) !important;
        }

        .pr-section--danger .pr-form-skin button[type=submit]:hover {
            background: var(--red-dark) !important;
            border-color: var(--red-dark) !important;
        }

        /* Strip rounded corners from partials */
        .pr-form-skin .rounded-md,
        .pr-form-skin .rounded-lg,
        .pr-form-skin .rounded-full,
        .pr-form-skin .rounded-xl {
            border-radius: 0 !important;
        }

        /* Validation colours */
        .pr-form-skin .text-red-600,
        .pr-form-skin .text-red-700 {
            color: var(--red) !important;
            font-size: 0.75rem;
        }

        .pr-form-skin .text-green-600,
        .pr-form-skin .text-green-700 {
            color: var(--green) !important;
            font-size: 0.75rem;
        }

        .pr-form-skin p.text-sm {
            font-size: 0.78rem;
            color: var(--ink-3);
        }

        /* ── Reveal ── */
        .pr-reveal {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.45s ease, transform 0.45s ease;
        }

        .pr-reveal.in {
            opacity: 1;
            transform: none;
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

    <div class="pr">

        {{-- ── Masthead ── --}}
        <div class="pr-header pr-reveal" data-stagger="0">
            <div class="pr-header__bg">PROFILS</div>
            <div class="pr-header__inner">
                <div>
                    <div class="pr-header__eyebrow">VolleyLV · Mans konts</div>
                    <h1 class="pr-header__title">Profils</h1>
                    <div class="pr-header__meta">
                        <span>{{ $u->name }}</span>
                        <span class="pr-header__meta-dot"></span>
                        <span>{{ $u->email }}</span>
                        <span class="pr-header__meta-dot"></span>
                        <span>Biedrs {{ $memberSince }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pr-bar"></div>

        <div class="pr-wrap">
            <div class="pr-layout pr-reveal" data-stagger="1">

                {{-- ── Sidebar ── --}}
                <aside class="pr-aside">

                    <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.5rem;">
                        <div class="pr-avatar">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</div>
                        <div style="min-width:0;">
                            <div class="pr-name">{{ $u->name }}</div>
                            <span class="pr-email"
                                onclick="
                                    navigator.clipboard?.writeText('{{ $u->email }}');
                                    this.textContent='Kopēts ✓';
                                    setTimeout(()=>this.textContent='{{ $u->email }}',1500)
                                ">{{ $u->email }}</span>
                            <div class="pr-since">Biedrs: {{ $memberSince }}</div>
                        </div>
                    </div>

                    <div class="pr-kpis">
                        <div class="pr-kpi">
                            <div class="pr-kpi__label">Turnīri</div>
                            <div class="pr-kpi__value">{{ $totalCount }}</div>
                        </div>
                        <div class="pr-kpi">
                            <div class="pr-kpi__label">Gaidāmie</div>
                            <div class="pr-kpi__value pr-kpi__value--red">{{ $upcomingCount }}</div>
                        </div>
                    </div>

                    <div class="pr-links">
                        <a href="{{ route('tournaments.calendar') }}" class="pr-link">Kalendārs</a>
                        <a href="{{ route('news.index') }}" class="pr-link">Ziņas</a>
                        <a href="{{ route('tournaments.index') }}" class="pr-link">Turnīri</a>
                        <a href="{{ route('dashboard') }}" class="pr-link">Sākums</a>
                    </div>

                    <hr class="pr-aside-sep">

                    <div class="pr-aside-head">
                        <span class="pr-aside-title">Mani turnīri</span>
                        <a href="{{ route('tournaments.calendar') }}" class="pr-aside-link">Kalendārs →</a>
                    </div>

                    @forelse($applied as $t)
                        @php $ts = \Carbon\Carbon::parse($t->start_date); @endphp
                        <a href="{{ route('tournaments.show', $t) }}" class="pr-tourn-item">
                            <div class="pr-tourn-item__date">
                                <div class="pr-tourn-item__day">{{ $ts->format('d') }}</div>
                                <div class="pr-tourn-item__mon">{{ strtoupper($ts->format('M')) }}</div>
                            </div>
                            <div class="pr-tourn-item__name">{{ $t->name }}</div>
                            <span style="font-size:0.75rem;color:var(--ink-4);flex-shrink:0;">→</span>
                        </a>
                    @empty
                        <p class="pr-tourn-empty">Vēl nav pieteikumu.</p>
                    @endforelse

                </aside>

                {{-- ── Form sections ── --}}
                <main class="pr-main">

                    <div class="pr-section pr-reveal" data-stagger="2">
                        <div class="pr-section__head">
                            <span class="pr-section__title">Profila informācija</span>
                            <span class="pr-section__badge">VolleyLV</span>
                        </div>
                        <div class="pr-section__body pr-form-skin">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="pr-section pr-reveal" data-stagger="3">
                        <div class="pr-section__head">
                            <span class="pr-section__title">Mainīt paroli</span>
                            <span class="pr-section__badge">Ieteicams ≥ 12 simboli</span>
                        </div>
                        <div class="pr-section__body pr-form-skin">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="pr-section pr-section--danger pr-reveal" data-stagger="4">
                        <div class="pr-section__head">
                            <span class="pr-section__title">Dzēst kontu</span>
                            <span class="pr-section__badge">Neatgriezeniska darbība</span>
                        </div>
                        <div class="pr-section__body pr-form-skin">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.pr-reveal').forEach(el => {
                const i = parseInt(el.dataset.stagger || '0', 10);
                setTimeout(() => el.classList.add('in'), 60 + i * 90);
            });
        });
    </script>
</x-app-layout>
