<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'VNSTAT',   //OK
        'VMID',     //OK
        'VENDOR',   //OK
        'VNDNAM',   //OK
        'VNDAD1',   //OK
        'VNDAD2',   //OK
        // 'VSTATE',
        // 'VPOST',
        'VTERMS',   //OK
        'VTYPE',    //OK
        // 'VPAYTO',
        // 'VDTLPD',
        // 'VDAYCL',
        // 'V1099',
        'VPHONE',   //OK
        // 'VCMPNY',
        'VCURR',    //OK
        'VPAYTY',   //OK
        // 'V1TIME',
        // 'VCORPV',
        // 'VHOLD',
        // 'VHOLDT',
        // 'VPYTYR',
        // 'VDSCAV',
        // 'VDSCTK',
        // 'VDPURS',
        // 'VNNEXT',
        // 'VNGEN',
        // 'VNALPH',
        // 'VNUNAL',
        // 'VCON',
        // 'VCOUN',
        // 'V1099S',
        'VPAD1',    //OK
        // 'VPAD2',
        // 'VPSTE',
        // 'VPPST',
        // 'VPCON',
        // 'VPCOU',
        // 'VMFRM',
        // 'VMMAT',
        // 'VTAX',
        // 'VPPHN',
        'VMFSCD',   //OK
        // 'VMIDNM',
        'VTAXCD',   //OK
        // 'VMXCRT',
        // 'VMXDTE',
        // 'VMXMAX',
        // 'VMSRNO',
        // 'VMPREQ',
        // 'VMRELP',
        // 'VMVFAX',
        // 'VMPFAX',
        // 'VMRELM',
        // 'VMPART',
        // 'VMTRBR',
        'VMDATN',   //OK
        // 'VNDAD3',
        // 'VPAD3',
        'VMPDAT',   //OK
        // 'VMBANK',
        // 'VMAD5',
        // 'VMAD6',
        // 'VMLANG',
        // 'VMPAD4',
        // 'VMPAD5',
        // 'VMPAD6',
        // 'VMSHFM',
        // 'VMCCEX',
        // 'VMAYTD',
        // 'VMBNKC',
        // 'VMBRNO',
        // 'VMBNKA',
        // 'VMUF01',
        // 'VMUF02',
        // 'VMUF03',
        // 'VMUF04',
        // 'VMUF05',
        // 'VMUF06',
        // 'VMUF07',
        // 'VMUF08',
        // 'VMUF09',
        // 'VMUF10',
        // 'VM3WMF',
        // 'VMPKRA',
        // 'VMSFBF',
        // 'VMPPHZ',
        // 'VMFPHZ',
        // 'VMDIHZ',
        // 'VMDILT',
        // 'VMPPO',
        // 'VMAQPO',
        // 'VMCRAL',
        // 'VMCREC',
        // 'VMRGCD',    
    ];

    // Relación con la tabla quote_lines
    public function quoteLines(){
        return $this->hasMany(QuoteLine::class,'Supplier_id');
    }
    public function quote(){
        return $this->hasMany(Quote::class,'Supplier_id');
    }
    public function quoteFile(){
        return $this->hasMany(QuoteFile::class,'Supplier_id');
    }
    public function requestRequisition(){
        return $this->hasMany(RequestRequisition::class, 'Supplier_id');
    }
}
