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

class LowStockSheet implements
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
        return 'Low Stock';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $lowStock = $this->report['low_stock']
            ?? [];

        $rows = [
            [
                'Product',
                'Product Code',
                'SKU',
                'Category',
                'Branch',
                'Quantity',
                'Available',
                'Reorder Level',
                'Maximum Stock',
                'Shortage',
                'Status',
            ],
        ];

        foreach ($lowStock as $product) {
            $rows[] = [
                $product['name']
                    ?? '—',

                $product['product_code']
                    ?? '—',

                $product['sku']
                    ?? '—',

                $product['category']
                    ?? '—',

                $product['branch_name']
                    ?? '—',

                $this->number(
                    $product['quantity']
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
                    $product['maximum_stock']
                        ?? 0
                ),

                $this->number(
                    $product['shortage']
                        ?? 0
                ),

                $this->statusLabel(
                    $product['status']
                        ?? null
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
                    'A1:K1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:K1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:K1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'F2:J' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:K' . max(
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

    protected function statusLabel(
        ?string $status
    ): string {
        return match ($status) {
            'out_of_stock' => 'Out of Stock',
            'low_stock' => 'Low Stock',
            default => '—',
        };
    }
}

