<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\ProductCategory;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use App\Exports\Reports\SalesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class SalesReportService
{
    /*
    |--------------------------------------------------------------------------
    | Default Pagination
    |--------------------------------------------------------------------------
    */

    protected int $defaultPerPage = 25;

    /**
     * Get filter options available to the current user.
     *
     * The filter lists are intentionally normalized into simple arrays so
     * the Blade and JavaScript layers do not depend on Eloquent model
     * structures.
     *
     * Branch visibility:
     * - Owner / Administrator: all company branches.
     * - Branch Manager: assigned branch only.
     * - Cashier: assigned branch only.
     *
     * Cashiers:
     * - Loaded for all visible branches.
     * - JavaScript will filter the cashier dropdown when a branch is selected.
     *
     * Customers:
     * - Customer registration branch is determined through created_by -> User -> branch_id.
     * - Loaded for all visible branches.
     * - JavaScript will filter the customer dropdown when a branch is selected.
     *
     * Payment methods:
     * - Fixed EMNEX POS payment methods.
     */
    public function getFilters(
        int $companyId,
        $user
    ): array {
        /*
        |--------------------------------------------------------------------------
        | BRANCHES
        |--------------------------------------------------------------------------
        */

        $branchesQuery = Branch::query()
            ->where('company_id', $companyId)
            ->orderBy('name');

        /*
        |--------------------------------------------------------------------------
        | ROLE-BASED BRANCH SCOPE
        |--------------------------------------------------------------------------
        */

        if (
            ! $user->isOwner()
            && ! $user->hasRole('administrator')
        ) {
            if ($user->hasRole('branch_manager')) {
                $branchesQuery->where(
                    'id',
                    $user->branch_id
                );
            } elseif ($user->hasRole('cashier')) {
                $branchesQuery->where(
                    'id',
                    $user->branch_id
                );
            }
        }

        $branches = $branchesQuery
            ->get([
                'id',
                'name',
            ])
            ->map(function ($branch) {
                return [
                    'id' => (int) $branch->id,
                    'name' => $branch->name,
                ];
            })
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | VISIBLE BRANCH IDS
        |--------------------------------------------------------------------------
        */

        $visibleBranchIds = collect($branches)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | CASHIERS
        |--------------------------------------------------------------------------
        |
        | We load all cashiers belonging to visible branches.
        | The frontend can then dynamically filter them when the user
        | changes the Branch filter.
        |
        */

        $cashiers = User::query()
            ->where('company_id', $companyId)
            ->where('status', true)
            ->whereHas('role', function ($query) {
                $query->whereIn('code', [
                    'cashier',
                ]);
            })
            ->when(
                ! empty($visibleBranchIds),
                function ($query) use ($visibleBranchIds) {
                    $query->whereIn(
                        'branch_id',
                        $visibleBranchIds
                    );
                }
            )
            ->with('branch:id,name')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get([
                'id',
                'branch_id',
                'first_name',
                'last_name',
                'other_name',
            ])
            ->map(function ($cashier) {
                return [
                    'id' => (int) $cashier->id,
                    'branch_id' => $cashier->branch_id
                        ? (int) $cashier->branch_id
                        : null,
                    'name' => $cashier->fullName,
                    'branch_name' => $cashier->branch?->name,
                ];
            })
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | PAYMENT METHODS
        |--------------------------------------------------------------------------
        |
        | These are the actual POS payment method values stored on payments.
        | Do not load PaymentMethod records here because the report filters
        | by payments.payment_method.
        |
        */

        $paymentMethods = [
            [
                'value' => 'Cash',
                'label' => 'Cash',
            ],
            [
                'value' => 'Transfer',
                'label' => 'Transfer',
            ],
            [
                'value' => 'Card',
                'label' => 'Card',
            ],
            [
                'value' => 'Wallet',
                'label' => 'Wallet',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | CUSTOMERS
        |--------------------------------------------------------------------------
        |
        | Customer does not have branch_id.
        |
        | Registration branch is determined through:
        |
        | customer.created_by
        |      -> User
        |      -> branch_id
        |
        */

        $customers = Customer::query()
            ->where('company_id', $companyId)
            ->with([
                'createdBy:id,branch_id,first_name,last_name,other_name',
            ])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get([
                'id',
                'company_id',
                'first_name',
                'last_name',
                'created_by',
            ])
            ->map(function ($customer) {

                $registrationBranchId =
                    $customer->createdBy?->branch_id;

                return [
                    'id' => (int) $customer->id,

                    'name' => $customer->displayName(),

                    'branch_id' => $registrationBranchId
                        ? (int) $registrationBranchId
                        : null,
                ];
            })
            ->filter(function ($customer) use ($visibleBranchIds) {

                /*
                |--------------------------------------------------------------------------
                | Customers without a registration branch
                |--------------------------------------------------------------------------
                |
                | Keep them visible for company-wide owner/admin reporting,
                | but don't expose them to a branch-specific selector where
                | their branch cannot be established.
                |
                */

                if ($customer['branch_id'] === null) {
                    return true;
                }

                return in_array(
                    $customer['branch_id'],
                    $visibleBranchIds,
                    true
                );
            })
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        $categories = ProductCategory::query()
            ->where('company_id', $companyId)
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ])
            ->map(function ($category) {
                return [
                    'id' => (int) $category->id,
                    'name' => $category->name,
                ];
            })
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */

        $products = Product::query()
            ->where('company_id', $companyId)
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ])
            ->map(function ($product) {
                return [
                    'id' => (int) $product->id,
                    'name' => $product->name,
                ];
            })
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | SALES CHANNELS
        |--------------------------------------------------------------------------
        */

        $salesChannels = [
            [
                'value' => 'POS',
                'label' => 'POS',
            ],
            [
                'value' => 'Online',
                'label' => 'Online',
            ],
            [
                'value' => 'Phone',
                'label' => 'Phone',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | RETURN FILTER DATA
        |--------------------------------------------------------------------------
        */

        return [
            'branches' => $branches,

            'cashiers' => $cashiers,

            'payment_methods' => $paymentMethods,

            'customers' => $customers,

            'categories' => $categories,

            'products' => $products,

            'sales_channels' => $salesChannels,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Sales Report
    |--------------------------------------------------------------------------
    */

    public function generate(
        array $filters,
        ?User $user = null
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Normalise Filters
        |--------------------------------------------------------------------------
        */

        $filters = $this->normaliseFilters($filters);

        $companyId = (int) $filters['company_id'];

        if (
            ! empty($filters['transaction_id']) &&
            ! empty($filters['details'])
        ) {
            return [
                'transaction' => $this->buildTransactionDetails(
                    (int) $filters['transaction_id'],
                    $companyId,
                    $user
                ),
            ];
        }

       
        /*
        |--------------------------------------------------------------------------
        | Transaction Inspector
        |--------------------------------------------------------------------------
        |
        | When a transaction_id is supplied with details=1, return only the
        | requested transaction details. This avoids rebuilding the entire
        | sales report when the inspector is opened.
        |
        */

        if (
            ! empty($filters['transaction_id']) &&
            ! empty($filters['details'])
        ) {
            return [
                'transaction' => $this->buildTransactionDetails(
                    (int) $filters['transaction_id'],
                    $companyId,
                    $user
                ),
            ];
        }



        /*
        |--------------------------------------------------------------------------
        | Base Completed Orders Query
        |--------------------------------------------------------------------------
        |
        | Held, Pending and Draft orders must not be counted as sales.
        |
        */

        $ordersQuery = Order::query()
            ->forCompany($companyId)
            ->completed();

        /*
        |--------------------------------------------------------------------------
        | Role / Branch Scope
        |--------------------------------------------------------------------------
        */

        $this->applyOrderScope(
            $ordersQuery,
            $user
        );

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        $this->applyDateFilter(
            $ordersQuery,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Standard Order Filters
        |--------------------------------------------------------------------------
        */

        $this->applyOrderFilters(
            $ordersQuery,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Product / Category Filters
        |--------------------------------------------------------------------------
        |
        | These filters are applied through order_items.
        |
        */

        $this->applyProductFilters(
            $ordersQuery,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Payment Method Filter
        |--------------------------------------------------------------------------
        |
        | Payment method belongs to Payment rather than Order.
        |
        */

        if (! empty($filters['payment_method'])) {
            $paymentMethod = $filters['payment_method'];

            $ordersQuery->whereHas('payments', function (Builder $query) use ($paymentMethod) {
                $query
                    ->completed()
                    ->where('payment_method', $paymentMethod);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Clone Base Query
        |--------------------------------------------------------------------------
        |
        | The same scoped query is reused for all report sections.
        |
        */

        $overviewQuery = clone $ordersQuery;
        $trendQuery = clone $ordersQuery;
        $categoryQuery = clone $ordersQuery;
        $cashierQuery = clone $ordersQuery;
        $customerQuery = clone $ordersQuery;
        $transactionQuery = clone $ordersQuery;

        /*
        |--------------------------------------------------------------------------
        | Overview
        |--------------------------------------------------------------------------
        */

        $overview = $this->buildOverview(
            $overviewQuery,
            $companyId,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Charts
        |--------------------------------------------------------------------------
        */

        $salesTrend = $this->buildSalesTrend(
            $trendQuery,
            $filters
        );

        $paymentDistribution = $this->buildPaymentDistribution(
            $companyId,
            $filters,
            $user
        );

        $categorySales = $this->buildCategorySales(
            $categoryQuery,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Performance Tables
        |--------------------------------------------------------------------------
        */

        $products = $this->buildProductPerformance(
            $companyId,
            $filters,
            $user
        );       

        $categories = $this->buildCategoryPerformance(
            $categoryQuery
        );

        $payments = $this->buildPaymentPerformance(
            $companyId,
            $filters,
            $user
        );

        $cashiers = $this->buildCashierPerformance(
            $cashierQuery
        );

        $customers = $this->buildCustomerPerformance(
            $customerQuery
        );

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */

        $transactions = $this->buildTransactions(
            $transactionQuery,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Response Contract
        |--------------------------------------------------------------------------
        */

        return [
            'filters' => [
                'date_from' => $filters['date_from'],
                'date_to' => $filters['date_to'],
            ],

            'stats' => $overview,

            'charts' => [
                'trend' => $salesTrend,

                'payments' => $paymentDistribution,

                'categories' => $categorySales,
            ],

            'products' => $products,

            'categories' => $categories,

            'payments' => $payments,

            'cashiers' => $cashiers,

            'customers' => $customers,

            'transactions' => $transactions,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Overview
    |--------------------------------------------------------------------------
    */

    protected function buildOverview(
        Builder $query,
        int $companyId,
        array $filters
    ): array {
        $totals = (clone $query)
            ->selectRaw('
                COALESCE(SUM(subtotal), 0) AS subtotal,
                COALESCE(SUM(discount), 0) AS discount,
                COALESCE(SUM(tax), 0) AS tax,
                COALESCE(SUM(total), 0) AS total,
                COALESCE(SUM(grand_total), 0) AS grand_total,
                COUNT(*) AS transactions
            ')
            ->first();

        $grossSales = (float) ($totals->subtotal ?? 0);
        $discounts = (float) ($totals->discount ?? 0);
        $tax = (float) ($totals->tax ?? 0);
        $netSales = (float) ($totals->grand_total ?? 0);
        $transactions = (int) ($totals->transactions ?? 0);

        $averageOrderValue = $transactions > 0
            ? $netSales / $transactions
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Returns
        |--------------------------------------------------------------------------
        */

        $returnsQuery = Order::query()
            ->forCompany($companyId)
            ->whereIn('order_status', ['Refunded', 'Returned']);

        $this->applyOrderScope($returnsQuery, request()->user());
        $this->applyDateFilter($returnsQuery, $filters);

        $returns = (float) $returnsQuery->sum('grand_total');

        /*
        |--------------------------------------------------------------------------
        | Cost of Goods Sold / Gross Profit
        |--------------------------------------------------------------------------
        |
        | unit_cost is the historical product cost snapshot stored on each
        | order item when the order is created/updated.
        |
        | This prevents historical profit from changing when the product's
        | current cost_price is changed later.
        |
        */

        $orderIds = (clone $query)->select('id');

        $costs = OrderItem::query()
            ->whereIn('order_id', $orderIds)
            ->selectRaw('
                COALESCE(SUM(quantity * unit_cost), 0) AS cogs
            ')
            ->first();

        $cogs = (float) ($costs->cogs ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Gross Profit
        |--------------------------------------------------------------------------
        |
        | Use the report's existing net sales figure so the profit KPI remains
        | consistent with the sales figures already shown by the report.
        |
        */

        $profit = $netSales - $cogs;

        return [
            'gross_sales' => round($grossSales, 2),
            'net_sales' => round($netSales, 2),
            'transactions' => $transactions,
            'average_order_value' => round($averageOrderValue, 2),
            'discounts' => round($discounts, 2),
            'tax' => round($tax, 2),
            'returns' => round($returns, 2),

            'cogs' => round($cogs, 2),
            'profit' => round($profit, 2),
            'profit_available' => true,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Sales Trend
    |--------------------------------------------------------------------------
    */

    protected function buildSalesTrend(
        Builder $query,
        array $filters
    ): array {
        $dateFrom = Carbon::parse(
            $filters['date_from']
        )->startOfDay();

        $dateTo = Carbon::parse(
            $filters['date_to']
        )->endOfDay();

        $days = $dateFrom->diffInDays(
            $dateTo
        );

        /*
        |--------------------------------------------------------------------------
        | Determine Grouping
        |--------------------------------------------------------------------------
        |
        | Short periods use daily grouping.
        | Longer periods use monthly grouping.
        |
        */

        if ($days <= 1) {
            $groupFormat = '%Y-%m-%d %H:00:00';
            $labelFormat = 'H:00';
            $groupBy = 'hour';
        } elseif ($days <= 31) {
            $groupFormat = '%Y-%m-%d';
            $labelFormat = 'd M';
            $groupBy = 'day';
        } elseif ($days <= 120) {
            $groupFormat = '%Y-%m-%d';
            $labelFormat = 'd M';
            $groupBy = 'day';
        } else {
            $groupFormat = '%Y-%m';
            $labelFormat = 'M Y';
            $groupBy = 'month';
        }

        /*
        |--------------------------------------------------------------------------
        | Database Aggregation
        |--------------------------------------------------------------------------
        */

        $rows = $query
            ->whereBetween(
                'completed_at',
                [
                    $dateFrom,
                    $dateTo,
                ]
            )
            ->selectRaw("
                DATE_FORMAT(completed_at, '{$groupFormat}') AS period,
                COALESCE(SUM(grand_total), 0) AS total
            ")
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Build Complete Date Series
        |--------------------------------------------------------------------------
        |
        | Empty periods are included so the chart doesn't visually jump
        | between dates with no sales.
        |
        */

        $labels = [];

        $values = [];

        $cursor = $dateFrom->copy();

        while ($cursor <= $dateTo) {

            if ($groupBy === 'hour') {
                $period = $cursor->format('Y-m-d H:00:00');
                $label = $cursor->format($labelFormat);

                $cursor->addHour();
            } elseif ($groupBy === 'day') {
                $period = $cursor->format('Y-m-d');
                $label = $cursor->format($labelFormat);

                $cursor->addDay();
            } else {
                $period = $cursor->format('Y-m');
                $label = $cursor->format($labelFormat);

                $cursor->addMonth();
            }

            $labels[] = $label;

            $row = $rows->firstWhere(
                'period',
                $period
            );

            $values[] = round(
                (float) ($row->total ?? 0),
                2
            );
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Payment Distribution
    |--------------------------------------------------------------------------
    */

    protected function buildPaymentDistribution(
        int $companyId,
        array $filters,
        ?User $user
    ): array {
        $query = Payment::query()
            ->forCompany($companyId)
            ->completed();

        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        */

        $query->whereBetween(
            'payment_date',
            [
                Carbon::parse(
                    $filters['date_from']
                )->startOfDay(),

                Carbon::parse(
                    $filters['date_to']
                )->endOfDay(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Branch Scope
        |--------------------------------------------------------------------------
        */

        $this->applyPaymentScope(
            $query,
            $user
        );

        /*
        |--------------------------------------------------------------------------
        | Standard Filters
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['branch_id'])) {
            $query->where(
                'branch_id',
                $filters['branch_id']
            );
        }

        if (! empty($filters['cashier_id'])) {
            $query->where(
                'received_by',
                $filters['cashier_id']
            );
        }

        if (! empty($filters['payment_method'])) {
            $query->where(
                'payment_method',
                $filters['payment_method']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Aggregate
        |--------------------------------------------------------------------------
        */

        return $query
            ->select(
                'payment_method'
            )
            ->selectRaw(
                'COALESCE(SUM(amount), 0) AS amount'
            )
            ->groupBy(
                'payment_method'
            )
            ->orderByDesc(
                'amount'
            )
            ->get()
            ->map(function ($row) {
                return [
                    'label' => $row->payment_method ?: 'Unknown',
                    'value' => round(
                        (float) $row->amount,
                        2
                    ),
                ];
            })
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Category Sales Chart
    |--------------------------------------------------------------------------
    */

    protected function buildCategorySales(
        Builder $query,
        array $filters
    ): array {
        $rows = (clone $query)
            ->with([
                'orderItems.product.category',
            ])
            ->get();

        $categories = [];

        foreach ($rows as $order) {
            foreach ($order->orderItems as $item) {

                $category = $item->product?->category;

                $categoryId = $category?->id ?? 0;

                $categoryName = $category?->name
                    ?? 'Uncategorised';

                if (! isset($categories[$categoryId])) {
                    $categories[$categoryId] = [
                        'label' => $categoryName,
                        'value' => 0,
                    ];
                }

                $categories[$categoryId]['value'] +=
                    (float) $item->total;
            }
        }

        return collect($categories)
            ->sortByDesc('value')
            ->values()
            ->map(function ($row) {
                $row['value'] = round(
                    $row['value'],
                    2
                );

                return $row;
            })
            ->all();
    }

    /**
     * |--------------------------------------------------------------------------
     * | Product Performance
     * |--------------------------------------------------------------------------
     */
    protected function buildProductPerformance(
        int $companyId,
        array $filters,
        ?User $user
    ): array {

        $query = OrderItem::query()
            ->forCompany($companyId)
            ->whereHas('order', function (Builder $orderQuery) use (
                $filters,
                $user
            ) {
                $orderQuery
                    ->completed();

                $this->applyOrderScope(
                    $orderQuery,
                    $user
                );

                $this->applyDateFilter(
                    $orderQuery,
                    $filters
                );

                $this->applyOrderFilters(
                    $orderQuery,
                    $filters
                );
            })
           ->with('product.category');

        /*
        |--------------------------------------------------------------------------
        | Product Filter
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['product_id'])) {

            $query->where(
                'product_id',
                $filters['product_id']
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if (! empty($filters['category_id'])) {

            $query->whereHas(
                'product',
                function (Builder $productQuery) use ($filters) {

                    $productQuery->where(
                        'category_id',
                        $filters['category_id']
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Aggregate Product Performance
        |--------------------------------------------------------------------------
        */

        return $query
            ->select(
                'product_id',
                'product_name'
            )
            ->selectRaw(
                'SUM(quantity) AS quantity'
            )
            ->selectRaw(
                'SUM(discount) AS discount'
            )
            ->selectRaw(
                'SUM(tax) AS tax'
            )
            ->selectRaw(
                'SUM(total) AS total'
            )
            ->selectRaw(
                'SUM(quantity * unit_cost) AS cogs'
            )
            ->groupBy(
                'product_id',
                'product_name'
            )
            ->orderByDesc(
                'total'
            )
            ->limit(20)
            ->get()
            ->map(function ($row) {

                $quantity = (float) $row->quantity;

                $discount = (float) $row->discount;

                $tax = (float) $row->tax;

                $total = (float) $row->total;

                $cogs = (float) $row->cogs;

                /*
                |--------------------------------------------------------------------------
                | Revenue
                |--------------------------------------------------------------------------
                |
                | Product revenue is the selling value before tax.
                |
                | total currently contains:
                |
                | selling value - discount + tax
                |
                | Therefore remove tax to get revenue.
                |
                */

                $revenue = $total - $tax;

                /*
                |--------------------------------------------------------------------------
                | Gross Profit
                |--------------------------------------------------------------------------
                */

                $grossProfit = $revenue - $cogs;

                /*
                |--------------------------------------------------------------------------
                | Margin
                |--------------------------------------------------------------------------
                */

                $margin = $revenue > 0
                    ? ($grossProfit / $revenue) * 100
                    : 0;

                return [
                    'product_id' => (int) $row->product_id,

                    'name' => $row->product_name,

                    'product_name' => $row->product_name,

                    'category' => $row->product?->category?->name
                     ?? 'Uncategorised',

                    'quantity' => round(
                        $quantity,
                        2
                    ),

                    'units_sold' => round(
                        $quantity,
                        2
                    ),

                    'revenue' => round(
                        $revenue,
                        2
                    ),

                    'cogs' => round(
                        $cogs,
                        2
                    ),

                    'gross_profit' => round(
                        $grossProfit,
                        2
                    ),

                    'margin' => round(
                        $margin,
                        2
                    ),

                    'discount' => round(
                        $discount,
                        2
                    ),

                    'tax' => round(
                        $tax,
                        2
                    ),

                    'total' => round(
                        $total,
                        2
                    ),
                ];
            })
            ->all();
    }

    /**
     * |--------------------------------------------------------------------------
     * | Category Performance
     * |--------------------------------------------------------------------------
     */
    protected function buildCategoryPerformance(
        Builder $query
    ): array {

        $orders = $query
            ->with([
                'orderItems.product.category',
            ])
            ->get();

        $categories = [];

        foreach ($orders as $order) {

            foreach ($order->orderItems as $item) {

                $category = $item->product?->category;

                $categoryId = $category?->id ?? 0;

                $categoryName = $category?->name
                    ?? 'Uncategorised';

                if (! isset($categories[$categoryId])) {

                    $categories[$categoryId] = [

                        'category_id' => $categoryId,

                        'name' => $categoryName,

                        'products' => [],

                        'orders' => [],

                        'quantity' => 0,

                        'discount' => 0,

                        'gross_sales' => 0,

                        'net_sales' => 0,

                        'tax' => 0,
                    ];
                }

                /*
                * ----------------------------------------------------------
                * Product Tracking
                * ----------------------------------------------------------
                */

                if ($item->product_id) {

                    $categories[$categoryId]['products'][
                        $item->product_id
                    ] = true;
                }

                /*
                * ----------------------------------------------------------
                * Order Tracking
                * ----------------------------------------------------------
                */

                if ($order->id) {

                    $categories[$categoryId]['orders'][
                        $order->id
                    ] = true;
                }

                /*
                * ----------------------------------------------------------
                * Units Sold
                * ----------------------------------------------------------
                */

                $categories[$categoryId]['quantity'] +=
                    (float) $item->quantity;

                /*
                * ----------------------------------------------------------
                * Discount
                * ----------------------------------------------------------
                */

                $categories[$categoryId]['discount'] +=
                    (float) $item->discount;

                /*
                * ----------------------------------------------------------
                * Gross Sales
                *
                * Unit price × quantity represents the line value
                * before discount.
                * ----------------------------------------------------------
                */

                $grossSales =
                    ((float) $item->unit_price)
                    * ((float) $item->quantity);

                $categories[$categoryId]['gross_sales'] +=
                    $grossSales;

                /*
                * ----------------------------------------------------------
                * Net Sales
                *
                * Gross sales less line discount.
                * ----------------------------------------------------------
                */

                $categories[$categoryId]['net_sales'] +=
                    $grossSales
                    - (float) $item->discount;

                /*
                * ----------------------------------------------------------
                * Tax
                * ----------------------------------------------------------
                */

                $categories[$categoryId]['tax'] +=
                    (float) $item->tax;
            }
        }

        /*
        * |--------------------------------------------------------------------------
        * | Calculate Total Net Sales
        * |--------------------------------------------------------------------------
        */

        $totalNetSales = collect($categories)
            ->sum('net_sales');

        /*
        * |--------------------------------------------------------------------------
        * | Format Response
        * |--------------------------------------------------------------------------
        */

        return collect($categories)
            ->sortByDesc('net_sales')
            ->values()
            ->map(function ($row) use ($totalNetSales) {

                $products = count(
                    $row['products']
                );

                $orders = count(
                    $row['orders']
                );

                $quantity = round(
                    $row['quantity'],
                    2
                );

                $grossSales = round(
                    $row['gross_sales'],
                    2
                );

                $discount = round(
                    $row['discount'],
                    2
                );

                $netSales = round(
                    $row['net_sales'],
                    2
                );

                $percentage = $totalNetSales > 0
                    ? ($netSales / $totalNetSales) * 100
                    : 0;

                return [

                    'category_id' => $row['category_id'],

                    'name' => $row['name'],

                    'products' => $products,

                    'units_sold' => $quantity,

                    'orders' => $orders,

                    'gross_sales' => $grossSales,

                    'discount' => $discount,

                    'net_sales' => $netSales,

                    'percentage' => round(
                        $percentage,
                        2
                    ),

                ];
            })
            ->all();
    }


    /**
     * |--------------------------------------------------------------------------
     * | Payment Performance
     * |--------------------------------------------------------------------------
     */
    protected function buildPaymentPerformance(
        int $companyId,
        array $filters,
        ?User $user
    ): array {

        $query = Payment::query()
            ->forCompany($companyId)
            ->completed()
            ->whereBetween(
                'payment_date',
                [
                    Carbon::parse(
                        $filters['date_from']
                    )->startOfDay(),

                    Carbon::parse(
                        $filters['date_to']
                    )->endOfDay(),
                ]
            );

        $this->applyPaymentScope(
            $query,
            $user
        );

        if (! empty($filters['branch_id'])) {
            $query->where(
                'branch_id',
                $filters['branch_id']
            );
        }

        if (! empty($filters['cashier_id'])) {
            $query->where(
                'received_by',
                $filters['cashier_id']
            );
        }

        if (! empty($filters['payment_method'])) {
            $query->where(
                'payment_method',
                $filters['payment_method']
            );
        }

        /*
        * ----------------------------------------------------------
        * Aggregate Payment Methods
        * ----------------------------------------------------------
        */

        $payments = $query
            ->select(
                'payment_method'
            )
            ->selectRaw(
                'COUNT(*) AS transactions'
            )
            ->selectRaw(
                'SUM(amount) AS amount'
            )
            ->groupBy(
                'payment_method'
            )
            ->orderByDesc(
                'amount'
            )
            ->get();

        /*
        * ----------------------------------------------------------
        * Total Payment Amount
        * ----------------------------------------------------------
        */

        $totalAmount = $payments->sum(
            fn ($row) => (float) $row->amount
        );

        /*
        * ----------------------------------------------------------
        * Build Response
        * ----------------------------------------------------------
        */

        return $payments
            ->map(function ($row) use ($totalAmount) {

                $amount = (float) $row->amount;

                $percentage = $totalAmount > 0
                    ? ($amount / $totalAmount) * 100
                    : 0;

                return [

                    'payment_method' =>
                        $row->payment_method,

                    'transactions' =>
                        (int) $row->transactions,

                    'amount' =>
                        round(
                            $amount,
                            2
                        ),

                    'percentage' =>
                        round(
                            $percentage,
                            2
                        ),
                ];
            })
            ->all();
    }



   
    /**
     * |--------------------------------------------------------------------------
     * | Salesperson Performance
     * |--------------------------------------------------------------------------
     */
    protected function buildCashierPerformance(
        Builder $query
    ): array {

        $rows = $query
            ->with('cashier.role')
            ->select(
                'cashier_id'
            )
            ->selectRaw(
                'COUNT(*) AS transactions'
            )
            ->selectRaw(
                'SUM(total_quantity) AS quantity'
            )
            ->selectRaw(
                'SUM(discount) AS discount'
            )
            ->selectRaw(
                'SUM(tax) AS tax'
            )
            ->selectRaw(
                'SUM(grand_total) AS total'
            )
            ->groupBy(
                'cashier_id'
            )
            ->orderByDesc(
                'total'
            )
            ->get();

        /*
        * ----------------------------------------------------------
        * Total Sales
        * ----------------------------------------------------------
        */

        $totalSales = $rows->sum(
            fn ($row) => (float) $row->total
        );

        /*
        * ----------------------------------------------------------
        * Build Response
        * ----------------------------------------------------------
        */

        return $rows
            ->map(function ($row) use ($totalSales) {

                $transactions = (int) $row->transactions;

                $total = (float) $row->total;

                $averageSale = $transactions > 0
                    ? $total / $transactions
                    : 0;

                $share = $totalSales > 0
                    ? ($total / $totalSales) * 100
                    : 0;

                return [

                    'cashier_id' =>
                        $row->cashier_id,

                    /*
                    * Although the database field remains
                    * cashier_id, this represents the actual
                    * salesperson/user who made the sale.
                    */
                    'name' => $row->cashier
                        ? trim(
                            $row->cashier->last_name . ' ' .
                            $row->cashier->first_name
                        )
                        : 'Unknown',

                    'role' => $row->cashier?->role?->name,

                    'transactions' =>
                        $transactions,

                    'quantity' =>
                        round(
                            (float) $row->quantity,
                            2
                        ),

                    'discount' =>
                        round(
                            (float) $row->discount,
                            2
                        ),

                    'tax' =>
                        round(
                            (float) $row->tax,
                            2
                        ),

                    'total' =>
                        round(
                            $total,
                            2
                        ),

                    'average_sale' =>
                        round(
                            $averageSale,
                            2
                        ),

                    'share' =>
                        round(
                            $share,
                            2
                        ),
                ];
            })
            ->all();
    }


   
    /**
     * |--------------------------------------------------------------------------
     * | Customer Performance
     * |--------------------------------------------------------------------------
     */
    protected function buildCustomerPerformance(
        Builder $query
    ): array {

        $rows = $query
            ->with('customer')
            ->select(
                'customer_id'
            )
            ->selectRaw(
                'COUNT(*) AS transactions'
            )
            ->selectRaw(
                'SUM(total_quantity) AS quantity'
            )
            ->selectRaw(
                'SUM(grand_total) AS total'
            )
            ->selectRaw(
                'SUM(discount) AS discount'
            )
            ->orderByDesc(
                'total'
            )
            ->groupBy(
                'customer_id'
            )
            ->limit(20)
            ->get();
      
        return $rows
            ->map(function ($row) {

                $transactions = (int) $row->transactions;

                $total = (float) $row->total;

                $averageOrder = $transactions > 0
                    ? $total / $transactions
                    : 0;

                return [

                    'customer_id' =>
                        $row->customer_id,

                    /*
                    * Saved customer
                    */
                    'customer' => $row->customer
                        ? $row->customer->displayName()
                        : 'Walk-in Customer',

                    /*
                    * Number of completed transactions
                    */
                    'transactions' =>
                        $transactions,

                    /*
                    * Total items/quantity purchased
                    */
                    'items' =>
                        round(
                            (float) $row->quantity,
                            2
                        ),

                    /*
                    * Discounts given
                    */
                    'discount' =>
                        round(
                            (float) $row->discount,
                            2
                        ),

                    /*
                    * Total sales
                    */
                    'total' =>
                        round(
                            $total,
                            2
                        ),

                    /*
                    * Average order value
                    */
                    'average_order' =>
                        round(
                            $averageOrder,
                            2
                        ),
                ];
            })
            ->all();
    }


    /*
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    */

    protected function buildTransactions(
        Builder $query,
        array $filters
    ): array {
        $perPage = $filters['per_page']
            ?: $this->defaultPerPage;

        $transactions = $query
            ->with([
                'branch',
                'cashier',
                'customer',
                'terminal',
                'payments',
            ])
            ->withCount('orderItems')
            ->orderByDesc(
                'completed_at'
            )
            ->paginate(
                $perPage
            );

        return [
            'data' => $transactions
                ->getCollection()
                ->map(function ($order) {

                    /* |-------------------------------------------------------------------------- 
                    | Payment Method |-------------------------------------------------------------------------- | 
                    | An order can have one or more payment records. | For the transaction report, display the payment method(s). 
                    | */ 
                    $paymentMethods = $order->payments 
                    ->pluck('payment_method') 
                    ->filter() 
                    ->unique() 
                    ->values(); 
                    $payment = $paymentMethods->isNotEmpty() ? $paymentMethods->implode(', ') : '—';
                    return [
                        'id' => $order->id,

                        'order_no' => $order->order_no,

                        'date' => $order->completed_at
                            ? $order->completed_at
                                ->format('Y-m-d H:i:s')
                            : null,

                       'customer' => $order->customer
                        ? $order->customer->displayName()
                        : 'Walk-in Customer',

                        'cashier' => $order->cashier
                            ? $this->userName(
                                $order->cashier
                            )
                            : 'Unknown',

                        'branch' => $order->branch
                            ? $order->branch->name
                            : 'Unknown',

                        'terminal' => $order->terminal
                            ? $order->terminal->name
                            : '—',

                        'items' => (int) $order->order_items_count,

                        'payment' => $payment,

                        'payment_status' =>
                            $order->payment_status,

                        'sales_channel' =>
                            $order->sales_channel,

                        'gross' => round(
                            (float) $order->subtotal,
                            2
                        ),

                        'discount' => round(
                            (float) $order->discount,
                            2
                        ),

                        'tax' => round(
                            (float) $order->tax,
                            2
                        ),

                        'total' => round(
                            (float) $order->grand_total,
                            2
                        ),

                        'status' =>
                            $order->order_status,
                    ];
                })
                ->values()
                ->all(),

            'current_page' =>
                $transactions->currentPage(),

            'last_page' =>
                $transactions->lastPage(),

            'per_page' =>
                $transactions->perPage(),

            'total' =>
                $transactions->total(),

            'from' =>
                $transactions->firstItem(),

            'to' =>
                $transactions->lastItem(),
        ];
    }

    /**
     * |--------------------------------------------------------------------------
     * | Transaction Export Rows
     * |--------------------------------------------------------------------------
     * |
     * | Returns all matching transactions for export.
     * | Unlike buildTransactions(), this is intentionally not paginated.
     * |
     */
    protected function buildTransactionExportRows(
        Builder $query
    ): array {
        $transactions = $query
            ->with([
                'branch',
                'cashier',
                'customer',
                'terminal',
                'payments' => function ($paymentQuery) {
                    $paymentQuery
                        ->completed()
                        ->orderBy('id');
                },
            ])
            ->orderByDesc('completed_at')
            ->get();

        return $transactions
            ->map(function ($order) {

                $paymentMethods = $order->payments
                    ->pluck('payment_method')
                    ->filter()
                    ->unique()
                    ->values();

                $payment = $paymentMethods->isNotEmpty()
                    ? $paymentMethods->implode(', ')
                    : '—';

                return [
                    'order_no' => $order->order_no,

                    'date' => $order->completed_at
                        ? $order->completed_at->format(
                            'Y-m-d H:i:s'
                        )
                        : null,

                    'customer' => $order->customer
                        ? $order->customer->displayName()
                        : 'Walk-in Customer',

                    'cashier' => $order->cashier
                        ? $this->userName(
                            $order->cashier
                        )
                        : 'Unknown',

                    'branch' => $order->branch
                        ? $order->branch->name
                        : 'Unknown',

                    'terminal' => $order->terminal
                        ? $order->terminal->terminal_name
                        : '—',

                    'payment' => $payment,

                    'gross' => round(
                        (float) $order->subtotal,
                        2
                    ),

                    'discount' => round(
                        (float) $order->discount,
                        2
                    ),

                    'tax' => round(
                        (float) $order->tax,
                        2
                    ),

                    'total' => round(
                        (float) $order->grand_total,
                        2
                    ),

                    'status' => $order->order_status,
                ];
            })
            ->values()
            ->all();
    }

    /*
    |--------------------------------------------------------------------------
    | Transaction Inspector
    |--------------------------------------------------------------------------
    |
    | This method is intentionally separate so the frontend can request
    | one transaction without loading the entire transaction dataset.
    |
    */

    public function transaction(
        int $companyId,
        int $transactionId,
        ?User $user = null
    ): ?array {
        $query = Order::query()
            ->forCompany($companyId)
            ->completed()
            ->where(
                'id',
                $transactionId
            )
            ->with([
                'branch',
                'terminal',
                'customer',
                'cashier',
                'orderItems.product.category',
                'payments',
            ]);

        $this->applyOrderScope(
            $query,
            $user
        );

        $order = $query->first();

        if (! $order) {
            return null;
        }

        return [
            'id' => $order->id,

            'order_no' => $order->order_no,

            'date' => $order->completed_at
                ? $order->completed_at
                    ->format('Y-m-d H:i:s')
                : null,

            'status' => $order->order_status,

            'payment_status' =>
                $order->payment_status,

            'sales_channel' =>
                $order->sales_channel,

            'customer' => $order->customer
            ? $order->customer->displayName()
            : 'Walk-in Customer',

            'cashier' => $order->cashier
                ? $this->userName(
                    $order->cashier
                )
                : 'Unknown',

            'branch' => $order->branch
                ? $order->branch->name
                : 'Unknown',

            'terminal' => $order->terminal
                ? $order->terminal->name
                : '—',

            'items' => $order->orderItems
                ->map(function ($item) {
                    return [
                        'product_id' =>
                            $item->product_id,

                        'product_name' =>
                            $item->product_name,

                        'barcode' =>
                            $item->product_barcode,

                        'quantity' => round(
                            (float) $item->quantity,
                            2
                        ),

                        'unit_price' => round(
                            (float) $item->unit_price,
                            2
                        ),

                        'discount' => round(
                            (float) $item->discount,
                            2
                        ),

                        'tax' => round(
                            (float) $item->tax,
                            2
                        ),

                        'total' => round(
                            (float) $item->total,
                            2
                        ),
                    ];
                })
                ->values()
                ->all(),

            'payments' => $order->payments
                ->map(function ($payment) {
                    return [
                        'payment_number' =>
                            $payment->payment_number,

                        'payment_method' =>
                            $payment->payment_method,

                        'reference_no' =>
                            $payment->reference_no,

                        'transaction_reference' =>
                            $payment->transaction_reference,

                        'amount' => round(
                            (float) $payment->amount,
                            2
                        ),

                        'payment_status' =>
                            $payment->payment_status,

                        'payment_date' =>
                            $payment->payment_date
                                ? $payment->payment_date
                                    ->format(
                                        'Y-m-d H:i:s'
                                    )
                                : null,
                    ];
                })
                ->values()
                ->all(),

            'totals' => [
                'gross' => round(
                    (float) $order->subtotal,
                    2
                ),

                'discount' => round(
                    (float) $order->discount,
                    2
                ),

                'tax' => round(
                    (float) $order->tax,
                    2
                ),

                'total' => round(
                    (float) $order->grand_total,
                    2
                ),

                'amount_paid' => round(
                    (float) $order->amount_paid,
                    2
                ),

                'balance' => round(
                    (float) $order->balance,
                    2
                ),

                'change_given' => round(
                    (float) $order->change_given,
                    2
                ),
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Export
    |--------------------------------------------------------------------------
    |
    | CSV is implemented without requiring an additional package.
    |
    | XLSX/PDF should be connected to the project's existing export
    | packages once those packages are confirmed.
    |
    */

    public function export(
        array $filters,
        ?User $user = null
    ) {
        $filters = $this->normaliseFilters($filters);

         return match ($filters['format']) {
            'xlsx' => $this->exportXlsx(
                $filters,
                $user
            ),

            'csv' => $this->exportCsv(
                $filters,
                $user
            ),

            'pdf' => $this->exportPdf(
                $filters,
                $user
            ),

            default => abort(
                501,
                'This export format has not yet been configured.'
            ),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | CSV Export
    |--------------------------------------------------------------------------
    */

    /**
     * Export transaction-level sales data as CSV.
     */
    protected function exportCsv(
        array $filters,
        ?User $user = null
    ) {
        $query = Order::query()
            ->forCompany($filters['company_id'])
            ->completed();

        /*
        |--------------------------------------------------------------------------
        | Scope
        |--------------------------------------------------------------------------
        */

        $this->applyOrderScope(
            $query,
            $user
        );

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $this->applyDateFilter(
            $query,
            $filters
        );

        $this->applyOrderFilters(
            $query,
            $filters
        );

        $this->applyProductFilters(
            $query,
            $filters
        );

        /*
        |--------------------------------------------------------------------------
        | Payment Method Filter
        |--------------------------------------------------------------------------
        |
        | Payment filtering is done through whereHas() so payment rows do not
        | multiply the order records or affect transaction-level exports.
        |
        */

        if (! empty($filters['payment_method'])) {
            $query->whereHas(
                'payments',
                function (Builder $paymentQuery) use ($filters) {
                    $paymentQuery
                        ->completed()
                        ->where(
                            'payment_method',
                            $filters['payment_method']
                        );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filename
        |--------------------------------------------------------------------------
        */

        $dateFrom = $filters['date_from']
            ?? now()->format('Y-m-d');

        $dateTo = $filters['date_to']
            ?? now()->format('Y-m-d');

        $filename = sprintf(
            'sales-report-%s-to-%s.csv',
            $dateFrom,
            $dateTo
        );

        /*
        |--------------------------------------------------------------------------
        | CSV Response
        |--------------------------------------------------------------------------
        */

        return response()->streamDownload(
            function () use ($query) {
                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                |--------------------------------------------------------------------------
                | UTF-8 BOM
                |--------------------------------------------------------------------------
                |
                | Helps Excel correctly recognise UTF-8 CSV files.
                |
                */

                // fwrite(
                //     $handle,
                //     "\xEF\xBB\xBF"
                // );

                /*
                |--------------------------------------------------------------------------
                | Header
                |--------------------------------------------------------------------------
                */

                fputcsv(
                    $handle,
                    [
                        'Order No.',
                        'Date',
                        'Customer',
                        'Salesperson',
                        'Branch',
                        'Terminal',
                        'Payment',
                        'Gross Sales',
                        'Discount',
                        'Tax',
                        'Total',
                        'Status',
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | Transactions
                |--------------------------------------------------------------------------
                */

                $query
                    ->with([
                        'branch',
                        'cashier',
                        'customer',
                         'terminal',
                        'payments' => function ($paymentQuery) {
                            $paymentQuery
                                ->completed()
                                ->orderBy('id');
                        },
                    ])
                    ->orderByDesc('completed_at')
                    ->chunkById(
                        500,
                        function ($orders) use ($handle) {
                            foreach ($orders as $order) {
                                /*
                                |--------------------------------------------------------------------------
                                | Customer
                                |--------------------------------------------------------------------------
                                */

                                $customer = $order->customer
                                    ? $order->customer->displayName()
                                    : 'Walk-in Customer';

                                /*
                                |--------------------------------------------------------------------------
                                | Salesperson
                                |--------------------------------------------------------------------------
                                */

                                $salesperson = $this->userName(
                                    $order->cashier
                                );

                                /*
                                |--------------------------------------------------------------------------
                                | Payment Methods
                                |--------------------------------------------------------------------------
                                */

                                $paymentMethods = $order->payments
                                    ->pluck('payment_method')
                                    ->filter()
                                    ->unique()
                                    ->values()
                                    ->implode(', ');

                                if ($paymentMethods === '') {
                                    $paymentMethods = '—';
                                }

                                /*
                                |--------------------------------------------------------------------------
                                | Date
                                |--------------------------------------------------------------------------
                                */

                                $date = $order->completed_at
                                    ? $order->completed_at->format(
                                        'Y-m-d H:i:s'
                                    )
                                    : '—';

                                /*
                                |--------------------------------------------------------------------------
                                | CSV Row
                                |--------------------------------------------------------------------------
                                */

                                fputcsv(
                                    $handle,
                                    [
                                        $order->order_no,
                                        $date,
                                        $customer,
                                        $salesperson,
                                        $order->branch?->name ?? '—',
                                        $order->terminal?->terminal_name ?? '—',
                                        $paymentMethods,
                                        number_format(
                                            (float) $order->subtotal,
                                            2,
                                            '.',
                                            ''
                                        ),
                                        number_format(
                                            (float) $order->discount,
                                            2,
                                            '.',
                                            ''
                                        ),
                                        number_format(
                                            (float) $order->tax,
                                            2,
                                            '.',
                                            ''
                                        ),
                                        number_format(
                                            (float) $order->grand_total,
                                            2,
                                            '.',
                                            ''
                                        ),
                                        $order->order_status ?? '—',
                                    ]
                                );
                            }
                        }
                    );

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }

    
    /**
     * Export the sales report as PDF.
     */
    protected function exportPdf(
        array $filters,
        ?User $user = null
    ) {
        $filters = $this->normaliseFilters($filters);

        $companyId = (int) $filters['company_id'];

        $report = $this->generate(
            $filters,
            $user
        );

        $company = Company::query()
            ->whereKey($companyId)
            ->first();

        $dateFrom = $filters['date_from']
            ?? now()->format('Y-m-d');

        $dateTo = $filters['date_to']
            ?? now()->format('Y-m-d');

        $filename = sprintf(
            'sales-report-%s-to-%s.pdf',
            $dateFrom,
            $dateTo
        );

        $pdf = app('dompdf.wrapper');

        $pdf->loadView(
            'reports.sales.pdf',
            [
                'company' => $company,
                'report' => $report,
                'filters' => $filters,
                'user' => $user,
            ]
        );

        $pdf->setPaper(
            'a4',
            'landscape'
        );

        return $pdf->download(
            $filename
        );
    }

     /**
     * Export the sales report as Excel.
     */

    protected function exportXlsx(
        array $filters,
        ?User $user = null
    ) {
        $filters = $this->normaliseFilters(
            $filters
        );

        $companyId = (int) $filters['company_id'];

        /*
        * Build the same report data used by the
        * Sales Report dashboard.
        *
        * This keeps the Excel export aligned with
        * the existing report calculations instead
        * of duplicating them inside the export classes.
        */
        $report = $this->generate(
            $filters,
            $user
        );

        /*
        * Build the transaction query separately.
        *
        * The dashboard transaction table is paginated,
        * but an Excel export must contain ALL matching
        * transactions.
        */
        $transactionQuery = Order::query()
            ->forCompany($companyId)
            ->completed();

        $this->applyOrderScope(
            $transactionQuery,
            $user
        );

        $this->applyDateFilter(
            $transactionQuery,
            $filters
        );

        $this->applyOrderFilters(
            $transactionQuery,
            $filters
        );

        $this->applyProductFilters(
            $transactionQuery,
            $filters
        );

        /*
        * Payment filtering must use whereHas()
        * so payment rows cannot multiply order
        * aggregates.
        */
        if (! empty($filters['payment_method'])) {
            $paymentMethod =
                $filters['payment_method'];

            $transactionQuery->whereHas(
                'payments',
                function (Builder $query) use (
                    $paymentMethod
                ) {
                    $query
                        ->completed()
                        ->where(
                            'payment_method',
                            $paymentMethod
                        );
                }
            );
        }

        /*
        * Add all matching transactions specifically
        * for the Excel Transactions worksheet.
        *
        * Do not modify the normal paginated
        * transactions response.
        */
        $report['transaction_export_rows'] =
            $this->buildTransactionExportRows(
                $transactionQuery
            );

        $dateFrom = $filters['date_from']
            ?? now()->format('Y-m-d');

        $dateTo = $filters['date_to']
            ?? now()->format('Y-m-d');

        $filename = sprintf(
            'sales-report-%s-to-%s.xlsx',
            $dateFrom,
            $dateTo
        );

        return Excel::download(
            new SalesReportExport(
                $report,
                $filters
            ),
            $filename
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Normalise Filters
    |--------------------------------------------------------------------------
    */

    protected function normaliseFilters(
        array $filters
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Default Date Range
        |--------------------------------------------------------------------------
        |
        | If the frontend does not supply dates, default to today.
        |
        */

        $dateFrom = ! empty(
            $filters['date_from']
        )
            ? Carbon::parse(
                $filters['date_from']
            )->toDateString()
            : now()->toDateString();

        $dateTo = ! empty(
            $filters['date_to']
        )
            ? Carbon::parse(
                $filters['date_to']
            )->toDateString()
            : now()->toDateString();

        return [
            'company_id' =>
                (int) ($filters['company_id'] ?? 0),

            'date_from' =>
                $dateFrom,

            'date_to' =>
                $dateTo,

            'branch_id' =>
                ! empty($filters['branch_id'])
                    ? (int) $filters['branch_id']
                    : null,

            'cashier_id' =>
                ! empty($filters['cashier_id'])
                    ? (int) $filters['cashier_id']
                    : null,

            'payment_method' =>
                $filters['payment_method']
                    ?? null,

            'sales_channel' =>
                $filters['sales_channel']
                    ?? null,

            'customer_id' =>
                ! empty($filters['customer_id'])
                    ? (int) $filters['customer_id']
                    : null,

            'category_id' =>
                ! empty($filters['category_id'])
                    ? (int) $filters['category_id']
                    : null,

            'product_id' =>
                ! empty($filters['product_id'])
                    ? (int) $filters['product_id']
                    : null,

            'transaction_id' =>
                ! empty($filters['transaction_id'])
                    ? (int) $filters['transaction_id']
                    : null,

            'details' =>
                filter_var(
                    $filters['details'] ?? false,
                    FILTER_VALIDATE_BOOLEAN
                ),

            'page' =>
                max(
                    1,
                    (int) (
                        $filters['page'] ?? 1
                    )
                ),

            'per_page' =>
                min(
                    100,
                    max(
                        10,
                        (int) (
                            $filters['per_page']
                                ?? $this->defaultPerPage
                        )
                    )
                ),

            'format' =>
                $filters['format'] ?? null,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Date Filter
    |--------------------------------------------------------------------------
    */

    protected function applyDateFilter(
        Builder $query,
        array $filters
    ): void {
        $query->whereBetween(
            'completed_at',
            [
                Carbon::parse(
                    $filters['date_from']
                )->startOfDay(),

                Carbon::parse(
                    $filters['date_to']
                )->endOfDay(),
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Standard Order Filters
    |--------------------------------------------------------------------------
    */

    protected function applyOrderFilters(
        Builder $query,
        array $filters
    ): void {
        if (! empty($filters['branch_id'])) {
            $query->where(
                'branch_id',
                $filters['branch_id']
            );
        }

        if (! empty($filters['cashier_id'])) {
            $query->where(
                'cashier_id',
                $filters['cashier_id']
            );
        }

        if (! empty($filters['customer_id'])) {
            $query->where(
                'customer_id',
                $filters['customer_id']
            );
        }

        if (! empty($filters['sales_channel'])) {
            $query->where(
                'sales_channel',
                $filters['sales_channel']
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Product / Category Filters
    |--------------------------------------------------------------------------
    */

    protected function applyProductFilters(
        Builder $query,
        array $filters
    ): void {
        if (
            empty($filters['product_id']) &&
            empty($filters['category_id'])
        ) {
            return;
        }

        $query->whereHas(
            'orderItems',
            function (Builder $itemQuery) use (
                $filters
            ) {
                if (! empty($filters['product_id'])) {
                    $itemQuery->where(
                        'product_id',
                        $filters['product_id']
                    );
                }

                if (! empty($filters['category_id'])) {
                    $itemQuery->whereHas(
                        'product',
                        function (Builder $productQuery) use (
                            $filters
                        ) {
                            $productQuery->where(
                                'category_id',
                                $filters['category_id']
                            );
                        }
                    );
                }
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Order Role Scope
    |--------------------------------------------------------------------------
    |
    | Role scope:
    |
    | Owner / Administrator
    |     -> entire company
    |
    | Branch Manager
    |     -> assigned branch
    |
    | Cashier
    |     -> own records
    |
    */

    protected function applyOrderScope(
        Builder $query,
        ?User $user
    ): void {
        if (! $user) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        if ($user->is_owner) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Administrator
        |--------------------------------------------------------------------------
        */

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('administrator')
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Cashier
        |--------------------------------------------------------------------------
        */

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('cashier')
        ) {
            $query->where(
                'cashier_id',
                $user->id
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Branch Manager
        |--------------------------------------------------------------------------
        |
        | The exact assigned-branch implementation depends on the existing
        | User/Branch structure. We use an existing branch_id attribute
        | when available.
        |
        */

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('branch_manager')
        ) {
            if (
                isset($user->branch_id) &&
                $user->branch_id
            ) {
                $query->where(
                    'branch_id',
                    $user->branch_id
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Payment Scope
    |--------------------------------------------------------------------------
    */

    protected function applyPaymentScope(
        Builder $query,
        ?User $user
    ): void {
        if (! $user) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        if ($user->is_owner) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Administrator
        |--------------------------------------------------------------------------
        */

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('administrator')
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Cashier
        |--------------------------------------------------------------------------
        */

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('cashier')
        ) {
            $query->where(
                'received_by',
                $user->id
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Branch Manager
        |--------------------------------------------------------------------------
        */

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('branch_manager')
        ) {
            if (
                isset($user->branch_id) &&
                $user->branch_id
            ) {
                $query->where(
                    'branch_id',
                    $user->branch_id
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Apply Branch Scope
    |--------------------------------------------------------------------------
    */

    protected function applyBranchScope(
        Builder $query,
        ?User $user
    ): void {
        if (! $user) {
            return;
        }

        if ($user->is_owner) {
            return;
        }

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('administrator')
        ) {
            return;
        }

        if (
            method_exists($user, 'hasRole') &&
            $user->hasRole('branch_manager')
        ) {
            if (
                isset($user->branch_id) &&
                $user->branch_id
            ) {
                $query->where(
                    'id',
                    $user->branch_id
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | User Display Name
    |--------------------------------------------------------------------------
    */

    protected function userName(
        User $user
    ): string {
        $name = trim(
            implode(
                ' ',
                array_filter([
                    $user->first_name ?? null,
                    $user->middle_name ?? null,
                    $user->last_name ?? null,
                ])
            )
        );

        if ($name !== '') {
            return $name;
        }

        return $user->name
            ?? $user->email
            ?? 'Unknown User';
    }
   
   
    protected function buildTransactionDetails(
        int $transactionId,
        int $companyId,
        ?User $user = null
    ): array {
        $query = Order::query()
            ->forCompany($companyId)
            ->completed()
            ->with([
                'branch',
                'cashier',
                'customer',
                'terminal',
                'orderItems.product',
                'payments',
            ])
            ->whereKey($transactionId);

        /*
        |--------------------------------------------------------------------------
        | Apply the same role / branch security used by the report
        |--------------------------------------------------------------------------
        */
        $this->applyOrderScope($query, $user);

        /*
        |--------------------------------------------------------------------------
        | Retrieve the transaction
        |--------------------------------------------------------------------------
        |
        | firstOrFail() is intentional here. If the transaction does not belong
        | to the user's permitted company / branch / scope, it will not be
        | returned.
        |
        */
        $order = $query->firstOrFail();      

        /*
        |--------------------------------------------------------------------------
        | Completed Payments
        |--------------------------------------------------------------------------
        */

        $payments = $order->payments
            ->where('payment_status', 'Completed')
            ->values();

        $paymentMethods = $payments
            ->pluck('payment_method')
            ->filter()
            ->unique()
            ->values();

        $paymentMethod = $paymentMethods->isNotEmpty()
            ? $paymentMethods->implode(', ')
            : '—';

        $paymentReferences = $payments
            ->map(function ($payment) {
                return $payment->reference_no
                    ?: $payment->transaction_reference;
            })
            ->filter()
            ->unique()
            ->values();

        $paymentReference = $paymentReferences->isNotEmpty()
            ? $paymentReferences->implode(', ')
            : '—';

        $amountPaid = $payments->sum(
            fn ($payment) => (float) $payment->amount
        );

        /*
        |--------------------------------------------------------------------------
        | Transaction Items
        |--------------------------------------------------------------------------
        */

        $items = $order->orderItems
            ->map(function ($item) {
                $productName = $item->product
                    ? $item->product->name
                    : ($item->product_name ?? 'Unknown Product');

                return [
                    'id' => $item->id,

                    'product_id' => $item->product_id,

                    'product' => $productName,

                    'product_name' => $productName,

                    'quantity' => round(
                        (float) ($item->quantity ?? 0),
                        2
                    ),

                    'unit_price' => round(
                        (float) ($item->unit_price ?? 0),
                        2
                    ),

                    'discount' => round(
                        (float) ($item->discount ?? 0),
                        2
                    ),

                    'tax' => round(
                        (float) ($item->tax ?? 0),
                        2
                    ),

                    'total' => round(
                        (float) (
                            $item->total
                            ?? $item->line_total
                            ?? 0
                        ),
                        2
                    ),
                ];
            })
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

        return [
            'id' => $order->id,

            'order_no' => $order->order_no,

            'date' => $order->completed_at
                ? $order->completed_at->format('Y-m-d H:i:s')
                : null,

            'status' => $order->order_status,

            /*
            |--------------------------------------------------------------------------
            | Customer
            |--------------------------------------------------------------------------
            */

            'customer' => $order->customer
                ? $order->customer->displayName()
                : 'Walk-in Customer',

            /*
            |--------------------------------------------------------------------------
            | Salesperson / Cashier
            |--------------------------------------------------------------------------
            |
            | Keep the API field as "cashier" because the existing transaction
            | table and inspector already use that contract.
            |
            */

            'cashier' => $order->cashier
                ? $this->userName($order->cashier)
                : '—',

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'branch' => $order->branch
                ? $order->branch->name
                : '—',

            'terminal' => $order->terminal
                ? $order->terminal->terminal_name
                : '—',

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            'payment_method' => $paymentMethod,

            'payment_reference' => $paymentReference,

            'amount_paid' => round($amountPaid, 2),

            /*
            |--------------------------------------------------------------------------
            | Totals
            |--------------------------------------------------------------------------
            */

            'gross' => round(
                (float) $order->subtotal,
                2
            ),

            'discount' => round(
                (float) $order->discount,
                2
            ),

            'tax' => round(
                (float) $order->tax,
                2
            ),

            'total' => round(
                (float) $order->grand_total,
                2
            ),

            /*
            |--------------------------------------------------------------------------
            | Items
            |--------------------------------------------------------------------------
            */

            'items' => $items,
        ];
    }




}

