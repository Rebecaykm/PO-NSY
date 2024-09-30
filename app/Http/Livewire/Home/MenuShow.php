<?php

namespace App\Http\Livewire\Home;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\{
    CostCenter, Folio, GCC, Item, MeasurementUnits, Project, Quote, QuoteFile, QuoteHistory, QuoteLine, RequestAuthorization, RequestQuote, RequestRequisition, StatusList
};
use Illuminate\Support\Facades\DB;

class MenuShow extends Component
{
    use WithFileUploads, WithPagination;
 
    public $searchRQ;
    public $test = ['1', '2', '3', '4'];
    public $selectedRQOrderBy = 'RFQ', $selectedRQOrder = 'DESC';
    public $startDate;
    public $endDate;
    public $perPage = 10;

    // Variables para almacenar los datos cargados en mount
    public $RQLineID = null;
    public $RQdescription;
    public $RQDepartmentRequest_id;
    public $RQuser_id;
    public $RQStatusList_Id;
    public $RQNomina = null;
    public $RQCostCenter_id = null;
    public $RQProject_id = null;
    public $RQL_imgPath = null;
    public $RQLname = null, $RQLdescription = null, $RQLquantity = null, $RQLdateRequired = null, $RQLStatusList_Id = null;
    public $RQLQuoteRequest_id = null, $RQLItem_id = null, $RQLCostCenter_id = null, $RQLMeasurementUnit_id = null, $RQLQuote_id = null;

    // Variables para los modales
    public $modeRQ;
    public $modeLine = null;
    public $showConfirmCancelModal = true;
    public $showUpdateLineQuoteModal= true;
    public $showConfirmDeleteLineQuoteModal = true;
    public $showConfirmGenerateRequisitionModal = true;
    public $showConfirmSelectionQuoteModal = true;
    public $showHistoryModal = true;
    public $showConfirmCancelQuoteModal = true;
    public $showConfirmSelectQuoteModal = true;
    public $showConfirmRequisitionQuoteModal = true;
    public $showConfirmSendQuoteBuyerModal = true;
    public $showSelectedQuoteModal = true;
    public $showCreateRIModal = true;
    public $showCreateQuoteModal = false;
    public $showLinesQuoteModal = true;
    public $close = true, $open = false;

    // Variables para selección de objetos
    public $selectedRQStatus;
    public $selectedDepartment = null;
    public $selectedItem = null;
    public $selectedCostCenter = null;
    public $selectedRQ = null;
    public $selectedRQLine = null;
    public $selectedQuote = null;
    
    // Variables para datos iniciales
    public $user;
    public $measurementUnits = null;
    public $costCenters = null;
    public $projects = null;
    public $items = null;
    public $status;
    public $exchangeRates;
    public $files = null;
    public $quotes = null;
    protected $requestQuotes = null;
    public $RQLines = null;
    public $RQHistory = null;

    protected $queryString = ['searchRQ', 'page', 'selectedRQOrderBy', 'selectedRQOrder', 'selectedRQStatus', 'startDate', 'startDate'];

    public function mount()
    {
        try {
            $this->user = Auth::user();
            $this->measurementUnits = MeasurementUnits::where('status', true)->orderBy('name', 'asc')->get();
            $this->costCenters = CostCenter::where('status', true)->orderBy('Department_id', 'asc')->get();
            $this->projects = Project::where('status', true)->orderBy('name', 'asc')->get();
            $this->items = Item::where('status', true)->orderBy('name', 'asc')->get();
            $this->status = StatusList::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 11, 12, 13, 14, 15, 16, 18, 19, 20, 21, 23])->get();
            
            // Obtener los archivos de cotización relacionados
            $quoteRequestIds = $this->getRequestQuotes()->pluck('id');
            $this->files = QuoteFile::whereIn('QuoteRequest_id', $quoteRequestIds)->get();
            
            $this->quotes = Quote::all();
            $this->RQLines = QuoteLine::whereIn('QuoteRequest_id', $quoteRequestIds)
                ->where('status', true)
                ->orderBy('id', 'ASC')
                ->get();
            $this->RQHistory = QuoteHistory::whereIn('QuoteRequest_id', $quoteRequestIds)->get();
            
        } catch (\Exception $e) {
            Log::error('Error al cargar los datos iniciales: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cargar los datos iniciales.');
        }
    }

    public function render()
    {
        return view('livewire.home.menu-show', [
            'requestQuotes' => $this->getRequestQuotes(),
        ]);
    }

    public function getRequestQuotes()
    {
        try {
            // Inicia la consulta con la base de datos, no la colección ya cargada
            $query = RequestQuote::where('User_id', $this->user->id);

            if ($this->searchRQ) {
                $query = $query->where('RFQ', 'like', '%' . $this->searchRQ . '%');
            }

            if ($this->selectedRQStatus) {
                $query = $query->where('StatusList_id', $this->selectedRQStatus);
            }

            if ($this->startDate && $this->endDate) {
                $query = $query->whereBetween('updated_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
            } elseif ($this->startDate) {
                $query = $query->where('updated_at', '>=', $this->startDate . ' 00:00:00');
            } elseif ($this->endDate) {
                $query = $query->where('updated_at', '<=', $this->endDate . ' 23:59:59');
            }

            // Paginar la consulta
            return $query->orderBy($this->selectedRQOrderBy, $this->selectedRQOrder)
                            ->paginate($this->perPage);
        } catch (\Exception $e) {
            Log::error('Error al obtener las cotizaciones de solicitud: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las cotizaciones de solicitud.');
            return collect();
        }
    }

    public function selectRQ($RQ_id)
    {
        try {
            $this->selectedRQ = $this->getRequestQuotes()->firstWhere('id', $RQ_id);
            if ($this->selectedRQ) {
                $this->selectedRQLine = null;
                $this->RQLines = $this->getRequestQuoteLines();
                $this->files = $this->getFiles();
            }
        } catch (\Exception $e) {
            Log::error('Error al seleccionar cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la cotización.');
        }
    }

    public function getFiles()
    {
        return ($this->selectedRQ) ? $this->files->where('QuoteRequest_id', $this->selectedRQ->id) : null;
    }

    public function getRequestQuoteLines()
    {
        return ($this->selectedRQ) ? $this->RQLines->where('QuoteRequest_id', $this->selectedRQ->id) : collect();
    }

    public function getHistory()
    {
        return ($this->selectedRQ) ? $this->RQHistory->where('QuoteRequest_id', $this->selectedRQ->id) : collect();
    }

    public function selectOrderFlag($field)
    {
        try {
            if ($this->selectedQuote) {
                $this->selectedRQOrderBy = $field;
            }
            $this->selectedRQOrder = ($this->selectedRQOrder === 'ASC') ? 'DESC' : 'ASC';
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la bandera de orden: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la bandera de orden.');
        }
    }
    
    
    
    public function selectRQLine($RQL_ID)
    {
        try {
            // Filtra la colección RQLines para obtener la línea seleccionada
            $this->selectedRQLine = $this->RQLines->find($RQL_ID);
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la línea de cotización.');
        }
    }

    
    public function selectQuote($rowID)
    {
        try {
            $this->selectedRQLine = $this->quotes->where('id',$rowID);
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la cotización.');
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
    
    private function resetInputFields()
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error al restablecer los campos de entrada: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al restablecer los campos de entrada.');
        }
    }
    
    public function clearFilters()
    {
        try {
            $this->selectedRQStatus = null;
            $this->searchRQ = null;
            $this->selectedRQStatus = null;
            $this->selectedRQ = null;
            $this->reset(['searchRQ', 'page']);
        } catch (\Exception $e) {
            Log::error('Error al limpiar los filtros: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al limpiar los filtros.');
        }
    }
    
    public function resetInputRQL()
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error al restablecer los campos de entrada de la línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al restablecer los campos de entrada de la línea de cotización.');
        }
    }
    
    public function chargeData()
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error al cargar los datos de la línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cargar los datos de la línea de cotización.');
        }
    }
    
    public function OpenModalUpdateLineQuote($modeLine)
    {
        try {
            $this->modeLine = $modeLine;
            if ($modeLine == 'create') {
                $this->resetInputRQL();
            }
            if ($modeLine == 'edit') {
                $this->chargeData();
            }
            $this->showUpdateLineQuoteModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de actualización de línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de actualización de línea de cotización.');
        }
    }    
    
    public function closeAllModals()
    {
        try {
            $this->showCreateQuoteModal = $this->close;
            $this->showUpdateLineQuoteModal = $this->close;
            $this->showLinesQuoteModal = $this->close;
            $this->showConfirmSendQuoteBuyerModal = $this->close;
            $this->showConfirmDeleteLineQuoteModal = $this->close;
            $this->showConfirmCancelQuoteModal = $this->close;
            // $this->showGenerateRequisitionModal = $this->close;
            $this->showHistoryModal = $this->close;
            $this->showCreateRIModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar todos los modales: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar todos los modales.');
        }
    }
    
    public function CancelQuote()
    {
        try {
            $this->selectedRQ->update([
                'StatusList_id' => 39,
            ]);
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 39,
            ]);
            $this->showConfirmCancelQuoteModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cancelar la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cancelar la cotización.');
        }
    }
    
    public function createQuote()
    {
        try {
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
            
            // Validamos que el nombreNomina se haya encontrado
            if ($nombreNomina) {
                // Asignación automática de RFQ (Número de Solicitud de Cotización)
                $folio_RFQ = Folio::findOrFail(1); //Folio Correspondiente a Cotizaciones
                $RFQ = str_pad($folio_RFQ->folio, 8, '0', STR_PAD_LEFT); // Rellenar con ceros a la izquierda para obtener una cadena de 8 caracteres
                $folio_RFQ->update(['folio' => $folio_RFQ->folio + 1]);  // Actualizamos el último número del seguimiento en la Tabla Folio
    
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
                    'User_id' => $this->user->id,
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
                    $this->showCreateQuoteModal = $this->close;
                    $this->showLinesQuoteModal = $this->open;
                } else {
                    $this->showCreateQuoteModal = $this->close;
                    session()->flash('error', 'No se ha logrado continuar con el proceso, por favor inténtelo nuevamente');
                }
            } else {
                $this->showCreateQuoteModal = $this->close;
                session()->flash('error', 'Registro de número de nomina invalido, intente nuevamente');
            }
        } catch (\Exception $e) {
            Log::error('Error al crear la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al crear la cotización.');
        }
    }
    
    
    public function createLineQuote()
    {
        try {
            if ($this->RQLItem_id) {
                $this->validate([
                    'RQLquantity'      => 'required|numeric',
                    'RQLdateRequired'  => 'required|date',
                    'RQLCostCenter_id' => 'required|exists:cost_centers,id',
                    'RQLItem_id'       => 'required|exists:items,id',
                ]);
    
                $Item = Item::findOrFail($this->RQLItem_id);
                $lineQuote = QuoteLine::create([
                    'imgPath'            => $Item->imgPath,
                    'name'               => $Item->name,
                    'description'        => $Item->description,
                    'quantity'           => $this->RQLquantity,
                    'Item_id'            => $this->RQLItem_id,
                    'CostCenter_id'      => $this->RQLCostCenter_id,
                    'MeasurementUnit_id' => $Item->MeasurementUnit_id,
                    'QuoteRequest_id'    => $this->selectedRQ->id,
                    'dateRequired'       => $this->RQLdateRequired,
                    'StatusList_id'      => 9,
                ]);
            } else {
                $this->validate([
                    'RQL_imgPath'           => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,zip,rar,pdf|max:15360', // 15 MB = 15360 KB
                    'RQLname'               => 'required|string|max:50',
                    'RQLdescription'        => 'nullable|string',
                    'RQLquantity'           => 'required|numeric',
                    'RQLdateRequired'       => 'required|date',
                    'RQLCostCenter_id'      => 'required|exists:cost_centers,id',
                    'RQLMeasurementUnit_id' => 'required|exists:measurement_units,id',
                ]);
    
                $imageName = null;
                if ($this->RQL_imgPath) {
                    $imageBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($this->RQLname, PATHINFO_FILENAME));
                    $imageExtension = $this->RQL_imgPath->extension();
                    $imageName = 'Item' . '_' . $this->selectedRQ->RFQ . '_' . $imageBaseName . '.' . $imageExtension;
    
                    // Store the image
                    $this->RQL_imgPath->storeAs('public/items', $imageName);
                }
    
                $lineQuote = QuoteLine::create([
                    'imgPath'            => $imageName,
                    'name'               => $this->RQLname,
                    'description'        => $this->RQLdescription,
                    'quantity'           => $this->RQLquantity,
                    'dateRequired'       => $this->RQLdateRequired,
                    'CostCenter_id'      => $this->RQLCostCenter_id,
                    'MeasurementUnit_id' => $this->RQLMeasurementUnit_id,
                    'QuoteRequest_id'    => $this->selectedRQ->id,
                    'StatusList_id'      => 9,
                ]);
            }
    
            RequestAuthorization::create([
                'RFQ'             => $this->selectedRQ->RFQ,
                'QuoteRequest_id' => $this->selectedRQ->id,
                'QuoteLine_id'    => $lineQuote->id,
                'Department_id'   => $this->selectedRQ->Department_id,
                'CostCenter_id'   => $lineQuote->CostCenter_id,
            ]);
    
            $this->resetInputFields();
            $this->selectRQ($this->selectedRQ->id);
            $this->showUpdateLineQuoteModal = $this->close;
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->closeAllModals();
            session()->flash('error', 'Un error ha ocurrido mientras procesaba la solicitud. Por favor intente nuevamente.');
            Log::error('Error creating line quote: ' . $e->getMessage());
        }
    }
    
    public function EditLineQuote()
    {
        try {
            if ($this->RQLItem_id) {
                $this->validate([
                    'RQLquantity'      => 'required|numeric',
                    'RQLdateRequired'  => 'required|date',
                    'RQLCostCenter_id' => 'required|exists:cost_centers,id',
                    'RQLItem_id'       => 'required|exists:items,id',
                ]);
    
                $Item = Item::findOrFail($this->RQLItem_id);
                $this->selectedRQLine->update([
                    'imgPath'            => $Item->imgPath,
                    'name'               => $Item->name,
                    'description'        => $Item->description,
                    'quantity'           => $this->RQLquantity,
                    'Item_id'            => $this->RQLItem_id,
                    'CostCenter_id'      => $this->RQLCostCenter_id,
                    'MeasurementUnit_id' => $Item->MeasurementUnit_id,
                    'QuoteRequest_id'    => $this->selectedRQ->id,
                    'dateRequired'       => $this->RQLdateRequired,
                    'StatusList_id'      => 9,
                ]);
            } else {
                $this->validate([
                    'RQL_imgPath'           => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,zip,rar,pdf|max:15360', // 15 MB = 15360 KB
                    'RQLname'               => 'required|string|max:50',
                    'RQLdescription'        => 'nullable|string',
                    'RQLquantity'           => 'required|numeric',
                    'RQLdateRequired'       => 'required|date',
                    'RQLCostCenter_id'      => 'required|exists:cost_centers,id',
                    'RQLMeasurementUnit_id' => 'required|exists:measurement_units,id',
                ]);
    
                $imageName = null;
                if ($this->RQL_imgPath) {
                    $imageBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($this->RQLname, PATHINFO_FILENAME));
                    $imageExtension = $this->RQL_imgPath->extension();
                    $imageName = 'Item' . '_' . $this->selectedRQ->RFQ . '_' . $imageBaseName . '.' . $imageExtension;
    
                    // Store the image
                    $this->RQL_imgPath->storeAs('public/items', $imageName);
                }
    
                $this->selectedRQLine->update([
                    'imgPath'            => $imageName,
                    'name'               => $this->RQLname,
                    'description'        => $this->RQLdescription,
                    'quantity'           => $this->RQLquantity,
                    'dateRequired'       => $this->RQLdateRequired,
                    'CostCenter_id'      => $this->RQLCostCenter_id,
                    'MeasurementUnit_id' => $this->RQLMeasurementUnit_id,
                    'QuoteRequest_id'    => $this->selectedRQ->id,
                    'StatusList_id'      => 9,
                ]);
            }
            $this->selectRQ($this->selectedRQ->id);
            $this->showUpdateLineQuoteModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error editing line quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al editar la línea de cotización.');
        }
    }
    
    public function DeleteLineQuote()
    {
        try {
            $this->selectedRQLine->update(['status' => false]);
            $this->showConfirmDeleteLineQuoteModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error deleting line quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al eliminar la línea de cotización.');
        }
    }
    
    public function sendQuoteToBuyer()
    {
        try {
            $this->selectedRQ->update([
                'StatusList_id' => 2,
                'dateRequiredQuote' => null,
            ]);
    
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 2,
            ]);
    
            if ($this->selectedRQ->StatusList_id == 2) {
                $this->showConfirmSendQuoteBuyerModal = $this->close;
                $this->showLinesQuoteModal = $this->close;
    //         $this->selectedRQLine = null;
                session()->flash('success', 'La cotización ' . $this->selectedRQ->RFQ . ' ha sido enviada a compras con éxito');
            } else {
                session()->flash('error', 'Ocurrió un error, intente más tarde.');
            }
        } catch (\Exception $e) {
            Log::error('Error sending quote to buyer: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al enviar la cotización al comprador.');
        }
    }
    
    public function selectedQuoteForRequisition()
    {
        try {
            $this->validate([
                'selectedQuote' => 'required',
            ]);
    
            $quote = Quote::find($this->selectedQuote);
            $this->selectedRQLine->update([
                'Quote_id' => $this->selectedQuote,
                'StatusList_id' => 11,
                'Currency_id' => $quote->Currency_id,
                'Supplier_id' => $quote->Supplier_id,
                'UnitCost' => $quote->Cost,
                'TotatlCost' => $quote->Cost * $this->selectedRQLine->quantity,
                'NumDaysArrival' => $quote->NumDaysArrival,
                'dateArrival' => Carbon::today()->addDays($quote->NumDaysArrival)->format('Ymd'),
            ]);
            // Initialize any required data
            $date = Carbon::today()->format('Ymd');
            $this->exchangeRates = GCC::where('CCNVDT', $date)->get();
            if ($this->exchangeRates->isEmpty()) {
                // Si no hay tipos de cambio para la fecha actual, buscar la fecha más cercana
                $closestDate = GCC::select('CCNVDT')
                    ->orderByRaw("ABS(DATEDIFF(CCNVDT, '$date'))")
                    ->first()
                    ->CCNVDT;
    
                // Obtener los tipos de cambio para la fecha más cercana
                $this->exchangeRates = GCC::where('CCNVDT', $closestDate)->get();
            }
    
            // Procesar los tipos de cambio
            $this->exchangeRates = $this->exchangeRates->keyBy(function ($item) {
                return $item->CCFRCR . '-' . $item->CCTOCR;
            });
    
            $ER_MXN_USD = $this->exchangeRates['MXN-USD']->CCNVFC ?? 0;
            $ER_MXN_JPY = $this->exchangeRates['MXN-JPY']->CCNVFC ?? 0;
            $ER_USD_MXN = $this->exchangeRates['USD-MXN']->CCNVFC ?? 0;
            $ER_JPY_MXN = $this->exchangeRates['JPY-MXN']->CCNVFC ?? 0;
    
            if ($ER_MXN_USD) {
                $ER_USD_JPY = $ER_MXN_JPY / $ER_MXN_USD;
            } else {
                $ER_USD_JPY = 0;
            }
    
            if ($ER_USD_JPY) {
                $ER_JPY_USD = 1 / $ER_USD_JPY;
            } else {
                $ER_JPY_USD = 0;
            }
    
            $ER_MXN_USD = $this->exchangeRates['MXN-USD']->CCNVFC ?? 0;
            $ER_MXN_JPY = $this->exchangeRates['MXN-JPY']->CCNVFC ?? 0;
            $ER_USD_MXN = $this->exchangeRates['USD-MXN']->CCNVFC ?? 0;
            $ER_JPY_MXN = $this->exchangeRates['JPY-MXN']->CCNVFC ?? 0;
    
            $ER_USD_JPY = $ER_MXN_USD ? $ER_MXN_JPY / $ER_MXN_USD : 0;
            $ER_JPY_USD = $ER_USD_JPY ? 1 / $ER_USD_JPY : 0;
    
            $quantity = $this->selectedRQLine->quantity;
            $unitCost = $this->selectedRQLine->UnitCost;
    
            if ($this->selectedRQLine->Currency_id == 1) { // MXN
                $this->selectedRQLine->update([
                    'TotalCostMXN' => $quantity * $unitCost,
                    'TotalCostUSD' => round($quantity * $unitCost * $ER_MXN_USD, 4),
                    'TotalCostJPY' => round($quantity * $unitCost * $ER_MXN_JPY, 4),
                ]);
            } elseif ($this->selectedRQLine->Currency_id == 2) { // USD
                $this->selectedRQLine->update([
                    'TotalCostMXN' => round($quantity * $unitCost * $ER_USD_MXN, 4),
                    'TotalCostUSD' => $quantity * $unitCost,
                    'TotalCostJPY' => round($quantity * $unitCost * $ER_USD_JPY, 4),
                ]);
            } elseif ($this->selectedRQLine->Currency_id == 3) { // JPY
                $this->selectedRQLine->update([
                    'TotalCostMXN' => round($quantity * $unitCost * $ER_JPY_MXN, 4),
                    'TotalCostUSD' => round($quantity * $unitCost * $ER_JPY_USD, 4),
                    'TotalCostJPY' => $quantity * $unitCost,
                ]);
            }
    
            $allLines = QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                    ->where('status', true)
                                    ->get();
            $allLinesApproved = $allLines->every(function ($line) {
                return $line->StatusList_id == 11;
            });
    
            if ($allLinesApproved) {
                $this->selectedRQ->update(['StatusList_id' => 7]);
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 7,
                ]);
            }
            $this->exchangeRates = null;
            $this->selectedQuote = null;
            $this->showLinesQuoteModal = $this->close;
    //         $this->selectedRQLine = null;
            sleep(2);
            $this->render();
            $this->showLinesQuoteModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error selecting quote for requisition: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la cotización para la requisición.');
        }
    }

    
    
    public function SelectionQuote()
    {
        try {
            if ($this->selectedRQ) {
                $this->selectedRQ->update([
                    'PID' => 'RQ',
                    'StatusList_id' => 8,
                ]);
    
                QuoteHistory::create([
                    'QuoteRequest_id' => $this->selectedRQ->id,
                    'StatusList_id' => 8,
                    'remarks' => 'Aprobada por ' . $this->user->id,
                ]);
                
                $this->showConfirmSelectionQuoteModal = $this->close;
                $this->showLinesQuoteModal = $this->close;
                session()->flash('success', 'Cotizaciones confirmadas exitosamente');
                // $this->showLinesQuoteModal = $this->close;
                // $this->resetPage();
                // $this->showLinesQuoteModal = $this->open;
            }
        } catch (\Exception $e) {
            Log::error('Error confirming selection quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al confirmar la selección de la cotización.');
        }
    }
    
    public function generateRequisition()
    {
        try {
            
    
            $lines = QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)->where('status', true)->get();
    
            $totalCostMXN = $lines->sum('TotalCostMXN');
            $totalCostUSD = $lines->sum('TotalCostUSD');
            $totalCostJPY = $lines->sum('TotalCostJPY');
    
            $supplierIds = $lines->pluck('Supplier_id')->unique();
            $currenciesIds = $lines->pluck('Currency_id')->unique();
    
            foreach ($supplierIds as $supplier) {
                foreach ($currenciesIds as $currency) {
                    $filteredLines = $lines->where('Supplier_id', $supplier)->where('Currency_id', $currency);
                    if ($filteredLines->isNotEmpty()) {
                        RequestRequisition::create([
                            'QuoteRequest_id' => $this->selectedRQ->id,
                            'RFQ' => $this->selectedRQ->RFQ,
                            'Supplier_id' => $supplier,
                            'Currency_id' => $currency,
                        ]);
                    }
                }
            }
    
            
            $this->selectedRQ->update([
                'TotalCostMXN' => $totalCostMXN,
                'TotalCostUSD' => $totalCostUSD,
                'TotalCostJPY' => $totalCostJPY,
                'PID' => 'RQ',
                'StatusList_id' => 13,
                'ApprovateUser' => 1,
                'ApprovateUserName' => $this->user->name,
                'ApprovateUserDate' => Carbon::today(),
            ]);
    
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 13,
            ]);
            $this->showConfirmGenerateRequisitionModal = $this->close;
            $this->showLinesQuoteModal = $this->close;
            session()->flash('success', 'Requisición generada con éxito');
    
            
        } catch (QueryException $e) {
            Log::error('Error generating requisition: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al generar la requisición, por favor intente nuevamente. ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error generating requisition: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al generar la requisición, por favor intente nuevamente.');
        }
    }

    // public function updatingSearch()
    // {
    //     try {
    //         $this->resetPage();
    //     } catch (\Exception $e) {
    //         Log::error('Error al actualizar la búsqueda: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al actualizar la búsqueda.');
    //     }
    // }
    
    // public function updatingSelectedOrderBy()
    // {
    //     try {
    //         $this->resetPage();
    //     } catch (\Exception $e) {
    //         Log::error('Error al actualizar el ordenamiento: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al actualizar el ordenamiento.');
    //     }
    // }
    
    // public function updatingSelectedOrder()
    // {
    //     try {
    //         $this->resetPage();
    //     } catch (\Exception $e) {
    //         Log::error('Error al actualizar el orden: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al actualizar el orden.');
    //     }
    // }
    
    // public function OpenModalCreateQuote()
    // {
    //     try {
    //         $this->showCreateQuoteModal = $this->open;
    //     } catch (\Exception $e) {
    //         Log::error('Error al abrir el modal de creación de cotización: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al abrir el modal de creación de cotización.');
    //     }
    // }
    
    // public function OpenModalConfirmSendQuoteBuyer()
    // {
    //     try {
    //         $this->showConfirmSendQuoteBuyerModal = $this->open;
    //     } catch (\Exception $e) {
    //         Log::error('Error al abrir el modal de confirmación para enviar cotización al comprador: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación para enviar cotización al comprador.');
    //     }
    // }
    
    // public function OpenModalConfirmDeleteLineQuote()
    // {
    //     try {
    //         $this->showConfirmDeleteLineQuoteModal = $this->open;
    //     } catch (\Exception $e) {
    //         Log::error('Error al abrir el modal de confirmación para eliminar línea de cotización: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación para eliminar línea de cotización.');
    //     }
    // }
    

    // public function OpenModalGenerateRequisition()
    // {
    //     try {
    //         $this->showGenerateRequisitionModal = $this->open;
    //     } catch (\Exception $e) {
    //         Log::error('Error al abrir el modal de generación de requisición: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al abrir el modal de generación de requisición.');
    //     }
    // }
    
    // public function closeModalCreateQuote()
    // {
    //     try {
    //         $this->showCreateQuoteModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de creación de cotización: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de creación de cotización.');
    //     }
    // }
    
    
    
    // public function closeModalLinesQuote()
    // {
    //     try {
    //         $this->showLinesQuoteModal = $this->close;
    //         $this->selectedRQLine = null;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de líneas de cotización: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de líneas de cotización.');
    //     }
    // }
    
    // public function closeModalConfirmSendQuoteSupplier()
    // {
    //     try {
    //         $this->showConfirmSendQuoteBuyerModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de confirmación para enviar cotización al comprador: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación para enviar cotización al comprador.');
    //     }
    // }
    
    // public function closeModalConfirmDeleteLineQuote()
    // {
    //     try {
    //         $this->showConfirmDeleteLineQuoteModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de confirmación para eliminar línea de cotización: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación para eliminar línea de cotización.');
    //     }
    // }
    
    // public function closeModalConfirmCancelQuote()
    // {
    //     try {
    //         $this->showConfirmCancelQuoteModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de confirmación para cancelar cotización: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación para cancelar cotización.');
    //     }
    // }
    
    // public function closeModalGenerateRequisition()
    // {
    //     try {
    //         $this->showGenerateRequisitionModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de generación de requisición: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de generación de requisición.');
    //     }
    // }
    
    // public function closeModalHistory()
    // {
    //     try {
    //         $this->showHistoryModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de historial: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de historial.');
    //     }
    // }
    
    // public function CloseModalConfirmCancel()
    // {
    //     try {
    //         $this->showConfirmCancelModal = $this->close;
    //     } catch (\Exception $e) {
    //         Log::error('Error al cerrar el modal de confirmación de cancelación: ' . $e->getMessage());
    //         session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de cancelación.');
    //     }
    // }
}
