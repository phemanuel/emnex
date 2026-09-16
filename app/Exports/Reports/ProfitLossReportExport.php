<?php

namespace App\Exports\Reports;

use App\Exports\Reports\ProfitLoss\BreakdownSheet;
use App\Exports\Reports\ProfitLoss\CostOfGoodsSheet;
use App\Exports\Reports\ProfitLoss\ExpensesSheet;
use App\Exports\Reports\ProfitLoss\FinancialPositionSheet;
use App\Exports\Reports\ProfitLoss\ProfitSheet;
use App\Exports\Reports\ProfitLoss\RevenueSheet;
use App\Exports\Reports\ProfitLoss\SummarySheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProfitLossReportExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        return [
            new SummarySheet(
                $this->report,
                $this->filters
            ),

            new RevenueSheet(
                $this->report
            ),

            new CostOfGoodsSheet(
                $this->report
            ),

            new ExpensesSheet(
                $this->report
            ),

            new ProfitSheet(
                $this->report
            ),

            new BreakdownSheet(
                $this->report
            ),

            new FinancialPositionSheet(
                $this->report
            ),
        ];
    }
}

