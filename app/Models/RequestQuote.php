<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestQuote extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
            'RFQ',
            'PID',
            'WorkNumber',
            'description',
            'UserName',
            'dateRequiredQuote',
            'ApprovateUserDate',
            'ApprovateUserName',
            'ApprovateUser',
            'ApprovateLinesDate',
            'ApprovateLines',
            'ManagerApprovateDate',
            'ManagerApprovateName',
            'ManagerApprovate',
            'UploadedINFOR',
            'UploadedINFORDate',
            'UploadedINFORName',
            'ApprovateBuyerDate',
            'ApprovateBuyerName',
            'ApprovatePOBuyer',
            'ApprovateDirectorDate',
            'ApprovateDirector',
            'ApprovatePODirector',
            'ApprovateVPresidentDate',
            'ApprovateVPresidentName',
            'ApprovateVPresident',
            'ApprovatePresidentDate',
            'ApprovatePresidentName',
            'ApprovatePresident',
            'Nomina',
            'TotalCostMXN',
            'TotalCostUSD',
            'TotalCostJPY',
            'remarks1',
            'remarks2',
            'remarks3',
            'DateRequireQuotation',
            'User_id',
            'CostCenter_id',
            'Department_id',
            'Commodity_id',
            'Project_id',
            'Buyer_id',
            'StatusList_id',
            'User_id',
            'CostCenter_id',
            'Department_id',
            'Buyer_id',
            'Commodity_id',
            'Project_id',
            'StatusList_id',
            'Gerente_id',
            'Director_id',
            'Vicepresidente_id',
            'Presidente_id',
    ];

    public function quoteFile(){
        return $this->hasMany(QuoteFile::class, 'QuoteRequest_id');
    }
    public function quote(){
        return $this->hasMany(Quote::class, 'QuoteRequest_id');
    }
    public function investmentRequest(){
        return $this->hasMany(RequestInvestment::class,'RequestQuote_id');
    }
    public function quoteHistory(){
        return $this->hasMany(QuoteHistory::class, 'QuoteRequest_id');
    }
    public function providerEmailLog(){
        return $this->hasMany(ProviderEmailLog::class, 'QuoteRequest_id');
    }
    public function authorization(){
        return $this->hasMany(Authorization::class,'QuoteRequest_id');
    }
    public function costCenter(){
        return $this->belongsTo(CostCenter::class,'CostCenter_id');
    }
    public function commodity(){
        return $this->belongsTo(Commodity::class, 'Commodity_id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'Department_id');
    }
    public function quoteLine(){
        return $this->hasMany(QuoteLine::class, 'QuoteRequest_id');
    }
    //Relación inversa uno a muchos ( User - Quote)
    public function user(){
        return $this->belongsTo(User::class, 'User_id');
    }
    public function gerente(){
        return $this->belongsTo(User::class, 'Gerente_id');
    }
    public function director(){
        return $this->belongsTo(User::class, 'Director_id');
    }
    public function vicepresidente(){
        return $this->belongsTo(User::class, 'Vicepresidente_id');
    }
    public function presidente(){
        return $this->belongsTo(User::class, 'Presidente_id');
    }
    public function buyer(){
        return $this->belongsTo(Buyer::class, 'Buyer_id');
    }
    public function statusList(){
        return $this->belongsTo(StatusList::class, 'StatusList_id');
    }
    
    public function project(){
        return $this->belongsTo(Project::class, 'Project_id');
    }
}
