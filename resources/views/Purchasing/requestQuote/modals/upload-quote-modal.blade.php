<div id="UploadQuoteModal" tabindex="-1" aria-hidden="true" @if ($showUploadQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Cotizar Solicitud
                </h3>
                <button wire:click="CloseModalUploadQuote" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                @if ($RQLines)
                <div class="flex space-x-2">
                    @if ($selectedRQ && $selectedRQ->statusList->id <= 5)
                    <button wire:click='OpenModalAddQuoteFile' wire:loading.attr="disabled" type="submit" class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Añadir documento
                    </button>
                    @endif
                    @if ($selectedRQLine)
                    <button wire:click='OpenModalAddQuote' wire:loading.attr="disabled" type="submit" class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Subir Cotización
                    </button>
                    @endif
                </div>
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 250px;">
                    <div class="w-full overflow-x-auto">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Departamento<br>que usara</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Contenido</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Descripción</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Cantidad</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Cotizaciónes</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Fecha<br>Requiere</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Estatus</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($RQLines as $RQL)
                                <tr wire:click="selectLine({{ $RQL->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQLine && $selectedRQLine->id == $RQL->id) bg-green-200 dark:bg-gray-500 @endif">
                                    <td class="px-4 py-2 text-xs whitespace-pre-line">
                                        {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                    </td>
                                    <td class="px-4 py-2 text-xs whitespace-pre-line">{{ $RQL->name }}</td>
                                    <td class="px-4 py-2 text-xs whitespace-pre-line">{{ $RQL->description }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $RQL->quantity }}</td>
                                    <td class="px-4 py-2 text-xs">
                                        @if ($RQL->StatusList_id == 11)
                                        @php
                                        $quotes = App\Models\Quote::where('QuoteLine_id', $RQL->id)->get();
                                        @endphp
                                        @foreach ($quotes as $QU)
                                        <li>$ {{$QU->Cost}} {{$QU->currency->name}} - {{$QU->dateArrived}} - {{$QU->supplier->VNDNAM}}</li>
                                        @endforeach
                                        @else
                                        Vacio
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-xs">{{ $RQL->dateQuotation }}</td>
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
                <br>
                @if ($selectedRQ && $selectedRQLine)
                @php
                $quotes = App\Models\Quote::where('QuoteLine_id', $selectedRQLine->id)->get();
                @endphp
                <br>
                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400"><strong>Cotizaciónes:</strong></p>
                @if (!$selectedRQLine)
                <br>
                <div class="flex justify-center items-center">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">No se ah seleccionado ninguna linea</h4>
                    </div>
                </div>
                <br>
                @else
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900">
                    <div class="w-full overflow-x-auto">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Proveedor</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Precio</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Due Date</span></th>
                                    <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700"><span class="mr-1">Comentario</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($quotes as $quote)
                                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 text-xs">{{ $quote->supplier->VENDOR }} -{{ $quote->supplier->VNDNAM }}</td>
                                    <td class="px-4 py-2 text-xs">$ {{ $quote->Cost }} {{ $quote->currency->name }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $quote->NumDaysArrival }}</td>
                                    <td class="px-4 py-2 text-xs">{{ $quote->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
