<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionLine extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'PID','RFQ','PORD','PLINE','PPROD','PVEND','PQORD','PQREC','PDDTE','PECST','PUM','PLTDT','PPRT','PCQTY','PSHIP','PTMKY','PUMCN','PBUYC','PWHSE','POCUR','POVTXC','POITXC','POSHTY','PONAME','POSTE','POCOUN','POCOM','PODESC',
    ];
}
