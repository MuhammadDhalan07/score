<?php

namespace App\Exports;

use App\Models\Grade\Athlete;
use App\Models\Grade\Value;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rank implements FromCollection, WithColumnWidths, WithStyles
{
    use Exportable;

    private Collection $collection;
    private int $rowCount;

    public function __construct()
    {
        $this->collection = collect();
        $this->rowCount = 0;
    }

    public function setUp(Collection $values): self
    {
        $this->collection->push([
            [],
            [null, 'LAPORAN SMARTER'],
            [], [], [],
            ['No', 'Nama', 'Cabang Olahraga', 'Rank'],
            [],
        ]);

        $groupedValues = $values->groupBy('person_id')->map(function ($group) {
            return [
                'athlete' => $group->first()->person,
                'total_rank' => $group->sum('rank')
            ];
        });

        $sortedValues = $groupedValues->sortByDesc('total_rank');

        $no = 1;
        foreach ($sortedValues as $data) {
            $athlete = $data['athlete'];
            $totalRank = $data['total_rank'];
            // Hapus atau komentari dump yang ada
            // dd($athlete);

            $this->collection->push([
                $no++,
                $athlete->athlete_name,
                $athlete->cabor,
                $totalRank,
            ]);
        }

        $this->rowCount = $this->collection->count();

        return $this;
    }

    public function columnWidths(): array
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
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]
            ],
            'A6:D6' => [
                'font' => [
                    'bold' => true,
                    'size' => 12
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ]
                ]
            ],
            'A7:D' . ($this->rowCount + 6) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ]
                ],
            ],
            'A7:A' . ($this->rowCount + 6) => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                ]
            ],
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
