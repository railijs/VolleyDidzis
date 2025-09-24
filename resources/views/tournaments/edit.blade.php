<x-app-layout>
    <div class="w-full max-w-md sm:max-w-4xl mx-auto mt-20 mb-12 px-4 sm:px-6 lg:px-8" x-data="tournamentForm()">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 text-center">
            Edit Tournament: {{ $tournament->name }}
        </h1>

        @if (auth()->user()?->isAdmin())
            <div class="flex space-x-3 mb-6 justify-start">
                <button type="button"
                    class="inline-flex items-center text-gray-700 hover:text-red-600 border border-gray-400 hover:border-red-400 px-3 py-1.5 rounded-md text-sm font-medium transition"
                    @click="showDelete = true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Delete
                </button>
            </div>
        @endif

        <form action="{{ route('tournaments.update', $tournament) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow border border-gray-300 p-6 space-y-4">

                <!-- Basic Info -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-300 pb-2 mb-2">Basic Info</h2>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tournament Name</label>
                        <input type="text" name="name" id="name" x-model="name"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="3" x-model="description"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        @error('description')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dates & Location -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-300 pb-2 mb-2">Dates & Location
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" x-model="start_date"
                                class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_date')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" x-model="end_date"
                                class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('end_date')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" x-model="location"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('location')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Teams & Gender -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-300 pb-2 mb-2">Teams & Sizes
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="max_teams" class="block text-sm font-medium text-gray-700">Max Teams</label>
                            <input type="number" name="max_teams" id="max_teams" min="2"
                                x-model.number="maxTeams"
                                class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('max_teams')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="team_size" class="block text-sm font-medium text-gray-700">Team Size</label>
                            <input type="number" name="team_size" id="team_size" min="2"
                                x-model.number="teamSize" @input="adjustMix()"
                                class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('team_size')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="gender_type" class="block text-sm font-medium text-gray-700">Gender Type</label>
                        <select name="gender_type" id="gender_type" x-model="gender" @change="adjustMix()"
                            class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="men">Men</option>
                            <option value="women">Women</option>
                            <option value="mix">Mixed</option>
                        </select>
                    </div>

                    <template x-if="gender==='mix'">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="min_boys" class="block text-sm font-medium text-gray-700">Min Boys</label>
                                <input type="number" name="min_boys" id="min_boys" min="1"
                                    x-model.number="minBoys" @input="validateMix('minBoys')" :max="teamSize - 1"
                                    class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('min_boys')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="min_girls" class="block text-sm font-medium text-gray-700">Min
                                    Girls</label>
                                <input type="number" name="min_girls" id="min_girls" min="1"
                                    x-model.number="minGirls" @input="validateMix('minGirls')" :max="teamSize - 1"
                                    class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('min_girls')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </template>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="min_age" class="block text-sm font-medium text-gray-700">Min Age</label>
                            <input type="number" name="min_age" id="min_age" min="0"
                                x-model.number="minAge" @input="validateAge()"
                                class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('min_age')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="max_age" class="block text-sm font-medium text-gray-700">Max Age</label>
                            <input type="number" name="max_age" id="max_age" min="0"
                                x-model.number="maxAge" @input="validateAge()"
                                class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('max_age')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 space-y-2">
                    <h2 class="text-lg font-semibold text-gray-800 border-b border-gray-300 pb-2 mb-2">Recommendations
                    </h2>
                    <textarea name="recommendations" id="recommendations" rows="3" x-model="recommendations"
                        class="w-full mt-1 border border-gray-300 rounded-md p-2 text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow text-sm sm:text-base transition">
                        Update Tournament
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 
                sm:px-6 py-2 rounded-md shadow-sm transition text-sm sm:text-base">
                ← Back to Tournaments
            </a>
        </div>

    </div>

    <script>
        function tournamentForm() {
            return {
                name: @json(old('name', $tournament->name)),
                description: @json(old('description', $tournament->description)),
                start_date: @json(old('start_date', $tournament->start_date)),
                end_date: @json(old('end_date', $tournament->end_date)),
                location: @json(old('location', $tournament->location)),
                maxTeams: @json(old('max_teams', $tournament->max_teams)),
                teamSize: @json(old('team_size', $tournament->team_size)),
                gender: @json(old('gender_type', $tournament->gender_type)),
                minBoys: @json(old('min_boys', $tournament->min_boys)),
                minGirls: @json(old('min_girls', $tournament->min_girls)),
                minAge: @json(old('min_age', $tournament->min_age)),
                maxAge: @json(old('max_age', $tournament->max_age)),
                recommendations: @json(old('recommendations', $tournament->recommendations)),

                validateMix(field) {
                    if (field === 'minBoys') {
                        this.minBoys = Math.max(1, Math.min(this.minBoys, this.teamSize - 1));
                    }
                    if (field === 'minGirls') {
                        this.minGirls = Math.max(1, Math.min(this.minGirls, this.teamSize - 1));
                    }
                },

                adjustMix() {
                    if (this.gender !== 'mix') {
                        this.minBoys = 0;
                        this.minGirls = 0;
                    } else {
                        this.validateMix('minBoys');
                        this.validateMix('minGirls');
                    }
                },

                validateAge() {
                    if (this.minAge && this.maxAge && this.maxAge < this.minAge) {
                        this.maxAge = this.minAge;
                    }
                }
            }
        }
    </script>
</x-app-layout>
