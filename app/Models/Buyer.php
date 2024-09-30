<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'PBID', 'PBPBC','PBTYP','PBNAM',
    ];
    public function user(){
        return $this->hasOne(User::class, 'Buyer_id');
    }
    public function quoteRequest(){
        return $this->hasMany(RequestQuote::class, 'Buyer_id');
    }
    public function requestInvestment(){
        return $this->hasMany(RequestInvestment::class, 'Buyer_id');
    }
}
