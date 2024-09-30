<?php

namespace App\Http\Livewire\Requisition;

use App\Models\Buyer;
use App\Models\Quote;
use App\Models\QuoteFile;
use Livewire\Component;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestQuote;
use App\Models\RequestRequisition;
use App\Models\YH120;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class WarehouseReception extends Component
{
    use WithPagination;
    public $search, $selectedStatus, $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC', $cadena;
    public $selectedQT = null, $selectedRQ = null, $selectedRQLine = null,  $perPage = 10;
    public $buyers;
    public $departmentId;
    public $selectedBuyer = null;
    public $requestRequisitionIds = []; // IDs de las requisiciones

    public $showConfirmAssignmentModal = true, $showAssignmentBuyerModal = true;
    public $close = true, $open = false;
    public $link_uuid = null;
    public $uuid = null;
    public $showReceptionRQLineModal = true;
    public $requestQuotes = null;
    public $quotes = null;

    public function mount()
    {
        $this->buyers = Buyer::all(); // Cargar todos los compradores.
    }

    public function render()
    {
        $this->quotes = $this->getQuotes();
        return view('livewire.requisition.warehouse-reception', [
            'requestRequisitions' => $this->getRequestRequisitions(),
            'RQLines' => $this->getRequestRequisitionLine(),
            'quotes'  => $this->quotes,
            'files'  => $this->getFiles(),
        ]);
    }

    protected function getRequestRequisitions()
    {
        try {
            $allRR = RequestRequisition::pluck('PPO')->unique()->toArray();
            $recepcionadas = YH120::whereIn('RHORD', $allRR)->pluck('RHORD')->unique()->toArray();

            // Convertir los valores de RHORD a strings
            $recepcionadas_str = array_map('strval', $recepcionadas);

            // Obtener los IDs de los registros de RequestRequisition cuyo campo PPO esté en la lista recepcionadas
            $this->requestRequisitionIds = RequestRequisition::whereIn('PPO', $recepcionadas_str)->pluck('id')->toArray();

            // Retornar los registros completos paginados
            return RequestRequisition::whereIn('id', $this->requestRequisitionIds)->paginate($this->perPage);
        } catch (\Exception $e) {
            Log::error('Error al cargar las requisiciones de pla requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al intentar cargar las requisiciones.');
            return collect(); // Retorna una colección vacía en caso de error
        }
    }

    protected function getRequestRequisitionLine()
    {
        try {
            return ($this->selectedRQ) ? QuoteLine::where('PPO', $this->selectedRQ->PPO)
                                                ->where('status',true)
                                                ->orderBy('numLine', 'ASC')->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al cargar líneas de requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al intentar cargar las líneas de requisición.');
            return collect(); // Retorna una colección vacía en caso de error
        }
    }

    public function resetPage()
    {
        try {
            $this->reset('page');
        } catch (\Exception $e) {
            Log::error('Error al resetear la página: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al resetear la página.');
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

    public function selectQT($QT_ID) { $this->selectedQT = RequestQuote::find($QT_ID); }
    public function selectRQ($RQ_ID) { $this->selectedRQ = RequestRequisition::find($RQ_ID); }
    public function selectRQLine($RQL_ID) { $this->selectedRQLine = QuoteLine::find($RQL_ID); }

    public function selectOrderFlag($field)
    {
        $this->selectedOrderBy = $field;
        $this->selectedOrder = $this->selectedOrder === 'ASC' ? 'DESC' : 'ASC';
    }

    public function OpenModalReceptionLine() { $this->showReceptionRQLineModal = $this->open; }
    public function OpenModalConfirmAssigment() { $this->showConfirmAssignmentModal = $this->open; }
    public function confirmAssignment() { $this->showConfirmAssignmentModal = $this->open; }
    public function assignmentBuyer() { $this->showAssignmentBuyerModal = $this->open; }
    public function CloseModalReceptionLine() { $this->showReceptionRQLineModal = $this->close; }
    public function CloseModalConfirmAssigment() { $this->showConfirmAssignmentModal = $this->close; }

    public function closeModal()
    {
        $this->showAssignmentBuyerModal = $this->close;
        $this->showConfirmAssignmentModal = $this->close;
        $this->showConfirmAssignmentModal = $this->close;
        $this->showAssignmentBuyerModal = $this->close;
    }

    public function clearFilters()
    {
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedRQ = null;
        $this->closeModal();
    }

    public function receptionRQL()
    {
        $requisitionsLines = QuoteLine::where('PPO',$this->selectedRQ->PPO)
                                        ->where('status',true)
                                        ->get();
        foreach ($requisitionsLines as $RQL) {
            
            $YH120row = YH120::query()
                    ->where('RHORD', $RQL->PPO)
                    ->where('RHLINE', $RQL->numLine)
                    ->first();
            
            if (!empty($YH120row)) {
                $patron = '/id¡(.*?)\//';
    
                if (preg_match($patron, $this->link_uuid, $coincidencias)) {
                    $filtrado = str_replace("'", "-", $coincidencias[1]);
                }
    
                $RQL->update([
                    'QuantityReturned' => intval($YH120row->RHQREC),
                    'dateArrival' => $YH120row->RHRDTE,
                    'StatusList_id' => 55,
                    'UUID' => $filtrado,
                ]);
    
                DB::connection('odbc-connection-lx834fu02')
                    ->table('LX834FU02.YH120')
                    ->where('RHORD', $RQL->PPO)
                    ->where('RHLINE', $RQL->numLine)
                    ->update([
                    'RHUUID' => $filtrado,
                    'RHWEB' => '1',
                ]);
    
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->QuoteRequest_id,
                    'StatusList_id' => 34, // 
                    'remark' => 'Recepcionada por ' . Auth::user()->name,
                ]);
                $this->uuid = null;
                $this->CloseModalConfirmAssigment();
                $this->CloseModalReceptionLine();
                $this->closeModal();
                session()->flash('success', 'La línea del RFQ: ' . $this->selectedRQ->RFQ . ' ha sido Recepcionada');
            } else {
                $this->closeModal();
                session()->flash('error', 'Aún no se ha recepcionado en INFOR.');
            }
        }
        $this->selectedRQ->update([
            'PickUp' => 1,
            'PickUpDate' => Carbon::today(),
            'PickUp_User_id' => Auth::user()->id,
        ]);
    }
}
