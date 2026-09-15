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

class SalesTrendSheet implements
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

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Title
     * |--------------------------------------------------------------------------
     */
    public function title(): string
    {
        return 'Sales Trend';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $trend = $this->report['charts']['trend']
            ?? [];

        $rows = [
            [
                'Date',
                'Gross Sales',
                'Net Sales',
                'Transactions',
            ],
        ];

        foreach ($trend as $item) {
            $rows[] = [
                $item['date']
                    ?? $item['label']
                    ?? '—',

                $this->number(
                    $item['gross_sales']
                        ?? $item['gross']
                        ?? 0
                ),

                $this->number(
                    $item['net_sales']
                        ?? $item['net']
                        ?? 0
                ),

                (int) (
                    $item['transactions']
                        ?? $item['orders']
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
                    'A1:D1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:D1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:D1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'B2:C' . $highestRow
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
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:D' . max(
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