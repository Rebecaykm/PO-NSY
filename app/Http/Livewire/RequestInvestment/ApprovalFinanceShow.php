<?php

namespace App\Http\Livewire\RequestInvestment;

use Livewire\Component;
use App\Models\{Currency,GCC,Quote,RequestInvestment,Supplier, QuoteFile, QuoteHistory, QuoteLine, RequestQuote};
use Carbon\Carbon;
use Illuminate\Support\Facades\{Auth,Log};
use Livewire\WithPagination;

class ApprovalFinanceShow extends Component
{
    use WithPagination;
    
    public $search, $selectedStatus, $selectedOrderBy = 'Worknumber', $selectedOrder = 'DESC';
    public $selectedRI = null, $selectedRQ = null, $perPage = 10, $page = 1;
    public $showQuoteModal = true, $showModalViewRI = true;
    public $showConfirmApprovalModal = true, $showModalConfirmRejectedRI = true ;
    public $showConfirmRejectModal = true, $showModalConfirmApprovateRI = true ;
    public $modalOpen = false, $modalClose = true;
    public $open = false, $close = true;
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
        return view('livewire.request-investment.approval-finance-show', [
            'RequestsInvestment' => $this->getRequestInvestments(),
            'chosenSuppliers' => $this->getChosenSuppliers(),
            'currencies' => $this->getCurrencies(),
            'quotes' => $this->getQuotes(),
        ]);
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
    private function getQuotes()
    {
        try {
            return ($this->selectedRQ) ? Quote::where('QuoteRequest_id',$this->selectedRQ->id)
                                            ->orderBy('QuoteLine_id','ASC')
                                            ->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al obtener cotizaciones: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener cotizaciones.');
            return collect();
        }
    }
    private function getRequestInvestments()
    {
        try {
            return RequestInvestment::whereIn('StatusList_id',[31,35,44])
            ->orderBy($this->selectedOrderBy,$this->selectedOrder)
            ->paginate($this->perPage);
            
            
        } catch (\Exception $e) {
            Log::error('Error al obtener solicitudes de inversión: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener solicitudes de inversión.');
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

    public function resetPage(){
        $this->page = 1;
        $this->render();
    }

    public function selectOrderFlag($field){
        $this->selectedOrderBy = $field;
        $this->selectedOrder = ($this->selectedOrder === 'ASC') ? 'DESC' : 'ASC';
    }
    
    public function clearFilters(){
        $this->selectedStatus = null;
        $this->search = null;
        $this->selectedRQ = null;
        $this->showQuoteModal = $this->close;
        $this->showConfirmApprovalModal = $this->close;
        $this->showConfirmRejectModal = $this->close;
    }
    // public function getFiles()
    // {
    //     return ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;
    // }
    public function selectRI($RI_id)
    {
        try {
            $this->selectedRI = RequestInvestment::find($RI_id);
            $this->selectedRQ = RequestQuote::find($this->selectedRI->RequestQuote_id);
            // $this->files = $this->getFiles();
            $this->files = ($this->selectedRQ) ? QuoteFile::where('QuoteRequest_id',$this->selectedRQ->id)->get() : null;
        } catch (\Exception $e) {
            Log::error('Error al seleccionar RI: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al seleccionar RI.');
        }
    }

    public function DataCharge(){
        $this->ProjectName = $this->selectedRI->ProjectName;
        $this->ThemeOfRequest = $this->selectedRI->ThemeOfRequest;
        $this->RequestQuote_id = $this->selectedRI->RequestQuote_id;
        $this->Budget = $this->selectedRI->Budget;
        $this->BudgetAmount = $this->selectedRI->BudgetAmount;
        $this->CurrencyType = $this->selectedRI->CurrencyType;
        $this->RateYen = $this->selectedRI->RateYen;
        $this->YenConversion = $this->selectedRI->YenConversion;
        $this->NoBudgetReason = $this->selectedRI->NoBudgetReason;
        $this->FirstQuotingCompany = $this->selectedRI->FirstQuotingCompany;
        $this->SecondQuotingCompany = $this->selectedRI->SecondQuotingCompany;
        $this->ThirdQuotingCompany = $this->selectedRI->ThirdQuotingCompany;
        $this->FirstQuotingCost = $this->selectedRI->FirstQuotingCost;
        $this->SecondQuotingCost = $this->selectedRI->SecondQuotingCost;
        $this->ThirdQuotingCost = $this->selectedRI->ThirdQuotingCost;
        $this->FirstQuotingCurrency = $this->selectedRI->FirstQuotingCurrency;
        $this->SecondQuotingCurrency = $this->selectedRI->SecondQuotingCurrency;
        $this->ThirdQuotingCurrency = $this->selectedRI->ThirdQuotingCurrency;
        $this->FirstYenExchangeRate = $this->selectedRI->FirstYenExchangeRate;
        $this->FirstYenCost = $this->selectedRI->FirstYenCost;
        $this->SecondYenExchangeRate = $this->selectedRI->SecondYenExchangeRate;
        $this->SecondYenCost = $this->selectedRI->SecondYenCost;
        $this->ThirdYenExchangeRate = $this->selectedRI->ThirdYenExchangeRate;
        $this->ThirdYenCost = $this->selectedRI->ThirdYenCost;
        $this->AffectedPlace = $this->selectedRI->AffectedPlace;
        $this->AffectedMachine = $this->selectedRI->AffectedMachine;
        $this->YearsOfUse = $this->selectedRI->YearsOfUse;
        $this->StartOfWorkDate = $this->selectedRI->StartOfWorkDate;
        $this->CompletionDate = $this->selectedRI->CompletionDate;
        $this->StartOfUseDate = $this->selectedRI->StartOfUseDate;
        $this->PaymentDate = $this->selectedRI->PaymentDate;
        $this->ClientRecovery = $this->selectedRI->ClientRecovery;
        $this->RecoveryMethod = $this->selectedRI->RecoveryMethod;
        $this->SelectedQuoteCost = $this->selectedRI->SelectedQuoteCost;
        $this->SelectedQuoteCurrency = $this->selectedRI->SelectedQuoteCurrency;
        $this->YenAmount = $this->selectedRI->YenAmount;
        $this->SelectionReason = $this->selectedRI->SelectionReason;
        $this->AssignedAccount = $this->selectedRI->AssignedAccount;
        $this->DurationYears = $this->selectedRI->DurationYears;
        $this->AffectedAssetNumber = $this->selectedRI->AffectedAssetNumber;
        $this->ExpenseIncreasesUsefulLifeOfCurrentFA = $this->selectedRI->ExpenseIncreasesUsefulLifeOfCurrentFA;
        $this->ProposingDepartment = $this->selectedRI->ProposingDepartment;
        $this->ExpenseCoveringDepartment = $this->selectedRI->ExpenseCoveringDepartment;
        $this->ObjectiveDescription = $this->selectedRI->ObjectiveDescription;
        $this->JapaneseObjectiveDescription = $this->selectedRI->JapaneseObjectiveDescription;
        $this->ObjectiveContent = $this->selectedRI->ObjectiveContent;
        $this->JapaneseObjectiveContent = $this->selectedRI->JapaneseObjectiveContent;
        $this->ApproveUser = $this->selectedRI->ApproveUser;
        $this->UserApproveUser = $this->selectedRI->UserApproveUser;
        $this->DateApproveUser = $this->selectedRI->DateApproveUser;
        $this->ApproveManager = $this->selectedRI->ApproveManager;
        $this->UserApproveManager = $this->selectedRI->UserApproveManager;
        $this->DateApproveManager = $this->selectedRI->DateApproveManager;
        $this->ApproveBuyer = $this->selectedRI->ApproveBuyer;
        $this->UserApproveBuyer = $this->selectedRI->UserApproveBuyer;
        $this->DateApproveBuyer = $this->selectedRI->DateApproveBuyer;
        $this->ApproveDirector = $this->selectedRI->ApproveDirector;
        $this->UserApproveDirector = $this->selectedRI->UserApproveDirector;
        $this->DateApproveDirector = $this->selectedRI->DateApproveDirector;
        $this->ApproveVicePresident = $this->selectedRI->ApproveVicePresident;
        $this->UserApproveVicePresident = $this->selectedRI->UserApproveVicePresident;
        $this->DateApproveVicePresident = $this->selectedRI->DateApproveVicePresident;
        $this->ApprovePresident = $this->selectedRI->ApprovePresident;
        $this->UserApprovePresident = $this->selectedRI->UserApprovePresident;
        $this->DateApprovePresident = $this->selectedRI->DateApprovePresident;
        $this->ReviewedByFinance = $this->selectedRI->ReviewedByFinance;
        $this->UserReviewedByFinance = $this->selectedRI->UserReviewedByFinance;
        $this->DateReviewedByFinance = $this->selectedRI->DateReviewedByFinance;
    }
    public function OpenModalViewRI($RI_ID){
        $this->showModalViewRI = $this->open;
        $this->selectRI($RI_ID);
        $this->DataCharge();
    }
    public function ApprovateRI(){
        $this->selectedRI->update([
            'StatusList_id' => 35,
            'ReviewedByFinance' => true,
            'UserReviewedByFinance' => Auth::user()->name,
            'DateReviewedByFinance' => Carbon::today()->format('Y-m-d'),
            'Finanzas_id' => Auth::user()->id,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRI->quoteRequest->id, 
            'StatusList_id' => 35,
            'remark' => 'Aprueba ' . Auth::user()->name,
        ]);
        $this->showModalViewRI = $this->close;
        $this->showModalConfirmApprovateRI = $this->close;
        session()->flash('message', 'Solicitud de inversión aprobada.'); 
    }
    public function RejectedRI(){
        $this->selectedRI->update([
            'StatusList_id' => 44,
            'ReviewedByFinance' => false,
            'UserReviewedByFinance' => Auth::user()->name,
            'DateReviewedByFinance' => Carbon::today()->format('Y-m-d'),
            'Finanzas_id' => Auth::user()->id,
        ]);
        QuoteHistory::create([
            'QuoteRequest_id' => $this->selectedRI->quoteRequest->id, 
            'StatusList_id' => 44,
            'remark' => 'Rechaza ' . Auth::user()->name,
            
        ]);
        $this->showModalViewRI = $this->close;
        $this->showModalConfirmRejectedRI = $this->close;
        session()->flash('message', 'Solicitud de inversión enviada a Gerente.'); 
    }
}
