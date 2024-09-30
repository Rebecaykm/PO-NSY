<?php

namespace App\Http\Livewire\Requisition;

use App\Models\CostCenter;
use App\Models\Quote;
use App\Models\QuoteFile;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestQuote;
use App\Models\StatusList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ApproverRequestsShow extends Component
{
    use WithPagination;
    public $search, $selectedStatus, $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC', $cadena;
    public $selectedRQ = null, $selectedRQLine = null, $perPage = 10, $selectedRQL = null; 
    public $departmentId, $lengthRQ = 0, $RQRemark = null;
    public $showQuoteModal = true, $showConfirmApprovalModal = true, $showConfirmRejectModal = true;
    public $close = true, $open = false;
    public $startDate = null, $endDate = null, $status = null;
    public $user = null, $users = null, $selectedUser = null;
    public $departmentIds = null;
    public $quotes = null;
    public $costCenterIds = null;

    public function mount()
    {
        try {
            $this->user = Auth::user();
            $this->status = StatusList::where('Status', 1)->whereIn('id', [14, 15, 42])->get();
            $this->departmentIds = $this->user->authorization->where('Status', 1)->pluck('Department_id');
            $this->costCenterIds = CostCenter::whereIn('Department_id',  $this->departmentIds)->pluck('id');
            $this->users = User::whereIn('Department_id', $this->departmentIds)->get();
            
        } catch (\Exception $e) {
            Log::error('Error initializing component: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al inicializar el componente.');
        }
    }

    public function render()
    {
        $this->quotes = $this->getQuotes();
        return view('livewire.requisition.approver-requests-show', [
            'requestQuotes' => $this->getRequestQuote(),
            'RQLines'       => $this->getRequestQuoteLine(),
            'quotes'        => $this->quotes,
            'files'         => $this->getFiles(),
        ]);
    }

    public function getRequestQuote()
    {
        try {
            $query = RequestQuote::whereIn('CostCenter_id', $this->costCenterIds)
                ->whereIn('StatusList_id', [14, 15, 42])
                ->orderBy($this->selectedOrderBy, $this->selectedOrder);

            if ($this->search) {
                $query->where(function ($q) {
                    $q->where('RFQ', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->selectedStatus) {
                $query->where('StatusList_id', $this->selectedStatus);
            }

            if ($this->selectedUser) {
                $query->where('User_id', $this->selectedUser);
            }

            if ($this->startDate && $this->endDate) {
                $query->whereBetween('updated_at', [$this->startDate, $this->endDate]);
            } elseif ($this->startDate) {
                $query->where('updated_at', '>=', $this->startDate);
            } elseif ($this->endDate) {
                $query->where('updated_at', '<=', $this->endDate);
            }

            return $query->paginate($this->perPage);
        } catch (\Exception $e) {
            Log::error('Error fetching request quotes: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las cotizaciones de solicitud.');
        }
    }

    public function getRequestQuoteLine()
    {
        try {
            return ($this->selectedRQ) ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)->where('status',true)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error fetching request quote lines: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las líneas de cotización de solicitud.');
        }
    }

    public function selectRQ($RQ_id)
    {
        try {
            $this->selectedRQ = RequestQuote::find($RQ_id);
        } catch (\Exception $e) {
            Log::error('Error selecting request quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la cotización de solicitud.');
        }
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
    public function getQuoteLine()
    {
        try {
            return ($this->selectedRQ) ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)->where('status',true)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener líneas de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener líneas de cotización.');
            return collect();
        }
    }

    public function selectOrderFlag($field)
    {
        try {
            $this->selectedOrderBy = $field;
            $this->selectedOrder = ($this->selectedOrder === 'ASC') ? 'DESC' : 'ASC';
        } catch (\Exception $e) {
            Log::error('Error updating order flag: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar el indicador de orden.');
        }
    }

    public function updatingSearch()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error updating search: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar la búsqueda.');
        }
    }

    public function updatingSelectedOrderBy()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error updating order by: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar el ordenamiento.');
        }
    }

    public function updatingSelectedOrder()
    {
        try {
            $this->resetPage();
        } catch (\Exception $e) {
            Log::error('Error updating order: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar el orden.');
        }
    }

    public function resetPage()
    {
        try {
            $this->reset('page');
        } catch (\Exception $e) {
            Log::error('Error resetting page: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al restablecer la página.');
        }
    }

    public function OpenModelShowQuote()
    {
        $this->showQuoteModal = $this->open;
        $this->selectedRQLine = null;
    }

    public function OpenModalConfirmApproval()
    {
        $this->showConfirmApprovalModal = $this->open;
    }

    public function OpenModalConfirmReject()
    {
        $this->showConfirmRejectModal = $this->open;
    }

    public function CloseModelShowQuote()
    {
        $this->showQuoteModal = $this->close;
        $this->selectedRQLine = null;
        $this->quotes = null;
    }

    public function CloseModalConfirmApproval()
    {
        $this->showConfirmApprovalModal = $this->close;
    }

    public function CloseModalConfirmReject()
    {
        $this->showConfirmRejectModal = $this->close;
    }

    public function CloseAllModals()
    {
        $this->showQuoteModal = $this->close;
        $this->showConfirmApprovalModal = $this->close;
        $this->showConfirmRejectModal = $this->close;
    }

    public function clearFilters()
    {
        try {
            $this->selectedStatus = null;
            $this->search = null;
            $this->selectedUser = null;
            $this->startDate = null;
            $this->endDate = null;
            $this->selectedRQ = null;
            $this->selectedRQL = null;
        } catch (\Exception $e) {
            Log::error('Error clearing filters: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al limpiar los filtros.');
        }
    }

    public function ApproveRQ()
    {
        try {
            $user = Auth::user();
            if ($this->selectedRQ) {
                $this->selectedRQ->update([
                    'ManagerApprovate' => 1,
                    'ManagerApprovateName' => $user->name,
                    'ManagerApprovateDate' => Carbon::today(),
                    'StatusList_id' => 15,
                ]);
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 15,
                ]);
                session()->flash('success', 'La Requisición ha sido aprobada.');
            } else {
                session()->flash('error', 'La Requisición no pudo ser aprobada.');
            }
            $this->closeAllModals();
        } catch (\Exception $e) {
            Log::error('Error approving request quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al aprobar la requisición.');
        }
    }

    public function RejectRQ()
    {
        try {
            $user = Auth::user();
            $this->validate(['RQRemark' => 'required|min:10|max:300']);
            if ($this->selectedRQ) {
                $this->selectedRQ->update([
                    'ApprovateRQ' => 0,
                    'ManagerApprovateRQ' => $user->name,
                    'StatusList_id' => 42,
                ]);
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 42,
                ]);
                session()->flash('success', 'La Requisición ha sido rechazada.');
            } else {
                session()->flash('error', 'La Requisición no pudo ser rechazada.');
            }
            $this->closeAllModals();
            $this->RQRemark = null;
        } catch (\Exception $e) {
            Log::error('Error rejecting request quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al rechazar la requisición.');
        }
    }
}
