<?php

namespace App\Http\Livewire\PurchaseOrder;

use App\Models\Quote;
use App\Models\QuoteFile;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestQuote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovalVPShow extends Component
{
    use  WithPagination;
    
    public $search, $selectedStatus, $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC', $cadena;
    public $selectedRQ = null,  $perPage = 10, $page = 1;
    public $departmentId, $lengthRQ = 0, $RQRemark = null;
    public $showQuoteModal = true, $showConfirmApprovalModal = true, $showConfirmRejectModal = true;
    public $close = true, $open = false;
    public $selectedRQLine = null;
    protected $rules = [
        'RQRemark' => 'required|min:10|max:300'
    ];
    public function render()
    {
        
        return view('livewire.purchase-order.approval-v-p-show',[
            'requestQuotes' => $this->getRequestQuote(),
            'RQLines' => $this->getQuoteLine(),
            'files' => $this->getFiles(),   
            'quotes' => $this->getQuotes(),
        ]);
    }
    
    public function selectRQLine($RQL_ID)
    {
        try {
            $this->selectedRQLine = QuoteLine::find($RQL_ID);
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la línea de cotización.');
        }
    }
    public function getFiles()
    {
        return  ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;
    }
    public function getQuotes()
    {
        return ($this->selectedRQLine) ? Quote::where('QuoteLine_id',$this->selectedRQLine->id)->get() : null;
    }
    public function getRequestQuote()
    {
        try {
            return RequestQuote::whereIn('StatusList_id', [23, 24, 50])
                ->orderBy($this->selectedOrderBy, $this->selectedOrder)
                ->paginate($this->perPage);
        } catch (\Exception $e) {
            Log::error('Error al obtener cotizaciones de solicitud: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener cotizaciones de solicitud.');
            return collect();
        }
    }
    
    public function getQuoteLine()
    {
        try {
            return ($this->selectedRQ) ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                                    ->where('status', 1)
                                                    ->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener líneas de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener líneas de cotización.');
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
            Log::error('Error al actualizar ordenamiento: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar el ordenamiento.');
        }
    }
    
    public function updatingSelectedOrder()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error al actualizar orden: ' . $e->getMessage());
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
        } catch (\Exception $e) {
            Log::error('Error al seleccionar cotización de solicitud: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar cotización de solicitud.');
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
    
    public function OpenModelShowQuote()
    {
        try {
            $this->showQuoteModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de mostrar cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de mostrar cotización.');
        }
    }
    
    public function OpenModalConfirmApproval()
    {
        try {
            $this->showConfirmApprovalModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmar aprobación: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmar aprobación.');
        }
    }
    
    public function OpenModalConfirmReject()
    {
        try {
            $this->showConfirmRejectModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmar rechazo: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmar rechazo.');
        }
    }
    
    public function CloseModelShowQuote()
    {
        try {
            $this->showQuoteModal = $this->close;
            $this->selectedRQLine = null;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de mostrar cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de mostrar cotización.');
        }
    }
    
    public function CloseModalConfirmApproval()
    {
        try {
            $this->showConfirmApprovalModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmar aprobación: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmar aprobación.');
        }
    }
    
    public function CloseModalConfirmReject()
    {
        try {
            $this->showConfirmRejectModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmar rechazo: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmar rechazo.');
        }
    }
    
    public function CloseAllModals()
    {
        try {
            $this->showQuoteModal = $this->close;
            $this->showConfirmApprovalModal = $this->close;
            $this->showConfirmRejectModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar todos los modales: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar todos los modales.');
        }
    }
    
    public function clearFilters()
    {
        try {
            $this->selectedStatus = null;
            $this->search = null;
            $this->selectedRQ = null;
            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Error al limpiar filtros: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al limpiar filtros.');
        }
    }
    
    public function VPApprovePO()
    {
        try {
            $user = Auth::user();
            if ($this->selectedRQ) {
                $this->selectedRQ->update([
                    'ApprovateVPresident' => 1,
                    'ApprovateVPresidentName' => $user->name,
                    'Vicepresidente_id' => $user->id,
                    'ApprovateVPresidentDate' => Carbon::today(),
                    'StatusList_id' => 24
                ]);
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 24, //48 es el estatus de rechazo de comprador
                ]);
            }
            session()->flash('message', ($this->selectedRQ->StatusList_id == 24) ? 'La Requisición ha sido aprobada' : 'La Requisición no ha podido ser aprobada');
        } catch (\Exception $e) {
            Log::error('Error al aprobar la PO por VP: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al aprobar la PO por VP.');
        }
    }
    
    public function PresidentApprovePO()
    {
        try {
            $user = Auth::user();
            if ($this->selectedRQ) {
                $this->selectedRQ->update([
                    'ApprovatePresident' => 1,
                    'ApprovatePresidentName' => $user->name,
                    'Presidente_id' => $user->id,
                    'ApprovatePresidentDate' => Carbon::today(),
                    'StatusList_id' => 25
                ]);
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 25, //48 es el estatus de rechazo de comprador
                    'remark' => 'Aprobada por ' . Auth::user()->name,
                ]);
            }
            session()->flash('message', ($this->selectedRQ->StatusList_id == 25) ? 'La Requisición ha sido aprobada' : 'La Requisición no ha podido ser aprobada');
        } catch (\Exception $e) {
            Log::error('Error al aprobar la PO por el Presidente: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al aprobar la PO por el Presidente.');
        }
    }
    
    public function DualApprovePO()
    {
        try {

                $user = Auth::user();
                if ($this->selectedRQ) {
                    $this->selectedRQ->update([
                        'ApprovateVPresident' => 1,
                        'ApprovateVPresidentName' => $user->name,
                        'Vicepresidente_id' => $user->id,
                        'ApprovateVPresidentDate' => Carbon::today(),
                        'ApprovatePresident' => 1,
                        'ApprovatePresidentName' => $user->name,
                        'Presidente_id' => $user->id,
                        'ApprovatePresidentDate' => Carbon::today(),
                        'StatusList_id' => 25
                    ]);
                    QuoteHistory::create([
                        'QuoteRequest_id' => $this->selectedRQ->id,
                        'StatusList_id' => 24, //48 es el estatus de rechazo de comprador
                    ]);
                    QuoteHistory::create([
                        'QuoteRequest_id' => $this->selectedRQ->id,
                        'StatusList_id' => 25, //48 es el estatus de rechazo de comprador
                        'remark' => 'Aprobada por ' . Auth::user()->name,
                    ]);
                }
                session()->flash('message', ($this->selectedRQ->StatusList_id == 24) ? 'La Requisición ha sido aprobada' : 'La Requisición no ha podido ser aprobada');
            $this->CloseAllModals();
        } catch (\Exception $e) {
            Log::error('Error al aprobar la PO de forma dual: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al aprobar la PO de forma dual.');
        }
    }
    
    public function VPRejectRQ()
    {
        try {
            $user = Auth::user();
            $this->validate(['RQRemark' => 'required|min:10|max:300']);
            if ($this->selectedRQ) {
                $this->selectedRQ->update([
                    'ApprovateVPresident' => 0,
                    'ApprovateVPresidentName' => $user->name,
                    'ApprovateVPresidentDate' => Carbon::today(),
                    'StatusList_id' => 50
                ]);
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 50, //48 es el estatus de rechazo de comprador
                    'remark' => 'Rechazada por ' . Auth::user()->name,
                ]);
            }
            session()->flash('message', ($this->selectedRQ->StatusList_id == 50) ? 'La Requisición ha sido rechazada' : 'La Requisición no ha podido ser rechazada');
            $this->CloseAllModals();
            $this->RQRemark = null;
        } catch (\Exception $e) {
            Log::error('Error al rechazar la PO por VP: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al rechazar la PO por VP.');
        }
    }    
}