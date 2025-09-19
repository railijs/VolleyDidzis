<!-- Update Password Form -->
<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <!-- Current Password -->
    <div>
        <x-input-label for="current_password" :value="__('Current Password')" />
        <x-text-input
            id="current_password"
            name="current_password"
            type="password"
            class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500"
            autocomplete="current-password"
        />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
    </div>

    <!-- New Password -->
    <div>
        <x-input-label for="password" :value="__('New Password')" />
        <x-text-input
            id="password"
            name="password"
            type="password"
            class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500"
            autocomplete="new-password"
        />
        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <x-text-input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            class="mt-2 block w-full rounded-lg border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500"
            autocomplete="new-password"
        />
        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
    </div>

    <!-- Actions -->
    <div class="flex justify-end">
        <x-primary-button>{{ __('Update Password') }}</x-primary-button>
    </div>
</form>
