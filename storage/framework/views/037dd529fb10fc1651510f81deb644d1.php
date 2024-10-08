<div class="overflow-x-auto bg-white-100 rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" style="height: 500px;">
    <table class="table table-fixed border-collapse w-full whitespace-no-wrap bg-white-100 table relative">
        <thead class="bg-gray-100" style="position: sticky; top: 0; z-index: 10;">
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 ">
                    <span class="mr-1">PORD</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">PVEND</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Line</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Ship To</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Buyer</span>
                </th>
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Currency</span>
                </th>
                
                <th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <span class="mr-1">Acción</span>
                </th>
            </tr>
        </thead>
        <tbody id="requestQuotesTable" class="requestQuotesTable bg-white-100 divide-y dark:divide-gray-700 dark:bg-gray-800">
            <?php if(!is_null($POs)): ?>
                <?php $__currentLoopData = $POs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700">
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($line->PORD); ?>

                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($line->PVEND); ?>

                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($line->PLINE); ?>

                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($line->PSHIP); ?>

                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($line->PBUYC); ?>

                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <?php echo e($line->POCUR); ?>

                        </td>
                        <td class="px-4 py-2 text-xs description-cell">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-eye">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                        </td>
                        
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div><?php /**PATH C:\xampp\htdocs\PO-MSY\resources\views/partials/table_approve_po.blade.php ENDPATH**/ ?>