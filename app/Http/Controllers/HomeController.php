<?php

namespace App\Http\Controllers;

use App\Models\HPO;
use App\Models\ZRC;
use App\Models\ZRT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

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

    
    public function pdf($PORD){
        
        $name = 'PurchaseOrder_' . $PORD . '.pdf';
        $Lines = HPO::where('PORD', 'like', '%' . $PORD . '%')
                        ->where('PID','PO')
                        ->orderBy('PLINE',  'ASC')
                        ->get();
        [$ST, $IVA, $IRF, $OT] = $this->calcularImpuestosYSubtotal($Lines);
        $pdf = PDF::loadView('pdf', ['PORD' => $PORD, 'SUBTOTAL' => $ST, 'IVA' => $IVA, 'IRF' => $IRF, 'OT' => $OT]);
        return $pdf->setPaper('letter', 'landscape')->stream($name);
    }

    private function calcularImpuestosYSubtotal($Lines)
    {
        try {
            $subtotal = 0.0;
            $IVA = 0.0;
            $IRF = 0.0;
            $OtherTax = 0.0;
    
            foreach ($Lines as $line) {
                
                $taxData = $this->obtenerDatosImpuestos($line);
    
                $IVA += $taxData['IVA'];
                $IRF += $taxData['IRF'];
                $OtherTax += $taxData['OtherTax'];
                $subtotal += $taxData['subtotal'];
            }
            return [$subtotal, $IVA, $IRF, $OtherTax];
        } catch (\Exception $e) {
            Log::error('Error al calcular impuestos y subtotal: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al calcular impuestos y subtotal.');
            return [0, 0, 0, 0]; // Retorna valores por defecto en caso de error
        }
    }
    
    private function obtenerDatosImpuestos($line)
    {
        try {
            
            $total = $line->PQORD * $line->PECST;
            $zrt = ZRT::where('RTCVCD', 'like', '%' . trim($line->POVTXC) . '%')
                        ->where('RTICDE', 'like', '%' . trim($line->POITXC) . '%')
                        ->first();
            
            $ZRC_IVA = ZRC::where('RCRTCD', $zrt->RTRC01)->first();
            $ZRC_IRF = ZRC::where('RCRTCD', $zrt->RTRC02)->first();
            $ZRC_OtherTax1 = ZRC::where('RCRTCD', $zrt->RTRC02)->first();
            $ZRC_OtherTax2 = ZRC::where('RCRTCD', $zrt->RTRC03)->first();
            // dd('test1');
            
            $IVA_Aux = !empty($ZRC_IVA) ? round($total * floatval($ZRC_IVA->RCCRTE) / 100, 4) : 0.0;
            $IRF_Aux = !empty($ZRC_IRF) ? round($total * floatval($ZRC_IRF->RCCRTE) / 100, 4) : 0.0;
            // dd('test2');
            
            $OtherTax1 = (!empty($ZRC_OtherTax1)) ? round($total * floatval($ZRC_OtherTax1->RCCRTE) / 100, 4) : 0.0;
            $OtherTax2 = (!empty($ZRC_OtherTax2)) ? round($total * floatval($ZRC_OtherTax2->RCCRTE) / 100, 4) : 0.0;
            $OtherTax_Aux = $OtherTax1 + $OtherTax2;
            
            $line->IVA = $IVA_Aux;
            $line->IRF = $IRF_Aux;
            $line->OTEHERTAX = $OtherTax_Aux ;
    
            return ['IVA' => $IVA_Aux, 'IRF' => $IRF_Aux, 'OtherTax' => $OtherTax_Aux, 'subtotal' => $total];
        } catch (\Exception $e) {
            Log::error('Error al obtener datos de impuestos: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener datos de impuestos.');
            return ['IVA' => 0.0, 'IRF' => 0.0, 'OtherTax' => 0.0, 'subtotal' => 0.0]; // Retorna valores por defecto en caso de error
        }
    }
}
