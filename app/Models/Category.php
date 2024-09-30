<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'code',
        'description',
        'name',
        'status',
    ];
    public function classification(){
        return $this->hasMany(Classification::class, 'Category_id');
    }
    public function item(){
        return $this->hasMany(Item::class, 'Category_id');
    }
}
