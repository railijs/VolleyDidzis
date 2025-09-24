<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VolleyLV') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gradient-to-b from-white via-red-50 to-white text-gray-900">

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center text-center overflow-hidden">
        <div class="absolute inset-0 flex flex-col md:flex-row">
            <!-- Left side -->
            <div class="md:w-1/2 w-full h-1/2 md:h-full bg-cover bg-center"
                style="background-image: url('https://static.lsm.lv/media/2025/06/large/1/qmth.jpg');"></div>
            <!-- Right side -->
            <div class="md:w-1/2 w-full h-1/2 md:h-full bg-cover bg-center"
                style="background-image: url('https://faili.liepaja.lv/Bildes/Sports/1DX29498-20.jpg');"></div>
        </div>

        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60"></div>

        <!-- Latvian pattern overlay -->
        <div class="absolute inset-0 opacity-20 bg-repeat animate-[scrollBg_20s_linear_infinite]"
            style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/f/fc/Lielvardes_josta_pattern.svg'); background-size: 200px;">
        </div>

        <div
            class="relative z-20 max-w-4xl px-4 md:px-6 py-6 md:py-8 bg-black/40 backdrop-blur-sm rounded-2xl shadow-lg text-center">

            <!-- Logo -->
            <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV Logo" class="mx-auto w-32 sm:w-40 mb-4">


            <p class="text-lg sm:text-xl md:text-2xl text-gray-200 mb-6 md:mb-8">
                Mēs spēlējam kā viens.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 sm:gap-6">
                <a href="{{ route('register') }}"
                    class="bg-red-700 hover:bg-red-800 text-white px-6 sm:px-10 py-3 sm:py-4 rounded-xl text-lg shadow-lg transition transform hover:-translate-y-1">
                    Pievienojies spēlei
                </a>
                <a href="{{ route('login') }}"
                    class="bg-white/20 hover:bg-white/40 text-white px-6 sm:px-10 py-3 sm:py-4 rounded-xl text-lg shadow-lg transition transform hover:-translate-y-1">
                    Esmu spēlētājs
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
                background-position: 200px 0;
            }
        }
    </style>

</body>

</html>
