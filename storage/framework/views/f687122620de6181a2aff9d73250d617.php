<!-- Create Quote Modal -->
<div id="CreateRIModal" tabindex="-1" aria-hidden="true" <?php if(0): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl max-h-screen mx-auto overflow-y-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aprobar Solicitud de Inversión</h3>
                <button wire:click="$set('showModalViewRI',true)" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7L1 13M7 7l6-6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
            </div>
            <?php
                $selectedRI = App\Models\RequestInvestment::where('RFQ','00000024')->first();  
            ?>
            <!-- Modal body -->
            <?php if($selectedRI): ?>
            <form wire:submit.prevent class="p-4 md:p-5">
                <!-- Project Information -->
                <div class="grid gap-3 mb-3 lg:grid-cols-12">
                    <!-- Project Name -->
                    <div class="col-span-4">
                        <label for="ProjectName" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Nombre del Proyecto:</label>
                        <input type="text" id="ProjectName" wire:model="ProjectName" class="disabled-input" disabled>
                    </div>
                    <!-- Theme of Request -->
                    <div class="col-span-8">
                        <label for="ThemeOfRequest" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Tema de la Solicitud:</label>
                        <input type="text" id="ThemeOfRequest" wire:model="ThemeOfRequest" class="disabled-input" disabled>
                    </div>

                    <!-- Budget Section -->
                    <div class="col-span-12" x-data="budgetData()" x-init="calculateRateYen()">
                        <!-- Budget Select -->
                        <div class="col-span-12">
                            <label for="Budget" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Presupuestado:</label>
                            <select x-model="Budget" id="Budget" class="disabled-input" disabled>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>

                        <!-- No Budget Reason -->
                        <template x-if="Budget == 0">
                            <div class="col-span-12">
                                <label for="NoBudgetReason" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Motivo por no tener presupuesto:</label>
                                <input type="text" x-model="NoBudgetReason" id="NoBudgetReason" class="disabled-input" disabled>
                            </div>
                        </template>

                        <!-- Budget Amount and Currency -->
                        <template x-if="Budget == 1">
                            <div class="grid gap-3">
                                <div class="col-span-12">
                                    <label for="BudgetAmount" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Presupuesto:</label>
                                    <input type="number" x-model="BudgetAmount" id="BudgetAmount" class="disabled-input" disabled>
                                </div>
                                <div class="col-span-12">
                                    <label for="CurrencyType" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Tipo de Moneda:</label>
                                    <select x-model="CurrencyType" id="CurrencyType" class="disabled-input" disabled>
                                        <option value="">Seleccione un tipo de moneda</option>
                                        <template x-for="currency in currencies" :key="currency.id">
                                            <option :value="currency.id" x-text="`${currency.name} - ${currency.description}`"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="col-span-12">
                                    <label for="RateYen" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Conversión en Yen:</label>
                                    <input type="number" x-bind:value="RateYen" class="disabled-input" disabled>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Selected Quotes Table -->
                    <div class="col-span-12 bg-white rounded-lg shadow-lg overflow-x-auto dark:bg-gray-900">
                        <table id="quotes" class="table-auto w-full">
                            <!-- Cotizaciones seleccionadas -->
                        </table>
                    </div>

                    <!-- Selected Suppliers -->
                    <div class="col-span-12 bg-gray-50 dark:bg-gray-700 border rounded-lg p-4">
                        <strong>Empresa seleccionada:</strong>
                        
                        <!-- Exchange Rates -->
                        <strong>Cambio de moneda:</strong>
                        <div>$ <?php echo e(floatval(round($selectedRI->quoteRequest->TotalCostMXN, 4))); ?> MXN</div>
                        <div>$ <?php echo e(floatval(round($selectedRI->quoteRequest->TotalCostUSD, 4))); ?> USD</div>
                        <div>$ <?php echo e(floatval(round($selectedRI->quoteRequest->TotalCostJPY, 4))); ?> JPY</div>
                    </div>

                    <!-- Documents Section -->
                    

                    <!-- Affected Place and Machine -->
                    <div class="col-span-12">
                        <label for="AffectedPlace" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Lugar afectado:</label>
                        <input type="text" id="AffectedPlace" wire:model="AffectedPlace" class="disabled-input" disabled>
                    </div>
                    <div class="col-span-9">
                        <label for="AffectedMachine" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Máquina afectada:</label>
                        <input type="text" id="AffectedMachine" wire:model="AffectedMachine" class="disabled-input" disabled>
                    </div>
                    <div class="col-span-3">
                        <label for="YearsOfUse" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Años de uso:</label>
                        <input type="number" id="YearsOfUse" wire:model="YearsOfUse" class="disabled-input" disabled>
                    </div>

                    <!-- Dates Section -->
                    <div class="col-span-3">
                        <label for="StartOfWorkDate" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha de inicio de obra:</label>
                        <input type="date" id="StartOfWorkDate" wire:model="StartOfWorkDate" class="disabled-input" disabled>
                    </div>
                    <div class="col-span-3">
                        <label for="CompletionDate" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha finalización de obra:</label>
                        <input type="date" id="CompletionDate" wire:model="CompletionDate" class="disabled-input" disabled>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end p-3 md:p-4 border-t border-gray-200 dark:border-gray-600">
                    <button wire:click="$set('showModalViewRI', true)" type="button" class="btn-secondary mr-2">Cerrar</button>
                    <button type="submit" class="btn-primary">Guardar</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>



<style>
    .disabled-input {
        background-color: #f3f4f6;
        border-color: #e5e7eb;
        color: #6b7280;
    }

    .btn-primary {
        background-color: #2563eb;
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        transition: background-color 0.3s;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }
</style>
<?php /**PATH C:\xampp\htdocs\GESC\resources\views/partials/request_inverstment.blade.php ENDPATH**/ ?>