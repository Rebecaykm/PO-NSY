<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => 'Generar OC'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container mx-auto">
        <h2 class="mt-4 mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Generador de Órdenes de Compra
        </h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="searchTitle"
                    class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:bg-gray-700 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por Número de PO">
            </div>
            <div class="col-md-3">
                <button id="searchButton" class="btn btn-primary">Buscar</button>
                <button id="clearButton" class="btn btn-secondary">Borrar filtro</button>
            </div>
        </div>
        <?php echo $__env->make('partials.table_po', ['POs' => $POs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<script>
    $(document).ready(function () {
        // Función para actualizar la tabla con un solo objeto
        function updateTable(po) {
            $('#purchaseOrderTable').empty(); // Limpia la tabla antes de agregar nueva fila

            if (!po) { // Si no hay resultados
                $('#purchaseOrderTable').append('<tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>');
                return;
            }

            const row = `
                <tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <td class="px-4 py-2 text-xs">${po.PORD || ''}</td>
                    <td class="px-4 py-2 text-xs">${po.PVEND || ''}</td>
                    <td class="px-4 py-2 text-xs">${po.PLINE || ''}</td>
                    <td class="px-4 py-2 text-xs">${po.PSHIP || ''}</td>
                    <td class="px-4 py-2 text-xs">${po.PBUYC || ''}</td>
                    <td class="px-4 py-2 text-xs">${po.POCUR || ''}</td>
                    <td class="px-4 py-2 text-xs description-cell">
                        <a href="<?php echo e(route('pdf', ['PO' => '${po.PORD}'])); ?>" target="_blank">
                            PDF
                        </a>
                    </td>
                </tr>`;

            $('#purchaseOrderTable').append(row); // Añadir fila a la tabla
        }

        // Evento para limpiar el filtro
        $('#clearButton').on('click', function () {
            $('#searchTitle').val(''); // Limpiar el input de búsqueda
            $.ajax({
                url: "<?php echo e(route('index')); ?>",
                method: 'GET',
                data: { search: '' },
                success: function (response) {
                    updateTable(response); // Llamada con el objeto
                },
                error: function () {
                    console.error('Error al obtener los datos');
                }
            });
        });

        // Evento para realizar la búsqueda
        $('#searchButton').on('click', function () {
            const query = $('#searchTitle').val();
            $.ajax({
                url: "<?php echo e(route('index')); ?>",
                method: 'GET',
                data: { search: query },
                success: function (response) {
                    updateTable(response); // Llamada con el objeto
                },
                error: function () {
                    console.error('Error al realizar la búsqueda');
                }
            });
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\PO-MSY\resources\views/index.blade.php ENDPATH**/ ?>