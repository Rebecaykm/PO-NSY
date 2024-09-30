<?php

namespace App\Http\Livewire\RequestInvestment;

use Livewire\Component;
use App\Models\CostCenter;
use App\Models\Currency;
use App\Models\RequestInvestment;
use App\Models\Supplier;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class ApproverRequestsShow extends Component
{
    use WithFileUploads, WithPagination;
    

    public $showRIModalSendRI = true;
    public $modalOpen = false, $modalClose = true;
    public $ER_MXN_USD = 0;
    public $ER_MXN_JPY = 0;
    public $ER_USD_MXN = 0;
    public $ER_JPY_MXN = 0;
    public $ER_USD_JPY = 0;    
    public $ER_JPY_USD = 0;
    protected $queryString = ['search', 'page', 'selectedOrderBy', 'selectedOrder'];
    public $search, $selectedStatus, $selectedOrderBy = 'Worknumber', $selectedOrder = 'DESC', $cadena;
    public $selectedRI = null,  $perPage = 10, $page = 1;
    public $ShowModalPurchasingData = true; //Comprador LLenara un formulario
    public $ShowModalApprovateRequestInvestment = true; //Mostrara un modal en el que el comprador aprobará la requisición 
    public $ShowModalConfirmApprovateRI = true; //Modal para confirmación del la requisición 
    public $ShowModalViewRequisition = true; //Modal que le dará una vista del la requisición según la solicitud de inversión 
    public $open = true, $close = false;
    public $selectedRQ = null;
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
    public $showSaveRIModal = true;
    public $lengthRI = 0;

    public $showRIModal = true;
    public function render()
    {
        $RequestsInvestment = RequestInvestment::orderBy($this->selectedOrderBy,$this->selectedOrder)
                        ->paginate($this->perPage, ['*'], 'page', $this->page);
        $costCenters = CostCenter::all();
        $currencies = Currency::all();
        $suppliers = Supplier::all();
        return view('livewire.request-investment.approver-requests-show',compact('RequestsInvestment','costCenters','currencies','suppliers'));
    }
}
