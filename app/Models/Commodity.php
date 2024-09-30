<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
            'PCID',
            'PCTYPE',
            'PCCOM',
            'PCCTYP',
            'PCCUM',
            'PCDESC',
            'PCALGL',
            'PCEXGL',
            'PCPVGL',
            'PCSLGL',
            'PCCGGL',
            'PCPRF',
            'PCTAXC',
            'PCDDYP',
            'PCDDYM',
            'PCQTYP',
            'PCQTYM',
            'PCAUTO',
            'PCFXCH',
            'PCDSC2',
            'PCCONT',
            'PCOCT1',
            'PCOCT2',
            'PCPREF',
            'PCPRC1',
            'PCPRC2',
            'PCQUOT',
            'PCSDEC',
            'PCSUPU',
            'PCVMCD',
            'PCA1CD',
            'PCADJU',
            'PCECCM',
    ];
    public function requestQuote(){
        return $this->hasMany(RequestQuote::class, 'Commodity_id');
    }
    
    public function requestRequisition(){
        return $this->hasMany(RequestRequisition::class, 'Commodity_id'); 
    }
    public function quoteLine(){
        return $this->hasMany(QuoteLine::class, 'Commodity_id');
    }
}
