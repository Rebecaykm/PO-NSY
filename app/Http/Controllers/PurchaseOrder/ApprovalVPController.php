<?php

namespace App\Http\Controllers\PurchaseOrder;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteFile;
use App\Models\QuoteHistory;
use App\Models\QuoteLine;
use App\Models\RequestQuote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalVPController extends Controller
{
    // Define constants for status IDs
    const STATUS_PENDING = 23;
    const STATUS_APPROVED = 25;
    const STATUS_REJECTED = 50;

    public function index(Request $request)
    {
        // Define el query base para los estados pendiente y rechazado
        $query = RequestQuote::whereIn('StatusList_id', [self::STATUS_PENDING, self::STATUS_REJECTED]);

        // Contar las órdenes pendientes
        // $PO_Pendientes = RequestQuote::whereIn('StatusList_id', [self::STATUS_PENDING])->count();

        // Verificar si hay un filtro de búsqueda
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('RFQ', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('UserName', 'like', '%' . $request->search . '%');
            });
        }

        // Obtener los resultados con las relaciones
        $requestQuotes = $query->with(['costCenter.department','buyer','user.department'])->get();
    
        // Devolver los resultados en JSON si es una solicitud AJAX
        if ($request->ajax()) {
            return response()->json($requestQuotes);
        }

        // Devolver la vista con las variables
        return view('PurchaseOrder.ApprovalVP.index', compact('requestQuotes'));
    }



    public function show(RequestQuote $requestQuote)
    {
        $requestQuote = RequestQuote::where('id',$requestQuote->id)->with(['costCenter.department','commodity'])->first();
        $quoteLines = QuoteLine::where('QuoteRequest_id', $requestQuote->id)
                                ->with(['costCenter.department', 'supplier','currency'])
                                ->get();
        
        $quoteFiles = QuoteFile::where('QuoteRequest_id', $requestQuote->id)->with('supplier')->get();
        $quotes = Quote::where('QuoteRequest_id', $requestQuote->id)->with('supplier')->with('currency')->get();

        return response()->json([
            'requestQuote' => $requestQuote,
            'quoteLines' => $quoteLines,
            'quoteFiles' => $quoteFiles,
            'quotes' => $quotes
        ]);
    }

    // public function select(Request $request, $id)
    // {
    //     $requestQuote = RequestQuote::findOrFail($id);
    //     return response()->json([
    //         'requestQuote' => $requestQuote,
    //     ]);
    // }

    public function handleApproval(Request $request, $id, $action)
    {
        $requestQuote = RequestQuote::findOrFail($id);
        $status = $action === 'approve' ? self::STATUS_APPROVED : self::STATUS_REJECTED;
        $remark = ucfirst($action) . ' por ' . Auth::user()->name;

        $this->updateRequestQuote($requestQuote, $status, $remark);
        return response()->json(['message' => ucfirst($action) . ' exitosa']);
    }

    private function updateRequestQuote(RequestQuote $requestQuote, $status, $remark)
    {
        $user = Auth::user();
        $requestQuote->update([
            'ApprovateVPresident' => $status === self::STATUS_APPROVED ? 1 : 0,
            'ApprovateVPresidentName' => $user->name,
            'Vicepresidente_id' => $user->id,
            'ApprovateVPresidentDate' => Carbon::today(),
            'StatusList_id' => $status
        ]);
        $approve = 1;

        QuoteHistory::create([
            'QuoteRequest_id' => $requestQuote->id,
            'StatusList_id' => $status,
            'remark' => $remark,
        ]);
    }

    public function update(Request $request, RequestQuote $requestQuote)
    {
        $requestQuote->update($request->all());
        return response()->json($requestQuote);
    }
}

