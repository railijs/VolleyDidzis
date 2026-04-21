<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VolleyLV') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,700;0,900;1,700;1,900&family=Barlow:wght@300;400;500&display=swap"
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
            --red: #D42B2B;
            --red-glow: rgba(212, 43, 43, 0.45);
            --gold: #C8963E;
            --ink: #080808;
            --white: #F5F4F0;
        }

        /* ── Keyframes ── */
        @keyframes imgReveal {
            from {
                opacity: 0;
                transform: scale(1.06);
                filter: blur(4px);
            }

            to {
                opacity: 1;
                transform: scale(1);
                filter: blur(0);
            }
        }

        @keyframes slashReveal {
            from {
                opacity: 0;
                transform: translateX(-40px) skewX(-12deg);
            }

            to {
                opacity: 1;
                transform: translateX(0) skewX(-12deg);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes lineGrow {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        @keyframes scrollX {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* ── Base ── */
        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Barlow', sans-serif;
            background: var(--ink);
            color: var(--white);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Hero ── */
        .hero {
            position: relative;
            min-height: 100svh;
            display: grid;
            grid-template-rows: 1fr auto;
            overflow: hidden;
        }

        /* ── Background photo ── */
        .hero__bg {
            position: absolute;
            inset: 0;
            background-image: url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg');
            background-size: cover;
            background-position: center 30%;
            animation: imgReveal 1.8s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
            z-index: 0;
        }

        /* Progressive dark overlay — left panel solid, right feathers */
        .hero__veil {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(100deg,
                    rgba(8, 8, 8, 0.97) 0%,
                    rgba(8, 8, 8, 0.90) 28%,
                    rgba(8, 8, 8, 0.55) 55%,
                    rgba(8, 8, 8, 0.15) 80%,
                    rgba(8, 8, 8, 0.08) 100%);
        }

        /* Bottom fade so ticker reads */
        .hero__floor {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 220px;
            z-index: 2;
            background: linear-gradient(to top, rgba(8, 8, 8, 1) 0%, transparent 100%);
        }

        /* Red glow blob behind headline */
        .hero__glow {
            position: absolute;
            z-index: 1;
            left: -80px;
            top: 30%;
            width: 700px;
            height: 500px;
            background: radial-gradient(ellipse at center, var(--red-glow) 0%, transparent 65%);
            pointer-events: none;
        }

        /* ── Diagonal accent bar ── */
        .hero__slash {
            position: absolute;
            top: 0;
            bottom: 0;
            left: clamp(260px, 46vw, 680px);
            width: 3px;
            background: var(--red);
            transform: skewX(-4deg);
            z-index: 3;
            transform-origin: top;
            animation: slashReveal 1s cubic-bezier(0.16, 1, 0.3, 1) 0.6s both;
            box-shadow: 0 0 24px 4px var(--red-glow);
        }

        /* hide on mobile */
        @media (max-width: 900px) {
            .hero__slash {
                display: none;
            }
        }

        /* ── Main content ── */
        .hero__content {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            padding: 0 clamp(1.5rem, 6vw, 6rem);
            padding-top: clamp(5rem, 12vh, 8rem);
            padding-bottom: 5rem;
        }

        .hero__left {
            max-width: 560px;
        }

        /* ── Eyebrow ── */
        .eyebrow {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.5s both;
        }

        .eyebrow__dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--red);
            animation: pulse 2s ease-in-out 1.5s infinite;
        }

        .eyebrow__text {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.55);
        }

        .eyebrow__sep {
            width: 28px;
            height: 1px;
            background: var(--red);
            flex-shrink: 0;
        }

        /* ── Headline ── */
        .headline {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-style: italic;
            line-height: 0.9;
            letter-spacing: -0.01em;
            text-transform: uppercase;
            color: var(--white);
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.65s both;
        }

        .headline__main {
            display: block;
            font-size: clamp(5rem, 13vw, 10rem);
        }

        .headline__sub {
            display: block;
            font-size: clamp(2.2rem, 5.5vw, 4.2rem);
            color: var(--red);
            font-weight: 700;
            font-style: normal;
            letter-spacing: 0.06em;
            margin-top: 0.1em;
        }

        /* ── Divider line ── */
        .hero__line {
            height: 2px;
            background: linear-gradient(to right, var(--red) 0%, rgba(200, 150, 62, 0.4) 60%, transparent 100%);
            margin: 1.5rem 0;
            transform-origin: left;
            animation: lineGrow 0.8s cubic-bezier(0.16, 1, 0.3, 1) 1s both;
        }

        /* ── Lead copy ── */
        .lead {
            font-size: 1.05rem;
            font-weight: 300;
            line-height: 1.7;
            color: rgba(245, 244, 240, 0.70);
            max-width: 400px;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.9s both;
        }

        /* ── Stats row ── */
        .stats {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin: 2rem 0;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 1s both;
        }

        .stat__num {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            line-height: 1;
            color: var(--white);
        }

        .stat__label {
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.4);
            margin-top: 0.2rem;
        }

        .stat__sep {
            width: 1px;
            height: 36px;
            background: rgba(245, 244, 240, 0.12);
        }

        /* ── CTA buttons ── */
        .ctas {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 1.1s both;
        }

        .cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            text-decoration: none;
            padding: 0.75rem 1.75rem;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 100%, 10px 100%);
        }

        .cta:hover {
            transform: translateY(-2px);
        }

        .cta--primary {
            background: var(--red);
            color: var(--white);
            box-shadow: 0 8px 32px -8px var(--red-glow);
        }

        .cta--primary:hover {
            background: #E03030;
            box-shadow: 0 12px 40px -8px var(--red-glow);
        }

        .cta--ghost {
            background: rgba(245, 244, 240, 0.08);
            color: var(--white);
            border: 1px solid rgba(245, 244, 240, 0.18);
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 100%, 10px 100%);
        }

        .cta--ghost:hover {
            background: rgba(245, 244, 240, 0.14);
        }

        .cta--outline {
            background: transparent;
            color: rgba(245, 244, 240, 0.6);
            border: 1px solid rgba(245, 244, 240, 0.15);
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 100%, 10px 100%);
        }

        .cta--outline:hover {
            color: var(--white);
            border-color: rgba(245, 244, 240, 0.35);
        }

        .cta__arrow {
            font-size: 1rem;
            line-height: 1;
        }

        /* ── Bottom ticker ── */
        .ticker {
            position: relative;
            z-index: 10;
            border-top: 1px solid rgba(245, 244, 240, 0.08);
            background: rgba(8, 8, 8, 0.85);
            backdrop-filter: blur(8px);
            overflow: hidden;
            height: 42px;
            display: flex;
            align-items: center;
        }

        .ticker__label {
            flex-shrink: 0;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            background: var(--red);
            color: var(--white);
            padding: 0 1.1rem;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .ticker__track {
            overflow: hidden;
            flex: 1;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .ticker__inner {
            display: flex;
            align-items: center;
            white-space: nowrap;
            animation: scrollX 28s linear infinite;
        }

        .ticker__item {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.55);
            padding: 0 2.5rem;
        }

        .ticker__item strong {
            color: var(--white);
            font-weight: 700;
        }

        .ticker__dot {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--red);
            flex-shrink: 0;
        }

        /* ── Corner number ── */
        .hero__number {
            position: absolute;
            bottom: 70px;
            right: clamp(1.5rem, 5vw, 5rem);
            z-index: 10;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(6rem, 16vw, 14rem);
            font-weight: 900;
            font-style: italic;
            color: rgba(245, 244, 240, 0.04);
            line-height: 1;
            pointer-events: none;
            user-select: none;
            letter-spacing: -0.05em;
            -webkit-text-stroke: 1px rgba(245, 244, 240, 0.06);
        }

        @media (max-width: 600px) {
            .hero__number {
                display: none;
            }
        }

        /* ── Scroll cue ── */
        .scroll-cue {
            position: absolute;
            bottom: 56px;
            left: clamp(1.5rem, 6vw, 6rem);
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.3);
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) 1.4s both;
        }

        .scroll-cue__line {
            width: 1px;
            height: 32px;
            background: linear-gradient(to bottom, var(--red), transparent);
        }

        @media (max-width: 600px) {
            .scroll-cue {
                display: none;
            }
        }
    </style>
</head>

<body>

    <section class="hero">

        <!-- Photo layer -->
        <div class="hero__bg"></div>
        <div class="hero__veil"></div>
        <div class="hero__floor"></div>
        <div class="hero__glow"></div>

        <!-- Vertical red slash (desktop) -->
        <div class="hero__slash"></div>

        <!-- Large ghost number -->
        <div class="hero__number">LV</div>

        <!-- Scroll cue -->
        <div class="scroll-cue">
            <div class="scroll-cue__line"></div>
            Ritiniet
        </div>

        <!-- Main content -->
        <div class="hero__content">
            <div class="hero__left">

                <div class="eyebrow">
                    <div class="eyebrow__dot"></div>
                    <span class="eyebrow__text">Latvijas volejbols</span>
                    <div class="eyebrow__sep"></div>
                    <span class="eyebrow__text">Ziņas & Turnīri</span>
                </div>

                <h1 class="headline">
                    <span class="headline__main">Volley</span>
                    <span class="headline__sub">Latvija</span>
                </h1>

                <div class="hero__line"></div>

                <p class="lead">Mēs spēlējam kā viens. Seko aktuālajiem turnīriem, rezultātiem un spēlētāju
                    statistikai.</p>

                <div class="stats">
                    <div>
                        <div class="stat__num">24</div>
                        <div class="stat__label">Turnīri</div>
                    </div>
                    <div class="stat__sep"></div>
                    <div>
                        <div class="stat__num">400+</div>
                        <div class="stat__label">Spēlētāji</div>
                    </div>
                    <div class="stat__sep"></div>
                    <div>
                        <div class="stat__num">18</div>
                        <div class="stat__label">Komandas</div>
                    </div>
                </div>

                <div class="ctas">
                    <a href="{{ route('register') }}" class="cta cta--primary">
                        Pievienojies <span class="cta__arrow">→</span>
                    </a>
                    <a href="{{ route('login') }}" class="cta cta--ghost">
                        Esmu spēlētājs
                    </a>
                    <a href="{{ route('dashboard') }}" class="cta cta--outline">
                        Sākumlapa
                    </a>
                </div>

            </div>
        </div>

        <!-- Bottom ticker -->
        <div class="ticker">
            <div class="ticker__label">Aktuāli</div>
            <div class="ticker__track">
                <div class="ticker__inner">
                    <!-- duplicate for seamless loop -->
                    <span class="ticker__item"><strong>Sezona 2025</strong> — reģistrācija atvērta</span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item">Nākamā spēle: <strong>Rīga vs Liepāja</strong> — 28. apr.</span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item">Rezultāti: <strong>Jelgava 3:1 Ventspils</strong></span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item">Jaunākās ziņas — volejbols.lv</span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item"><strong>Sezona 2025</strong> — reģistrācija atvērta</span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item">Nākamā spēle: <strong>Rīga vs Liepāja</strong> — 28. apr.</span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item">Rezultāti: <strong>Jelgava 3:1 Ventspils</strong></span>
                    <span class="ticker__dot"></span>
                    <span class="ticker__item">Jaunākās ziņas — volejbols.lv</span>
                    <span class="ticker__dot"></span>
                </div>
            </div>
        </div>

    </section>

</body>

</html>
