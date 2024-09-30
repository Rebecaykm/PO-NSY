<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'Cost','dateArrived','description','QuoteRequest_id','QuoteLine_id','Supplier_id','Currency_id','NumDaysArrival'
    ];

    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class,'QuoteRequest_id');
    }
    public function quoteLine(){
        return $this->belongsTo(QuoteLine::class, 'QuoteLine_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'Supplier_id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class, 'Currency_id');
    }
}
