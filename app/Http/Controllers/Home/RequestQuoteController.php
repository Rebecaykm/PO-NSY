<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\RequestQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestQuoteController extends Controller
{
    //
    public function getRequestQuotes(Request $request)
    {
        try {
            $query = RequestQuote::where('User_id', Auth::id());

            if ($request->has('searchRQ')) {
                $query = $query->where('RFQ', 'like', '%' . $request->searchRQ . '%');
            }

            if ($request->has('selectedRQStatus') && $request->selectedRQStatus != 0) {
                $query = $query->where('StatusList_id', $request->selectedRQStatus);
            }

            if ($request->has('startDate') && $request->has('endDate')) {
                $query = $query->whereBetween('updated_at', [$request->startDate . ' 00:00:00', $request->endDate . ' 23:59:59']);
            } elseif ($request->has('startDate')) {
                $query = $query->where('updated_at', '>=', $request->startDate . ' 00:00:00');
            } elseif ($request->has('endDate')) {
                $query = $query->where('updated_at', '<=', $request->endDate . ' 23:59:59');
            }

            $requestQuotes = $query->orderBy($request->selectedRQOrderBy, $request->selectedRQOrder)
                                   ->paginate($request->perPage);

            return response()->json($requestQuotes);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener las cotizaciones de solicitud: ' . $e->getMessage()], 500);
        }
    }
}
