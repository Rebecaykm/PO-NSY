<div class="modal fade bd-example-modal-xl fixed inset-0 z-50 flex items-center justify-center dark:bg-gray-800 bg-opacity-50" id="requestQuotesModal" tabindex="-1" role="dialog" aria-labelledby="requestQuotesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl overflow-y-auto mx-auto relative p-4 w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl max-w-md max-h-screen" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title-quoteLines" id="requestQuotesModalLabel">Orden de Compra: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="requestQuotesModalDetails">  </div>
                <!-- Aquí se cargarán los datos dinámicamente -->
                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                    <strong>Líneas</strong>
                </p>                        
                <div class="overflow-x-auto bg-white-100 rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" ">
                    <div class="w-full overflow-x-auto">
                        <table id="modal-quoteLines" class="table table-striped border-collapse table-auto w-full whitespace-no-wrap bg-white-100 table-striped relative">
                            <!-- Las filas se cargarán aquí con jQuery -->
                        </table>
                    </div>
                </div>
                <br>
                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                    <strong>Cotizaciónes:</strong>
                </p>
                <div class="overflow-x-auto bg-white-100 rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" ">
                    <div class="w-full overflow-x-auto">
                        <table id="modal-quotes" class="table table-striped">
                            <!-- Las filas se cargarán aquí con jQuery -->
                        </table>
                    </div>
                </div>
                <br>
                <p class="flex justify-center items-center text-gray-600 dark:text-gray-400">
                    <strong>Documentos Adjuntos:</strong>
                </p>                        
                <div class="overflow-x-auto bg-white-100 rounded-lg shadow overflow-y-auto relative bg-gray-50 dark:bg-gray-900" ">
                    <div class="w-full overflow-x-auto">
                        <table id="modal-quoteFiles" class="table table-striped">
                            <!-- Las filas se cargarán aquí con jQuery -->
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\GESC\resources\views/partials/modal_rfq_po.blade.php ENDPATH**/ ?>