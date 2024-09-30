<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AVM;

class AVMController extends Controller
{
    public function index()
    {
        $AVM = AVM::query()
        ->SELECT([
            'VNSTAT','VMID','VENDOR','VNDNAM'
        ])
        ->orderBy('VENDOR','DESC')
        ->get();

        return view('Admin.AVM.index',['AVM' => $AVM]);
    }
}
