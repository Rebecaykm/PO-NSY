<?php

namespace App\Http\Controllers\Purchasing;

use App\Http\Controllers\Controller;
use App\Models\RequestQuote;
use App\Models\StatusList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
class AssignedRFQController extends Controller
{
    //
    const STATUS_PENDING = 23;
    const STATUS_APPROVED = 25;
    const STATUS_REJECTED = 50;
    public function index(Request $request)
    {
        try {
            // $status_list = [
            //     self::STATUS_PENDING, 
            //     self::STATUS_REJECTED
            // ];

            $status_list = [
                3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,19,21,22,29,30,31,35,43,44,45,46,47
            ];

            $user = Auth::user();
            $query = RequestQuote::where('Buyer_id', $user->buyer->id)
                                ->whereIn('StatusList_id', $status_list)
                                ->orderBy('id', 'ASC');
    
            if ($request->has('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('RFQ', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }
        
            // Filtro por estatus seleccionado
            if ($request->has('state')) {
                $query->where('StatusList_id', $request->has('state'));
            }
        
            // Filtro por rango de fechas en la última fecha de actualización
            if ($request->has('startDate') && $request->has('endDate')) {
                $query->whereBetween('updated_at', [$request->has('startDate') . ' 00:00:00.000', $request->has('endDate') . ' 23:59:59.000']);
            } elseif ($request->has('startDate')) {
                $query->where('updated_at', '>=', $request->has('startDate') . ' 23:59:59.000');
            } elseif ($request->has('endDate')) {
                $query->where('updated_at', '<=', $request->has('endDate') . ' 23:59:59.000');
            }
            
            $requestQuotes = $query->get();

            $status = StatusList::where('status ',true)->get();

            return view('Purchasing.requestQuote.index',compact('requestQuotes','status'));
        } catch (\Exception $e) {
            Log::error('Error al obtener las cotizaciones: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al obtener las cotizaciones.');
            return null; // Retorna una colección vacía en caso de error
        }
    }
    

    public function pdf(RequestQuote $selectedRQ){
        
        $name = 'PurchaseOrder_' . $selectedRQ->RFQ . '.pdf';
        $pdf = PDF::loadView('Purchasing.requestQuote.pdf', ['selectedRQ' => $selectedRQ]);
        // return  $pdf->download($name);
        // return  $pdf->setPaper('A4','landscape')->stream($name);
        return $pdf->setPaper('letter', 'landscape')->stream($name);
        // return view('Purchasing.requestQuote.pdf',compact('selectedRQ'));
    }
}
