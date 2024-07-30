<?php

namespace App\Exports;

use App\Models\Grade\Athlete;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rank implements FromCollection, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public $collection = [];

    public ?Collection $record = null;

    public Collection $value;

    private Athlete $athlete;

    public function setUp(Athlete $athlete):self
    {
        $this->athlete = $athlete;

        $this->record->push([
            [],
            [null, 'LAPORAN SMARTER'],
            [],[],[],
            // ['Tanggal',':', date('d-m-Y')],
            ['No', 'Nama', 'Cabang Olahraga', 'Rank'],
            [],
            [],
        ]);
        return $this;
    }

    public function columnWidths():array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 25,
            'D' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B2:F3');

        return [
            'B2:F3' => [
                'font' => [
                    'bold' => true,
                    'size' => 16
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ]
        ];
    }


    public function collection()
    {
        return $this->record;
        // dd($this->record);

    }

    public function __construct()
    {
        $this->record = new Collection([]);
    }
}
