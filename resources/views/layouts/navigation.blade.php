<nav x-data="{ open: false }"
    class="fixed top-0 inset-x-0 z-50 backdrop-blur supports-[backdrop-filter]:bg-gradient-to-r bg-red-700/95 from-red-800/95 via-red-700/95 to-red-800/95 border-b border-white/10 shadow-[0_8px_24px_rgba(185,28,28,0.25)]">
    <!-- Bar -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="h-16 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center h-16">
                <span class="relative block h-12 w-12 overflow-visible">
                    <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV"
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2
                                h-auto w-auto max-h-16 max-w-16 object-contain
                                drop-shadow select-none pointer-events-none" />
                </span>
            </a>

            <!-- Desktop nav -->
            <div class="hidden sm:flex items-center gap-6">
                <a href="{{ route('dashboard') }}"
                    class="relative inline-flex items-center h-full text-sm font-medium px-0.5
                   {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/80 hover:text-white' }}
                   after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:rounded-full
                   {{ request()->routeIs('dashboard') ? 'after:w-full' : 'after:w-0 hover:after:w-full' }}
                   after:bg-gradient-to-r after:from-red-300 after:to-red-500 after:transition-all after:duration-200">
                    Sākums
                </a>

                <a href="{{ route('news.index') }}"
                    class="relative inline-flex items-center h-full text-sm font-medium px-0.5
                   {{ request()->routeIs('news.*') ? 'text-white' : 'text-white/80 hover:text-white' }}
                   after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:rounded-full
                   {{ request()->routeIs('news.*') ? 'after:w-full' : 'after:w-0 hover:after:w-full' }}
                   after:bg-gradient-to-r after:from-red-300 after:to-red-500 after:transition-all after:duration-200">
                    Ziņas
                </a>

                <a href="{{ route('tournaments.calendar') }}"
                    class="relative inline-flex items-center h-full text-sm font-medium px-0.5
                   {{ request()->routeIs('tournaments.calendar') ? 'text-white' : 'text-white/80 hover:text-white' }}
                   after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:rounded-full
                   {{ request()->routeIs('tournaments.calendar') ? 'after:w-full' : 'after:w-0 hover:after:w-full' }}
                   after:bg-gradient-to-r after:from-red-300 after:to-red-500 after:transition-all after:duration-200">
                    Kalendārs
                </a>

                <a href="{{ route('about') }}"
                    class="relative inline-flex items-center h-full text-sm font-medium px-0.5
                   {{ request()->routeIs('about') ? 'text-white' : 'text-white/80 hover:text-white' }}
                   after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:rounded-full
                   {{ request()->routeIs('about') ? 'after:w-full' : 'after:w-0 hover:after:w-full' }}
                   after:bg-gradient-to-r after:from-red-300 after:to-red-500 after:transition-all after:duration-200">
                    Par mums
                </a>

                {{-- Leaderboard (matches other link styles) --}}
                <a href="{{ route('leaderboard') }}"
                    class="relative inline-flex items-center h-full text-sm font-medium px-0.5
                   {{ request()->routeIs('leaderboard') ? 'text-white' : 'text-white/80 hover:text-white' }}
                   after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:rounded-full
                   {{ request()->routeIs('leaderboard') ? 'after:w-full' : 'after:w-0 hover:after:w-full' }}
                   after:bg-gradient-to-r after:from-red-300 after:to-red-500 after:transition-all after:duration-200">
                    Leaderboard
                </a>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}"
                            class="relative inline-flex items-center h-full text-sm font-medium px-0.5
                           {{ request()->routeIs('admin.*') ? 'text-white' : 'text-white/80 hover:text-white' }}
                           after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-0.5 after:rounded-full
                           {{ request()->routeIs('admin.*') ? 'after:w-full' : 'after:w-0 hover:after:w-full' }}
                           after:bg-gradient-to-r after:from-red-300 after:to-red-500 after:transition-all after:duration-200">
                            Admin panelis
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right (auth) -->
            <div class="profile hidden sm:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="text-white/85 hover:text-white transition font-medium">
                        Pieslēgties
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center rounded-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-1.5 font-semibold shadow-md ring-1 ring-white/10 transition">
                        Reģistrēties
                    </a>
                @endguest

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">

                            <button data-testid="profile-button"
                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 hover:bg-white/15 text-white transition ring-1 ring-white/15">
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
                            <form method="POST" action="{{ route('logout') }}" data-testid="logout-link">
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
                        d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-cloak x-show="open" x-transition.origin.top
        class="sm:hidden bg-gradient-to-r from-red-800 to-red-700 text-white border-t border-white/10">
        <div class="px-5 py-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'hover:bg-white/5' }}">
                Sākums
            </a>
            <a href="{{ route('news.index') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('news.*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'hover:bg-white/5' }}">
                Ziņas
            </a>
            <a href="{{ route('tournaments.calendar') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('tournaments.calendar') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'hover:bg-white/5' }}">
                Kalendārs
            </a>
            <a href="{{ route('about') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('about') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'hover:bg-white/5' }}">
                Par mums
            </a>

            {{-- Leaderboard (mobile) --}}
            <a href="{{ route('leaderboard') }}"
                class="block px-2 py-2 rounded-md {{ request()->routeIs('leaderboard') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'hover:bg-white/5' }}">
                Leaderboard
            </a>

            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.users') }}"
                        class="block px-2 py-2 rounded-md {{ request()->routeIs('admin.*') ? 'bg-white/10 text-white ring-1 ring-white/15' : 'hover:bg-white/5' }}">
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
                        class="flex-1 text-center rounded-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 px-4 py-2 font-semibold">
                        Reģistrēties
                    </a>
                </div>
            @else
                <div class="pt-4 text-sm text-white/85">{{ Auth::user()->name }} • {{ Auth::user()->email }}</div>
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
