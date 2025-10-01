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
        /* Viegli pielāgojami mainīgie ātrumam */
        :root {
            --slide-duration: 1.6s;
            /* bija ~0.9s */
            --slide-delay: .12s;
            --content-duration: 1.05s;
            /* bija ~0.75s */
            --easing-soft: cubic-bezier(.22, .55, .15, 1);
        }

        /* --- Keyframes --- */
        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(24px) scale(.985);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-8%) scale(1.02);
                filter: blur(2px);
            }

            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes slideInRight {
            0% {
                opacity: 0;
                transform: translateX(8%) scale(1.02);
                filter: blur(2px);
            }

            100% {
                opacity: 1;
                transform: translateX(0) scale(1);
                filter: blur(0);
            }
        }

        @keyframes scrollBg {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 180px 0;
            }
        }

        /* Diagonālie klipi dinamiskākai kompozīcijai */
        @media (min-width: 768px) {
            .clip-left {
                clip-path: polygon(0 0, 66% 0, 54% 100%, 0% 100%);
            }

            .clip-right {
                clip-path: polygon(46% 0, 100% 0, 100% 100%, 34% 100%);
            }
        }

        @media (max-width: 767px) {
            .clip-top {
                clip-path: polygon(0 0, 100% 0, 100% 60%, 0 75%);
            }

            .clip-bottom {
                clip-path: polygon(0 40%, 100% 25%, 100% 100%, 0 100%);
            }
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            .rm\\:no-anim {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body class="antialiased bg-gradient-to-b from-white via-red-50 to-white text-gray-900">

    <!-- HERO -->
    <section id="hero" class="relative h-screen flex items-center justify-center overflow-hidden select-none">

        <!-- Fona slāņi: katrs ieslīd lēnāk no savas puses un paliek -->
        <div class="absolute inset-0">
            <!-- Labā bilde (ieslīd no labās) -->
            <div class="absolute inset-0 md:inset-auto md:right-0 md:top-0 md:bottom-0 md:w-2/3 bg-cover bg-center will-change-transform clip-right clip-top rm:no-anim"
                style="
          background-image:url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg');
          animation: slideInRight var(--slide-duration) var(--easing-soft) var(--slide-delay) both;
        ">
            </div>

            <!-- Kreisā bilde (ieslīd no kreisās) -->
            <div class="absolute inset-0 md:inset-auto md:left-0 md:top-0 md:bottom-0 md:w-2/3 bg-cover bg-center will-change-transform clip-left clip-bottom rm:no-anim"
                style="
          background-image:url('https://static.lsm.lv/media/2025/06/large/1/qmth.jpg');
          animation: slideInLeft var(--slide-duration) var(--easing-soft) calc(var(--slide-delay) + .05s) both;
        ">
            </div>

            <!-- Viegla vignete + gaisma -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/35 to-black/60"></div>
            <div class="absolute -inset-24"
                style="pointer-events:none; mix-blend-mode:screen; background: radial-gradient(800px 700px at 60% 35%, rgba(239,68,68,.33), transparent 60%);">
            </div>

            <!-- Lielvārdes josta (smalka tekstūra) -->
            <div class="absolute inset-0 opacity-15 bg-repeat rm:no-anim"
                style="background-image:url('https://upload.wikimedia.org/wikipedia/commons/f/fc/Lielvardes_josta_pattern.svg'); background-size:180px; animation: scrollBg 28s linear infinite;">
            </div>
        </div>

        <!-- Saturs -->
        <div class="relative z-10 max-w-3xl w-[92%] sm:w-auto px-6 sm:px-10 py-8 sm:py-10 bg-white/5 backdrop-blur-md rounded-3xl border border-white/15 shadow-2xl ring-1 ring-black/10 text-center"
            style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .1s) both;">
            <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV Logo"
                class="mx-auto w-28 sm:w-36 mb-4 drop-shadow"
                style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .2s) both;">
            <p class="text-xl sm:text-2xl text-white/90 mb-6 font-semibold tracking-tight"
                style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .3s) both;">
                Mēs spēlējam kā viens.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4"
                style="animation: fadeUp var(--content-duration) var(--easing-soft) calc(var(--slide-delay) + .4s) both;">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center bg-red-700 hover:bg-red-800 text-white px-7 py-3 rounded-xl text-lg font-semibold shadow-lg transition-transform duration-300 hover:-translate-y-0.5">
                    Pievienojies spēlei
                </a>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center bg-white/15 hover:bg-white/25 text-white px-7 py-3 rounded-xl text-lg font-semibold shadow-lg transition-transform duration-300 hover:-translate-y-0.5">
                    Esmu spēlētājs
                </a>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center border border-white/50 hover:bg-white/10 text-white px-7 py-3 rounded-xl text-lg font-semibold shadow-lg transition-transform duration-300 hover:-translate-y-0.5">
                    Sākumlapa
                </a>
            </div>
        </div>
    </section>
</body>

</html>
