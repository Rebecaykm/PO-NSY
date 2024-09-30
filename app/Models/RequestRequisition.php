<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRequisition extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'RFQ',
        'PORD',
        'PPO',
        'PEDTE',
        'PPCLS',
        'Subtotal',
        'IVA',
        'IRF',
        'OtherTax',
        'Total',
        'Reception',
        'ReceptionDate',
        'PickUp',
        'PickUpDate',
        
        'Reception_User_id',
        'PickUp_User_id',
        'Supplier_id',
        'Currency_id',
        'QuoteRequest_id',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'Supplier_id');
    }
    public function currency(){
        return $this->belongsTo(Currency::class, 'Currency_id');
    }
    public function commodity(){
        return $this->belongsTo(Commodity::class, 'Commodity_id');
    }
    public function quoteRequest(){
        return $this->belongsTo(RequestQuote::class, 'QuoteRequest_id');
    }
    public function receptionUser()
    {
        return $this->belongsTo(User::class,'Reception_User_id');
    }
    public function pickupUser()
    {
        return $this->belongsTo(User::class,'PickUp_User_id');
    }
}
