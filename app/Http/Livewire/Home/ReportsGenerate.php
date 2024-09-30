<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\CostCenter;
use App\Models\Folio;
use App\Models\GCC;
use App\Models\Item;
use App\Models\MeasurementUnits;
use App\Models\Project;
use App\Models\Quote;
use App\Models\QuoteFile;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestAuthorization;
use App\Models\RequestQuote;
use App\Models\RequestRequisition;
use App\Models\StatusList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class ReportsGenerate extends Component
{
    use WithPagination;
    //Funcionamiento general

    public $startDate;
    public $endDate;
    public $searchRQ;
    public $selectedRQStatus;
    public $selectedRQOrderBy = 'RFQ', $selectedRQOrder = 'DESC';
    public $selectedDepartment = null;
    public $selectedItem = null;
    public $selectedCostCenter = null;
    public $showConfirmCancelModal = true;
    public $selectedRQ = null;
    public $selectedRQLine = null;
    public $selectedQuote = null;
    public $modeRQ;
    public $perPage = 10;
    public $RQLineID = null;
    public $RQdescription;
    public $RQDepartmentRequest_id;
    public $RQuser_id;
    public $RQStatusList_Id;
    public $RQNomina = null;
    public $RQCostCenter_id = null;
    public $RQProject_id = null;
    public $showHistoryModal = true;
    public $showSelectedQuoteModal = true, $showCreateRIModal = true;
    public $close = true, $open = false;
    public $showLinesQuoteModal = true;
    public $RQL_imgPath = null;
    public $RQLname = null, $RQLdescription = null, $RQLquantity = null, $RQLdateRequired = null, $RQLStatusList_Id = null;
    public $RQLQuoteRequest_id = null, $RQLItem_id = null, $RQLCostCenter_id = null, $RQLMeasurementUnit_id = null, $RQLQuote_id = null;
    protected $queryString = ['searchRQ', 'page', 'selectedRQOrderBy', 'selectedRQOrder'];
    public function render()
    {

        $measurementUnits = MeasurementUnits::where('status',true)->orderBy('name','asc')->get();
        $costCenters = CostCenter::where('status',true)->orderBy('Department_id','asc')->get();
        $projects = Project::where('status',true)->orderBy('name','asc')->get();

        $files = ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;

        return view('livewire.home.reports-generate',compact('costCenters','projects','measurementUnits','files'),[
            'requestQuotes' => $this->getRequestQuotes(),
            'RQLines'       => $this->getRequestQuoteLines(),
            'RQHistory'     => $this->getHistory(),
            'items' => $this->getItems(),
            'status' => $this->getStatusList(),
        ]);
    }
    public function getStatusList()
    {
        return StatusList::all();
    }
    public function getItems()
    {
        return Item::where('status',true)->orderBy('name','asc')->get();
    }
    public function getRequestQuoteLines()
    {
        return  $this->selectedRQ ? QuoteLine::where('QuoteRequest_id',$this->selectedRQ->id)
                                        ->where('status',true)
                                        ->orderBy('id','ASC')
                                        ->get()
                                    : null;
    }

    public function getHistory()
    {
        return $this->selectedRQ ?  QuoteHistory::where('QuoteRequest_id',$this->selectedRQ->id)->get()
                                : null;
    }

    public function getRequestQuotes()
    {
        $query = RequestQuote::orderBy($this->selectedRQOrderBy,$this->selectedRQOrder);

        if ($this->searchRQ) {
            $query->where(function($q) {
                $q->where('RFQ', 'like', '%' . $this->searchRQ . '%')
                    ->orWhere('description', 'like', '%' . $this->searchRQ . '%');
            });
        }
    
        // Filtro por estatus seleccionado
        if ($this->selectedRQStatus) {
            $query->where('StatusList_id', $this->selectedRQStatus);
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


    public function selectOrderFlag($field){
        if ($this->selectedQuote){ $this->selectedRQOrderBy = $field; }
        $this->selectedRQOrder = ($this->selectedRQOrder === 'ASC') ? 'DESC' : 'ASC';
    }

    public function selectRQ($RQ_ID){ $this->selectedRQ = RequestQuote::find($RQ_ID); }
    public function selectRQLine($RQL_ID){ $this->selectedRQLine = QuoteLine::find($RQL_ID); }
    public function selectQuote($rowID){ $this->selectedRQLine = Quote::find($rowID);}

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
    private function resetInputFields(){
        $this->RQNomina = null;
        $this->RQdescription = null;
        $this->RQLItem_id = null;
        $this->RQLCostCenter_id = null;
        $this->RQL_imgPath = null;
        $this->RQLname = null;
        $this->RQLdescription = null;
        $this->RQLquantity = null;
        $this->RQLdateRequired = null;
        $this->RQLStatusList_Id = null;
        $this->RQLQuoteRequest_id = null;
        $this->RQLItem_id = null;
        $this->RQLCostCenter_id = null;
        $this->RQLMeasurementUnit_id = null;
        $this->RQLQuote_id = null;
    }

    public function clearFilters(){
        $this->startDate = null;
        $this->endDate = null;
        $this->searchRQ = null;
        $this->selectedRQStatus = null;
        $this->searchRQ = null;
        $this->selectedRQ = null;
        $this->reset(['searchRQ', 'page']);
    }

    public function resetInputRQL(){
        $this->RQL_imgPath = null;
        $this->RQLItem_id = null;
        $this->selectedItem = null;
        $this->RQLname = null;
        $this->RQLdescription = null;
        $this->RQLquantity = null;
        $this->RQLdateRequired = null;
        $this->RQLStatusList_Id = null;
        $this->RQLQuoteRequest_id = null;
        $this->RQLCostCenter_id = null;
        $this->RQLMeasurementUnit_id = null;
        $this->RQLQuote_id = null;
    }


    public function chargeData(){
        $this->RQL_imgPath        = $this->selectedRQLine->imgPath;
        $this->RQLname            = $this->selectedRQLine->name;
        $this->RQLdescription     = $this->selectedRQLine->description;
        $this->RQLquantity        = $this->selectedRQLine->quantity;
        $this->RQLdateRequired    = $this->selectedRQLine->dateRequired;
        $this->RQLStatusList_Id   = $this->selectedRQLine->StatusList_Id;
        $this->RQLQuoteRequest_id = $this->selectedRQLine->QuoteRequest_id;
        $this->RQLItem_id         = $this->selectedRQLine->Item_id;
        $this->RQLCostCenter_id   = $this->selectedRQLine->CostCenter_id;
        $this->RQLMeasurementUnit_id = $this->selectedRQLine->MeasurementUnit_id;
    }

    /********** MÉTODOS PARA ABRIR MODALES **********/

    

    public function OpenModalLinesQuote(){$this->showLinesQuoteModal = $this->open;}
    public function OpenModalHistory(){$this->showHistoryModal = $this->open;}


    /********** MÉTODOS PARA CERRAR MODALES **********/
    
    public function closeModalLinesQuote(){
        $this->showLinesQuoteModal = $this->close;
        $this->selectedRQLine =null;
    }


    public function closeModalHistory(){$this->showHistoryModal = $this->close;}
    public function CloseModalConfirmCancel(){$this->showConfirmCancelModal = $this->close; }
    
    public function closeAllModals(){
        $this->showLinesQuoteModal = $this->close;
        $this->showHistoryModal = $this->close;
        $this->showCreateRIModal = $this->close;
    }


    public function CancelQuote(){
        $this->selectedRQ->update([
            'StatusList_id' => 39,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRQ->id,
            'StatusList_id' => 39,
        ]);
    }

    public function createQuote(){
        // Validación de datos de entrada
        $this->validate([
            'RQCostCenter_id' =>  'required|exists:cost_centers,id',
            'RQProject_id' => 'required|exists:projects,id',
            'RQNomina' => 'required|string|min:5|max:5',
            'RQdescription' => 'required|string|min:10|max:300',
        ]);
        $nombreNomina = DB::connection('external_db')
            ->table('tblTrabajador')
            ->select('Nombre')
            ->where('Trabajador', $this->RQNomina)
            ->first();
        
        // $nombreNomina = "TEST";

         // Validamos que el nombreNomina se haya encontrado
        if ($nombreNomina) {        

            // Asignación automática de RFQ (Número de Solicitud de Cotización)
            $folio_RFQ = Folio::findOrFail(1); //Folio Correspondiente a Cotizaciones
            $RFQ = str_pad($folio_RFQ->folio, 8, '0', STR_PAD_LEFT); // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
            $folio_RFQ->update(['folio' => $folio_RFQ->folio + 1]);  // Actualizamos el último número del seguimiento en la Tabla Folio
            $user = Auth::user(); // Consultamos la información del Usuario Autentificado

            // Obtenemos el Departamento del centro de costos seleccionado
            $department_id = CostCenter::findOrFail($this->RQCostCenter_id)->department->id;
            
            // Creamos la Cotización
            $quote = RequestQuote::create([
                'RFQ' => $RFQ,
                'PID' => 'QU',
                'description' => $this->RQdescription,
                'Department_id' => $department_id,
                'Nomina' => $this->RQNomina,
                'UserName' => $nombreNomina ? $nombreNomina->Nombre : null,
                // 'UserName' => $nombreNomina,
                'User_id' => $user->id,
                'CostCenter_id' => $this->RQCostCenter_id,
                'Project_id' => $this->RQProject_id,
                'StatusList_id' => 1,
            ]);

            if ($quote) {
                QuoteHistory::create([
                    'QuoteRequest_id' => $quote->id,
                    'StatusList_id' => $quote->statusList->id,
                ]);
                    $this->RQCostCenter_id = null;
                    $this->RQProject_id = null;
                    $this->RQNomina = null;
                    $this->RQdescription = null;
                $this->selectRQ($quote->id);
                $this->closeModalCreateQuote();
                $this->OpenModalLinesQuote();
            }
            else {
                $this->closeModalCreateQuote();
                session()->flash('error', 'No se ha logrado continuar con el proceso, por favor inténtelo nuevamente');
            }
        }
        else {
            $this->closeModalCreateQuote();
            session()->flash('error', 'Registro de número de nomina invalido, intente nuevamente');
        }
    }
    


    public function DeleteLineQuote(){
        $this->selectedRQLine->update([
            'status' => false,
        ]);
        $this->closeModalConfirmDeleteLineQuote();
    }

    public function sendQuoteToBuyer()
    {
        $this->selectedRQ->update([
            'StatusList_id' => 2,
            'remarks1' => null,
        ]);

        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRQ->id,
            'StatusList_id' => 2,
        ]);

        if ($this->selectedRQ->StatusList_id == 2) {
            $this->closeModalConfirmSendQuoteSupplier();
            $this->closeModalLinesQuote();
            session()->flash('success', 'La cotización ' . $this->selectedRQ->RFQ . ' ha sido enviada a compras con éxito');
        } else {
            session()->flash('error', 'Ocurrió un error, intente más tarde.');
        }
    }    
}
