<div>
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
                                <option value="">Todos</option>
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

    {{-- Botones de Crud, y lista de cantidad de paginación --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <span class="flex items-center justify-end col-span-1 text-gray-700 dark:text-gray-300">
            {{ __('messages.mostrando') }}:
        </span>
        <select  wire:model="perPage" name="Status" id="Status" class="col-span-1 block py-1 px-2 rounded my-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray">
            <option value="" disabled>Seleccione la pagianación</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <div >
            <div x-data="{ showCreateQuoteModal: @entangle('showCreateQuoteModal') }">
                <!-- Button to open modal -->
                <button x-on:click="showCreateQuoteModal = true" wire:loading.attr="disabled" class="col-span-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                    {{ __('messages.nuevaCotizacion') }}
                </button>
            
                <!-- Create Quote Modal -->
                <div 
                    x-show="showCreateQuoteModal" 
                    @click.away="showCreateQuoteModal = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                    style="display: none;"
                >
                    <div class="overflow-hidden mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Nueva Cotización
                                </h3>
                                <button x-on:click="showCreateQuoteModal = false" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">
                                        Cerrar ventana
                                    </span>
                                </button>
                            </div>
                            <form wire:submit.prevent="" class="p-4 md:p-5">
                                <!-- Form fields here -->
                                <div class="w-full mx-auto bg-white dark:bg-gray-700 ">
                                    <div class="grid gap-3 mb-3 lg:grid-cols-6">
                                        <div class="col-span-3">
                                            <label for="user" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Usuario:</label>
                                            <input type="text" id="user" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{$user->name}}" disabled>
                                        </div>
                                        <div class="col-span-3">
                                            <label for="dueDate" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Fecha documento:</label>
                                            <input type="text" id="dueDate" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{date('d/m/Y')}}" disabled>
                                        </div>
                                        <div class="col-span-2">
                                            <label for="Nomina" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Número de nómina:</label>
                                            <input wire:model.defer='RQNomina' type="text" minlength="5" maxlength="5" id="Nomina" name="Nomina" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej. 12345" required>
                                        </div>
                                        <div class="col-span-2">
                                            <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que Solicita:</label>
                                            <select wire:model.defer="RQCostCenter_id" name="CostCenter_id" id="CostCenter_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="">Seleccione un Centro de Costos</option>
                                                @foreach($costCenters as $costCenter)
                                                    <option value="{{ $costCenter->id }}">{{ $costCenter->name }} - {{ $costCenter->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-span-2">
                                            <label for="Project_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Proyecto:</label>
                                            <select wire:model.defer="RQProject_id" name="RQProject_id" id="RQProject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="">Seleccione un proyecto</option>
                                                @foreach($projects as $project)
                                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-span-6">
                                            <label for="RQdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comentarios (Breve explicación de lo que se solicita en la cotización)</label>
                                            <textarea wire:model.defer="RQdescription" name="RQdescription" id="RQdescription" minlength="10" maxlength="300" rows="2" id="RQdescription" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba una brebe explicación de la solicitud" required> </textarea>
                                        </div>
                                    </div>
                                </div>
                                <button 
                                    wire:click="createQuote" 
                                    wire:loading.attr="disabled" 
                                    type="submit" 
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                    <span wire:loading.remove wire:target="createQuote">Siguiente</span>
                                    <span wire:loading wire:target="createQuote">Guardando...</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
        @if ($selectedRQ)
            <button  x-on:click="showLinesQuoteModal = true" wire:loading.attr="disabled" class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                {{ __('messages.detalle') }}
            </button>
            <button x-on:click="showHistoryModal = true" wire:loading.attr="disabled" class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                {{ __('messages.historial') }}
            </button>
            <button x-on:click="showConfirmCancelQuoteModal = true" wire:loading.attr="disabled" class="col-span-1 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded my-2">
                {{ __('messages.cancelar') }}
            </button>
        @endif

    </div>
    
    <p>Hola 1 </p>

    <p id="id_text_2">Hola 2 </p>
    <button id="id_Bttn_2">Click me to hide paragraphs</button>

    <p class="Class_text_3">Hola 3 </p>
    <button class="Class_Bttn_3">Click me to hide paragraphs</button>
    {{-- <button>Click me to hide paragraphs</button> --}}
    <br>
    <button id="id_bttn_show">Click me to hide paragraphs</button>
    <script>
        // $(document).ready(fucntion(){
        //     $("buttnon").click(function)
        // });
        $(document).ready(function(){
            $("#id_Bttn_2").dblclick(function(){
                $("#id_text_2").hide();
            });
        });
        $(document).ready(function(){
            $(".Class_Bttn_3").click(function(){
                $(".Class_text_3").hide();
            });
        });
        $(document).ready(function(){
            $("#id_bttn_show").click(function(){
                $("p").show();
            });
        });
        // $("#id_text_2").mouseenter(function(){
        //     alert("TEXTO 2 EXITO");
        // });
        $("#id_text_2").mouseleave(function(){
            alert("TEXTO 2 ADIOS");
        });
        $(document).ready(function(){
            $("p").dblclick(function(){
                $(this).hide();
            });
        });
        
    </script>
    

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
                            <span class="mr-1">Fecha<br>Creado</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Fecha ultima <br>Actualización</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 uppercase dark:bg-gray-800">
                    @foreach ($requestQuotes as $RQ)
                        <tr x-on:click="$wire.selectRQ({{ $RQ->id }})"  class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedRQ && $selectedRQ->id == $RQ->id)  bg-green-200 dark:bg-gray-500 @endif">
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
                                        NO ASIGNADO
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
                                @if( $RQ->ApprovatePresident )
                                    <span class="assigned description-cell">
                                        FINALIZADA
                                    </span>
                                @elseif($RQ->StatusList_id == 24 )
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
                                        NO GENEADO
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
    <div class="px-4 py-3 rounded-md text-sm text-center font-semibold text-gray-700 uppercase bg-white sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span>{{ __('messages.noSeHanEncontradoDatos') }}</span>
    </div>
    @endif

    <!-- Create Quote Modal -->
    <div 
        x-show="showCreateQuoteModal" 
        @click.away="showCreateQuoteModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        style="display: none;"
        >
        <div class="overflow-hidden mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Nueva Cotización
                    </h3>
                    <button x-on:click="showCreateQuoteModal = false" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">
                            Cerrar ventana
                        </span>
                    </button>
                </div>
                <form wire:submit.prevent="" class="p-4 md:p-5">
                    <!-- Form fields here -->
                    <div class="w-full mx-auto bg-white dark:bg-gray-700 ">
                        <div class="grid gap-3 mb-3 lg:grid-cols-6">
                            <div class="col-span-3">
                                <label for="user" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Usuario:</label>
                                <input type="text" id="user" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{$user->name}}" disabled>
                            </div>
                            <div class="col-span-3">
                                <label for="dueDate" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Fecha documento:</label>
                                <input type="text" id="dueDate" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{date('d/m/Y')}}" disabled>
                            </div>
                            <div class="col-span-2">
                                <label for="Nomina" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Número de nómina:</label>
                                <input wire:model.defer='RQNomina' type="text" minlength="5" maxlength="5" id="Nomina" name="Nomina" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej. 12345" required>
                            </div>
                            <div class="col-span-2">
                                <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que Solicita:</label>
                                <select wire:model.defer="RQCostCenter_id" name="CostCenter_id" id="CostCenter_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un Centro de Costos</option>
                                    @foreach($costCenters as $costCenter)
                                        <option value="{{ $costCenter->id }}">{{ $costCenter->name }} - {{ $costCenter->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-span-2">
                                <label for="Project_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Proyecto:</label>
                                <select wire:model.defer="RQProject_id" name="RQProject_id" id="RQProject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un proyecto</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="RQdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comentarios (Breve explicación de lo que se solicita en la cotización)</label>
                                <textarea wire:model.defer="RQdescription" name="RQdescription" id="RQdescription" minlength="10" maxlength="300" rows="2" id="RQdescription" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba una brebe explicación de la solicitud" required> </textarea>
                            </div>
                        </div>
                    </div>
                    <button 
                        {{-- wire:click="createQuote"  --}}
                        x-on:click="$wire.createQuote()"
                        wire:loading.attr="disabled" 
                        type="submit" 
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        <span wire:loading.remove wire:target="createQuote">Siguiente</span>
                        <span wire:loading wire:target="createQuote">Guardando...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
        

    
    <!-- Create Quote Modal -->
    <div 
        x-show="confirmCancelQuoteModal" 
        @click.away="confirmCancelQuoteModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        style="display: none;"
        >               
    {{-- <div id="confirmCancelQuoteModal" tabindex="-1" aria-hidden="true" @if ($showConfirmCancelQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"> --}}
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button x-on:click="showConfirmCancelQuoteModal = false" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres cancelar esta cotización?</h3>
                    <button wire:click="CancelQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        <span wire:loading.remove wire:target="CancelQuote">Si, seguro.</span>
                        <span wire:loading wire:target="CancelQuote">Guardando...</span>
                    </button>
                    <button wire:click="$set('showConfirmCancelQuoteModal',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="confirmSelectQuoteModal" tabindex="-1" aria-hidden="true" @if ($showConfirmSelectQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="set('showConfirmCancelQuoteModal',true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quiere Seleccionar estas Cotizaciones?</h3>
                    <button wire:click="CancelQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="set('showConfirmCancelQuoteModal',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div> --}}


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
                            RFQ: {{ $selectedRQ->RFQ}} - Selección de Cotizaciones
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
                    <button wire:click="$set('showLinesQuoteModal',true)" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <div class="w-full mx-auto bg-white dark:bg-gray-700 ">
                        @if ($selectedRQ && $RQLines)
                            <table>
                                <thead></thead>
                                <tbody>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Descripción:</strong> {{ $selectedRQ->description }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Usuario</strong> {{ $selectedRQ->UserName }}
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
                                        @if ($selectedRQ->remarks2)
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Motivo Rechazo:</strong> {{ $selectedRQ->remarks1 }}
                                            </p>
                                        @endif  
                                        @if ($selectedRQ->remarks3)
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
                                                    @if ($RQL->imgPath)
                                                    <td class="px-4 py-3 description-cell">
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            @if ($selectedRQ && $selectedRQLine && $selectedRQ->StatusList_id >= 6)
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
                                                        <th  class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                            <span class="mr-1">Proveedor</span>
                                                        </th>
                                                        <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                            <span class="mr-1">Precio</span>
                                                        </th>
                                                        <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                                                            <span class="mr-1">Días de entrega</span>
                                                        </th>
                                                        <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 description-cell">
                                                            <span class="mr-1">Comentarios</span>
                                                        </th>
                                                    </atr>
                                                </thead>
                                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                                    @foreach ($quotes as $quote)
                                                        {{-- <tr wire:click="selectQuote({{ $quote->id }})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 @if($selectedQuote && $selectedQuote->id == $quote->id)  bg-green-200 dark:bg-gray-500 @endif"> --}}
                                                        {{-- <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">@if($quote->id == $quote->quoteLine->Quote_id) bg-green-200 dark:bg-gray-500 @endif --}}
                                                        <tr class="text-gray-700 dark:text-gray-400 @if($quote->id == $quote->quoteLine->Quote_id) bg-blue-200 dark:bg-blue-500 @endif">
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
                                                    </atr>
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
                                                        {{$selectedRQ->UserName}}
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
                                                <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprobación Comprador:</label>
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprobación Gerente Compras:</label>
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font- text-gray-900 dark:text-gray-300">Aprobación Vicepresidente:</label>
                                            </div>
                                            <div class="col-span-2">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprobación Presidente:</label>
                                            </div> 
                                        </div>
                                    </div>
                                    <br>
                                @endif
                            @endif
                        @endif
                    @endif
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
                    @if ($selectedRQ && ($selectedRQ->statusList->id == 1 || $selectedRQ->statusList->id == 38 || $selectedRQ->statusList->id == 37 || $selectedRQ->statusList->id == 10))
                        <button wire:click="OpenModalUpdateLineQuote('create')" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="OpenModalUpdateLineQuote('create')">Añadir Línea</span>
                            <span wire:loading wire:target="OpenModalUpdateLineQuote('create')">Cargando...</span>
                        </button>
                        @if ($RQLines)
                            @if ($RQLines->count() != 0)
                                @if ($selectedRQLine)
                                    <button wire:click="OpenModalUpdateLineQuote('edit')" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <span wire:loading.remove wire:target="OpenModalUpdateLineQuote('edit')">Editar</span>
                                        <span wire:loading wire:target="OpenModalUpdateLineQuote('edit')">Cargando...</span>
                                    </button>
                                    <button wire:click="$set('showConfirmDeleteLineQuoteModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <span wire:loading.remove wire:target="$set('showConfirmDeleteLineQuoteModal',false)">Eliminar</span>
                                        <span wire:loading wire:target="$set('showConfirmDeleteLineQuoteModal',false)">Cargando...</span>
                                    </button>
                                @endif
                                <button wire:click="$set('showConfirmSendQuoteBuyerModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <span wire:loading.remove wire:target="$set('showConfirmSendQuoteBuyerModal',false)">Enviar a Compras</span>
                                    <span wire:loading wire:target="$set('showConfirmSendQuoteBuyerModal',false)">Cargando...</span>
                                </button>
                            @endif
                        @endif
                    @endif
                    @if ($selectedRQLine != null && ($selectedRQ->statusList->id == 6 || $selectedRQ->statusList->id == 7))
                        <div class="col-span-3">
                            <label for="selectedQuote" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Elija una cotización:</label>
                            <select wire:model="selectedQuote" name="selectedQuote" id="selectedQuote" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option selected value="">Cotización (Precio /Fecha Llegada/ Proveedor)</option>
                                @foreach ($quotes as $QU)
                                    <option value="{{$QU->id}}"> {{ round($QU->Cost,4) }} {{$QU->currency->name}} - {{$QU->supplier->VNDNAM}} </option>
                                @endforeach
                            </select>
                        </div>
                        <button wire:click="selectedQuoteForRequisition" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="selectedQuoteForRequisition">Seleccionar Cotización</span>
                            <span wire:loading wire:target="selectedQuoteForRequisition">Cargando...</span>
                        </button>
                    @endif
                    @if ($selectedRQ && $selectedRQ->statusList->id == 7 )
                    <button wire:click="$set('showConfirmSelectionQuoteModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span wire:loading.remove wire:target="$set('showConfirmSelectionQuoteModal',false)">Confirmar Cotización</span>
                        <span wire:loading wire:target="$set('showConfirmSelectionQuoteModal',false)">Cargando...</span>
                    </button>
                @endif
                    @if ($selectedRQ && $selectedRQ->statusList->id == 8 )
                        <button wire:click="$set('showConfirmGenerateRequisitionModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="$set('showConfirmGenerateRequisitionModal',false)">Generar Requisición</span>
                            <span wire:loading wire:target="$set('showConfirmGenerateRequisitionModal',false)">Cargando...</span>
                        </button>
                    @endif
                    {{-- <div class="w-full mx-auto bg-white dark:bg-gray-700 "> --}}
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
                        Editar Línea
                    @endif
                    <button wire:click="$set('showUpdateLineQuoteModal',true)" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="" class="p-4 md:p-5">
                    <!-- component -->
                    <!-- This is an example component -->
                    <div class="w- mx-auto bg-white dark:bg-gray-700 ">
                        <div class="grid gap-3 mb-3 lg:grid-cols-4">
                            {{-- <div class="col-span-1">
                                <label for="Search_CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Buscar Centrod de costos:</label>
                                <input wire:model="Search_CostCenter_id" type="text" maxlength="50" id="Search_CostCenter_id" name="Search_CostCenter_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                            </div>
                            <div class="col-span-3">
                                <label for="Search_RQLItem_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Buscar Item:</label>
                                <input wire:model="Search_RQLItem_id" type="text"maxlength="50" id="Search_RQLItem_id" name="Search_RQLItem_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div> --}}
                            <div class="col-span-1">
                                <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que usara:</label>
                                <select wire:model.defer="RQLCostCenter_id" name="CostCenter_id" id="CostCenter_id" @if($selectedRQ) value="{{$RQLCostCenter_id}}" @endif class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un Centro de Costos</option>
                                    @foreach($costCenters as $costCenter)
                                        <option value="{{ $costCenter->id }}">{{ $costCenter->name }} - {{ $costCenter->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label for="RQLItem_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Item:</label>
                                <select wire:model="RQLItem_id" name="Item_id" id="Item_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" >Seleccione un Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (!$RQLItem_id)
                                <div class="col-span-3">
                                    <label for="name" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Concepto del material o servicio:</label>
                                    <input wire:model.lazy="RQLname" type="text" minlength="10" maxlength="50" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>
                            @endif
                            <div class="col-span-1">
                                <label for="RQLquantity" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Cantidad:</label>
                                <input wire:model.defer="RQLquantity" type="number" id="quantity" name="quantity" min="1" max="10000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            @if (!$RQLItem_id)
                                <div class="col-span-3">
                                    <label for="RQLdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Descripción (añada caracteristicas adicionales del material o servicio):</label>
                                    <textarea wire:model.lazy="RQLdescription" name="RQLdescription"  id="RQLdescription" minlength="10" maxlength="300" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required> </textarea>
                                </div>
                            @endif
                            <div class="col-span-1">
                                <label for="RQLdateRequired" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha en que se requiere:</label>
                                <input wire:model.defer="RQLdateRequired" type="date" id="RQLdateRequired" name="RQLdateRequired" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        required min="{{ now()->format('Y-m-d') }}">
                            </div>
                            @if (!$RQLItem_id)
                                <div class="col-span-1">
                                    <label for="RQL_imgPath" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Imagen:</label>
                                    <input wire:model.defer="RQL_imgPath" type="file" id="RQL_imgPath" name="RQL_imgPath" accept=".png, .jpg, .jpeg, .zip, .rar, .pdf," class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @error('RQL_imgPath') <span class="error">{{ $message }}</span> @enderror
                                </div>
                            @endif
                            @if (!$RQLItem_id)
                                <div class="col-span-1">
                                    <label for="MeasurementUnit_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Unidad de Medida:</label>
                                    <select wire:model.defer="RQLMeasurementUnit_id" name="MeasurementUnit_id" id="MeasurementUnit_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="">Seleccione unidad de medida</option>
                                        @foreach($measurementUnits as $measurementUnit)
                                            <option value="{{ $measurementUnit->id }}">{{ $measurementUnit->name }} - {{ $measurementUnit->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
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
                    @if ($modeLine == "create")
                        <button wire:click="createLineQuote" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="createLineQuote">Guardar</span>
                            <span wire:loading wire:target="createLineQuote">Cargando...</span>
                        </button>
                    @endif
                    @if ($modeLine == "edit")
                        <button wire:click="EditLineQuote('edit')" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="EditLineQuote('edit')">Guardar</span>
                            <span wire:loading wire:target="EditLineQuote('edit')">Cargando...</span>
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div id="confirmSendQuoteToBuyerModal" tabindex="-1" aria-hidden="true" @if ($showConfirmSendQuoteBuyerModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmSendQuoteBuyerModal',true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
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
                    <button wire:click="sendQuoteToBuyer" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        <span wire:loading.remove wire:target="sendQuoteToBuyer">Si, seguro</span>
                        <span wire:loading wire:target="sendQuoteToBuyer">Cargando...</span>
                    </button>
                    <button wire:click="$set('showConfirmSendQuoteBuyerModal',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmDeleteLineQuoteModal" tabindex="-1" aria-hidden="true" @if ($showConfirmDeleteLineQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmDeleteLineQuoteModal',true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres eliminar este registro?</h3>
                    <button wire:click="DeleteLineQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        <span wire:loading.remove wire:target="DeleteLineQuote">Si, seguro</span>
                        <span wire:loading wire:target="DeleteLineQuote">Cargando...</span>
                    </button>
                    <button wire:click="$set('showConfirmDeleteLineQuoteModal',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- show Confirm Selection Cotizacin  Modal -->
    <div id="confirmSendQuoteToBuyerModal" tabindex="-1" aria-hidden="true" @if ($showConfirmSelectionQuoteModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmSelectionQuoteModal',true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres confirmar estas cotizaciones? No podra cambiar las cotizaciones poesteriormente</h3>

                    <button wire:click="SelectionQuote" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        <span wire:loading.remove wire:target="SelectionQuote">Si, seguro</span>
                        <span wire:loading wire:target="SelectionQuote">Cargando...</span>
                    </button>
                    <button wire:click="$set('showConfirmSelectionQuoteModal',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- show Confirm Generate Requisition Modal -->
    <div id="confirmSendQuoteToBuyerModal" tabindex="-1" aria-hidden="true" @if ($showConfirmGenerateRequisitionModal) style="display:none" @endif class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="$set('showConfirmGenerateRequisitionModal',true)" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro que quieres generara la requisición?</h3>

                    <button wire:click="generateRequisition" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        <span wire:loading.remove wire:target="generateRequisition">Si, seguro</span>
                        <span wire:loading wire:target="generateRequisition">Cargando...</span>
                    </button>
                    <button wire:click="$set('showConfirmGenerateRequisitionModal',true)"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
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


{{-- <!-- Incluye jQuery en tu plantilla -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadRequestQuotes() {
            $.ajax({
                url: "{{ route('getRequestQuotes') }}",
                method: "GET",
                data: {
                    searchRQ: $('#searchRQ').val(),
                    selectedRQStatus: $('#selectedRQStatus').val(),
                    startDate: $('#startDate').val(),
                    endDate: $('#endDate').val(),
                    selectedRQOrderBy: '{{ $selectedRQOrderBy }}',
                    selectedRQOrder: '{{ $selectedRQOrder }}',
                    perPage: $('#perPage').val()
                },
                success: function(data) {
                    $('#requestQuotesTable tbody').empty();
                    $.each(data.data, function(index, RQ) {
                        $('#requestQuotesTable tbody').append(`
                            <tr onclick="selectRQ(${RQ.id})" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-3">${RQ.RFQ}</td>
                                <td class="px-4 py-3">${RQ.UserName}</td>
                                <td class="px-4 py-3">${RQ.statusList.name}</td>
                                <td class="px-4 py-3">${RQ.buyer ? RQ.buyer.PBNAM : 'NO ASIGNADO'}</td>
                                <td class="px-4 py-3">${RQ.commodity ? RQ.commodity.PCCOM : 'NO ASIGNADO'}</td>
                                <td class="px-4 py-3">${RQ.created_at}</td>
                                <td class="px-4 py-3">${RQ.updated_at}</td>
                            </tr>
                        `);
                    });
                    $('#pagination').html(data.links);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $('#searchRQ, #selectedRQStatus, #startDate, #endDate, #perPage').change(function() {
            loadRequestQuotes();
        });

        // Load quotes on page load
        loadRequestQuotes();
    });

    function selectRQ(RQ_id) {
        $.ajax({
            url: "{{ route('getRequestQuotes') }}",
            method: "GET",
            data: {
                id: RQ_id
            },
            success: function(data) {
                // Handle the selected RQ details here
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script> --}}
