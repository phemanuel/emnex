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

class RevenueSheet implements
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
        return 'Revenue';
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
            'Gross Revenue',
            'Sales Returns',
            'Net Revenue',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Rows
    |--------------------------------------------------------------------------
    */

    public function array(): array
    {
        $rows = $this->report['charts']['revenue']
            ?? $this->report['revenue']
            ?? [];

        return collect($rows)
            ->map(function ($row) {

                return [
                    $row['label']
                        ?? $row['date']
                        ?? $row['period']
                        ?? '—',

                    $this->number(
                        $row['gross_revenue']
                            ?? $row['grossRevenue']
                            ?? 0
                    ),

                    $this->number(
                        $row['sales_returns']
                            ?? $row['salesReturns']
                            ?? 0
                    ),

                    $this->number(
                        $row['net_revenue']
                            ?? $row['netRevenue']
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
                    'EMNEX Revenue Report'
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
                    'Gross revenue, sales returns and net revenue for the selected period.'
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

