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

class BreakdownSheet implements
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
        return 'Breakdown';
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

        $netRevenue = $this->number(
            $stats['net_revenue']
                ?? $stats['netRevenue']
                ?? 0
        );

        $netCogs = $this->number(
            $stats['net_cogs']
                ?? $stats['netCogs']
                ?? 0
        );

        $grossProfit = $this->number(
            $stats['gross_profit']
                ?? $stats['grossProfit']
                ?? ($netRevenue - $netCogs)
        );

        $inventoryLoss = $this->number(
            $stats['inventory_loss']
                ?? $stats['inventoryLoss']
                ?? 0
        );

        $operatingResult = $this->number(
            $stats['operating_result']
                ?? $stats['operatingResult']
                ?? ($grossProfit - $inventoryLoss)
        );

        $operatingMargin = $this->number(
            $stats['operating_margin']
                ?? $stats['operatingMargin']
                ?? $this->calculateMargin(
                    $operatingResult,
                    $netRevenue
                )
        );

        return [
            [
                'Net Revenue',
                $netRevenue,
            ],
            [
                'Net Cost of Goods Sold',
                $netCogs,
            ],
            [
                'Gross Profit',
                $grossProfit,
            ],
            [
                'Inventory Losses',
                $inventoryLoss,
            ],
            [
                'Operating Result',
                $operatingResult,
            ],
            [
                'Operating Margin',
                $operatingMargin,
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

    protected function calculateMargin(
        float $amount,
        float $revenue
    ): float {
        if ($revenue == 0.0) {
            return 0.0;
        }

        return round(
            ($amount / $revenue) * 100,
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

                $sheet->mergeCells('A1:B1');

                $sheet->setCellValue(
                    'A1',
                    'EMNEX Financial Breakdown'
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

                $sheet->mergeCells('A2:B2');

                $sheet->setCellValue(
                    'A2',
                    'Summary of the major financial components used to determine the operating result.'
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

                $sheet->getStyle('A3:B3')->applyFromArray([
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

                    /*
                    | Amount rows
                    */

                    $sheet->getStyle(
                        'B4:B8'
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    /*
                    | Margin
                    */

                    $sheet->getStyle(
                        'B9'
                    )->getNumberFormat()
                        ->setFormatCode(
                            '0.00"%"'
                        );

                    /*
                    | Right Alignment
                    */

                    $sheet->getStyle(
                        'B4:B9'
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_RIGHT
                        );

                    /*
                    | Borders
                    */

                    $sheet->getStyle(
                        'A3:B9'
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
                | Emphasise Result
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A8:B8')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A9:B9')
                    ->getFont()
                    ->setBold(true);

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

