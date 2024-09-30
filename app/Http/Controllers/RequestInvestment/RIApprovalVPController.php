<?php

namespace App\Http\Controllers\RequestInvestment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RIApprovalVPController extends Controller
{
    //
    public function index(){
        return view('RequestInvestment.ApprovalVP.index');
    }
}
