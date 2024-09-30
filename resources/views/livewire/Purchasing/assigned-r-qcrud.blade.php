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
            <option value="50">100</option>
        </select>
    </div>

    @if (session()->has('message'))
        <div id="alertMessage" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex justify-center">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">¡Éxito!</p>
                    <p class="text-sm">{{ session('message') }}</p>
                </div>
            </div>
        </div>

        <script>
                // Función para desvanecer el mensaje después de 3 segundos
            setTimeout(function(){
                var alertMessage = document.getElementById('alertMessage');
                alertMessage.style.transition = 'opacity 2s';
                alertMessage.style.opacity = '1';
                setTimeout(function(){
                    alertMessage.remove();
                }, 2000); // Tiempo de desvanecimiento
            }, 1000); // Tiempo de espera antes de desvanecer
        </script>
    @endif


    {{-- Tabla, se muestra la lista de registros --}}
    @if ($requestQuotes->count())
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
                            <span class="mr-1">Descrición</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Aprobación<br>P.O.</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Fecha <br>Creado</span>
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
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 description-cell">
                            <div class="flex items-center text-sm">
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
                        <td class="px-4 py-2 text-xs description-cell">
                            {{ $RQ->description }}    
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
                            @elseif($RQ->ApprovatePODirector)
                                <span class="not-assigned description-cell">
                                    PENDIENTE APROBACIÓN DE VICEPRESIDENTE
                                </span>
                            @elseif($RQ->ApprovatePOBuyer == 1)
                                <span class="not-assigned description-cell">
                                    PENDIENTE APROBACIÓN DE GERENTE COMPRAS
                                </span>
                            @elseif($RQ->StatusList_id == 18)
                                <span class="not-assigned description-cell">
                                    PENDIENTE APROBACIÓN DE COMPRADOR
                                </span>
                            @else
                                <span class="ni-assigned description-cell">
                                    NO GENERADO
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
                        <td class="px-4 py-2 text-xs space-y-2">
                            <button wire:click="$set('showQuoteModal',false)" wire:loading.attr="disabled" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m0 0L9 9m0 3l0 3m6-3H9" />
                                </svg>
                                Ver
                            </button>
                        
                            @if ($RQ->StatusList_id == 25)
                            <button wire:click="OpenModalConfirmSendYH100" wire:loading.attr="disabled" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Subir a infor
                            </button>
                            @endif
                        
                            @if ($RQ->StatusList_id == 18)
                            <a wire:click="" href="{{route('Purchasing.requestRequisition.pdf', ['selectedRQ' => $RQ->id])}}"
                                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded flex items-center justify-center"
                                type="button"
                                wire:loading.attr="disabled"
                                target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16m-7 4h7m-7 4h7M9 14H4m0 4h7m0-4H4" />
                                </svg>
                                Generar P.O.
                            </a>
                            @endif
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
                    <button wire:click="CloseModalQuoteModal" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                @if ($selectedRQ )
                <div class="p-4 md:p-5">
                    <!-- This is an example component -->
                    {{-- Tabla, se muestra la lista de registros --}}
                    @if ($RQLines)
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>Descripción:</strong> {{ $selectedRQ->description }}
                        </p>
                        <p class="text-gray-600 dark:text-gray-400">
                            <strong>Solicitante:</strong> {{ $selectedRQ->UserName }}
                        </p>
                        @if ($selectedRQ)
                            @if ($selectedRQ->Commodity_id)
                                <p class="text-gray-600 dark:text-gray-400">
                                    <strong>Commodity:</strong> {{ $selectedRQ->commodity->PCCOM }}
                                </p>
                            @endif
                            @if ($selectedRQ->WorkNumber)
                                <p class="text-gray-600 dark:text-gray-400">
                                    <strong>Número de Obra:</strong> {{ $selectedRQ->WorkNumber }}
                                </p>
                            @endif
                            @if ($selectedRQ->dateRequiredQuote)
                                <p class="text-gray-600 dark:text-gray-400">
                                    <strong>Fecha se requier cotización:</strong> {{ Carbon\Carbon::parse($selectedRQ->dateRequiredQuote)->format('d-m-Y') }}
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
                                                <span class="mr-1">Frecha <br>Requiere</span>
                                            </th>
                                            <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Estatus</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                        @foreach ($RQLines as $RQL)
                                            <tr wire:click="selectLine({{ $RQL->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQLine && $selectedRQLine->id == $RQL->id)  bg-green-200 dark:bg-gray-500 @endif">
                                                <td class="px-4 py-2 text-xs whitespace-pre-line">
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
                    @if ($selectedRQ && $selectedRQLine)
                        @php
                            $quotes = App\Models\Quote::where('QuoteLine_id',$selectedRQLine->id)->get();
                        @endphp
                        <br>
                        <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                            <strong>Cotizaciónes :</strong>
                        </p>
                        @if (!$selectedRQLine )
                            <br>
                            <div class="flex justify-center items-center">
                                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        No se ah seleccionado ninguna linea
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
                                            </atr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                            @foreach ($quotes as $quote)
                                            {{-- <tr wire:click="selectQuote({{ $quote->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedQuote && $selectedQuote->id == $quote->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                                            <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
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
                    @if ($selectedRQ && $selectedRQ->StatusList_id < 4)
                    <button wire:click='OpenModalConfirmRejectQuote' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Rechazar
                    </button>
                    @endif
                @endif
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
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres subir este solicitud de cotización?</h3>
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
    