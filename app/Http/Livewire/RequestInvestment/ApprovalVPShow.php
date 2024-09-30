<?php

namespace App\Http\Livewire\RequestInvestment;

use Livewire\Component;
use App\Models\CostCenter;
use App\Models\Currency;
use App\Models\GCC;
use App\Models\Quote;
use App\Models\QuoteFile;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestInvestment;
use App\Models\RequestQuote;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ApprovalVPShow extends Component
{
    use WithFileUploads, WithPagination;
    
    public $search, $selectedStatus, $selectedOrderBy = 'Worknumber', $selectedOrder = 'DESC';
    public $selectedRI = null, $selectedRQ = null, $perPage = 10, $page = 1, $files = null;
    public $showSaveRIModal = true, $showRIModalSendRI = true;
    public $modalOpen = false, $modalClose = true;
    public $ER_MXN_USD = 0;
    public $ER_MXN_JPY = 0;
    public $ER_USD_MXN = 0;
    public $ER_JPY_MXN = 0;
    public $ER_USD_JPY = 0;    
    public $ER_JPY_USD = 0;
    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];
    public $ShowModalPurchasingData = true; //Comprador LLenara un formulario
    public $ShowModalApprovateRequestInvestment = true; //Mostrara un modal en el que el comprador aprobará la requisición 
    public $showModalConfirmApprovateRI = true; //Modal para confirmación del la requisición 
    public $showModalConfirmRejectedRI = true;
    public $showModalViewRI = true; //Modal que le dará una vista del la requisición según la solicitud de inversión 
    public $open = false, $close = true;
    public $departmentId, $lengthRQ = 0, $RQRemark = null;
    public $showQuoteModal = true, $showConfirmApprovalModal = true, $showConfirmRejectModal = true;
    public $RFQ = null;
    public $WorkNumber = null;
    public $Buyer_id = null;
    public $User_id = null;
    public $ProjectName = null;
    public $ThemeOfRequest = null;
    public $RequestQuote_id = null;
    public $Budget = null;
    public $BudgetAmount = null;
    public $CurrencyType = null;
    public $RateYen = null;
    public $YenConversion = null;
    public $NoBudgetReason = null;
    public $FirstQuotingCompany = null;
    public $SecondQuotingCompany = null;
    public $ThirdQuotingCompany = null;
    public $FirstQuotingCost = null;
    public $SecondQuotingCost = null;
    public $ThirdQuotingCost = null;
    public $FirstQuotingCurrency = null;
    public $SecondQuotingCurrency = null;
    public $ThirdQuotingCurrency = null;
    public $FirstYenExchangeRate = null;
    public $FirstYenCost = null;
    public $SecondYenExchangeRate = null;
    public $SecondYenCost = null;
    public $ThirdYenExchangeRate = null;
    public $ThirdYenCost = null;
    public $AffectedPlace = null;
    public $AffectedMachine = null;
    public $YearsOfUse = null;
    public $StartOfWorkDate = null;
    public $CompletionDate = null;
    public $StartOfUseDate = null;
    public $PaymentDate = null;
    public $ClientRecovery = null;
    public $RecoveryMethod = null;
    public $SelectedSupplier = null;
    public $SelectedQuoteCost = null;
    public $SelectedQuoteCurrency = null;
    public $YenAmount = null;
    public $SelectionReason = null;
    public $AssignedAccount = null;
    public $DurationYears = null;
    public $AffectedAssetNumber = null;
    public $ExpenseIncreasesUsefulLifeOfCurrentFA = null;
    public $ProposingDepartment = null;
    public $ExpenseCoveringDepartment = null;
    public $ObjectiveDescription = null;
    public $JapaneseObjectiveDescription = null;
    public $ObjectiveContent = null;
    public $JapaneseObjectiveContent = null;
    public $ApproveUser = null;
    public $UserApproveUser = null;
    public $DateApproveUser = null;
    public $ApproveManager = null;
    public $UserApproveManager = null;
    public $DateApproveManager = null;
    public $ApproveBuyer = null;
    public $UserApproveBuyer = null;
    public $DateApproveBuyer = null;
    public $ApproveDirector = null;
    public $UserApproveDirector = null;
    public $DateApproveDirector = null;
    public $ApproveVicePresident = null;
    public $UserApproveVicePresident = null;
    public $DateApproveVicePresident = null;
    public $ApprovePresident = null;
    public $UserApprovePresident = null;
    public $DateApprovePresident = null;
    public $ReviewedByFinance = null;
    public $UserReviewedByFinance = null;
    public $DateReviewedByFinance = null;
    public $StatusList_id = null;
    public $lengthRI = 0;
    public function mount()
    {
        try {
            $date = Carbon::today()->format('Ymd');
    
            $exchangeRates = GCC::where('CCNVDT', $date)->get();
    
            if ($exchangeRates->isEmpty()) {
                $closestDate = GCC::select('CCNVDT')
                    ->orderByRaw("ABS(DATEDIFF(CCNVDT, '$date'))")
                    ->first()
                    ->CCNVDT;
    
                $exchangeRates = GCC::where('CCNVDT', $closestDate)->get();
            }
    
            $exchangeRates = $exchangeRates->keyBy(function ($item) {
                return $item->CCFRCR . '-' . $item->CCTOCR;
            });
    
            $this->ER_MXN_USD = $exchangeRates['MXN-USD']->CCNVFC ?? 0;
            $this->ER_MXN_JPY = $exchangeRates['MXN-JPY']->CCNVFC ?? 0;
            $this->ER_USD_MXN = $exchangeRates['USD-MXN']->CCNVFC ?? 0;
            $this->ER_JPY_MXN = $exchangeRates['JPY-MXN']->CCNVFC ?? 0;
    
            if ($this->ER_MXN_USD) {
                $this->ER_USD_JPY = $this->ER_MXN_JPY / $this->ER_MXN_USD;
            } else {
                $this->ER_USD_JPY = 0;
            }
    
            if ($this->ER_USD_JPY) {
                $this->ER_JPY_USD = 1 / $this->ER_USD_JPY;
            } else {
                $this->ER_JPY_USD = 0;
            }
        } catch (\Exception $e) {
            Log::error('Error al inicializar datos en mount: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al inicializar datos.');
        }
    }
    public function render()
    {
        return view('livewire.request-investment.approval-v-p-show', [
            'RequestsInvestment' => $this->getRequestInvestments(),
            'suppliers' => $this->getSuppliers(),
            'chosenSuppliers' => $this->getChosenSuppliers(),
            'secondSuppliers' => $this->getSecondSuppliers(),
            'thirdSuppliers' => $this->getThirdSuppliers(),
            'costCenters' => $this->getCostCenters(),
            'currencies' => $this->getCurrencies(),
            'quotes' => $this->getQuotes(),
        ]);
    }
    public function getFiles()
    {
        return ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;
    }
    private function getRequestInvestments()
    {
        try {
            return RequestInvestment::whereIn('StatusList_id',[29,46])
            ->orderBy($this->selectedOrderBy,$this->selectedOrder)
            ->paginate($this->perPage);
            
        } catch (\Exception $e) {
            Log::error('Error al obtener solicitudes de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener solicitudes de inversión.');
            return collect();
        }
    }
    private function getQuotes()
    {
        try {
            return ($this->selectedRQ) ? Quote::where('QuoteRequest_id',$this->selectedRQ->id)
                                            ->orderBy('QuoteLine_id','ASC')
                                            ->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener centros de costo: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener centros de costo.');
            return collect();
        }
    }
    // public function getFiles()
    // {
    //     return ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;
    // }
    
    private function getCostCenters()
    {
        try {
            return CostCenter::all();
        } catch (\Exception $e) {
            Log::error('Error al obtener centros de costo: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener centros de costo.');
            return collect();
        }
    }
    
    private function getCurrencies()
    {
        try {
            return Currency::all();
        } catch (\Exception $e) {
            Log::error('Error al obtener monedas: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener monedas.');
            return collect();
        }
    }
    private function getSuppliers()
    {
        try {
            if ($this->selectedRI) {
                $supplierIds = QuoteLine::where('QuoteRequest_id', $this->selectedRI->quoteRequest->id)
                                        ->where('status', true)
                                        ->pluck('Supplier_id')
                                        ->unique();
                return Supplier::whereIn('id', $supplierIds)->get();
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error al obtener proveedores: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener proveedores.');
            return collect();
        }
    }
    
    public function getChosenSuppliers()
    {
        try {
            if ($this->selectedRI) {
                $quoteIds = QuoteLine::where('QuoteRequest_id', $this->selectedRI->quoteRequest->id)
                                    ->where('status', true)
                                    ->pluck('Quote_id')
                                    ->unique();
    
                $supplierIds = Quote::whereIn('id', $quoteIds)
                                    ->pluck('Supplier_id')
                                    ->unique();
    
                return Supplier::whereIn('id', $supplierIds)->get();
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error al obtener proveedores elegidos: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener proveedores elegidos.');
            return collect();
        }
    }

    public function getSecondSuppliers()
    {
        try {
            if ($this->selectedRI) {
                $quoteLines = QuoteLine::where('QuoteRequest_id', $this->selectedRI->quoteRequest->id)
                                    ->where('status', true)
                                    ->get();
                
                $supplierIds = [];
                foreach ($quoteLines as $quoteLine) {
                    $quoteSupplierIds = Quote::where('id', $quoteLine->Quote_id)
                                            ->pluck('Supplier_id')
                                            ->toArray();
                    if (count($quoteSupplierIds) >= 2) {
                        $supplierIds = array_merge($supplierIds, $quoteSupplierIds);
                    }
                }
                
                return Supplier::whereIn('id', array_unique($supplierIds))->get();
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error al obtener proveedores secundarios: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener proveedores secundarios.');
            return collect();
        }
    }

    public function getThirdSuppliers()
    {
        try {
            if ($this->selectedRI) {
                $quoteLines = QuoteLine::where('QuoteRequest_id', $this->selectedRI->quoteRequest->id)
                                    ->where('status', true)
                                    ->get();
                $supplierIds = [];
                foreach ($quoteLines as $quoteLine) {
                    $quoteSupplierIds = Quote::where('id', $quoteLine->Quote_id)
                                            ->pluck('Supplier_id')
                                            ->toArray();
                    if (count($quoteSupplierIds) >= 3) {
                        $supplierIds = array_merge($supplierIds, $quoteSupplierIds);
                    }
                }
                return Supplier::whereIn('id', array_unique($supplierIds))->get();
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error al obtener proveedores terciarios: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener proveedores terciarios.');
            return collect();
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
    
    public function selectRI($RI_id)
    {
        try {
            $this->selectedRI = RequestInvestment::find($RI_id);
            $this->selectedRQ = RequestQuote::find($this->selectedRI->RequestQuote_id);
            $this->files = $this->getFiles();
        } catch (\Exception $e) {
            Log::error('Error al seleccionar RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar RI.');
        }
    }
    
    public function selectOrderFlag($field)
    {
        try {
            $this->selectedOrderBy = $field;
            $this->selectedOrder = $this->selectedOrder === 'ASC' ? 'DESC' : 'ASC';
        } catch (\Exception $e) {
            Log::error('Error al seleccionar la bandera de orden: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar la bandera de orden.');
        }
    }
    
    public function clearFilters()
    {
        try {
            $this->selectedStatus = null;
            $this->search = null;
            $this->selectedRI = null;
            $this->showSaveRIModal = $this->modalClose;
        } catch (\Exception $e) {
            Log::error('Error al limpiar filtros: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al limpiar filtros.');
        }
    }
    
    private function DataCharge()
    {
        try {
            $fields = [
                'ProjectName', 'ThemeOfRequest', 'RequestQuote_id', 'Budget', 'BudgetAmount', 'CurrencyType',
                'RateYen', 'YenConversion', 'NoBudgetReason', 'FirstQuotingCompany', 'SecondQuotingCompany',
                'ThirdQuotingCompany', 'FirstQuotingCost', 'SecondQuotingCost', 'ThirdQuotingCost',
                'FirstQuotingCurrency', 'SecondQuotingCurrency', 'ThirdQuotingCurrency', 'FirstYenExchangeRate',
                'FirstYenCost', 'SecondYenExchangeRate', 'SecondYenCost', 'ThirdYenExchangeRate', 'ThirdYenCost',
                'AffectedPlace', 'AffectedMachine', 'YearsOfUse', 'StartOfWorkDate', 'CompletionDate', 'StartOfUseDate',
                'PaymentDate', 'ClientRecovery', 'RecoveryMethod', 'SelectedQuoteCost', 'SelectedQuoteCurrency',
                'YenAmount', 'SelectionReason', 'AssignedAccount', 'DurationYears', 'AffectedAssetNumber',
                'ExpenseIncreasesUsefulLifeOfCurrentFA', 'ProposingDepartment', 'ExpenseCoveringDepartment',
                'ObjectiveDescription', 'JapaneseObjectiveDescription', 'ObjectiveContent', 'JapaneseObjectiveContent',
                'ApproveUser', 'UserApproveUser', 'DateApproveUser', 'ApproveManager', 'UserApproveManager',
                'DateApproveManager', 'ApproveBuyer', 'UserApproveBuyer', 'DateApproveBuyer', 'ApproveDirector',
                'UserApproveDirector', 'DateApproveDirector', 'ApproveVicePresident', 'UserApproveVicePresident',
                'DateApproveVicePresident', 'ApprovePresident', 'UserApprovePresident', 'DateApprovePresident',
                'ReviewedByFinance', 'UserReviewedByFinance', 'DateReviewedByFinance'
            ];
            foreach ($fields as $field) {
                $this->$field = $this->selectedRI->$field;
            }
        } catch (\Exception $e) {
            Log::error('Error al cargar datos: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cargar datos.');
        }
    }    
    
    private function formatDates($data)
    {
        try {
            $dateFields = ['StartOfWorkDate', 'CompletionDate', 'StartOfUseDate', 'PaymentDate', 'DateApproveUser', 'DateApproveManager', 'DateApproveBuyer', 'DateApproveDirector', 'DateApproveVicePresident', 'DateApprovePresident', 'DateReviewedByFinance'];
            foreach ($dateFields as $field) {
                if (isset($data[$field])) {
                    $data[$field] = Carbon::parse($data[$field])->format('Y-m-d');
                }
            }
            return $data;
        } catch (\Exception $e) {
            Log::error('Error al formatear fechas: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al formatear fechas.');
            return [];
        }
    }

    public function OpenModalViewRI(){
        $this->showModalViewRI = $this->open;
        $this->DataCharge();
    }
    public function ApprovateRI(){
        $this->selectedRI->update([
            'StatusList_id' => 31,
            'ApproveVicePresident' => true,
            'UserApproveVicePresident' => Auth::user()->name,
            'DateApproveVicePresident' => Carbon::today()->format('Y-m-d'),
            'ApprovePresident' => true,
            'UserApprovePresident' => Auth::user()->name,
            'DateApprovePresident' => Carbon::today()->format('Y-m-d'),
            'Vicepresidente_id' => Auth::user()->id,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRI->quoteRequest->id, 
            'StatusList_id' => 30,
            'remark' => 'Aprueba ' . Auth::user()->name,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRI->quoteRequest->id, 
            'StatusList_id' => 31,
            'remark' => 'Aprueba ' . Auth::user()->name,
        ]);
        $this->showModalViewRI = $this->close;
        $this->showModalConfirmApprovateRI = $this->close;
        session()->flash('message', 'Solicitud de inversión enviada a Gerente.'); 
    }
    public function RejectedRI(){
        $this->selectedRI->update([
            'StatusList_id' => 46,
            'ApproveVicePresident' => false,
            'UserApproveVicePresident' => Auth::user()->name,
            'DateApproveVicePresident' => Carbon::today()->format('Y-m-d'),
            'Vicepresidente_id' => Auth::user()->id,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRI->quoteRequest->id, 
            'StatusList_id' => 46,
            'remark' => 'Rechaza ' . Auth::user()->name,
        ]);
        $this->showModalViewRI = $this->close;
        $this->showModalConfirmRejectedRI = $this->close;
        session()->flash('message', 'Solicitud de inversión enviada a Gerente.'); 
    }
}
