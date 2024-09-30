<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'code', 'imgPATH', 'name', 'description', 'status','Category_id','Classification_id','MeasurementUnit_id'
    ];
    public function category(){
        return $this->belongsTo(Category::class,'Category_id');
    }
    public function classification(){
        return $this->belongsTo(Classification::class,'Classification_id');
    }
    public function measurementUnit(){
        return $this->belongsTo(MeasurementUnits::class, 'MeasurementUnit_id');
    }
    public function quoteLine(){
        return $this->hasMany(QuoteLine::class, 'Item_id');
    }
}
