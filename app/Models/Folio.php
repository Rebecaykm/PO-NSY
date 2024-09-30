<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folio extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'name',
        'description',
        'folio',
    ];
}
