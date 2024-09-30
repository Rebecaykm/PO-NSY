<?php

namespace App\Http\Controllers\RequestInvestment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RIApprovalFinanceController extends Controller
{
    //
    public function index(){
        return view('RequestInvestment.ApprovalFinance.index');
    }
}
