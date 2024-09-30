<div id="showQuoteModal" tabindex="-1" aria-hidden="true" @if ($showQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                @if ($selectedRQ)
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Seguimiento de RFQ: {{$selectedRQ->RFQ}}
                </h3>
                @endif
                <button wire:click="CloseModalQuoteModal" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                @if ($RQLines)
                    @if ($RQLines)
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>Descripción:</strong> {{ $selectedRQ->description }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>Usuario:</strong> {{ $selectedRQ->UserName }}
                        </p>
                        @if ($selectedRQ->Commodity_id)
                            <p class="text-gray-600 dark:text-gray-400">
                                <strong>Commodity:</strong> {{ $selectedRQ->commodity->PCCOM }}
                            </p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">
                                <strong>Commodity:</strong> No asignado.
                            </p>
                        @endif
                        @if ($selectedRQ->WorkNumber)
                            <p class="text-gray-600 dark:text-gray-400">
                                <strong>Número de Obra:</strong> {{ $selectedRQ->WorkNumber }}
                            </p>
                        @endif
                        @if ($selectedRQ && $selectedRQ->dateRequiredQuote)
                            <p class="text-gray-600 dark:text-gray-400">
                                <strong>Fecha se requier cotización:</strong> {{ Carbon\Carbon::parse($selectedRQ->dateRequiredQuote)->format('d-m-Y') }}
                            </p>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">
                                <strong>Fecha de cotización:</strong> No asignado.
                            </p>
                        @endif
                    @endif
                    <br>
                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 400px;">
                        <div class="w-full overflow-x-auto">
                            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                <thead>
                                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-4 py-2 dark:hover:bg-gray-700">
                                            <span class="mr-1">Departamento<br>que usara</span>
                                        </th>
                                        <th class="px-4 py-2 dark:hover:bg-gray-700">
                                            <span class="mr-1">Contenido</span>
                                        </th>
                                        <th class="px-4 py-2 dark:hover:bg-gray-700">
                                            <span class="mr-1">Descripción</span>
                                        </th>
                                        <th class="px-4 py-2 dark:hover:bg-gray-700">
                                            <span class="mr-1">Cantidad</span>
                                        </th>
                                        <th class="px-4 py-2 dark:hover:bg-gray-700">
                                            <span class="mr-1">Commodity</span>
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
                                    <tr wire:click="selectLine({{ $RQL->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQLine && $selectedRQLine->id == $RQL->id) bg-green-200 dark:bg-gray-500 @endif">
                                        <td class="px-4 py-2 text-xs whitespace-pre-line">
                                            {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                        </td>
                                        @if ($RQL->imgPATH)
                                        <td class="px-4 py-3">
                                            <div class="flex items-center text-sm">
                                                <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="{{ Storage::url('items/'.$RQL->imgPATH) }}" alt="Not Img" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">{{ $RQL->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        @else
                                        <td class="px-4 py-2 text-xs description-cell">{{ $RQL->name }}</td>
                                        @endif
                                        <td class="px-4 py-2 text-xs description-cell">{{ $RQL->description }}</td>
                                        <td class="px-4 py-2 text-xs">{{ $RQL->quantity }}</td>
                                        <td class="px-4 py-2 text-xs">
                                            @if ($RQL->Commodity_id)
                                            <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">{{ $RQL->commodity->PCCOM }}</span>
                                            @else
                                            <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">No Asignado</span>
                                            @endif
                                        </td>
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
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Proveedor</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Precio</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Due Date</span></th>
                                    <th class="px-4 py-2 dark:hover:bg-gray-700"><span class="mr-1">Comentario</span></th>
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
                @if ($selectedRQ && $selectedRQ->StatusList_id < 4)
                <button wire:click='OpenModalConfirmRejectQuote' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Rechazar
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
