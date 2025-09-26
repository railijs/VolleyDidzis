<!-- Delete Account (VolleyLV style) -->
<div class="glass p-6 sm:p-8 rounded-2xl border border-red-200/60 bg-red-50/40">
    <div class="flex items-start gap-3">
        <div class="shrink-0 mt-0.5 inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-600 text-white">
            <!-- warning icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-extrabold text-gray-900">Dzēst kontu</h3>
            <p class="mt-1 text-sm text-gray-700">
                Pēc konta dzēšanas visi dati tiks neatgriezeniski izdzēsti.
                Lejupielādē visu, ko vēlies paturēt, pirms turpināt.
            </p>
            <div class="mt-5 flex justify-end">
                <button type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white
                           font-semibold px-5 py-2 shadow transition">
                    Dzēst kontu
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal (unchanged name & behavior) -->
<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 space-y-6">
        @csrf
        @method('delete')

        <div class="space-y-2">
            <h2 class="text-xl font-extrabold text-gray-900">Vai tiešām dzēst kontu?</h2>
            <p class="text-sm text-gray-600">
                Šī darbība ir neatgriezeniska. Lai apstiprinātu, ievadi savu paroli.
            </p>
        </div>

        <!-- Password -->
        <div>
            <label for="delete_password" class="block text-sm font-semibold text-gray-900">Parole</label>
            <div class="relative mt-2">
                <input id="delete_password" name="password" type="password" autocomplete="current-password" required
                    autofocus
                    class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2 pr-24 text-gray-900
                           focus:border-red-500 focus:ring-2 focus:ring-red-200"
                    placeholder="••••••••" />
                <!-- Show/Hide (pure client-side) -->
                <button type="button"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-xs font-bold rounded-full px-2 py-1
                               bg-gray-100 text-gray-700 border border-gray-200 hover:bg-gray-200"
                    onclick="(function(i){ i.type = i.type==='password' ? 'text' : 'password'; })(document.getElementById('delete_password'))">
                    Rādīt
                </button>
            </div>
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                class="inline-flex items-center justify-center rounded-full border border-gray-300 text-gray-700
                       hover:bg-gray-50 px-5 py-2 text-sm font-semibold transition">
                Atcelt
            </button>
            <button type="submit"
                class="inline-flex items-center justify-center rounded-full bg-red-600 hover:bg-red-700 text-white
                       font-semibold px-5 py-2 shadow transition">
                Dzēst
            </button>
        </div>
    </form>
</x-modal>
