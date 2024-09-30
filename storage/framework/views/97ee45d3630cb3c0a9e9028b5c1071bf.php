<div>
    
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
        <?php if($selectedRQ): ?>
        <button wire:click="OpenModelShowQuote" wire:loading.attr="disabled" class="col-span-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded my-2">Detalle</button>
        <?php endif; ?>
    </div>

    <?php if(session()->has('message')): ?>
    <div id="alertMessage" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
        <div class="flex justify-center">
            <div class="py-1">
                <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                </svg>
            </div>
            <div>
                <p class="font-bold">¡Éxito!</p>
                <p class="text-sm"><?php echo e(session('message')); ?></p>
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
    <?php endif; ?>


    
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
        <div class="w-full overflow-x-auto">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <?php if($selectedOrderBy == 'RFQ' && $selectedOrder == 'ASC'): ?>
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        <?php elseif($selectedOrderBy == 'RFQ' && $selectedOrder === 'DESC'): ?>
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                        <?php else: ?>
                        <th wire:click="selectOrderFlag('RFQ')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">RFQ</span>
                        <?php endif; ?>
                        </th>
                        <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                            <span class="mr-1">Propietario</span>
                        </th>
                        <?php if($selectedOrderBy == 'description' && $selectedOrder === 'ASC'): ?>
                        <th wire:click="selectOrderFlag('description')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Descripción</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-down" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        <?php elseif($selectedOrderBy == 'description' && $selectedOrder === 'DESC'): ?>
                        <th wire:click="selectOrderFlag('description')" class="px-4 py-2 flex items-center hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Descripción</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-up" width="18" height="18" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                        <?php else: ?>
                        <th wire:click="selectOrderFlag('description')" class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Descripción</span>
                        <?php endif; ?>
                        </th>
                        <th class="px-4 py-2  dark:hover:bg-gray-700 ">
                            <span class="mr-1">Estatus</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Comprador <br>Asignado</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Commodity</span>
                        </th>
                        <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                            <span class="mr-1">Aprobación</span>
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
                        <?php $__currentLoopData = $requestQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $RQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr wire:click="selectRQ(<?php echo e($RQ->id); ?>)" class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 <?php if($selectedRQ && $selectedRQ->id == $RQ->id): ?>  bg-green-200 dark:bg-gray-500 <?php endif; ?>">
                            <td class="px-4 py-2 text-xs">
                                <?php echo e($RQ->RFQ); ?>

                            </td>
                            <td class="px-4 py-2 text-xs description-cell">
                                <?php echo e($RQ->UserName); ?>

                            </td>
                            <td class="px-4 py-2 text-xs description-cell">
                                <?php echo e($RQ->description); ?>

                            </td>
                            <td class="px-4 py-2 text-xs">
                                <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    <?php echo e($RQ->statusList->name); ?>

                                </span>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php if( $RQ->Buyer_id ): ?>
                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        <?php echo e($RQ->buyer->PBNAM); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        No Asignado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php if( $RQ->Commodity_id ): ?>
                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        <?php echo e($RQ->commodity->PCCOM); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        No Asignado
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php if( $RQ->ApprovatePresident ): ?>
                                    <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                        Aprobada
                                    </span>
                                <?php else: ?>
                                    <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                        No aprobada
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php echo e($RQ->created_at); ?>

                            </td>
                            <td class="px-4 py-2 text-xs">
                                <?php echo e($RQ->updated_at); ?>

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


    <!-- Show Quote Modal -->
    <div id="showQuoteModal" tabindex="-1" aria-hidden="true" <?php if($showQuoteModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen">
        
            <!-- Modal content -->
            <div class="relative bg-white w-full rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Aprobar Requisición
                    </h3>
                    <button wire:click="CloseModelShowQuote" wire:loading.attr="disabled" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"  onclick="document.getElementById('saveModal').style.display='none'">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Cerrar ventana</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <!-- This is an example component -->
                    
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
                                            <strong>Usuario:</strong> <?php echo e($selectedRQ->UserName); ?>

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
                                                                <span class="mr-1">Costo Unit.</span>
                                                            </th>
                                                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                                <span class="mr-1">Costo Total</span>
                                                            </th>
                                                            <th class="px-4 py-2 dark:hover:bg-gray-700 ">
                                                                <span class="mr-1">Frecha<br>Entrega</span>
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
                                                        <td class="px-4 py-3">
                                                            <div class="flex items-center text-sm">
                                                                <!-- Avatar with inset shadow -->
                                                                <div class="relative hidden w-20 h-20 mr-3 rounded-full md:block">
                                                                    <img class="object-cover w-full h-full rounded-full"
                                                                        src="<?php echo e(Storage::url('items/' . $RQL->imgPath)); ?>"
                                                                        alt="<?php echo e($RQL->name); ?>"/>
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
                                                            <td class="px-4 py-2 text-xs">
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
                                                            <td class="px-4 py-2 text-xs">
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
                                                        </atr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                                        <?php $__currentLoopData = $quotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                <td class="px-4 py-2 text-xs">
                                                                    <?php echo e($quote->supplier->VENDOR); ?> -<?php echo e($quote->supplier->VNDNAM); ?>

                                                                </td>
                                                                <td class="px-4 py-2 text-xs">
                                                                    $ <?php echo e($quote->Cost); ?> <?php echo e($quote->currency->name); ?>

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
                                                                <span class="mr-1">Descargar</span>
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
                                                    <?php if( $selectedRQ && $selectedRQ->ApprovateUser): ?>
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            <?php echo e($selectedRQ->user->name); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            No aprobada
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-span-2 flex justify-center items-center">
                                                    <?php if( $selectedRQ && $selectedRQ->ApprovateLines): ?>
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            Aprobada
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            No aprobada
                                                        </span>
                                                    <?php endif; ?>
                                                </div> 
                                                <div class="col-span-2 flex items-center">
                                                    <?php if( $selectedRQ && $selectedRQ->ManagerApprovateName): ?>
                                                        <span class="px-4 py-2 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                                            <?php echo e($selectedRQ->ManagerApprovateName); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="px-4 py-2 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                                            No aprobada
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
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprueba Usuario</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprobación de Lineas</label>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300">Aprueba Gerente</label>
                                                </div>                                                          
                                            </div>
                                        </div>
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
                    </div>
                    <?php if($selectedRQ && $selectedRQ->StatusList_id == 24): ?>
                        <button wire:click="OpenModalConfirmApproval" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Aprobar
                        </button>
                        <button wire:click="OpenModalConfirmReject" wire:loading.attr="disabled" type="submit" class="text-white inline-flex items-end bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Rechazar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Modal -->
    <div id="confirmApprovalModal" tabindex="-1" aria-hidden="true" <?php if($showConfirmApprovalModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden  mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="closeModal" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estas seguro de aprobar esta requisición?</h3>
                    <button wire:click="PresidentApprovePO" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Si, seguro.
                    </button>
                    <button wire:click="CloseModalConfirmApproval"  wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="document.getElementById('confirmDeleteModal').style.display='none'">
                        No, cancelar.
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Quote Modal -->
    <div id="confirmRejectModal" tabindex="-1" aria-hidden="true" <?php if($showConfirmRejectModal): ?> style="display:none" <?php endif; ?> class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="overflow-hidden mx-auto relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button wire:click="CloseModalConfirmReject" type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <form wire:submit.prevent="" class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Estás seguro de rechazar esta cotización?</h3>
                    <div class="col-span-1">
                        <label for="RQRemark" class="block text-sm font-medium text-gray-900 dark:text-gray-300">Escribe una breve explicación de el rechazo:</label>
                        <textarea wire:model="RQRemark" name="RQRemark" id="RQRemark" minlength="10" maxlength="300" rows="2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
                        <?php $__errorArgs = ['RQRemark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500">Por favor llenar este campo, minimo 10 caracteres, maximo 300</span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button wire:click="PresidentRejectRQ" wire:loading.attr="disabled" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Sí, seguro.
                    </button>
                    <button wire:click="CloseModalConfirmReject" wire:loading.attr="disabled" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No, cancelar.
                    </button>
                </form>
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
<?php /**PATH C:\xampp\htdocs\GESC\resources\views/livewire/purchase-order/approval-president-show.blade.php ENDPATH**/ ?>