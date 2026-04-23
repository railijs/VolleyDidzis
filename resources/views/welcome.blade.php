<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VolleyLV') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,600;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400&family=DM+Sans:wght@400;500&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --red: #C5231B;
            --red-dim: rgba(197, 35, 27, .35);
            --ink: #060606;
            --white: #F4F3EF;
            --muted: rgba(244, 243, 239, .45);
            --muted-2: rgba(244, 243, 239, .18);
            --rule: rgba(244, 243, 239, .08);
        }

        @keyframes imgIn {
            from {
                opacity: 0;
                transform: scale(1.04)
            }

            to {
                opacity: 1;
                transform: scale(1)
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        @keyframes lineGrow {
            from {
                transform: scaleX(0)
            }

            to {
                transform: scaleX(1)
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1
            }

            50% {
                opacity: .35
            }
        }

        @keyframes slashIn {
            from {
                opacity: 0;
                clip-path: inset(0 100% 0 0)
            }

            to {
                opacity: 1;
                clip-path: inset(0 0% 0 0)
            }
        }

        @media(prefers-reduced-motion:reduce) {
            * {
                animation-duration: .01ms !important
            }
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            /* no scroll */
            font-family: 'Barlow', sans-serif;
            background: var(--ink);
            color: var(--white);
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Full-viewport shell ─────────────────── */
        .shell {
            width: 100vw;
            height: 100dvh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto 1fr auto;
            overflow: hidden;
            position: relative;
        }

        /* ─── Background photo (right half) ──────── */
        .bg-photo {
            position: absolute;
            inset: 0;
            left: 42%;
            background: url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg') center 25% / cover no-repeat;
            animation: imgIn 2s cubic-bezier(.16, 1, .3, 1) .1s both;
            z-index: 0;
        }

        /* feathered left edge */
        .bg-photo::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, var(--ink) 0%, rgba(6, 6, 6, .7) 35%, rgba(6, 6, 6, .1) 70%, transparent 100%);
        }

        /* bottom darkening */
        .bg-photo::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(6, 6, 6, .65) 0%, transparent 50%);
        }

        /* ─── Red diagonal slash ──────────────────── */
        .slash {
            position: absolute;
            top: 0;
            bottom: 0;
            left: clamp(220px, 40vw, 600px);
            width: 2px;
            background: var(--red);
            transform: skewX(-3deg);
            box-shadow: 0 0 20px 3px var(--red-dim);
            z-index: 2;
            animation: fadeUp .6s ease .8s both;
        }

        @media(max-width:860px) {
            .slash {
                display: none
            }
        }

        /* ─── Top bar ─────────────────────────────── */
        .topbar {
            grid-column: 1 / -1;
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: clamp(.75rem, 2vh, 1.25rem) clamp(1.25rem, 4vw, 3rem);
            border-bottom: 1px solid var(--rule);
        }

        .logo {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.2rem, 2.5vw, 1.6rem);
            font-weight: 900;
            font-style: italic;
            letter-spacing: -.02em;
            color: var(--white);
            text-decoration: none;
            line-height: 1;
        }

        .logo em {
            color: var(--red);
            font-style: normal;
        }

        .topbar__nav {
            display: flex;
            align-items: center;
            gap: clamp(.75rem, 2vw, 1.5rem);
        }

        .topbar__link {
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--muted);
            text-decoration: none;
            transition: color .15s;
        }

        .topbar__link:hover {
            color: var(--white);
        }

        .topbar__divider {
            width: 1px;
            height: 14px;
            background: var(--rule);
        }

        .topbar__cta {
            font-family: 'DM Sans', sans-serif;
            font-size: .72rem;
            font-weight: 500;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--white);
            background: var(--red);
            border: none;
            padding: .45rem 1.1rem;
            text-decoration: none;
            cursor: pointer;
            clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 100%, 8px 100%);
            transition: background .15s;
        }

        .topbar__cta:hover {
            background: #a81d16;
        }

        /* ─── Left content panel ──────────────────── */
        .left {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(1.5rem, 4vh, 3rem) clamp(1.25rem, 4vw, 3rem);
            gap: clamp(.75rem, 2vh, 1.25rem);
        }

        /* eyebrow */
        .eyebrow {
            display: flex;
            align-items: center;
            gap: .6rem;
            animation: fadeUp .6s ease .4s both;
        }

        .eyebrow__dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--red);
            animation: pulse 2s ease-in-out 1.5s infinite;
        }

        .eyebrow__text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .eyebrow__sep {
            width: 20px;
            height: 1px;
            background: var(--red);
            flex-shrink: 0;
        }

        /* headline */
        .headline {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: -.025em;
            line-height: .88;
            color: var(--white);
            font-size: clamp(3.5rem, 8vw, 7.5rem);
            animation: fadeUp .7s ease .55s both;
        }

        .headline em {
            display: block;
            color: var(--red);
            font-style: normal;
        }

        /* rule */
        .rule {
            height: 2px;
            width: 100%;
            max-width: 280px;
            background: linear-gradient(to right, var(--red), rgba(197, 35, 27, .2), transparent);
            transform-origin: left;
            animation: lineGrow .7s ease .9s both;
        }

        /* tagline */
        .tagline {
            font-size: clamp(.82rem, 1.3vw, .95rem);
            font-weight: 300;
            line-height: 1.7;
            color: var(--muted);
            max-width: 380px;
            animation: fadeUp .6s ease .75s both;
        }

        /* stats */
        .stats {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            animation: fadeUp .6s ease .9s both;
        }

        .stat__num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 900;
            line-height: 1;
            color: var(--white);
        }

        .stat__lbl {
            font-size: .6rem;
            font-weight: 500;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(244, 243, 239, .35);
            margin-top: .15rem;
        }

        .stat__sep {
            width: 1px;
            height: 28px;
            background: var(--rule);
        }

        /* CTAs */
        .ctas {
            display: flex;
            flex-wrap: wrap;
            gap: .6rem;
            animation: fadeUp .6s ease 1.05s both;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            text-decoration: none;
            padding: .65rem 1.5rem;
            clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 100%, 8px 100%);
            transition: transform .2s, background .15s;
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn--red {
            background: var(--red);
            color: var(--white);
        }

        .btn--red:hover {
            background: #a81d16;
        }

        .btn--ghost {
            background: var(--muted-2);
            color: var(--white);
            border: 1px solid rgba(244, 243, 239, .15);
        }

        .btn--ghost:hover {
            background: rgba(244, 243, 239, .14);
        }

        /* ─── Right panel: feature cards ─────────── */
        .right {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(1.5rem, 4vh, 3rem) clamp(1.25rem, 3vw, 2.5rem) clamp(1.5rem, 4vh, 3rem) clamp(2rem, 4vw, 3.5rem);
            gap: 0;
        }

        @media(max-width:860px) {
            .right {
                display: none
            }
        }

        .features-label {
            font-family: 'DM Sans', sans-serif;
            font-size: .58rem;
            font-weight: 500;
            letter-spacing: .16em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .4rem;
            animation: fadeUp .5s ease .8s both;
        }

        .features-label::before {
            content: '';
            width: 12px;
            height: 1.5px;
            background: var(--red);
        }

        .feat {
            display: flex;
            align-items: flex-start;
            gap: .9rem;
            padding: .9rem 0;
            border-bottom: 1px solid var(--rule);
            animation: fadeUp .5s ease var(--d, 0s) both;
            transition: background .12s;
        }

        .feat:first-of-type {
            border-top: 1px solid var(--rule);
        }

        .feat:hover {
            background: rgba(244, 243, 239, .03);
        }

        .feat__num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: .78rem;
            font-weight: 900;
            font-style: italic;
            color: var(--red);
            min-width: 1.5rem;
            flex-shrink: 0;
            opacity: .7;
            margin-top: .1rem;
        }

        .feat__body {
            flex: 1;
        }

        .feat__title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(.9rem, 1.4vw, 1rem);
            font-weight: 900;
            font-style: italic;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: .2rem;
            letter-spacing: .01em;
        }

        .feat__desc {
            font-size: clamp(.72rem, 1.1vw, .8rem);
            font-weight: 300;
            line-height: 1.6;
            color: var(--muted);
        }

        .feat__link {
            flex-shrink: 0;
            align-self: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(244, 243, 239, .25);
            text-decoration: none;
            transition: color .15s;
        }

        .feat__link:hover {
            color: var(--red);
        }

        /* ─── Bottom bar ──────────────────────────── */
        .bottombar {
            grid-column: 1 / -1;
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: clamp(.6rem, 1.5vh, 1rem) clamp(1.25rem, 4vw, 3rem);
            border-top: 1px solid var(--rule);
            gap: 1rem;
            flex-wrap: wrap;
        }

        .bottombar__copy {
            font-family: 'DM Sans', sans-serif;
            font-size: .6rem;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: rgba(244, 243, 239, .2);
        }

        .bottombar__links {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .bottombar__link {
            font-family: 'DM Sans', sans-serif;
            font-size: .6rem;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: rgba(244, 243, 239, .25);
            text-decoration: none;
            transition: color .15s;
        }

        .bottombar__link:hover {
            color: rgba(244, 243, 239, .7);
        }

        /* ─── Mobile fallback (< 860px): vertical layout, scrollable ─ */
        @media(max-width:860px) {

            html,
            body {
                overflow: auto;
            }

            .shell {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr auto auto;
                height: auto;
                min-height: 100dvh;
            }

            .bg-photo {
                left: 0;
                opacity: .3;
            }

            .bg-photo::before {
                background: linear-gradient(to bottom, var(--ink) 0%, rgba(6, 6, 6, .5) 60%, var(--ink) 100%);
            }

            .left {
                grid-row: 2;
                justify-content: flex-start;
                padding: 2rem 1.25rem 1.5rem;
            }

            .right {
                display: flex;
                grid-row: 3;
                padding: 0 1.25rem 2rem;
            }

            .bottombar {
                grid-row: 4;
            }
        }
    </style>
</head>

<body>
    <div class="shell">

        <!-- Background photo -->
        <div class="bg-photo"></div>
        <div class="slash"></div>

        <!-- Top nav bar -->
        <header class="topbar">
            <a href="{{ route('dashboard') }}" class="logo">Volley<em>LV</em></a>
            <nav class="topbar__nav">
                <a href="{{ route('news.index') }}" class="topbar__link">Ziņas</a>
                <a href="{{ route('tournaments.calendar') }}" class="topbar__link">Kalendārs</a>
                <a href="{{ route('tournaments.index') }}" class="topbar__link">Turnīri</a>
                <a href="{{ route('about') }}" class="topbar__link">Par mums</a>
                <div class="topbar__divider"></div>
                <a href="{{ route('login') }}" class="topbar__link">Ienākt</a>
                <a href="{{ route('register') }}" class="topbar__cta">Reģistrēties</a>
            </nav>
        </header>

        <!-- Left: hero content -->
        <main class="left">
            <div class="eyebrow">
                <div class="eyebrow__dot"></div>
                <span class="eyebrow__text">Latvijas volejbols</span>
                <div class="eyebrow__sep"></div>
                <span class="eyebrow__text">Ziņas & Turnīri</span>
            </div>

            <h1 class="headline">
                Volley
                <em>Latvija</em>
            </h1>

            <div class="rule"></div>

            <p class="tagline">Viena platforma visam Latvijas volejbolam — turnīri, komandas, rezultāti un ziņas.</p>

            <div class="stats">
                <div>
                    <div class="stat__num">24</div>
                    <div class="stat__lbl">Turnīri</div>
                </div>
                <div class="stat__sep"></div>
                <div>
                    <div class="stat__num">400+</div>
                    <div class="stat__lbl">Spēlētāji</div>
                </div>
                <div class="stat__sep"></div>
                <div>
                    <div class="stat__num">18</div>
                    <div class="stat__lbl">Komandas</div>
                </div>
            </div>

            <div class="ctas">
                <a href="{{ route('register') }}" class="btn btn--red">Pievienojies →</a>
                <a href="{{ route('dashboard') }}" class="btn btn--ghost">Sākumlapa</a>
            </div>
        </main>

        <!-- Right: feature list -->
        <aside class="right">
            <div class="features-label">Ko tu varēsi sagaidīt</div>

            <div class="feat" style="--d:.9s">
                <div class="feat__num">01</div>
                <div class="feat__body">
                    <div class="feat__title">Turnīru kalendārs</div>
                    <div class="feat__desc">Visi gaidāmie un notiekošie turnīri vienā skatā — filtrē pēc datuma, dzimuma
                        vai vietas.</div>
                </div>
                <a href="{{ route('tournaments.calendar') }}" class="feat__link">Skatīt →</a>
            </div>

            <div class="feat" style="--d:1s">
                <div class="feat__num">02</div>
                <div class="feat__body">
                    <div class="feat__title">Pieteikšanās komandai</div>
                    <div class="feat__desc">Piesakies turnīram dažos soļos — norādi kapteiņa datus un komandas
                        nosaukumu.</div>
                </div>
                <a href="{{ route('tournaments.index') }}" class="feat__link">Turnīri →</a>
            </div>

            <div class="feat" style="--d:1.1s">
                <div class="feat__num">03</div>
                <div class="feat__body">
                    <div class="feat__title">Rezultāti & kopvērtējums</div>
                    <div class="feat__desc">Seko braketiem, spēļu rezultātiem un leaderboard reāllaikā.</div>
                </div>
                <a href="{{ route('leaderboard') }}" class="feat__link">Leaderboard →</a>
            </div>

            <div class="feat" style="--d:1.2s">
                <div class="feat__num">04</div>
                <div class="feat__body">
                    <div class="feat__title">Ziņas no kopienas</div>
                    <div class="feat__desc">Aktualitātes, paziņojumi un atskaites tieši no turnīru organizatoriem.</div>
                </div>
                <a href="{{ route('news.index') }}" class="feat__link">Ziņas →</a>
            </div>
        </aside>

        <!-- Bottom bar -->
        <footer class="bottombar">
            <span class="bottombar__copy">© {{ date('Y') }} VolleyLV — Visas tiesības aizsargātas</span>
            <nav class="bottombar__links">
                <a href="{{ route('about') }}" class="bottombar__link">Par mums</a>
                <a href="{{ route('news.index') }}" class="bottombar__link">Ziņas</a>
                <a href="{{ route('tournaments.calendar') }}" class="bottombar__link">Kalendārs</a>
            </nav>
        </footer>

    </div>
</body>

</html>
