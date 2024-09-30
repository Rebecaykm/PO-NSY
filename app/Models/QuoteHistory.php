<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteHistory extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'QuoteRequest_id', 'StatusList_id','remark'
    ];

    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class, 'QuoteRequest_id');
    }

    public function statusList(){
        return $this->belongsTo(StatusList::class, 'StatusList_id');
    }
}
