<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

// class PurchaseOrderExport implements FromCollection
class PurchaseOrderExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $RQLines;
    private $selectedRQ;

    public function __construct($selectedRQ,$RQLines)
    {
        $this->RQLines = $RQLines;
        $this->selectedRQ = $selectedRQ;
    }

    public function view(): View
    {

        return view('Purchasing.requestQuote.pdf', [
            'selectedRQ' => $this->selectedRQ,
        ]);
    }

    // public function collection()
    // {
    //     return $this->RQLines->map(function ($RQL) {
    //         return [
    //             'RFQ' => $RQL->quoteRequest->RFQ,
    //             'NAME' => $RQL->name,
    //             'DESCRIPCIÓN' => $RQL->description,
    //             'LINE' => $RQL->numLine,
    //             'CANTIDAD' => $RQL->quantity,
    //             'PRECIO UNITARIO' => '$' . $RQL->UnitCost,
    //             'TOTAL' => 'Adios',
    //         ];
    //     });
    // }
    // public function headings(): array
    // {
    //     return [
    //         'RFQ',
    //         'NAME',
    //         'DESCRIPCIÓN',
    //         'LINE',
    //         'CANTIDAD',
    //         'PRECIO' ,
    //         'TOTAL',
    //     ];
    // }

}
