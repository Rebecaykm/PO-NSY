<div class="overflow-x-auto bg-white-100 rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 500px;">
    <table class="table table-fixed border-collapse w-full whitespace-no-wrap bg-white-100 table relative">
        <thead class="bg-gray-100" style="position: sticky; top: 0; z-index: 10;">
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                    <span class="mr-1">RFQ</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Propietario</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Descripción</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Comprador <br>Asignado</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Aprobación</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Frecha <br>Creado</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Fecha ultima <br>Actualización</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Acción</span>
                </th>
            </tr>
        </thead>
        <tbody id="requestQuotesTable" class="requestQuotesTable bg-white-100 divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php $__currentLoopData = $requestQuotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $RQ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <td class="px-4 py-2 text-xs description-cell">
                        <?php echo e($RQ->RFQ); ?>

                    </td>
                    <td class="px-4 py-2 text-xs description-cell">
                        <?php echo e($RQ->UserName); ?> - <?php echo e($RQ->costCenter->name); ?>

                    </td>
                    <td class="px-4 py-2 text-xs description-cell">
                        <?php echo e($RQ->description); ?>

                    </td>
                    <td class="px-4 py-2 text-xs description-cell">
                        <span class="px-4 py-2 assigned">
                            <?php echo e($RQ->buyer->PBNAM); ?>

                        </span>
                    </td>
                    <td class="px-4 py-2 text-xs description-cell">
                        <?php if( $RQ->ApprovateVPresident == null): ?>
                            <span class="px-4 py-2 ni-assigned">
                                Pendiente
                            </span>
                        <?php elseif( $RQ->ApprovateVPresident == 0): ?>
                            <span class="px-4 py-2 not-assigned">
                                Rechazado
                            </span>
                        <?php else: ?>
                            <span class="px-4 py-2 ni-assigned">
                                Aprobado
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2 text-xs description-cell">
                        <?php echo e(Carbon\Carbon::parse($RQ->created_at)->format('d-m-Y')); ?>

                        <br>
                        <?php echo e(Carbon\Carbon::parse($RQ->created_at)->format('H:m:s')); ?>

                    </td>
                    <td class="px-4 py-2 text-xs description-cell">
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
</div><?php /**PATH C:\xampp\htdocs\GESC\resources\views/partials/table_approve_po.blade.php ENDPATH**/ ?>