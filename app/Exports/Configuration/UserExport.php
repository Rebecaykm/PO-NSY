<?php

namespace App\Exports\Configuration;

use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $dataset;

    public function __construct($dataset)
    {
        $this->dataset = $dataset;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    { //
        return $this->dataset->map(function ($row) {
            return [
                'name' => $row->name,
                'email' => $row->email,
                'phone' => $row->phpne,
            ];
        });
    }
    public function headings(): array
    {
        return [
            'name',
            'email',
            'phone',
        ];
    }
}
