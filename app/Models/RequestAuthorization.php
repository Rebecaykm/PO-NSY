<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAuthorization extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'RFQ','QuoteRequest_id','QuoteLine_id','Department_id','CostCenter_id','Check'
    ];

    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class,'QuoteRequest_id');
    }
    public function quoteLine(){
        return $this->belongsTo(QuoteLine::class,'QuoteLine_id');
    }
    public function departament(){
        return $this->belongsTo(Department::class, 'Department_id');
    }
    public function costCenter(){
        return $this->belongsTo(CostCenter::class, 'CostCenter_id');
    }
}
