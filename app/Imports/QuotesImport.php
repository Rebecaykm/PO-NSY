<?php

namespace App\Imports;

use App\Models\Currency;
use App\Models\Quote;
use App\Models\RequestQuote;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;

class QuotesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Buscar el ID del proveedor por el nombre del proveedor
        $supplier = Supplier::where('VENDOR', $row['vendor'])->first();
        $currency = Currency::where('name', $row['vendor'])->first();
        $currency = RequestQuote::where('RFQ', $row['RFQ'])->first();

        return new Quote([
            //
            'Cost' => $row['cost'],
            'description' => $row['description'],
            'QuoteRequest_id' => $row['QuoteRequest_id'],
            'QuoteLine_id' => $row['QuoteLine_id'],
            'Supplier_id' => $supplier ? $supplier->id : null,
            'Currency_id' => $currency ? $currency->id : null,
            'NumDaysArrival' => $row['NumDaysArrival'],
        ]);
    }
}
