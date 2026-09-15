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

class TransactionsSheet implements
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
        return 'Transactions';
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sheet Data
     * |--------------------------------------------------------------------------
     */
    public function array(): array
    {
           $transactions =
                $this->report['transaction_export_rows']
                ?? [];

            $rows = [
                [
                    'Order No.',
                    'Date',
                    'Customer',
                    'Salesperson',
                    'Branch',
                    'Terminal',
                    'Payment',
                    'Gross Sales',
                    'Discount',
                    'Tax',
                    'Total',
                    'Status',
                ],
            ];



        foreach ($transactions as $transaction) {
            $rows[] = [
                $transaction['order_no']
                    ?? '—',

                $transaction['date']
                    ?? '—',

                $transaction['customer']
                    ?? 'Walk-in Customer',

                $transaction['cashier']
                    ?? $transaction['salesperson']
                    ?? 'Unknown',

                $transaction['branch']
                    ?? 'Unknown',

                $transaction['terminal']
                    ?? '—',

                $transaction['payment']
                    ?? '—',

                $this->number(
                    $transaction['gross']
                        ?? $transaction['gross_sales']
                        ?? 0
                ),

                $this->number(
                    $transaction['discount']
                        ?? 0
                ),

                $this->number(
                    $transaction['tax']
                        ?? 0
                ),

                $this->number(
                    $transaction['total']
                        ?? 0
                ),

                $transaction['status']
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
                    'A1:L1'
                )->getFont()->setBold(true);

                $sheet->getStyle(
                    'A1:L1'
                )->getFill()->setFillType(
                    Fill::FILL_SOLID
                );

                $sheet->getStyle(
                    'A1:L1'
                )->getAlignment()->setHorizontal(
                    Alignment::HORIZONTAL_LEFT
                );

                if ($highestRow > 1) {
                    $sheet->getStyle(
                        'H2:K' . $highestRow
                    )->getNumberFormat()
                        ->setFormatCode(
                            '#,##0.00'
                        );
                }

                $sheet->freezePane('A2');

                $sheet->setAutoFilter(
                    'A1:L' . max(
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