<?php

namespace App\Http\Controllers\RequestInvestment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeRI extends Controller
{
    //
    public function index(){
        return view('RequestInvestment.HomeRI.index');
    }
}
