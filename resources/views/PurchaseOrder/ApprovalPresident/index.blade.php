<style>
    .max-width-cell {
    max-width: 10px; /* Establece el ancho máximo deseado */
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
    .description-cell {
        max-width: 200px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
/*  .description-cell {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .description-cell:hover {
        overflow: visible;
        white-space: normal;
        word-wrap: break-word;
    } */


    .assigned {
    padding: 0.5rem 1rem;
    font-weight: 600;
    color: #047857; /* text-green-700 */
    background-color: #d1fae5; /* bg-green-100 */
    border-radius: 9999px; /* rounded-full */
    display: inline-block; /* to ensure correct padding and background application */
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
<x-app-layout title="QuoteAssignment">
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-4 mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Aprobación de Orden de Compra (Presidente)
        </h2>
        @livewire('purchase-order.approval-president-show')
        </div>
    </div>
</x-app-layout>
