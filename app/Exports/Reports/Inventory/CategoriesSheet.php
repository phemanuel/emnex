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
                'Units',
                'Stock Value',
                'Retail Value',
                'Stock In',
                'Stock Out',
                'Net Movement',
            ],
        ];

        foreach ($categories as $category) {
            $rows[] = [
                $category['name']
                    ?? 'Uncategorized',

                (int) (
                    $category['products']
                        ?? 0
                ),

                $this->number(
                    $category['units']
                        ?? 0
                ),

                $this->number(
                    $category['stock_value']
                        ?? 0
                ),

                $this->number(
                    $category['retail_value']
                        ?? 0
                ),

                $this->number(
                    $category['stock_in']
                        ?? 0
                ),

                $this->number(
                    $category['stock_out']
                        ?? 0
                ),

                $this->number(
                    $category['net_movement']
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
                        'C2:H' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
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
}

