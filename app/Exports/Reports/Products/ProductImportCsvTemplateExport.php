<?php

namespace App\Exports\Reports\Products;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ProductImportCsvTemplateExport implements
    FromArray,
    WithCustomCsvSettings
{
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
                'Tax Rate',
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
                'VAT 7.5%',
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

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
        ];
    }
}

