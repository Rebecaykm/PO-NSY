<div>
    {{-- The whole world belongs to you. --}}

    <div class="px-4 py-3 gap-x-2 my-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <label class="text-sm">
            <div class="relative text-gray-500">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="col-span-4  focus-within:text-blue-600">
                        <label for="search" class="block text-sm">Buscar</label>
                        <input wire:model="search" type="text" name="search" id="search" placeholder="Buscar..." autocomplete="off" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </div>
                    <div class="col-span-3 focus-within:text-blue-600">
                        <label for="start_date" class="block text-sm">Fecha Inicial</label>
                        <input wire:model="selectedStartDate" type="date" id="start_date" name="start_date"  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </div>
                    <div class="col-span-3 focus-within:text-blue-600">
                        <label for="end_date" class="block text-sm">Fecha Final</label>
                        <input wire:model="selectedEndDate" type="date" id="end_date" name="end_date"  class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"/>
                    </div>
                    <div class="col-span-2 focus-within:text-blue-600">
                        <label class="block text-sm">   &nbsp;</label>
                        <div class="flex justify-end">
                            <button wire:click="clearFilters" class="flex items-center px-6 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-md active:bg-gray-100 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                </svg>
                                Limpiar Filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </label>
    </div>
    <div class="flex justify-end pt-2 pb-4 gap-2">
        <form method="GET" action="{{route('Process.Report.pdf')}}" target="_blank">
            <input type="hidden" name="search" id="search" value="{{$search}}">
            <input type="hidden" name="start_date" id="start_date"  value="{{$startDate}}">
            <input type="hidden" name="end_date" id="end_date" value="{{$endDate}}">
            <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                    <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4"></path>
                    <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6"></path>
                    <path d="M17 18h2"></path>
                    <path d="M20 15h-3v6"></path>
                    <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z"></path>
                </svg>
            </button>
        </form>
        <form method="GET" action="{{route('Process.Report.excel')}}">
            <input type="hidden" name="search" id="search" value="{{$search}}">
            <input type="hidden" name="start_date" id="start_date"  value="{{$startDate}}">
            <input type="hidden" name="end_date" id="end_date" value="{{$endDate}}">
            <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-plus-filled" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                    <path d="M4 15l4 6" />
                    <path d="M4 21l4 -6" />
                    <path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" />
                    <path d="M11 15v6h3" />
                </svg>
            </a>
        </form>
    </div>


    <div class="w-full overflow-hidden rounded-lg  shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">Item</th>
                        <th class="px-4 py-2">Rack</th>
                        <th class="px-4 py-2">Cantidadad</th>
                        <th class="px-4 py-2">Antes</th>
                        <th class="px-4 py-2">Depues</th>
                        <th class="px-4 py-2">Movimiento</th>
                        <th class="px-4 py-2">#Soli.</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Hora</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach ($operations as $operation)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-2 text-xs">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <img class="object-cover w-full h-full rounded-full" src={{ $operation->itemDetail->item->Image}} alt="" loading="lazy" />
                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $operation->itemDetail->item->Code}}
                                    </p>
                                    <p class="font-semibold">{{ $operation->itemDetail->item->Model }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $operation->itemDetail->item->Brand}}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $operation->itemDetail->rack->Name }}
                        </td>

                        <td class="px-4 py-2 text-xs">
                            {{ $operation->Quantity }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $operation->QtyBefore }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $operation->QtyAfter }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $operation->typeOperation->Name }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ $operation->Request_id ? $operation->requested->Folio : '' }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ \Carbon\Carbon::parse($operation->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            {{ \Carbon\Carbon::parse($operation->created_at)->format('H:i:s') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span class="flex items-center col-span-3">
                Mostrando {{ $operations->firstItem() }} - {{ $operations->lastItem() }} de {{ $operations->total() }}
            </span>
            <span class="col-span-2"></span>
            <!-- Pagination -->
            <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                        {{ $operations->withQueryString()->links() }}
                    </ul>
                </nav>
            </span>
        </div>
    </div>
</div>
