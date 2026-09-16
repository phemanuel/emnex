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

class FinancialPositionSheet implements
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
        return 'Financial Position';
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

        $grossRevenue = $this->number(
            $stats['gross_revenue']
                ?? $stats['grossRevenue']
                ?? 0
        );

        $salesReturns = $this->number(
            $stats['sales_returns']
                ?? $stats['salesReturns']
                ?? 0
        );

        $netRevenue = $this->number(
            $stats['net_revenue']
                ?? $stats['netRevenue']
                ?? ($grossRevenue - $salesReturns)
        );

        $grossCogs = $this->number(
            $stats['gross_cogs']
                ?? $stats['grossCogs']
                ?? 0
        );

        $returnedCogs = $this->number(
            $stats['returned_cogs']
                ?? $stats['returnedCogs']
                ?? 0
        );

        $netCogs = $this->number(
            $stats['net_cogs']
                ?? $stats['netCogs']
                ?? ($grossCogs - $returnedCogs)
        );

        $grossProfit = $this->number(
            $stats['gross_profit']
                ?? $stats['grossProfit']
                ?? ($netRevenue - $netCogs)
        );

        $damageLoss = $this->number(
            $stats['damage_loss']
                ?? $stats['damageLoss']
                ?? 0
        );

        $expiredLoss = $this->number(
            $stats['expired_loss']
                ?? $stats['expiredLoss']
                ?? 0
        );

        $inventoryLoss = $this->number(
            $stats['inventory_loss']
                ?? $stats['inventoryLoss']
                ?? ($damageLoss + $expiredLoss)
        );

        $operatingResult = $this->number(
            $stats['operating_result']
                ?? $stats['operatingResult']
                ?? ($grossProfit - $inventoryLoss)
        );

        return [
            [
                'Gross Revenue',
                $grossRevenue,
            ],
            [
                'Sales Returns',
                $salesReturns,
            ],
            [
                'Net Revenue',
                $netRevenue,
            ],
            [
                'Gross Cost of Goods Sold',
                $grossCogs,
            ],
            [
                'Returned Cost of Goods',
                $returnedCogs,
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
                'Damage Loss',
                $damageLoss,
            ],
            [
                'Expired Loss',
                $expiredLoss,
            ],
            [
                'Total Inventory Loss',
                $inventoryLoss,
            ],
            [
                'Operating Result',
                $operatingResult,
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
                    'EMNEX Financial Position Summary'
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
                    'Financial performance position derived from revenue, cost of goods and inventory losses.'
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

                    $sheet->getStyle(
                        'B4:B' . $lastRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'B4:B' . $lastRow
                    )->getAlignment()
                        ->setHorizontal(
                            Alignment::HORIZONTAL_RIGHT
                        );

                    $sheet->getStyle(
                        'A3:B' . $lastRow
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
                | Emphasise Key Financial Totals
                |--------------------------------------------------------------------------
                |
                | After the two inserted rows:
                |
                | Row 6  = Net Revenue
                | Row 10 = Gross Profit
                | Row 13 = Total Inventory Loss
                | Row 14 = Operating Result
                |
                */

                $keyRows = [
                    6,
                    10,
                    13,
                    14,
                ];

                foreach ($keyRows as $row) {

                    $sheet->getStyle(
                        'A' . $row . ':B' . $row
                    )->getFont()
                        ->setBold(true);
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

