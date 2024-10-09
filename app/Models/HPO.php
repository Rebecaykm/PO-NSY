<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HPO extends Model
{
    use HasFactory;
    // protected $connection = 'odbc-connection-lx834f02';
    protected $connection = 'odbc-connection-lx834f01';
    // protected $table = 'LX834F02.HPO';
    protected $table = 'LX834F01.HPO';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
    protected $fillable = [
        //ej.     470694
        'PID',    //Estatus
        'PORD',   //num po
        'PLINE',  //numero de linea
        'PPROD',  //commodity
        'PODESC', //descripcion
        'PUM',    //unidad de medida
        'PDDTE',  //Due Date
        'PQORD',  //Quantity Ordered
        'PECST',  //Unit Cost
        'PVEND',  // VENDOR NUM
        'PSHIP',  // Ship To
        'PONAME', //  Departament ship to
        'PBUYC',  //Buyer
        'POCUR',  //Currency
    ];
}
