<?php

namespace App\Exports;

use Barryvdh\DomPDF\PDF;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

// class PurchaseOrderExport implements FromCollection
class PurchaseOrderExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $PO;

    public function __construct($PO)
    {
        $this->PO = $PO;
    }

    public function view(): View
    {
        return view('pdf', [
            'PO' => $this->PO,
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
