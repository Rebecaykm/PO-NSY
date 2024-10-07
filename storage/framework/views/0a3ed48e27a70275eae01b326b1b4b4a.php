<style>
    .selected-option {
    opacity: 1.5; /* Ajusta la opacidad según tu preferencia */
    background-color: #e2e8f0;
    }
</style>

<div class="py-4 text-gray-500 dark:text-gray-400">
    <ul class="mt-6">
        <li class="relative px-10 py-1">
            <?php echo request()->routeIs('index') ? '<span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>' : ''; ?>

            <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 <?php echo e(request()->routeIs('index') ? 'flex items-center px-4 py-2 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-100 dark:text-blue-700' : ''); ?>" href="<?php echo e(route('index')); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                </svg>
                <span class="ml-4">Inicio</span>
            </a>
        </li>
    </ul>
</div>
<?php /**PATH C:\xampp\htdocs\PO-MSY\resources\views/layouts/_menus.blade.php ENDPATH**/ ?>