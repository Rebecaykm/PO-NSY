<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';

    protected $fillable = [
        'CODE', 'Name', 'Description', 'Status',
    ];
    public function authorization(){
        return $this->hasMany(Authorization::class, 'Department_id');
    }
    //Relación uno a muchos (Departments  - Users )
    public function user(){
        return $this->hasMany(User::class, 'Department_id');
    }
    public function costCenter(){
        return $this->hasMany(CostCenter::class, 'Department_id');
    }
    public function requestQuote(){
        return $this->hasMany(RequestQuote::class, 'Department_id');
    }
    public function requestAuthorization(){
        return $this->hasMany(RequestAuthorization::class, 'Department_id');
    }
    
}
