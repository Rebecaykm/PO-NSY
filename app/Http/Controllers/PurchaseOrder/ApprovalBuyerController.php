<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApprovalBuyerController extends Controller
{
    //
    public function index(){
        return view('PurchaseOrder.ApprovalBuyer.index');
    }
}
