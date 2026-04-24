<nav x-data="{ open: false }" class="fixed top-0 inset-x-0 z-50"
    style="background: #0F0F0E; border-bottom: 1px solid rgba(245,244,240,0.08); font-family: 'DM Sans', sans-serif;">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,900&family=DM+Sans:wght@400;500&display=swap');

        .nb-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.55);
            text-decoration: none;
            padding: 0;
            transition: color 0.15s;
            white-space: nowrap;
        }

        .nb-link:hover {
            color: rgba(245, 244, 240, 0.9);
        }

        .nb-link.active {
            color: #F5F4F0;
        }

        .nb-link::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 1px;
            background: #B8241C;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.2s ease;
        }

        .nb-link:hover::after,
        .nb-link.active::after {
            transform: scaleX(1);
        }

        .nb-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 900;
            font-style: italic;
            letter-spacing: -0.02em;
            color: #F5F4F0;
            text-decoration: none;
            line-height: 1;
        }

        .nb-logo-text em {
            color: #B8241C;
            font-style: normal;
        }

        .nb-btn-login {
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.55);
            text-decoration: none;
            transition: color 0.15s;
        }

        .nb-btn-login:hover {
            color: #F5F4F0;
        }

        .nb-btn-register {
            display: inline-flex;
            align-items: center;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #F5F4F0;
            text-decoration: none;
            border: 1px solid rgba(245, 244, 240, 0.2);
            padding: 0.4rem 1rem;
            transition: background 0.15s, border-color 0.15s;
        }

        .nb-btn-register:hover {
            background: rgba(245, 244, 240, 0.08);
            border-color: rgba(245, 244, 240, 0.35);
        }

        .nb-profile-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.06em;
            color: rgba(245, 244, 240, 0.7);
            background: none;
            border: 1px solid rgba(245, 244, 240, 0.12);
            padding: 0.35rem 0.75rem;
            cursor: pointer;
            transition: all 0.15s;
        }

        .nb-profile-btn:hover {
            color: #F5F4F0;
            border-color: rgba(245, 244, 240, 0.3);
            background: rgba(245, 244, 240, 0.05);
        }

        .nb-admin-badge {
            font-size: 0.6rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #B8241C;
            border: 1px solid rgba(184, 36, 28, 0.35);
            padding: 0.1rem 0.45rem;
            margin-left: 0.1rem;
        }

        /* Mobile */
        .nb-mobile-link {
            display: block;
            padding: 0.65rem 0;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: rgba(245, 244, 240, 0.55);
            text-decoration: none;
            border-bottom: 1px solid rgba(245, 244, 240, 0.06);
            transition: color 0.15s;
        }

        .nb-mobile-link:hover,
        .nb-mobile-link.active {
            color: #F5F4F0;
        }

        .nb-mobile-link.active {
            border-left: 2px solid #B8241C;
            padding-left: 0.75rem;
        }

        .nb-divider {
            width: 1px;
            height: 16px;
            background: rgba(245, 244, 240, 0.1);
        }

        /* Hamburger */
        .nb-hamburger {
            background: none;
            border: 1px solid rgba(245, 244, 240, 0.15);
            padding: 0.4rem;
            cursor: pointer;
            color: rgba(245, 244, 240, 0.7);
            transition: all 0.15s;
        }

        .nb-hamburger:hover {
            color: #F5F4F0;
            border-color: rgba(245, 244, 240, 0.3);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    {{-- Desktop bar --}}
    <div style="max-width:1200px; margin:0 auto; padding:0 1.5rem;">
        <div style="height:56px; display:flex; align-items:center; justify-content:space-between; gap:2rem;">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="nb-logo-text" style="flex-shrink:0;">
                Volley<em>LV</em>
            </a>

            {{-- Nav links (desktop) --}}
            <div class="hidden sm:flex items-center" style="gap:1.75rem; flex:1; padding-left:2rem;">
                <a href="{{ route('dashboard') }}"
                    class="nb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Sākums
                </a>
                <a href="{{ route('news.index') }}" class="nb-link {{ request()->routeIs('news.*') ? 'active' : '' }}">
                    Ziņas
                </a>
                <a href="{{ route('tournaments.calendar') }}"
                    class="nb-link {{ request()->routeIs('tournaments.calendar') ? 'active' : '' }}">
                    Kalendārs
                </a>
                <a href="{{ route('tournaments.index') }}"
                    class="nb-link {{ request()->routeIs('tournaments.index') ? 'active' : '' }}">
                    Turnīri
                </a>
                <a href="{{ route('about') }}" class="nb-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    Par mums
                </a>
                <a href="{{ route('leaderboard') }}"
                    class="nb-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}">
                    Kopvērtējums
                </a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}"
                            class="nb-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                            Admin <span class="nb-admin-badge">ADM</span>
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Auth (desktop) --}}
            <div class="hidden sm:flex items-center" style="gap:1rem; flex-shrink:0;">
                @guest
                    <a href="{{ route('login') }}" class="nb-btn-login">Pieslēgties</a>
                    <div class="nb-divider"></div>
                    <a href="{{ route('register') }}" class="nb-btn-register">Reģistrēties</a>
                @endguest

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="nb-profile-btn" data-testid="profile-button">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity:.6">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                                <svg width="10" height="10" viewBox="0 0 20 20" fill="currentColor"
                                    style="opacity:.4">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">Profils</x-dropdown-link>
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

            {{-- Hamburger (mobile) --}}
            <button @click="open = !open" class="nb-hamburger sm:hidden" aria-label="Izvēlne">
                <svg x-show="!open" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" x-cloak width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Ticker line under nav --}}
    <div
        style="height:2px; background: linear-gradient(to right, #B8241C 0%, rgba(184,36,28,0.3) 40%, transparent 70%);">
    </div>

    {{-- Mobile menu --}}
    <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        style="background:#0F0F0E; border-top:1px solid rgba(245,244,240,0.08);">
        <div style="max-width:1200px; margin:0 auto; padding:0.75rem 1.5rem 1.25rem;">

            <div style="display:flex; flex-direction:column;">
                <a href="{{ route('dashboard') }}"
                    class="nb-mobile-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Sākums</a>
                <a href="{{ route('news.index') }}"
                    class="nb-mobile-link {{ request()->routeIs('news.*') ? 'active' : '' }}">Ziņas</a>
                <a href="{{ route('tournaments.calendar') }}"
                    class="nb-mobile-link {{ request()->routeIs('tournaments.calendar') ? 'active' : '' }}">Kalendārs</a>
                <a href="{{ route('tournaments.index') }}"
                    class="nb-mobile-link {{ request()->routeIs('tournaments.index') ? 'active' : '' }}">Turnīri</a>
                <a href="{{ route('about') }}"
                    class="nb-mobile-link {{ request()->routeIs('about') ? 'active' : '' }}">Par mums</a>
                <a href="{{ route('leaderboard') }}"
                    class="nb-mobile-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}">Leaderboard</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}"
                            class="nb-mobile-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin panelis</a>
                    @endif
                @endauth
            </div>

            <div style="margin-top:1.25rem; padding-top:1rem; border-top:1px solid rgba(245,244,240,0.08);">
                @guest
                    <div style="display:flex; gap:0.75rem;">
                        <a href="{{ route('login') }}" class="nb-btn-register"
                            style="flex:1; justify-content:center;">Pieslēgties</a>
                        <a href="{{ route('register') }}" class="nb-btn-register"
                            style="flex:1; justify-content:center; background:rgba(184,36,28,0.15); border-color:rgba(184,36,28,0.4); color:#F5F4F0;">Reģistrēties</a>
                    </div>
                @endguest

                @auth
                    <div style="margin-bottom:0.75rem;">
                        <div
                            style="font-size:0.72rem; font-weight:500; letter-spacing:0.06em; color:rgba(245,244,240,0.4); text-transform:uppercase; margin-bottom:0.2rem;">
                            Pieslēdzies kā</div>
                        <div style="font-size:0.9rem; color:#F5F4F0;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.72rem; color:rgba(245,244,240,0.4);">{{ Auth::user()->email }}</div>
                    </div>
                    <div style="display:flex; gap:0.5rem;">
                        <a href="{{ route('profile.edit') }}" class="nb-btn-register">Profils</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nb-btn-register" style="cursor:pointer;">Izrakstīties</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
