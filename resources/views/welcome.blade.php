<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VolleyLV') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== Theme & Motion ===== */
        :root {
            --accent: #ef4444;
            /* red-500 */
            --accent-600: #dc2626;
            --chip-bg: rgba(255, 255, 255, .10);
            --chip-ring: rgba(255, 255, 255, .15);

            --slide-duration: 1.4s;
            --slide-delay: .10s;
            --content-duration: .95s;
            --easing-soft: cubic-bezier(.22, .55, .15, 1);

            --noise: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cfilter id='n'%3E%3CfeTurbulence baseFrequency='.8' numOctaves='2' stitchTiles='stitch'/%3E%3C/ filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.03'/%3E%3C/svg%3E");
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(22px) scale(.985)
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1)
            }
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-8%) scale(1.02);
                filter: blur(2px)
            }

            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
                filter: blur(0)
            }
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(8%) scale(1.02);
                filter: blur(2px)
            }

            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
                filter: blur(0)
            }
        }

        @keyframes scrollBg {
            from {
                background-position: 0 0
            }

            to {
                background-position: 180px 0
            }
        }

        /* ===== Accessibility toggles ===== */
        @media (prefers-reduced-motion: reduce) {

            .rm\:no-anim,
            #hero * {
                animation: none !important;
                transition: none !important;
            }
        }

        @media (prefers-contrast: more) {
            .chip {
                border-color: rgba(255, 255, 255, .45) !important;
            }

            .btn-ghost {
                border-color: rgba(255, 255, 255, .6) !important;
            }
        }

        /* ===== Typography polish ===== */
        body {
            font-feature-settings: "ss01", "ss02", "case", "cpsp";
        }

        h1 {
            text-wrap: balance;
        }

        /* ===== Hero image slice: wider on desktop, feathered edge ===== */
        .hero-slice {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            will-change: transform;
        }

        @media (min-width:1024px) {
            .hero-slice {
                /* geometric wedge */
                clip-path: polygon(30% 0, 100% 0, 100% 100%, 16% 100%);
                /* soft feather on the left edge (so text reads cleanly) */
                -webkit-mask-image: linear-gradient(to left, rgba(0, 0, 0, 1) 70%, rgba(0, 0, 0, 0) 98%);
                mask-image: linear-gradient(to left, rgba(0, 0, 0, 1) 70%, rgba(0, 0, 0, 0) 98%);
            }
        }

        /* On tiny screens: no clip-path, keep image full-bleed but darken more */
        @media (max-width: 360px) {
            .hero-slice {
                -webkit-mask-image: linear-gradient(to bottom, rgba(0, 0, 0, .92), rgba(0, 0, 0, .92));
                mask-image: linear-gradient(to bottom, rgba(0, 0, 0, .92), rgba(0, 0, 0, .92));
            }
        }

        /* ===== Pattern & noise overlays (Latvian spirit, subtle) ===== */
        .pattern {
            opacity: .10;
            background-repeat: repeat;
            background-size: 180px;
            animation: scrollBg 28s linear infinite;
        }

        .noise {
            pointer-events: none;
            background-image: var(--noise);
            mix-blend-mode: overlay;
            opacity: .9;
        }

        /* ===== Hero gradient layers ===== */
        .gloom-b {
            background: linear-gradient(to bottom, rgba(0, 0, 0, .70), rgba(0, 0, 0, .40), rgba(0, 0, 0, .70));
        }

        .gloom-r {
            background: linear-gradient(to right, rgba(0, 0, 0, .70), rgba(0, 0, 0, .30), transparent);
        }

        .glow {
            mix-blend-mode: screen;
            pointer-events: none;
            background: radial-gradient(900px 700px at 75% 45%, rgba(239, 68, 68, .33), transparent 60%);
        }

        /* ===== Watermark ===== */
        .watermark {
            pointer-events: none;
            user-select: none;
            line-height: .8;
            letter-spacing: -.04em;
            white-space: nowrap;
            color: rgba(255, 255, 255, .06);
            -webkit-text-stroke: 1px rgba(255, 255, 255, .12);
            text-shadow: 0 2px 18px rgba(0, 0, 0, .20);
            font-weight: 700;
            font-size: clamp(3.5rem, 9vw, 8rem);
        }

        @media (max-width: 360px) {
            .watermark {
                opacity: .04;
                transform: translateX(-4px);
            }
        }

        /* ===== Chips & CTA tactile tweaks (no markup change) ===== */
        .chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .45rem .75rem;
            border-radius: 999px;
            background: var(--chip-bg);
            border: 1px solid var(--chip-ring);
            backdrop-filter: blur(4px);
        }

        .chip>.upcase {
            text-transform: uppercase;
            letter-spacing: .2em;
            font-size: 10px;
            opacity: .85;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .75rem 1.1rem;
            border-radius: .9rem;
            font-weight: 600;
            transition: transform .25s var(--easing-soft), box-shadow .25s var(--easing-soft), background-color .2s, border-color .2s, color .2s;
            outline: none;
        }

        .btn:focus-visible {
            box-shadow: 0 0 0 2px #111827, 0 0 0 4px rgba(255, 255, 255, .8);
        }

        .btn-primary {
            background: var(--accent);
            box-shadow: 0 12px 24px -12px rgba(239, 68, 68, .45);
        }

        .btn-primary:hover {
            background: var(--accent-600);
            transform: translateY(-2px);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .20);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, .18);
            transform: translateY(-2px);
        }

        .btn-outline {
            border: 1px solid rgba(255, 255, 255, .30);
            background: transparent;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, .10);
            transform: translateY(-2px);
        }

        /* Bind our button skins to the existing Tailwind buttons (no markup change) */
        #hero .btn-primary-link {
            composes: btn btn-primary;
        }

        #hero .btn-ghost-link {
            composes: btn btn-ghost;
        }

        #hero .btn-outline-link {
            composes: btn btn-outline;
        }

        /* If your build doesn't support `composes`, fallback: */
        #hero .btn-primary-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .75rem 1.1rem;
            border-radius: .9rem;
            font-weight: 600;
            background: var(--accent);
            box-shadow: 0 12px 24px -12px rgba(239, 68, 68, .45);
        }

        #hero .btn-primary-link:hover {
            background: var(--accent-600);
            transform: translateY(-2px);
        }

        #hero .btn-ghost-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .75rem 1.1rem;
            border-radius: .9rem;
            font-weight: 600;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .20);
        }

        #hero .btn-ghost-link:hover {
            background: rgba(255, 255, 255, .18);
            transform: translateY(-2px);
        }

        #hero .btn-outline-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .75rem 1.1rem;
            border-radius: .9rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, .30);
        }

        #hero .btn-outline-link:hover {
            background: rgba(255, 255, 255, .10);
            transform: translateY(-2px);
        }

        /* ===== 320px mobile fit ===== */
        @media (max-width: 360px) {
            .container {
                padding-left: 18px;
                padding-right: 18px;
            }

            #hero .lead {
                font-size: .95rem;
            }

            #hero .cta-group {
                gap: .6rem;
            }

            #hero .cta-group a {
                padding: .7rem 1rem !important;
            }

            #hero .chips {
                gap: .35rem .5rem;
            }
        }
    </style>
</head>

<body class="antialiased bg-neutral-950 text-white selection:bg-red-600/40 selection:text-white">

    <!-- ===== HERO ===== -->
    <section id="hero" class="relative min-h-svh overflow-hidden">

        <!-- Background image (dominant on desktop) -->
        <div class="hero-slice lg:inset-y-0 lg:right-0 lg:w-[78%] rm:no-anim z-0"
            style="background-image:url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg'); animation: slideInRight var(--slide-duration) var(--easing-soft) var(--slide-delay) both;">
        </div>

        <!-- Subtle Latvian pattern -->
        <div class="pattern absolute inset-0 rm:no-anim z-[12]"
            style="background-image:url('https://upload.wikimedia.org/wikipedia/commons/f/fc/Lielvardes_josta_pattern.svg');">
        </div>

        <!-- Noise texture to tie layers together -->
        <div class="noise absolute inset-0 z-[13]"></div>

        <!-- Overlays for drama & readability -->
        <div class="gloom-b absolute inset-0 z-20"></div>
        <div class="gloom-r absolute inset-0 z-20"></div>
        <div class="glow absolute inset-0 z-20"></div>

        <!-- Watermark (big background label) -->
        <div class="absolute -left-6 bottom-8 lg:bottom-10 z-10 watermark">VolleyLV</div>

        <!-- Content -->
        <div class="relative z-30 container mx-auto px-6 md:px-10 lg:px-14">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-10 min-h-svh items-center">

                <!-- Left column -->
                <div class="lg:col-span-6 py-20 md:py-24 lg:py-0 will-change-transform"
                    style="animation: slideInLeft var(--slide-duration) var(--easing-soft) calc(var(--slide-delay) + .05s) both;">

                    <!-- Small label -->
                    <p class="uppercase tracking-[0.2em] text-[11px] text-red-300/90 font-bold"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .10s) both;">
                        Ziņas & Turnīri
                    </p>

                    <!-- Headline -->
                    <h1 class="mt-1 font-bold tracking-tight text-white"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .15s) both; font-size: clamp(2.4rem, 5.2vw, 4.75rem);">
                        VolleyLV
                    </h1>

                    <!-- Subcopy -->
                    <p class="lead mt-5 text-white/85 text-lg leading-relaxed max-w-xl"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .25s) both;">
                        Mēs spēlējam kā viens.
                    </p>

                    <!-- Quick chips -->
                    <div class="chips mt-4 flex flex-wrap gap-2"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .30s) both;">
                        <span class="chip"><span class="upcase">Kalendārs</span></span>
                        <span class="chip"><span class="upcase">Rezultāti</span></span>
                        <span class="chip"><span class="upcase">Statistika</span></span>
                    </div>

                    <!-- CTAs (no markup change required; extra classes just add nicer CSS skins) -->
                    <div class="cta-group mt-8 flex flex-col sm:flex-row gap-4"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .35s) both;">
                        <a href="{{ route('register') }}"
                            class="btn-primary-link inline-flex items-center justify-center px-7 py-3 rounded-xl text-base font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:ring-offset-neutral-950 shadow-lg shadow-red-900/30">
                            Pievienojies spēlei
                        </a>
                        <a href="{{ route('login') }}"
                            class="btn-ghost-link inline-flex items-center justify-center px-7 py-3 rounded-xl text-base font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/60 focus:ring-offset-neutral-950">
                            Esmu spēlētājs
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="btn-outline-link inline-flex items-center justify-center px-7 py-3 rounded-xl text-base font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/60 focus:ring-offset-neutral-950">
                            Sākumlapa
                        </a>
                    </div>

                    <!-- Micro caption -->
                    <p class="mt-4 uppercase tracking-[0.2em] text-[10px] text-white/60">
                        Reģistrācija • Pieslēgšanās • Pārskats
                    </p>
                </div>

                <!-- (Right column stays the background image; nothing needed here) -->

            </div>
        </div>
    </section>

</body>

</html>
