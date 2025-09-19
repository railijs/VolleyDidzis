<nav x-data="{ open: false }" 
     id="mainNav"
     class="fixed top-0 left-0 w-full z-50 backdrop-blur-sm border-b border-transparent transition-all duration-300 
     {{ request()->routeIs('about') ? 'bg-gray-900' : 'bg-black/20' }}">

    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('images/volleylv-logo.png') }}" 
                         alt="VolleyLV Logo" 
                         class="w-14 h-14">
                </a>
            </div>

            <!-- Links (Desktop) -->
            <div class="hidden sm:flex items-center space-x-8">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-blue-400 transition">
                    {{ __('Home') }}
                </x-nav-link>

                <x-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')" class="text-white hover:text-blue-400 transition">
                    {{ __('News') }}
                </x-nav-link>

                <x-nav-link :href="route('tournaments.calendar')" :active="request()->routeIs('tournaments.calendar')" class="text-white hover:text-blue-400 transition">
                    {{ __('Calendar') }}
                </x-nav-link>

                <x-nav-link :href="route('about')" :active="request()->routeIs('about')" class="text-white hover:text-blue-400 transition">
                    {{ __('About Us') }}
                </x-nav-link>
            </div>

            <!-- Admin Links (right aligned) -->
            @if(auth()->user()?->isAdmin())
                <div class="hidden sm:flex items-center ml-6 space-x-4">
                    <x-nav-link :href="route('tournaments.create')" :active="request()->routeIs('tournaments.create')" class="text-white hover:text-blue-400 transition">
                        {{ __('Create Tournament') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.*')" class="text-white hover:text-blue-400 transition">
                        {{ __('Admin Panel') }}
                    </x-nav-link>
                </div>
            @endif

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-blue-400 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="ms-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" 
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" 
                        class="p-2 rounded-md text-white hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" 
                              class="inline-flex" 
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" 
                              class="hidden" 
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-black/90 text-white">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('news.index')" :active="request()->routeIs('news.*')">
                {{ __('News') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('tournaments.calendar')" :active="request()->routeIs('tournaments.calendar')">
                {{ __('Calendar') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('About Us') }}
            </x-responsive-nav-link>

            @if(auth()->user()?->isAdmin())
                <x-responsive-nav-link :href="route('tournaments.create')" :active="request()->routeIs('tournaments.create')">
                    {{ __('Create Tournament') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.*')">
                    {{ __('Admin Panel') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t border-white/10 px-4">
            <div class="font-medium text-base">{{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-300">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

@if (!request()->routeIs('about'))
<script>
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            nav.classList.add('bg-gray-900/80');
            nav.classList.remove('bg-black/20');
        } else {
            nav.classList.remove('bg-gray-900/80');
            nav.classList.add('bg-black/20');
        }
    });
</script>
@endif
