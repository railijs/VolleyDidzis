<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind + JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS Animate on Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="font-sans antialiased">
    <div class="bg-transparent">
        @include('layouts.navigation')

        <!-- Page Content fills everything below navbar -->
        <main class="h-[calc(100vh-6rem)]">
            {{ $slot }}
        </main>
    </div>

    <!-- AOS Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init({
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                offset: 50
            });
        });
    </script>
</body>

</html>
