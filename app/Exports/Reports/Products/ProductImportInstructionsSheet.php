<?php

namespace App\Exports\Reports\Products;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductImportInstructionsSheet implements
    FromArray,
    WithTitle,
    ShouldAutoSize,
    WithStyles
{
    public function title(): string
    {
        return 'Instructions';
    }

    public function array(): array
    {
        return [
            [
                'Product Import Template',
            ],

            [
                '',
            ],

            [
                'Important Instructions',
            ],

            [
                '1. Delete the sample product row before importing your real products.',
            ],

            [
                '2. Do not add, remove, or rename the column headers.',
            ],

            [
                '3. Product Code is generated automatically by EMNEX and should not be included.',
            ],

            [
                '4. Category, Unit, Tax Rate, and Discount must use their names, not database IDs.',
            ],

            [
                '5. SKU and Barcode must be unique within the company.',
            ],

            [
                '6. Cost Price, Selling Price, and stock quantities must be numeric values.',
            ],

            [
                '7. Maximum Stock may be left blank if there is no maximum stock limit.',
            ],

            [
                '8. Opening Stock will be created in the Head Office stock record.',
            ],

            [
                '9. Status can be Active or Inactive. Blank status defaults to Active.',
            ],

            [
                '10. Expiry Date should use a valid date such as 2027-12-31.',
            ],

            [
                '',
            ],

            [
                'Column',
                'Required',
                'Description',
                'Example',
            ],

            [
                'Name',
                'Yes',
                'Product name.',
                'Sample Product',
            ],

            [
                'SKU',
                'No',
                'Unique stock keeping unit.',
                'SKU-0001',
            ],

            [
                'Barcode',
                'No',
                'Unique product barcode.',
                '1234567890123',
            ],

            [
                'QR Code',
                'No',
                'Product QR code value.',
                'QR-0001',
            ],

            [
                'Description',
                'No',
                'Product description.',
                'Example product',
            ],

            [
                'Brand',
                'No',
                'Product brand.',
                'Sample Brand',
            ],

            [
                'Manufacturer',
                'No',
                'Product manufacturer.',
                'Sample Manufacturer',
            ],

            [
                'Category',
                'Yes',
                'Existing product category name.',
                'Electronics',
            ],

            [
                'Unit',
                'Yes',
                'Existing unit name.',
                'Piece',
            ],

            [
                'Tax Rate',
                'No',
                'Existing tax rate name.',
                'VAT 7.5%',
            ],

            [
                'Discount',
                'No',
                'Existing discount name.',
                'None',
            ],

            [
                'Cost Price',
                'Yes',
                'Product cost price.',
                '5000',
            ],

            [
                'Selling Price',
                'Yes',
                'Product selling price.',
                '7500',
            ],

            [
                'Minimum Stock',
                'Yes',
                'Reorder/minimum stock level.',
                '10',
            ],

            [
                'Maximum Stock',
                'No',
                'Maximum allowed stock level.',
                '100',
            ],

            [
                'Opening Stock',
                'No',
                'Initial stock quantity.',
                '25',
            ],

            [
                'Weight',
                'No',
                'Product weight.',
                '0.50',
            ],

            [
                'Expiry Date',
                'No',
                'Product expiry date.',
                '2027-12-31',
            ],

            [
                'Status',
                'No',
                'Active or Inactive.',
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
                    'size' => 16,
                ],
            ],

            3 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],

            15 => [
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
        ];
    }
}

