<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Volitis Volleyball') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gradient-to-b from-white to-blue-50 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">

<!-- Navbar -->
<!-- Navbar -->
<header id="navbar" class="fixed top-0 left-0 w-full px-8 py-5 flex justify-between items-center z-30 bg-black/20 backdrop-blur-sm transition-all duration-300">
    <h1 class="text-3xl font-extrabold text-white tracking-wide">VolleyLV</h1>
    @if (Route::has('login'))
        <nav class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-6 py-2 text-white border border-white/50 rounded-lg hover:bg-white hover:text-black transition">
                    Log in
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<!-- JS for scroll effect -->
<script>
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('bg-gray-900/80', 'backdrop-blur-md');
            navbar.classList.remove('bg-black/20');
        } else {
            navbar.classList.remove('bg-gray-900/80', 'backdrop-blur-md');
            navbar.classList.add('bg-black/20');
        }
    });
</script>

<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center text-center bg-cover bg-center"
         style="background-image: url('https://www.avca.org/wp-content/uploads/bb-plugin/cache/gcu-ncca-men-national-e1689195844675-panorama-222901b0b8954651eaa8785e22722153-sry8vcfa2h67.jpg');">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative z-20 max-w-4xl px-6">
        <h2 class="text-5xl md:text-6xl font-extrabold text-white drop-shadow-2xl mb-6">
            Experience Volleyball Like Never Before
        </h2>
        <p class="text-xl md:text-2xl text-gray-200 mb-10">
            Tournaments • Highlights • Global Community
        </p>
        <div class="flex justify-center gap-6">
            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-xl text-lg shadow-lg transition transform hover:-translate-y-1">
                Get Started
            </a>
            <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/40 text-white px-10 py-4 rounded-xl text-lg shadow-lg transition transform hover:-translate-y-1">
                Login
            </a>
        </div>
    </div>
</section>

<!-- Highlights Section -->
<section class="relative py-24 bg-gradient-to-b from-white via-blue-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl font-extrabold text-center mb-16 text-gray-900 dark:text-gray-100">Highlights</h2>
        <div class="flex gap-4 justify-center">
            @foreach ([
                'https://www.nippon.com/en/ncommon/contents/japan-topics/2470950/2470950.jpg',
                'https://volleycountry.com/wp-content/uploads/2020/11/olympics-volleyball-rio-1080x675.jpg',
                'https://www.fivb.com/wp-content/uploads/2025/04/101752-scaled.jpeg',
                'https://www.fivb.com/wp-content/uploads/2025/04/101819.jpeg',
                'https://www.fivb.com/wp-content/uploads/2025/04/102016-1.jpeg',
                'https://webmedia.cev.eu/media/rrwihtzp/205034__mi_1278.jpg?width=1920&v=1d904df8b710bc0'
            ] as $img)
            <div class="relative flex-1 overflow-hidden rounded-3xl shadow-2xl transition-all duration-500 transform hover:scale-110">
                <img src="{{ $img }}" alt="Volleyball Image"
                     class="w-full h-48 object-cover transition-all duration-500">
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Call to Action -->
<!-- Social Media Footer -->
<footer class="bg-gray-100 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Connect with us</h3>
        <div class="flex justify-center gap-6">
            <a href="https://www.facebook.com/" target="_blank" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 transition">
                <svg class="w-6 h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M22.675 0h-21.35c-.734 0-1.325.591-1.325 1.325v21.351c0 .734.591 1.324 1.325 1.324h11.495v-9.294h-3.124v-3.622h3.124v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.464.099 2.795.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.587l-.467 3.622h-3.12v9.293h6.116c.733 0 1.324-.59 1.324-1.324v-21.35c0-.734-.591-1.325-1.324-1.325z"/>
                </svg>
            </a>
            <a href="https://twitter.com/" target="_blank" class="text-gray-700 dark:text-gray-300 hover:text-blue-400 transition">
                <svg class="w-6 h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 4.557a9.83 9.83 0 01-2.828.775 4.932 4.932 0 002.165-2.724 9.864 9.864 0 01-3.127 1.195 4.916 4.916 0 00-8.38 4.482c-4.083-.195-7.702-2.16-10.126-5.134a4.822 4.822 0 00-.664 2.475c0 1.708.87 3.216 2.188 4.099a4.904 4.904 0 01-2.228-.616c-.054 1.982 1.381 3.833 3.415 4.247a4.936 4.936 0 01-2.224.084 4.923 4.923 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.396 0-.788-.023-1.175-.068a13.945 13.945 0 007.557 2.212c9.054 0 14.001-7.496 14.001-13.986 0-.21-.005-.423-.014-.634a9.936 9.936 0 002.457-2.548l.002-.003z"/>
                </svg>
            </a>
            <a href="https://www.instagram.com/" target="_blank" class="text-gray-700 dark:text-gray-300 hover:text-pink-500 transition">
                <svg class="w-6 h-6 inline-block" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.07 1.646.07 4.851s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.07-4.85.07s-3.584-.012-4.851-.07c-1.366-.062-2.633-.336-3.608-1.311-.975-.975-1.249-2.242-1.311-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.851c.062-1.366.336-2.633 1.311-3.608.975-.975 2.242-1.249 3.608-1.311 1.266-.058 1.646-.07 4.851-.07zm0-2.163c-3.259 0-3.667.012-4.947.072-1.523.066-2.874.35-3.905 1.382-1.031 1.03-1.315 2.382-1.382 3.905-.06 1.28-.072 1.688-.072 4.947s.012 3.667.072 4.947c.066 1.523.35 2.874 1.382 3.905 1.03 1.031 2.382 1.315 3.905 1.382 1.28.06 1.688.072 4.947.072s3.667-.012 4.947-.072c1.523-.066 2.874-.35 3.905-1.382 1.031-1.03 1.315-2.382 1.382-3.905.06-1.28.072-1.688.072-4.947s-.012-3.667-.072-4.947c-.066-1.523-.35-2.874-1.382-3.905-1.03-1.031-2.382-1.315-3.905-1.382-1.28-.06-1.688-.072-4.947-.072zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998zm6.406-11.845a1.44 1.44 0 11-2.879 0 1.44 1.44 0 012.879 0z"/>
                </svg>
            </a>
        </div>
        <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }} VolleyLV. All rights reserved.</p>
    </div>
</footer>


</body>
</html>
