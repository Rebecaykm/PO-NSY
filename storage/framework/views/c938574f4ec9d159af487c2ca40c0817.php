<style>
    .max-width-cell {
    max-width: 8px; /* Establece el ancho máximo deseado */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    }
    /* Agrega reglas de estilo personalizadas aquí */
    .truncate-text {
        max-width: 100px; /* Ajusta la cantidad máxima de caracteres que deseas mostrar */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .name-cell {
        max-width: 150px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
    .description-cell {
        max-width: 200px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
    .assigned {
    padding: 0.5rem 1rem;
    font-weight: 600;
    color: #047857; /* text-green-700 */
    background-color: #d1fae5; /* bg-green-100 */
    border-radius: 9999px; /* rounded-full */
    display: inline-block; /* to ensure correct padding and background application */
    }

    .ni-assigned {
        padding: 0.5rem 1rem; /* py-2 px-4 */
        font-weight: 600; /* font-semibold */
        color: #4B5563; /* text-gray-700 */
        background-color: #F3F4F6; /* bg-gray-100 */
        border-radius: 9999px; /* rounded-full */
        display: inline-block; /* to ensure correct padding and background application */
    }

    .dark .ni-assigned {
        color: #F3F4F6; /* dark:text-gray-100 */
        background-color: #374151; /* dark:bg-gray-700 */
    }

    .not-assigned {
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: #b91c1c; /* text-red-700 */
        background-color: #fee2e2; /* bg-red-100 */
        border-radius: 9999px; /* rounded-full */
        display: inline-block; /* to ensure correct padding and background application */
    }
</style>
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => ''.e(__('GESC - INICIO')).''] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="grid px-10 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <?php echo e(__('Inicio')); ?>

        </h2>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('home.menu-show')->html();
} elseif ($_instance->childHasBeenRendered('emLVX1o')) {
    $componentId = $_instance->getRenderedChildComponentId('emLVX1o');
    $componentTag = $_instance->getRenderedChildComponentTagName('emLVX1o');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('emLVX1o');
} else {
    $response = \Livewire\Livewire::mount('home.menu-show');
    $html = $response->html();
    $_instance->logRenderedChild('emLVX1o', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\GESC\resources\views/Home/Menu/index.blade.php ENDPATH**/ ?>