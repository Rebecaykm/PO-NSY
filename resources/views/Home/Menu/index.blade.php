<x-app-layout title="{{ __('GESC - INICIO') }}">
    <div class="grid px-10 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Inicio') }}
        </h2>
        @livewire('home.menu-show')
    </div>
</x-app-layout>
