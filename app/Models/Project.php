<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'code',
        'name',
        'description',
        'status',
    ];
    public function requestQuote(){
        return $this->hasMany(RequestQuote::class, 'Project_id');
    }
}
