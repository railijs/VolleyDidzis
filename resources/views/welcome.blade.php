<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Volitis Volleyball') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <!-- Navbar -->
    <header class="absolute top-0 left-0 w-full px-8 py-5 flex justify-between items-center z-20 bg-gradient-to-b from-black/80 to-transparent">
        <h1 class="text-3xl font-extrabold text-white tracking-wide">Volitis</h1>
        @if (Route::has('login'))
            <nav class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-6 py-2 text-white border border-white/50 rounded-lg hover:bg-white hover:text-black transition">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-lg transition">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center justify-center text-center bg-cover bg-center"
             style="background-image: url('https://www.avca.org/wp-content/uploads/bb-plugin/cache/gcu-ncca-men-national-e1689195844675-panorama-222901b0b8954651eaa8785e22722153-sry8vcfa2h67.jpg');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative z-10 max-w-4xl px-6">
            <h2 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-lg mb-6">
                Experience Volleyball Like Never Before
            </h2>
            <p class="text-xl md:text-2xl text-gray-200 mb-10">
                Tournaments • Highlights • Global Community
            </p>
            <div class="flex justify-center gap-6">
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-lg text-lg shadow-lg transition">
                    Get Started
                </a>
                <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/40 text-white px-10 py-4 rounded-lg text-lg shadow-lg transition">
                    Login
                </a>
            </div>
        </div>
    </section>

    <!-- Highlights -->
    <section class="py-20 bg-gradient-to-b from-gray-100 to-white dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-14 text-gray-900 dark:text-gray-100">Highlights</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="overflow-hidden rounded-xl shadow-xl hover:shadow-2xl transition">
                    <img src="https://www.nippon.com/en/ncommon/contents/japan-topics/2470950/2470950.jpg"
                         alt="Japan Volleyball"
                         class="w-full h-72 object-cover hover:scale-110 transition-transform duration-700">
                </div>
                <div class="overflow-hidden rounded-xl shadow-xl hover:shadow-2xl transition">
                    <img src="https://volleycountry.com/wp-content/uploads/2020/11/olympics-volleyball-rio-1080x675.jpg"
                         alt="Olympics Volleyball"
                         class="w-full h-72 object-cover hover:scale-110 transition-transform duration-700">
                </div>
                <div class="overflow-hidden rounded-xl shadow-xl hover:shadow-2xl transition">
                    <img src="https://www.fivb.com/wp-content/uploads/2025/04/101752-scaled.jpeg"
                         alt="International Volleyball"
                         class="w-full h-72 object-cover hover:scale-110 transition-transform duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="relative py-28 bg-cover bg-center"
             style="background-image: url('https://volleycountry.com/wp-content/uploads/2020/11/olympics-volleyball-rio-1080x675.jpg');">
        <div class="absolute inset-0 bg-black/70"></div>
        <div class="relative z-10 max-w-3xl mx-auto text-center px-6 text-white">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6">Join the Action</h2>
            <p class="text-lg md:text-xl mb-10">Sign up now to explore tournaments, track your stats, and connect with the global volleyball community.</p>
            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 px-10 py-5 rounded-lg text-lg font-semibold shadow-lg transition">
                Register Today
            </a>
        </div>
    </section>

</body>
</html>
