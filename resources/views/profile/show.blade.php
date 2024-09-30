<x-app-layout title="Profile">
    <div class="container grid px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Profile
        </h2>

        <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
            {{ __('Información de la Cuenta') }}
        </h4>

        @livewire('profile.update-profile-information-form')

        <x-section-border />



        <div class="mt-10 sm:mt-0">
            <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
                {{ __('Browser Sessions') }}
            </h4>

            @livewire('profile.logout-other-browser-sessions-form')
        </div>

    </div>
</x-app-layout>
