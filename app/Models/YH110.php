<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YH110 extends Model
{
    use HasFactory;
    // protected $connection = 'odbc-connection-lx834fu02';
    protected $connection = 'odbc-connection-lx834fu01';
    // protected $table = 'LX834FU02.YH110';
    protected $table = 'LX834FU01.YH110';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
    protected $fillable = [
        'HHRQID',   //Requisition　ID
        'HHRLIN',   //Requisition　Line
        'HHORD',    //PO Number
        'HHLINE',   //Line　Number
        'HHVEND',   //Vendor　Number
        'HHWHSE',   //Warehouse
        'HHSHIP',   //Ship To Number
        'HHBUYC',   //Buyer　Code
        'HHCCOD',   //Commodity code
        'HHCDES',   //Commodity　Description
        'HHQORD',   //Quantity Ordered
        'HHDDTE',   //Due　Date
        'HHECST',   //Expected　Cost
        'HHUM',     //U／M
        'HHITXC',   //Commodity Tax Code
        'HHOPRF',   //Profit　Center
        'HHCDT',    //Create Date
        'HHCTM',    //Create Time
        'HHCBY',    //Create User
    ];
}
