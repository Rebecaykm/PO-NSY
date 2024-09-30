<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IWM extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
}
