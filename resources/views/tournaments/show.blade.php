<x-app-layout>
<div class="max-w-4xl mx-auto mt-24 mb-12 px-4 sm:px-6 lg:px-8">

    <!-- Tournament Header -->
    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-4">
        <h1 class="text-xl sm:text-3xl font-bold text-gray-900 truncate">{{ $tournament->name }}</h1>

        @php
            $gender = $tournament->gender_type;
            $badgeColor = match($gender) {
                'men' => 'bg-blue-500',
                'women' => 'bg-pink-500',
                'mix' => 'bg-gradient-to-r from-blue-500 to-pink-500',
                default => 'bg-gray-400'
            };
            $tooltip = match($gender) {
                'men' => 'Men’s Tournament',
                'women' => 'Women’s Tournament',
                'mix' => 'Mixed Tournament',
                default => 'Tournament'
            };
        @endphp

        <span class="text-xs sm:text-sm font-semibold px-3 py-1 rounded-full {{ $badgeColor }} text-white"
              title="{{ $tooltip }}">
            {{ ucfirst($gender) }}
        </span>
    </div>

    <!-- Edit/Delete Buttons (Admins) -->
    @if(auth()->user() && auth()->user()->isAdmin())
        <div class="flex flex-col sm:flex-row sm:space-x-3 gap-2 mb-6">
            <a href="{{ route('tournaments.edit', $tournament) }}"
               class="inline-flex items-center justify-center text-gray-700 hover:text-gray-900 border border-gray-300 hover:border-gray-400 px-3 py-2 rounded-md text-sm font-medium transition">
                Edit
            </a>

            <button type="button"
                    class="inline-flex items-center justify-center text-gray-700 hover:text-red-600 border border-gray-300 hover:border-red-400 px-3 py-2 rounded-md text-sm font-medium transition"
                    onclick="document.getElementById('delete-modal').classList.remove('hidden')">
                Delete
            </button>
        </div>

        <!-- Delete Modal -->
        <div id="delete-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm" 
                 onclick="document.getElementById('delete-modal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-lg shadow-lg p-4 sm:p-6 w-full max-w-sm z-10">
                <h2 class="text-lg sm:text-xl font-semibold text-red-600 mb-3">Confirm Deletion</h2>
                <p class="text-gray-700 mb-4 text-sm">
                    Are you sure you want to delete <strong>{{ $tournament->name }}</strong>? This action cannot be undone.
                </p>
                <div class="flex flex-col sm:flex-row justify-end gap-2">
                    <button type="button"
                            class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100"
                            onclick="document.getElementById('delete-modal').classList.add('hidden')">
                        Cancel
                    </button>
                    <form action="{{ route('tournaments.destroy', $tournament) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-medium transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Tournament Dates -->
    <p class="text-sm sm:text-base text-gray-600 mb-6 text-center">
        {{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }} – 
        {{ \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') }}
    </p>

    <!-- Start Tournament Button -->
    @if($tournament->status === 'pending' && (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin())))
        <div class="mb-6 text-center">
            <form action="{{ route('tournaments.start', $tournament) }}" method="POST">
                @csrf
                <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow transition text-sm sm:text-base">
                    Start Tournament
                </button>
            </form>
        </div>
    @endif

    <!-- Stop Tournament Button -->
    @if($tournament->status === 'active' && (auth()->id() === $tournament->creator_id || (auth()->user() && auth()->user()->isAdmin())))
        <div class="mb-6 text-center">
            <button type="button"
                    class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md shadow transition text-sm sm:text-base"
                    onclick="document.getElementById('stop-modal').classList.remove('hidden')">
                Stop Tournament
            </button>
        </div>

        <!-- Stop Modal -->
        <div id="stop-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm" 
                 onclick="document.getElementById('stop-modal').classList.add('hidden')"></div>
            <div class="relative bg-white rounded-lg shadow-lg p-4 sm:p-6 w-full max-w-sm z-10">
                <h2 class="text-lg sm:text-xl font-semibold text-red-600 mb-3">Confirm Stop</h2>
                <p class="text-gray-700 mb-4 text-sm">
                    Are you sure you want to stop <strong>{{ $tournament->name }}</strong>? 
                    Once stopped, the tournament will be marked as <strong>completed</strong>.
                </p>
                <div class="flex flex-col sm:flex-row justify-end gap-2">
                    <button type="button"
                            class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100"
                            onclick="document.getElementById('stop-modal').classList.add('hidden')">
                        Cancel
                    </button>
                    <form action="{{ route('tournaments.stop', $tournament) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-medium transition">
                            Stop
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Tournament Details -->
    <div class="border border-gray-400 rounded-lg p-4 sm:p-6 mb-6 bg-white shadow-sm">
        <p class="text-gray-800 mb-4 text-sm sm:text-base">{{ $tournament->description ?? 'No description provided.' }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4 text-sm sm:text-base text-gray-700">
            <p><strong>Location:</strong> {{ $tournament->location ?? 'TBA' }}</p>
            <p><strong>Applications:</strong> {{ $tournament->applications->count() }} / {{ $tournament->max_teams ?? 'Unlimited' }} applied</p>
            <p><strong>Gender:</strong> 
                @if($tournament->gender_type === 'men') Men
                @elseif($tournament->gender_type === 'women') Women
                @else Mixed (min {{ $tournament->min_boys }} boys, {{ $tournament->min_girls }} girls)
                @endif
            </p>
            <p><strong>Team Size:</strong> {{ $tournament->team_size }} players on court</p>
            <p><strong>Age Limit:</strong>
                @if($tournament->min_age && $tournament->max_age)
                    {{ $tournament->min_age }} – {{ $tournament->max_age }} years
                @elseif($tournament->min_age)
                    Minimum {{ $tournament->min_age }} years
                @elseif($tournament->max_age)
                    Maximum {{ $tournament->max_age }} years
                @else
                    No age restriction
                @endif
            </p>
            @if($tournament->recommendations)
                <p class="sm:col-span-2"><strong>Recommendations:</strong> {{ $tournament->recommendations }}</p>
            @endif
        </div>
    </div>

    <!-- Applicants List -->
    @if($tournament->applications->count())
        <div class="border border-gray-400 rounded-lg p-4 sm:p-6 mb-6 bg-white shadow-sm">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-3">Applicants</h2>
            <ul class="divide-y divide-gray-200 text-sm">
                @foreach($tournament->applications as $applicant)
                    <li class="py-2 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <span>
                            <strong>Team:</strong> {{ $applicant->team_name }} |
                            <strong>Captain:</strong> {{ $applicant->captain_name }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Join Form -->
    @if($tournament->status === 'pending')
        <div class="border border-gray-400 rounded-lg p-4 sm:p-6 mb-6 bg-white shadow-sm">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 mb-3">Apply to Join</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('tournaments.join', $tournament) }}" class="space-y-3">
                @csrf
                <div>
                    <label for="team_name" class="block text-sm font-medium text-gray-700">Team Name</label>
                    <input type="text" name="team_name" id="team_name" required
                           class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="captain_name" class="block text-sm font-medium text-gray-700">Captain Name</label>
                    <input type="text" name="captain_name" id="captain_name" required
                           class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                    <input type="email" name="email" id="email" required
                           class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <button type="submit"
                        class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow transition text-sm sm:text-base">
                    Submit Application
                </button>
            </form>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 sm:p-6 mb-6 text-yellow-800 text-center text-sm sm:text-base">
            Tournament has started or ended! Applications are closed.
        </div>
    @endif

    <!-- View Stats Button -->
    <div class="mb-6 text-center">
        <a href="{{ route('tournaments.stats', $tournament) }}"
           class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow transition text-sm sm:text-base">
            View Tournament Stats
        </a>
    </div>

    <!-- Back Button -->
    <div class="mt-8 text-center">
        <a href="{{ route('dashboard') }}"
           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md shadow-sm transition text-sm sm:text-base">
            ← Back to Tournaments
        </a>
    </div>
</div>
</x-app-layout>
