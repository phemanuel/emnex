<?php

namespace App\Exports\Reports;

use App\Exports\Reports\Sales\CategoriesSheet;
use App\Exports\Reports\Sales\CustomersSheet;
use App\Exports\Reports\Sales\PaymentsSheet;
use App\Exports\Reports\Sales\ProductsSheet;
use App\Exports\Reports\Sales\SalespersonsSheet;
use App\Exports\Reports\Sales\SummarySheet;
use App\Exports\Reports\Sales\TransactionsSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalesReportExport implements WithMultipleSheets
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

    /**
     * |--------------------------------------------------------------------------
     * | Worksheets
     * |--------------------------------------------------------------------------
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

            new PaymentsSheet(
                $this->report
            ),

            new SalespersonsSheet(
                $this->report
            ),

            new CustomersSheet(
                $this->report
            ),

            new TransactionsSheet(
                $this->report
            ),
        ];
    }
}