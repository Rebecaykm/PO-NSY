<?php

namespace App\Exports;

use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    private $operations;

    public function __construct($operations)
    {
        $this->operations = $operations;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Modifica esta parte según tus necesidades
        return $this->operations->map(function ($operation) {
            return [
                'CODE' => $operation->Code,
                'SUMINISTRO' => $operation->itemDetail->item->Brand . ' - ' . $operation->itemDetail->item->Model,
                'DESCRIPCIÓN' => $operation->itemDetail->item->Description,
                'CANTIDAD' => $operation->Quantity,
                'QTY ANTERIOR' => $operation->QtyBefore,
                'QTY DESPUES' => $operation->QtyAfter,
                'QTY MIN' => $operation->itemDetail->QtyMin,
                'QTY MAX' => $operation->itemDetail->QtyMax,
                'OPERACIÓN' => $operation->typeOperation->Name,
                'FECHA' => $operation->created_at->format('Y-m-d'),
                'HORA' => $operation->created_at->format('H:i:s'),
                'DEPARTAMENTO' => $operation->Warehouse->departament->Name,
                'ALMACEN' => $operation->Warehouse->Name,
                'RACK' => $operation->Rack->Name,
                'SOLICITUD' => $operation->requested ? $operation->requested->Folio : "",
                'LINEA SOLI.' => $operation->lineRequested ? $operation->lineRequested->Code : "",
                'PROPIERARIO SOLI.' => $operation->Request_id ? $operation->requested->UserName : '',
                'NOMINA SOLI.' => $operation->Request_id ? $operation->requested->Nomina : '',
                'COMENTARIOS' => $operation->Remarks,
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
            'QTY DESPUES',
            'QTY MIN',
            'QTY MAX',
            'OPERACIÓN',
            'FECHA',
            'HORA',
            'DEPARTAMENTO',
            'ALMACEN',
            'RACK',
            'SOLICITUD',
            'LINEA SOLI.',
            'PROPIERARIO SOLI.',
            'NOMINA SOLI.',
            'COMENTARIOS'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Establecer el color de texto negro para las celdas en columnas 'QTY ANTERIOR' y 'QTY DESPUES'
        $this->setBlackTextColor($sheet, 'E');
        $this->setBlackTextColor($sheet, 'F');

        // Aplicar estilos condicionales a las celdas en columnas 'QTY ANTERIOR' y 'QTY DESPUES'
        $this->applyConditionalStyles($sheet, 'E','G','H');
        $this->applyConditionalStyles($sheet, 'F','G','H');

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function setBlackTextColor(Worksheet $sheet, $column)
    {
        $sheet->getStyle($column . '2:' . $column . ($sheet->getHighestRow()))
            ->getFont()
            ->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
    }

    private function applyConditionalStyles(Worksheet $sheet, $column, $qtyMinColumn, $qtyMaxColumn)
    {
        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            $qtyCellValue = $sheet->getCell($column . $row)->getValue();
            $qtyMinValue = $sheet->getCell($qtyMinColumn . $row)->getValue();
            $qtyMaxValue = $sheet->getCell($qtyMaxColumn . $row)->getValue();
        // Si Stock <= QtyMin, aplicar color rojo
        if ($qtyCellValue <= $qtyMinValue) {
            $this->applyStyle($sheet, $column, $row, 'FF1D1D'); // Rojo
        }
        // Si QtyMin < Stock < QtyMax, aplicar color verde
        elseif ($qtyCellValue > $qtyMinValue && $qtyCellValue < $qtyMaxValue) {
            $this->applyStyle($sheet, $column, $row, '92D050'); // Verde
        }
        // Si Stock > QtyMax, aplicar color amarillo
        elseif ($qtyCellValue > $qtyMaxValue) {
            $this->applyStyle($sheet, $column, $row, 'FAFA26'); // Amarillo
        }
        // Puedes agregar más condiciones según sea necesario
        }
    }

    private function applyStyle(Worksheet $sheet, $column, $row, $color)
    {
        $sheet->getStyle($column . $row)->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => $color],
            ],
        ]);
    }
}
