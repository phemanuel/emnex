<?php

namespace App\Exports\Reports\ProfitLoss;

use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithTitle;

class SummarySheet implements
    FromArray,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithTitle
{
    protected array $report;

    protected array $filters;

    public function __construct(
        array $report,
        array $filters
    ) {
        $this->report = $report;
        $this->filters = $filters;
    }

    /*
    |--------------------------------------------------------------------------
    | Sheet Title
    |--------------------------------------------------------------------------
    */

    public function title(): string
    {
        return 'Summary';
    }

    /*
    |--------------------------------------------------------------------------
    | Headings
    |--------------------------------------------------------------------------
    */

    public function headings(): array
    {
        return [
            'Metric',
            'Amount',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Rows
    |--------------------------------------------------------------------------
    */

    public function array(): array
    {
        $stats = $this->report['stats'] ?? [];

        return [
            [
                'Gross Revenue',
                $this->number(
                    $stats['gross_revenue']
                        ?? $stats['grossRevenue']
                        ?? 0
                ),
            ],
            [
                'Sales Returns',
                $this->number(
                    $stats['sales_returns']
                        ?? $stats['salesReturns']
                        ?? 0
                ),
            ],
            [
                'Net Revenue',
                $this->number(
                    $stats['net_revenue']
                        ?? $stats['netRevenue']
                        ?? 0
                ),
            ],
            [
                'Gross Cost of Goods Sold',
                $this->number(
                    $stats['gross_cogs']
                        ?? $stats['grossCogs']
                        ?? 0
                ),
            ],
            [
                'Returned Cost of Goods',
                $this->number(
                    $stats['returned_cogs']
                        ?? $stats['returnedCogs']
                        ?? 0
                ),
            ],
            [
                'Net Cost of Goods Sold',
                $this->number(
                    $stats['net_cogs']
                        ?? $stats['netCogs']
                        ?? 0
                ),
            ],
            [
                'Gross Profit',
                $this->number(
                    $stats['gross_profit']
                        ?? $stats['grossProfit']
                        ?? 0
                ),
            ],
            [
                'Operating Expenses',
                $this->number(
                    $stats['operating_expenses']
                        ?? $stats['operatingExpenses']
                        ?? 0
                ),
            ],
            [
                'Inventory Loss',
                $this->number(
                    $stats['inventory_loss']
                        ?? $stats['inventoryLoss']
                        ?? 0
                ),
            ],
            [
                'Operating Profit / Loss',
                $this->number(
                    $stats['operating_result']
                        ?? $stats['operatingResult']
                        ?? 0
                ),
            ],
            [
                'Profit Margin',
                $this->percentage(
                    $stats['profit_margin']
                        ?? $stats['profitMargin']
                        ?? 0
                ),
            ],
        ];
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

    protected function percentage($value): string
    {
        return number_format(
            (float) ($value ?? 0),
            2
        ) . '%';
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

                $sheet->insertNewRowBefore(1, 4);

                $sheet->mergeCells('A1:B1');

                $sheet->setCellValue(
                    'A1',
                    'EMNEX Profit & Loss Summary'
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
                | Period
                |--------------------------------------------------------------------------
                */

                $dateFrom = $this->filters['date_from']
                    ?? null;

                $dateTo = $this->filters['date_to']
                    ?? null;

                if ($dateFrom || $dateTo) {
                    $sheet->mergeCells('A2:B2');

                    $sheet->setCellValue(
                        'A2',
                        'Reporting Period: '
                        . ($dateFrom ?: '—')
                        . ' to '
                        . ($dateTo ?: '—')
                    );

                    $sheet->getStyle('A2')->applyFromArray([
                        'font' => [
                            'size' => 10,
                        ],
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Branch
                |--------------------------------------------------------------------------
                */

                $branchName =
                    $this->filters['branch_name']
                    ?? 'All Branches';

                $sheet->mergeCells('A3:B3');

                $sheet->setCellValue(
                    'A3',
                    'Branch: ' . $branchName
                );

                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'size' => 10,
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Generated
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A4:B4');

                $sheet->setCellValue(
                    'A4',
                    'Generated: '
                    . now()->format('d M Y H:i')
                );

                $sheet->getStyle('A4')->applyFromArray([
                    'font' => [
                        'size' => 9,
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A5:B5')->applyFromArray([
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

                $sheet->getStyle(
                    'B6:B' . $lastRow
                )->getNumberFormat()
                    ->setFormatCode(
                        '#,##0.00'
                    );

                /*
                |--------------------------------------------------------------------------
                | Profit Margin
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'B16'
                )->getNumberFormat()
                    ->setFormatCode(
                        '0.00%'
                    );

                /*
                |--------------------------------------------------------------------------
                | Alignment
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'B6:B' . $lastRow
                )->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    );

                /*
                |--------------------------------------------------------------------------
                | Borders
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'A5:B' . $lastRow
                )->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' =>
                                Border::BORDER_HAIR,
                        ],
                    ],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Emphasise Key Results
                |--------------------------------------------------------------------------
                */

                $keyRows = [
                    8,  // Net Revenue
                    11, // Net COGS
                    12, // Gross Profit
                    15, // Operating Profit / Loss
                ];

                foreach ($keyRows as $row) {
                    $sheet->getStyle(
                        'A' . $row . ':B' . $row
                    )->getFont()->setBold(true);
                }

                /*
                |--------------------------------------------------------------------------
                | Freeze
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A6');
            },
        ];
    }
}

