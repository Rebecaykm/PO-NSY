<x-app-layout title="Cotización RFQ">
    <div class="container-fluid w-75 grid px-2 mx-auto">
        <h2 class="mt-4 mb-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Solicitudes de Cotización 
        </h2>
        {{-- @livewire('purchasing.assigned-r-f-q-crud') --}}
        @include('partials.filter_rfq')
        @include('partials.table_quote_purchasing',['requestQuotes' => $requestQuotes, 'ACTION' => 'partials.action_quote_purchasing'])
        <!-- Modal View Detail-->
        @include('partials.modal_rfq_po')

        <!-- Modal View Detail-->
        {{-- @include('partials.request_inverstment') --}}
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        // Evento para limpiar el filtro
        $('#clearButton').on('click', function() {
            $('#searchTitle').val(''); // Limpia el input de búsqueda

            $.ajax({
                url: "{{ route('PurchaseOrder.ApprovalVP.index') }}",
                method: 'GET',
                data: {search: ''},
                success: function(response) {
                    // console.log(response);
                    $('#requestQuotesTable').empty();
                    response.forEach(function(rq) {
                         // Formatear las fechas
                        let createdAtFecha = moment(rq.created_at).format('DD-MM-YYYY');
                        let createdAtHora = moment(rq.created_at).format('HH:mm:ss');
                        let updatedAtFecha = moment(rq.updated_at).format('DD-MM-YYYY');
                        let updatedAtHora = moment(rq.updated_at).format('HH:mm:ss');
                        let costCenterDescription = rq.costCenter ? rq.costCenter.description : 'No asignado';

                        
                        $('#requestQuotesTable').append('<tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs">' + rq.RFQ + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell">' + rq.UserName + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell">' + rq.description + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell"><span class="px-4 py-2 assigned">' + rq.buyer.PBNAM + '</span></td>');
                        if (rq.ApprovateVPresident == null) {
                            $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs"><span class="px-4 py-2 ni-assigned">Pendiente</span></td>');
                        } else if (rq.ApprovateVPresident == 0) {
                            $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs"><span class="px-4 py-2 not-assigned">Rechazado</span></td>');
                        } else {
                            $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs"><span class="px-4 py-2 assigned">Aprobado</span></td>');
                        }
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs">' + createdAtFecha + '<br>' + createdAtHora + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs">' + updatedAtFecha + '<br>' + updatedAtHora + '</td>');
                        // Ver Detalles, Aprobar, Rechazar
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs space-x-2 justify-center"><button class="text-blue-500 hover:text-blue-700 focus:outline-none view-details" title="Ver detalles" data-id="' + rq.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></button><button class="text-green-500 hover:text-green-700 focus:outline-none" title="Aprobar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="approve" data-rfq="' + rq.RFQ + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" /></svg></button><button class="text-red-500 hover:text-red-700 focus:outline-none" title="Rechazar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="reject" data-rfq="' + rq.RFQ + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" /></svg></button></td>');
                        $('#requestQuotesTable').append('</tr>');
                    });
                    // Volver a enlazar el evento de clic para los botones de ver detalles
                    bindViewDetails();
                }
            });
        });
        // Búsqueda solo al hacer clic en el botón
        $('#searchButton').on('click', function() {
            let query = $('#searchTitle').val();

            $.ajax({
                url: "{{ route('PurchaseOrder.ApprovalVP.index') }}",
                method: 'GET',
                data: {search: query},
                success: function(response) {
                    $('#requestQuotesTable').empty();
                    response.forEach(function(rq) {
                         // Formatear las fechas
                        let createdAtFecha = moment(rq.created_at).format('DD-MM-YYYY');
                        let createdAtHora = moment(rq.created_at).format('HH:mm:ss');
                        let updatedAtFecha = moment(rq.updated_at).format('DD-MM-YYYY');
                        let updatedAtHora = moment(rq.updated_at).format('HH:mm:ss');
                        
                        $('#requestQuotesTable').append('<tr class="text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs">' + rq.RFQ + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell">' + rq.UserName + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell">' + rq.description + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell"><span class="px-4 py-2 assigned">' + rq.buyer.PBNAM + '</span></td>');
                        if (rq.ApprovateVPresident == null) {
                            $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs"><span class="px-4 py-2 ni-assigned">Pendiente</span></td>');
                        } else if (rq.ApprovateVPresident == 0) {
                            $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs"><span class="px-4 py-2 not-assigned">Rechazado</span></td>');
                        } else {
                            $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs"><span class="px-4 py-2 assigned">Aprobado</span></td>');
                        }
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs">' + createdAtFecha + '<br>' + createdAtHora + '</td>');
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs">' + updatedAtFecha + '<br>' + updatedAtHora + '</td>');
                        // Ver Detalles, Aprobar, Rechazar
                        $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs space-x-2 justify-center"><button class="text-blue-500 hover:text-blue-700 focus:outline-none view-details" title="Ver detalles" data-id="' + rq.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></button><button class="text-green-500 hover:text-green-700 focus:outline-none" title="Aprobar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="approve" data-rfq="' + rq.RFQ + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" /></svg></button><button class="text-red-500 hover:text-red-700 focus:outline-none" title="Rechazar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="reject" data-rfq="' + rq.RFQ + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" /></svg></button></td>');
                        $('#requestQuotesTable').append('</tr>');
                    });
                    // Volver a enlazar el evento de clic para los botones de ver detalles
                    bindViewDetails();
                }
            });
        });
        // Evento de clic para abrir el modal
        function bindViewDetails() {
            $('.view-details').on('click', function() {
                let requestQuoteId = $(this).data('id');
                // let quotes = data.quotes;
                let quotes = data.quotes;
                let quoteFiles = data.quoteFiles;
                
                // Solicitud AJAX
                $.ajax({
                    url: "/PurchaseOrder/ApprovalVP/" + requestQuoteId,
                    type: 'GET',
                    success: function(data) {
                        // console.log(data);
                        // Limpia el contenido anterior
                        let dep_solicita = data.requestQuote.cost_center ? data.requestQuote.cost_center.department.Description : 'No asignado';
                        let cc = data.requestQuote.cost_center ? data.requestQuote.cost_center.name : 'No asignado';
                        let propietario = data.requestQuote.descipcion ? data.requestQuote.description : 'No asignado';
                        let descripcion = data.requestQuote.cost_center ? data.requestQuote.description : 'No asignado';
                        let desc_commodity = data.requestQuote.commodity ? data.requestQuote.commodity.PCDESC : 'No asignado';
                        let commodity = data.requestQuote.commodity ? data.requestQuote.commodity.PCCOM : 'No asignado';
                        let mxn = data.requestQuote.TotalCostMXN ? parseFloat(data.requestQuote.TotalCostMXN).toFixed(2) : '0.00';
                        let usd = data.requestQuote.TotalCostUSD ? parseFloat(data.requestQuote.TotalCostUSD).toFixed(2) : '0.00';
                        let jpy = data.requestQuote.TotalCostJPY ? parseFloat(data.requestQuote.TotalCostJPY).toFixed(2) : '0.00';
                        $('#modal-quoteLines').empty();
                        $('#modal-quoteFiles').empty();
                        $('#modal-quotes').empty();
                        $('#requestQuotesModalLabel').text('Orden de Compra: ' + data.requestQuote.RFQ );
                        $('#requestQuotesModalDetails').empty();
                        $('#requestQuotesModalDetails').append(`<div class="flex flex-wrap">
                                                                    <!-- Primera columna: Información básica -->
                                                                    <div class="w-1/2">
                                                                        <ul>
                                                                            <li class="text-s"><strong>Departamento que Solicita:</strong> ${dep_solicita} - CC: ${cc}</li>
                                                                            <li class="text-s"><strong>Propietario:</strong> ${propietario}</li>
                                                                            <li class="text-s"><strong>Descripción:</strong> ${descripcion}</li>
                                                                            <li class="text-s"><strong>Commodity:</strong> ${desc_commodity} - ${commodity}</li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- Segunda columna: Precios -->
                                                                    <div class="w-1/2">
                                                                            <strong> Precio total de PO en cada tipo de moneda </strong>
                                                                        <ul>
                                                                            <li class="text-s"> $ ${mxn} MXN</li>
                                                                            <li class="text-s"> $ ${usd} USD</li>
                                                                            <li class="text-s"> ¥ ${jpy} YJP</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>`);
                        //Cabezera de lineas de cotización
                        $('#modal-quoteLines').append('<thead><tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"><th class="px-4 py-2"><span class="mr-1">Dep.<br>Usara</span></th><th class="px-4 py-2"><span class="mr-1">Contenido</span></th><th class="px-4 py-2"><span class="mr-1">Descripción</span></th><th class="px-4 py-2"><span class="mr-1">Proveedor</span></th><th class="px-4 py-2"><span class="mr-1">Qty.</span></th><th class="px-4 py-2"><span class="mr-1">Cost.<br>Unit.</span></th><th class="px-4 py-2"><span class="mr-1">Costo<br>Total</span></th></tr></thead>');
                        // Rellena las tablas con los datos recibidos
                        $.each(data.quoteLines, function(index, quoteLine) {
                            let Total = quoteLine.UnitCost * quoteLine.quantity;
                            $('#modal-quoteLines').append('<tbody><tr>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs description-cell">' + quoteLine.cost_center.name + ' - ' + quoteLine.cost_center.department.Name + '</td>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs description-cell">' + quoteLine.name + '</td>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs description-cell ">' + quoteLine.description + '</td>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs description-cell">' + quoteLine.supplier.VNDNAM + '</td>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs">' + quoteLine.quantity + '</td>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs"> $ ' + parseFloat(quoteLine.UnitCost).toFixed(2) + ' ' + quoteLine.currency.name + '</td>');
                            $('#modal-quoteLines').append('<td class="px-4 py-2 text-xs"> $ ' + parseFloat(Total).toFixed(2) + ' ' + quoteLine.currency.name + '</td>');
                            $('#modal-quoteLines').append('</tr></tbody>');
                        });

                        
                        $('#modal-quotes').append('<thead><tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"><th class="px-4 py-2"><span class="mr-1">Proveedor</span></th><th class="px-4 py-2"><span class="mr-1">Precio</span></th><th class="px-4 py-2"><span class="mr-1">Días de<br>Entrega</span></th><th class="px-4 py-2"><span class="mr-1">Comentario</span></th></tr></thead>');
                        $.each(data.quotes, function(index, quote) {
                            $('#modal-quotes').append('<tbody><tr>');
                            $('#modal-quotes').append('<td class="px-4 py-2 text-xs description-cell">' + quote.supplier.VNDNAM + '</td>');
                            $('#modal-quotes').append('<td class="px-4 py-2 text-xs justify-center"> $ ' + parseFloat(quote.Cost).toFixed(2) + ' ' + quote.currency.name + '</td>');
                            $('#modal-quotes').append('<td class="px-4 py-2 text-xs justify-center">' + quote.NumDaysArrival + '</td>');
                            if (quote.description !== null) {
                                $('#modal-quotes').append('<td class="px-4 py-2 text-xs description-cell">' + quote.description + '</td>');
                            } else {
                                $('#modal-quotes').append('<td></td>');
                            }
                            // $('#modal-quotes').append('<td>' + quote.description + '</td>');
                            $('#modal-quotes').append('</tr></tbody>');
                        });

                        $('#modal-quoteFiles').append('<thead><tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"><th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 "><span class="mr-1">VENDOR</span></th><th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 "><span class="mr-1">Proveedor</span></th><th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 "><span class="mr-1">Nombre</span></th><th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 "><span class="mr-1">Fecha</span></th><th class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 "><span class="mr-1">Acción</span></th></tr></thead>');
                        $.each(data.quoteFiles, function(index, quoteFile) {
                            let createdAtFechaQuote = moment(quoteFile.created_at).format('DD-MM-YYYY');
                            let createdAtHoraQuote = moment(quoteFile.created_at).format('HH:mm:ss');
                            $('#modal-quoteFiles').append('<tbody><tr>');
                            $('#modal-quoteFiles').append('<td class="px-4 py-2 text-xs description-cell">' + quoteFile.supplier.VENDOR + '</td>');
                            $('#modal-quoteFiles').append('<td class="px-4 py-2 text-xs description-cell">' + quoteFile.supplier.VNDNAM + '</td>');
                            $('#modal-quoteFiles').append('<td class="px-4 py-2 text-xs description-cell">' + quoteFile.fileName + '</td>');
                            $('#modal-quoteFiles').append('<td class="px-4 py-2 text-xs justify-center">' + createdAtFechaQuote + '<br>' + createdAtHoraQuote + '</td>');
                            $('#modal-quoteFiles').append('<td class="px-4 py-2 text-xs description-cell"><a href="{{ Storage::url(' + quoteFile.id + ') }}" target="_blank">Ir al Documento</a></td>');
                            $('#modal-quoteFiles').append('</tr></tbody>');
                        });

                        // Muestra el modal
                        $('#requestQuotesModal').modal('show');
                    },
                    error: function() {
                        alert('Error al cargar los detalles de la solicitud.');
                    }
                });
            });
        }

        // Llama a la función para enlazar los eventos de detalles al cargar la página
        bindViewDetails();
    });
    $(document).ready(function() {
        $('#confirmModal').on('show.bs.modal', function (event) {
        // $('.view-confirm').on('click', function () {
            const button = $(event.relatedTarget);
            requestId = button.data('id');
            requestRFQ = button.data('rfq');
            actionType = button.data('action');
            // let requestId = $(this).data('id');
            // let actionType = $(this).data('action');
            const actionText = actionType === 'approve' ? 'aprobar' : 'rechazar';
            const titulo = actionType === 'approve' ? 'Aprobar RFQ: ' : 'Rechazar RFQ: ';
            $('#confirmModalLabel').text(titulo + requestRFQ);
            $('#actionType').text(actionText);
            $('#confirmModal').modal('show');
            // $.ajax({
            //     url: "/PurchaseOrder/ApprovalVP/Select/" + requestId,
            //     type: 'GET',
            //     success: function(data) {
            //         $('#confirmModalLabel').text(titulo + data.requestQuote.RFQ);
            //         $('#actionType').text(actionText);
            //         $('#confirmModal').modal('show');
            //     },
            //     error: function() {
            //         alert('Error al cargar los detalles de la solicitud.');
            //     }
            // });
        });

        $('#confirmAction').click(function() {
            const url = `/PurchaseOrder/ApprovalVP/${requestId}/${actionType}`;
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#confirmModal').modal('hide');
                    // Mostrar una notificación con SweetAlert2
                    Swal.fire({
                        title: 'Acción completada',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Opcional: Actualizar la tabla o redireccionar después de la notificación
                        location.reload(); // Recargar la página para reflejar los cambios
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

</script>