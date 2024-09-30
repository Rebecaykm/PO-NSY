<style>
    .max-width-cell {
    max-width: 10px; /* Establece el ancho máximo deseado */
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
    .description-cell {
        max-width: 200px; /* Ajusta este valor según sea necesario */
        overflow: visible;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;
    }
/*  .description-cell {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .description-cell:hover {
        overflow: visible;
        white-space: normal;
        word-wrap: break-word;
    } */


    .assigned {
    padding: 0.5rem 1rem;
    font-weight: 600;
    color: #047857; /* text-green-700 */
    background-color: #d1fae5; /* bg-green-100 */
    border-radius: 9999px; /* rounded-full */
    display: inline-block; /* to ensure correct padding and background application */
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
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'QuoteAssignment'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container grid px-6 mx-auto">
        <h2 class="mt-4 mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Aprobación de Orden de Compra (Presidente)
        </h2>
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('purchase-order.approval-president-show')->html();
} elseif ($_instance->childHasBeenRendered('BF4yJW7')) {
    $componentId = $_instance->getRenderedChildComponentId('BF4yJW7');
    $componentTag = $_instance->getRenderedChildComponentTagName('BF4yJW7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('BF4yJW7');
} else {
    $response = \Livewire\Livewire::mount('purchase-order.approval-president-show');
    $html = $response->html();
    $_instance->logRenderedChild('BF4yJW7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
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
<?php /**PATH C:\xampp\htdocs\GESC\resources\views/PurchaseOrder/ApprovalPresident/index.blade.php ENDPATH**/ ?>