<div>
    <div class="px-4 py-3 gap-x-2 my-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <label class="text-sm">
            <div class="relative text-gray-500">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <!-- Campo de búsqueda por palabra clave -->
                    <div class="col-span-9 focus-within:text-blue-600">
                        <label for="searchRQ" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por RFQ o Descripción:</label>
                        <input wire:model="searchRQ" type="text" maxlength="50" name="searchRQ" id="searchRQ" placeholder="Buscar registro..." autocomplete="off" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </div>
                    <!-- Botón para limpiar filtros -->
                    <div class="col-span-3 focus-within:text-blue-600">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">&nbsp;</label>
                        <button wire:click="clearFilters" wire:loading.attr="disabled" class="flex mt-1 py-2 px-7 text-sm font-medium text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-md active:bg-gray-100 focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                            Limpiar Filtros
                        </button>
                    </div>
                    <!-- Campo para seleccionar estatus -->
                    <div class="col-span-3 focus-within:text-blue-600">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estatus</label>
                        <select wire:model="selectedRQStatus" id="status" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                            <option value="">Todos</option>
                            @foreach ($status as $state)
                                <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Campo para seleccionar la fecha de inicio -->
                    <div class="col-span-3 focus-within:text-blue-600">
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Inicio</label>
                        <input wire:model="startDate" type="date" id="start_date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </div>
                    <!-- Campo para seleccionar la fecha de final -->
                    <div class="col-span-3 focus-within:text-blue-600">
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fecha Final</label>
                        <input wire:model="endDate" type="date" id="end_date" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                    </div>
                </div>
            </div>
        </label>
    </div>
    
        {{-- Botones de Crud, y lista de cantidad de paginación --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <span class="flex items-center justify-end col-span-1 text-gray-700 dark:text-gray-300">
                {{ __('messages.mostrando') }}:
            </span>
            <select wire:click="resetPage"  wire:model="perPage" name="Status" id="Status" class="col-span-1 block py-1 px-2 rounded my-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray">
                <option value="" disabled>Seleccione la pagianación</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
    
            @if ($selectedRQ)
                
                <button wire:click="OpenModalLinesQuote" wire:loading.attr="disabled" class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                    {{ __('messages.detalle') }}
                </button>
                <button wire:click="OpenModalHistory"    wire:loading.attr="disabled" class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                    {{ __('messages.historial') }}
                </button>
                @if ($selectedRQ->StatusList_id == 25)
                    <a wire:click="" href="{{route('Purchasing.requestRequisition.pdf', ['selectedRQ' => $selectedRQ])}}"
                        class="col-span-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2" 
                        type="button"
                        wire:loading.attr="disabled"
                        target="_blank">
                        Generar P.O.
                    </a>
                @endif
            @endif
        </div>
    
        {{-- <img class="object-cover w-full h-full"
        src="{{ asset('img/items/img.png') }}" alt="Y-Tec Keylex México"/> --}}
    
    
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
                        alertMessage.style.transition = 'opacity 2s';
                        alertMessage.style.opacity = '1';
                        setTimeout(function(){
                            alertMessage.remove();
                        }, 2000);
                    }, 1000);
                </script>
            @elseif(session('error'))
                <div id="alertMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
                <script>
                    setTimeout(function(){
                        var alertMessage = document.getElementById('alertMessage');
                        alertMessage.style.transition = 'opacity 2s';
                        alertMessage.style.opacity = '1';
                        setTimeout(function(){
                            alertMessage.remove();
                        }, 2000);
                    }, 1000);
                </script>
            @endif
        </div>
    
    
        {{-- Tabla, se muestra la lista de registros --}}
        @if ($requestQuotes->count())
        {{-- <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative"  background: rgba(255, 255, 255, 0.408)"> --}}
            {{-- <div class="w-full overflow-x-auto  background: rgba(255, 255, 255, 0.408)"> --}}
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            @if ($selectedRQOrderBy == 'RFQ' && $selectedRQOrder == 'ASC')
                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                <span class="mr-1">
                                    RFQ
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
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
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Comprador<br>Asignado</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Aprobación<br>Requisición</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Commodity<br>Asignado</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Aprobación<br>Sol. Inver.</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Aprobación<br>P.O.</span>
                            </th>
                            {{-- <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Recepcionado</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Recolectado</span>
                            </th> --}}
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Frecha <br>Creado</span>
                            </th>
                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                <span class="mr-1">Fecha ultima <br>Actualización</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 uppercase dark:bg-gray-800">
                        @foreach ($requestQuotes as $RQ)
                            <tr wire:click="selectRQ({{ $RQ->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQ && $selectedRQ->id == $RQ->id)  bg-green-200 dark:bg-gray-500 @endif">
                                {{-- <td class="px-4 py-2 text-xs whitespace-pre-line">
                                    {{ $RQ->RFQ }}
                                </td> --}}
                                <td class="px-4 py-3 description-cell">
                                    <div class="flex items-center text-sm">
                                        <!-- Avatar with inset shadow -->
                                        <div>
                                            <p >{{ $RQ->RFQ }}</p>                                        
                                        </div>
                                    </div>
                                </td> 
                                <td class="px-4 py-3 text-xs description-cell">
                                    <p >{{$RQ->UserName}}</p>
                                </td>  
                                <td class="px-4 py-2 text-xs">
                                    @if ($RQ->StatusList_id == 39)
                                    <span class="not-assigned description-cell">
                                        {{ $RQ->statusList->name }}
                                    </span>
                                    @else
                                    <span class="assigned description-cell">
                                        {{ $RQ->statusList->name }}
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    @if( $RQ->Buyer_id )
                                        <span class="assigned description-cell">
                                            {{ $RQ->buyer->PBNAM }}
                                        </span>
                                    @else
                                        <span class="ni-assigned description-cell">
                                            NO ASIGNADO
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    @if( $RQ->ApprovateUser && $RQ->ApprovateLines && $RQ->ManagerApprovate )
                                        <span class="assigned description-cell">
                                            FINALIZADA
                                        </span>
                                    @elseif( $RQ->ApprovateUser && $RQ->ApprovateLines )
                                        <span class="not-assigned description-cell">
                                            LINEAS<br>APROBADAS
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
                                            NO ASIGNADO
                                        </span>
                                    @endif
                                </td>
                                @php
                                    $RI = App\Models\RequestInvestment::where('RequestQuote_id',$RQ->id)->first();
                                @endphp
                                <td class="px-4 py-2 text-xs">
                                    @if( $RI && $RI->ReviewedByFinance == 1 )
                                        <span class="assigned description-cell">
                                            APROBADA
                                        </span>
                                    @elseif( $RI && $RI->ApprovePresident )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN FINANZAS
                                        </span>
                                    @elseif( $RI && $RI->ApproveVicePresident )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN PRESIDENTE
                                        </span>
                                    @elseif( $RI && $RI->ApproveDirector )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN VICEPRESIDENTE
                                        </span>
                                    @elseif( $RI && $RI->ApproveManager )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN GERENTE COMPRAS
                                        </span>
                                    @elseif( $RI && $RI->ApproveUser )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN GERENTE
                                        </span>
                                    @elseif( $RI && $RI->WorkNumber )
                                        <span class="not-assigned description-cell">
                                            PENDIENTE DE LLENADO
                                        </span>
                                    @else
                                        <span class="ni-assigned description-cell">
                                            NO APLICA
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    @if( $RQ->ApprovatePresident )
                                        <span class="assigned description-cell">
                                            FINALIZADA
                                        </span>
                                    @elseif($RQ->ApprovateVPresident)
                                        <span class="not-assigned description-cell">
                                            PENDINTE APROBACIÓN DE PRESIDENTE
                                        </span>
                                    @elseif($RQ->ApprovateDirector)
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN DE VICEPRESIDENTE
                                        </span>
                                    @elseif($RQ->ApprobateBuyer)
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN DE GERENTE COMPRAS
                                        </span>Ç
                                    @elseif($RQ->StatusList_id == 18)
                                        <span class="not-assigned description-cell">
                                            PENDIENTE APROBACIÓN DE COMPRADOR
                                        </span>
                                    @else
                                        <span class="ni-assigned description-cell">
                                            NO GENEADO
                                        </span>    
                                    @endif
                                </td>
                                
                                {{-- <td class="px-4 py-2 text-xs">
                                    @if( $RQ && $RQ->Approvate )
                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            OK
                                        </span>
                                    @else
                                        <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                            NO<br>GENERADA
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs">
                                    @if( $RQ->Approvate )
                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                            OK
                                        </span>
                                    @else
                                        <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                            NO<br>GENERADA
                                        </span>
                                    @endif
                                </td> --}}
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
    
        <!-- show History Modal -->
        <div id="ViewHistoryQuote" tabindex="-1" aria-hidden="true" @if($showHistoryModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"  >
            <div class="overflow-hidden  mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Historial
                        </h3>
                        <button wire:click="closeModalHistory" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Cerrar ventana</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <!-- component -->
                        <div class="w-full mx-auto bg-white dark:bg-gray-700 ">
                            @if ($RQLines)
                                {{-- Tabla, se muestra la lista de registros --}}
                                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 470px;">
                                    <div class="w-full overflow-x-auto">
                                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                            <thead>
                                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                                    <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                        <span class="mr-1">Estatus</span>
                                                    </th>
                                                    <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                        <span class="mr-1">Fecha</span>
                                                    </th>
                                                    <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                        <span class="mr-1">Hora</span>
                                                    </th>
                                                    <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                        <span class="mr-1">Comentarios</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                                @foreach ($RQHistory as $RQH)
                                                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <td class="px-4 py-2 text-xs">
                                                            {{ $RQH->statusList->name }}
                                                        </td>
                                                        <td class="px-4 py-2 text-xs">
                                                            {{ Carbon\Carbon::parse($RQH->updated_at)->format('d-m-Y') }}
                                                        </td>
                                                        <td class="px-4 py-2 text-xs">
                                                            {{ Carbon\Carbon::parse($RQH->updated_at)->format('H:m:s') }}    
                                                        </td>
                                                        <td class="px-4 py-2 text-xs">
                                                            {{ $RQH->remark }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

        <!-- View Lines Quote Modal -->
        <div id="ViewLinesQuoteModal" tabindex="-1" aria-hidden="true" @if ($showLinesQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
            {{-- <div class="overflow-y-auto mx-auto relative p-4 overflow-w-auto md max-h-screen"> --}}
                <!-- Modal content -->
                <div class="relative bg-white w-full rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <!-- Header content goes here -->
                        @if ( $selectedRQ && $selectedRQ->statusList->id == 1 )
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                RFQ: {{ $selectedRQ->RFQ}} - Ingreso de Lineas.
                            </h3>
                        @elseif ( $selectedRQ && $selectedRQ->statusList->id == 6 )
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                RFQ: {{ $selectedRQ->RFQ}} - Seleccion de Cotizaciones
                            </h3>
                        @elseif ( $selectedRQ && $selectedRQ->statusList->id == 7 )
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                RFQ: {{ $selectedRQ->RFQ}} - Cotización
                            </h3>
                        @elseif ( $selectedRQ && $selectedRQ->statusList->id == 9 )
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                RFQ: {{ $selectedRQ->RFQ}} - Requesición
                            </h3>
                        @elseif ( $selectedRQ && $selectedRQ->statusList->id == 10 )
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                RFQ: {{ $selectedRQ->RFQ}} - P.O.
                            </h3>
                        @else
                            @if ( $selectedRQ )
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    RFQ: {{ $selectedRQ->RFQ}} - Detalles
                                </h3>
                            @endif
                        @endif
                        <button wire:click="closeModalLinesQuote" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Cerrar ventana</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="w-full mx-auto bg-white dark:bg-gray-700 ">
                            @if ($RQLines)
                                <table>
                                    <thead></thead>
                                    <tbody>
                                        <td>
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
                                            @if ($selectedRQ->remarks1)
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    <strong>Motivo Rechazo:</strong> {{ $selectedRQ->remarks1 }}
                                                </p>
                                            @endif  
                                        </td>
                                        <td>
                                            @if ($selectedRQ->TotalCostMXN)
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Total MXN:</strong> ${{ round($selectedRQ->TotalCostMXN,4) }}
                                            </p>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Total USD:</strong> ${{ round($selectedRQ->TotalCostUSD,4) }}
                                            </p>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Total JPY:</strong> ¥{{ round($selectedRQ->TotalCostJPY,4) }}
                                            </p>
                                            @endif
                                        </td>
                                    </tbody>
                                </table>
                                <br>
                                @if ($RQLines->count() == 0)
                                    <div class="flex justify-center items-center">
                                        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                ¡Aún no se han añadido líneas!
                                            </h4>
                                        </div>
                                    </div>
                                @else
                                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                    <strong>Lineas:</strong>
                                </p>
                                {{-- Tabla, se muestra la lista de registros --}}
                                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" ">
                                    <div class="w-full overflow-x-auto">
                                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                                            <thead>
                                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
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
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                                @foreach ($RQLines as $RQL)
                                                    <tr wire:click="selectRQLine({{ $RQL->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQLine && $selectedRQLine->id == $RQL->id)  bg-green-200 dark:bg-gray-500 @endif">
                                                        <td class="px-4 py-2 text-xs whitespace-pre-line">
                                                            {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                                        </td>
                                                        @if ($RQL->imgPATH != NULL)
                                                            {{-- <td class="px-4 py-3">
                                                                <div class="flex items-center text-sm">
                                                                    <!-- Avatar with inset shadow -->
                                                                    <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                                        <img class="object-cover w-full h-full rounded-full" --}}
                                                                            {{-- src="{{ asset('img/items/'.$RQL->imgPATH) }}" alt="Y-Tec Keylex México" --}}
                                                                            {{-- src="{{ Storage::url('items/'.$RQL->imgPATH) }}" alt="Not Img"  --}}
                                                                            {{-- src="" alt="Not Img"  --}}
                                                                            {{-- src="C:\Users\carlos.garcia\Desktop\Isaac.jpg" alt="Not Img"  --}}
                                                                            {{-- loading="lazy" --}}
                                                                            {{-- />
                                                                        <div class="absolute inset-0 rounded-full shadow-inner"
                                                                            aria-hidden="true"></div>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-semibold">{{ $RQL->name }},
                                                                    </div>
                                                                </div>
                                                            </td> --}}
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
                                                            <td class="px-4 py-2 text-xs">
                                                                $ {{ round($RQL->quantity * $RQL->UnitCost,4) }} {{ $RQL->currency->name }}
                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                                    {{ $RQL->statusList->name}}
                                                                </span>
                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                {{ Carbon\Carbon::parse($RQL->dateArrival)->format('d-m-Y') }}
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                @if ($selectedRQ && $selectedRQLine && $selectedRQ->StatusList_id >= 6)
                                    @php
                                        $quotes = App\Models\Quote::where('QuoteLine_id',$selectedRQLine->id)->get();
                                    @endphp
                                    <br>
                                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                        <strong>Cotizaciónes:</strong>
                                    </p>
                                    @if (!$selectedRQLine )
                                        <br>
                                        <div class="flex justify-center items-center">
                                            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    No se ah seleccionado ninguna línea
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
                                                                <span class="mr-1">Días de entrega</span>
                                                            </th>
                                                            <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                                <span class="mr-1">Comentario</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                                        @foreach ($quotes as $quote)
                                                        {{-- <tr wire:click="selectQuote({{ $quote->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedQuote && $selectedQuote->id == $quote->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                                                        <tr class="text-gray-700 dark:text-gray-400 @if($quote->id == $quote->quoteLine->Quote_id) bg-blue-200 dark:bg-blue-500 @endif">
                                                        {{-- <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"> --}}
                                                                <td class="px-4 py-2 text-xs">
                                                                    {{ $quote->supplier->VENDOR }} -{{ $quote->supplier->VNDNAM }}
                                                                </td>
                                                                <td class="px-4 py-2 text-xs">
                                                                    $ {{ $quote->Cost }} {{ $quote->currency->name }}
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
                                @if ($files && $selectedRQ->StatusList_id >= 6 )
                                    <br>
                                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                        <strong>Documentos:</strong>
                                    </p>
                                    @if ($files->count()>0)
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
                                                                <span class="mr-1">Nombre</span>
                                                            </th>
                                                            <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                                <span class="mr-1">Fecha</span>
                                                            </th>
                                                            <th wire:click="Detalles('description')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                                <span class="mr-1">Ir</span>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                                        @foreach ($files as $file)
                                                        <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <td class="px-4 py-2 text-xs">
                                                                    {{ $file->supplier->VENDOR }}
                                                                </td>
                                                                <td class="px-4 py-2 text-xs">
                                                                    {{ $file->supplier->VNDNAM }}
                                                                </td>
                                                                <td class="px-4 py-2 text-xs">
                                                                    {{ $file->fileName }}
                                                                </td>
                                                                <td class="px-4 py-2 text-xs">
                                                                    {{ $file->created_at }}
                                                                </td>
                                                                <td class="px-4 py-2 text-xs">
                                                                    <a href="{{ Storage::url($file->filePath) }}" target="_blank">Ver documento</a>
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
                                    @if ($selectedRQ->StatusList_id >=14  && $selectedRQ->StatusList_id != 39 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37)
                                        <br>
                                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                            <strong>Aprobación de Requisición:</strong>
                                        </p>
                                        <br>
                                        <div class="flex justify-center items-center w-full mx-auto bg-white dark:bg-gray-700 ">
                                            <div class="grid gap-3 mb-3 lg:grid-cols-6">                                    
                                                <div class="col-span-2 flex items-center">
                                                    @if( is_null($selectedRQ->ApprovateUser ))
                                                        <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ && $selectedRQ->ApprovateUser == true)
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            {{$selectedRQ->user->name}}
                                                        </span>
                                                    @else
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            Rechazada
                                                        </span>
                                                    
                                                    @endif
                                                </div>
                                                <div class="col-span-2 flex justify-center items-center">
                                                    @if(is_null($selectedRQ->ApprovateLines))
                                                        <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ && $selectedRQ->ApprovateLines == 1)
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            Aprobada
                                                        </span>
                                                    @else
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </div> 
                                                <div class="col-span-2 flex items-center">
                                                    @if(is_null($selectedRQ->ApprovateLines))
                                                        <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ && $selectedRQ->ManagerApprovateName)
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            {{$selectedRQ->ManagerApprovateName}}
                                                        </span>
                                                    @else
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div> 
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Usuario</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Gerentes Usara</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Gerente Solicita</label>
                                                </div>                                                          
                                            </div>
                                        </div>
                                    @endif
                                    @if ($selectedRQ->StatusList_id>=18  && $selectedRQ->StatusList_id != 39 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37)
                                        <br>
                                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                            <strong>Aprobación de P.O:</strong>
                                        </p>
                                        <br>
                                        <div class="flex justify-center items-center w-full mx-auto bg-white dark:bg-gray-700 ">
                                            <div class="grid gap-3 mb-3 lg:grid-cols-8">
                                                <div class="col-span-2">
                                                    @if(is_null($selectedRQ->ApprovatePOBuyer))
                                                        <span class="ni-assigned">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ && $selectedRQ->ApprovatePOBuyer == true)
                                                        <span class="assigned">
                                                            {{$selectedRQ->ApprovateBuyerName}}
                                                        </span>
                                                    @else
                                                        <span class="not-assigned">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-span-2">
                                                    @if(is_null($selectedRQ->ApprovatePODirector))
                                                        <span class="ni-assigned">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ->ApprovatePODirector == true)
                                                        <span class="assigned">
                                                            {{$selectedRQ->ApprovateDirector}}
                                                        </span>
                                                    @else
                                                        <span class="not-assigned">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-span-2">
                                                    @if(is_null($selectedRQ->ApprovateVPresident))
                                                        <span class="ni-assigned">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ && $selectedRQ->ApprovateVPresident == 1)
                                                        <span class="assigned">
                                                            {{$selectedRQ->ApprovateVPresidentName}}
                                                        </span>
                                                    @else
                                                        <span class="not-assigned">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-span-2">
                                                    @if(is_null($selectedRQ->ApprovatePresident))
                                                        <span class="ni-assigned">
                                                            Pendiente
                                                        </span>
                                                    @elseif( $selectedRQ && $selectedRQ->ApprovatePresident == 1)
                                                        <span class="assigned">
                                                            {{$selectedRQ->ApprovatePresidentName}}
                                                        </span>
                                                    @else
                                                        <span class="not-assigned">
                                                            Rechazada
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div>
                                                <div class="col-span-2 flex items-center">
                                                    <hr class="border-t-2 border-gray-400 flex-grow ml-4">
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprueba Comprador:</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprueba Gerente Compras:</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font- text-gray-900 dark:text-gray-300">Aprueba Vicepresidente:</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprueba Presidente:</label>
                                                </div> 
                                            </div>
                                        </div>
                                        <br>
                                    @endif
                                @endif
                            @endif
                        @endif
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
    
</div>
