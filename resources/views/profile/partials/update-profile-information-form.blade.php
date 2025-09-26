<!-- Profile Information (VolleyLV style) -->
<form method="post" action="{{ route('profile.update') }}" class="space-y-6 form-skin">
    @csrf
    @method('patch')

    {{-- Name --}}
    <div>
        <label for="name">Vārds</label>
        <input id="name" name="name" type="text"
            class="mt-2 w-full rounded-xl border border-gray-300 bg-white px-3 py-2 text-gray-900
                   focus:border-red-500 focus:ring-2 focus:ring-red-200"
            value="{{ old('name', $user->name) }}" required autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    {{-- Email --}}
    <div>
        <label for="email">E-pasts</label>
        <div class="relative mt-2">
            <input id="email" name="email" type="email"
                class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 pr-20 text-gray-900
                       focus:border-red-500 focus:ring-2 focus:ring-red-200"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            {{-- Quick copy (optional, harmless if clipboard not allowed) --}}
            <button type="button"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-xs font-bold rounded-full px-2 py-1
                       bg-red-50 text-red-700 border border-red-200 hover:bg-red-100"
                onclick="navigator.clipboard?.writeText(document.getElementById('email').value)">
                Kopēt
            </button>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3">
        <button type="submit" class="btn-red rounded-full px-5 py-2 font-semibold shadow">
            Saglabāt
        </button>

        @if (session('status') === 'profile-updated')
            <span id="savedBadge"
                class="inline-flex items-center rounded-full bg-green-50 text-green-700 border border-green-200
                         px-3 py-1 text-sm font-semibold">
                Saglabāts
            </span>
            <script>
                // Auto-hide the "Saglabāts" badge after 2.2s
                setTimeout(() => document.getElementById('savedBadge')?.remove(), 2200);
            </script>
        @endif
    </div>
</form>
