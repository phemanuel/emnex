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

class CategoriesSheet implements
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
        return 'Categories';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $categories = $this->report['categories']
            ?? [];

        $rows = [
            [
                'Category',
                'Products',
                'Units Sold',
                'Orders',
                'Gross Sales',
                'Discount',
                'Net Sales',
                '% of Sales',
            ],
        ];

        foreach ($categories as $category) {
            $rows[] = [
                $category['category']
                    ?? $category['name']
                    ?? $category['category_name']
                    ?? '—',

                (int) (
                    $category['products']
                        ?? 0
                ),

                (float) (
                    $category['units_sold']
                        ?? $category['quantity']
                        ?? 0
                ),

                (int) (
                    $category['orders']
                        ?? $category['transactions']
                        ?? 0
                ),

                $this->number(
                    $category['gross_sales']
                        ?? 0
                ),

                $this->number(
                    $category['discount']
                        ?? 0
                ),

                $this->number(
                    $category['net_sales']
                        ?? 0
                ),

                $this->percentage(
                    $category['percentage']
                        ?? $category['percent']
                        ?? $category['share']
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
                    'A1:H1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:H1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:H1'
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
                        'D2:D' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0'
                        );

                    $sheet->getStyle(
                        'E2:G' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'H2:H' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '0.00%'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:H' . max(
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

    protected function percentage($value): float
    {
        $percentage = (float) $value;

        /*
         * The Sales Report may expose the share
         * as either:
         *
         * 0.25  -> 25%
         * 25    -> 25%
         *
         * Normalize both representations for
         * Excel percentage formatting.
         */
        if ($percentage > 1) {
            return round(
                $percentage / 100,
                4
            );
        }

        return round(
            $percentage,
            4
        );
    }
}