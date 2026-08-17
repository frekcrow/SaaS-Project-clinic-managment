<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Activate Your Subscription') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Enter your activation code to continue using the application.') }}
        </p>
    </div>

    <!-- Session Status -->
    @if (session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('activation.submit') }}">
        @csrf

        <!-- Activation Code -->
        <div>
            <x-input-label for="activation_code" :value="__('Activation Code')" />
            <x-text-input id="activation_code" class="block mt-1 w-full" type="text" name="activation_code" :value="old('activation_code')" required autofocus placeholder="ATLAS-xxxxxxxx..." />
            <x-input-error :messages="$errors->get('activation_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3 w-full justify-center">
                {{ __('Activate') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
