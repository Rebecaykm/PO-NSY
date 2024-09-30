<?php

namespace App\Exports;

use App\Models\RequestQuote;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $RequestQuote;
    public function __construct(RequestQuote $RequestQuote) {
        $this->RequestQuote = $RequestQuote;
    }
    public function collection()
    {
        //
        return $this->RequestQuote->map(function ($RFQ) {
            return [
                '' => "",
                'SUMINISTRO' => "",
                'DESCRIPCIÓN' => "",
                'CANTIDAD' => "",
                'QTY ANTERIOR' => "",
                'QTY DESPUÉS' =>  "",
                'QTY MIN' =>   "",
                'QTY MAX' =>   "",
                'OPERACIÓN' => "",
                'FECHA' => "",
                'HORA' => "",
                'DEPARTAMENTO' => "",
                'ALMACÉN' => "",
                'RACK' => "",
                'SOLICITUD' => "",
                'LINEA SOLI.' => "",
                'PROPIETARIO SOLI.' => "",
                'NOMINA SOLI.' => "",
                'COMENTARIOS' => "",
            ];
        });
    }
    public function headings(): array
    {
        return [
            'CODE',
            'SUMINISTRO',
            'DESCRIPCIÓN',
            'CANTIDAD',
            'QTY ANTERIOR',
            'QTY DESPUÉS',
            'QTY MIN',
            'QTY MAX',
            'OPERACIÓN',
            'FECHA',
            'HORA',
            'DEPARTAMENTO',
            'ALMACÉN',
            'RACK',
            'SOLICITUD',
            'LINEA SOLI.',
            'PROPIETARIO SOLI.',
            'NOMINA SOLI.',
            'COMENTARIOS'
        ];
    }
}
