<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'code', 'name', 'description', 'status'
    ];

    // Relación con la tabla quote_lines
    public function quoteLines(){
        return $this->hasMany(QuoteLine::class, 'Currency_id');
    }
    public function quote(){
        return $this->hasMany(Quote::class, 'Currency_id');
    }
    public function requestRequisition(){
        return $this->hasMany(RequestRequisition::class, 'Currency_id'); 
    }
}
