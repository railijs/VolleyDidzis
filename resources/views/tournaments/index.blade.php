<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight text-center">
            Tournaments
        </h2>
    </x-slot>

    <div class="relative min-h-screen pt-24 pb-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-6">
            
            <!-- Success message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($tournaments->count())
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                    <form class="divide-y divide-gray-200">
                        @foreach($tournaments as $tournament)
                            <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        {{ $tournament->name }}
                                    </h3>
                                    <p class="text-gray-600 mb-3">
                                        {{ $tournament->description }}
                                    </p>
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                        <span>
                                            <strong>Date:</strong> 
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d M Y') }}
                                        </span>
                                        @if($tournament->location)
                                            <span><strong>Location:</strong> {{ $tournament->location }}</span>
                                        @endif
                                        @if($tournament->max_teams)
                                            <span><strong>Max Teams:</strong> {{ $tournament->max_teams }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <button type="button"
                                            onclick="document.getElementById('modal-{{ $tournament->id }}').classList.remove('hidden')"
                                            class="inline-block px-5 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                                        View Details / Join
                                    </button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div id="modal-{{ $tournament->id }}" class="fixed inset-0 flex items-center justify-center z-50 hidden">
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
                                     onclick="document.getElementById('modal-{{ $tournament->id }}').classList.add('hidden')"></div>

                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl z-10 overflow-y-auto max-h-[90vh]">
                                    <h2 class="text-2xl font-bold mb-4">{{ $tournament->name }}</h2>
                                    <p class="mb-4">{{ $tournament->description ?? 'No description provided.' }}</p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 mb-6">
                                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($tournament->start_date)->format('F j, Y') }} – {{ \Carbon\Carbon::parse($tournament->end_date)->format('F j, Y') }}</p>
                                        <p><strong>Location:</strong> {{ $tournament->location ?? 'TBA' }}</p>
                                        <p><strong>Gender:</strong> {{ ucfirst($tournament->gender_type) }}</p>
                                        <p><strong>Team Size:</strong> {{ $tournament->team_size }}</p>
                                        <p><strong>Applications:</strong> {{ $tournament->applications->count() }} / {{ $tournament->max_teams ?? 'Unlimited' }}</p>
                                    </div>

                                    <!-- Join Form -->
                                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 mb-4">
                                        <h3 class="font-semibold mb-2">Apply to Join</h3>
                                        <form method="POST" action="{{ route('tournaments.join', $tournament) }}" class="space-y-3">
                                            @csrf
                                            <div>
                                                <label for="team_name-{{ $tournament->id }}" class="block text-sm font-medium text-gray-700">Team Name</label>
                                                <input type="text" name="team_name" id="team_name-{{ $tournament->id }}" required
                                                       class="w-full mt-1 border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                            <div>
                                                <label for="captain_name-{{ $tournament->id }}" class="block text-sm font-medium text-gray-700">Captain Name</label>
                                                <input type="text" name="captain_name" id="captain_name-{{ $tournament->id }}" required
                                                       class="w-full mt-1 border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                            <div>
                                                <label for="email-{{ $tournament->id }}" class="block text-sm font-medium text-gray-700">Contact Email</label>
                                                <input type="email" name="email" id="email-{{ $tournament->id }}" required
                                                       class="w-full mt-1 border border-gray-300 rounded-md p-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            </div>
                                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow transition">
                                                Submit Application
                                            </button>
                                        </form>
                                    </div>

                                    <div class="text-right">
                                        <button onclick="document.getElementById('modal-{{ $tournament->id }}').classList.add('hidden')"
                                                class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>
            @else
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('tournaments.create') }}" 
                       class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                       + Create Tournament
                    </a>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>

<footer class="bg-white border-t border-gray-200 py-8">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} VolleyLV. All rights reserved.</p>
    </div>
</footer>
