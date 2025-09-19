<!-- Delete Account Section -->
<div>
    <p class="text-sm text-gray-600">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, download anything you wish to retain.') }}
    </p>

    <!-- Trigger -->
    <div class="mt-6 flex justify-end">
        <button
            type="button"
            x-data
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition"
        >
            {{ __('Delete Account') }}
        </button>
    </div>

    <!-- Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <p class="text-sm text-gray-600">
                {{ __('This action is irreversible. Please enter your password to confirm.') }}
            </p>

            <!-- Password -->
            <div>
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 focus:ring-2 focus:ring-red-500"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg shadow-sm transition"
                >
                    {{ __('Cancel') }}
                </button>
                <button
                    type="submit"
                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition"
                >
                    {{ __('Delete') }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
