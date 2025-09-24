<x-app-layout>
    <div class="w-full max-w-md sm:max-w-3xl mx-auto mt-20 mb-16 px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 text-center">
            Create Volleyball Tournament
        </h1>

        <!-- Make the Alpine data function available BEFORE the form uses it -->
        <script>
            // define globally so Alpine can call tournamentForm() without timing issues
            window.tournamentForm = function() {
                return {
                    name: @json(old('name')),
                    gender: @json(old('gender_type', '')),
                    teamSize: @json(old('team_size', 6)),
                    maxTeams: @json(old('max_teams', 5)),
                    minBoys: @json(old('min_boys', 0)),
                    minGirls: @json(old('min_girls', 0)),
                    validateMix(field) {
                        if (field === 'minBoys') this.minBoys = Math.min(this.minBoys, this.teamSize - this.minGirls);
                        if (field === 'minGirls') this.minGirls = Math.min(this.minGirls, this.teamSize - this.minBoys);
                    }
                }
            }
        </script>

        <form method="POST" action="{{ route('tournaments.store') }}"
            class="bg-white border border-gray-200 shadow-md p-4 sm:p-6 rounded-lg space-y-4 sm:space-y-6"
            x-data="tournamentForm()">
            @csrf

            <!-- Tournament Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tournament Name*</label>
                <input type="text" name="name" x-model="name" value="{{ old('name') }}"
                    class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 
                      text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                @error('name')
                    <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date*</label>
                    <input type="date" name="start_date" min="{{ date('Y-m-d') }}" value="{{ old('start_date') }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('start_date')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date*</label>
                    <input type="date" name="end_date" min="{{ date('Y-m-d') }}" value="{{ old('end_date') }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('end_date')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location & Max Teams -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location*</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('location')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Teams*</label>
                    <input type="number" name="max_teams" x-model.number="maxTeams" min="2"
                        value="{{ old('max_teams', 5) }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('max_teams')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Team Size & Gender -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Players per Team*</label>
                    <input type="number" name="team_size" x-model.number="teamSize" min="1"
                        value="{{ old('team_size', 6) }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('team_size')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender Type*</label>
                    <select name="gender_type" x-model="gender"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                        <option value="">Select Type</option>
                        <option value="men" {{ old('gender_type') === 'men' ? 'selected' : '' }}>Men Only</option>
                        <option value="women" {{ old('gender_type') === 'women' ? 'selected' : '' }}>Women Only
                        </option>
                        <option value="mix" {{ old('gender_type') === 'mix' ? 'selected' : '' }}>Mixed</option>
                    </select>
                    @error('gender_type')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Mix inputs -->
            <div x-show="gender==='mix'" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-600">Min Boys on Court</label>
                    <input type="number" x-model.number="minBoys" @input="validateMix('minBoys')" min="0"
                        :max="teamSize - minGirls" name="min_boys" value="{{ old('min_boys', 0) }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('min_boys')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm text-gray-600">Min Girls on Court</label>
                    <input type="number" x-model.number="minGirls" @input="validateMix('minGirls')" min="0"
                        :max="teamSize - minBoys" name="min_girls" value="{{ old('min_girls', 0) }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('min_girls')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Age Restrictions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Age</label>
                    <input type="number" name="min_age" min="0" value="{{ old('min_age') }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('min_age')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Age</label>
                    <input type="number" name="max_age" min="0" value="{{ old('max_age') }}"
                        class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    @error('max_age')
                        <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Recommendations -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Recommendations / Rules (optional)</label>
                <textarea name="recommendations" rows="3"
                    class="w-full rounded-lg px-3 py-2 border border-gray-300 bg-gray-50 text-gray-900 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('recommendations') }}</textarea>
                @error('recommendations')
                    <p class="text-red-600 mt-1 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow transition text-sm sm:text-base">
                    Create Tournament
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
