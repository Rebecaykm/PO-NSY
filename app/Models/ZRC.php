<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZRC extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'RCID',
        'RCRTCD',
        'RCDESC',
        'RCEDTE',
        'RCCSET',
        'RCCTXR',
        'RCNTXR',
        'RCCTRA',
        'RCNTRA',
        'RCCTXP',
        'RCNTXP',
        'RCCTPA',
        'RCNTPA',
        'RCCRTE',
        'RCNRTE',
        'RCRNDM',
        'RCRNDP',
        'RCTAXN',
        'RCVATT',
        'RCVATN',
        'RCINPC',
        'RCINF',
    ];
}
