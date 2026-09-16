<?php

namespace App\Exports\Reports;

use App\Exports\Reports\Inventory\CategoriesSheet;
use App\Exports\Reports\Inventory\LowStockSheet;
use App\Exports\Reports\Inventory\MovementsSheet;
use App\Exports\Reports\Inventory\ProductsSheet;
use App\Exports\Reports\Inventory\SummarySheet;
use App\Exports\Reports\Inventory\ValuationSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class InventoryReportExport implements WithMultipleSheets
{
    use Exportable;

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
     | Worksheets
     |--------------------------------------------------------------------------
     */

    public function sheets(): array
    {
        return [
            new SummarySheet(
                $this->report,
                $this->filters
            ),

            new ProductsSheet(
                $this->report
            ),

            new CategoriesSheet(
                $this->report
            ),           

            new MovementsSheet(
                $this->report
            ),

            new LowStockSheet(
                $this->report
            ),

            new ValuationSheet(
                $this->report
            ),
        ];
    }
}