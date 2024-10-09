<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZRC extends Model
{
    use HasFactory;
    // protected $dateFormat = 'Ymd H:i:s.v';
    // protected $connection = 'odbc-connection-lx834f02';
    protected $connection = 'odbc-connection-lx834f01';
    // protected $table = 'LX834F02.AVM';
    protected $table = 'LX834F01.ZRC';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
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
