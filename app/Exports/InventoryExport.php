<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class InventoryExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $itemsDetails;

    public function __construct($itemsDetails)
    {
        $this->itemsDetails = $itemsDetails;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->itemsDetails->map(function ($itemDetail) {
            return [
                'CODE' => $itemDetail->item->Code,
                'SUMINISTRO' => $itemDetail->item->Model . '  ' . $itemDetail->item->Brand,
                'DESCRIPCIÓN' => $itemDetail->item->Description,
                'CATEGORIA' => $itemDetail->item->category->Name . ' - ' . $itemDetail->item->category->Description,
                'CLASIFICACIÓN' => $itemDetail->item->clasification->Name . ' - ' . $itemDetail->item->clasification->Description,
                'PRECIO' => $itemDetail->item->Price,
                'MONEDA' => $itemDetail->item->currency->Name,
                'MEDIDA' => $itemDetail->item->Measure,
                'UNIDAD DE MEDIDA' => $itemDetail->item->unitMeasure->Name,
                'CANTIDAD' => $itemDetail->Stock,
                'QTY MIN' => $itemDetail->QtyMin,
                'QTY MAX' => $itemDetail->QtyMax,
                'LEAD TIME' => $itemDetail->LeadTime,
                'PROVEEDOR' => $itemDetail->vendor->Name,
                'DEPARTAMENTO' => $itemDetail->warehouse->departament->Name,
                'ALMACEN' => $itemDetail->warehouse->Name,
                'RACK' => $itemDetail->rack->Name,

            ];
        });
    }

    public function headings(): array
    {
        return [
            'CODE',
            'SUMINISTRO',
            'DESCRIPCIÓN',
            'CATEGORIA',
            'CLASIFICACIÓN',
            'PRECIO',
            'MONEDA',
            'MEDIDA',
            'UNIDAD DE MEDIDA',
            'CANTIDAD',
            'QTY MIN',
            'QTY MAX',
            'LEAD TIME',
            'PROVEEDOR',
            'DEPARTAMENTO',
            'ALMACEN',
            'RACK',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('J2:J' . ($sheet->getHighestRow()))
            ->getFont()
            ->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            $cellValue = $sheet->getCell('J' . $row)->getValue(); // Assuming 'CANTIDAD' is in column 'L'

            // Apply red color if Stock <= QtyMin
            if ($cellValue <= $sheet->getCell('K' . $row)->getValue()) {
                $sheet->getStyle('J' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'FF1D1D'], // Red color
                    ],
                ]);
            }
            elseif ($cellValue > $sheet->getCell('K' . $row)->getValue() && $cellValue < $sheet->getCell('L' . $row)->getValue()) {
                // Apply green color if QtyMin < Stock < QtyMax
                $sheet->getStyle('J' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '92D050'], // Green color
                    ],
                ]);
            }
            elseif ($cellValue > $sheet->getCell('L' . $row)->getValue()) {
                // Apply yellow color if Stock > QtyMax
                $sheet->getStyle('J' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'FAFA26'], // Yellow color
                    ],
                ]);
            }
        }

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
