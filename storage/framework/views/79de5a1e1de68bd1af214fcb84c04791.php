
<div class="px-4 py-3 gap-x-2 my-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
    <label class="text-sm">
        <form >
            <div class="relative text-gray-500">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Campo de búsqueda por palabra clave -->
                    <div class="col-span-4 focus-within:text-blue-600">
                        <label for="searchRQ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por RFQ o Descripción:</label>
                        <input wire:model.defer="searchRQ" type="text" maxlength="50" name="searchRQ" id="searchRQ" placeholder="Buscar registro..." autocomplete="off" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </div>
                    
                    
                    
                    <!-- Botón para limpiar filtros -->
                    <div class="col-span-1 focus-within:text-blue-600">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">&nbsp;</label>
                        <button wire:click="render" wire:loading.attr="disabled" class="flex mt-1 py-2 px-7 text-sm font-medium text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-md active:bg-gray-100 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </label>
</div>
<?php /**PATH C:\xampp\htdocs\GESC\resources\views/partials/filter_rfq.blade.php ENDPATH**/ ?>