<?php

namespace App\Http\Controllers\Requisition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseReceptionController extends Controller
{
    //
    public function index(){
        return view('Requisition.WarehouseReception.index');
    }
}
