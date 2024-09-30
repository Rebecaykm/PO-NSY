<?php

namespace App\Http\Livewire\Purchasing;

use App\Models\{
    YH100, Currency, Folio, HPO, ProviderEmailLog, QuoteLine, RequestQuote, Quote, QuoteFile, QuoteHistory, RequestRequisition, StatusList, Supplier, YH110, ZRC, ZRT
};
use Illuminate\Support\Facades\{Mail, Auth, Log, Storage};
use App\Mail\SendQuoteToSupplier;
use Exception;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Livewire\WithFileUploads;
use App\Exports\PurchaseOrderExport;
use App\Mail\SendReleasedQuoteToUser;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class AssignedRQcrud extends Component
{
    use WithFileUploads, WithPagination;

    //FILTRO DE BUSQUEDA 
    public $searchRQ;
    public $selectedRQStatus;
    public $selectedOrderBy = 'RFQ';
    public $selectedOrder = 'DESC';
    public $startDate, $endDate;
    public $perPage = 10, $page = 1;
    public $selectedRQOrderBy = 'RFQ';
    public $selectedRQOrder = 'DESC';
    
    
    //CARGA DE DATOS
    public $user;
    public $suppliers;
    public $status;
    public $selectedRQ = null;
    public $selectedRQLine = null;
    public $selectedQuote = null;
    public $providerEmailLog;
    public $selectedSupplier = null;
    public $selectedLine = null ;
    public $quoteFiles = null;

    // MODALES
    public $showQuoteModal = true;
    public $showChoseSupplierModal = true;
    public $showConfirmSendSupplierModal = true;
    public $showUploadQuoteModal = true;
    public $showUploadFORMQuoteModal = true;
    public $showRequisitionModal = true;
    public $showConfirmSendYH100Modal = true;
    public $showConfirmMakeQuote = true;
    public $showAddQuoteModal = true;
    public $showAddQuoteFileModal = true;
    public $showConfirmSendUserModal = true;
    public $showConfirmDeleteQuoteFile = true;
    public $showConfirmRejectQuoteModal = true;
    public $close = true, $open = false;

    //CARGA DE DATOS RQ
    public $name;
    public $NumDaysArrival;
    public $description;
    public $Supplier_id;
    public $price;
    public $Currency_id;
    public $date;
    public $RQRemark;
    public $selectModalSupplier = null;
    protected $queryString = ['searchRQ', 'page', 'selectedOrderBy', 'selectedOrder'];
    public function mount()
    {
        try {
            $this->user = Auth::user();
            if (!$this->user || !$this->user->buyer) {
                session()->flash('error', 'Usuario no autenticado o sin comprador asignado.');
                return null; // Retorna una colección vacía en caso de error
            }
            $this->status = StatusList::whereIn('id', [12,18,20,23,24,25,26,27,28,32,33,34,36,48,49,50,51])->get();
            
        } catch (\Exception $e) {
            Log::error('Error al montar el componente: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al montar el componente.');
        }
    }
    public function render()
    {
        return view('livewire.purchasing.assigned-r-qcrud', [
            'requestQuotes' => $this->getRequestQuotes(),
            'suppliers' => $this->getSuppliers(),
            'RQLines' => $this->getRequestQuotesLines(),
            'files' => $this->getRequestRequestQuotesFiles(),
            'currencies' => $this->getCurrencies(),
            'emails' => $this->getProviderEmailLog(),
        ]);
    }
    public function getRequestQuotes()
    {
        try {
            $query = RequestQuote::where('Buyer_id', $this->user->buyer->id)
                                    ->whereIn('StatusList_id', [12,18,20,23,24,25,26,27,28,32,33,34,36,48,49,50,51])
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

    public function getRequestRequestQuotesFiles()
    {
        try {
            return $this->selectedRQ ? QuoteFile::where('QuoteRequest_id', $this->selectedRQ->id)->get() : collect();
        } catch (\Exception $e) {
            Log::error('Error al obtener los archivos de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener los archivos de cotización.');
            return collect();
        }
    }

    public function getCurrencies()
    {
        try {
            return Currency::where('status', true)->orderBy('name', 'ASC')->get();
        } catch (\Exception $e) {
            Log::error('Error al obtener las monedas: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las monedas.');
            return collect(); // Retorna una colección vacía en caso de error
        }
    }

    public function getProviderEmailLog()
    {
        try {
            return $this->selectedRQ ? ProviderEmailLog::where('QuoteRequest_id', $this->selectedRQ->id)->get() : collect();
        } catch (\Exception $e) {
            Log::error('Error al obtener el registro de correos del proveedor: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener el registro de correos del proveedor.');
            return collect();
        }
    }

    public function getRequestQuotesLines()
    {
        try {
            return $this->selectedRQ ? QuoteLine::where('QuoteRequest_id', $this->selectedRQ->id)
                                                    ->where('status', true)
                                                    ->orderBy('id', 'ASC')
                                                    ->paginate($this->perPage) : collect();
        } catch (\Exception $e) {
            Log::error('Error al obtener las líneas de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las líneas de cotización.');
            return collect();
        }
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
            Log::error('Error al obtener los proveedores: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener los proveedores.');
            return collect(); // Retorna una colección vacía en caso de error
        }
    }

    public function resetPage()
    {
        $this->reset('page');
    }

    public function selectRQ($RQ_id)
    {
        try {
            $this->selectedRQ = RequestQuote::find($RQ_id);
            if ($this->selectedRQ) {
                $this->selectedRQLine = null;
                $this->quoteFiles = $this->getRequestRequestQuotesFiles();
                $this->providerEmailLog = $this->getProviderEmailLog();
            }
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la cotización.');
        }
    }

    public function selectLine($rowID)
    {
        try {
            $this->selectedRQLine = QuoteLine::find($rowID);
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la línea de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la línea de cotización.');
        }
    }

    public function selectQuoteFile($rowID)
    {
        try {
            $this->selectedRQLine = Quote::find($rowID);
        } catch (\Exception $e) {
            Log::error('Error al seleccionar el archivo de cotización: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar el archivo de cotización.');
        }
    }

    public function selectSupplier($rowID)
    {
        try {
            $this->selectedSupplier = Supplier::find($rowID);
        } catch (\Exception $e) {
            Log::error('Error al seleccionar el proveedor: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar el proveedor.');
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
    
    public function OpenModalRequisition()
    {
        try {
            $this->showRequisitionModal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de requisición.');
        }
    }
    public function OpenModalQuoteModal()
    {
        $this->showQuoteModal = $this->open;
    }
    public function CloseModalQuoteModal()
    {
        $this->reset(['selectedSupplier', 'showQuoteModal']);
    }
    
    public function OpenModalConfirmSendYH100()
    {
        try {
            $this->showConfirmSendYH100Modal = $this->open;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmación: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmación.');
        }
    }
    
    public function CloseModalRequisition()
    {
        try {
            $this->showRequisitionModal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de requisición.');
        }
    }
    
    public function CloseModalConfirmSendYH100()
    {
        try {
            $this->showConfirmSendYH100Modal = $this->close;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmación: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmación.');
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
    
    
    
    public function resetData()
    {
        try {
            $this->reset(['selectedRQ', 'selectedSupplier']);
        } catch (\Exception $e) {
            Log::error('Error al resetear los datos: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al resetear los datos.');
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
    
    public function generatePO()
    {
        try {
            $this->selectedRQ->update(['StatusList_id' => 18]);
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 18,
            ]);
            $lineas = QuoteLine::where('RequestQuote_id',$this->selectedRQ)
                                ->where('status', 1)
                                ->get();
            $lineas->query()->update([
                'dateArrival' => Carbon::today()->addDays($this->selectedRQ->NumDaysArrival)->format('Ymd'),
            ]); 
        } catch (\Exception $e) {
            Log::error('Error al generar la orden de compra: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al generar la orden de compra.');
        }
    }
    
    public function SendRQtoYH100()
    {
        try {
            $folio = Folio::where('name', 'RQ')->first();
            $ConsecutivoRQ = $folio->folio;
            $NumeroLinea = 0;
    
            $RequestRequisitions = RequestRequisition::where('RFQ', $this->selectedRQ->RFQ)->get();
    
            foreach ($RequestRequisitions as $requisition) {
                $ConsecutivoRQ = $this->obtenerConsecutivoRQ($ConsecutivoRQ);
    
                $RequisitionLines = QuoteLine::where('QuoteRequest_id', $requisition->quoteRequest->id)
                    ->where('Supplier_id', $requisition->supplier->id)
                    ->where('Currency_id', $requisition->currency->id)
                    ->where('status', 1)
                    ->get();
    
                [$subtotal, $IVA, $IRF, $OtherTax] = $this->calcularImpuestosYSubtotal($RequisitionLines, $requisition->currency->id);
    
                $Total = $subtotal + $IVA + $IRF + $OtherTax;
                $this->actualizarRequisition($requisition, $subtotal, $IVA, $IRF, $OtherTax, $Total);
    
                foreach ($RequisitionLines as $RequisitionLine) {
                    $NumeroLinea++;
                    $RequisitionLine->update(['numLine' => $NumeroLinea]);
                    $this->SendRQLYH100($ConsecutivoRQ, $RequisitionLine);
                }
    
                $requisition->PORD = $ConsecutivoRQ;
                $ConsecutivoRQ++;
                $folio->update(['folio' => $ConsecutivoRQ]);
                $NumeroLinea = 0;
            }
    
            $this->ejecutarConsultaODBC();
    
            $this->actualizarRequisitionFinal($RequestRequisitions);
            $this->actualizarSelectedRQ();
            $this->CloseAllModals();
        } catch (\Exception $e) {
            Log::error('Error al enviar las requisiciones a YH100: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al enviar las requisiciones a YH100.');
        }
    }
    
    private function obtenerConsecutivoRQ($ConsecutivoRQ)
    {
        try {
            do {
                $count1 = HPO::where('PORD', 'like', '%' . $ConsecutivoRQ . '%')->count();
                $count2 = HPO::where('POSRCE', 'like', '%' . $ConsecutivoRQ . '%')->count();
            } while ($count1 > 0 || $count2 > 0 && $ConsecutivoRQ++);
        } catch (QueryException $e) {
            Log::error('Error al contar en HPO: ' . $e->getMessage());
            throw $e;
        }
    
        return $ConsecutivoRQ;
    }
    
    private function calcularImpuestosYSubtotal($RequisitionLines, $currencyId)
    {
        try {
            $subtotal = 0.0;
            $IVA = 0.0;
            $IRF = 0.0;
            $OtherTax = 0.0;
    
            foreach ($RequisitionLines as $requisitionLine) {
                $taxData = $this->obtenerDatosImpuestos($requisitionLine);
    
                $IVA += $taxData['IVA'];
                $IRF += $taxData['IRF'];
                $OtherTax += $taxData['OtherTax'];
            }
    
            switch ($currencyId) {
                case 1:
                    $subtotal = $RequisitionLines->sum('TotalCostMXN');
                    break;
                case 2:
                    $subtotal = $RequisitionLines->sum('TotalCostUSD');
                    break;
                case 3:
                    $subtotal = $RequisitionLines->sum('TotalCostJPY');
                    break;
                default:
                    $subtotal = 0;
            }
    
            return [$subtotal, $IVA, $IRF, $OtherTax];
        } catch (\Exception $e) {
            Log::error('Error al calcular impuestos y subtotal: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al calcular impuestos y subtotal.');
            return [0, 0, 0, 0]; // Retorna valores por defecto en caso de error
        }
    }
    
    private function obtenerDatosImpuestos($requisitionLine)
    {
        try {
            $RequisitionVendorTAX = $requisitionLine->supplier->VTAXCD;
            $RequisitionCommodityTax = $requisitionLine->commodity->PCTAXC;
            $requisitionLine->update(['CODEIVA' => $RequisitionCommodityTax]);
    
            $zrt = ZRT::where('RTCVCD', 'like', '%' . trim($RequisitionVendorTAX) . '%')
                ->where('RTICDE', 'like', '%' . trim($RequisitionCommodityTax) . '%')
                ->first();
    
            $ZRC_IVA = ZRC::where('RCRTCD', $zrt->RTRC01)->first();
            $ZRC_IRF = ZRC::where('RCRTCD', $zrt->RTRC02)->first();
            $ZRC_OtherTax1 = ZRC::where('RCRTCD', $zrt->RTRC02)->first();
            $ZRC_OtherTax2 = ZRC::where('RCRTCD', $zrt->RTRC03)->first();
    
            $IVA_Aux = !empty($ZRC_IVA) ? round($requisitionLine->quantity * $requisitionLine->UnitCost * floatval($ZRC_IVA->RCCRTE) / 100, 4) : 0.0;
            $IRF_Aux = !empty($ZRC_IRF) ? round($requisitionLine->quantity * $requisitionLine->UnitCost * floatval($ZRC_IRF->RCCRTE) / 100, 4) : 0.0;
    
            $OtherTax1 = (!empty($ZRC_OtherTax1)) ? round($requisitionLine->quantity * $requisitionLine->UnitCost * floatval($ZRC_OtherTax1->RCCRTE) / 100, 4) : 0.0;
            $OtherTax2 = (!empty($ZRC_OtherTax2)) ? round($requisitionLine->quantity * $requisitionLine->UnitCost * floatval($ZRC_OtherTax2->RCCRTE) / 100, 4) : 0.0;
            $OtherTax_Aux = $OtherTax1 + $OtherTax2;
            
            $requisitionLine->IVA = $IVA_Aux;
            $requisitionLine->IRF = $IRF_Aux;
            $requisitionLine->OTEHERTAX = $OtherTax_Aux ;
    
            return ['IVA' => $IVA_Aux, 'IRF' => $IRF_Aux, 'OtherTax' => $OtherTax_Aux];
        } catch (\Exception $e) {
            Log::error('Error al obtener datos de impuestos: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener datos de impuestos.');
            return ['IVA' => 0.0, 'IRF' => 0.0, 'OtherTax' => 0.0]; // Retorna valores por defecto en caso de error
        }
    }
    
    private function actualizarRequisition($requisition, $subtotal, $IVA, $IRF, $OtherTax, $Total)
    {
        try {
            $requisition->update([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'RFQ' => $this->selectedRQ->RFQ,
                'Supplier_id' => $requisition->supplier->id,
                'Currency_id' => $requisition->currency->id,
                'Subtotal' => $subtotal,
                'IVA' => $IVA,
                'IRF' => $IRF,
                'OtherTax' => $OtherTax,
                'Total' => $Total,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la requisición: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar la requisición.');
        }
    }
    
    private function ejecutarConsultaODBC()
    {
        try {
            $conn = odbc_connect("Driver={Client Access ODBC Driver (32-bit)};System=192.168.200.7;", "YKMS002", "AYAX4123");
    
            if ($conn === false) {
                throw new Exception("Error al conectar con la base de datos Infor.");
            }
    
            $query = "CALL LX834OU.YPU054C";
            $result = odbc_exec($conn, $query);
    
            if ($result) {
                Log::info("LX834OU.YPU054C: La consulta se ejecutó con éxito en " . date('Y-m-d H:i:s'));
            } else {
                throw new Exception("LX834OU.YPU054C: Error en la consulta: " . odbc_errormsg($conn));
            }
        } catch (Exception $e) {
            Log::alert($e->getMessage());
            session()->flash('error', 'Ocurrió un error al ejecutar la consulta ODBC: ' . $e->getMessage());
        } finally {
            if (isset($conn)) {
                odbc_close($conn);
            }
        }
    }
    
    private function actualizarRequisitionFinal($RequestRequisitions)
    {
        try {
            foreach ($RequestRequisitions as $requisition) {
                $YH110row = YH110::query()
                    ->where('HHRQID', $requisition->PORD)
                    // ->where('HHRLIN', 1)
                    ->select([
                        'HHRQID', 'HHRLIN', 'HHORD', 'HHLINE', 'HHVEND', 'HHWHSE', 'HHSHIP', 'HHBUYC',
                        'HHCCOD', 'HHCDES', 'HHQORD', 'HHDDTE', 'HHECST', 'HHUM', 'HHITXC', 'HHOPRF',
                        'HHCDT', 'HHCTM', 'HHCBY'
                    ])
                    ->first();
    
                $RequisitionLines = QuoteLine::where('QuoteRequest_id', $requisition->quoteRequest->id)
                                                ->where('PORD', $requisition->PORD)
                                                ->where('status', 1)
                                                ->orderBy('numLine','ASC')
                                                ->get();
    
                $requisition->update([
                    'PPO' => $YH110row->HHORD,
                    'PEDTE' => Carbon::today()->format('Ymd'),
                    'PPCLS' => Carbon::today()->format('Ymd'),
                ]);
    
                $RequisitionLines->toQuery()->update([
                    'PPO' => $requisition->PPO,
                    'PEDTE' => Carbon::today()->format('Ymd'),
                    'PPCLS' => Carbon::today()->format('Ymd'),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al actualizar la requisición final: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar la requisición final.');
        }
    }
    
    private function actualizarSelectedRQ()
    {
        try {
            $this->selectedRQ->update([
                'UploadedINFOR' => true,
                'UploadedINFORDate' => Carbon::today(),
                'UploadedINFORName' => Auth::user()->name,
                'StatusList_id' => 18,
            ]);
    
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRQ->id,
                'StatusList_id' => 18,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la cotización seleccionada: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al actualizar la cotización seleccionada.');
        }
    }
    
    public function SendRQLYH100($NRQ, $RQL)
    {
        try {
            $DueDate = Carbon::createFromFormat('Y-m-d', $RQL->dateArrival)->format('Ymd');
            $fechaActual = Carbon::now();
            $date = $fechaActual->format('Ymd');
            $time = $fechaActual->format('His');
    
            // Crear variable temporal para HRCDES sin caracteres especiales ni acentos
            $HRCDES = $this->removeSpecialCharacters($RQL->name);
    
            YH100::create([
                'HRRQID' => $NRQ,
                'HRRLIN' => $RQL->numLine,
                'HRRQNO' => '0',
                'HRORD' =>  '0',
                'HRLINE' => '0',
                'HRVEND' => $RQL->supplier->VENDOR,
                'HRWHSE' => $RQL->costCenter->name,
                'HRSHIP' => $RQL->quoteRequest->costCenter->name,
                'HRBUYC' => $RQL->quoteRequest->buyer->PBPBC,
                'HRCCOD' => $RQL->commodity->PCCOM,
                'HRCDES' => $HRCDES,
                'HRQORD' => $RQL->quantity,
                'HRDDTE' => $DueDate,
                'HRECST' => round($RQL->UnitCost , 4),
                'HRUM' => 'EA',
                'HRITXC' => $RQL->CODEIVA,
                'HROPRF' => $RQL->commodity->PCPRF,
                'HRCDT' => $date,
                'HRCTM' => $time,
                'HRCBY' => 'YKMS002',
            ]);
    
            $RQL->update(['PORD' => $NRQ]);
            $this->CloseModalConfirmSendYH100();
        } catch (\Exception $e) {
            Log::error('Error creating YH100 record: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al crear el registro YH100.');
        }
    }
    
    private function removeSpecialCharacters($string)
    {
        // Eliminar acentos y convertir a ASCII
        $unaccented = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    
        // Eliminar caracteres especiales
        $cleaned = preg_replace('/[^A-Za-z0-9 ]/', '', $unaccented);
    
        return $cleaned;
    }
    

}