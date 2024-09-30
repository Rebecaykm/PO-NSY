<div>
    <div class="px-4 py-3 gap-x-2 my-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <label class="text-sm">
            <form >
                <div class="relative text-gray-500">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- Campo de búsqueda por palabra clave -->
                        <div class="col-span-4 focus-within:text-blue-600">
                            <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por RFQ o Descripción:</label>
                            <input wire:model.defer="search" type="text" maxlength="50" name="search" id="search" placeholder="Buscar registro..." autocomplete="off" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
                        </div>
                        
                        <!-- Campo para seleccionar estatus -->
                        <div class="col-span-2 focus-within:text-blue-600">
                            <label for="selectedStatus" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estatus</label>
                            <select wire:model.defer="selectedStatus" name="selectedStatus" id="selectedStatus" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                <option value="">Todos</option>
                                <!-- Agrega las opciones de estatus disponibles -->
                                <option value="2">Pendiente</option>
                                <option value="3">Asignado</option>
                                <option value="38">Rechazado</option>
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
    
    

    {{-- Botones de Crud, y lista de cantidad de paginación --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <span class="flex items-center col-span-1 text-gray-700 dark:text-gray-300"> Mostrando:</span>
        <select wire:click="resetPage"  wire:model="perPage" name="Status" id="Status" class="block py-1 px-2 rounded my-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray">
            <option value="" disabled>Seleccione la pagianación</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <span class="col-span-8"></span>
        @if ($selectedRQ)
        <button wire:click="OpenModalAssignQuoteToBuyer" wire:loading.attr="disabled" class="col-span-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">Asignar Comprador</button>
        @endif
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
                        @if ($selectedOrderBy == 'RFQ' && $selectedOrder == 'ASC')
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        @elseif ($selectedOrderBy == 'RFQ' && $selectedOrder === 'DESC')
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                        @else
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                        @endif
                        </th>
                        <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                            <span class="mr-1">Propietario</span>
                        </th>
                        @if ($selectedOrderBy == 'description' && $selectedOrder === 'ASC')
                        <th wire:click="selectOrderFlag('description')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Descripción</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        @elseif ($selectedOrderBy == 'description' && $selectedOrder === 'DESC')
                        <th wire:click="selectOrderFlag('description')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Descripción</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                        @else
                        <th wire:click="selectOrderFlag('description')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Descripción</span>
                        @endif
                        </th>
                        <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                            <span class="mr-1">Estatus</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Comprador <br>Asignado</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Frecha <br>Creado</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Fecha ultima <br>Actualización</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($requestQuotes as $RQ)
                        <tr wire:click="selectRQ({{ $RQ->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQ && $selectedRQ->id == $RQ->id)  bg-green-200 dark:bg-gray-500 @endif">
                            <td class="px-4 py-2 text-xs">
                                {{ $RQ->RFQ }}
                            </td>
                            <td class="px-4 py-2 text-xs description-cell">
                                {{ $RQ->UserName }}
                            </td>
                            <td class="px-4 py-2 text-xs description-cell">
                                {{ $RQ->description }}
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    {{ $RQ->statusList->name }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                {{-- @if ()
                                    
                                @endif --}}
                                @if( $RQ->Buyer_id )
                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        {{ $RQ->buyer->PBNAM }}
                                    </span>
                                @else
                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        No Asignado
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
    <div class="px-4 py-3 rounded-md text-sm text-center font-semibold text-gray-700 uppercase bg-white sm:grid-cols-9 dark:text-gray-500 dark:bg-gray-800">
        {{ __('No Se Han Encontrado Datos') }}
    </div>
    @endif

    <!-- VieW Quote and Select Buyer -->
    <div id="CreateLineQuoteModal" tabindex="-1" aria-hidden="true" @if ($showAssignBuyerModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"  >
        <div class="overflow-hidden  mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    @if ($selectedRQ)
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Asignar Comprador. RFQ: {{$selectedRQ->RFQ}}
                    </h3>
                    @endif
                    

                    <button wire:click="CloseModalAssignQuoteToBuyer" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="" class="p-4 md:p-5">
                    <!-- This is an example component -->
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
                                    <strong>Fecha se requier cotización:</strong> {{ Carbon\Carbon::parse($selectedRQ->dateRequiredQuote)->format('d-m-Y') }}
                                </p>
                            @else
                                <p class="text-gray-600 dark:text-gray-400">
                                    <strong>Fecha de cotización:</strong> No asignado.
                                </p>
                            @endif
                            @if ($selectedRQ->remarks1)
                                <p class="text-gray-600 dark:text-gray-400">
                                    <strong>Comentarios por rechazo:</strong> {{ $selectedRQ->remarks1 }}
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
                                            <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                <span class="mr-1">Contenido</span>
                                            </th>
                                            <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
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
                                                <td class="px-4 py-2 text-xs whitespace-pre-line">
                                                    {{ $RQL->costCenter->name }} - {{ $RQL->costCenter->description }}
                                                </td>
                                                @if ($RQL->imgPath)
                                                    <td class="px-4 py-3">
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
                                                        <td class="px-4 py-2 text-xs">
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
                    @if ($selectedRQ && $selectedRQ->StatusList_id != 38 )                        
                        @if ($selectedRQ && !$selectedRQ->dateRequiredQuote)
                        <br>
                        <button wire:click='OpenModalConfirmRejectQuote' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Rechazar
                        </button>
                        <button wire:click='OpenModalAssignDateRequiredQuote' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Asignar fecha maxima para la cotización
                        </button>
                        @else
                        <br>
                        <div class="col-span-1">
                            <label for="Buyer_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comprador asignado:</label>
                            <select wire:model="selectedBuyer" name="Buyer_id" id="Buyer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option selected value="">Seleccione un comprador</option>
                                @foreach($buyers as $buy)
                                    <option value="{{ $buy->buyer->id }}">{{ $buy->buyer->PBPBC }} - {{ $buy->buyer->PBNAM }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <button wire:click='OpenModalConfirmAssignQuoteToBuyer' wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Guardar
                        </button>
                        @endif
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Date Request Quote Modal -->
    <div id="confirmRejectModal" tabindex="-1" aria-hidden="true" @if ($showAssignDateToRequestQuote) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalAssignDateRequiredQuote" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Asignar fecha maxima en la que esta solitud debe ser cotizada</h3>
                    <div class="col-span-1">
                        <label for="dateRequiredQuote" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Seleccione un día hábil :</label>
                        <input wire:model="dateRequiredQuote" type="date" id="dateRequiredQuote" name="dateRequiredQuote"  min = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 1 days"));?>" max = "<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 42 days"));?>"class="input100 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>

                    <button wire:click="AssignDateToRequestQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalAssignDateRequiredQuote"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Assignment Quote To Buyer Modal -->
    <div id="confirmAssignModal" tabindex="-1" aria-hidden="true" @if ($showConfirmAssignModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalConfirmAssigNQuoteToBuyer" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro de esta asignación?</h3>

                    <button wire:click="sendQuoteToBuyer" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalConfirmAssigNQuoteToBuyer"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Quote Modal -->
    <div id="confirmRejectModal" tabindex="-1" aria-hidden="true" @if ($showConfirmRejectQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalConfirmRejectQuote" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
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
                        <textarea wire:model="RQRemark" name="remark" id="remark" minlength="10" maxlength="300" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required> </textarea>
                    </div>
                    <button wire:click="RejectRequestQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalConfirmRejectQuote"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
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