<?php

namespace App\Exports\Reports\Inventory;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ValuationSheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected array $report;

    public function __construct(
        array $report
    ) {
        $this->report = $report;
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Title
     * |--------------------------------------------------------------------------
     */
    public function title(): string
    {
        return 'Valuation';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $valuation = $this->report['valuation']
            ?? [];

        $costValue = $this->number(
            $valuation['cost_value'] ?? 0
        );

        $retailValue = $this->number(
            $valuation['retail_value'] ?? 0
        );

        $potentialProfit = $this->number(
            $valuation['potential_profit'] ?? 0
        );

        $rows = [
            ['INVENTORY VALUATION'],
            [''],
            ['Metric', 'Value'],
            [
                'Cost Value',
                $costValue,
            ],
            [
                'Retail Value',
                $retailValue,
            ],
            [
                'Potential Profit',
                $potentialProfit,
            ],
            [''],
            ['VALUATION BY BRANCH'],
            [
                'Branch',
                'Units',
                'Stock Value',
                'Retail Value',
                'Potential Profit',
            ],
        ];

        foreach (
            ($valuation['branches'] ?? [])
            as $branch
        ) {
            $rows[] = [
                $branch['branch_name']
                    ?? '—',

                $this->number(
                    $branch['units'] ?? 0
                ),

                $this->number(
                    $branch['stock_value'] ?? 0
                ),

                $this->number(
                    $branch['retail_value'] ?? 0
                ),

                $this->number(
                    $branch['potential_profit'] ?? 0
                ),
            ];
        }

        return $rows;
    }

    /**
     * |--------------------------------------------------------------------------
     * | Styles
     * |--------------------------------------------------------------------------
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 18,
                ],
                'alignment' => [
                    'horizontal' =>
                        Alignment::HORIZONTAL_LEFT,
                ],
            ],

            3 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            8 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            9 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    /**
     * |--------------------------------------------------------------------------
     * | Events
     * |--------------------------------------------------------------------------
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (
                AfterSheet $event
            ) {
                $sheet = $event->sheet
                    ->getDelegate();

                $highestRow =
                    $sheet->getHighestRow();

                /*
                 * Report title.
                 */
                $sheet->mergeCells('A1:E1');

                $sheet->getStyle(
                    'A1:E1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:E1'
                )->getAlignment()->setVertical(
                    Alignment::VERTICAL_CENTER
                );

                $sheet->getRowDimension(1)
                    ->setRowHeight(28);

                /*
                 * Section headers.
                 */
                $this->styleSection(
                    $sheet,
                    'A8:E8'
                );

                $this->styleHeader(
                    $sheet,
                    'A3:B3'
                );

                $this->styleHeader(
                    $sheet,
                    'A9:E9'
                );

                /*
                 * Number formatting.
                 */
                $sheet->getStyle(
                    'B4:B6'
                )->getNumberFormat()
                    ->setFormatCode(
                        '#,##0.00'
                    );

                if ($highestRow >= 10) {
                    $sheet->getStyle(
                        'B10:E' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );
                }

                /*
                 * Branch table.
                 */
                $sheet->setAutoFilter(
                    'A9:E' . max(
                        9,
                        $highestRow
                    )
                );

                $sheet->freezePane('A10');
            },
        ];
    }

    /**
     * |--------------------------------------------------------------------------
     * | Helpers
     * |--------------------------------------------------------------------------
     */
    protected function number($value): float
    {
        return round(
            (float) $value,
            2
        );
    }

    protected function styleSection(
        Worksheet $sheet,
        string $range
    ): void {
        $sheet->getStyle($range)
            ->getFont()
            ->setBold(true);

        $sheet->getStyle($range)
            ->getFill()
            ->setFillType(
                Fill::FILL_SOLID
            );

        $sheet->getStyle($range)
            ->getAlignment()
            ->setVertical(
                Alignment::VERTICAL_CENTER
            );
    }

    protected function styleHeader(
        Worksheet $sheet,
        string $range
    ): void {
        $sheet->getStyle($range)
            ->getFont()
            ->setBold(true);

        $sheet->getStyle($range)
            ->getAlignment()
            ->setHorizontal(
                Alignment::HORIZONTAL_LEFT
            );
    }
}

