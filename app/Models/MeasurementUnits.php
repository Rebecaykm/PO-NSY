<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnits extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'code', 'name', 'description', 'status',
    ];
    public function item(){
        return $this->hasMany(Item::class, 'MeasurementUnits_id');
    }
    public function quoteLine(){
        return $this->hasMany(QuoteLine::class, 'MeasurementUnits_id');
    }
}
