<?php

namespace App\Http\Controllers\Configuration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function index(){
        return view('Configuration.Supplier.index');
    }
}
