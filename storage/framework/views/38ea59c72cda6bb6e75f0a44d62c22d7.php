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
                                <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->id); ?>" <?php echo e($state->id == $selectedRQStatus ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <span class="flex items-center justify-end col-span-1 text-gray-700 dark:text-gray-300">
            <?php echo e(__('messages.mostrando')); ?>:
        </span>
        <select  wire:model="perPage" name="Status" id="Status" class="col-span-1 block py-1 px-2 rounded my-2 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray">
            <option value="" disabled>Seleccione la pagianación</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
        </select>
        <div >
            <div x-data="{ showCreateQuoteModal: <?php if ((object) ('showCreateQuoteModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showCreateQuoteModal'->value()); ?>')<?php echo e('showCreateQuoteModal'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('showCreateQuoteModal'); ?>')<?php endif; ?> }">
                <!-- Button to open modal -->
                <button x-on:click="showCreateQuoteModal = true" wire:loading.attr="disabled" class="col-span-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                    <?php echo e(__('messages.nuevaCotizacion')); ?>

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
                                            <input type="text" id="user" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="<?php echo e($user->name); ?>" disabled>
                                        </div>
                                        <div class="col-span-3">
                                            <label for="dueDate" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Fecha documento:</label>
                                            <input type="text" id="dueDate" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo e(date('d/m/Y')); ?>" disabled>
                                        </div>
                                        <div class="col-span-2">
                                            <label for="Nomina" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Número de nómina:</label>
                                            <input wire:model.defer='RQNomina' type="text" minlength="5" maxlength="5" id="Nomina" name="Nomina" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej. 12345" required>
                                        </div>
                                        <div class="col-span-2">
                                            <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que Solicita:</label>
                                            <select wire:model.defer="RQCostCenter_id" name="CostCenter_id" id="CostCenter_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="">Seleccione un Centro de Costos</option>
                                                <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($costCenter->id); ?>"><?php echo e($costCenter->name); ?> - <?php echo e($costCenter->description); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-span-2">
                                            <label for="Project_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Proyecto:</label>
                                            <select wire:model.defer="RQProject_id" name="RQProject_id" id="RQProject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                                <option value="">Seleccione un proyecto</option>
                                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <?php if($selectedRQ): ?>
            <button  x-on:click="showLinesQuoteModal = true" wire:loading.attr="disabled" class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                <?php echo e(__('messages.detalle')); ?>

            </button>
            <button x-on:click="showHistoryModal = true" wire:loading.attr="disabled" class="col-span-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">
                <?php echo e(__('messages.historial')); ?>

            </button>
            <button x-on:click="showConfirmCancelQuoteModal = true" wire:loading.attr="disabled" class="col-span-1 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded my-2">
                <?php echo e(__('messages.cancelar')); ?>

            </button>
        <?php endif; ?>

    </div>
    
    <p>Hola 1 </p>

    <p id="id_text_2">Hola 2 </p>
    <button id="id_Bttn_2">Click me to hide paragraphs</button>

    <p class="Class_text_3">Hola 3 </p>
    <button class="Class_Bttn_3">Click me to hide paragraphs</button>
    
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
    

    
    <div class="py-2">
        <?php if(session('success')): ?>
            <div  id="alertMessage" role="alert" class="rounded-xl border border-gray-100 bg-white p-4">
                <div class="flex items-start gap-4">
                    <span class="text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <div class="flex-1">
                        <strong class="block font-medium text-gray-900">¡¡Exito!!</strong>
                        <p class="mt-1 text-sm text-gray-700"><?php echo e(session('success')); ?></p>
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
        <?php elseif(session('error')): ?>
            <div id="alertMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo e(session('error')); ?></span>
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
        <?php endif; ?>
    </div>

    
    <?php if($requestQuotes->count()): ?>
    
        
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <?php if($selectedRQOrderBy == 'RFQ' && $selectedRQOrder == 'ASC'): ?>
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">
                                RFQ
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M6 9l6 6l6 -6" />
                            </svg>
                        </th>
                        <?php elseif($selectedRQOrderBy == 'RFQ' && $selectedRQOrder === 'DESC'): ?>
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                        </th>
                        <?php else: ?>
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                        </th>
                        <?php endif; ?>
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
                        
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Fecha<br>Creado</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Fecha ultima <br>Actualización</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 uppercase dark:bg-gray-800">
                    <?php $__currentLoopData = $requestQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $RQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr x-on:click="$wire.selectRQ(<?php echo e($RQ->id); ?>)"  class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 <?php if($selectedRQ && $selectedRQ->id == $RQ->id): ?>  bg-green-200 dark:bg-gray-500 <?php endif; ?>">
                            
                            <td class="px-4 py-3 description-cell">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->
                                    <div>
                                        <p ><?php echo e($RQ->RFQ); ?></p>                                        
                                    </div>
                                </div>
                            </td> 
                            <td class="px-4 py-3 text-xs description-cell">
                                <p ><?php echo e($RQ->UserName); ?></p>
                            </td>  
                            <td class="px-4 py-2 text-xs">
                                <?php if($RQ->StatusList_id == 39): ?>
                                <span class="not-assigned description-cell">
                                    <?php echo e($RQ->statusList->name); ?>

                                </span>
                                <?php else: ?>
                                <span class="assigned description-cell">
                                    <?php echo e($RQ->statusList->name); ?>

                                </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php if( $RQ->Buyer_id ): ?>
                                    <span class="assigned description-cell">
                                        <?php echo e($RQ->buyer->PBNAM); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="ni-assigned description-cell">
                                        NO ASIGNADO
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs ">
                                <?php if( $RQ->ApprovateUser && $RQ->ApprovateLines && $RQ->ManagerApprovate ): ?>
                                    <span class="assigned description-cell">
                                        FINALIZADA
                                    </span>
                                <?php elseif( $RQ->ApprovateUser && $RQ->ApprovateLines ): ?>
                                    <span class=" not-assigned description-cell">
                                        PENDIENTE APROBACIÓN GERENTE DEP. SOLICITA
                                    </span>
                                <?php elseif($RQ->ApprovateUser): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE DE APROBACIÓN DE LÍNEAS
                                    </span>   
                                <?php else: ?>
                                    <span class="ni-assigned description-cell">
                                        NO APLICA
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs  ">
                                <?php if( $RQ->Commodity_id ): ?>
                                    <span class="assigned description-cell">
                                        <?php echo e($RQ->commodity->PCCOM); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="ni-assigned description-cell">
                                        NO ASIGNADO
                                    </span>
                                <?php endif; ?>
                            </td>
                            <?php
                                $RI = App\Models\RequestInvestment::where('RequestQuote_id',$RQ->id)->first();
                            ?>
                            <td class="px-4 py-2 text-xs">
                                <?php if( $RI && $RI->StatusList_id == 35 ): ?>
                                    <span class="assigned description-cell">
                                        APROBADA
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 31 ): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN FINANZAS
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 30 ): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN PRESIDENTE
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 29 ): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN VICEPRESIDENTE
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 22 ): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN GERENTE COMPRAS
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 21 ): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN GERENTE DEP. SOLICITA
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 47 ): ?>
                                    <span class="not-assigned description-cell">
                                        RECHAZA PRESIDENTE
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 46 ): ?>
                                    <span class="not-assigned description-cell">
                                        RECHAZA VICEPRESIDENTE
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 45 ): ?>
                                    <span class="not-assigned description-cell">
                                        RECHAZA GERENTE DE COMPRAS
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 44 ): ?>
                                    <span class="not-assigned description-cell">
                                        RECHAZA PLANEACIÓN CORPORATIVA
                                    </span>
                                <?php elseif( $RI && $RI->StatusList_id == 43 ): ?>
                                    <span class="not-assigned description-cell">
                                        RECHAZA GERENTE DEL DEP. SOLICITANTE
                                    </span>
                                <?php else: ?>
                                    <span class="ni-assigned description-cell">
                                        NO APLICA
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php if( $RQ->ApprovatePresident ): ?>
                                    <span class="assigned description-cell">
                                        FINALIZADA
                                    </span>
                                <?php elseif($RQ->StatusList_id == 24 ): ?>
                                    <span class="not-assigned description-cell">
                                        PENDINTE APROBACIÓN DE PRESIDENTE
                                    </span>
                                <?php elseif($RQ->ApprovatePODirector): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN DE VICEPRESIDENTE
                                    </span>
                                <?php elseif($RQ->ApprovatePOBuyer == 1): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN DE GERENTE COMPRAS
                                    </span>
                                <?php elseif($RQ->StatusList_id == 18): ?>
                                    <span class="not-assigned description-cell">
                                        PENDIENTE APROBACIÓN DE COMPRADOR
                                    </span>
                                <?php else: ?>
                                    <span class="ni-assigned description-cell">
                                        NO GENEADO
                                    </span>    
                                <?php endif; ?>
                            </td>
                            
                            <td class="px-4 py-2 text-xs">
                                <?php echo e(Carbon\Carbon::parse($RQ->created_at)->format('d-m-Y')); ?>

                                <br>
                                <?php echo e(Carbon\Carbon::parse($RQ->created_at)->format('H:m:s')); ?>

                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php echo e(Carbon\Carbon::parse($RQ->updated_at)->format('d-m-Y')); ?>

                                <br>
                                <?php echo e(Carbon\Carbon::parse($RQ->updated_at)->format('H:m:s')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="flex items-center col-span-3">
                    <?php echo e(__('Mostrando')); ?> <?php echo e($requestQuotes->firstItem()); ?> - <?php echo e($requestQuotes->lastItem()); ?> <?php echo e(__('de')); ?> <?php echo e($requestQuotes->total()); ?>

                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                    <nav aria-label="Table navigation">
                        <?php echo e($requestQuotes->withQueryString()->links()); ?>

                    </nav>
                </span>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="px-4 py-3 rounded-md text-sm text-center font-semibold text-gray-700 uppercase bg-white sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span><?php echo e(__('messages.noSeHanEncontradoDatos')); ?></span>
    </div>
    <?php endif; ?>

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
                                <input type="text" id="user" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="<?php echo e($user->name); ?>" disabled>
                            </div>
                            <div class="col-span-3">
                                <label for="dueDate" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Fecha documento:</label>
                                <input type="text" id="dueDate" class="bg-gray-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-500 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="<?php echo e(date('d/m/Y')); ?>" disabled>
                            </div>
                            <div class="col-span-2">
                                <label for="Nomina" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Número de nómina:</label>
                                <input wire:model.defer='RQNomina' type="text" minlength="5" maxlength="5" id="Nomina" name="Nomina" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ej. 12345" required>
                            </div>
                            <div class="col-span-2">
                                <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que Solicita:</label>
                                <select wire:model.defer="RQCostCenter_id" name="CostCenter_id" id="CostCenter_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un Centro de Costos</option>
                                    <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($costCenter->id); ?>"><?php echo e($costCenter->name); ?> - <?php echo e($costCenter->description); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            
                            <div class="col-span-2">
                                <label for="Project_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Proyecto:</label>
                                <select wire:model.defer="RQProject_id" name="RQProject_id" id="RQProject_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un proyecto</option>
                                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($project->id); ?>"><?php echo e($project->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="RQdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Comentarios (Breve explicación de lo que se solicita en la cotización)</label>
                                <textarea wire:model.defer="RQdescription" name="RQdescription" id="RQdescription" minlength="10" maxlength="300" rows="2" id="RQdescription" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escriba una brebe explicación de la solicitud" required> </textarea>
                            </div>
                        </div>
                    </div>
                    <button 
                        
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

    


    <!-- View Lines Quote Modal -->
    <div id="ViewLinesQuoteModal" tabindex="-1" aria-hidden="true" <?php if($showLinesQuoteModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
        
            <!-- Modal content -->
            <div class="relative bg-white w-full rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <!-- Header content goes here -->
                    <?php if( $selectedRQ && $selectedRQ->statusList->id == 1 ): ?>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            RFQ: <?php echo e($selectedRQ->RFQ); ?> - Ingreso de Lineas.
                        </h3>
                    <?php elseif( $selectedRQ && $selectedRQ->statusList->id == 6 ): ?>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            RFQ: <?php echo e($selectedRQ->RFQ); ?> - Selección de Cotizaciones
                        </h3>
                    <?php elseif( $selectedRQ && $selectedRQ->statusList->id == 7 ): ?>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            RFQ: <?php echo e($selectedRQ->RFQ); ?> - Cotización
                        </h3>
                    <?php elseif( $selectedRQ && $selectedRQ->statusList->id == 9 ): ?>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            RFQ: <?php echo e($selectedRQ->RFQ); ?> - Requesición
                        </h3>
                    <?php elseif( $selectedRQ && $selectedRQ->statusList->id == 10 ): ?>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            RFQ: <?php echo e($selectedRQ->RFQ); ?> - P.O.
                        </h3>
                    <?php else: ?>
                        <?php if( $selectedRQ ): ?>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                RFQ: <?php echo e($selectedRQ->RFQ); ?> - Detalles
                            </h3>
                        <?php endif; ?>
                    <?php endif; ?>
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
                        <?php if($selectedRQ && $RQLines): ?>
                            <table>
                                <thead></thead>
                                <tbody>
                                    <td>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Descripción:</strong> <?php echo e($selectedRQ->description); ?>

                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Usuario</strong> <?php echo e($selectedRQ->UserName); ?>

                                        </p>
                                        <?php if($selectedRQ->Commodity_id): ?>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Commodity:</strong> <?php echo e($selectedRQ->commodity->PCCOM); ?>

                                            </p>
                                        <?php else: ?>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Commodity:</strong> No asignado.
                                            </p>
                                        <?php endif; ?>
                                        <?php if($selectedRQ->WorkNumber): ?>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Número de Obra:</strong> <?php echo e($selectedRQ->WorkNumber); ?>

                                            </p>
                                        <?php endif; ?>
                                        <?php if($selectedRQ->remarks1): ?>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Motivo Rechazo:</strong> <?php echo e($selectedRQ->remarks1); ?>

                                            </p>
                                        <?php endif; ?>  
                                        <?php if($selectedRQ->remarks2): ?>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Motivo Rechazo:</strong> <?php echo e($selectedRQ->remarks1); ?>

                                            </p>
                                        <?php endif; ?>  
                                        <?php if($selectedRQ->remarks3): ?>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                <strong>Motivo Rechazo:</strong> <?php echo e($selectedRQ->remarks1); ?>

                                            </p>
                                        <?php endif; ?>  
                                    </td>
                                    <td>
                                        <?php if($selectedRQ->TotalCostMXN): ?>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Total MXN:</strong> $<?php echo e(round($selectedRQ->TotalCostMXN,4)); ?>

                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Total USD:</strong> $<?php echo e(round($selectedRQ->TotalCostUSD,4)); ?>

                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            <strong>Total JPY:</strong> ¥<?php echo e(round($selectedRQ->TotalCostJPY,4)); ?>

                                        </p>
                                        <?php endif; ?>
                                    </td>
                                </tbody>
                            </table>
                            <br>
                            <?php if($RQLines->count() == 0): ?>
                                <div class="flex justify-center items-center">
                                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            ¡Aún no se han añadido líneas!
                                        </h4>
                                    </div>
                                </div>
                            <?php else: ?>
                            <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                <strong>Lineas:</strong>
                            </p>
                            
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
                                                <?php if($selectedRQ->StatusList_id >= 8 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37 ): ?>
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
                                                <?php endif; ?>
                                                <?php if($selectedRQ->StatusList_id < 8 || $selectedRQ->StatusList_id == 38 || $selectedRQ->StatusList_id == 37  ): ?>
                                                <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Estatus</span>
                                                </th>
                                                <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                                                    <span class="mr-1">Fecha <br>Requerida</span>
                                                </th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                            <?php $__currentLoopData = $RQLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $RQL): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr wire:click="selectRQLine(<?php echo e($RQL->id); ?>)" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 <?php if($selectedRQLine && $selectedRQLine->id == $RQL->id): ?>  bg-green-200 dark:bg-gray-500 <?php endif; ?>">
                                                    <td class="px-4 py-2 text-xs whitespace-pre-line">
                                                        <?php echo e($RQL->costCenter->name); ?> - <?php echo e($RQL->costCenter->description); ?>

                                                    </td>
                                                    <?php if($RQL->imgPath): ?>
                                                    <td class="px-4 py-3 description-cell">
                                                        <div class="flex items-center text-sm">
                                                            <!-- Avatar with inset shadow -->
                                                            <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                                <img class="object-cover w-full h-full rounded-full"
                                                                    src="<?php echo e(Storage::url('items/' . $RQL->imgPath)); ?>"
                                                                    alt="<?php echo e($RQL->name); ?>"
                                                                    />
                                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                            </div>
                                                            <div>
                                                                <p class="font-semibold"><?php echo e($RQL->name); ?></p>
                                                                <!-- Enlace de descarga -->
                                                                <?php if($RQL->imgPath): ?>    
                                                                <a href="<?php echo e(route('Configuration.Items.download', ['filename' => $RQL->imgPath])); ?>"
                                                                    class="text-blue-600 hover:underline"
                                                                    download>
                                                                    Descargar
                                                                </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>   
                                                    <?php else: ?>
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        <?php echo e($RQL->name); ?>

                                                    </td>
                                                    <?php endif; ?>
                                                    <td class="px-4 py-2 text-xs description-cell">
                                                        <?php echo e($RQL->description); ?>

                                                    </td>
                                                    <td class="px-4 py-2 text-xs">
                                                        <?php echo e($RQL->quantity); ?>

                                                    </td>
                                                    <?php if($selectedRQ->StatusList_id < 8 || $selectedRQ->StatusList_id == 38 || $selectedRQ->StatusList_id == 37 ): ?>
                                                        <td class="px-4 py-2 text-xs">
                                                            <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                                <?php echo e($RQL->statusList->name); ?>

                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-2 text-xs">
                                                            <?php echo e(Carbon\Carbon::parse($RQL->dateRequired)->format('d-m-Y')); ?>

                                                        </td>
                                                    <?php endif; ?>
                                                    
                                                    <?php if($selectedRQ->StatusList_id >= 8 && $selectedRQ->StatusList_id != 39 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37 ): ?>
                                                        <td class="px-4 py-2 text-xs description-cell">
                                                            <?php echo e($RQL->supplier->VNDNAM); ?>

                                                        </td>
                                                        <td class="px-4 py-2 text-xs">
                                                            $ <?php echo e(round($RQL->UnitCost,4)); ?> <?php echo e($RQL->currency->name); ?>

                                                        </td>
                                                        <?php if($RQL->Currency_id == 1): ?>
                                                            <td class="px-4 py-2 text-xs">
                                                                $ <?php echo e(round($RQL->TotalCostMXN,4)); ?> <?php echo e($RQL->currency->name); ?>

                                                            </td>
                                                        <?php elseif($RQL->Currency_id == 2): ?>
                                                            <td class="px-4 py-2 text-xs">
                                                                $ <?php echo e(round($RQL->TotalCostUSD,4)); ?> <?php echo e($RQL->currency->name); ?>

                                                            </td>
                                                        <?php elseif($RQL->Currency_id == 3): ?>
                                                            <td class="px-4 py-2 text-xs">
                                                                $ <?php echo e(round($RQL->TotalCostJPY,4)); ?> <?php echo e($RQL->currency->name); ?>

                                                            </td>
                                                        <?php endif; ?>
                                                        <td class="px-4 py-2 text-xs">
                                                            <span class="assigned description-cell">
                                                                <?php echo e($RQL->statusList->name); ?>

                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-2 text-xs">
                                                            <?php echo e(Carbon\Carbon::parse($RQL->dateArrival)->format('d-m-Y')); ?>

                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <?php if($selectedRQ && $selectedRQLine && $selectedRQ->StatusList_id >= 6): ?>
                                <br>
                                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                    <strong>Cotizaciónes:</strong>
                                </p>
                                <?php if(!$selectedRQLine ): ?>
                                    <br>
                                    <div class="flex justify-center items-center">
                                        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                No se ah seleccionado ninguna línea
                                            </h4>
                                        </div>
                                    </div>
                                    <br>
                                <?php else: ?>
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
                                                    <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        
                                                        <tr class="text-gray-700 dark:text-gray-400 <?php if($quote->id == $quote->quoteLine->Quote_id): ?> bg-blue-200 dark:bg-blue-500 <?php endif; ?>">
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($quote->supplier->VENDOR); ?> -<?php echo e($quote->supplier->VNDNAM); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                $ <?php echo e(round($quote->Cost,4)); ?> <?php echo e($quote->currency->name); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($quote->NumDaysArrival); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($quote->description); ?>

                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if($files && $selectedRQ->StatusList_id >= 6 ): ?>
                                <br>
                                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                    <strong>Documentos:</strong>
                                </p>
                                <?php if($files->count()>0): ?>
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
                                                    <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($file->supplier->VENDOR); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($file->supplier->VNDNAM); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($file->fileName); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <?php echo e($file->created_at); ?>

                                                            </td>
                                                            <td class="px-4 py-2 text-xs">
                                                                <a href="<?php echo e(Storage::url($file->filePath)); ?>" target="_blank">Ver documento</a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <br>
                                        <div class="flex justify-center items-center">
                                            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    No hay Documentos Adjuntos
                                                </h4>
                                            </div>
                                        </div>
                                    <br>
                                <?php endif; ?>
                                <?php if($selectedRQ->StatusList_id >=14  && $selectedRQ->StatusList_id != 39 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37): ?>
                                    <br>
                                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                        <strong>Aprobación de Requisición:</strong>
                                    </p>
                                    <br>
                                    <div class="flex justify-center items-center w-full mx-auto bg-white dark:bg-gray-700 ">
                                        <div class="grid gap-3 mb-3 lg:grid-cols-6">                                    
                                            <div class="col-span-2 flex items-center">
                                                <?php if( is_null($selectedRQ->ApprovateUser )): ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ && $selectedRQ->ApprovateUser == true): ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                        <?php echo e($selectedRQ->UserName); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                        Rechazada
                                                    </span>
                                                
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-span-2 flex justify-center items-center">
                                                <?php if(is_null($selectedRQ->ApprovateLines)): ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ && $selectedRQ->ApprovateLines == 1): ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                        Aprobada
                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                        Rechazada
                                                    </span>
                                                <?php endif; ?>
                                            </div> 
                                            <div class="col-span-2 flex items-center">
                                                <?php if(is_null($selectedRQ->ApprovateLines)): ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-100">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ && $selectedRQ->ManagerApprovateName): ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                        <?php echo e($selectedRQ->ManagerApprovateName); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                        Rechazada
                                                    </span>
                                                <?php endif; ?>
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
                                <?php endif; ?>
                                <?php if($selectedRQ->StatusList_id>=18  && $selectedRQ->StatusList_id != 39 && $selectedRQ->StatusList_id != 38 && $selectedRQ->StatusList_id != 37): ?>
                                    <br>
                                    <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                                        <strong>Aprobación de P.O:</strong>
                                    </p>
                                    <br>
                                    <div class="flex justify-center items-center w-full mx-auto bg-white dark:bg-gray-700 ">
                                        <div class="grid gap-3 mb-3 lg:grid-cols-8">
                                            <div class="col-span-2">
                                                <?php if(is_null($selectedRQ->ApprovatePOBuyer)): ?>
                                                    <span class="ni-assigned">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ && $selectedRQ->ApprovatePOBuyer == true): ?>
                                                    <span class="assigned">
                                                        <?php echo e($selectedRQ->ApprovateBuyerName); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="not-assigned">
                                                        Rechazada
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-span-2">
                                                <?php if(is_null($selectedRQ->ApprovatePODirector)): ?>
                                                    <span class="ni-assigned">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ->ApprovatePODirector == true): ?>
                                                    <span class="assigned">
                                                        <?php echo e($selectedRQ->ApprovateDirector); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="not-assigned">
                                                        Rechazada
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-span-2">
                                                <?php if(is_null($selectedRQ->ApprovateVPresident)): ?>
                                                    <span class="ni-assigned">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ && $selectedRQ->ApprovateVPresident == 1): ?>
                                                    <span class="assigned">
                                                        <?php echo e($selectedRQ->ApprovateVPresidentName); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="not-assigned">
                                                        Rechazada
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-span-2">
                                                <?php if(is_null($selectedRQ->ApprovatePresident)): ?>
                                                    <span class="ni-assigned">
                                                        Pendiente
                                                    </span>
                                                <?php elseif( $selectedRQ && $selectedRQ->ApprovatePresident == 1): ?>
                                                    <span class="assigned">
                                                        <?php echo e($selectedRQ->ApprovatePresidentName); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="not-assigned">
                                                        Rechazada
                                                    </span>
                                                <?php endif; ?>
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
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($errors->any()): ?>
                        <div class="mb-4">
                            <div class="font-medium text-red-600">¡Oh no! Algo salió mal.</div>
                            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if($selectedRQ && ($selectedRQ->statusList->id == 1 || $selectedRQ->statusList->id == 38 || $selectedRQ->statusList->id == 37 || $selectedRQ->statusList->id == 10)): ?>
                        <button wire:click="OpenModalUpdateLineQuote('create')" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="OpenModalUpdateLineQuote('create')">Añadir Línea</span>
                            <span wire:loading wire:target="OpenModalUpdateLineQuote('create')">Cargando...</span>
                        </button>
                        <?php if($RQLines): ?>
                            <?php if($RQLines->count() != 0): ?>
                                <?php if($selectedRQLine): ?>
                                    <button wire:click="OpenModalUpdateLineQuote('edit')" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <span wire:loading.remove wire:target="OpenModalUpdateLineQuote('edit')">Editar</span>
                                        <span wire:loading wire:target="OpenModalUpdateLineQuote('edit')">Cargando...</span>
                                    </button>
                                    <button wire:click="$set('showConfirmDeleteLineQuoteModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        <span wire:loading.remove wire:target="$set('showConfirmDeleteLineQuoteModal',false)">Eliminar</span>
                                        <span wire:loading wire:target="$set('showConfirmDeleteLineQuoteModal',false)">Cargando...</span>
                                    </button>
                                <?php endif; ?>
                                <button wire:click="$set('showConfirmSendQuoteBuyerModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <span wire:loading.remove wire:target="$set('showConfirmSendQuoteBuyerModal',false)">Enviar a Compras</span>
                                    <span wire:loading wire:target="$set('showConfirmSendQuoteBuyerModal',false)">Cargando...</span>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if($selectedRQLine != null && ($selectedRQ->statusList->id == 6 || $selectedRQ->statusList->id == 7)): ?>
                        <div class="col-span-3">
                            <label for="selectedQuote" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Elija una cotización:</label>
                            <select wire:model="selectedQuote" name="selectedQuote" id="selectedQuote" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option selected value="">Cotización (Precio /Fecha Llegada/ Proveedor)</option>
                                <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $QU): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($QU->id); ?>"> <?php echo e(round($QU->Cost,4)); ?> <?php echo e($QU->currency->name); ?> - <?php echo e($QU->supplier->VNDNAM); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button wire:click="selectedQuoteForRequisition" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="selectedQuoteForRequisition">Seleccionar Cotización</span>
                            <span wire:loading wire:target="selectedQuoteForRequisition">Cargando...</span>
                        </button>
                    <?php endif; ?>
                    <?php if($selectedRQ && $selectedRQ->statusList->id == 7 ): ?>
                    <button wire:click="$set('showConfirmSelectionQuoteModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span wire:loading.remove wire:target="$set('showConfirmSelectionQuoteModal',false)">Confirmar Cotización</span>
                        <span wire:loading wire:target="$set('showConfirmSelectionQuoteModal',false)">Cargando...</span>
                    </button>
                <?php endif; ?>
                    <?php if($selectedRQ && $selectedRQ->statusList->id == 8 ): ?>
                        <button wire:click="$set('showConfirmGenerateRequisitionModal',false)" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="$set('showConfirmGenerateRequisitionModal',false)">Generar Requisición</span>
                            <span wire:loading wire:target="$set('showConfirmGenerateRequisitionModal',false)">Cargando...</span>
                        </button>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Update Line Quote Modal -->
    <div id="UpdateLineQuoteModal" tabindex="-1" aria-hidden="true" <?php if($showUpdateLineQuoteModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"  >
        <div class="overflow-hidden  mx-auto relative p-4 w-full md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mx-auto max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <?php if($modeLine == "create"): ?>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Nueva Línea
                        </h3>
                    <?php elseif($modeLine == "edit"): ?>
                        Editar Línea
                    <?php endif; ?>
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
                            
                            <div class="col-span-1">
                                <label for="CostCenter_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Departamento que usara:</label>
                                <select wire:model.defer="RQLCostCenter_id" name="CostCenter_id" id="CostCenter_id" <?php if($selectedRQ): ?> value="<?php echo e($RQLCostCenter_id); ?>" <?php endif; ?> class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Seleccione un Centro de Costos</option>
                                    <?php $__currentLoopData = $costCenters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $costCenter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($costCenter->id); ?>"><?php echo e($costCenter->name); ?> - <?php echo e($costCenter->description); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-span-3">
                                <label for="RQLItem_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Item:</label>
                                <select wire:model="RQLItem_id" name="Item_id" id="Item_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" >Seleccione un Item</option>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?> - <?php echo e($item->description); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php if(!$RQLItem_id): ?>
                                <div class="col-span-3">
                                    <label for="name" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Concepto del material o servicio:</label>
                                    <input wire:model.lazy="RQLname" type="text" minlength="10" maxlength="50" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                </div>
                            <?php endif; ?>
                            <div class="col-span-1">
                                <label for="RQLquantity" class="block  text-sm font-medium text-gray-900 dark:text-gray-300">Cantidad:</label>
                                <input wire:model.defer="RQLquantity" type="number" id="quantity" name="quantity" min="1" max="10000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            </div>
                            <?php if(!$RQLItem_id): ?>
                                <div class="col-span-3">
                                    <label for="RQLdescription" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Descripción (añada caracteristicas adicionales del material o servicio):</label>
                                    <textarea wire:model.lazy="RQLdescription" name="RQLdescription"  id="RQLdescription" minlength="10" maxlength="300" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required> </textarea>
                                </div>
                            <?php endif; ?>
                            <div class="col-span-1">
                                <label for="RQLdateRequired" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Fecha en que se requiere:</label>
                                <input wire:model.defer="RQLdateRequired" type="date" id="RQLdateRequired" name="RQLdateRequired" 
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        required min="<?php echo e(now()->format('Y-m-d')); ?>">
                            </div>
                            <?php if(!$RQLItem_id): ?>
                                <div class="col-span-1">
                                    <label for="RQL_imgPath" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Imagen:</label>
                                    <input wire:model.defer="RQL_imgPath" type="file" id="RQL_imgPath" name="RQL_imgPath" accept=".png, .jpg, .jpeg, .zip, .rar, .pdf," class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <?php $__errorArgs = ['RQL_imgPath'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            <?php endif; ?>
                            <?php if(!$RQLItem_id): ?>
                                <div class="col-span-1">
                                    <label for="MeasurementUnit_id" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Unidad de Medida:</label>
                                    <select wire:model.defer="RQLMeasurementUnit_id" name="MeasurementUnit_id" id="MeasurementUnit_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                        <option value="">Seleccione unidad de medida</option>
                                        <?php $__currentLoopData = $measurementUnits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $measurementUnit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($measurementUnit->id); ?>"><?php echo e($measurementUnit->name); ?> - <?php echo e($measurementUnit->description); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($errors->any()): ?>
                        <div class="mb-4">
                            <div class="font-medium text-red-600">¡Oh no! Algo salió mal.</div>
                            <ul class="mt-3 text-sm text-red-600 list-disc list-inside">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if($modeLine == "create"): ?>
                        <button wire:click="createLineQuote" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="createLineQuote">Guardar</span>
                            <span wire:loading wire:target="createLineQuote">Cargando...</span>
                        </button>
                    <?php endif; ?>
                    <?php if($modeLine == "edit"): ?>
                        <button wire:click="EditLineQuote('edit')" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target="EditLineQuote('edit')">Guardar</span>
                            <span wire:loading wire:target="EditLineQuote('edit')">Cargando...</span>
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <div id="confirmSendQuoteToBuyerModal" tabindex="-1" aria-hidden="true" <?php if($showConfirmSendQuoteBuyerModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
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

    <div id="confirmDeleteLineQuoteModal" tabindex="-1" aria-hidden="true" <?php if($showConfirmDeleteLineQuoteModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
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
    <div id="confirmSendQuoteToBuyerModal" tabindex="-1" aria-hidden="true" <?php if($showConfirmSelectionQuoteModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
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
    <div id="confirmSendQuoteToBuyerModal" tabindex="-1" aria-hidden="true" <?php if($showConfirmGenerateRequisitionModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
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



<?php /**PATH C:\xampp\htdocs\GESC\resources\views/livewire/home/menu-show.blade.php ENDPATH**/ ?>