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

class SalespersonsSheet implements
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
        return 'Salespersons';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
        $salespersons = $this->report['cashiers']
            ?? [];

        $rows = [
            [
                'Salesperson',
                'Transactions',
                'Quantity',
                'Average Sale',
                'Sales',
                'Share',
            ],
        ];

        foreach ($salespersons as $salesperson) {
            $rows[] = [
                $salesperson['cashier']
                    ?? $salesperson['salesperson']
                    ?? $salesperson['name']
                    ?? '—',

                (int) (
                    $salesperson['transactions']
                        ?? 0
                ),

                (float) (
                    $salesperson['quantity']
                        ?? $salesperson['units_sold']
                        ?? 0
                ),

                $this->number(
                    $salesperson['average_sale']
                        ?? $salesperson['average_order']
                        ?? 0
                ),

                $this->number(
                    $salesperson['sales']
                        ?? $salesperson['total']
                        ?? 0
                ),

                $this->percentage(
                    $salesperson['share']
                        ?? $salesperson['percentage']
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
                    'A1:F1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:F1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:F1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'B2:C' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0'
                        );

                    $sheet->getStyle(
                        'D2:E' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );

                    $sheet->getStyle(
                        'F2:F' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '0.00%'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:F' . max(
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