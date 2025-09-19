<x-app-layout>
    <!-- Page Header -->
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900">
                {{ __('Profile Settings') }}
            </h2>
            <p class="text-sm text-gray-500 mt-2 sm:mt-0">
                {{ __('Manage your account details, security, and preferences.') }}
            </p>
        </div>
    </x-slot>

    <!-- Content -->
    <div class="mt-24 mb-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto grid gap-8 lg:grid-cols-3">

            <!-- Left Sidebar: Quick Info & Applied Tournaments -->
            <div class="bg-white shadow rounded-xl p-6 flex flex-col items-center text-center space-y-4 border border-gray-300">
                <!-- Avatar -->
                <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center text-3xl font-bold text-indigo-600">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                </div>
                <span class="px-3 py-1 text-xs font-medium bg-indigo-50 text-indigo-600 rounded-full">
                    {{ __('Member since') }} {{ auth()->user()->created_at->format('M Y') }}
                </span>

                <!-- Applied Tournaments -->
                <div class="mt-6 w-full text-left">
                    <h4 class="text-sm font-semibold text-gray-800 border-b border-gray-200 pb-2">
                        {{ __('My Tournaments') }}
                    </h4>
                    <ul class="mt-3 space-y-2 text-sm text-gray-700">
                        @forelse($appliedTournaments as $tournament)
                            <a href="{{ route('tournaments.show', $tournament) }}" class="block group">
                                <li class="px-3 py-2 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center hover:bg-gray-100 transition">
                                    <div>
                                        <span class="font-medium">{{ $tournament->name }}</span>
                                        <span class="block text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </li>
                            </a>
                        @empty
                            <li class="text-gray-500 italic">
                                {{ __('No tournaments applied yet.') }}
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Right Side: Profile Management -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Profile Info -->
                <div class="bg-white shadow rounded-xl p-6 border border-gray-300">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3">
                        {{ __('Profile Information') }}
                    </h3>
                    <div class="mt-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password -->
                <div class="bg-white shadow rounded-xl p-6 border border-gray-300">
                    <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-3">
                        {{ __('Update Password') }}
                    </h3>
                    <div class="mt-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="bg-white shadow-lg border border-red-300 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-red-600 border-b border-red-400 pb-3">
                        {{ __('') }}
                    </h3>
                    <div class="mt-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
