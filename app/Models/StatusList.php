<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusList extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'code', 'name','description','status',
    ];
    public function requestQuote(){
        return $this->hasMany(RequestQuote::class, 'StatusList_id');
    }
    public function quoteLine(){
        return $this->hasMany(QuoteLine::class, 'StatusList_id');
    }
    public function quoteHistory(){
        return $this->hasMany(QuoteHistory::class, 'StatusList_id');
    }
    public function requestInvestment(){
        return $this->hasMany(RequestInvestment::class, 'StatusList_id');
    }
}
