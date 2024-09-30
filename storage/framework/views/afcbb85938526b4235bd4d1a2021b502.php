<button class="text-blue-500 hover:text-blue-700 focus:outline-none view-details" title="Ver detalles" data-id="<?php echo e($RQ->id); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-eye">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
        <path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
    </svg>
</button>


<button class="text-green-500 hover:text-green-700 focus:outline-none" title="Aprobar" data-toggle="modal" data-target="#confirmModal" data-id="<?php echo e($RQ->id); ?>" data-action="approve" data-RFQ="<?php echo e($RQ->RFQ); ?>">

    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-up">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" />
    </svg>
</button>


<button class="text-red-500 hover:text-red-700 focus:outline-none" title="Rechazar" data-toggle="modal" data-target="#confirmModal" data-id="<?php echo e($RQ->id); ?>" data-action="reject" data-rfq="<?php echo e($RQ->RFQ); ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-down">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" />
    </svg>
</button><?php /**PATH C:\xampp\htdocs\GESC\resources\views/partials/action_approve_po_vp.blade.php ENDPATH**/ ?>