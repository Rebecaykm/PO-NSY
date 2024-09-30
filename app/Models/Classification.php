<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'code', 'description','name','status','Category_id'
    ];
    //Relación uno a muchos (  -  )
    public function category(){
        return $this->belongsTo(Category::class,'Category_id');
    }
    public function item(){
        return $this->hasMany(Item::class, 'Classification_id');
    }
}
