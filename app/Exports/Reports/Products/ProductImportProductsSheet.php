<?php

namespace App\Exports\Reports\Products;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImportProductsSheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize,
    WithStyles
{
    public function title(): string
    {
        return 'Products';
    }

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

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
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
}

