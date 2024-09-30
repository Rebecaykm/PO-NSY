<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderEmailLog extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'PastDue',
        'Received',
        'status',
        'RequireDate',
        'QuoteRequest_id',
        'QuoteLine_id',
        'Supplier_id',
    ];

    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class, 'QuoteRequest_id');
    }
    public function quoteLine(){
        return $this->belongsTo(QuoteLine::class, 'QuoteLine_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'Supplier_id');
    }

}
