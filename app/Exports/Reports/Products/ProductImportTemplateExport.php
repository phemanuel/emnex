<?php

namespace App\Exports\Reports\Products;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductImportTemplateExport implements WithMultipleSheets
{
    /**
     * --------------------------------------------------------------------------
     * Worksheets
     * --------------------------------------------------------------------------
     */
    public function sheets(): array
    {
        return [
            new ProductImportProductsSheet(),
            new ProductImportInstructionsSheet(),
        ];
    }
}

