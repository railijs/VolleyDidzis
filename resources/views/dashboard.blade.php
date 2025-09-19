<x-app-layout>
    <!-- Hero Section -->
    <div class="relative min-h-screen pt-24 pb-12 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 space-y-8">

            <!-- Welcome Card -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">Welcome to VolleyLV</h2>
                <p class="text-gray-600 text-base sm:text-lg leading-relaxed max-w-xl mx-auto">
                    You’re logged in to <span class="font-semibold text-gray-900">VolleyLV</span>. Track tournaments, follow player stats, and connect with the Latvian volleyball community.
                </p>
            </div>

            <!-- Closest Upcoming Tournaments -->
            @php
                $closestTournaments = $tournaments->sortBy('start_date')->take(3);
            @endphp

            @if($closestTournaments->count())
                <div>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Closest Upcoming Tournaments</h3>
                    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                        @foreach($closestTournaments as $tournament)
                            @php
                                $gender = $tournament->gender_type;
                                $badgeColor = match($gender) {
                                    'men' => 'bg-blue-500',
                                    'women' => 'bg-pink-500',
                                    'mix' => 'bg-gradient-to-r from-blue-500 to-pink-500',
                                    default => 'bg-gray-400'
                                };
                            @endphp
                            <div class="relative bg-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition transform hover:scale-105 border border-gray-200">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $tournament->name }}</h4>
                                    <span class="mt-2 sm:mt-0 text-xs font-semibold px-2 py-1 rounded-full {{ $badgeColor }} text-white">
                                        {{ ucfirst($gender) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">{{ $tournament->description }}</p>
                                <p class="text-xs text-gray-500">
                                    <strong>Dates:</strong> {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }} – {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    <strong>Location:</strong> {{ $tournament->location ?? 'TBA' }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    <strong>Teams Applied:</strong> {{ $tournament->applications->count() }} @if($tournament->max_teams) / {{ $tournament->max_teams }} @endif
                                </p>
                                <a href="{{ route('tournaments.show', $tournament) }}"
                                   class="block w-full mt-3 text-center px-3 py-2 bg-gray-900 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm transition">
                                   View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- All Upcoming Tournaments -->
            <div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Upcoming Tournaments</h3>

                <!-- Filter Section -->
                <div class="flex flex-col sm:flex-row flex-wrap gap-3 mb-4 items-stretch sm:items-center">
                    <input type="text" id="searchInput" placeholder="Search by tournament name..."
                        class="block w-full sm:w-64 border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <select id="genderFilter"
                        class="block w-full sm:w-48 border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Genders</option>
                        <option value="men">Men</option>
                        <option value="women">Women</option>
                        <option value="mix">Mixed</option>
                    </select>
                    <select id="locationFilter"
                        class="block w-full sm:w-48 border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Locations</option>
                        @foreach($tournaments->pluck('location')->unique() as $location)
                            @if($location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="date" id="dateFilter"
                        class="block w-full sm:w-48 border border-gray-300 rounded-lg px-3 py-2 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <button id="clearFilters"
                        class="w-full sm:w-auto px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition">
                        Clear Filters
                    </button>
                </div>

                <!-- Tournament List -->
                @if($tournaments->count())
                    <div id="tournamentList" class="bg-white border border-gray-200 shadow-md rounded-xl overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach($tournaments as $tournament)
                                <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 tournament-item"
                                    data-gender="{{ $tournament->gender_type }}"
                                    data-location="{{ $tournament->location }}"
                                    data-start="{{ $tournament->start_date }}"
                                    data-end="{{ $tournament->end_date }}"
                                    data-name="{{ strtolower($tournament->name) }}">
                                    
                                    <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-gray-100 rounded-lg border border-gray-200">
                                        <img src="{{ asset('images/volleylv-logo.png') }}" alt="VolleyLV Logo" class="w-8 h-8 object-contain">
                                    </div>
                                    
                                    <div class="flex-1 space-y-1">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                                            <h4 class="text-md sm:text-lg font-semibold text-gray-900">{{ $tournament->name }}</h4>
                                            @php
                                                $gender = $tournament->gender_type;
                                                $badgeColor = match($gender) {
                                                    'men' => 'bg-blue-500',
                                                    'women' => 'bg-pink-500',
                                                    'mix' => 'bg-gradient-to-r from-blue-500 to-pink-500',
                                                    default => 'bg-gray-400'
                                                };
                                            @endphp
                                            <span class="mt-1 sm:mt-0 text-xs font-semibold px-2 py-1 rounded-full {{ $badgeColor }} text-white">{{ ucfirst($gender) }}</span>
                                        </div>
                                        <p class="text-gray-600 text-sm">{{ $tournament->description }}</p>
                                        <div class="text-xs text-gray-500 space-y-1">
                                            <p><strong>Dates:</strong> {{ \Carbon\Carbon::parse($tournament->start_date)->format('M d, Y') }} – {{ \Carbon\Carbon::parse($tournament->end_date)->format('M d, Y') }}</p>
                                            <p><strong>Location:</strong> {{ $tournament->location ?? 'TBA' }}</p>
                                            <p><strong>Teams Applied:</strong> <span class="font-medium text-gray-900">{{ $tournament->applications->count() }}</span> @if($tournament->max_teams) / {{ $tournament->max_teams }} @endif</p>
                                        </div>
                                    </div>
                                    
                                    <a href="{{ route('tournaments.show', $tournament) }}" class="block w-full sm:w-auto mt-2 sm:mt-0 px-3 py-2 bg-gray-900 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm transition text-center">View Details</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 text-center">
                        <p class="text-gray-600 mb-3">No upcoming tournaments at the moment. Check back soon!</p>
                        <a href="{{ route('tournaments.create') }}" class="inline-block px-4 py-2 bg-gray-900 hover:bg-gray-700 text-white rounded-lg font-medium transition">Create Tournament</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const genderFilter = document.getElementById('genderFilter');
        const locationFilter = document.getElementById('locationFilter');
        const dateFilter = document.getElementById('dateFilter');
        const searchInput = document.getElementById('searchInput');
        const clearFilters = document.getElementById('clearFilters');
        const tournamentItems = document.querySelectorAll('.tournament-item');

        function filterTournaments() {
            const gender = genderFilter.value;
            const location = locationFilter.value;
            const date = dateFilter.value;
            const search = searchInput.value.toLowerCase();
            tournamentItems.forEach(item => {
                const itemGender = item.dataset.gender;
                const itemLocation = item.dataset.location;
                const itemStart = item.dataset.start;
                const itemEnd = item.dataset.end;
                const itemName = item.dataset.name;
                let show = true;
                if (gender && itemGender !== gender) show = false;
                if (location && itemLocation !== location) show = false;
                if (date && (date < itemStart || date > itemEnd)) show = false;
                if (search && !itemName.includes(search)) show = false;
                item.style.display = show ? 'flex' : 'none';
            });
        }

        function resetFilters() {
            genderFilter.value = '';
            locationFilter.value = '';
            dateFilter.value = '';
            searchInput.value = '';
            filterTournaments();
        }

        genderFilter.addEventListener('change', filterTournaments);
        locationFilter.addEventListener('change', filterTournaments);
        dateFilter.addEventListener('change', filterTournaments);
        searchInput.addEventListener('input', filterTournaments);
        clearFilters.addEventListener('click', resetFilters);
    </script>
</x-app-layout>


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