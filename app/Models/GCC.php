<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GCC extends Model
{
    use HasFactory;
    protected $connection = 'odbc-connection-lx834f01';
    // protected $connection = 'odbc-connection-lx834f01';
    protected $table = 'LX834F01.GCC';
    // protected $table = 'LX834F01.GCC';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
    protected $fillable = [
                'GCCID',
                'CCNVDT',	
                'CCNVFC',	
                'CCFRCR',	
                'CCTOCR',	
                'CCRTYP',	
                'CCUSER',	
                'CCDATE',	
                'CCTIME',	
                'CCLOCK',	
                'CCCNV2',	
                'CCCMET',
    ];
}
