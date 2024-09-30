<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenter extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'code', 'name', 'description', 'status',
    ];
    //Relación uno a muchos (  -  )
    public function department(){
        return $this->belongsTo(Department::class,'Department_id');
    }
    public function quoteLine(){
        return $this->hasMany(QuoteLine::class, 'CostCenter_id');
    }
    public function quoteRequest(){
        return $this->hasMany(RequestQuote::class,'CostCenter_id');
    }
    public function requestAuthorization(){
        return $this->hasMany(RequestAuthorization::class, 'CostCenter_id');
    }
}
