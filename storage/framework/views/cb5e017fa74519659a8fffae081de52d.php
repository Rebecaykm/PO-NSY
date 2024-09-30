<div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 400px;">
    <table class="table table-fixed border-collapse w-full whitespace-no-wrap bg-white table relative">
        <thead class="bg-gray-100" style="position: sticky; top: 0; z-index: 10;">
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                    <span class="mr-1">RFQ</span>
                </th>
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
        <tbody id="requestQuotesTable" class="requestQuotesTable bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php $__currentLoopData = $requestQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $RQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="px-4 py-2 text-xs whitespace-pre-line">
                            <?php echo e($RQ->RFQ); ?>

                        </td>
                        <td class="px-4 py-2 text-xs whitespace-pre-line">
                            <?php echo e($RQ->UserName); ?>

                        </td>
                        <td class="px-4 py-2 text-xs">
                            <?php if($RQ->StatusList_id == 39): ?>
                            <span class="not-assigned  description-cell">
                                <?php echo e($RQ->statusList->name); ?>

                            </span>
                            <?php else: ?>
                            <span class="assigned  description-cell">
                                <?php echo e($RQ->statusList->name); ?>

                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($RQ->description); ?>

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
                                    No Asignado
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
                            <?php echo e(Carbon\Carbon::parse($RQ->created_at)->format('d-m-Y')); ?>

                            <br>
                            <?php echo e(Carbon\Carbon::parse($RQ->created_at)->format('H:m:s')); ?>

                        </td>
                        <td class="px-4 py-2 text-xs">
                            <?php echo e(Carbon\Carbon::parse($RQ->updated_at)->format('d-m-Y')); ?>

                            <br>
                            <?php echo e(Carbon\Carbon::parse($RQ->updated_at)->format('H:m:s')); ?>

                        </td>
                    <td class="px-4 py-2 text-xs space-x-2 justify-center">
                        
                        <?php echo $__env->make($ACTION, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div><?php /**PATH C:\xampp\htdocs\GESC\resources\views/partials/table_quote_purchasing.blade.php ENDPATH**/ ?>