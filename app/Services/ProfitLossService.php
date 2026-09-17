<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ProfitLossService
{
    public function export(array $filters, $user)
    {
        $report = $this->generate(
            $filters,
            $user
        );
        

        $format = strtolower(
            trim(
                $filters['format'] ?? 'xlsx'
            )
        );

        return match ($format) {

            'xlsx' => \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\Reports\ProfitLossReportExport(
                    $report,
                    $filters
                ),
                'profit-loss-report-'
                    . now()->format('Y-m-d_H-i-s')
                    . '.xlsx'
            ),

            'csv' => (
                new \App\Exports\Reports\ProfitLossCsvExport(
                    $report,
                    $filters
                )
            )->download(),

            'pdf' => \Barryvdh\DomPDF\Facade\Pdf::loadView(
                'reports.profit-loss.pdf',
                [
                    'report' => $report,
                    'filters' => $filters,
                    'company' => \App\Models\Company::find($user->company_id),
                ]
            )
                ->setPaper('a4', 'landscape')
                ->download(
                    'profit-loss-report-'
                    . now()->format('Y-m-d_H-i-s')
                    . '.pdf'
                ),

            default => throw new \InvalidArgumentException(
                'Invalid export format.'
            ),
        };
    }


    /**
     * |--------------------------------------------------------------------------
     * | Generate Profit & Loss Report
     * |--------------------------------------------------------------------------
     */
    public function generate(array $filters, $user): array
    {
        $companyId = (int) $user->company_id;

        $dateFrom = $this->resolveDateFrom($filters);
        $dateTo = $this->resolveDateTo($filters);

        $branchId = $filters['branch_id'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Revenue
        |--------------------------------------------------------------------------
        */

        $grossRevenue = $this->calculateGrossRevenue(
            $companyId,
            $branchId,
            $dateFrom,
            $dateTo
        );

        /*
        |--------------------------------------------------------------------------
        | Sales Returns
        |--------------------------------------------------------------------------
        */

        $salesReturns = $this->calculateSalesReturns(
            $companyId,
            $branchId,
            $dateFrom,
            $dateTo
        );

        /*
        |--------------------------------------------------------------------------
        | Net Revenue
        |--------------------------------------------------------------------------
        */

        $netRevenue =
            $grossRevenue
            -
            $salesReturns['amount'];

        /*
        |--------------------------------------------------------------------------
        | Cost Of Goods Sold
        |--------------------------------------------------------------------------
        */

        $grossCogs = $this->calculateGrossCogs(
            $companyId,
            $branchId,
            $dateFrom,
            $dateTo
        );

        /*
        |--------------------------------------------------------------------------
        | Returned Cost Of Goods
        |--------------------------------------------------------------------------
        */

        $returnedCogs = $salesReturns['cogs'];

        /*
        |--------------------------------------------------------------------------
        | Net COGS
        |--------------------------------------------------------------------------
        */

        $netCogs =
            $grossCogs
            -
            $returnedCogs;

        /*
        |--------------------------------------------------------------------------
        | Gross Profit
        |--------------------------------------------------------------------------
        */

        $grossProfit =
            $netRevenue
            -
            $netCogs;

        /*
        |--------------------------------------------------------------------------
        | Inventory Losses
        |--------------------------------------------------------------------------
        */

        $inventoryLosses = $this->calculateInventoryLosses(
            $companyId,
            $branchId,
            $dateFrom,
            $dateTo
        );

        /*
        |--------------------------------------------------------------------------
        | Operating Result
        |--------------------------------------------------------------------------
        */

        $operatingResult =
            $grossProfit
            -
            $inventoryLosses['total'];

        /*
        |--------------------------------------------------------------------------
        | Margins
        |--------------------------------------------------------------------------
        */

        $grossMargin = $netRevenue > 0
            ? ($grossProfit / $netRevenue) * 100
            : 0;

        $operatingMargin = $netRevenue > 0
            ? ($operatingResult / $netRevenue) * 100
            : 0;

        return [
            'filters' => [
                'date_from' => $dateFrom->toDateString(),
                'date_to' => $dateTo->toDateString(),
                'branch_id' => $branchId,
            ],

            'stats' => [
                'gross_revenue' => round($grossRevenue, 2),
                'sales_returns' => round(
                    $salesReturns['amount'],
                    2
                ),
                'net_revenue' => round(
                    $netRevenue,
                    2
                ),

                'gross_cogs' => round(
                    $grossCogs,
                    2
                ),
                'returned_cogs' => round(
                    $returnedCogs,
                    2
                ),
                'net_cogs' => round(
                    $netCogs,
                    2
                ),

                'gross_profit' => round(
                    $grossProfit,
                    2
                ),

                'damage_loss' => round(
                    $inventoryLosses['damage'],
                    2
                ),

                'expired_loss' => round(
                    $inventoryLosses['expired'],
                    2
                ),

                'inventory_loss' => round(
                    $inventoryLosses['total'],
                    2
                ),

                'operating_result' => round(
                    $operatingResult,
                    2
                ),

                'gross_margin' => round(
                    $grossMargin,
                    2
                ),

                'operating_margin' => round(
                    $operatingMargin,
                    2
                ),
            ],

           'charts' => [
                'trend' => $this->buildTrendChart(
                    $filters,
                    $user,
                    $dateFrom,
                    $dateTo
                ),

                'revenue' => $this->buildRevenueChart(
                    $filters,
                    $user,
                    $dateFrom,
                    $dateTo
                ),

                'costs' => $this->buildCostsChart(
                    $filters,
                    $user,
                    $dateFrom,
                    $dateTo
                ),

                'profit' => $this->buildProfitChart(
                    $filters,
                    $user,
                    $dateFrom,
                    $dateTo
                ),
            ],

            'revenue' => [
                'gross_revenue' => round(
                    $grossRevenue,
                    2
                ),

                'sales_returns' => round(
                    $salesReturns['amount'],
                    2
                ),

                'net_revenue' => round(
                    $netRevenue,
                    2
                ),
            ],

            'cost_of_goods' => [
                'gross_cogs' => round(
                    $grossCogs,
                    2
                ),

                'returned_cogs' => round(
                    $returnedCogs,
                    2
                ),

                'net_cogs' => round(
                    $netCogs,
                    2
                ),
            ],

            'expenses' => [
                'damage_loss' => round(
                    $inventoryLosses['damage'],
                    2
                ),

                'expired_loss' => round(
                    $inventoryLosses['expired'],
                    2
                ),

                'total' => round(
                    $inventoryLosses['total'],
                    2
                ),
            ],

            'profit' => [
                'gross_profit' => round(
                    $grossProfit,
                    2
                ),

                'gross_margin' => round(
                    $grossMargin,
                    2
                ),

                'operating_result' => round(
                    $operatingResult,
                    2
                ),

                'operating_margin' => round(
                    $operatingMargin,
                    2
                ),
            ],


            'financial_position' => [
                'net_revenue' => round(
                    $netRevenue,
                    2
                ),

                'net_cogs' => round(
                    $netCogs,
                    2
                ),

                'gross_profit' => round(
                    $grossProfit,
                    2
                ),

                'inventory_loss' => round(
                    $inventoryLosses['total'],
                    2
                ),

                'operating_result' => round(
                    $operatingResult,
                    2
                ),

                'gross_margin' => round(
                    $grossMargin,
                    2
                ),

                'operating_margin' => round(
                    $operatingMargin,
                    2
                ),
            ],

            'breakdown' => [
                'gross_revenue' => round(
                    $grossRevenue,
                    2
                ),

                'sales_returns' => round(
                    $salesReturns['amount'],
                    2
                ),

                'net_revenue' => round(
                    $netRevenue,
                    2
                ),

                'gross_cogs' => round(
                    $grossCogs,
                    2
                ),

                'returned_cogs' => round(
                    $returnedCogs,
                    2
                ),

                'net_cogs' => round(
                    $netCogs,
                    2
                ),

                'gross_profit' => round(
                    $grossProfit,
                    2
                ),

                'damage_loss' => round(
                    $inventoryLosses['damage'],
                    2
                ),

                'expired_loss' => round(
                    $inventoryLosses['expired'],
                    2
                ),

                'inventory_loss' => round(
                    $inventoryLosses['total'],
                    2
                ),

                'operating_result' => round(
                    $operatingResult,
                    2
                ),
            ],
        ];
    }

   
    /*
    |--------------------------------------------------------------------------
    | Chart Data
    |--------------------------------------------------------------------------
    */

    protected function buildTrendChart(
        array $filters,
        $user,
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $branchId = isset($filters['branch_id']) && $filters['branch_id'] !== ''
            ? (int) $filters['branch_id']
            : null;

        $orders = Order::query()
            ->where('company_id', $user->company_id)
            ->where('order_status', 'Completed')
            ->whereBetween('completed_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($orders, $branchId);

        $orders = $orders
            ->with('orderItems:id,order_id,quantity,unit_cost')
            ->get();

        $returns = SalesReturn::query()
            ->where('company_id', $user->company_id)
            ->where('return_status', 'Completed')
            ->whereBetween('processed_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($returns, $branchId);

        $returns = $returns
            ->with('items:id,sales_return_id,quantity,unit_cost,total')
            ->get();

        $movements = StockMovement::query()
            ->where('company_id', $user->company_id)
            ->whereIn('movement_type', ['Damage', 'Expired'])
            ->whereBetween('created_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($movements, $branchId);

        $movements = $movements->get();

        $periods = $this->buildChartPeriods($dateFrom, $dateTo);

        $orderPeriods = $orders->groupBy(function ($order) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $order->completed_at,
                $dateFrom,
                $dateTo
            );
        });

        $returnPeriods = $returns->groupBy(function ($return) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $return->processed_at,
                $dateFrom,
                $dateTo
            );
        });

        $movementPeriods = $movements->groupBy(function ($movement) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $movement->created_at,
                $dateFrom,
                $dateTo
            );
        });

        return collect($periods)->map(function ($period) use (
            $orderPeriods,
            $returnPeriods,
            $movementPeriods
        ) {
            $date = $period['date'];

            $periodOrders = $orderPeriods->get($date, collect());
            $periodReturns = $returnPeriods->get($date, collect());
            $periodMovements = $movementPeriods->get($date, collect());

            $grossRevenue = (float) $periodOrders->sum('grand_total');

            $salesReturns = (float) $periodReturns->sum(function ($return) {
                return (float) $return->refund_amount;
            });

            $grossCogs = (float) $periodOrders->sum(function ($order) {
                return (float) $order->orderItems->sum(function ($item) {
                    return (float) $item->quantity
                        * (float) $item->unit_cost;
                });
            });

            $returnedCogs = (float) $periodReturns->sum(function ($return) {
                return (float) $return->items->sum(function ($item) {
                    return (float) $item->quantity
                        * (float) $item->unit_cost;
                });
            });

            $inventoryLoss = (float) $periodMovements->sum(function ($movement) {
                return (float) $movement->quantity
                    * (float) $movement->unit_cost;
            });

            $netRevenue = $grossRevenue - $salesReturns;
            $netCogs = $grossCogs - $returnedCogs;
            $grossProfit = $netRevenue - $netCogs;
            $operatingResult = $grossProfit - $inventoryLoss;

            return [
                'date' => $date,
                'label' => $period['label'],
                'revenue' => round($netRevenue, 2),
                'cogs' => round($netCogs, 2),
                'operating_result' => round($operatingResult, 2),
            ];
        })->values()->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Revenue Chart
    |--------------------------------------------------------------------------
    */

    protected function buildRevenueChart(
        array $filters,
        $user,
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $branchId = isset($filters['branch_id']) && $filters['branch_id'] !== ''
            ? (int) $filters['branch_id']
            : null;

        $orders = Order::query()
            ->where('company_id', $user->company_id)
            ->where('order_status', 'Completed')
            ->whereBetween('completed_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($orders, $branchId);

        $orders = $orders->get();

        $returns = SalesReturn::query()
            ->where('company_id', $user->company_id)
            ->where('return_status', 'Completed')
            ->whereBetween('processed_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($returns, $branchId);

        $returns = $returns->get();

        $periods = $this->buildChartPeriods($dateFrom, $dateTo);

        $orderPeriods = $orders->groupBy(function ($order) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $order->completed_at,
                $dateFrom,
                $dateTo
            );
        });

        $returnPeriods = $returns->groupBy(function ($return) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $return->processed_at,
                $dateFrom,
                $dateTo
            );
        });

        return collect($periods)->map(function ($period) use (
            $orderPeriods,
            $returnPeriods
        ) {
            $date = $period['date'];

            $periodOrders = $orderPeriods->get($date, collect());
            $periodReturns = $returnPeriods->get($date, collect());

            $grossRevenue = (float) $periodOrders->sum('grand_total');

            $salesReturns = (float) $periodReturns->sum('refund_amount');

            return [
                'date' => $date,
                'label' => $period['label'],
                'gross_revenue' => round($grossRevenue, 2),
                'sales_returns' => round($salesReturns, 2),
                'net_revenue' => round(
                    $grossRevenue - $salesReturns,
                    2
                ),
            ];
        })->values()->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Cost Chart
    |--------------------------------------------------------------------------
    */

    protected function buildCostsChart(
        array $filters,
        $user,
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $branchId = isset($filters['branch_id']) && $filters['branch_id'] !== ''
            ? (int) $filters['branch_id']
            : null;

        $orders = Order::query()
            ->where('company_id', $user->company_id)
            ->where('order_status', 'Completed')
            ->whereBetween('completed_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($orders, $branchId);

        $orders = $orders
            ->with('orderItems:id,order_id,quantity,unit_cost')
            ->get();

        $returns = SalesReturn::query()
            ->where('company_id', $user->company_id)
            ->where('return_status', 'Completed')
            ->whereBetween('processed_at', [$dateFrom, $dateTo]);

        $this->applyBranchFilter($returns, $branchId);

        $returns = $returns
            ->with('items:id,sales_return_id,quantity,unit_cost')
            ->get();

        $periods = $this->buildChartPeriods($dateFrom, $dateTo);

        $orderPeriods = $orders->groupBy(function ($order) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $order->completed_at,
                $dateFrom,
                $dateTo
            );
        });

        $returnPeriods = $returns->groupBy(function ($return) use (
            $dateFrom,
            $dateTo
        ) {
            return $this->chartPeriodKey(
                $return->processed_at,
                $dateFrom,
                $dateTo
            );
        });

        return collect($periods)->map(function ($period) use (
            $orderPeriods,
            $returnPeriods
        ) {
            $date = $period['date'];

            $periodOrders = $orderPeriods->get($date, collect());
            $periodReturns = $returnPeriods->get($date, collect());

            $grossCogs = (float) $periodOrders->sum(function ($order) {
                return (float) $order->orderItems->sum(function ($item) {
                    return (float) $item->quantity
                        * (float) $item->unit_cost;
                });
            });

            $returnedCogs = (float) $periodReturns->sum(function ($return) {
                return (float) $return->items->sum(function ($item) {
                    return (float) $item->quantity
                        * (float) $item->unit_cost;
                });
            });

            return [
                'date' => $date,
                'label' => $period['label'],
                'gross_cogs' => round($grossCogs, 2),
                'returned_cogs' => round($returnedCogs, 2),
                'net_cogs' => round(
                    $grossCogs - $returnedCogs,
                    2
                ),
            ];
        })->values()->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Profit Chart
    |--------------------------------------------------------------------------
    */

    protected function buildProfitChart(
        array $filters,
        $user,
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $trend = $this->buildTrendChart(
            $filters,
            $user,
            $dateFrom,
            $dateTo
        );

        return collect($trend)->map(function ($row) {
            $grossProfit = (float) $row['revenue']
                - (float) $row['cogs'];

            $inventoryLoss = $grossProfit
                - (float) $row['operating_result'];

            return [
                'date' => $row['date'],
                'label' => $row['label'],
                'gross_profit' => round($grossProfit, 2),
                'inventory_loss' => round(
                    max($inventoryLoss, 0),
                    2
                ),
                'operating_result' => round(
                    (float) $row['operating_result'],
                    2
                ),
            ];
        })->values()->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Chart Periods
    |--------------------------------------------------------------------------
    */

    protected function buildChartPeriods(
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $days = $dateFrom->diffInDays($dateTo);

        if ($days <= 31) {
            $periods = [];

            $cursor = $dateFrom->copy()->startOfDay();
            $end = $dateTo->copy()->startOfDay();

            while ($cursor->lte($end)) {
                $periods[] = [
                    'date' => $cursor->format('Y-m-d'),
                    'label' => $cursor->format('d M'),
                ];

                $cursor->addDay();
            }

            return $periods;
        }

        $periods = [];

        $cursor = $dateFrom->copy()->startOfMonth();
        $end = $dateTo->copy()->startOfMonth();

        while ($cursor->lte($end)) {
            $periods[] = [
                'date' => $cursor->format('Y-m'),
                'label' => $cursor->format('M Y'),
            ];

            $cursor->addMonth();
        }

        return $periods;
    }


    /*
    |--------------------------------------------------------------------------
    | Chart Period Key
    |--------------------------------------------------------------------------
    */

    protected function chartPeriodKey(
        $date,
        Carbon $dateFrom,
        Carbon $dateTo
    ): ?string {
        if (!$date) {
            return null;
        }

        $days = $dateFrom->diffInDays($dateTo);

        return $days <= 31
            ? $date->format('Y-m-d')
            : $date->format('Y-m');
    }



  
    public function getFilters(int $companyId, $user): array
    {
        $branchesQuery = \App\Models\Branch::query()
            ->where('company_id', $companyId)
            ->orderBy('name');

        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('branch_manager') ||
            $user->hasRole('cashier')
        ) {
            $branchId = $user->branch_id;

            if ($branchId) {
                $branchesQuery->where('id', $branchId);
            } else {
                $branchesQuery->whereRaw('1 = 0');
            }
        }

        return [
            'branches' => $branchesQuery->get(),
        ];
    }




    /**
     * |--------------------------------------------------------------------------
     * | Gross Revenue
     * |--------------------------------------------------------------------------
     *
     * Completed sales only.
     *
     * Revenue is based on Order.grand_total and the order completion date.
     */
    protected function calculateGrossRevenue(
        int $companyId,
        ?int $branchId,
        Carbon $dateFrom,
        Carbon $dateTo
    ): float {
        $query = Order::query()
            ->where('company_id', $companyId)
            ->where('order_status', 'Completed')
            ->whereBetween(
                'completed_at',
                [
                    $dateFrom->copy()->startOfDay(),
                    $dateTo->copy()->endOfDay(),
                ]
            );

        $this->applyBranchFilter(
            $query,
            $branchId
        );

        return (float) $query->sum('grand_total');
    }

    /**
     * |--------------------------------------------------------------------------
     * | Gross COGS
     * |--------------------------------------------------------------------------
     *
     * Uses the historical unit_cost stored on OrderItem.
     */
    protected function calculateGrossCogs(
        int $companyId,
        ?int $branchId,
        Carbon $dateFrom,
        Carbon $dateTo
    ): float {
        $query = \App\Models\OrderItem::query()
            ->where('company_id', $companyId)
            ->whereHas('order', function (Builder $orderQuery) use (
                $dateFrom,
                $dateTo,
                $branchId
            ) {
                $orderQuery
                    ->where('order_status', 'Completed')
                    ->whereBetween(
                        'completed_at',
                        [
                            $dateFrom->copy()->startOfDay(),
                            $dateTo->copy()->endOfDay(),
                        ]
                    );

                if ($branchId !== null) {
                    $orderQuery->where(
                        'branch_id',
                        $branchId
                    );
                }
            });

        return (float) $query
            ->selectRaw(
                'COALESCE(SUM(quantity * unit_cost), 0) as total'
            )
            ->value('total');
    }

    /**
     * |--------------------------------------------------------------------------
     * | Sales Returns
     * |--------------------------------------------------------------------------
     *
     * Completed returns processed within the selected period.
     *
     * Return amount:
     * SalesReturnItem.total
     *
     * Returned COGS:
     * SalesReturnItem.quantity × SalesReturnItem.unit_cost
     */
    protected function calculateSalesReturns(
        int $companyId,
        ?int $branchId,
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $returnQuery = SalesReturn::query()
            ->where('company_id', $companyId)
            ->where('return_status', 'Completed')
            ->whereBetween(
                'processed_at',
                [
                    $dateFrom->copy()->startOfDay(),
                    $dateTo->copy()->endOfDay(),
                ]
            );

        $this->applyBranchFilter(
            $returnQuery,
            $branchId
        );

        $returnIds = $returnQuery->pluck('id');

        if ($returnIds->isEmpty()) {
            return [
                'amount' => 0.0,
                'cogs' => 0.0,
            ];
        }

        $itemQuery = SalesReturnItem::query()
            ->where('company_id', $companyId)
            ->whereIn(
                'sales_return_id',
                $returnIds
            );

        $amount = (float) $itemQuery
            ->selectRaw(
                'COALESCE(SUM(total), 0) as total'
            )
            ->value('total');

        $cogs = (float) SalesReturnItem::query()
            ->where('company_id', $companyId)
            ->whereIn(
                'sales_return_id',
                $returnIds
            )
            ->selectRaw(
                'COALESCE(SUM(quantity * unit_cost), 0) as total'
            )
            ->value('total');

        return [
            'amount' => $amount,
            'cogs' => $cogs,
        ];
    }

    /**
     * |--------------------------------------------------------------------------
     * | Inventory Losses
     * |--------------------------------------------------------------------------
     *
     * Damage and Expired movements are inventory losses.
     *
     * Loss = quantity × historical unit_cost.
     */
    protected function calculateInventoryLosses(
        int $companyId,
        ?int $branchId,
        Carbon $dateFrom,
        Carbon $dateTo
    ): array {
        $query = StockMovement::query()
            ->where('company_id', $companyId)
            ->whereIn(
                'movement_type',
                [
                    'Damage',
                    'Expired',
                ]
            )
            ->whereBetween(
                'created_at',
                [
                    $dateFrom->copy()->startOfDay(),
                    $dateTo->copy()->endOfDay(),
                ]
            );

        $this->applyBranchFilter(
            $query,
            $branchId
        );

        $movements = $query
            ->select([
                'movement_type',
                'quantity',
                'unit_cost',
            ])
            ->get();

        $damage = 0.0;
        $expired = 0.0;

        foreach ($movements as $movement) {
            $loss =
                (float) $movement->quantity
                *
                (float) $movement->unit_cost;

            if ($movement->movement_type === 'Damage') {
                $damage += $loss;
            }

            if ($movement->movement_type === 'Expired') {
                $expired += $loss;
            }
        }

        return [
            'damage' => $damage,
            'expired' => $expired,
            'total' => $damage + $expired,
        ];
    }

    /**
     * |--------------------------------------------------------------------------
     * | Apply Branch Filter
     * |--------------------------------------------------------------------------
     */
    protected function applyBranchFilter(
        Builder $query,
        ?int $branchId
    ): void {
        if ($branchId !== null) {
            $query->where(
                'branch_id',
                $branchId
            );
        }
    }

    /**
     * |--------------------------------------------------------------------------
     * | Resolve Date From
     * |--------------------------------------------------------------------------
     */
    protected function resolveDateFrom(array $filters): Carbon
    {
        if (! empty($filters['date_from'])) {
            return Carbon::parse(
                $filters['date_from']
            )->startOfDay();
        }

        return now()->startOfMonth();
    }

    /**
     * |--------------------------------------------------------------------------
     * | Resolve Date To
     * |--------------------------------------------------------------------------
     */
    protected function resolveDateTo(array $filters): Carbon
    {
        if (! empty($filters['date_to'])) {
            return Carbon::parse(
                $filters['date_to']
            )->endOfDay();
        }

        return now()->endOfDay();
    }

    protected function writeFinancialPosition($handle): void
    {
        $position =
            $this->report['financial_position']
                ?? [];

        fputcsv($handle, [
            'FINANCIAL POSITION',
        ]);

        fputcsv($handle, [
            'Metric',
            'Amount',
        ]);

        fputcsv($handle, [
            'Net Revenue',
            $this->number(
                $position['net_revenue'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Net Cost of Goods Sold',
            $this->number(
                $position['net_cogs'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Gross Profit',
            $this->number(
                $position['gross_profit'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Inventory Loss',
            $this->number(
                $position['inventory_loss'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Operating Result',
            $this->number(
                $position['operating_result'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Gross Margin',
            $this->percentage(
                $position['gross_margin'] ?? 0
            ),
        ]);

        fputcsv($handle, [
            'Operating Margin',
            $this->percentage(
                $position['operating_margin'] ?? 0
            ),
        ]);

        fputcsv($handle, []);
    }
}

