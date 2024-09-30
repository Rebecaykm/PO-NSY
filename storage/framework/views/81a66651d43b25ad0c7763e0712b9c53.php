<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['submit']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['submit']); ?>
<?php foreach (array_filter((['submit']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800'])); ?>>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="<?php echo e($submit); ?>">
            <div class="overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <?php echo e($form); ?>

                    </div>
                </div>

                <?php if(isset($actions)): ?>
                <div class="flex items-center px-4 py-3 sm:px-6">
                    <?php echo e($actions); ?>

                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\GESC\resources\views/components/form-section.blade.php ENDPATH**/ ?>