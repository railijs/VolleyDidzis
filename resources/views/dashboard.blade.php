<x-app-layout>
    <div class="relative min-h-screen pt-24 pb-16 bg-gradient-to-b from-white via-red-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            <!-- Featured News Section -->
            @if ($news->isNotEmpty())
                @php $featured = $news->first(); @endphp
                <div class="grid lg:grid-cols-3 gap-10 items-start">

                    <!-- Featured News -->
                    <div
                        class="lg:col-span-2 relative group overflow-hidden rounded-3xl shadow-2xl hover:scale-105 transition transform hover:-translate-y-1">
                        @if ($featured->image)
                            <a href="{{ route('news.show', $featured) }}">
                                <img src="{{ Storage::url($featured->image) }}" alt="{{ $featured->title }}"
                                    class="w-full h-96 object-cover transition-transform duration-500 group-hover:scale-110 brightness-90">
                            </a>
                        @endif
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-8">
                            @if ($featured->category)
                                <span
                                    class="text-xs text-red-400 font-bold uppercase tracking-wider">{{ $featured->category }}</span>
                            @endif
                            <h3 class="text-3xl text-white font-extrabold mt-2">
                                <a href="{{ route('news.show', $featured) }}"
                                    class="hover:text-red-300 transition">{{ $featured->title }}</a>
                            </h3>
                            <p class="text-gray-200 mt-1 text-sm">{{ $featured->created_at->format('d.m.Y') }}</p>
                            <p class="text-gray-100 mt-3 line-clamp-4">
                                {{ Str::limit(strip_tags($featured->content), 250) }}</p>
                        </div>
                    </div>

                    <!-- Smaller News Cards -->
                    <div class="space-y-6">
                        @foreach ($news->skip(1)->take(3) as $item)
                            <div
                                class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105">
                                @if ($item->image)
                                    <a href="{{ route('news.show', $item) }}">
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}"
                                            class="w-full h-40 object-cover transition-transform duration-500 group-hover:scale-105">
                                    </a>
                                @endif
                                <div class="p-4 flex flex-col h-full">
                                    @if ($item->category)
                                        <span
                                            class="text-xs text-red-600 uppercase font-semibold mb-1">{{ $item->category }}</span>
                                    @endif
                                    <h4 class="font-bold text-gray-900 text-lg mb-1 line-clamp-2">
                                        <a href="{{ route('news.show', $item) }}"
                                            class="hover:text-red-500 transition">{{ $item->title }}</a>
                                    </h4>
                                    <p class="text-gray-500 text-xs mb-2">{{ $item->created_at->format('d.m.Y') }}</p>
                                    <p class="text-gray-700 flex-1 text-sm line-clamp-3">
                                        {{ Str::limit(strip_tags($item->content), 150) }}</p>
                                    <a href="{{ route('news.show', $item) }}"
                                        class="mt-3 inline-block text-red-600 hover:text-red-800 font-medium text-sm transition">
                                        Lasīt tālāk →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tournaments Section -->
            @php $closestTournaments = $tournaments->sortBy('start_date')->take(6); @endphp
            @if ($closestTournaments->isNotEmpty())
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-10 border-l-4 border-red-600 pl-3">Tuvākie
                        Turnīri</h2>

                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach ($closestTournaments as $tournament)
                            @php
                                $gender = $tournament->gender_type;
                                $badgeColor = match ($gender) {
                                    'men' => 'bg-blue-500',
                                    'women' => 'bg-pink-500',
                                    'mix' => 'bg-purple-500',
                                    default => 'bg-gray-400',
                                };
                            @endphp

                            <div
                                class="relative rounded-2xl shadow-xl overflow-hidden bg-white flex flex-col md:flex-row hover:shadow-2xl transition transform hover:-translate-y-1">
                                <!-- Left: Book-style info -->
                                <div
                                    class="w-full md:w-1/3 bg-gray-50 p-6 flex flex-col justify-between border-r border-gray-200">
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $tournament->name }}</h4>
                                        <span
                                            class="text-white text-xs font-bold px-3 py-1 rounded-full {{ $badgeColor }}">
                                            {{ ucfirst($gender) }}
                                        </span>
                                    </div>
                                    <div class="mt-4 text-gray-700 text-sm space-y-1">
                                        <p><strong>Dates:</strong>
                                            {{ \Carbon\Carbon::parse($tournament->start_date)->format('d.m.Y') }} –
                                            {{ \Carbon\Carbon::parse($tournament->end_date)->format('d.m.Y') }}</p>
                                        <p><strong>Location:</strong> {{ $tournament->location ?? 'TBA' }}</p>
                                        <p><strong>Team Size:</strong> {{ $tournament->team_size }} players</p>
                                        <p><strong>Applications:</strong> {{ $tournament->applications->count() }}
                                            @if ($tournament->max_teams)
                                                /{{ $tournament->max_teams }}
                                            @endif
                                        </p>
                                        <p><strong>Age Limit:</strong>
                                            @if ($tournament->min_age && $tournament->max_age)
                                                {{ $tournament->min_age }}–{{ $tournament->max_age }} yrs
                                            @elseif($tournament->min_age)
                                                ≥ {{ $tournament->min_age }} yrs
                                            @elseif($tournament->max_age)
                                                ≤ {{ $tournament->max_age }} yrs
                                            @else
                                                No limit
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Right: Description + Action -->
                                <div class="flex-1 p-6 flex flex-col justify-between">
                                    <p class="text-gray-600 text-sm line-clamp-4 mb-4">{{ $tournament->description }}
                                    </p>
                                    <a href="{{ route('tournaments.show', $tournament) }}"
                                        class="self-start px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold shadow-md hover:shadow-lg transition">
                                        Skatīt detaļas
                                    </a>
                                </div>

                                <!-- Watermark Logo -->
                                <img src="{{ asset('images/volleylv-logo.png') }}" alt="Logo"
                                    class="absolute bottom-2 right-2 w-20 h-20 opacity-10 transition-all">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
