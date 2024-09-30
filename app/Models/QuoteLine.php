<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteLine extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'PORD',
        'PPO',
        'PEDTE',
        'PPCLS',
        'status',
        'dateRequired',
        'dateArrival',
        'dateArrivalReal',
        'imgPath',
        'name',
        'description',
        'quantity',
        'numLine',
        'Approvate',
        'ApprovateName',
        'ApprovateDate',
        'UnitCost',
        'TotatlCost',
        'TotalCostMXN',
        'TotalCostUSD',
        'TotalCostJPY',
        'UUID',
        'QuantityReturned',
        'QuantityRejected',
        'PickUp',
        'CODEIVA',
        'PickUpDate',
        'Quote_id',
        'Commodity_id',
        'Supplier_id',
        'Currency_id',
        'StatusList_id',
        'Item_id',
        'QuoteRequest_id',
        'CostCenter_id',
        'MeasurementUnit_id',
    ];

    public function requestAuthorization(){
        return $this->hasMany(RequestAuthorization::class,'QuoteLine_id');
    }
    public function providerEmailLog(){
        return $this->hasMany(ProviderEmailLog::class, 'QuoteLine_id');
    }
    public function quote(){
        return $this->hasMany(Quote::class, 'QuoteLine_id');
    }
    public function statusList(){
        return $this->belongsTo(StatusList::class, 'StatusList_id');
    }
    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class, 'QuoteRequest_id');
    }
    public function item(){
        return $this->belongsTo(Item::class, 'Item_id');
    }
    public function costCenter(){
        return $this->belongsTo(CostCenter::class, 'CostCenter_id');
    }
    public function measuremetnUnit(){
        return $this->belongsTo(MeasurementUnits::class, 'MeasurementUnit_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'Supplier_id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class, 'Currency_id');
    }
    public function commodity(){
        return $this->belongsTo(Commodity::class, 'Commodity_id');
    }
}
