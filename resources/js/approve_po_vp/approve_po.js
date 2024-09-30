$(document).ready(function() {
    // Evento para limpiar el filtro
    $('#clearButton').on('click', function() {
        $('#searchTitle').val(''); // Limpia el input de búsqueda

        $.ajax({
            url: "{{ route('PurchaseOrder.ApprovalVP.index') }}",
            method: 'GET',
            data: {search: ''},
            success: function(response) {
                console.log(response);
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
                    $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs description-cell">' + rq.UserName + '. - Dep:'  + rq.user.department.Name+ '</td>');
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
                    $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs space-x-2 justify-center"><button class="text-blue-500 hover:text-blue-700 focus:outline-none view-details" title="Ver detalles" data-id="' + rq.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></button><button class="text-green-500 hover:text-green-700 focus:outline-none" title="Aprobar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="approve"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" /></svg></button><button class="text-red-500 hover:text-red-700 focus:outline-none" title="Rechazar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="reject"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" /></svg></button></td>');
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
                    $('#requestQuotesTable').append('<td class="px-4 py-2 text-xs space-x-2 justify-center"><button class="text-blue-500 hover:text-blue-700 focus:outline-none view-details" title="Ver detalles" data-id="' + rq.id + '"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12 18c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></button><button class="text-green-500 hover:text-green-700 focus:outline-none" title="Aprobar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="approve"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 11v8a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-7a1 1 0 0 1 1 -1h3a4 4 0 0 0 4 -4v-1a2 2 0 0 1 4 0v5h3a2 2 0 0 1 2 2l-1 5a2 3 0 0 1 -2 2h-7a3 3 0 0 1 -3 -3" /></svg></button><button class="text-red-500 hover:text-red-700 focus:outline-none" title="Rechazar" data-toggle="modal" data-target="#confirmModal" data-id="' + rq.id + '" data-action="reject"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-thumb-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 13v-8a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a4 4 0 0 1 4 4v1a2 2 0 0 0 4 0v-5h3a2 2 0 0 0 2 -2l-1 -5a2 3 0 0 0 -2 -2h-7a3 3 0 0 0 -3 3" /></svg></button></td>');
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
                console.log(data);
                // Limpia el contenido anterior
                $('#modal-quoteLines').empty();
                $('#modal-quoteFiles').empty();
                $('#modal-quotes').empty();
                $('#requestQuotesModalLabel').text('Orden de Compra:' + data.requestQuote.RFQ );
                $('#requestQuotesModalDetails').empty();
                $('#requestQuotesModalDetails').append('<li>Departamento que Solicita: ' + data.requestQuote.cost_center.department.Description + ' - CC: ' + data.requestQuote.cost_center.name + '</li>');
                $('#requestQuotesModalDetails').append('<li>Propietario: ' + data.requestQuote.UserName + '</li>');
                $('#requestQuotesModalDetails').append('<li>Descripción: ' + data.requestQuote.description + '</li>');
                $('#requestQuotesModalDetails').append('<li>Commodity: ' + data.requestQuote.commodity.PCDESC + ' - ' + data.requestQuote.commodity.PCCOM + '</li>');
                $('#requestQuotesModalDetails').append('<li>Precio en MXN: $ ' + parseFloat(data.requestQuote.TotalCostMXN).toFixed(2) + '</li>'); 
                $('#requestQuotesModalDetails').append('<li>Precio en USD: $ ' + parseFloat(data.requestQuote.TotalCostUSD).toFixed(2) + '</li>'); 
                $('#requestQuotesModalDetails').append('<li>Precio en YJP: ¥ ' + parseFloat(data.requestQuote.TotalCostJPY).toFixed(2) + '</li>'); 
                data.requestQuote.cost_center.department.Name

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
    let requestId;
    let actionType;

    $('#confirmModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        requestId = button.data('id');
        actionType = button.data('action');
        $.ajax({
            url: "/PurchaseOrder/ApprovalVP/Select/" + requestId,
            type: 'GET',
            success: function(data) {
                const actionText = actionType === 'approve' ? 'aprobar' : 'rechazar';
                const titulo = actionType === 'approve' ? 'Aprobar RFQ :' : 'Rechazar RFQ :';
                $('#confirmModalLabel').empty();
                $('#confirmModalLabel').append('<h5>' + titulo + data.requestQuote.RFQ + '</h5>');
                $('#actionType').text(actionText);
            },
            error: function() {
                alert('Error al cargar los detalles de la solicitud.');
            }
        });
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