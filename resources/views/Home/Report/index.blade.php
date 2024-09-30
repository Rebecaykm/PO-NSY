<style>
    .max-width-cell {
    max-width: 8px; /* Establece el ancho máximo deseado */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    /* Agrega reglas de estilo personalizadas aquí */
    .truncate-text {
        max-width: 100px; /* Ajusta la cantidad máxima de caracteres que deseas mostrar */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .name-cell {
        max-width: 150px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
    .description-cell {
        max-width: 200px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
    .assigned {
    padding: 0.5rem 1rem;
    font-weight: 600;
    color: #047857; /* text-green-700 */
    background-color: #d1fae5; /* bg-green-100 */
    border-radius: 9999px; /* rounded-full */
    display: inline-block; /* to ensure correct padding and background application */
    }

    .ni-assigned {
        padding: 0.5rem 1rem; /* py-2 px-4 */
        font-weight: 600; /* font-semibold */
        color: #4B5563; /* text-gray-700 */
        background-color: #F3F4F6; /* bg-gray-100 */
        border-radius: 9999px; /* rounded-full */
        display: inline-block; /* to ensure correct padding and background application */
    }

    .dark .ni-assigned {
        color: #F3F4F6; /* dark:text-gray-100 */
        background-color: #374151; /* dark:bg-gray-700 */
    }

    .not-assigned {
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: #b91c1c; /* text-red-700 */
        background-color: #fee2e2; /* bg-red-100 */
        border-radius: 9999px; /* rounded-full */
        display: inline-block; /* to ensure correct padding and background application */
    }
</style>
<x-app-layout title="{{ __('GESC - REPORTES') }}">
    <div class="grid px-10 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            {{ __('Reportes') }}
        </h2>
        @livewire('home.reports-generate')
    </div>
</x-app-layout>
