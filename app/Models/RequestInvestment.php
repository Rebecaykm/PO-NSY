<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestInvestment extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
            'RFQ',                  //OK
            'WorkNumber',           //OK
            'Buyer_id',             //OK
            'User_id',              //OK
            'ProjectName',          //ok
            'ThemeOfRequest',       //ok
            'Budget',       
            'BudgetAmount',
            'CurrencyType',
            'RateYen',
            'YenConversion',
            'NoBudgetReason',
            'RequestQuote_id',
            'FirstQuotingCompany',
            'SecondQuotingCompany',
            'ThirdQuotingCompany',
            'FirstQuotingCost',
            'SecondQuotingCost',
            'ThirdQuotingCost',
            'FirstQuotingCurrency',
            'SecondQuotingCurrency',
            'ThirdQuotingCurrency',
            'FirstYenExchangeRate',
            'FirstYenCost',
            'SecondYenExchangeRate',
            'SecondYenCost',
            'ThirdYenExchangeRate',
            'ThirdYenCost',
            'AffectedPlace',
            'AffectedMachine',
            'YearsOfUse',
            'StartOfWorkDate',
            'CompletionDate',
            'StartOfUseDate',
            'PaymentDate',
            'ClientRecovery',
            'RecoveryMethod',
            'SelectedSupplier',
            'SelectedQuoteCost',
            'SelectedQuoteCurrency',
            'YenAmount',
            'SelectionReason',
            'AssignedAccount',
            'DurationYears',
            'AffectedAssetNumber',
            'ExpenseIncreasesUsefulLifeOfCurrentFA',
            'ProposingDepartment',
            'ExpenseCoveringDepartment',
            'ObjectiveDescription',
            'JapaneseObjectiveDescription',
            'ObjectiveContent',
            'JapaneseObjectiveContent',
            'ApproveUser',
            'UserApproveUser',
            'DateApproveUser',
            'ApproveManager',
            'UserApproveManager',
            'DateApproveManager',
            'ApproveBuyer',
            'UserApproveBuyer',
            'DateApproveBuyer',
            'ApproveDirector',
            'UserApproveDirector',
            'DateApproveDirector',
            'ApproveVicePresident',
            'UserApproveVicePresident',
            'DateApproveVicePresident',
            'ApprovePresident',
            'UserApprovePresident',
            'DateApprovePresident',
            'ReviewedByFinance',
            'UserReviewedByFinance',
            'DateReviewedByFinance',
            'StatusList_id',
            'Gerente_id',
            'Director_id',
            'Vicepresidente_id',
            'Presidente_id',
            'Finanzas_id',
    ];

    // Relationships
    public function user(){
        return $this->belongsTo(User::class, 'User_id');
    }
    public function currencyType(){
        return $this->belongsTo(Currency::class, 'CurrencyType');
    }

    public function firstQuotingCompany(){
        return $this->belongsTo(Supplier::class, 'FirstQuotingCompany');
    }

    public function secondQuotingCompany(){
        return $this->belongsTo(Supplier::class, 'SecondQuotingCompany');
    }

    public function thirdQuotingCompany(){
        return $this->belongsTo(Supplier::class, 'ThirdQuotingCompany');
    }

    public function firstQuotingCurrency(){
        return $this->belongsTo(Currency::class, 'FirstQuotingCurrency');
    }

    public function secondQuotingCurrency(){
        return $this->belongsTo(Currency::class, 'SecondQuotingCurrency');
    }

    public function thirdQuotingCurrency(){
        return $this->belongsTo(Currency::class, 'ThirdQuotingCurrency');
    }

    public function selectedSupplier(){
        return $this->belongsTo(Supplier::class, 'SelectedSupplier');
    }

    public function selectedQuoteCurrency(){
        return $this->belongsTo(Currency::class, 'SelectedQuoteCurrency');
    }
    
    public function proposingDepartment() {
        return $this->belongsTo(Department::class, 'ProposingDepartment');
    }

    public function expenseCoveringDepartment(){
        return $this->belongsTo(Department::class, 'ExpenseCoveringDepartment');
    }
    public function statusList(){
        return $this->belongsTo(StatusList::class, 'StatusList_id');
    }
    public function buyer(){
        return $this->belongsTo(Buyer::class, 'Buyer_id');
    }
    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class, 'RequestQuote_id');
    }
}
