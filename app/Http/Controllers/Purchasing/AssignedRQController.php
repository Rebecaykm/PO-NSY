<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use App\Models\RequestQuote;
use Illuminate\Http\Request;
use PDF;
class AssignedRQController extends Controller
{
    //
    public function index(){
        return view('Purchasing.requestRequisition.index');
    }
    

    public function pdf(RequestQuote $selectedRQ){
        
        $name = 'PurchaseOrder_' . $selectedRQ->RFQ . '.pdf';
        $pdf = PDF::loadView('Purchasing.requestRequisition.pdf', ['selectedRQ' => $selectedRQ]);
        // return  $pdf->download($name);
        // return  $pdf->setPaper('A4','landscape')->stream($name);
        return $pdf->setPaper('letter', 'landscape')->stream($name);
        // return view('Purchasing.requestRequisition.pdf',compact('selectedRQ'));
    }
}
