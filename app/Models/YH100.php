<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YH100 extends Model
{
    use HasFactory;
    // protected $connection = 'odbc-connection-lx834f02';
    protected $connection = 'odbc-connection-lx834f01';
    // protected $table = 'LX834F02.HPO';
    protected $table = 'LX834FU01.YH100';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
    protected $fillable = [
        'HRRQID', //Requisition　ID
        'HRRLIN', //Requisition　Line
        'HRRQNO', //Requisition　Number
        'HRORD',  //PO Number
        'HRLINE', //Line　Number
        'HRVEND', //Vendor　Number
        'HRWHSE', //Warehouse
        'HRSHIP', //Ship To Number
        'HRBUYC', //Buyer　Code
        'HRCCOD', //Commodity code
        'HRCDES', //Commodity　Description
        'HRQORD', //Quantity Ordered
        'HRDDTE', //Due　Date
        'HRECST', //Expected　Cost
        'HRUM',   //U／M
        'HRITXC', //Commodity Tax Code
        'HROPRF', //Profit　Center
        'HRCDT',  //Create Date
        'HRCTM',  //Create Time
        'HRCBY',  //Create User
    ];
}
