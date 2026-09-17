<?php

namespace App\Exports\Reports;

class ProfitLossCsvExport
{
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
    | Download
    |--------------------------------------------------------------------------
    */

    public function download()
    {
        $filename =
            'profit-loss-report-'
            . now()->format('Y-m-d_H-i-s')
            . '.csv';

        return response()->streamDownload(
            function () {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM
                |--------------------------------------------------------------------------
                */

                fwrite(
                    $handle,
                    "\xEF\xBB\xBF"
                );

                /*
                |--------------------------------------------------------------------------
                | Report Header
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [
                    'EMNEX PROFIT & LOSS REPORT',
                ]);

                fputcsv($handle, [
                    'Reporting Period',
                    ($this->filters['date_from'] ?? '—')
                    . ' to '
                    . ($this->filters['date_to'] ?? '—'),
                ]);

                fputcsv($handle, [
                    'Branch',
                    !empty($this->filters['branch_id'])
                        ? $this->filters['branch_id']
                        : 'All Branches',
                ]);

                fputcsv($handle, [
                    'Generated',
                    now()->format('d M Y H:i'),
                ]);

                fputcsv($handle, []);

                /*
                |--------------------------------------------------------------------------
                | Summary
                |--------------------------------------------------------------------------
                */

                $this->writeSummary($handle);

                /*
                |--------------------------------------------------------------------------
                | Revenue
                |--------------------------------------------------------------------------
                */

                $this->writeRevenue($handle);

                /*
                |--------------------------------------------------------------------------
                | Cost of Goods
                |--------------------------------------------------------------------------
                */

                $this->writeCostOfGoods($handle);

                /*
                |--------------------------------------------------------------------------
                | Expenses / Inventory Losses
                |--------------------------------------------------------------------------
                */

                $this->writeExpenses($handle);

                /*
                |--------------------------------------------------------------------------
                | Profit
                |--------------------------------------------------------------------------
                */

                $this->writeProfit($handle);

                /*
                |--------------------------------------------------------------------------
                | Breakdown
                |--------------------------------------------------------------------------
                */

                $this->writeBreakdown($handle);

                /*
                |--------------------------------------------------------------------------
                | Financial Position
                |--------------------------------------------------------------------------
                */

                $this->writeFinancialPosition($handle);

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

    protected function writeSummary($handle): void
    {
        $stats = $this->report['stats'] ?? [];

        fputcsv($handle, [
            'SUMMARY',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        $rows = [
            [
                'Gross Revenue',
                $stats['gross_revenue'] ?? 0,
            ],
            [
                'Sales Returns',
                $stats['sales_returns'] ?? 0,
            ],
            [
                'Net Revenue',
                $stats['net_revenue'] ?? 0,
            ],
            [
                'Gross Cost of Goods Sold',
                $stats['gross_cogs'] ?? 0,
            ],
            [
                'Returned Cost of Goods',
                $stats['returned_cogs'] ?? 0,
            ],
            [
                'Net Cost of Goods Sold',
                $stats['net_cogs'] ?? 0,
            ],
            [
                'Gross Profit',
                $stats['gross_profit'] ?? 0,
            ],
            [
                'Damage Loss',
                $stats['damage_loss'] ?? 0,
            ],
            [
                'Expired Loss',
                $stats['expired_loss'] ?? 0,
            ],
            [
                'Inventory Loss',
                $stats['inventory_loss'] ?? 0,
            ],
            [
                'Operating Result',
                $stats['operating_result'] ?? 0,
            ],
            [
                'Gross Margin',
                $stats['gross_margin'] ?? 0,
            ],
            [
                'Operating Margin',
                $stats['operating_margin'] ?? 0,
            ],
        ];

        foreach ($rows as $row) {

            fputcsv($handle, [
                $row[0],
                $this->number($row[1]),
            ]);
        }

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Revenue
    |--------------------------------------------------------------------------
    */

    protected function writeRevenue($handle): void
    {
        $revenue =
            $this->report['revenue'] ?? [];

        fputcsv($handle, [
            'REVENUE',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        fputcsv($handle, [
            'Gross Revenue',
            $this->number(
                $revenue['gross_revenue'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Sales Returns',
            $this->number(
                $revenue['sales_returns'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Net Revenue',
            $this->number(
                $revenue['net_revenue'] ?? 0
            ),
        ]);

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Cost of Goods
    |--------------------------------------------------------------------------
    */

    protected function writeCostOfGoods($handle): void
    {
        $costs =
            $this->report['cost_of_goods'] ?? [];

        fputcsv($handle, [
            'COST OF GOODS',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        fputcsv($handle, [
            'Gross COGS',
            $this->number(
                $costs['gross_cogs'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Returned COGS',
            $this->number(
                $costs['returned_cogs'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Net COGS',
            $this->number(
                $costs['net_cogs'] ?? 0
            ),
        ]);

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Expenses / Inventory Losses
    |--------------------------------------------------------------------------
    */

    protected function writeExpenses($handle): void
    {
        $expenses =
            $this->report['expenses'] ?? [];

        fputcsv($handle, [
            'EXPENSES / INVENTORY LOSSES',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        fputcsv($handle, [
            'Damage Loss',
            $this->number(
                $expenses['damage_loss'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Expired Loss',
            $this->number(
                $expenses['expired_loss'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Total Inventory Loss',
            $this->number(
                $expenses['total'] ?? 0
            ),
        ]);

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Profit
    |--------------------------------------------------------------------------
    */

    protected function writeProfit($handle): void
    {
        $profit =
            $this->report['profit'] ?? [];

        fputcsv($handle, [
            'PROFIT',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        fputcsv($handle, [
            'Gross Profit',
            $this->number(
                $profit['gross_profit'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Gross Margin',
            $this->percentage(
                $profit['gross_margin'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Operating Result',
            $this->number(
                $profit['operating_result'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Operating Margin',
            $this->percentage(
                $profit['operating_margin'] ?? 0
            ),
        ]);

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Breakdown
    |--------------------------------------------------------------------------
    */

    protected function writeBreakdown($handle): void
    {
        $breakdown =
            $this->report['breakdown'] ?? [];

        fputcsv($handle, [
            'BREAKDOWN',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        foreach ($breakdown as $key => $value) {

            fputcsv($handle, [
                $this->label($key),
                $this->number($value),
            ]);
        }

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Financial Position
    |--------------------------------------------------------------------------
    */

    protected function writeFinancialPosition($handle): void
    {
        /*
        |--------------------------------------------------------------------------
        | Current ProfitLossService::generate() does not yet return a
        | financial_position array.
        |--------------------------------------------------------------------------
        */

        $financialPosition =
            $this->report['financial_position']
                ?? null;

        fputcsv($handle, [
            'FINANCIAL POSITION',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        if (
            is_array($financialPosition)
            && !empty($financialPosition)
        ) {

            foreach (
                $financialPosition as $key => $value
            ) {

                fputcsv($handle, [
                    $this->label($key),
                    $this->number(
                        is_array($value)
                            ? (
                                $value['amount']
                                ?? $value['total']
                                ?? 0
                            )
                            : $value
                    ),
                ]);
            }

        } else {

            fputcsv($handle, [
                'Financial Position',
                'Not available',
            ]);
        }

        fputcsv($handle, []);
    }

    /*
    |--------------------------------------------------------------------------
    | Number
    |--------------------------------------------------------------------------
    */

    protected function number($value): float
    {
        return round(
            (float) ($value ?? 0),
            2
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Percentage
    |--------------------------------------------------------------------------
    */

    protected function percentage($value): string
    {
        return number_format(
            (float) ($value ?? 0),
            2
        ) . '%';
    }

    /*
    |--------------------------------------------------------------------------
    | Label
    |--------------------------------------------------------------------------
    */

    protected function label(string $key): string
    {
        return ucwords(
            str_replace(
                '_',
                ' ',
                $key
            )
        );
    }
}

