<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ienākt - VolleyLV</title>

    <!-- Performance: preconnect + preload critical assets -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com" crossorigin>
    <link rel="preload" as="image" href="{{ asset('images/volleylv-logo.png') }}">

    <!-- Prefetch opposite page to speed up navigation -->
    <link rel="prefetch" href="{{ route('register') }}" as="document">

    <script src="https://cdn.tailwindcss.com" defer></script>

    <style>
        /* View Transitions: nicer cross-page fade (supported in modern Chromium/Firefox) */
        ::view-transition-old(root),
        ::view-transition-new(root) {
            animation-duration: 200ms;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-red-700 via-red-600 to-red-700/90">
    <!-- BG soft glows (kept subtle; blurs are costly, so opacity is reduced) -->
    <div class="pointer-events-none fixed inset-0 select-none" aria-hidden="true">
        <div class="absolute -top-32 -left-24 h-96 w-96 rounded-full blur-3xl opacity-20 bg-red-500"></div>
        <div class="absolute -bottom-40 -right-24 h-[28rem] w-[28rem] rounded-full blur-[90px] opacity-15 bg-red-400">
        </div>
    </div>

    <main id="pageRoot" class="relative z-10 transition-opacity duration-200 ease-out opacity-0">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-10 items-start">
                <!-- LEFT: Logo + Heading + Copy -->
                <section class="text-white">
                    <div class="flex items-center gap-5">
                        <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV"
                            class="h-14 w-14 sm:h-16 sm:w-16 object-contain" decoding="async" fetchpriority="high" />
                        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Ienākt</h1>
                    </div>

                    <p class="mt-4 text-lg text-red-100 leading-relaxed max-w-xl">
                        Ienāc, lai sekotu saviem turnīriem un spēlēm, pārvaldītu komandas un redzētu jaunākās ziņas.
                    </p>

                    <p class="mt-6 text-red-100">
                        Nav konta?
                        <a href="{{ route('register') }}" data-transition
                            class="underline font-semibold hover:text-white" data-prefetch>Reģistrēties</a>
                    </p>

                    <div class="mt-10 h-px w-full bg-white/10"></div>
                </section>

                <!-- RIGHT: Login Card -->
                <section>
                    <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden">
                        <div class="h-3 bg-gradient-to-r from-red-600 via-red-500 to-red-600"></div>
                        <div class="p-6 sm:p-8">
                            <h2 class="text-xl font-extrabold text-neutral-900">Laipni lūdzam atpakaļ</h2>
                            <p class="text-sm text-neutral-600 mt-1">Ienāc ar savu e-pastu un paroli.</p>

                            @if ($errors->any())
                                <div
                                    class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                                    <ul class="list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div
                                    class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                                @csrf

                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-neutral-800 mb-1.5">E-pasts</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        required autofocus
                                        class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-neutral-900 placeholder-neutral-400
                                focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600"
                                        placeholder="you@example.com" />
                                </div>

                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-neutral-800 mb-1.5">Parole</label>
                                    <input id="password" type="password" name="password" required
                                        class="block w-full rounded-lg border border-neutral-300 bg-white px-3 py-2.5 text-neutral-900 placeholder-neutral-400
                                focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600"
                                        placeholder="••••••••" />
                                </div>

                                <div class="flex items-center">
                                    <label for="remember_me" class="inline-flex items-center gap-2">
                                        <input id="remember_me" type="checkbox" name="remember"
                                            class="rounded border-neutral-300 text-red-600 shadow-sm focus:ring-red-600">
                                        <span class="text-sm text-neutral-700">Atcerēties mani</span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('register') }}" data-transition
                                        class="text-sm text-neutral-600 hover:text-neutral-800 underline underline-offset-4"
                                        data-prefetch>
                                        Vai nav konta? Reģistrējies
                                    </a>

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg
                                 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold
                                 px-6 py-3 shadow-lg shadow-red-700/20 hover:to-red-800
                                 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                                        Ienākt
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>

            <!-- CONTACTS -->
            <section class="mt-14">
                <div class="h-px bg-white/15"></div>

                <div class="grid lg:grid-cols-2 gap-8 items-start text-white mt-8">
                    <div>
                        <p class="uppercase tracking-[0.2em] text-[11px] text-red-100/90 font-bold">Kontakti</p>
                        <h3 class="text-3xl font-extrabold mt-1">Sazinies ar VolleyLV</h3>
                        <p class="mt-2 text-red-100 max-w-xl">
                            Jautājumi par turnīriem, sadarbības piedāvājumi vai atbalsts — droši raksti vai zvani.
                        </p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <a href="tel:+37120001234"
                            class="group inline-flex items-center gap-3 rounded-xl border border-white/20 bg-white/10 px-4 py-3 hover:bg-white/15 hover:border-white/30 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90" viewBox="0 0 24 24"
                                fill="currentColor" aria-hidden="true">
                                <path
                                    d="M6.62 10.79a15.05 15.05 0 006.59 6.59l1.82-1.82a1 1 0 011.01-.24c1.1.37 2.28.57 3.5.57a1 1 0 011 1V21a1 1 0 01-1 1C10.07 22 2 13.93 2 3a1 1 0 011-1h3.11a1 1 0 011 1c0 1.22.2 2.4.57 3.5a1 1 0 01-.24 1.01l-1.82 1.82z" />
                            </svg>
                            <span class="font-semibold">+371 20001234</span>
                        </a>

                        <a href="mailto:info@volleylv.example"
                            class="group inline-flex items-center gap-3 rounded-xl border border-white/20 bg-white/10 px-4 py-3 hover:bg-white/15 hover:border-white/30 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90" viewBox="0 0 24 24"
                                fill="currentColor" aria-hidden="true">
                                <path
                                    d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 2v.01L12 13 4 6.01V6h16zM4 18V8.236l7.386 5.74a1 1 0 001.228 0L20 8.236V18H4z" />
                            </svg>
                            <span class="font-semibold">info@volleylv.example</span>
                        </a>

                        <div class="flex items-center gap-3 pt-1 text-sm text-red-100">
                            <span class="inline-flex items-center gap-1">
                                <span class="h-2 w-2 rounded-full bg-green-300"></span> Atbildam darba dienās
                                09:00–18:00
                            </span>
                        </div>
                    </div>
                </div>

                <p class="text-center text-xs text-red-100 mt-8">
                    © {{ date('Y') }} VolleyLV. Visas tiesības aizsargātas.
                </p>
            </section>
        </div>
    </main>

    <script>
        // Fade-in once Tailwind is ready (script is deferred)
        const root = document.getElementById('pageRoot');
        requestAnimationFrame(() => root.classList.remove('opacity-0'));

        // Prefetch on hover/touch for extra snappiness
        document.addEventListener('mouseover', prefetchHandler, {
            passive: true
        });
        document.addEventListener('touchstart', prefetchHandler, {
            passive: true
        });

        function prefetchHandler(e) {
            const a = e.target.closest('a[data-prefetch]');
            if (!a || a.dataset.prefetched) return;
            const l = document.createElement('link');
            l.rel = 'prefetch';
            l.as = 'document';
            l.href = a.href;
            document.head.appendChild(l);
            a.dataset.prefetched = '1';
        }

        // View Transitions navigation (no artificial timeout)
        document.addEventListener('click', (e) => {
            const a = e.target.closest('a[data-transition]');
            if (!a) return;
            if (!document.startViewTransition) return; // graceful fallback: default navigation
            e.preventDefault();
            const href = a.href;
            document.startViewTransition(() => {
                window.location.href = href;
            });
        });
    </script>
</body>

</html>
