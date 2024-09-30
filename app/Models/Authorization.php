<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'User_id',
        'Department_id',
        'Status',
        'TypeAuthorization',
    ];
    public function department(){
        return $this->belongsTo(Department::class,'Department_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'User_id');
    }
}
