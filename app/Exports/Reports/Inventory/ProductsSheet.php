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
                'Product Code',
                'SKU',
                'Category',
                'Branch',
                'Quantity',
                'Reserved',
                'Available',
                'Reorder Level',
                'Stock Value',
                'Retail Value',
                'Stock In',
                'Stock Out',
                'Net Movement',
                'Adjustments',
                'Transfers',
                'Status',
            ],
        ];

        foreach ($products as $product) {
            $rows[] = [
                $product['name']
                    ?? $product['product']
                    ?? $product['product_name']
                    ?? '—',

                $product['product_code']
                    ?? '—',

                $product['sku']
                    ?? '—',

                $product['category']
                    ?? $product['category_name']
                    ?? '—',

                $product['branch_name']
                    ?? '—',

                $this->number(
                    $product['quantity']
                        ?? 0
                ),

                $this->number(
                    $product['reserved_quantity']
                        ?? 0
                ),

                $this->number(
                    $product['available_quantity']
                        ?? 0
                ),

                $this->number(
                    $product['reorder_level']
                        ?? 0
                ),

                $this->number(
                    $product['stock_value']
                        ?? 0
                ),

                $this->number(
                    $product['retail_value']
                        ?? 0
                ),

                $this->number(
                    $product['stock_in']
                        ?? 0
                ),

                $this->number(
                    $product['stock_out']
                        ?? 0
                ),

                $this->number(
                    $product['net_movement']
                        ?? 0
                ),

                $this->number(
                    $product['adjustments']
                        ?? 0
                ),

                $this->number(
                    $product['transfers']
                        ?? 0
                ),

                $product['stock_status']
                    ?? '—',
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
                    'A1:Q1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:Q1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:Q1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'F2:I' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'J2:K' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'L2:P' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:Q' . max(
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
}

