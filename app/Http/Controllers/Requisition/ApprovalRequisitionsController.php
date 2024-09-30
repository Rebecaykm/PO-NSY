<?php

namespace App\Http\Controllers\Requisition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprovalRequisitionsController extends Controller
{
    //
    public function index(){
        return view('Requisition.ApprobalRequisition.index');
    }
}
