<?php

namespace App\Http\Controllers;

use App\Models\HPO;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $POs = [];
        if ($request->has('search') && !empty($request->search)) {
            $POs = HPO::where('PORD', 'like', '%' . $request->search . '%')
                        ->where('PID','PO')
                        ->orderBy('PLINE', 'DESC')
                        ->first();
        }

        if ($request->ajax()) {
            return response()->json($POs);
        }

        return view('index', ['POs' => $POs]);
    }

    public function show(){
        return response()->json([
        ]);
    }

    public function pdf(HPO $PO){
        
        $name = 'PurchaseOrder_' . $PO->PORD . '.pdf';
        $pdf = PDF::loadView('pdf', ['PO' => $PO]);
        return $pdf->setPaper('letter', 'landscape')->stream($name);
    }
}
