<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YH120 extends Model
{
    use HasFactory;
    // protected $connection = 'odbc-connection-lx834fu02';
    protected $connection = 'odbc-connection-lx834fu01';
    // protected $table = 'LX834FU02.YH120';
    protected $table = 'LX834FU01.YH120';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
    protected $fillable = [
        'RHORD',    //PURCHASE ORDER
        'RHLINE',   //LINE NUMBER
        'RHTSEQ',   //TRANS HISTORY SEQ
        'RHTYPE',   //TRANSACTION TYPE
        'RHRDTE',   //RECEIVED DATE
        'RHQREC',   //QUANTITY RECEIVED
        'RHVEND',   //VENDOR NUMBER
        'RHCCOD',   //COMMODITY CODE
        'RHWHS',    //WAREHOUSE
        'RHLOC',    //LOCATION
        'RHTVAL',   //TRANS VALUE
        'RHREAS',   //TRANS REASON CODE
        'RHRENM',   //TRANS REASON DESCRIP
        'RHWEB',    //WEB IF FLAG
        'RHCDT',    //CREATE DATE
        'RHCTM',    //CREATE TIME
        'RHCBY',    //CREATE USER
    ];
}
