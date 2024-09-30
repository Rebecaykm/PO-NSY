<div>
    {{-- Botones de Crud, y lista de cantidad de paginación --}}
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
                        
                        <!-- Campo para seleccionar estatus -->
                        <div class="col-span-2 focus-within:text-blue-600">
                            <label for="selectedRQStatus" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estatus</label>
                            <select wire:model.defer="selectedRQStatus" name="selectedRQStatus" id="selectedRQStatus" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <option value="0">Todos</option>
                                @foreach ($status as $state)
                                    <option value="{{ $state->id }}" {{ $state->id == $selectedRQStatus ? 'selected' : '' }}>{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Campo para seleccionar la fecha de inicio -->
                        <div class="col-span-2 focus-within:text-blue-600">
                            <label for="startDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Inicio</label>
                            <input wire:model.defer="startDate" type="date" name="startDate" id="startDate" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </div>
                        
                        <!-- Campo para seleccionar la fecha de final -->
                        <div class="col-span-2 focus-within:text-blue-600">
                            <label for="endDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Final</label>
                            <input wire:model.defer="endDate" type="date" name="endDate" id="endDate" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
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
    
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <span class="flex items-center col-span-1 text-gray-700 dark:text-gray-300">Mostrando:</span>
        <select wire:click="resetPage" wire:model="perPage" name="Status" id="Status" class="block py-1 px-2 rounded my-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray">
            <option value="" disabled>Seleccione la paginación</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="200">200</option>
        </select>
    </div>

    {{-- Notificaciones de confirmación de Movimientos --}}
    <div class="py-2">
        @if(session('success'))
            <div  id="alertMessage" role="alert" class="rounded-xl border border-gray-100 bg-white p-4">
                <div class="flex items-start gap-4">
                    <span class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <div class="flex-1">
                        <strong class="block font-medium text-gray-900">¡¡Exito!!</strong>
                        <p class="mt-1 text-sm text-gray-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>              
            <script>
                setTimeout(function(){
                    var alertMessage = document.getElementById('alertMessage');
                    alertMessage.style.transition = 'opacity 3s';
                    alertMessage.style.opacity = '2';
                    setTimeout(function(){
                        alertMessage.remove();
                    }, 3000);
                }, 2000);
            </script>
        @elseif(session('error'))
            <div id="alertMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            <script>
                setTimeout(function(){
                    var alertMessage = document.getElementById('alertMessage');
                    alertMessage.style.transition = 'opacity 3s';
                    alertMessage.style.opacity = '2';
                    setTimeout(function(){
                        alertMessage.remove();
                    }, 3000);
                }, 2000);
            </script>
        @endif
    </div>

    {{-- Tabla, se muestra la lista de registros --}}
    @if ($requestQuotes->count())
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            @if ($selectedRQOrderBy == 'RFQ' && $selectedRQOrder == 'ASC')
                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                    <span class="mr-1">RFQ</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                </th>
                            @elseif ($selectedRQOrderBy == 'RFQ' && $selectedRQOrder === 'DESC')
                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                    <span class="mr-1">RFQ</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                                </th>
                            @else
                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                    <span class="mr-1">RFQ</span>
                                </th>
                            @endif
                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                <span class="mr-1">Propietario</span>
                            </th>
                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                <span class="mr-1">Estatus</span>
                            </th>
                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                <span class="mr-1">Descripción</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Aprobación<br>Requisición</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Commodity</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Aprobación<br>Sol. Inver.</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Frecha <br>Creado</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Fecha ultima <br>Actualización</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Acción</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 uppercase dark:bg-gray-800">
                            @foreach ($requestQuotes as $RQ)
                            {{-- <tr wire:click="selectRQ({{ $RQ->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQ && $selectedRQ->id == $RQ->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 text-xs whitespace-pre-line">
                                    {{ $RQ->RFQ }}
                                </td>
                                <td class="px-4 py-2 text-xs whitespace-pre-line">
                                    {{ $RQ->UserName }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    @if ($RQ->StatusList_id == 39)
                                    <span class="not-assigned  description-cell">
                                        {{ $RQ->statusList->name }}
                                    </span>
                                    @else
                                    <span class="assigned  description-cell">
                                        {{ $RQ->statusList->name }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs description-cell">
                                    {{ $RQ->description }}
                                </td>
                                <td class="px-4 py-2 text-xs ">
                                    @if( $RQ->ApprovateUser && $RQ->ApprovateLines && $RQ->ManagerApprovate )
                                        <span class="assigned description-cell">
                                            FINALIZADA
                                        </span>
                                    @elseif( $RQ->ApprovateUser && $RQ->ApprovateLines )
                                        <span class=" not-assigned description-cell">
                                            PENDIENTE APROBACIÓN GERENTE DEP. SOLICITA
                                        </span>
                                    @elseif($RQ->ApprovateUser)
                                        <span class="not-assigned description-cell">
                                            PENDIENTE DE APROBACIÓN DE LÍNEAS
                                        </span>   
                                    @else
                                        <span class="ni-assigned description-cell">
                                            NO APLICA
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs  ">
                                    @if( $RQ->Commodity_id )
                                        <span class="assigned description-cell">
                                            {{ $RQ->commodity->PCCOM }}
                                        </span>
                                    @else
                                        <span class="ni-assigned description-cell">
                                            No Asignado
                                        </span>
                                    @endif
                                </td>
                                @php
                                    $RI = App\Models\RequestInvestment::where('RequestQuote_id',$RQ->id)->first();
                                @endphp
                                <td class="px-4 py-2 text-xs">
                                    @if( $RI && $RI->StatusList_id == 35 )
                                        <span class="assigned description-cell">
                                            APROBADA
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 31 )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN FINANZAS
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 30 )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN PRESIDENTE
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 29 )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN VICEPRESIDENTE
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 22 )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN GERENTE COMPRAS
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 21 )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN GERENTE DEP. SOLICITA
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 47 )
                                        <span class="not-assigned description-cell">
                                            RECHAZA PRESIDENTE
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 46 )
                                        <span class="not-assigned description-cell">
                                            RECHAZA VICEPRESIDENTE
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 45 )
                                        <span class="not-assigned description-cell">
                                            RECHAZA GERENTE DE COMPRAS
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 44 )
                                        <span class="not-assigned description-cell">
                                            RECHAZA PLANEACIÓN CORPORATIVA
                                        </span>
                                    @elseif( $RI && $RI->StatusList_id == 43 )
                                        <span class="not-assigned description-cell">
                                            RECHAZA GERENTE DEL DEP. SOLICITANTE
                                        </span>
                                    @else
                                        <span class="ni-assigned description-cell">
                                            NO APLICA
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ Carbon\Carbon::parse($RQ->created_at)->format('d-m-Y') }}
                                    <br>
                                    {{ Carbon\Carbon::parse($RQ->created_at)->format('H:m:s') }}
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    {{ Carbon\Carbon::parse($RQ->updated_at)->format('d-m-Y') }}
                                    <br>
                                    {{ Carbon\Carbon::parse($RQ->updated_at)->format('H:m:s') }}
                                </td>
                                <td class="px-4 py-2 text-xs text-center space-y-2">
                                    <!-- Botón Ver -->
                                    <button wire:click="OpenModalQuoteModal({{ $RQ->id }})" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-1 px-2 rounded-lg shadow-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        <span wire:loading.remove wire:target="OpenModalQuoteModal({{ $RQ->id }})">Ver</span>
                                        <span wire:loading wire:target="OpenModalQuoteModal({{ $RQ->id }})">Cargando...</span>
                                    </button>
                                
                                    <!-- Botón Enviar a proveedores -->
                                    <button wire:click="OpenModalChoseSupplier({{ $RQ->id }})" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white font-bold py-1 px-2 rounded-lg shadow-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        <span wire:loading.remove wire:target="OpenModalChoseSupplier({{ $RQ->id }})">Enviar a<br>proveedores</span>
                                        <span wire:loading wire:target="OpenModalChoseSupplier({{ $RQ->id }})">Cargando...</span>
                                    </button>
                                
                                    <!-- Botón Subir Cotización -->
                                    <button wire:click="OpenModalUploadQuote({{ $RQ->id }})" wire:loading.attr="disabled" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-700 hover:from-yellow-600 hover:to-yellow-800 text-white font-bold py-1 px-2 rounded-lg shadow-lg flex items-center justify-center transition duration-300 ease-in-out transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 20h-8a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5" /><path d="M11 16h-5a2 2 0 0 0 -2 2" /><path d="M15 16l3 -3l3 3" /><path d="M18 13v9" />
                                        </svg>
                                        <span wire:loading.remove wire:target="OpenModalUploadQuote({{ $RQ->id }})">Subir Cotización</span>
                                        <span wire:loading wire:target="OpenModalUploadQuote({{ $RQ->id }})">Cargando...</span>
                                    </button>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                    <span class="flex items-center col-span-3">
                        {{ __('Mostrando') }} {{ $requestQuotes->firstItem() }} - {{ $requestQuotes->lastItem() }} {{ __('de') }} {{ $requestQuotes->total() }}
                    </span>
                    <span class="col-span-2"></span>
                    <!-- Pagination -->
                    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                        <nav aria-label="Table navigation">
                            {{ $requestQuotes->withQueryString()->links() }}
                        </nav>
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="px-4 py-3 rounded-md text-sm text-center font-semibold text-gray-700 uppercase bg-white sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
            <span>{{ __('messages.noSeHanEncontradoDatos') }}</span>
        </div>
    @endif

    <!-- View and Reject Quote Modal -->
    <div id="showQuoteModal" tabindex="-1" aria-hidden="true" @if ($showQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    @if ($selectedRQ )
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Seguimiento de RFQ: {{$selectedRQ->RFQ}}
                        </h3>
                    @endif
                    <button wire:click="$set('showQuoteModal', true)" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                @if ($selectedRQ )
                <div class="p-4 md:p-5">
                    {{-- Tabla, se muestra la lista de registros --}}
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
                                    <strong>Fecha se requiere cotización:</strong> {{ Carbon\Carbon::parse($selectedRQ->dateRequiredQuote)->format('d-m-Y') }}
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
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Departamento <br> que usara</span>
                                            </th>
                                            <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Contenido</span>
                                            </th>
                                            <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Descripción</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Cantidad</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Commodity</span>
                                            </th>
                                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Fecha <br>Requiere</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Estatus</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($RQLines as $RQL)
                                            {{-- <tr wire:click="selectLine({{ $RQL->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQLine && $selectedRQLine->id == $RQL->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="px-4 py-2 text-xs whitespace-pre-line">
                                                    {{ $RQL->costCenter->name }}  - {{ $RQL->costCenter->description }}
                                                </td>
                                                @if ($RQL->imgPath)
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        <div class="flex items-center text-sm">
                                                            <!-- Avatar with inset shadow -->
                                                            <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                                <img class="object-cover w-full h-full rounded-full"
                                                                    src="{{ Storage::url('items/' . $RQL->imgPath) }}"
                                                                    alt="{{ $RQL->name }}"
                                                                    />
                                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold">{{ $RQL->name }}</p>
                                                                <!-- Enlace de descarga -->
                                                                @if ($RQL->imgPath)    
                                                                <a href="{{ route('Configuration.Items.download', ['filename' => $RQL->imgPath]) }}"
                                                                    class="text-blue-600 hover:underline"
                                                                    download>
                                                                    Descargar
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>   
                                                @else
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $RQL->name }}
                                                    </td>
                                                @endif
                                                <td class="px-4 py-2 text-xs description-cell">
                                                    {{ $RQL->description }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $RQL->quantity }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    @if( $RQL->Commodity_id )
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            {{ $RQL->commodity->PCCOM }}
                                                        </span>
                                                    @else
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            No Asignado
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $RQL->dateRequired }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                        {{ $RQL->statusList->name }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <br>
                    @if ($selectedRQ)
                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                            <strong>Cotizaciónes :</strong>
                        </p>
                        @if (!$quotes )
                            <br>
                            <div class="flex justify-center items-center">
                                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        No hay cotizaciones
                                    </h4>
                                </div>
                            </div>
                            <br>
                        @else
                            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900">
                                <div class="w-full overflow-x-auto">
                                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                        <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Proveedor</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Precio</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Due Date</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Comentario</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                            @foreach ($quotes as $quote)
                                                {{-- <tr wire:click="selectQuote({{ $quote->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedQuote && $selectedQuote->id == $quote->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                                                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $quote->supplier->VENDOR }} -{{ $quote->supplier->VNDNAM }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        $ {{ round($quote->Cost,4) }} {{ $quote->currency->name }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $quote->NumDaysArrival }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $quote->description }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endif
                    @if ($selectedRQ)
                        <button wire:click="$set('showConfirmRejectQuoteModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Rechazar
                        </button>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Quote Modal -->
    <div id="confirmRejectModal" tabindex="-1" aria-hidden="true" @if ($showConfirmRejectQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmRejectQuoteModal', true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro de rechazar esta cotización?</h3>
                    <div class="col-span-1">
                        <label for="RQRemark" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Escribe una breve explicación de el rechazo:</label>
                        <textarea wire:model.defer="RQRemark" name="remark" id="remark" minlength="10" maxlength="300" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required> </textarea>
                    </div>
                    <button wire:click="RejectRequestQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="$set('showConfirmRejectQuoteModal', true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="showChoseSupplierModal" tabindex="-1" aria-hidden="true" @if ($showChoseSupplierModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    @if ($selectedRQ )
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        ENVIAR LÍNEAS DE COTIZACIÓN {{$selectedRQ->RFQ}} A PROVEEDRORES
                    </h3>
                    @endif
                    <button wire:click="$set('showChoseSupplierModal', true)" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    {{-- Tabla, se muestra la lista de registros --}}
                    @if ($RQLines)
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900">
                            <div class="w-full overflow-x-auto">
                                <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                    <thead>
                                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Check</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Dep. que <br>usara</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Contenido</span>
                                            </th>
                                            <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Descripción</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Cantidad</span>
                                            </th>
                                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Frecha <br>Requiere</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Estatus</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($RQLines as $RQL)
                                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="px-4 py-2 text-xs">
                                                    <input type="checkbox" wire:click="toggleSelectedLine({{ $RQL->id }}, $event.target.checked)">
                                                </td>
                                                <td class="px-4 py-2 text-xs description-cell">
                                                    {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                                </td>
                                                @if ($RQL->imgPath)
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        <div class="flex items-center text-sm">
                                                            <!-- Avatar with inset shadow -->
                                                            <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                                <img class="object-cover w-full h-full rounded-full"
                                                                    src="{{ Storage::url('items/' . $RQL->imgPath) }}"
                                                                    alt="{{ $RQL->name }}"
                                                                    />
                                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold">{{ $RQL->name }}</p>
                                                                <!-- Enlace de descarga -->
                                                                @if ($RQL->imgPath)    
                                                                <a href="{{ route('Configuration.Items.download', ['filename' => $RQL->imgPath]) }}"
                                                                    class="text-blue-600 hover:underline"
                                                                    download>
                                                                    Descargar
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>   
                                                @else
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $RQL->name }}
                                                    </td>
                                                    
                                                @endif
                                                <td class="px-4 py-2 text-xs description-cell">
                                                    {{ $RQL->description }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $RQL->quantity }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $RQL->dateRequired }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                        {{ $RQL->statusList->name }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <form wire:submit.prevent="">
                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                            <strong>Seleccione un Proveedor para envio:</strong>
                        </p>
                        <div>
                            @php
                                $query_supplier = App\Models\Supplier::select('id', 'VENDOR', 'VNDNAM')
                                // ->where("VENDOR"," NOT LIKE", '11%')
                                // ->whereRaw("CAST(VENDOR as CHAR) NOT LIKE '11%'")
                                ->where('VMID', 'VM')
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
                                                <div class="col-span-10  focus-within:text-blue-600">
                                                    <label for="selectModalSupplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por Nombre o Código</label>
                                                    <input wire:model.lazy="selectModalSupplier" type="text" maxlength="50" name="selectModalSupplier" id="selectModalSupplier" placeholder="Buscar registro..." autocomplete="on" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                    <select wire:model.defer="selectedSupplier" name="selectedSupplier" id="selectedSupplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                        <option value="">Seleccione un Proveedor</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{ $supplier->id }}">{{ $supplier->VENDOR }} - {{ $supplier->VNDNAM }} : {{ $supplier->VMDATN }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-span-2  focus-within:text-blue-600">
                                                    <p>&nbsp;</p>
                                                    <button wire:click='OpenModalConfirmSendSupplier' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                        <span wire:loading.remove wire:target="OpenModalConfirmSendSupplier">Enviar líneas a proveedor</span>
                                                        <span wire:loading wire:target="OpenModalConfirmSendSupplier">Cargando...</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br>
                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                        <strong>Registro de correos enviados:</strong>
                    </p>
                    @if ($emails )
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 200px;">
                            <div class="w-full overflow-x-auto">
                                <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                    <thead>
                                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">VENDOR</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Proveedor</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Estatus</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Fecha Maxima <br>para cotizar</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Contenido</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Cantidad</span>
                                            </th>
                                        </atr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($emails as $email)
                                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $email->supplier->VENDOR }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $email->supplier->VNDNAM }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{$email->recived}}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $email->RequireDate }}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{$email->quoteLine->name}}
                                                </td>
                                                <td class="px-4 py-2 text-xs">
                                                    {{$email->quoteLine->quantity}}
                                                </td>
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
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        No se han enviado correos a proveedores
                                    </h4>
                                </div>
                            </div>
                        <br>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Send To Supplier Modal -->
    <div id="ConfirmSendSupplierModal" tabindex="-1" aria-hidden="true" @if ($showConfirmSendSupplierModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmSendSupplierModal', true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro de enviar estor registros a proveedor?</h3>
                    <button wire:click="SendToSupplier" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        <span wire:loading.remove wire:target="SendToSupplier">Si, seguro.</span>
                        <span wire:loading wire:target="SendToSupplier">Cargando...</span>
                    </button>
                    <button wire:click="$set('showConfirmSendSupplierModal', true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Add QuoteFile And Quote  -->
    <div id="UploadQuoteModal" tabindex="-1" aria-hidden="true" @if ($showUploadQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    @if ($selectedRQ )
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Cotizar Solicitud {{ $selectedRQ->RFQ }}
                        </h3>
                    @endif
                    <button wire:click="CloseModalUploadQuote" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    @if ($RQLines)
                        <div class="flex space-x-2">
                            @if ($selectedRQ)
                                <div class="flex space-x-2">
                                    <!-- Botón Añadir Documento -->
                                    <button wire:click="$set('showAddQuoteFileModal',false)" wire:loading.attr="disabled" type="submit" class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M12 11v6" />
                                            <path d="M9.5 13.5l2.5 -2.5l2.5 2.5" />
                                        </svg>
                                        <span wire:loading.remove wire:target="$set('showAddQuoteFileModal',false)">Añadir Documento</span>
                                        <span wire:loading wire:target="$set('showAddQuoteFileModal',false)">Cargando...</span>
                                    </button>
                                    <!-- Botón Añadir Imortar Líneas -->
                                    <form wire:submit.prevent="importExcel">
                                        <input type="file" wire:model="excelFile">
                                        @error('excelFile') <span class="error">{{ $message }}</span> @enderror
                                        <button wire:loading.attr="disabled" type="submit" class="flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <span wire:loading.remove wire:target="importExcel">Importar Cotizaciones</span>
                                            <span wire:loading wire:target="importExcel">Cargando...</span>
                                        </button>
                                    </form>
                                    <!-- Botón Añadir Línea -->
                                    <button wire:click="OpenModalUpdateLineQuote('create',null)" wire:loading.attr="disabled" type="submit" class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span wire:loading.remove wire:target="OpenModalUpdateLineQuote('create',null)">Añadir Línea</span>
                                        <span wire:loading wire:target="OpenModalUpdateLineQuote('create',null)">Cargando...</span>
                                    </button>

                                    @if ($generatePartiality)
                                        <!-- Botón Generar Cotización Parcial -->
                                        <button wire:click="$set('showConfirmGeneratePartialQuote',false)" wire:loading.attr="disabled" type="submit" class="flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-300 ease-in-out transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Generar Cotización Parcial
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                    <br>
                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                        <strong>Líneas:</strong>
                    </p>
                    @if ($selectedRQ)
                        {{-- Tabla, se muestra la lista de registros --}}
                        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" ">
                            <div class="w-full overflow-x-auto">
                                <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                    <thead>
                                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">ID</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Dep.<br>usara</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Contenido</span>
                                            </th>
                                            <th wire:click="selectOrderFlag('description')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Descripción</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Qty.</span>
                                            </th>
                                            @if ($selectedRQ->StatusList_id >= 8 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37 )
                                                <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Proveedor</span>
                                                </th>
                                                <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Costo<br>Unit.</span>
                                                </th>
                                                <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Costo<br>Total</span>
                                                </th>
                                                <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Estatus</span>
                                                </th>
                                                <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Fecha<br>Entrega</span>
                                                </th>
                                            @endif
                                            @if ($selectedRQ->StatusList_id < 8 || $selectedRQ->StatusList_id == 38 || $selectedRQ->StatusList_id == 37  )
                                                <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Estatus</span>
                                                </th>
                                                <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Fecha <br>Requerida</span>
                                                </th>
                                            @endif
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Acción</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($RQLines as $RQL)
                                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <td class="px-4 py-2 text-xs">
                                                    {{ $RQL->id }}
                                                </td>
                                                <td class="px-4 py-2 text-xs description-cell">
                                                    {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                                </td>
                                                @if ($RQL->imgPath)
                                                    <td class="px-4 py-3 description-cell">
                                                        <div class="flex items-center text-sm">
                                                            <!-- Avatar with inset shadow -->
                                                            <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                                <img class="object-cover w-full h-full rounded-full"
                                                                    src="{{ Storage::url('items/' . $RQL->imgPath) }}"
                                                                    alt="{{ $RQL->name }}"
                                                                    />
                                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold">{{ $RQL->name }}</p>
                                                                <!-- Enlace de descarga -->
                                                                @if ($RQL->imgPath)    
                                                                    <a href="{{ route('Configuration.Items.download', ['filename' => $RQL->imgPath]) }}"
                                                                        class="text-blue-600 hover:underline"
                                                                        download>
                                                                        Descargar
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>   
                                                @else
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $RQL->name }}
                                                    </td>
                                                @endif
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $RQL->description }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $RQL->quantity }}
                                                    </td>
                                                @if ($selectedRQ->StatusList_id < 8 || $selectedRQ->StatusList_id == 38 || $selectedRQ->StatusList_id == 37 )
                                                    <td class="px-4 py-2 text-xs">
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            {{ $RQL->statusList->name}}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ Carbon\Carbon::parse($RQL->dateRequired)->format('d-m-Y') }}
                                                    </td>
                                                @endif
                                                @if ($selectedRQ->StatusList_id >= 8 && $selectedRQ->StatusList_id != 39 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37 )
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $RQL->supplier->VNDNAM}}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        $ {{ round($RQL->UnitCost,4) }} {{ $RQL->currency->name }}
                                                    </td>
                                                    @if ($RQL->Currency_id == 1)
                                                        <td class="px-4 py-2 text-xs">
                                                            $ {{ round($RQL->TotalCostMXN,4) }} {{ $RQL->currency->name }}
                                                        </td>
                                                    @elseif ($RQL->Currency_id == 2)
                                                        <td class="px-4 py-2 text-xs">
                                                            $ {{ round($RQL->TotalCostUSD,4) }} {{ $RQL->currency->name }}
                                                        </td>
                                                    @elseif ($RQL->Currency_id == 3)
                                                        <td class="px-4 py-2 text-xs">
                                                            $ {{ round($RQL->TotalCostJPY,4) }} {{ $RQL->currency->name }}
                                                        </td>
                                                    @endif
                                                    <td class="px-4 py-2 text-xs">
                                                        <span class="assigned description-cell">
                                                            {{ $RQL->statusList->name}}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ Carbon\Carbon::parse($RQL->dateArrival)->format('d-m-Y') }}
                                                    </td>
                                                @endif
                                                <td class="px-4 py-2 text-xs">
                                                    <div class="flex space-x-2 justify-center">
                                                        <!-- Botón Cotizar -->
                                                        <button wire:click="OpenModalAddQuote({{$RQL->id}})" wire:loading.attr="disabled" type="submit" class="text-blue-500 hover:text-blue-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" d="M14 20h-8a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5" d="M11 16h-5a2 2 0 0 0 -2 2" d="M15 16l3 -3l3 3" d="M18 13v9" />
                                                            </svg>
                                                            <span wire:loading wire:target="$set('showAddQuoteModal', false)">Cargando...</span>
                                                        </button>
                                                
                                                        <!-- Botón Editar -->
                                                        <button wire:click="OpenModalUpdateLineQuote('edit', '{{$RQL->id}}')" wire:loading.attr="disabled" type="submit" class="text-blue-500 hover:text-blue-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                <path d="M13.5 6.5l4 4" />
                                                            </svg>
                                                            <span wire:loading wire:target="OpenModalUpdateLineQuote('edit', {{$RQ->id}})">Cargando...</span>
                                                        </button>
                                                
                                                        <!-- Botón Eliminar -->
                                                        <button wire:click="OpenModalDeleteLineQuote({{$RQL->id}})" wire:loading.attr="disabled" type="submit" class="text-red-500 hover:text-red-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                            <span wire:loading wire:target="OpenModalDeleteLineQuote({{$RQL->id}})">Cargando...</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <br>
                    @if ($selectedRQ )
                        <br>
                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                            <strong>Cotizaciónes:</strong>
                        </p>
                        @if ($quotes->count())
                            <br>
                            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900">
                                <div class="w-full overflow-x-auto">
                                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                        <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                    <span class="mr-1">ID Línea</span>
                                                </th>
                                                <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                    <span class="mr-1">VENDOR</span>
                                                </th>
                                                <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                    <span class="mr-1">Proveedor</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Precio</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Días de<br>entrega</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                    <span class="mr-1">Comentarios</span>
                                                </th>
                                                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                    <span class="mr-1">Acción</span>
                                                </th>
                                            </atr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                            @foreach ($quotes as $quote)
                                            {{-- <tr wire:click="selectQuote({{ $quote->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedQuote && $selectedQuote->id == $quote->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                                                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $quote->quoteLine->id }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $quote->supplier->VENDOR }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $quote->supplier->VNDNAM }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        $ {{ round($quote->Cost,4) }} {{ $quote->currency->name }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $quote->NumDaysArrival }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $quote->description }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        <div class="flex space-x-2 justify-center">                                                    
                                                            <!-- Botón Editar -->
                                                            <button wire:click="OpenModalUpdateQuote('edit', {{$RQ->id}})" wire:loading.attr="disabled" type="submit" class="text-blue-500 hover:text-blue-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                                                    <path d="M13.5 6.5l4 4" />
                                                                </svg>
                                                                <span wire:loading wire:target="OpenModalUpdateLineQuote('edit', '{{$RQ->id}}')">Cargando...</span>
                                                            </button>
                                                    
                                                            <!-- Botón Eliminar -->
                                                            <button wire:click="OpenModalUpdateLineQuote('delete', '{{$RQ->id}}')" wire:loading.attr="disabled" type="submit" class="text-red-500 hover:text-red-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                                <span wire:loading wire:target="OpenModalUpdateLineQuote('delete', '{{$RQ->id}}')">Cargando...</span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                        @else
                            <div class="flex justify-center items-center">
                                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        No hay Cotizaciones
                                    </h4>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if ($files)
                        <br>
                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                            <strong>Documentos:</strong>
                        </p>
                        @if ($files->count())
                            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900"">
                                <div class="w-full overflow-x-auto">
                                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                        <thead>
                                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">VENDOR</span>
                                                </th>
                                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Proveedor</span>
                                                </th>
                                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Nombre</span>
                                                </th>
                                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Comentarios</span>
                                                </th>
                                                <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Fecha</span>
                                                </th>
                                                <th wire:click="Detalles('description')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Acción</span>
                                                </th>
                                            </atr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                            @foreach ($files as $file)
                                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $file->supplier->VENDOR }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $file->supplier->VNDNAM }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $file->fileName }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        {{ $file->description }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        {{ $file->created_at }}
                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        <div class="flex space-x-2 justify-center">
                                                            <!-- Enlace para Ver Documento -->
                                                            <a href="{{ Storage::url($file->filePath) }}" target="_blank" class="flex items-center text-blue-500 hover:text-blue-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                    <path d="M11.5 21h-4.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v5m-5 6h7m-3 -3l3 3l-3 3" />
                                                                </svg>
                                                            </a>
                                                    
                                                            <!-- Botón Eliminar -->
                                                            <button wire:click="OpenModalUpdateLineQuote('delete')" wire:loading.attr="disabled" type="submit" class="flex items-center text-red-500 hover:text-red-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                                <span wire:loading wire:target="OpenModalUpdateLineQuote('delete','{{$RQ->id}}')">Cargando...</span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    
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
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            No hay Documentos Adjuntos
                                        </h4>
                                    </div>
                                </div>
                            <br>
                        @endif
                    @endif
                    
                    
                    @if ($selectedRQ && $selectedRQ->statusList->id == 5)
                        <button wire:click="$set('showConfirmSendUserModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Enviar a usuario
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Update Line Quote Modal -->
    <div id="UpdateLineQuoteModal" tabindex="-1" aria-hidden="true" @if ($showUpdateLineQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"  >
        <div class="overflow-hidden  mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    @if ($modeLine == "create")
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Nueva Línea
                        </h3>
                    @elseif ($modeLine == "edit")
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Editar Línea
                        </h3>
                    @endif
                    <button wire:click="$set('showUpdateLineQuoteModal',true)" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="{{ $modeLine == 'create' ? 'createLineQuote' : 'EditLineQuote' }}" class="p-4 md:p-5">
                    <div class="w-full mx-auto bg-white dark:bg-gray-700">
                        <div class="grid gap-3 mb-3 lg:grid-cols-4">

                            <!-- Departamento que usara -->
                            <div class="col-span-1">
                                <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que usará:</label>
                                <select wire:model.defer="RQLCostCenter_id" id="CostCenter_id" name="CostCenter_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un Centro de Costos</option>
                                    @foreach($costCenters as $costCenter)
                                        <option value="{{ $costCenter->id }}">{{ $costCenter->name }} - {{ $costCenter->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Item -->
                            <div class="col-span-3">
                                <label for="RQLItem_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Ítem:</label>
                                <select wire:model="RQLItem_id" id="Item_id" name="Item_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Seleccione un Ítem</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nombre (si no se selecciona un item) -->
                            @if (!$RQLItem_id)
                                <div class="col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Nombre:</label>
                                    <input wire:model.lazy="RQLname" type="text" id="name" name="name" minlength="10" maxlength="50" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>
                            @endif

                            <!-- Cantidad -->
                            <div class="col-span-1">
                                <label for="RQLquantity" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Cantidad:</label>
                                <input wire:model.defer="RQLquantity" type="number" id="RQLquantity" name="quantity" min="1" max="10000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>

                            <!-- Descripción (si no se selecciona un item) -->
                            @if (!$RQLItem_id)
                                <div class="col-span-3">
                                    <label for="RQLdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Descripción:</label>
                                    <textarea wire:model.defer="RQLdescription" id="RQLdescription" name="RQLdescription" minlength="10" maxlength="300" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                                </div>
                            @endif

                            <!-- Fecha en que se requiere -->
                            <div class="col-span-1">
                                <label for="RQLdateRequired" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha en que se requiere:</label>
                                <input wire:model.defer="RQLdateRequired" type="date" id="RQLdateRequired" name="RQLdateRequired" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>

                            <!-- Imagen (si no se selecciona un item) -->
                            @if (!$RQLItem_id)
                                <div class="col-span-1">
                                    <label for="RQL_imgPath" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Imagen:</label>
                                    <input wire:model.defer="RQL_imgPath" type="file" id="RQL_imgPath" name="RQL_imgPath" accept=".png, .jpg, .jpeg, .zip, .rar, .pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>
                            @endif

                            <!-- Unidad de Medida (si no se selecciona un item) -->
                            @if (!$RQLItem_id)
                                <div class="col-span-1">
                                    <label for="MeasurementUnit_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Unidad de Medida:</label>
                                    <select wire:model.defer="RQLMeasurementUnit_id" id="MeasurementUnit_id" name="MeasurementUnit_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="">Seleccione unidad de medida</option>
                                        @foreach($measurementUnits as $measurementUnit)
                                            <option value="{{ $measurementUnit->id }}">{{ $measurementUnit->name }} - {{ $measurementUnit->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                    </div>
                    <button wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span>Guardar</span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- <div id="AddQuoteModal" tabindex="-1" aria-hidden="true" @if ($showAddQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Añadir Cotización
                    </h3>
                    <button wire:click="CloseModalAddQuote" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                @if ($selectedRQLine)
                <form wire:submit.prevent="MakeQuote" class="p-4 md:p-5">
                    <div class="grid gap-3 mb-3 lg:grid-cols-2">
                        <!-- <div class="col-span-1"></div> -->
                        <div class="col-span-2">
                            <strong>Item:</strong> {{ $selectedRQLine->name }} <br>
                            <strong>Descripción:</strong> {{ $selectedRQLine->description }} <br>
                            <strong>Cantidad:</strong> {{ $selectedRQLine->quantity }} <br>
                            <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                <strong>Seleccione el proveedor que cotiza:</strong>
                            </p>
                            <div>
                                @php
                                    $query_supplier = App\Models\Supplier::select('id', 'VENDOR', 'VNDNAM')
                                    // ->whereRaw("CAST(VENDOR as CHAR) NOT LIKE '11%'")
                                    // ->where("VENDOR"," NOT LIKE", '11%')
                                    ->where('VMID', 'VM')
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
                                                    <div class="col-span-10  focus-within:text-blue-600">
                                                        <label for="selectModalSupplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por Nombre o Código</label>
                                                        <input wire:model.lazy="selectModalSupplier" type="text" maxlength="50" name="selectModalSupplier" id="selectModalSupplier" placeholder="Buscar registro..." autocomplete="on" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                                                        <select wire:model.defer="selectedSupplier" name="selectedSupplier" id="selectedSupplier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                            <option value="">Seleccione un Proveedor</option>
                                                            @foreach($suppliers as $supplier)
                                                                <option value="{{ $supplier->id }}">{{ $supplier->VENDOR }} - {{ $supplier->VNDNAM }} : {{ $supplier->VMDATN }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <label for="price" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Precio unitario:</label>
                                    <input wire:model.defer='price' type="number" step="any" min="0" max="99999999" id="price" name="price"  @if ($selectedRQ)@if ($selectedRQ->Quote1) value="{{$selectedRQ->Quote1}}" @endif @endif class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingrese valor unitario del articulo" required>
                                </div>
                                <div class="col-span-1">
                                    <label for=Currency_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Moneda:</label>
                                    <select wire:model.defer="Currency_id" name="Currency_id" id="Currency_id"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option  value="">Seleccione tipo de moneda</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-1">
                                    <label for="totalPrice" class="block text-sm font-medium text-gray-700 dark:text-gray-500">Precio Total:</label>
                                    <input id="totalPrice" type="number" step="any" value="totalPrice" class="bg-gray-50 border border-gray-200 text-gray-500 text-sm rounded-lg focus:ring-blue-200 focus:border-blue-200 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-50 dark:placeholder-gray-200 dark:text-white" disabled>
                                </div>
                                
                                <script>
                                    let price = parseFloat('{{ $this->price }}');
                                    let quantity = parseFloat('{{ $this->selectedRQLine->quantity }}');
                                    
                                    // Calcula el precio total y redondea a 4 decimales
                                    let totalPrice = (price * quantity).toFixed(4);
                                    
                                    // Actualiza el valor del input con el total
                                    document.getElementById('totalPrice').value = totalPrice;
                                </script>
                                
                                <div class="col-span-1">
                                    <label for="NumDaysArrival" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Días para llegada:</label>
                                    <select wire:model.defer="NumDaysArrival" id="NumDaysArrival" name="NumDaysArrival" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        @for ($i = 1; $i <= 365; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-span-5">
                                    <label for="AddQuDescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comentarios (Opcional)</label>
                                    <textarea wire:model="AddQuDescription" name="AddQuDescription" id="AddQuDescription" maxlength="250" rows="2" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba una brebe explicación de la solicitud" > </textarea>
                                </div>                 
                            </div>
                        </div>
                        
                    </div>
                    <button wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div> --}}
    <div id="AddQuoteModal" tabindex="-1" aria-hidden="true" @if ($showAddQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Añadir Cotización
                    </h3>
                    <button wire:click="CloseModalAddQuote" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                @if ($selectedRQLine)
                <form wire:submit.prevent="MakeQuote" class="p-4 md:p-5">
                    <div class="mb-4">
                        <strong>Item:</strong> {{ $selectedRQLine->name }} <br>
                        <strong>Descripción:</strong> {{ $selectedRQLine->description }} <br>
                        <strong>Cantidad:</strong> {{ $selectedRQLine->quantity }} <br>
                    </div>
                    @php
                        $query_supplier = App\Models\Supplier::select('id', 'VENDOR', 'VNDNAM')
                        // ->whereRaw("CAST(VENDOR as CHAR) NOT LIKE '11%'")
                        // ->where("VENDOR"," NOT LIKE", '11%')
                        ->where('VMID', 'VM')
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
                    <div class="mb-4">
                        <label for="selectModalSupplier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por Nombre o Código</label>
                        <input wire:model.lazy="selectModalSupplier" type="text" maxlength="50" name="selectModalSupplier" id="selectModalSupplier" placeholder="Buscar registro..." autocomplete="on" class="block w-full mb-3 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        <select wire:model.defer="selectedSupplier" name="selectedSupplier" id="selectedSupplier" class="block w-full mb-4 p-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">Seleccione un Proveedor</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->VENDOR }} - {{ $supplier->VNDNAM }} : {{ $supplier->VMDATN }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Precio unitario:</label>
                            <input wire:model.defer='price' type="number" step="any" min="0" max="99999999" id="price" name="price" class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ingrese valor unitario del articulo" required>
                        </div>
                        <div>
                            <label for="Currency_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Moneda:</label>
                            <select wire:model.defer="Currency_id" name="Currency_id" id="Currency_id" class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">Seleccione tipo de moneda</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }} - {{ $currency->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="totalPrice" class="block text-sm font-medium text-gray-700 dark:text-gray-500">Precio Total:</label>
                            <input id="totalPrice" type="number" step="any" value="totalPrice" class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-200 text-gray-500 rounded-lg focus:ring-blue-200 focus:border-blue-200 dark:bg-gray-800 dark:border-gray-50 dark:placeholder-gray-200 dark:text-white" disabled>
                        </div>
                        <div>
                            <label for="NumDaysArrival" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Días para llegada:</label>
                            <select wire:model.defer="NumDaysArrival" id="NumDaysArrival" name="NumDaysArrival" class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                @for ($i = 1; $i <= 365; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="AddQuDescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comentarios (Opcional)</label>
                        <textarea wire:model="AddQuDescription" name="AddQuDescription" id="AddQuDescription" maxlength="250" rows="2" class="block w-full p-2.5 text-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba una breve explicación de la solicitud"></textarea>
                    </div>                 
                    <button wire:loading.attr="disabled" type="submit" class="w-full inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Guardar
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
    

    <!-- Modal Formulario para cotizar linea de RQ -->
    <div id="addDocumentModal" tabindex="-1" aria-hidden="true" @if ($showAddQuoteFileModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"  >
        <div class="overflow-hidden  mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Cargar documento de cotización
                    </h3>
                    <button wire:click="$set('showAddQuoteFileModal',true)" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="saveQuoteFile" class="p-4 md:p-5">
                    <!-- This is an example component -->
                    <div class="w-full mx-auto bg-white dark:bg-gray-700 ">
                        <div class="grid gap-3 mb-3 lg:grid-cols-6">
                            <div class="col-span-2">
                                <label for=selectSupplierFile" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Proveedor que Cotiza:</label>
                                <select wire:model="selectSupplierFile" name="selectSupplierFile" id="selectSupplierFile" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option selected value="">Seleccione un proveedor</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->VENDOR }} - {{ $supplier->VNDNAM }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label for="QuotePDF" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Archivo:</label>
                            <input wire:model="QuotePDF" type="file" id="QuotePDF" name="QuotePDF" accept=".png, .jpg, .jpeg, .zip, .rar, .pdf," class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            @error('QuotePDF') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-6">
                            <label for="QUdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comentarios (Opcional)</label>
                            <textarea wire:model="QUdescription" name="QUdescription" id="QUdescription" maxlength="250" rows="2" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba una brebe explicación de la solicitud" > </textarea>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">¡Oh no! Algo salió mal.</div>
                            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Subir
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirm Seend Quote To User Modal -->
    <div id="ConfirmSendToUser" tabindex="-1" aria-hidden="true" @if ($showConfirmSendUserModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalConfirmSendUser" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres enviar este solicitud de cotización?</h3>
                    <button wire:click="SendRQtoUser" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalConfirmSendUser"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Line Quote Modal -->
    <div id="ConfirmDeleteLineQuoteModal" tabindex="-1" aria-hidden="true" @if ($showDeleteLineQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalDeleteLineQuote" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres eliminar esta línea de cotización cotización?</h3>
                    <button wire:click="DeleteLineQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalDeleteLineQuote"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Seend Quote To Infor Modal -->
    <div id="ConfirmSendToYH100" tabindex="-1" aria-hidden="true" @if ($showConfirmSendYH100Modal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalConfirmSendYH100" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres enviar este solicitud de cotización?</h3>
                    <button wire:click="SendRQtoYH100" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalConfirmSendYH100"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Generate Parcial Quote -->
    <div id="ConfirmGeneratePartialQuote" tabindex="-1" aria-hidden="true" @if ($showConfirmGeneratePartialQuote) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmGeneratePartialQuote',true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro de generar una parcialidad, y enviar las lineas cotizadas al usuario?</h3>
                    <button wire:click="generatePartialQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="$set('showConfirmGeneratePartialQuote',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    Livewire.on('openModal', function (modalName) {
        // Oculta todos los modales
        const modals = document.querySelectorAll('[id^="modal"]');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });

        // Muestra el modal específico
        const modal = document.getElementById(modalName);
        if (modal) {
            modal.style.display = 'block';
        }

        // Evita el cierre del modal al hacer clic dentro de él
        modal.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        // Evita el cierre del modal al escribir en los campos de entrada dentro de él
        const inputFields = modal.querySelectorAll('input, textarea');
        inputFields.forEach(input => {
            input.addEventListener('focus', function (event) {
                event.stopPropagation();
            });
        });
    });

    Livewire.on('closeModal', function (modalName) {
        // Oculta el modal específico
        const modal = document.getElementById(modalName);
        if (modal) {
            modal.style.display = 'none';
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('dateRequiredQuote');
        const today = new Date().toISOString().split('T')[0];
        
        // Set minimum date to today
        dateInput.setAttribute('min', today);
    
        dateInput.addEventListener('input', function() {
            const dateValue = new Date(this.value);
            const dayOfWeek = dateValue.getUTCDay();
    
            // Check if the selected date is Saturday (6) or Sunday (0)
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                alert('Sábados y domingos no están permitidos.');
                this.value = '';
            }
        });
    });
</script>
    