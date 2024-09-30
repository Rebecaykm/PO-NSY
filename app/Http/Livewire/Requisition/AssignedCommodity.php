<?php

namespace App\Http\Livewire\Requisition;

use Livewire\Component;
use App\Models\Commodity;
use App\Models\Folio;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestInvestment;
use App\Models\RequestQuote;
use App\Models\RequestRequisition;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class AssignedCommodity extends Component
{
    use  WithPagination;
    public $search, $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC', $cadena;
    public $selectedRQ = null, $selectedRQLine = null, $perPage = 10, $page = 1;
    public $departmentId, $lengthRQ = 0;
    public $selectedCommodity = null;
    public $selectedCommodityLine = null;
    public $showAssignmentCommodityModal = true;
    public $showConfirmGenerateRequestInvestment = true;
    public $showConfirmAssignmentModal = true;
    public $showConfirmAssignmentCommodityForLine = true;
    public $showConfirmCloseRequestRequisition = true;
    public $close = true, $open = false;
    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];

    public function render()
    {
        return view('livewire.requisition.assigned-commodity', [
            'requestQuotes' => $this->getRequestQuotes(),
            'RQLines'       => $this->getRequestQuoteLines(),
            'commodities'   => $this->getCommodities(),
        ]);
    }

    public function getRequestQuotes()
    {
        try {
            $query = RequestQuote::whereIn('StatusList_id', [15, 16, 17, 19])
                ->orderBy($this->selectedOrderBy, $this->selectedOrder);
            if ($this->search) {
                $query->where('RFQ', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            }
            return $query->paginate($this->perPage);
        } catch (\Exception $e) {
            Log::error('Error al obtener las cotizaciones de solicitud: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las cotizaciones de solicitud.');
            return collect();
        }
    }
    
    public function getRequestQuoteLines()
    {
        try {
            return $this->selectedRQ ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                                    ->where('status', 1)
                                                    ->orderBy('id', 'ASC')
                                                    ->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener las líneas de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las líneas de cotización.');
            return collect();
        }
    }
    
    public function getCommodities()
    {
        try {
            return Commodity::get();
        } catch (\Exception $e) {
            Log::error('Error al obtener commodities: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener commodities.');
            return collect();
        }
    }
    
    public function updatingSearch()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error al actualizar búsqueda: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar la búsqueda.');
        }
    }
    
    public function updatingSelectedOrderBy()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error al actualizar el ordenamiento: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar el ordenamiento.');
        }
    }
    
    public function updatingSelectedOrder()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error al actualizar el orden: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar el orden.');
        }
    }
    
    public function resetPage()
    {
        try {
            $this->reset('page');
        } catch (\Exception $e) {
            Log::error('Error al restablecer la página: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al restablecer la página.');
        }
    }
    
    public function selectRQ($RQ_id)
    {
        try {
            $this->selectedRQ = RequestQuote::find($RQ_id);
            $this->selectedCommodity = $this->selectedRQ ? $this->selectedRQ->Commodity_id : null;
        } catch (\Exception $e) {
            Log::error('Error al seleccionar cotización de solicitud: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar cotización de solicitud.');
        }
    }
    
    public function selectRQLine($RQL_id)
    {
        try {
            $this->selectedRQLine = QuoteLine::find($RQL_id);
            if ($this->selectedRQLine != null) $this->selectedCommodityLine = $this->selectedRQ->Commodity_id;
        } catch (\Exception $e) {
            Log::error('Error al seleccionar línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar línea de cotización.');
        }
    }
    
    public function selectOrderFlag($field)
    {
        try {
            $this->selectedOrderBy = $field;
            $this->selectedOrder = ($this->selectedOrder === 'ASC') ? 'DESC' : 'ASC';
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la bandera de orden: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la bandera de orden.');
        }
    }
    
    public function clearFilters()
    {
        try {
            $this->search = null;
            $this->selectedRQ = null;
            $this->closeAllModals();
        } catch (\Exception $e) {
            Log::error('Error al limpiar filtros: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al limpiar filtros.');
        }
    }
    
    public function OpenModalAssignmentCommodity()
    {
        try {
            $this->showAssignmentCommodityModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de asignación de commodity: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de asignación de commodity.');
        }
    }
    
    public function OpenModalConfirmGenerateRequestInvestment()
    {
        try {
            $this->showConfirmGenerateRequestInvestment = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmación de generación de solicitud de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación de generación de solicitud de inversión.');
        }
    }
    
    public function OpenModalConfirmAssignmentCommodity()
    {
        try {
            $this->showConfirmAssignmentModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmación de asignación de commodity: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación de asignación de commodity.');
        }
    }
    
    public function OpenModalConfirmAssignmentCommodityForLine()
    {
        try {
            $this->showConfirmAssignmentCommodityForLine = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmación de asignación de commodity para línea: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación de asignación de commodity para línea.');
        }
    }
    
    public function OpenModalConfirmCloseRequestRequisition()
    {
        try {
            $this->showConfirmCloseRequestRequisition = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmación de cierre de solicitud de requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación de cierre de solicitud de requisición.');
        }
    }
    
    public function CloseModalAssignmentCommodity()
    {
        try {
            $this->showAssignmentCommodityModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de asignación de commodity: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de asignación de commodity.');
        }
    }
    
    public function CloseModalConfirmGenerateRequestInvestment()
    {
        try {
            $this->showConfirmGenerateRequestInvestment = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de generación de solicitud de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de generación de solicitud de inversión.');
        }
    }
    
    public function CloseModalConfirmAssignmentCommodity()
    {
        try {
            $this->showConfirmAssignmentModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de asignación de commodity: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de asignación de commodity.');
        }
    }
    
    public function CloseModalConfirmAssignmentCommodityForLine()
    {
        try {
            $this->showConfirmAssignmentCommodityForLine = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de asignación de commodity para línea: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de asignación de commodity para línea.');
        }
    }
    
    public function CloseModalConfirmCloseRequestRequisition()
    {
        try {
            $this->showConfirmCloseRequestRequisition = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de cierre de solicitud de requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de cierre de solicitud de requisición.');
        }
    }
    
    public function closeAllModals()
    {
        try {
            $this->showAssignmentCommodityModal = $this->close;
            $this->showConfirmGenerateRequestInvestment = $this->close;
            $this->showConfirmAssignmentModal = $this->close;
            $this->showConfirmAssignmentCommodityForLine = $this->close;
            $this->showConfirmCloseRequestRequisition = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar todos los modales: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar todos los modales.');
        }
    }
    
    public function AssignCommodity()
    {
        try {
            $this->validate(['selectedCommodity' => 'required']);
    
            $RequestRequisitionLines = $this->getRequestQuoteLines();
            $RequestRequisitionLines->each(function ($line) {
                $line->update(['Commodity_id' => $this->selectedCommodity]);
            });
    
            $this->selectedRQ->update(['Commodity_id' => $this->selectedCommodity]);
            
    
            if ($this->selectedRQ->wasChanged('Commodity_id')) {
                $this->selectedRQ->update([
                    'StatusList_id' => 16,
                    'Commodity_id' => $this->selectedCommodity,
                ]);
    
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 16,
                ]);
                session()->flash('success', 'El commodity ha sido asignado correctamente');
            } else {
                session()->flash('error', 'El commodity no se ha podido asignar, por favor intente nuevamente');
            }
            $this->CloseModalConfirmAssignmentCommodity();
        } catch (\Exception $e) {
            Log::error('Error al asignar commodity: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al asignar commodity.');
        }
    }
    
    public function AssignedCommodityForLine()
    {
        try {
            $this->validate(['selectedCommodityLine' => 'required']);
    
            if (!$this->selectedRQLine) {
                session()->flash('error', 'No se encontró la línea de cotización seleccionada.');
                return;
            }
    
            if (!$this->selectedCommodityLine) {
                session()->flash('error', 'Debe seleccionar un commodity.');
                return;
            }
    
            $this->selectedRQLine->update(['Commodity_id' => $this->selectedCommodityLine]);
    
            if ($this->selectedRQLine->wasChanged('Commodity_id')) {
                session()->flash('success', 'El commodity ha sido asignado correctamente.');
            } else {
                session()->flash('error', 'El commodity no se ha podido asignar, por favor intente nuevamente.');
            }
        } catch (\Exception $e) {
            Log::error('Error al asignar commodity para la línea: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al asignar commodity para la línea.');
        }
        $this->selectedCommodityLine = null;
        $this->closeAllModals();
    }
    
    public function ChangeStatus()
    {
        try {
            $this->selectedRQ->update([
                'StatusList_id' => 19,
            ]);
    
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 19,
            ]);
    
            $this->closeAllModals();
        } catch (\Exception $e) {
            Log::error('Error al cambiar el estado: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cambiar el estado.');
        }
    }
    
    public function GenerateRequestInvestment()
    {
        try {
            $folio_WN = Folio::findOrFail(3);
            $WN = str_pad($folio_WN->folio, 8, '0', STR_PAD_LEFT);
            $folio_WN->increment('folio');
    
            $request_investment = RequestInvestment::create([
                'RFQ' => $this->selectedRQ->RFQ,
                'WorkNumber' => $WN,
                'RequestQuote_id' => $this->selectedRQ->id,
                'Buyer_id' => $this->selectedRQ->Buyer_id,
                'User_id' => $this->selectedRQ->User_id,
                'StatusList_id' => 17,
            ]);
    
            $this->selectedRQ->update(['WorkNumber' => $WN]);
    
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 17,
            ]);
    
            if ($request_investment) {
                session()->flash('success', 'Solicitud de Inversión generada con éxito');
            } else {
                session()->flash('error', 'La Solicitud de Inversión no pudo ser generada, vuelva a intentar más tarde');
            }
            $this->CloseModalConfirmGenerateRequestInvestment();
        } catch (\Exception $e) {
            Log::error('Error al generar la solicitud de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al generar la solicitud de inversión.');
        }
    }
    

}
