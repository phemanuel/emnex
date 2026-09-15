<?php

namespace App\Exports\Reports\Sales;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsSheet implements
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
        return 'Products';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $products = $this->report['products']
            ?? [];

        $rows = [
            [
                'Product',
                'Category',
                'Units Sold',
                'Revenue',
                'COGS',
                'Gross Profit',
                'Margin',
            ],
        ];

        foreach ($products as $product) {
            $rows[] = [
                $product['product']
                    ?? $product['name']
                    ?? $product['product_name']
                    ?? '—',

                $product['category']
                    ?? $product['category_name']
                    ?? '—',

                (float) (
                    $product['units_sold']
                        ?? $product['quantity']
                        ?? 0
                ),

                $this->number(
                    $product['revenue']
                        ?? 0
                ),

                $this->number(
                    $product['cogs']
                        ?? 0
                ),

                $this->number(
                    $product['gross_profit']
                        ?? 0
                ),

                $this->margin(
                    $product['margin']
                        ?? 0
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
                ],
                'alignment' => [
                    'horizontal' =>
                        Alignment::HORIZONTAL_LEFT,
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

                $sheet->getStyle(
                    'A1:G1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:G1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:G1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'C2:C' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'D2:F' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'G2:G' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '0.00%'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:G' . max(
                        1,
                        $highestRow
                    )
                );
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

    protected function margin($value): float
    {
        $margin = (float) $value;

        /*
         * The report may already return margin
         * as a percentage (for example 25.50)
         * rather than a decimal (0.255).
         *
         * Keep the existing report value and
         * convert only when it is clearly a
         * percentage value.
         */
        if ($margin > 1) {
            return round(
                $margin / 100,
                4
            );
        }

        return round(
            $margin,
            4
        );
    }
}