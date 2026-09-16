<?php

namespace App\Exports\Reports\Inventory;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SummarySheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
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
     | Sheet Data
     |--------------------------------------------------------------------------
     */

    public function array(): array
    {
        $stats = $this->report['stats'] ?? [];

        $dateFrom = $this->filters['date_from']
            ?? '—';

        $dateTo = $this->filters['date_to']
            ?? '—';

        return [
            ['INVENTORY REPORT'],

            [''],

            [
                'Reporting Period',
                $dateFrom . ' to ' . $dateTo,
            ],

            [
                'Generated At',
                now()->format('Y-m-d H:i:s'),
            ],

            [''],

            ['INVENTORY SUMMARY'],

            ['Metric', 'Value'],

            [
                'Total Stock Value',
                $this->number(
                    $stats['total_stock_value'] ?? 0
                ),
            ],

            [
                'Available Stock Value',
                $this->number(
                    $stats['available_stock_value'] ?? 0
                ),
            ],

            [
                'Retail Value',
                $this->number(
                    $stats['retail_value'] ?? 0
                ),
            ],

            [
                'Potential Profit',
                $this->number(
                    $stats['potential_profit'] ?? 0
                ),
            ],

            [
                'Total Products',
                (int) (
                    $stats['total_products']
                    ?? 0
                ),
            ],

            [
                'Total Units',
                $this->number(
                    $stats['total_units'] ?? 0
                ),
            ],

            [
                'Low Stock',
                (int) (
                    $stats['low_stock']
                    ?? 0
                ),
            ],

            [
                'Out of Stock',
                (int) (
                    $stats['out_of_stock']
                    ?? 0
                ),
            ],

            [
                'Stock Movements',
                (int) (
                    $stats['stock_movements']
                    ?? 0
                ),
            ],

            [''],

            ['APPLIED FILTERS'],

            ['Filter', 'Value'],

            [
                'Branch',
                $this->filterValue(
                    $this->filters['branch_id'] ?? null
                ),
            ],

            [
                'Product',
                $this->filterValue(
                    $this->filters['product_id'] ?? null
                ),
            ],

            [
                'Category',
                $this->filterValue(
                    $this->filters['category_id'] ?? null
                ),
            ],

            [
                'Movement Type',
                $this->filterValue(
                    $this->filters['movement_type'] ?? null
                ),
            ],

            [
                'Stock Status',
                $this->filterValue(
                    $this->filters['stock_status'] ?? null
                ),
            ],
        ];
    }

    /*
     |--------------------------------------------------------------------------
     | Styles
     |--------------------------------------------------------------------------
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
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                ],
            ],

            6 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            7 => [
                'font' => [
                    'bold' => true,
                ],
            ],

            18 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            19 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    /*
     |--------------------------------------------------------------------------
     | Events
     |--------------------------------------------------------------------------
     */

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (
                AfterSheet $event
            ) {
                $sheet = $event->sheet
                    ->getDelegate();

                $sheet->mergeCells('A1:B1');

                $sheet->getStyle('A1:B1')
                    ->getFill()
                    ->setFillType(
                        Fill::FILL_SOLID
                    );

                $sheet->getStyle('A1:B1')
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                $sheet->getRowDimension(1)
                    ->setRowHeight(28);

                $this->styleSection(
                    $sheet,
                    'A6:B6'
                );

                $this->styleHeader(
                    $sheet,
                    'A7:B7'
                );

                $this->styleSection(
                    $sheet,
                    'A18:B18'
                );

                $this->styleHeader(
                    $sheet,
                    'A19:B19'
                );

                $sheet->getStyle('A1:B24')
                    ->getBorders()
                    ->getBottom()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                $sheet->freezePane('A7');
            },
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
            (float) $value,
            2
        );
    }

    protected function filterValue($value): string
    {
        if (
            $value === null
            || $value === ''
            || $value === 0
            || $value === '0'
        ) {
            return 'All';
        }

        return (string) $value;
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

