<?php

namespace App\Http\Livewire\Requisition;

use Livewire\Component;
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
use Livewire\WithPagination;

class ApprovalRequisitions extends Component{
    use WithPagination;
    public $search, $selectedStatus, $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC', $cadena;
    public $selectedRQ = null, $selectedRQLine = null, $perPage = 10, $selectedRQL = null;
    public $departmentId, $lengthRQ = 0, $RQRemark = null;
    public $showQuoteModal = true, $showConfirmApprovalModal = true, $showConfirmRejectModal = true;
    public $close = true, $open = false;
    public $startDate = null, $endDate = null, $status = null;
    public $user = null, $users = null, $selectedUser = null;
    public $quotes = null;
    public $departmentIds = null;
    public $costCenterIds = null;
    public function mount()
    {
        // Obtener el usuario autenticado
        $this->user = Auth::user();
        $this->status = StatusList::where('Status', 1)->whereIn('id', [13, 14, 41])->get();
        // Obtener los IDs de los departamentos a los que tiene acceso el usuario
        $this->departmentIds = $this->user->authorization->where('Status',true)->pluck('Department_id');
        // Obtener los centros de costos asociados a los departamentos a los que tiene acceso el usuario
        $this->costCenterIds = CostCenter::whereIn('Department_id', $this->departmentIds)->pluck('id');
        $this->users = User::whereIn('Department_id', $this->departmentIds)->get();
    }
    
    public function render()
    {
        $this->quotes = $this->getQuotes();
        return view('livewire.requisition.approval-requisitions',[
            'requestQuotes' => $this->getRequestQuote(),
            'RQLines' => $this->getRequestQuoteLine(),
            'files' => $this->getFiles(),
            'quotes' => $this->quotes,
        ]);
    }
    public function getRequestQuote()
    {
        try{
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        // Consulta base para obtener las líneas de cotización autorizadas para el usuario actual
        $quoteLineQuery = QuoteLine::whereHas('costCenter.department.authorization', function ($query) use ($userId) {
            // Filtrar por el ID del usuario y el estado autorizado
            $query->where('User_id', $userId)
                ->where('Status', true); // Aquí se agrega la condición para el campo Status
        });
        // Obtener las líneas de cotización paginadas
        $quoteLines = $quoteLineQuery->get();
        // Obtener los ID únicos de los QuoteRequest asociados a los QuoteLine
        $quoteRequestIds = $quoteLines->pluck('QuoteRequest_id')->unique();
        
        // Consulta para obtener los QuoteRequest asociados a los QuoteLine sin duplicados
        $query = RequestQuote::whereIn('id', $quoteRequestIds)
                                    ->whereIn('StatusList_id',[13,14,41])
                                    ->orderBy($this->selectedOrderBy,$this->selectedOrder);

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
        return ($this->selectedRQ) ? QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)
                                                ->whereIn('CostCenter_id',$this->costCenterIds)
                                                ->where('status',true)
                                                ->get() : null;
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
            return ($this->selectedRQ) ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener líneas de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener líneas de cotización.');
            return collect();
        }
    }
    public function selectOrderFlag($field){
        $this->selectedOrderBy = $field;
        $this->selectedOrder = ($this->selectedOrder === 'ASC') ? 'DESC' : 'ASC';
    }
    public function OpenModelShowQuote()
    {
        $this->showQuoteModal = $this->open;
        
    }

    public function OpenModalShowQuote(){$this->showQuoteModal = $this->open;}
    public function OpenModalConfirmApprove(){ $this->showConfirmApprovalModal = $this->open;}
    public function OpenModalConfirmReject(){ $this->showConfirmRejectModal = $this->open;}
    
    public function CloseModalShowQuote(){
        $this->showQuoteModal = $this->close;
        $this->selectedRQLine = null;
        $this->quotes = null;
    }
    public function CloseModalConfirmApprove(){ $this->showConfirmApprovalModal = $this->close;}
    public function CloseModalConfirmReject(){ $this->showConfirmRejectModal = $this->close;}
    
    public function closeAllModals(){
        $this->showQuoteModal = $this->close;
        $this->showConfirmApprovalModal = $this->close;
        $this->showConfirmRejectModal = $this->close;
    }
    
    public function clearFilters(){
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedRQ = null;
        $this->closeAllModals();
    }
    
    public function ApproveLines(){
        $user = Auth::user();

        // Obtener los IDs de los departamentos a los que tiene acceso el usuario
        $departmentIds = $user->authorization->pluck('Department_id');
        $costCenterIds = CostCenter::whereIn('Department_id', $departmentIds)->pluck('id');
        if($this->selectedRQ){ 
            $RQLines = QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)
                                ->where('status',true)
                                ->whereIn('CostCenter_id',$costCenterIds)->get(); 
        }
        $RQLines->toQuery()->update([
            'Approvate' => true,
            'ApprovateName' => $user->name,
            'ApprovateDate' => Carbon::today(),
            'StatusList_id' => 14 
        ]);

        sleep(2);
        
        $flag1 = true;
        foreach($RQLines as $RQL){ 
            if(!$RQL->Approvate) 
                $flag1 = false; 
        }
        
        if($this->selectedRQ){ 
            $RQLines = QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)->where('status',true)->get(); 
        }
        
        $flag2 = true;
        foreach($RQLines as $RQL){
            if(!$RQL->Approvate) 
                $flag2 = false; 
        }

        sleep(2);

        $RQLines->toQuery()->update([
            'Approvate' => true,
            'ApprovateName' => $user->name,
            'ApprovateDate' => Carbon::today(),
            'StatusList_id' => 14 
        ]);


        $flag1 = true;
        foreach($RQLines as $RQL){ 
            if(!$RQL->Approvate) 
                $flag1 = false; 
        }
        
        if($this->selectedRQ){ 
            $RQLines = QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)->where('status',true)->get(); 
        }
        
        $flag2 = true;
        foreach($RQLines as $RQL){
            if(!$RQL->Approvate) 
                $flag2 = false; 
        }

        if($flag1) 
            if($flag2){
                $this->selectedRQ->update([ 
                    'ApprovateLinesDate' => Carbon::today(), 
                    'ApprovateLines' => true ,
                    'StatusList_id' => 14 , 
                ]);
                session()->flash('message', 'Las lineas han sido aprobadas :) '); 
            }
            else
                session()->flash('message', 'Las lineas han sido aprobadas, sin embargo falta aprobación de otras áreas.'); 
        else{
            session()->flash('message', 'Las lineas no han podido ser aprobadas :( , intenta mas tarde.'); 
        }

        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRQ->id,
            'StatusList_id' => 14,
        ]);

        $this->closeAllModals();
        $this->selectedRQ = null;
    }

    public function RejectLines(){
        $this->validate(['RQRemark' => 'required|min:10|max:300']);
        $user = Auth::user();
        // Obtener los IDs de los departamentos a los que tiene acceso el usuario
        $departmentIds = $user->authorization->pluck('Department_id');
        $costCenterIds = CostCenter::whereIn('Department_id', $departmentIds)->pluck('id');
        if($this->selectedRQ){ 
            $RQLines = QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)->whereIn('CostCenter_id',$costCenterIds)->where('status',true)->get(); 
        }
        $RQLines->toQuery()->update(['Approvate' => false, 'StatusList_id' => 41 ]);
        $this->selectedRQ->update([ 'StatusList_id' => 41, 'ApprovateLines' => false ]);

        if($this->selectedRQ->StatusList_id == 41){ session()->flash('message', 'La Requisición a sido rechazada'); }
        else{ session()->flash('message', 'La Requisición no a podido ser rechazada, por favor intente nuevamente'); }
        $this->closeAllModals();
        $this->selectedRQ = null;
        $this->RQRemark = null;
    }
}
