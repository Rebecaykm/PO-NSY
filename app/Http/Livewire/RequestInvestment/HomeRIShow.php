<?php
namespace App\Http\Livewire\RequestInvestment;
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
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class HomeRIShow extends Component
{
    use WithFileUploads, WithPagination;
    
    public $search, $selectedStatus, $selectedOrderBy = 'Worknumber', $selectedOrder = 'DESC';
    public $selectedRI = null, $selectedRQ = null, $perPage = 10, $page = 1;
    public $showSaveRIModal = true, $showRIModalSendRI = true;
    public $modalOpen = false, $modalClose = true;
    public $ER_MXN_USD = 0;
    public $ER_MXN_JPY = 0;
    public $ER_USD_MXN = 0;
    public $ER_JPY_MXN = 0;
    public $ER_USD_JPY = 0;    
    public $ER_JPY_USD = 0;
    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];
    
    // Request Investment Properties
    public $RFQ = null, $WorkNumber = null, $Buyer_id = null, $User_id = null, $ProjectName = null;
    public $ThemeOfRequest = null, $RequestQuote_id = null, $Budget = 0, $BudgetAmount = null;
    public $CurrencyType = null, $RateYen = 0.0, $YenConversion = null, $NoBudgetReason = null;
    public $FirstQuotingCompany = null, $SecondQuotingCompany = null, $ThirdQuotingCompany = null;
    public $FirstQuotingCost = null, $SecondQuotingCost = null, $ThirdQuotingCost = null;
    public $FirstQuotingCurrency = null, $SecondQuotingCurrency = null, $ThirdQuotingCurrency = null;
    public $FirstYenExchangeRate = null, $FirstYenCost = null, $SecondYenExchangeRate = null;
    public $SecondYenCost = null, $ThirdYenExchangeRate = null, $ThirdYenCost = null;
    public $AffectedPlace = null, $AffectedMachine = null, $YearsOfUse = null, $StartOfWorkDate = null;
    public $CompletionDate = null, $StartOfUseDate = null, $PaymentDate = null, $ClientRecovery = null;
    public $RecoveryMethod = null, $SelectedSupplier = null, $SelectedQuoteCost = null;
    public $SelectedQuoteCurrency = null, $YenAmount = null, $SelectionReason = null, $AssignedAccount = null;
    public $DurationYears = null, $AffectedAssetNumber = null, $ExpenseIncreasesUsefulLifeOfCurrentFA = null;
    public $ProposingDepartment = null, $ExpenseCoveringDepartment = null, $ObjectiveDescription = null;
    public $JapaneseObjectiveDescription = null, $ObjectiveContent = null, $JapaneseObjectiveContent = null;
    public $ApproveUser = null, $UserApproveUser = null, $DateApproveUser = null, $ApproveManager = null;
    public $UserApproveManager = null, $DateApproveManager = null, $ApproveBuyer = null, $UserApproveBuyer = null;
    public $DateApproveBuyer = null, $ApproveDirector = null, $UserApproveDirector = null, $DateApproveDirector = null;
    public $ApproveVicePresident = null, $UserApproveVicePresident = null, $DateApproveVicePresident = null;
    public $ApprovePresident = null, $UserApprovePresident = null, $DateApprovePresident = null;
    public $ReviewedByFinance = null, $UserReviewedByFinance = null, $DateReviewedByFinance = null;
    public $StatusList_id = null, $files = null;

    public function render()
    {
        return view('livewire.request-investment.home-r-i-show', [
            'RequestsInvestment' => $this->getRequestInvestments(),
            'suppliers' => $this->getSuppliers(),
            'chosenSuppliers' => $this->getChosenSuppliers(),
            // 'secondSuppliers' => $this->getSecondSuppliers(),
            // 'thirdSuppliers' => $this->getThirdSuppliers(),
            'costCenters' => $this->getCostCenters(),
            'currencies' => $this->getCurrencies(),
            'quotes' => $this->getQuotes(),
        ]);
    }

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
    public function getFiles()
    {
        return ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;
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
    
    private function getRequestInvestments()
    {
        try {
            $user = Auth::user();
            return RequestInvestment::where('User_id', $user->id)
                                    ->orderBy($this->selectedOrderBy, $this->selectedOrder)
                                    ->paginate($this->perPage, ['*'], 'page', $this->page);
        } catch (\Exception $e) {
            Log::error('Error al obtener solicitudes de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener solicitudes de inversión.');
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
    
    public function OpenModalSaveRI()
    {
        try {
            $this->showSaveRIModal = $this->modalOpen;
            if ($this->selectedRI) {
                $this->FirstQuotingCost = floatval(round($this->selectedRI->quoteRequest->TotalCostMXN, 4));
                $this->FirstYenCost = floatval(round($this->selectedRI->quoteRequest->TotalCostJPY, 4));
                $this->DataCharge();
            }
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de guardar RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de guardar RI.');
        }
    }
    
    public function OpenModalConfirmSendRI()
    {
        try {
            $this->showRIModalSendRI = $this->modalOpen;
        } catch (\Exception $e) {
            Log::error('Error al abrir el modal de confirmar envío de RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al abrir el modal de confirmar envío de RI.');
        }
    }
    
    public function CloseModalSaveRI()
    {
        try {
            $this->showSaveRIModal = $this->modalClose;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de guardar RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de guardar RI.');
        }
    }
    
    public function CloseModalConfirmSendRI()
    {
        try {
            $this->showRIModalSendRI = $this->modalClose;
        } catch (\Exception $e) {
            Log::error('Error al cerrar el modal de confirmar envío de RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al cerrar el modal de confirmar envío de RI.');
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
            $this->CloseModalSaveRI();
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
    
    public function SaveRI()
    {
        try {
            $validatedData = $this->validate($this->validationRules());
            $this->selectedRI->update($this->formatDates($validatedData));
        } catch (\Exception $e) {
            Log::error('Error al guardar RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al guardar RI.');
        }
    }

    
    private function validationRules()
    {
        return [
            'ProjectName' => 'nullable', 'ThemeOfRequest' => 'nullable', 'RequestQuote_id' => 'nullable',
            'Budget' => 'nullable', 'BudgetAmount' => 'nullable', 'CurrencyType' => 'nullable', 'RateYen' => 'nullable',
            'YenConversion' => 'nullable', 'NoBudgetReason' => 'nullable', 'FirstQuotingCompany' => 'nullable',
            'SecondQuotingCompany' => 'nullable', 'ThirdQuotingCompany' => 'nullable', 'FirstQuotingCost' => 'nullable',
            'SecondQuotingCost' => 'nullable', 'ThirdQuotingCost' => 'nullable', 'FirstQuotingCurrency' => 'nullable',
            'SecondQuotingCurrency' => 'nullable', 'ThirdQuotingCurrency' => 'nullable', 'FirstYenExchangeRate' => 'nullable',
            'FirstYenCost' => 'nullable', 'SecondYenExchangeRate' => 'nullable', 'SecondYenCost' => 'nullable',
            'ThirdYenExchangeRate' => 'nullable', 'ThirdYenCost' => 'nullable', 'AffectedPlace' => 'nullable',
            'AffectedMachine' => 'nullable', 'YearsOfUse' => 'nullable', 'StartOfWorkDate' => 'nullable',
            'CompletionDate' => 'nullable', 'StartOfUseDate' => 'nullable', 'PaymentDate' => 'nullable',
            'ClientRecovery' => 'nullable', 'RecoveryMethod' => 'nullable', 'SelectedQuoteCost' => 'nullable',
            'SelectedQuoteCurrency' => 'nullable', 'YenAmount' => 'nullable', 'SelectionReason' => 'nullable',
            'AssignedAccount' => 'nullable', 'DurationYears' => 'nullable', 'AffectedAssetNumber' => 'nullable',
            'ExpenseIncreasesUsefulLifeOfCurrentFA' => 'nullable', 'ProposingDepartment' => 'nullable',
            'ExpenseCoveringDepartment' => 'nullable', 'ObjectiveDescription' => 'nullable', 'JapaneseObjectiveDescription' => 'nullable',
            'ObjectiveContent' => 'nullable', 'JapaneseObjectiveContent' => 'nullable', 'ApproveUser' => 'nullable',
            'UserApproveUser' => 'nullable', 'DateApproveUser' => 'nullable', 'ApproveManager' => 'nullable',
            'UserApproveManager' => 'nullable', 'DateApproveManager' => 'nullable', 'ApproveBuyer' => 'nullable',
            'UserApproveBuyer' => 'nullable', 'DateApproveBuyer' => 'nullable', 'ApproveDirector' => 'nullable',
            'UserApproveDirector' => 'nullable', 'DateApproveDirector' => 'nullable', 'ApproveVicePresident' => 'nullable',
            'UserApproveVicePresident' => 'nullable', 'DateApproveVicePresident' => 'nullable', 'ApprovePresident' => 'nullable',
            'UserApprovePresident' => 'nullable', 'DateApprovePresident' => 'nullable', 'ReviewedByFinance' => 'nullable',
            'UserReviewedByFinance' => 'nullable', 'DateReviewedByFinance' => 'nullable'
        ];
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
            session()->flash('error', 'Ocurrió un error al formatear fecha<s.');
            return [];
        }
    }
    
    public function SendRequestInvestment()
    {
        try {
            $this->selectedRI->update([
                'StatusList_id' => 21,
                'ApproveUser' => true,
                'UserApproveUser' => Auth::user()->name,
                'DateApproveUser' => Carbon::today()->format('Y-m-d'),
            ]);
            QuoteHistory::create([
                'QuoteRequest_id' => $this->selectedRI->quoteRequest->id,
                'StatusList_id' => 21,
            ]);
            $this->showRIModalSendRI = $this->modalClose;
            $this->showSaveRIModal = $this->modalClose;
            session()->flash('message', 'Solicitud de inversión enviada a Gerente.');
        } catch (\Exception $e) {
            Log::error('Error al enviar solicitud de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al enviar la solicitud de inversión.');
        }
    }
}
