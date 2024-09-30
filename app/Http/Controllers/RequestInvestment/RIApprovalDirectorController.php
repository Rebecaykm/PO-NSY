<?php

namespace App\Http\Controllers\RequestInvestment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RIApprovalDirectorController extends Controller
{
    //public function
    public function index(){
        return view('RequestInvestment.ApprovalDirector.index');
    }
}
