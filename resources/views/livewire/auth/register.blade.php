<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit.prevent="register" class="flex flex-col gap-6">
        <!-- First Name -->
        <flux:input
            wire:model="first_name"
            :label="__('First Name')"
            type="text"
            required
            autofocus
            autocomplete="given-name"
            :placeholder="__('Enter your first name')"
        />

        <!-- Last Name -->
        <flux:input
            wire:model="last_name"
            :label="__('Last Name')"
            type="text"
            required
            autocomplete="family-name"
            :placeholder="__('Enter your last name')"
        />

        <!-- Gender -->
        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Gender') }}
            </label>
            <select wire:model="gender" id="gender" name="gender" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">{{ __('Select your gender') }}</option>
                <option value="male">{{ __('Male') }}</option>
                <option value="female">{{ __('Female') }}</option>
            </select>
            @error('gender') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Role Selection -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Register as') }}
            </label>
            <select wire:model="role" id="role" name="role" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">{{ __('Select a role') }}</option>
                <option value="buyer">{{ __('Buyer') }}</option>
                <option value="seller">{{ __('Seller') }}</option>
            </select>
            @error('role') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Matrix Number (Only for Sellers) -->
        <div id="matrix-number-wrapper" class="hidden">
            <flux:input
                wire:model="matrix_number"
                id="matrix_number"
                name="matrix_number"
                :label="__('Matrix Number')"
                type="text"
                :placeholder="__('Enter your matrix number')"
            />
            @error('matrix_number') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="text"
            required
            autocomplete="email"
            :placeholder="__('Enter your email')"
        />
        @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

        <!-- Username -->
        <flux:input
            wire:model="username"
            :label="__('Username')"
            type="text"
            required
            autocomplete="username"
            :placeholder="__('Enter your username')"
        />
        @error('username') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

        <!-- Phone Number -->
        <flux:input
            wire:model="phone_number"
            :label="__('Phone Number')"
            type="text"
            required
            autocomplete="tel"
            :placeholder="__('Enter your phone number')"
        />
        @error('phone_number') <span class="text-sm text-red-600">{{ $message }}</span> @enderror

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#role').on('change', function () {
            if ($(this).val() === 'seller') {
                $('#matrix-number-wrapper').removeClass('hidden');
            } else {
                $('#matrix-number-wrapper').addClass('hidden');
            }
        });
    });
</script>