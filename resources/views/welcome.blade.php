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
        :root {
            --slide-duration: 1.6s;
            --slide-delay: .12s;
            --content-duration: 1.05s;
            --easing-soft: cubic-bezier(.22, .55, .15, 1);
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(24px) scale(.985)
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

        /* Wider image slice so the photo dominates on large screens */
        @media (min-width:1024px) {
            .hero-slice {
                clip-path: polygon(30% 0, 100% 0, 100% 100%, 16% 100%)
            }
        }

        /* Watermark: translucent fill + faint stroke for legibility */
        .watermark {
            pointer-events: none;
            user-select: none;
            line-height: .8;
            letter-spacing: -.04em;
            white-space: nowrap;
            color: rgba(255, 255, 255, .06);
            -webkit-text-stroke: 1px rgba(255, 255, 255, .12);
            text-shadow: 0 2px 18px rgba(0, 0, 0, .20);
        }

        @media (prefers-reduced-motion: reduce) {
            .rm\:no-anim {
                animation: none !important;
                transition: none !important
            }
        }
    </style>
</head>

<body class="antialiased bg-neutral-950 text-white selection:bg-red-600/40 selection:text-white">

    <!-- ===== HERO ===== -->
    <section id="hero" class="relative min-h-svh overflow-hidden">

        <!-- Background image (dominant on desktop) -->
        <div class="absolute inset-0 lg:inset-y-0 lg:right-0 lg:w-[78%] hero-slice bg-cover bg-center will-change-transform rm:no-anim z-0"
            style="background-image:url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg'); animation: slideInRight var(--slide-duration) var(--easing-soft) var(--slide-delay) both;">
        </div>

        <!-- Subtle Latvian pattern (between image and overlays) -->
        <div class="absolute inset-0 opacity-[0.10] bg-repeat rm:no-anim z-[12]"
            style="background-image:url('https://upload.wikimedia.org/wikipedia/commons/f/fc/Lielvardes_josta_pattern.svg'); background-size:180px; animation:scrollBg 28s linear infinite;">
        </div>

        <!-- Overlays for drama & readability -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/40 to-black/70 z-20"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/30 to-transparent z-20"></div>
        <div class="absolute inset-0 mix-blend-screen pointer-events-none z-20"
            style="background: radial-gradient(900px 700px at 75% 45%, rgba(239,68,68,.33), transparent 60%)"></div>

        <!-- Watermark (big background label) -->
        <div class="absolute -left-6 bottom-8 lg:bottom-10 z-10 watermark"
            style="font-weight:700; font-size: clamp(3.5rem, 9vw, 8rem);">
            VolleyLV
        </div>

        <!-- Content -->
        <div class="relative z-30 container mx-auto px-6 md:px-10 lg:px-14">
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-10 min-h-svh items-center">

                <!-- Left column -->
                <div class="lg:col-span-6 py-20 md:py-24 lg:py-0 will-change-transform"
                    style="animation: slideInLeft var(--slide-duration) var(--easing-soft) calc(var(--slide-delay) + .05s) both;">

                    <!-- Small label (your “p-style” tag) -->
                    <p class="uppercase tracking-[0.2em] text-[11px] text-red-300/90 font-bold"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .10s) both;">
                        Ziņas & Turnīri
                    </p>

                    <!-- Headline -->
                    <h1 class="mt-1 font-bold tracking-tight text-white"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .15s) both; font-size: clamp(2.6rem, 5.2vw, 4.75rem);">
                        VolleyLV
                    </h1>

                    <!-- Subcopy -->
                    <p class="mt-5 text-white/85 text-lg leading-relaxed max-w-xl"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .25s) both;">
                        Mēs spēlējam kā viens.
                    </p>

                    <!-- Quick chips (secondary labels in your p-style spirit) -->
                    <div class="mt-4 flex flex-wrap gap-2"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .30s) both;">
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 ring-1 ring-white/15 px-3 py-1 text-xs font-semibold">
                            <span class="uppercase tracking-[0.2em] text-[10px] text-white/80">Kalendārs</span>
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 ring-1 ring-white/15 px-3 py-1 text-xs font-semibold">
                            <span class="uppercase tracking-[0.2em] text-[10px] text-white/80">Rezultāti</span>
                        </span>
                        <span
                            class="inline-flex items-center rounded-full bg-white/10 ring-1 ring-white/15 px-3 py-1 text-xs font-semibold">
                            <span class="uppercase tracking-[0.2em] text-[10px] text-white/80">Statistika</span>
                        </span>
                    </div>

                    <!-- CTAs -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4"
                        style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .35s) both;">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-7 py-3 rounded-xl text-base font-semibold bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:ring-offset-neutral-950 shadow-lg shadow-red-900/30 transition-transform duration-300 hover:-translate-y-0.5">
                            Pievienojies spēlei
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-7 py-3 rounded-xl text-base font-semibold bg-white/10 hover:bg-white/20 ring-1 ring-white/20 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/60 focus:ring-offset-neutral-950 transition-transform duration-300 hover:-translate-y-0.5">
                            Esmu spēlētājs
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center justify-center px-7 py-3 rounded-xl text-base font-semibold bg-transparent hover:bg-white/10 ring-1 ring-white/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white/60 focus:ring-offset-neutral-950 transition-transform duration-300 hover:-translate-y-0.5">
                            Sākumlapa
                        </a>
                    </div>

                    <!-- Micro caption under CTAs with p-style -->
                    <p class="mt-4 uppercase tracking-[0.2em] text-[10px] text-white/60">
                        Reģistrācija • Pieslēgšanās • Pārskats
                    </p>
                </div>



            </div>
        </div>
    </section>

</body>

</html>
