<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZRT extends Model
{
    use HasFactory;
    protected $dateFormat = 'Ymd H:i:s.v';
    protected $fillable = [
        'RTID',
        'RTCVCD',
        'RTICDE',
        'RTWHSE',
        'RTRC01',
        'RTRC02',
        'RTRC03',
        'RTRC04',
        'RTRC05',
        'RTRC06',
        'RTRC07',
        'RTRC08',
        'RTRC09',
        'RTRC10',
        'RTCF01',
        'RTCF02',
        'RTCF03',
        'RTCF04',
        'RTCF05',
        'RTCF06',
        'RTCF07',
        'RTCF08',
        'RTCF09',
        'RTCF10',
        'RTOTRC',
    ];
}
