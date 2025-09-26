<nav x-data="{ open: false }" class="fixed top-0 inset-x-0 z-50 bg-gray-900/95 border-b border-red-700/20">
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Red underline for desktop links */
        .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            height: 100%;
            padding: .25rem 0;
            transition: color .2s ease;
        }

        .nav-link:after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -6px;
            height: 2px;
            background: linear-gradient(90deg, #ef4444, #dc2626);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .22s ease;
            border-radius: 999px;
        }

        .nav-link:hover:after {
            transform: scaleX(1);
        }

        .nav-link.active:after {
            transform: scaleX(1);
        }
    </style>

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="h-16 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV" class="w-11 h-11 rounded-lg shadow">
                <span class="hidden sm:block text-white font-semibold tracking-wide">VolleyLV</span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden sm:flex items-center gap-8">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-white/90 hover:text-white' }}">
                    Sākums
                </a>

                <a href="{{ route('news.index') }}"
                    class="nav-link {{ request()->routeIs('news.*') ? 'active text-white' : 'text-white/90 hover:text-white' }}">
                    Ziņas
                </a>

                <a href="{{ route('tournaments.calendar') }}"
                    class="nav-link {{ request()->routeIs('tournaments.calendar') ? 'active text-white' : 'text-white/90 hover:text-white' }}">
                    Kalendārs
                </a>

                <a href="{{ route('about') }}"
                    class="nav-link {{ request()->routeIs('about') ? 'active text-white' : 'text-white/90 hover:text-white' }}">
                    Par mums
                </a>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}"
                            class="nav-link {{ request()->routeIs('admin.*') ? 'active text-white' : 'text-white/90 hover:text-white' }}">
                            Admin panelis
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right (auth) -->
            <div class="hidden sm:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-white/90 hover:text-white transition font-medium">
                        Pieslēgties
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center rounded-full bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 font-semibold shadow transition">
                        Reģistrēties
                    </a>
                @endguest

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/20 text-white transition">
                                <span class="text-sm font-semibold">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profils
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Izrakstīties
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <button @click="open = !open" class="sm:hidden p-2 rounded-md text-white hover:bg-white/10 transition"
                aria-label="Atvērt izvēlni">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-cloak x-show="open" x-transition.origin.top
        class="sm:hidden bg-gray-900 text-white border-t border-red-700/20">
        <div class="px-5 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-red-600/10 text-red-400 border-l-4 border-red-600' : 'hover:bg-white/5' }}">
                Sākums
            </a>
            <a href="{{ route('news.index') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('news.*') ? 'bg-red-600/10 text-red-400 border-l-4 border-red-600' : 'hover:bg-white/5' }}">
                Ziņas
            </a>
            <a href="{{ route('tournaments.calendar') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('tournaments.calendar') ? 'bg-red-600/10 text-red-400 border-l-4 border-red-600' : 'hover:bg-white/5' }}">
                Kalendārs
            </a>
            <a href="{{ route('about') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('about') ? 'bg-red-600/10 text-red-400 border-l-4 border-red-600' : 'hover:bg-white/5' }}">
                Par mums
            </a>

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users') }}"
                        class="block px-2 py-2 rounded-md {{ request()->routeIs('admin.*') ? 'bg-red-600/10 text-red-400 border-l-4 border-red-600' : 'hover:bg-white/5' }}">
                        Admin panelis
                    </a>
                @endif
            @endauth
        </div>

        <div class="px-5 pb-5 border-t border-white/10">
            @guest
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('login') }}"
                        class="flex-1 text-center rounded-full bg-white/10 hover:bg-white/20 px-4 py-2 font-semibold">
                        Pieslēgties
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex-1 text-center rounded-full bg-red-600 hover:bg-red-700 px-4 py-2 font-semibold">
                        Reģistrēties
                    </a>
                </div>
            @else
                <div class="pt-4 text-sm text-white/80">{{ Auth::user()->name }} • {{ Auth::user()->email }}</div>
                <div class="mt-3">
                    <a href="{{ route('profile.edit') }}" class="block py-2 hover:bg-white/5 rounded-md">Profils</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block py-2 w-full text-left hover:bg-white/5 rounded-md">Izrakstīties</button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>
