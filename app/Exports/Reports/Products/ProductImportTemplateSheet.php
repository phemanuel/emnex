<?php

namespace App\Exports\Reports\Products;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImportTemplateSheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
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
        return [
            [
                'Name',
                'SKU',
                'Barcode',
                'QR Code',
                'Description',
                'Brand',
                'Manufacturer',
                'Category',
                'Unit',
                'Discount',
                'Cost Price',
                'Selling Price',
                'Minimum Stock',
                'Maximum Stock',
                'Opening Stock',
                'Weight',
                'Expiry Date',
                'Status',
            ],

            [
                'Sample Product',
                'SKU-0001',
                '1234567890123',
                'QR-0001',
                'Example product - replace this row with your products.',
                'Sample Brand',
                'Sample Manufacturer',
                'Electronics',
                'Piece',
                'None',
                5000,
                7500,
                10,
                100,
                25,
                0.50,
                '2027-12-31',
                'Active',
            ],
        ];
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
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            2 => [
                'font' => [
                    'italic' => true,
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
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:S1')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A1:S1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('E9EEF5');

                $sheet->getStyle('A1:S1')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                /*
                |--------------------------------------------------------------------------
                | Sample row
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A2:S2')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFF8E1');

                $sheet->getStyle('A2:S2')
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_TOP
                    );

                /*
                |--------------------------------------------------------------------------
                | Number formats
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'L2:Q' . $highestRow
                )->getNumberFormat()
                    ->setFormatCode('#,##0.00');

                /*
                |--------------------------------------------------------------------------
                | Expiry date
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle(
                    'R2:R' . $highestRow
                )->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');

                /*
                |--------------------------------------------------------------------------
                | Text columns
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:S' . $highestRow)
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_TOP
                    );

                $sheet->getStyle('E1:E' . $highestRow)
                    ->getAlignment()
                    ->setWrapText(true);

                /*
                |--------------------------------------------------------------------------
                | Freeze header
                |--------------------------------------------------------------------------
                */

                $sheet->freezePane('A2');

                /*
                |--------------------------------------------------------------------------
                | Filter
                |--------------------------------------------------------------------------
                */

                $sheet->setAutoFilter(
                    'A1:S' . max(1, $highestRow)
                );
            },
        ];
    }
}

