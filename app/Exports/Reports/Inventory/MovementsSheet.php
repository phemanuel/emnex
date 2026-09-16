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

class MovementsSheet implements
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
        return 'Movements';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $movements = $this->report['movement_export_rows']
            ?? [];

        $rows = [
            [
                'Reference',
                'Date',
                'Time',
                'Movement',
                'Direction',
                'Product',
                'Product Code',
                'SKU',
                'Category',
                'Branch',
                'Quantity',
                'Unit Cost',
                'Stock Before',
                'Stock After',
                'Remarks',
                'Created By',
            ],
        ];

        foreach ($movements as $movement) {
            $rows[] = [
                $movement['reference_no']
                    ?? '—',

                $movement['date']
                    ?? '—',

                $movement['time']
                    ?? '—',

                $movement['movement_label']
                    ?? $movement['movement_type']
                    ?? '—',

                $movement['direction']
                    ?? '—',

                $movement['product_name']
                    ?? '—',

                $movement['product_code']
                    ?? '—',

                $movement['sku']
                    ?? '—',

                $movement['category']
                    ?? '—',

                $movement['branch_name']
                    ?? '—',

                $this->number(
                    $movement['quantity']
                        ?? 0
                ),

                $this->number(
                    $movement['unit_cost']
                        ?? 0
                ),

                $this->number(
                    $movement['stock_before']
                        ?? 0
                ),

                $this->number(
                    $movement['stock_after']
                        ?? 0
                ),

                $movement['remarks']
                    ?? '—',

                $movement['created_by']
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
                    'A1:P1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:P1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:P1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'K2:N' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:P' . max(
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

