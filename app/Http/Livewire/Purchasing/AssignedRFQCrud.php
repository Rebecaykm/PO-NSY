<?php
namespace App\Http\Livewire\Purchasing;

use App\Imports\QuotesImport;
use App\Mail\SendQuoteToSupplier;
use App\Models\{
        CostCenter,Currency, Item, MeasurementUnits, Project, ProviderEmailLog, QuoteLine, RequestQuote,
        Quote, QuoteFile, QuoteHistory, RequestAuthorization, RequestInvestment, StatusList, Supplier
    };
use Illuminate\Support\Facades\{Mail, Auth, DB, Log, Storage};
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;
use App\Mail\SendReleasedQuoteToUser;
use Dotenv\Exception\ValidationException;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AssignedRFQCrud extends Component
{
    use WithFileUploads, WithPagination;

    //VARIABLES PARRA FILTRO
    public $searchRQ;
    public $selectedRQStatus;
    public $selectedOrderBy = 'RFQ', $selectedOrder = 'DESC';
    public $selectedRQOrderBy = 'RFQ';
    public $selectedRQOrder = 'DESC';
    public $startDate;
    public $endDate;
    public $perPage = 10;
    
    //CARGA DE DATOS INICIALES
    public $status;
    public $suppliers;
    public $costCenters;
    public $user;
    public $measurementUnits;
    public $projects;
    public $items;
    public $currencies;

    //CARGA DE DATOS RFQ
    public $quotes = null;
    public $RQL_imgPath = null;
    public $RQLname = null;
    public $RQLdescription = null;
    public $RQLquantity = null;
    public $RQLdateRequired = null;
    public $RQLStatusList_Id = null;
    public $RQLQuoteRequest_id = null;
    public $RQLItem_id = null;
    public $RQLCostCenter_id = null;
    public $RQLMeasurementUnit_id = null;
    public $RQLQuote_id = null;

    //CARGA DE DATOS SELECCIONADOS
    public $excelFile; //Carga de archivo de excel, layout
    public $selectedRQ;
    public $selectedRQLine;
    public $selectedLines = [];
    public $selectedItem;
    public $selectedQuote;
    public $selectedDoc;
    public $QuotePDF;
    public $selectedSupplier = null;
    public $selectModalSupplier = null;
    public $selectSupplierFile = null;
    public $selectedLine = null;
    public $selectedDias = null;
    public $departmentId;
    public $Supplier_id;
    public $price;
    public $Currency_id;
    public $date;
    public $RQRemark;

    //MODALES
    public $showQuoteModal = true;   //Visualizar Cotización
    public $showChoseSupplierModal = true;  //Visualizar enviar lineas a proveedor
    public $showConfirmSendSupplierModal = true; //Confirmar enviar líneas de cotización a proveedor
    public $showUploadQuoteModal = true;
    public $showUploadFORMQuoteModal = true;
    public $showRequisitionModal = true;
    public $showConfirmSendYH100Modal = true;
    public $showConfirmGeneratePartialQuote = true;  //Confirmar hacer parcialidad de cotización
    public $showConfirmMakeQuote = true;   
    public $showAddQuoteModal = true;
    public $showAddQuoteFileModal = true;
    public $showConfirmSendUserModal = true;
    public $showConfirmDeleteQuoteFile = true;
    public $showConfirmRejectQuoteModal = true; //Rechazar Cotización
    public $showUpdateLineQuoteModal = true; //Crear o Editar Líneas de cotización
    public $showDeleteLineQuoteModal = true; //Confirmar borrar línea de cotización
    public $showUpdateQuoteModal = true;  //Crear o Editar Cotizaciones
    public $showUpdateFileQuoteModal = true; //Crear o Editar Archivos de cotización
    public $modeLine = null;
    public $close = true, $open = false;
    
    public $documento;
    public $name;
    public $NumDaysArrival;
    public $QUdescription;
    public $AddQuDescription;
    public $quoteFiles = [];
    public $providerEmailLog = null;
    public $generatePartiality = false;
    public $RQLines;
    public $files;
    public $emails;
    protected $queryString = ['searchRQ', 'page', 'selectedRQOrderBy', 'selectedRQOrder', 'selectedRQStatus', 'startDate', 'startDate'];
    public function mount()
    {
        try {
            $this->user = Auth::user();
            $this->status = StatusList::whereIn('id', [1,2,3,4,5,6,7,8,9,10,11,13,14,15,16])->get();
            $this->suppliers = Supplier::all(); // Clave la colección por 'id'
            $this->costCenters = CostCenter::all();
            $this->measurementUnits = MeasurementUnits::where('status', true)->orderBy('name', 'asc')->get();
            $this->costCenters = CostCenter::where('status', true)->orderBy('Department_id', 'asc')->get();
            $this->projects = Project::where('status', true)->orderBy('name', 'asc')->get();
            $this->items = Item::where('status', true)->orderBy('name', 'asc')->get();
            $this->currencies = Currency::where('status', true)->orderBy('name', 'ASC')->get();
        } catch (\Exception $e) {
            Log::error('Error al cargar los proveedores: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cargar los proveedores.');
        }
    }
    
    public function render()
    {
        return view('livewire.purchasing.assigned-r-f-q-crud', [
            'requestQuotes' => $this->getRequestQuotes(),
            'suppliers' => $this->getSuppliers(),
            '' => $this->getRequestQuotesLines(),
        ]);
    }

    public function getSuppliers()
    {
        try {
            $query = Supplier::select('VNDNAM', 'VENDOR')
                ->where('VMID', 'VM')
                ->whereNotNull('VNDNAM')
                ->where('VNDNAM', '!=', '')
                ->whereNotNull('VMDATN')
                ->where('VMDATN', '!=', '')
                ->orderBy('VNDNAM', 'ASC');
    
            if ($this->selectModalSupplier) {
                $query->where(function ($query) {
                    $query->where('VENDOR', 'like', '%' . $this->selectModalSupplier . '%')
                        ->orWhere('VNDNAM', 'like', '%' . $this->selectModalSupplier . '%');
                });
            }
    
            return $query->get();
        } catch (\Exception $e) {
            Log::error('Error al obtener proveedores: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener proveedores.');
            return null; // Retorna una colección vacía en caso de error
        }
    }

    public function getRequestQuotes()
    {
        try {
            $query = RequestQuote::where('Buyer_id', $this->user->buyer->id)
                                ->orderBy($this->selectedRQOrderBy, $this->selectedRQOrder);
            
            if ($this->searchRQ) {
                $query->where(function($q) {
                    $q->where('RFQ', 'like', '%' . $this->searchRQ . '%');
                });
            }
        
            // Filtro por estatus seleccionado
            if ($this->selectedRQStatus) {
                $query->where('StatusList_id', $this->selectedRQStatus);
            }
        
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
            Log::error('Error al obtener las cotizaciones: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las cotizaciones.');
            return null; // Retorna una colección vacía en caso de error
        }
    }

    public function selectRQ($RQ_id)
    {
        try {
            if ($RQ_id) {
                $this->selectedRQ = RequestQuote::find($RQ_id);
                $this->selectedRQLine = null;
                $this->RQLines = $this->getRequestQuotesLines();
                $this->quotes = $this->getQuotes();
                $this->files = $this->getRequestQuotesFiles();
            }
        } catch (\Exception $e) {
            Log::error('Error al seleccionar cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la cotización.');
        }
    }

    public function getRequestQuotesLines()
    {
        try {
            return $this->selectedRQ ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                                    ->where('status', true)
                                                    ->orderBy('id', 'ASC')
                                                    ->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener las líneas de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las líneas de cotización.');
            return null;
        }
    }
    
    public function getQuotes(){
        try {
            return $this->selectedRQ ? Quote::where('QuoteRequest_id', $this->selectedRQ->id)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener los archivos de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener los archivos de cotización.');
            return null;
        }
    }

    public function getRequestQuotesFiles()
    {
        try {
            return $this->selectedRQ ? QuoteFile::where('QuoteRequest_id', $this->selectedRQ->id)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener los archivos de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener los archivos de cotización.');
            return null;
        }
    }
    
    public function getProviderEmailLog()
    {
        try {
            return $this->selectedRQ ? ProviderEmailLog::where('QuoteRequest_id', $this->selectedRQ->id)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener el registro de correos del proveedor: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener el registro de correos del proveedor.');
            return null;
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
    
    
    
    public function selectOrderFlag($field)
    {
        try {
            $this->selectedOrderBy = $field;
            $this->selectedOrder = $this->selectedOrder === 'ASC' ? 'DESC' : 'ASC';
        } catch (\Exception $e) {
            Log::error('Error al seleccionar el orden: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar el orden.');
        }
    } 

    public function chargeData($RQL_id)
    {
        try {
            $this->selectedRQLine = QuoteLine::find($RQL_id);
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
    public function RejectRequestQuote()
    {
        try {
            $this->selectedRQ->update(['StatusList_id' => 37, 'remarks1' => $this->RQRemark, 'Buyer_id' => null]);
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 37,
                'remark' => $this->RQRemark,
            ]);
            $this->reset('RQRemark');
            $this->CloseModalConfirmRejectQuote();
        } catch (\Exception $e) {
            Log::error('Error al rechazar la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al rechazar la cotización.');
        }
    }
    
    public function SendToSupplier()
    {   
        $supplier = Supplier::find($this->selectedSupplier);
        $emails = array_filter([trim($supplier->VMDATN), trim($supplier->VMPDAT)]);
        
        // $user = Auth::user();
        
        Mail::to($emails)->send(new SendQuoteToSupplier($supplier->id, $this->selectedLines, $this->user));
        
        foreach ($this->selectedLines as $line) {
            ProviderEmailLog::create([
                'RequireDate' => $this->selectedRQ->dateRequiredQuote,
                'QuoteRequest_id' => $this->selectedRQ->id,
                'QuoteLine_id' => $line,
                'Supplier_id' => $supplier->id,
            ]);
        }

        $this->selectedRQ->update(['StatusList_id' => 4]);
        // QuoteLine::whereIn('id', $this->selectedLines)->update(['dateQuotation' => $this->selectedRQ->dateRequiredQuote]);
        
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRQ->id,
            'StatusList_id' => 4,
        ]);
        $this->selectedSupplier = null;
        $this->showConfirmSendSupplierModal = $this->close;
    }
    
    public function saveQuoteFile()
    {
        $this->validate([
            'QuotePDF' => 'required|file|mimes:jpeg,png,jpg,gif,svg,zip,rar,pdf|max:15360', // 15 MB = 15360 KB
            'selectSupplierFile' => 'required',
            'QUdescription' => 'nullable',
        ]);

        $imageName = null;
        if ($this->QuotePDF) {
            $imageName = 'Documento' . $this->selectedRQ->RFQ . Carbon::now()->format('Ymd_His') . '.' . $this->QuotePDF->extension();

            // Store the image
            $this->QuotePDF->storeAs('public/documentos', $imageName);
        }
    
        if ($this->QuotePDF) {
            try {
                $nombreArchivo = 'Documento_' . Carbon::now()->format('Ymd_His') . '.' . $this->QuotePDF->extension();
                $rutaArchivo = $this->QuotePDF->storeAs('public/documentos', $nombreArchivo);
    
                QuoteFile::create([
                    'filePath' => $rutaArchivo,
                    'fileName' => $nombreArchivo,
                    'description' => $this->QUdescription,
                    'Supplier_id' => $this->selectSupplierFile,
                    'QuoteRequest_id' => $this->selectedRQ->id,
                ]);
    
                $this->showAddQuoteFileModal = $this->close;
            } catch (\Exception $e) {
                Log::error('Error al guardar el archivo de cotización: ' . $e->getMessage());
                session()->flash('error', 'Ocurrió un error al guardar el archivo de cotización.');
            }
        }
    }
    
    public function importExcel()
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // Almacenar el archivo temporalmente en el sistema de archivos
            $filePath = $this->excelFile->store('temp'); // almacena el archivo en storage/app/temp

            // Procesar el archivo Excel
            $data = Excel::toArray([], storage_path('app/' . $filePath));

            DB::beginTransaction();

            foreach ($data[0] as $row) {
                // Verificar si las claves existen en la fila
                if (!isset($row[5]) || !isset($row[1]) || !isset($row[2]) || !isset($row[3]) || !isset($row[0]) || ($row[0] == 'ID_LINE')) {
                    
                }else{
                    $supplier = Supplier::where('VENDOR', $row['5'])->first();
                    $currency = Currency::where('name', $row['2'])->first();
                    $RQ_Line = QuoteLine::where('id', $row['0'])->first();

                    Quote::create([
                        'Cost' => $row['1'],
                        'description' => $row['4'] ?? '',
                        'QuoteRequest_id' => $RQ_Line ? $RQ_Line->QuoteRequest_id : null,
                        'QuoteLine_id' => $RQ_Line ? $RQ_Line->id : null,
                        'Supplier_id' => $supplier ? $supplier->id : null,
                        'Currency_id' => $currency ? $currency->id : null,
                        'NumDaysArrival' => $row['3'],
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Importación exitosa.');

            // Opcional: Eliminar el archivo temporal después de procesarlo
            Storage::delete($filePath);

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }

    public function generatePartialQuote()
    {
        // Validar que la cotización seleccionada existe
        if (!$this->selectedRQ) {
            session()->flash('error', 'No se ha encontrado la cotización seleccionada, por favor inténtelo nuevamente.');
            return;
        }
    
        // Obtener las líneas de cotización sin cotización asociada
        $QuoteLinesWithoutQuote = QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                            ->where('StatusList_id', 9)
                                            ->where('status', true)
                                            ->get();
    
        if ($QuoteLinesWithoutQuote->isEmpty()) {
            session()->flash('error', 'No hay líneas de cotización disponibles para la cotización seleccionada.');
            return;
        }
    
        // Encontrar el próximo número de parcialidad disponible
        for ($i = 0; $i < 10; $i++) {
            $partialRFQ = 'P' . $i . substr($this->selectedRQ->RFQ, 2);
            if (!RequestQuote::where('RFQ', $partialRFQ)->exists()) {
                $Folio = $partialRFQ;
                break;
            }
        }
    
        if (!isset($Folio)) {
            session()->flash('error', 'Se ha alcanzado el máximo número de cotizaciones parciales (P0 a P9).');
            return;
        }
    
        try {
            // Crear una nueva cotización parcial con los datos de la cotización seleccionada
            $PartialQuote = RequestQuote::create([
                'RFQ' => $Folio,
                'PID' => $this->selectedRQ->PID,
                'WorkNumber' => $this->selectedRQ->WorkNumber,
                'description' => $this->selectedRQ->description,
                'UserName' => $this->selectedRQ->UserName,
                'dateRequiredQuote' => $this->selectedRQ->dateRequiredQuote,
                'ApprovateUserDate' => $this->selectedRQ->ApprovateUserDate,
                'ApprovateUserName' => $this->selectedRQ->ApprovateUserName,
                'ApprovateUser' => $this->selectedRQ->ApprovateUser,
                'ApprovateLinesDate' => $this->selectedRQ->ApprovateLinesDate,
                'ApprovateLines' => $this->selectedRQ->ApprovateLines,
                'ManagerApprovateDate' => $this->selectedRQ->ManagerApprovateDate,
                'ManagerApprovateName' => $this->selectedRQ->ManagerApprovateName,
                'ManagerApprovate' => $this->selectedRQ->ManagerApprovate,
                'UploadedINFOR' => $this->selectedRQ->UploadedINFOR,
                'UploadedINFORDate' => $this->selectedRQ->UploadedINFORDate,
                'UploadedINFORName' => $this->selectedRQ->UploadedINFORName,
                'ApprovateBuyerDate' => $this->selectedRQ->ApprovateBuyerDate,
                'ApprovateBuyerName' => $this->selectedRQ->ApprovateBuyerName,
                'ApprovatePOBuyer' => $this->selectedRQ->ApprovatePOBuyer,
                'ApprovateDirectorDate' => $this->selectedRQ->ApprovateDirectorDate,
                'ApprovateDirector' => $this->selectedRQ->ApprovateDirector,
                'ApprovatePODirector' => $this->selectedRQ->ApprovatePODirector,
                'ApprovateVPresidentDate' => $this->selectedRQ->ApprovateVPresidentDate,
                'ApprovateVPresidentName' => $this->selectedRQ->ApprovateVPresidentName,
                'ApprovateVPresident' => $this->selectedRQ->ApprovateVPresident,
                'ApprovatePresidentDate' => $this->selectedRQ->ApprovatePresidentDate,
                'ApprovatePresidentName' => $this->selectedRQ->ApprovatePresidentName,
                'ApprovatePresident' => $this->selectedRQ->ApprovatePresident,
                'Nomina' => $this->selectedRQ->Nomina,
                'TotalCostMXN' => $this->selectedRQ->TotalCostMXN,
                'TotalCostUSD' => $this->selectedRQ->TotalCostUSD,
                'TotalCostJPY' => $this->selectedRQ->TotalCostJPY,
                'remarks1' => $this->selectedRQ->remarks1,
                'remarks2' => $this->selectedRQ->remarks2,
                'remarks3' => $this->selectedRQ->remarks3,
                'DateRequireQuotation' => $this->selectedRQ->DateRequireQuotation,
                'User_id' => $this->selectedRQ->User_id,
                'CostCenter_id' => $this->selectedRQ->CostCenter_id,
                'Department_id' => $this->selectedRQ->Department_id,
                'Commodity_id' => $this->selectedRQ->Commodity_id,
                'Project_id' => $this->selectedRQ->Project_id,
                'Buyer_id' => $this->selectedRQ->Buyer_id,
                'StatusList_id' => $this->selectedRQ->StatusList_id,
            ]);
    
            if (!$PartialQuote) {
                session()->flash('error', 'No se ha logrado crear la nueva cotización parcial, por favor inténtelo nuevamente.');
                return;
            }
    
            // Actualizar las líneas de cotización para asociarlas a la nueva cotización parcial
            $QuoteLinesWithoutQuote->toQuery()->update([
                'QuoteRequest_id' => $PartialQuote->id,
            ]);
    
            // Actualizar el estado de la cotización seleccionada
            $this->selectedRQ->update(['StatusList_id' => 6]);
    
            // Registrar el cambio de estado en el historial de cotizaciones
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 6,
            ]);
    
            // Enviar notificación por correo electrónico
            $email = $this->selectedRQ->user->email_notification;
            // $user = Auth::user();
            Mail::to($email)->send(new SendReleasedQuoteToUser($this->selectedRQ, $this->user));
    
            // Resetear la bandera de generación parcial y cerrar el modal
            $this->generatePartiality = false;
            $this->showConfirmGeneratePartialQuote = $this->close;
            $this->reset(['selectedSupplier', 'showUploadQuoteModal']);
            session()->flash('success', 'Cotización parcial generada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores
            // Resetear la bandera de generación parcial y cerrar el modal
            $this->generatePartiality = false;
            $this->showConfirmGeneratePartialQuote = $this->close;
            $this->reset(['selectedSupplier', 'showUploadQuoteModal']);
            Log::error('Error al generar la cotización parcial: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al generar la cotización parcial: ' . $e->getMessage());
        }
    }
    
    public function SendRQtoUser()
    {
        try {
            $this->selectedRQ->update(['StatusList_id' => 6]);
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 6,
            ]);
            $email = $this->selectedRQ->user->email_notification;
            
            Mail::to($email)->send(new SendReleasedQuoteToUser($this->selectedRQ, $this->user));
            $this->CloseModalConfirmSendUser();
            $this->reset(['selectedSupplier', 'showUploadQuoteModal']);
        } catch (\Exception $e) {
            Log::error('Error al enviar la cotización al usuario: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al enviar la cotización al usuario.');
        }
    }
    
    public function toggleSelectedLine($lineId, $isChecked)
    {
        try {
            if ($isChecked) {
                // Añadir la línea si está seleccionada y no está ya en el array
                if (!in_array($lineId, $this->selectedLines)) {
                    $this->selectedLines[] = $lineId;
                }
            } else {
                // Quitar la línea si no está seleccionada
                if (in_array($lineId, $this->selectedLines)) {
                    $this->selectedLines = array_diff($this->selectedLines, [$lineId]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error al alternar la selección de la línea: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al alternar la selección de la línea.');
        }
    }

    
    
    
    public function clearFilters()
    {
        try {
            $this->reset(['selectedStatus', 'searchRQ', 'selectedRQ', 'selectModalSupplier']);
        } catch (\Exception $e) {
            Log::error('Error al limpiar los filtros: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al limpiar los filtros.');
        }
    }
    private function resetInputFields()
    {
        try {
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

    //Modificar Lineas
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
                $this->render();
                $this->resetInputFields();
                $this->showUpdateLineQuoteModal = true;
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
    
            $this->render();
            $this->resetInputFields();
            $this->showUpdateLineQuoteModal = true;
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
    
                if ($this->RQL_imgPath != null) {
                    $imageBaseName = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($this->RQLname, PATHINFO_FILENAME));
                    $imageExtension = $this->RQL_imgPath->extension();
                    $imageName = 'Item' . '_' . $this->selectedRQ->RFQ . '_' . $imageBaseName . '.' . $imageExtension;
                
                    // Store the image
                    $this->RQL_imgPath->storeAs('public/items', $imageName);

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
                
    
                $this->selectedRQLine->update([
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
    
            $this->render();
            $this->resetInputFields();
            $this->showUpdateLineQuoteModal = true;
        } catch (\Exception $e) {
            $this->showUpdateLineQuoteModal = true;
            $this->CloseModalUploadQuote();
            Log::error('Error editing line quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al editar la línea de cotización.');
        }
    }
    public function DeleteLineQuote()
    {
        try {
            $this->selectedRQLine->update(['status' => false]);
            $this->CloseModalDeleteLineQuote();
        } catch (\Exception $e) {
            Log::error('Error deleting line quote: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al eliminar la línea de cotización.');
        }
    }
    //CRUD COTIZACIONES DE LÍNEA
    public function MakeQuote()
    {
        
        $this->validate([
            'Currency_id' => 'required',
            'price' => 'required',
            'NumDaysArrival' => 'required',
            'selectedSupplier' => 'required',
            'AddQuDescription' => 'nullable',
        ]);
        $supplier = Supplier::find($this->selectedSupplier);
        try {
            Quote::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'QuoteLine_id' => $this->selectedRQLine->id,
                'Supplier_id' => $supplier->id,
                'Cost' => $this->price,
                'Currency_id' => $this->Currency_id,
                'NumDaysArrival' => $this->NumDaysArrival,
                'description' => $this->AddQuDescription,
            ]);
    
            $this->selectedRQLine->update(['StatusList_id' => 10]);
    
            if ($this->selectedRQ->StatusList_id <= 4) {
                $allLinesCompleted = QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                                ->where('status', true)
                                                ->where('StatusList_id', '!=', 10)
                                                ->doesntExist();
                if ($allLinesCompleted) {
                    $this->selectedRQ->update(['StatusList_id' => 5]);
                    QuoteHistory::create([
                        'QuoteRequest_id' => $this->selectedRQ->id,
                        'StatusList_id' => 5,
                    ]);
                }
            }
    
            $this->CloseModalAddQuote();
            $this->render();
            $this->OpenModalUploadQuote($this->selectedRQ->id);
        } catch (\Exception $e) {
            Log::error('Error al crear la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al crear la cotización.');
        }
    }
    
    public function EditQuote($RQ_id)
    {
        $RQ = RequestQuote::find($RQ_id);
        $this->validate([
            'Currency_id' => 'required',
            'price' => 'required',
            'NumDaysArrival' => 'required',
            'selectedSupplier' => 'required',
            'AddQuDescription' => 'nullable',
        ]);
        $supplier = Supplier::find($this->selectedSupplier);
        try {
            $RQ->update([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'QuoteLine_id' => $this->selectedRQLine->id,
                'Supplier_id' => $supplier->id,
                'Cost' => $this->price,
                'Currency_id' => $this->Currency_id,
                'NumDaysArrival' => $this->NumDaysArrival,
                'description' => $this->AddQuDescription,
            ]);
    
    
            $this->CloseModalEditQuote();
            $this->render();
            $this->OpenModalUploadQuote($this->selectedRQ->id);
        } catch (\Exception $e) {
            Log::error('Error al editar la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al editar la cotización.');
        }
    }
    
    public function DeleteQuote($RQ_id)
    {
        try {
            $RQ = RequestQuote::find($RQ_id);
            

        } catch (\Exception $e) {
            Log::error('Error al eliminar la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al eliminar la cotización.');
        }
    }
    //MODALES (OPEN - CLOSE)

    public function OpenModalQuoteModal($RQ_id)
    {
        try {
            $this->selectRQ($RQ_id);
            $this->showQuoteModal = $this->open;
            $this->render();
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de cotización.');
        }
    }
    public function OpenModalUpdateLineQuote($modeLine,$RQL_id)
    {
        try {
            $this->modeLine = $modeLine;
            if ($modeLine == 'create') {
                $this->resetInputRQL();
                $this->showUpdateLineQuoteModal = $this->open;
            }
            if ($modeLine == 'edit') {
                $this->chargeData($RQL_id);
                $this->selectedRQLine = QuoteLine::find($RQL_id);
                $this->showUpdateLineQuoteModal = $this->open;
            }
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de actualización de línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de actualización de línea de cotización.');
        }
    }

    public function OpenModalUpdateQuote($modeLine,$RQL_id)
    {
        try {
            $this->modeLine = $modeLine;
            if ($modeLine == 'create') {
                $this->resetInputRQL();
                $this->showUpdateQuoteModal = $this->open;
            }
            if ($modeLine == 'edit') {
                $this->chargeData($RQL_id);
                $this->showUpdateQuoteModal = $this->open;
            }
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de actualización de línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de actualización de línea de cotización.');
        }
    }

    public function OpenModalUpdateFileQuote($modeLine,$RQL_id)
    {
        try {
            $this->modeLine = $modeLine;
            if ($modeLine == 'create') {
                $this->resetInputRQL();
                $this->showUpdateFileQuoteModal = $this->open;
            }
            if ($modeLine == 'edit') {
                $this->chargeData($RQL_id);
                $this->showUpdateFileQuoteModal = $this->open;
            }
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de actualización de línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de actualización de línea de cotización.');
        }
    }

    public function OpenModalDeleteLineQuote($RQL_id)
    {
        try {
            $this->selectedRQLine = QuoteLine::find($RQL_id);
            $this->showDeleteLineQuoteModal = false;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de eliminar linea de cotización ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de eliminar línea de cotización.');
        }
    }
    public function OpenModalConfirmSendSupplier()
    {
        try {
            $this->validate(['selectedSupplier' => 'required']);
            $this->showConfirmSendSupplierModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmación de envío al proveedor: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación de envío al proveedor.');
        }
    }
    
    public function OpenModalUploadQuote($RQ_id)
    {
        try {
            $this->selectedRQ = RequestQuote::find($RQ_id);
            if ($RQ_id) {
                $this->quotes = Quote::where('QuoteRequest_id',$RQ_id)->orderBy('QuoteLine_id','ASC')->get();
                $this->files = $this->getRequestQuotesFiles($RQ_id);
            }
    
            // Contar cuántas líneas tienen StatusList_id igual a 10
            $count = $this->RQLines->filter(function ($line) {
                return $line->StatusList_id == 10;
            })->count();
            // dd($count);
    
            // Contar las cotizaciones parciales existentes
            $partialQuotesCount = RequestQuote::where('RFQ', 'like', 'P%' . substr($this->selectedRQ->RFQ, 1))->count();
    
            // Determinar si se debe generar parcialidad
            $this->generatePartiality = ($count > 0 && $count < $this->RQLines->count() && $partialQuotesCount < 10);
    
            // Mostrar el modal
            $this->showUploadQuoteModal = false;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de carga de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de carga de cotización.');
        }
    }

    public function OpenModalChoseSupplier($RQ_id)
    {
        try {
            $this->selectedLines = [];
            $this->RQLines = $this->getRequestQuotesLines($RQ_id);
            $this->showChoseSupplierModal = false;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de selección de proveedor: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de selección de proveedor.');
        }
    }
    public function OpenModalAddQuote($RQL_id)
    {
        try {
            $this->reset(['Currency_id', 'price', 'NumDaysArrival', 'selectedSupplier', 'AddQuDescription', 'showAddQuoteModal']);
            $this->showAddQuoteModal = false;
            $this->selectedRQLine = QuoteLine::find($RQL_id);
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de agregar cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de agregar cotización.');
        }
    }
    
    public function CloseModalDeleteLineQuote()
    {
        try {
            $this->selectedRQLine = null;
            $this->showDeleteLineQuoteModal = true;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de eliminar linea de cotización ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de eliminar línea de cotización.');
        }
    }
    public function CloseModalChoseSupplier()
    {
        try {
            // $this->reset(['selectedSupplier', 'showChoseSupplierModal']);
            $this->selectedSupplier = null;
            $this->selectedLines = [];
            $this->showChoseSupplierModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de elección de proveedor: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de elección de proveedor.');
        }
    }
    
    public function CloseModalUploadQuote()
    {
        try {
            $this->reset(['selectedSupplier', 'showUploadQuoteModal']);
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de carga de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de carga de cotización.');
        }
    }
    public function CloseModalAddQuote()
    {
        try {
            $this->reset(['Currency_id', 'price', 'NumDaysArrival', 'selectedSupplier', 'AddQuDescription', 'showAddQuoteModal']);
            $this->showAddQuoteModal = true;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de agregar cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de agregar cotización.');
        }
    }
    
    public function CloseModalConfirmDeleteQuoteFile()
    {
        try {
            // $this->showConfirmDeleteQuoteFileModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de eliminación de archivo de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de eliminación de archivo de cotización.');
        }
    }
    
    public function CloseModalConfirmSendUser()
    {
        try {
            $this->showConfirmSendUserModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de envío al usuario: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de envío al usuario.');
        }
    }
    
    public function CloseModalConfirmRejectQuote()
    {
        try {
            $this->showConfirmRejectQuoteModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación de rechazo de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación de rechazo de cotización.');
        }
    }
    
    public function CloseAllModals()
    {
        try {
            $this->reset([
                'showQuoteModal', 'showChoseSupplierModal', 'showConfirmSendSupplierModal', 'showUploadQuoteModal',
                'showUploadFORMQuoteModal', 'showRequisitionModal', 'showConfirmSendYH100Modal', 'showConfirmMakeQuote',
                'showConfirmRejectQuoteModal'
            ]);
        } catch (\Exception $e) {
            Log::error('Error al cerrar todos los modales: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar todos los modales.');
        }
    }
    
}