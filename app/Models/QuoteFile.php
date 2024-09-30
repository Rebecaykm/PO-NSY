<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteFile extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'fileName', 'filePath', 'Supplier_id', 'QuoteRequest_id',
    ];
    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class,'QuoteRequest_id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'Supplier_id');
    }
}
