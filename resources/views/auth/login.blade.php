<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ienākt - VolleyLV</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-b from-red-700 via-red-600 to-red-700/90">
    <!-- BG soft glows -->
    <div class="pointer-events-none fixed inset-0">
        <div class="absolute -top-32 -left-24 h-96 w-96 rounded-full blur-3xl opacity-25 bg-red-500"></div>
        <div class="absolute -bottom-40 -right-24 h-[28rem] w-[28rem] rounded-full blur-[90px] opacity-20 bg-red-400">
        </div>
    </div>

    <main id="pageRoot"
        class="relative z-10 transition-all duration-500 ease-out will-change-transform opacity-0 translate-x-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16 lg:py-20">
            <div class="grid lg:grid-cols-2 gap-10 items-start">
                <!-- LEFT: Logo + Heading + Copy -->
                <section class="text-white">
                    <div class="flex items-center gap-5">
                        <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV"
                            class="h-14 w-14 sm:h-16 sm:w-16 object-contain" />
                        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Ienākt</h1>
                    </div>

                    <p class="mt-4 text-lg text-red-100 leading-relaxed max-w-xl">
                        Ienāc, lai sekotu saviem turnīriem un spēlēm, pārvaldītu komandas un redzētu jaunākās ziņas.
                    </p>

                    <p class="mt-6 text-red-100">
                        Nav konta?
                        <a href="{{ route('register') }}" data-transition="left"
                            class="underline font-semibold hover:text-white">Reģistrēties</a>
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

                                <!-- Bottom row INSIDE the form: reģistrēties + poga -->
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('register') }}" data-transition="left"
                                        class="text-sm text-neutral-600 hover:text-neutral-800 underline underline-offset-4">
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
                            class="group inline-flex items-center gap-3 rounded-xl border border-white/20 bg-white/10 px-4 py-3
                      hover:bg-white/15 hover:border-white/30 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M6.62 10.79a15.05 15.05 0 006.59 6.59l1.82-1.82a1 1 0 011.01-.24c1.1.37 2.28.57 3.5.57a1 1 0 011 1V21a1 1 0 01-1 1C10.07 22 2 13.93 2 3a1 1 0 011-1h3.11a1 1 0 011 1c0 1.22.2 2.4.57 3.5a1 1 0 01-.24 1.01l-1.82 1.82z" />
                            </svg>
                            <span class="font-semibold">+371 20001234</span>
                        </a>

                        <a href="mailto:info@volleylv.example"
                            class="group inline-flex items-center gap-3 rounded-xl border border-white/20 bg-white/10 px-4 py-3
                      hover:bg-white/15 hover:border-white/30 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white/90" viewBox="0 0 24 24"
                                fill="currentColor">
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

    <!-- Page Transition Script (slide out/in) -->
    <script>
        // Slide IN on load
        const root = document.getElementById('pageRoot');
        requestAnimationFrame(() => {
            root.classList.remove('opacity-0', 'translate-x-8');
            root.classList.add('opacity-100', 'translate-x-0');
        });

        // Slide OUT when clicking a link with data-transition
        document.addEventListener('click', (e) => {
            const a = e.target.closest('a[data-transition]');
            if (!a) return;
            e.preventDefault();
            const dir = a.getAttribute('data-transition'); // "left" or "right"
            const href = a.getAttribute('href');

            sessionStorage.setItem('slideInFrom', dir === 'left' ? 'left' : 'right');

            root.classList.remove('translate-x-0', 'opacity-100');
            if (dir === 'left') {
                root.classList.add('-translate-x-10', 'opacity-0');
            } else {
                root.classList.add('translate-x-10', 'opacity-0');
            }

            setTimeout(() => window.location.assign(href), 320);
        });

        // Apply saved slide-in direction
        const saved = sessionStorage.getItem('slideInFrom');
        if (saved) {
            root.classList.remove('translate-x-0', 'opacity-100');
            root.classList.add(saved === 'left' ? 'translate-x-10' : '-translate-x-10', 'opacity-0');
            requestAnimationFrame(() => {
                root.classList.remove('translate-x-10', '-translate-x-10', 'opacity-0');
                root.classList.add('translate-x-0', 'opacity-100');
            });
            sessionStorage.removeItem('slideInFrom');
        }
    </script>
</body>

</html>
