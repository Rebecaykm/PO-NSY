<div id="showChoseSupplierModal" tabindex="-1" aria-hidden="true" @if ($showChoseSupplierModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    ENVIAR COTIZACIÓN A PROVEEDORES
                </h3>
                <button wire:click="CloseModalChoseSupplier" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                @if ($RQLines)
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 400px;">
                    <div class="w-full overflow-x-auto">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-2 dark:hover:bg-gray-700">
                                        <span class="mr-1">Check</span>
                                    </th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700">
                                        <span class="mr-1">Departamento<br>que usara</span>
                                    </th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="mr-1">Contenido</span>
                                    </th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <span class="mr-1">Descripción</span>
                                    </th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700">
                                        <span class="mr-1">Cantidad</span>
                                    </th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700">
                                        <span class="mr-1">Fecha<br>Requiere</span>
                                    </th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700">
                                        <span class="mr-1">Estatus</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($RQLines as $RQL)
                                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 text-xs">
                                        <input type="checkbox" wire:click="toggleSelectedLine({{ $RQL->id }})">
                                    </td>
                                    <td class="px-4 py-2 text-xs">
                                        {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                    </td>
                                    <td class="px-4 py-2 text-xs whitespace-pre-line">{{ $RQL->name }}</td>
                                    <td class="px-4 py-2 text-xs whitespace-pre-line">{{ $RQL->description }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $RQL->quantity }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $RQL->dateRequired }}</td>
                                    <td class="px-4 py-2 text-xs">
                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{ $RQL->statusList->name }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <form wire:submit.prevent="">
                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400"><strong>Seleccione un Proveedor para envío:</strong></p>
                    <div>
                        @php
                        $query_supplier = App\Models\Supplier::where('VMID', 'VM')
                            ->whereNotNull('VNDNAM')
                            ->where('VNDNAM', '!=', '')
                            ->whereNotNull('VMDATN')
                            ->where('VMDATN', '!=', '')
                            ->orderBy('VNDNAM', 'ASC');

                        if ($this->selectModalSupplier) {
                            $query_supplier->where(function($query) {
                                $query->where('VENDOR', 'like', '%' . $this->selectModalSupplier . '%')
                                    ->orWhere('VNDNAM', 'like', '%' . $this->selectModalSupplier . '%');
                            });
                        }

                        $suppliers = $query_supplier->get();
                        @endphp
                        <div class="w-full overflow-x-auto">
                            <div class="px-4 py-3 gap-x-2 my-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
                                <label class="text-sm">
                                    <div class="relative text-gray-500">
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                            <div class="col-span-10 focus-within:text-blue-600">
                                                <label for="selectModalSupplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por Nombre o Código</label>
                                                <input wire:model="selectModalSupplier" type="text" maxlength="50" name="selectModalSupplier" id="selectModalSupplier" placeholder="Buscar registro..." autocomplete="on" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 200px;">
                                <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                    <thead>
                                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">VENDOR</span></th>
                                            <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Nombre</span></th>
                                            <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Correo</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($suppliers as $supplier)
                                        <tr wire:click="selectSupplier({{ $supplier->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedSupplier && $selectedSupplier->id == $supplier->id) bg-green-200 dark:bg-gray-500 @endif">
                                            <td class="px-4 py-2 text-xs">{{ $supplier->VENDOR }}</td>
                                            <td class="px-4 py-2 text-xs">{{ $supplier->VNDNAM }}</td>
                                            <td class="px-4 py-2 text-xs">{{ $supplier->VMDATN }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <button wire:click='OpenModalConfirmSendSupplier' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Enviar líneas a proveedor
                    </button>
                </form>
                <br>
                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400"><strong>Registro de correos enviados:</strong></p>
                @if ($emails)
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 200px;">
                    <div class="w-full overflow-x-auto">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">VENDOR</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Proveedor</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Estatus</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Fecha Máxima<br>para cotizar</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Contenido</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Cantidad</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($emails as $email)
                                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 text-xs">{{ $email->supplier->VENDOR }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $email->supplier->VNDNAM }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $email->recived }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $email->RequireDate }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $email->quoteLine->name }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $email->quoteLine->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <br>
                <div class="flex justify-center items-center">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">No se han enviado correos a proveedores</h4>
                    </div>
                </div>
                <br>
                @endif
            </div>
        </div>
    </div>
</div>
