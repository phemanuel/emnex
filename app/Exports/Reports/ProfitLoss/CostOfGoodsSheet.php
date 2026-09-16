<?php

namespace App\Exports\Reports\ProfitLoss;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;

class CostOfGoodsSheet implements
    FromArray,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithTitle
{
    protected array $report;

    public function __construct(array $report)
    {
        $this->report = $report;
    }

    /*
    |--------------------------------------------------------------------------
    | Sheet Title
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Cost of Goods';
    }

    /*
    |--------------------------------------------------------------------------
    | Headings
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'Period',
            'Gross COGS',
            'Returned COGS',
            'Net COGS',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Rows
    |--------------------------------------------------------------------------
    */

    public function array(): array
    {
        $rows = $this->report['charts']['costs']
            ?? $this->report['charts']['cogs']
            ?? $this->report['cost_of_goods']
            ?? $this->report['costs']
            ?? [];

        return collect($rows)
            ->map(function ($row) {

                return [
                    $row['label']
                        ?? $row['date']
                        ?? $row['period']
                        ?? '—',

                    $this->number(
                        $row['gross_cogs']
                            ?? $row['grossCogs']
                            ?? 0
                    ),

                    $this->number(
                        $row['returned_cogs']
                            ?? $row['returnedCogs']
                            ?? 0
                    ),

                    $this->number(
                        $row['net_cogs']
                            ?? $row['netCogs']
                            ?? 0
                    ),
                ];
            })
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    protected function number($value): float
    {
        return round(
            (float) ($value ?? 0),
            2
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                |--------------------------------------------------------------------------
                | Title
                |--------------------------------------------------------------------------
                */

                $sheet->insertNewRowBefore(1, 2);

                $sheet->mergeCells('A1:D1');

                $sheet->setCellValue(
                    'A1',
                    'EMNEX Cost of Goods Report'
                );

                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' =>
                            Alignment::HORIZONTAL_LEFT,
                        'vertical' =>
                            Alignment::VERTICAL_CENTER,
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Description
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A2:D2');

                $sheet->setCellValue(
                    'A2',
                    'Gross cost of goods sold, returned COGS and net COGS for the selected period.'
                );

                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'size' => 10,
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A3:D3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' =>
                            Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E9ECEF',
                        ],
                    ],
                    'borders' => [
                        'bottom' => [
                            'borderStyle' =>
                                Border::BORDER_THIN,
                        ],
                    ],
                    'alignment' => [
                        'vertical' =>
                            Alignment::VERTICAL_CENTER,
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Amount Formatting
                |--------------------------------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();

                if ($lastRow >= 4) {

                    $sheet->getStyle(
                        'B4:D' . $lastRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'B4:D' . $lastRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_RIGHT
                        );

                    $sheet->getStyle(
                        'A3:D' . $lastRow
                    )->applyFromArray([
                        'borders' => [
                            'bottom' => [
                                'borderStyle' =>
                                    Border::BORDER_HAIR,
                            ],
                        ],
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Freeze Header
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A4');
            },
        ];
    }
}

