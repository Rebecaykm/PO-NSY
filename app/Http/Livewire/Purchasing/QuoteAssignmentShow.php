<?php

namespace App\Http\Livewire\Purchasing;

use App\Models\Buyer;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestQuote;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class QuoteAssignmentShow extends Component
{
    use WithPagination;
    public $search;
    public $selectedStatus;
    public $startDate;
    public $endDate;
    public $selectedOrderBy = 'updated_at';
    public $selectedOrder = 'desc';
    public $perPage = 10;
    public  $cadena;
    public  $selectedRQ = null;
    public  $departmentId, $lengthRQ = 0, $RQRemark = null;
    public  $selectedBuyer = null;
    public  $showConfirmAssignModal = true,
            $showAssignBuyerModal = true,
            $showConfirmRejectQuoteModal = true;
    public  $close = true, $open = false;
    public $buyers;
    public $dateRequiredQuote;
    public $showAssignDateToRequestQuote = true;
    protected $queryString = ['search','page','selectedStatus', 'selectedOrderBy', 'selectedOrder'];

    public function OpenModalAssignDateRequiredQuote(){ $this->showAssignDateToRequestQuote = $this->open;}
    public function CloseModalAssignDateRequiredQuote(){ $this->showAssignDateToRequestQuote = $this->close;}

    public function mount()
    {
        $this->buyers = User::whereHas('buyer', function ($query) {
            $query->where('PBTYP', 'B');
        })->get();
    }

    public function render(){        
        return view('livewire.purchasing.quote-assignment-show',[
            'requestQuotes' => $this->getRequestQuote(),
            'RQLines' => $this->getRequestQuoteLines(),
        ]);
    }
    public function getRequestQuoteLines()
    {
        return ($this->selectedRQ) ? QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)
                                                ->where('status',true)
                                                ->orderBy('id','ASC')
                                                ->get() : null; 
    }

    public function getRequestQuote()
    {
        // Base query con los estatus predeterminados
        $query = RequestQuote::whereIn('StatusList_id', [2, 3, 38])
                            ->orderBy($this->selectedOrderBy, $this->selectedOrder);
    
        // Filtro por palabra clave en RFQ o descripción
        if ($this->search) {
            $query->where(function($q) {
                $q->where('RFQ', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
    
        // Filtro por estatus seleccionado
        if ($this->selectedStatus) {
            $query->where('StatusList_id', $this->selectedStatus);
        }
    
        // Filtro por rango de fechas en la última fecha de actualización
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('updated_at', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('updated_at', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('updated_at', '<=', $this->endDate);
        }
    
        return $query->paginate($this->perPage);
    }
    

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedOrderBy()
    {
        $this->resetPage();
    }

    public function updatingSelectedOrder()
    {
        $this->resetPage();
    }

    public function resetPage()
    {
        $this->reset('page');
    }

    public function clearFilters(){
        $this->reset(['search','page']);
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedRQ = null;
    }


    public function selectRQ($RQ_id){ $this->selectedRQ = RequestQuote::find($RQ_id);    }

    public function selectOrderFlag($field){
        $this->selectedOrderBy = $field;
        if($this->selectedOrder === 'ASC'){$this->selectedOrder = 'DESC';}
        else {$this->selectedOrder = 'ASC';}
    }

    public function OpenModalAssignQuoteToBuyer(){ $this->showAssignBuyerModal = $this->open; }
    public function OpenModalConfirmAssignQuoteToBuyer(){ if($this->selectedBuyer){$this->showConfirmAssignModal = $this->open; }}
    public function OpenModalConfirmRejectQuote(){ $this->showConfirmRejectQuoteModal = $this->open; }
    public function CloseModalAssignQuoteToBuyer(){ $this->showAssignBuyerModal = $this->close; }
    public function CloseModalConfirmAssignQuoteToBuyer(){ $this->showConfirmAssignModal = $this->close; }
    public function CloseModalConfirmRejectQuote(){ 
        $this->showConfirmRejectQuoteModal = $this->close; 
    }

    public function CloseAllModals(){
        $this->showConfirmAssignModal = $this->close;
        $this->showAssignBuyerModal = $this->close;
        $this->showConfirmRejectQuoteModal = $this->close;
    }

    public function sendQuoteToBuyer(){
        $this->validate([ 'selectedBuyer' => 'required' ]);

        $buyer = Buyer::find($this->selectedBuyer);
        $this->selectedRQ->update([
            'StatusList_id' => 3,
            'Buyer_id' => $this->selectedBuyer,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRQ->id,
            'StatusList_id' => 3,
        ]);
        if($this->selectedRQ->StatusList_id == 3){ session()->flash('message', 'La cotización se a enviado a ' . $buyer->PBNAM . ' correctamente'); }
        else{ session()->flash('error', 'La cotización no  a sido enviada, vuelva a intentar más tarde'); }
        $this->CloseModalConfirmAssignQuoteToBuyer();
        $this->CloseModalAssignQuoteToBuyer();
    }


    public function RejectRequestQuote(){
        $this->selectedRQ->update([ 'StatusList_id' => 38, 'remarks1' => $this->RQRemark, 'Buyer_id' => null]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRQ->id,
            'StatusList_id' => 38,
            'remark' => $this->RQRemark,
        ]);
        $this->CloseModalConfirmRejectQuote();
    }

    public function AssignDateToRequestQuote(){
        $this->validate([
            'dateRequiredQuote' => ['required', function ($attribute, $value, $fail) {
                $date = Carbon::parse($value);
                if ($date->isWeekend()) {
                    $fail('No se permiten sábados y domingos.');
                } elseif ($date->isBefore(Carbon::today()->addDay())) {
                    $fail('La fecha debe ser a partir de mañana.');
                }
            }],
        ]);
        $this->selectedRQ->update([ 'dateRequiredQuote' =>  $this->dateRequiredQuote]);
        $this->dateRequiredQuote = null;
        $this->CloseModalAssignDateRequiredQuote();
    }

}
