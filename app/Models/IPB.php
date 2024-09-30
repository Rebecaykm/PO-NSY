<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPB extends Model
{
    use HasFactory;
    // protected $connection = 'odbc-connection-lx834f02';
    protected $connection = 'odbc-connection-lx834f01';
    // protected $table = 'LX834F02.HPO';
    protected $table = 'LX834F01.IPB';
    public $timestamps = false; // Desactivar timestamps
    public $incrementing = false;
    protected $fillable = [
        'PBID',
        'PBPBC',
        'PBTYP',
        'PBFAC',
        'PBNAM',
        'PBAD1',
        'PBAD2',
        'PBAD3',
        'PBSTE',
        'PBCUN',
        'PBPOST',
        'PBPHON',
        'PBEMAL',
        'PBCSTC',
        'PBUSR',
        'PBDTE',
        'PBTIM',
        'PBAD4',
        'PBAD5',
        'PBAD6',
        'PBRGCD',
    ];
}
