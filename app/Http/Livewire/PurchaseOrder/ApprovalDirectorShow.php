<?php

namespace App\Http\Livewire\PurchaseOrder;

use App\Models\Quote;
use App\Models\QuoteFile;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestQuote;
use App\Models\StatusList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ApprovalDirectorShow extends Component
{
    use WithPagination;
    public $selectedStatus, $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC', $cadena;
    public $searchRQ;
    public $selectedRQStatus;
    public $startDate;
    public $endDate;
    public $status;
    public $selectedRQId = null;

    public $selectedRQ = null,  $perPage = 10, $page = 1;
    public $departmentId, $lengthRQ = 0, $RQRemark = null;
    public $showQuoteModal = true, $showConfirmApprovalModal = true, $showConfirmRejectModal = true;
    public $close = true, $open = false;
    
    protected $queryString = ['searchRQ', 'page', 'selectedOrderBy', 'selectedOrder', 'selectedRQStatus', 'startDate', 'startDate'];
    public $selectedRQLine = null;

    protected $rules = [
        'RQRemark' => 'required|min:10|max:300'
    ];

    public function mount()
    {
        $this->status = StatusList::whereIn('id',[23, 28, 49])->get();
    }

    public function render()
    {
        return view('livewire.purchase-order.approval-director-show',[
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
            $query = RequestQuote::whereIn('StatusList_id', [23, 28, 49])
            ->orderBy($this->selectedOrderBy, $this->selectedOrder);

            if ($this->searchRQ) {
                $query->where(function($q) {
                    $q->where('RFQ', 'like', '%' . $this->searchRQ . '%');
                });
            }
        
            // Filtro por estatus seleccionado
            if ($this->selectedRQStatus) {
                $query->where('StatusList_id', $this->selectedRQStatus);
            }
            // dd($this->selectedRQStatus);
        
            // Filtro por rango de fechas en la última fecha de actualización
            if ($this->startDate && $this->endDate) {
                $query->whereBetween('updated_at', [$this->startDate . ' 00:00:00.000', $this->endDate . ' 23:59:59.000']);
            } elseif ($this->startDate) {
                $query->where('updated_at', '>=', $this->startDate . ' 23:59:59.000');
            } elseif ($this->endDate) {
                $query->where('updated_at', '<=', $this->endDate . ' 23:59:59.000');
            }
            
            return $query->paginate($this->perPage);
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
            $this->selectedRQId = $RQ_id;
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
            $this->selectedRQLine = null;
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

    // public function clearFilters()
    // {
    //     try {
    //         $this->selectedStatus = null;
    //         $this->searchRQ = null;
    //         $this->selectedRQ = null;
    //         $this->closeModal();
    //     } catch (\Exception $e) {
    //         Log::error('Error al limpiar filtros: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al limpiar filtros.');
    //     }
    // }
    public function DirectorApprovePO()
    {
        if ($this->selectedRQ) {
            $this->selectedRQ->update([
                'ApprovateDirectorDate' => Carbon::today(),
                'ApprovateDirector' => Auth::user()->name,
                'Director_id' => Auth::user()->id,
                'ApprovatePODirector' => true,
                'StatusList_id' => 23
            ]);

            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 23,
                'remark' => 'Aprobada por ' . Auth::user()->name,
            ]);

            session()->flash('message', 'La Requisición ha sido aprobada');
        } else {
            session()->flash('message', 'La Requisición no ha podido ser aprobada');
        }

        $this->closeAllModals();
    }

    public function DirectorRejectRQ()
    {
        $this->validate();

        if ($this->selectedRQ) {
            $this->selectedRQ->update([
                'ApprovatePODirector' => false,
                'ApprovateDirector' => Auth::user()->name,
                'Director_id' => Auth::user()->id,
                'StatusList_id' => 49
            ]);

            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 49,
                'remark' => 'Rechazada por ' . Auth::user()->name,

            ]);

            session()->flash('message', 'La Requisición ha sido rechazada');
        } else {
            session()->flash('message', 'La Requisición no ha podido ser rechazada');
        }

        $this->closeAllModals();
        $this->RQRemark = null;
    }
}
