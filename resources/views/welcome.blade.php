<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VolleyLV') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gradient-to-b from-white via-red-50 to-white text-gray-900">

    <!-- Hero -->
    <section class="relative h-screen flex items-center justify-center text-center overflow-hidden">
        <!-- Split background -->
        <div class="absolute inset-0 flex flex-col md:flex-row">
            <div class="md:w-1/2 w-full h-1/2 md:h-full bg-cover bg-center"
                style="background-image: url('https://static.lsm.lv/media/2025/06/large/1/qmth.jpg');"></div>
            <div class="md:w-1/2 w-full h-1/2 md:h-full bg-cover bg-center"
                style="background-image: url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg');"></div>
        </div>

        <!-- Dark overlay (lighter than before) -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/50"></div>

        <!-- Latvian pattern -->
        <div class="absolute inset-0 opacity-15 bg-repeat animate-[scrollBg_25s_linear_infinite]"
            style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/f/fc/Lielvardes_josta_pattern.svg'); background-size: 180px;">
        </div>

        <!-- Content -->
        <div class="relative z-20 max-w-3xl px-6 py-6 bg-black/30 backdrop-blur-sm rounded-2xl shadow-md text-center">
            <!-- Logo -->
            <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV Logo" class="mx-auto w-28 sm:w-36 mb-3">

            <!-- Tagline -->
            <p class="text-lg sm:text-xl text-gray-200 mb-5">Mēs spēlējam kā viens.</p>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}"
                    class="bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-xl text-lg font-semibold shadow transition hover:-translate-y-0.5">
                    Pievienojies spēlei
                </a>
                <a href="{{ route('login') }}"
                    class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl text-lg font-semibold shadow transition hover:-translate-y-0.5">
                    Esmu spēlētājs
                </a>
                <a href="{{ route('dashboard') }}"
                    class="border border-white/60 hover:bg-white/10 text-white px-6 py-3 rounded-xl text-lg font-semibold shadow transition hover:-translate-y-0.5">
                    Sākumlapa
                </a>
            </div>
        </div>
    </section>

    <style>
        @keyframes scrollBg {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 180px 0;
            }
        }
    </style>
</body>

</html>
