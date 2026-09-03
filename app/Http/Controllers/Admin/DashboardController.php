<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Customer;
use App\Models\ProductStock;
use App\Models\SalesReturn;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\OrderItem;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * Dashboard index.
     */
    public function index()
    {
        $user =
            Auth::user();

        $companyId =
            $user->company_id;

        /*
        |--------------------------------------------------------------------------
        | Access Scope
        |--------------------------------------------------------------------------
        */

        $role =
            $user->role?->code;

        $canManageAllBranches =
            in_array($role, [
                'owner',
                'administrator',
            ]);

        $isBranchManager =
            $role === 'branch_manager';

        $isCashier =
            $role === 'cashier';

        $currentBranchId =
            $user->branch_id;

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $canViewSales =
            canAccess('reports.sales') ||
            canAccess('orders.view') ||
            canAccess('pos.sell');

        $canViewOrders =
            canAccess('orders.view') ||
            canAccess('pos.open_orders');

        $canViewCustomers =
            canAccess('customers.view');

        $canViewInventory =
            canAccess('inventory.view');

        $canViewLowStock =
            canAccess('inventory.low_stock') ||
            canAccess('inventory.view');

        $canViewPayments =
            canAccess('payments.view');

        $canViewReports =
            canAccess('reports.sales') ||
            canAccess('reports.inventory') ||
            canAccess('reports.profit_loss') ||
            canAccess('reports.tax');

        $canViewTerminals =
            canAccess('terminals.view') ||
            canAccess('pos.cash_drawer');

        /*
        |--------------------------------------------------------------------------
        | Date Period
        |--------------------------------------------------------------------------
        */

        $period =
            request(
                'period',
                'this_week'
            );

        switch ($period) {

            case 'today':

                $startDate =
                    Carbon::today();

                $endDate =
                    Carbon::today();

                break;

            case 'yesterday':

                $startDate =
                    Carbon::yesterday();

                $endDate =
                    Carbon::yesterday();

                break;

            case 'this_month':

                $startDate =
                    Carbon::now()
                        ->startOfMonth();

                $endDate =
                    Carbon::now()
                        ->endOfMonth();

                break;

            case 'this_year':

                $startDate =
                    Carbon::now()
                        ->startOfYear();

                $endDate =
                    Carbon::now()
                        ->endOfYear();

                break;

            default:

                $startDate =
                    Carbon::now()
                        ->startOfWeek();

                $endDate =
                    Carbon::now()
                        ->endOfWeek();

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Order Query
        |--------------------------------------------------------------------------
        |
        | Owner / Administrator
        |     - All branches
        |     - All users
        |
        | Branch Manager
        |     - All users
        |     - Own branch
        |
        | Cashier
        |     - Own orders only
        |
        */

        $orderQuery =
            Order::forCompany(
                $companyId
            );

        if ($isCashier) {

            $orderQuery->where(
                'cashier_id',
                $user->id
            );

        } elseif ($isBranchManager) {

            $orderQuery->where(
                'branch_id',
                $currentBranchId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Query
        |--------------------------------------------------------------------------
        |
        | Cashiers are scoped by received_by.
        | Branch managers are scoped by branch.
        |
        */

        $paymentQuery =
            Payment::forCompany(
                $companyId
            );

        if ($isCashier) {

            $paymentQuery->where(
                'received_by',
                $user->id
            );

        } elseif ($isBranchManager) {

            $paymentQuery->where(
                'branch_id',
                $currentBranchId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Product Stock Query
        |--------------------------------------------------------------------------
        |
        | Stock is operational branch data.
        |
        | Owner / Administrator
        |     - All branches
        |
        | Branch Manager / Cashier
        |     - Current branch
        |
        */

        $stockQuery =
            ProductStock::query()
                ->where(
                    'company_id',
                    $companyId
                );

        if (
            !$canManageAllBranches
        ) {

            $stockQuery->where(
                'branch_id',
                $currentBranchId
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Today's / Selected Period Sales
        |--------------------------------------------------------------------------
        */

        $todaySales = 0;

        if ($canViewSales) {

            $todaySales =
                (clone $orderQuery)
                    ->completed()
                    ->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate,
                        ]
                    )
                    ->sum('total');
        }

        /*
        |--------------------------------------------------------------------------
        | Transactions
        |--------------------------------------------------------------------------
        */

        $todayTransactions = 0;

        if ($canViewOrders) {

            $todayTransactions =
                (clone $orderQuery)
                    ->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate,
                        ]
                    )
                    ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        $totalCustomers = 0;

        $newCustomersToday = 0;

        if ($canViewCustomers) {

            $customerQuery =
                Customer::forCompany(
                    $companyId
                );

            /*
            |--------------------------------------------------------------------------
            | Branch Customer Scope
            |--------------------------------------------------------------------------
            |
            | Customers are branch-scoped where branch_id exists.
            |
            */

            if (
                !$canManageAllBranches &&
                Schema::hasColumn(
                    'customers',
                    'branch_id'
                )
            ) {

                $customerQuery->where(
                    'branch_id',
                    $currentBranchId
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Customer Scope For Cashier
            |--------------------------------------------------------------------------
            |
            | If customers do not have a cashier/created_by field, branch
            | remains the appropriate operational scope.
            |
            */

            $totalCustomers =
                (clone $customerQuery)
                    ->count();

            $newCustomersToday =
                (clone $customerQuery)
                    ->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate,
                        ]
                    )
                    ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Inventory Value
        |--------------------------------------------------------------------------
        */

        $inventoryQuery =
            ProductStock::query()
                ->join(
                    'products',
                    'products.id',
                    '=',
                    'product_stocks.product_id'
                )
                ->where(
                    'product_stocks.company_id',
                    $companyId
                );

        if (
            !$canManageAllBranches
        ) {

            $inventoryQuery->where(
                'product_stocks.branch_id',
                $currentBranchId
            );
        }

        $inventoryValue =
            $inventoryQuery->sum(
                DB::raw(
                    'product_stocks.available_quantity * products.cost_price'
                )
            );

        /*
        |--------------------------------------------------------------------------
        | Today's Activity
        |--------------------------------------------------------------------------
        */

        $cashSales = 0;

        $cardSales = 0;

        $transferSales = 0;

        $walletSales = 0;

        if ($canViewPayments) {

            $todayPayments =
                (clone $paymentQuery)
                    ->completed()
                    ->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate,
                        ]
                    );

            /*
            |--------------------------------------------------------------------------
            | Cash
            |--------------------------------------------------------------------------
            */

            $cashSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Cash'
                    )
                    ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Card / POS
            |--------------------------------------------------------------------------
            */

            $cardSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Card'
                    )
                    ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Bank Transfer
            |--------------------------------------------------------------------------
            */

            $transferSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Transfer'
                    )
                    ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Wallet
            |--------------------------------------------------------------------------
            */

            $walletSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Wallet'
                    )
                    ->sum('amount');
        }

        /*
        |--------------------------------------------------------------------------
        | Refunds
        |--------------------------------------------------------------------------
        */

        $refundQuery =
            SalesReturn::query()
                ->where(
                    'company_id',
                    $companyId
                );

        if (!$canManageAllBranches) {

            $refundQuery->where(
                'branch_id',
                $currentBranchId
            );
        }

        $refunds =
            (clone $refundQuery)
                ->whereBetween(
                    'created_at',
                    [
                        $startDate,
                        $endDate,
                    ]
                )
                ->sum('refund_amount');

        /*
        |--------------------------------------------------------------------------
        | Pending Orders
        |--------------------------------------------------------------------------
        */

        $pendingOrders = 0;

        if ($canViewOrders) {

            $pendingOrders =
                (clone $orderQuery)
                    ->pending()
                    ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Recent Orders
        |--------------------------------------------------------------------------
        */

        $recentOrders =
            collect();

        if ($canViewOrders) {

            $recentOrders =
                (clone $orderQuery)
                    ->with([
                        'customer',
                        'cashier',
                    ])
                    ->latest()
                    ->take(10)
                    ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Low Stock Products
        |--------------------------------------------------------------------------
        */

        $lowStockProducts =
            collect();

        if ($canViewLowStock) {

            $lowStockProducts =
                (clone $stockQuery)
                    ->lowStock()
                    ->with('product')
                    ->orderBy('quantity')
                    ->take(5)
                    ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Top Selling Products
        |--------------------------------------------------------------------------
        */

        $topProducts =
            collect();

        if ($canViewSales) {

            $orderItemQuery =
                OrderItem::forCompany(
                    $companyId
                );

            /*
            |--------------------------------------------------------------------------
            | Cashier / Branch Manager Scope
            |--------------------------------------------------------------------------
            |
            | Order items belong to orders.
            | Therefore the order query is used to enforce access.
            |
            */

            if ($isCashier) {

                $orderItemQuery->whereHas(
                    'order',
                    function ($query) use (
                        $user
                    ) {

                        $query->where(
                            'cashier_id',
                            $user->id
                        );
                    }
                );

            } elseif ($isBranchManager) {

                $orderItemQuery->whereHas(
                    'order',
                    function ($query) use (
                        $currentBranchId
                    ) {

                        $query->where(
                            'branch_id',
                            $currentBranchId
                        );
                    }
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Completed Sales Only
            |--------------------------------------------------------------------------
            */

            $orderItemQuery->whereHas(
                'order',
                function ($query) {

                    $query->completed();
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Selected Period
            |--------------------------------------------------------------------------
            */

            $orderItemQuery->whereHas(
                'order',
                function ($query) use (
                    $startDate,
                    $endDate
                ) {

                    $query->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate,
                        ]
                    );
                }
            );

            /*
            |--------------------------------------------------------------------------
            | Top Products
            |--------------------------------------------------------------------------
            */

            $topProducts =
                $orderItemQuery
                    ->selectRaw(
                        "
                            product_id,
                            product_name,
                            SUM(quantity) as total_quantity,
                            SUM(total) as total_sales
                        "
                    )
                    ->groupBy(
                        'product_id',
                        'product_name'
                    )
                    ->orderByDesc(
                        'total_quantity'
                    )
                    ->take(5)
                    ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Sales Chart
        |--------------------------------------------------------------------------
        */

        $salesChart = [];

        if ($canViewSales) {

            switch ($period) {

                /*
                |--------------------------------------------------------------------------
                | Today
                |--------------------------------------------------------------------------
                */

                case 'today':

                    $chartStartDate =
                        $startDate
                            ->copy()
                            ->startOfDay();

                    $chartEndDate =
                        $endDate
                            ->copy()
                            ->endOfDay();

                    break;

                /*
                |--------------------------------------------------------------------------
                | Yesterday
                |--------------------------------------------------------------------------
                */

                case 'yesterday':

                    $chartStartDate =
                        $startDate
                            ->copy()
                            ->startOfDay();

                    $chartEndDate =
                        $endDate
                            ->copy()
                            ->endOfDay();

                    break;

                /*
                |--------------------------------------------------------------------------
                | This Week
                |--------------------------------------------------------------------------
                */

                case 'this_week':

                    $chartStartDate =
                        $startDate
                            ->copy()
                            ->startOfDay();

                    $chartEndDate =
                        $endDate
                            ->copy()
                            ->endOfDay();

                    break;

                /*
                |--------------------------------------------------------------------------
                | This Month
                |--------------------------------------------------------------------------
                */

                case 'this_month':

                    $chartStartDate =
                        $startDate
                            ->copy()
                            ->startOfDay();

                    $chartEndDate =
                        $endDate
                            ->copy()
                            ->endOfDay();

                    break;

                /*
                |--------------------------------------------------------------------------
                | This Year
                |--------------------------------------------------------------------------
                */

                case 'this_year':

                    $chartStartDate =
                        $startDate
                            ->copy()
                            ->startOfDay();

                    $chartEndDate =
                        $endDate
                            ->copy()
                            ->endOfDay();

                    break;

                /*
                |--------------------------------------------------------------------------
                | Default
                |--------------------------------------------------------------------------
                */

                default:

                    $chartStartDate =
                        $startDate
                            ->copy()
                            ->startOfDay();

                    $chartEndDate =
                        $endDate
                            ->copy()
                            ->endOfDay();

                    break;
            }

            /*
            |--------------------------------------------------------------------------
            | Determine Chart Granularity
            |--------------------------------------------------------------------------
            */

            if (
                $period === 'this_year'
            ) {

                /*
                |--------------------------------------------------------------------------
                | Monthly Chart
                |--------------------------------------------------------------------------
                */

                $chartCursor =
                    $chartStartDate
                        ->copy()
                        ->startOfMonth();

                $chartEnd =
                    $chartEndDate
                        ->copy()
                        ->startOfMonth();

                while (
                    $chartCursor->lte(
                        $chartEnd
                    )
                ) {

                    $monthStart =
                        $chartCursor
                            ->copy()
                            ->startOfMonth();

                    $monthEnd =
                        $chartCursor
                            ->copy()
                            ->endOfMonth();

                    $sales =
                        (clone $orderQuery)
                            ->completed()
                            ->whereBetween(
                                'created_at',
                                [
                                    $monthStart,
                                    $monthEnd,
                                ]
                            )
                            ->sum('amount_paid');

                    $transactions =
                        (clone $orderQuery)
                            ->completed()
                            ->whereBetween(
                                'created_at',
                                [
                                    $monthStart,
                                    $monthEnd,
                                ]
                            )
                            ->count();

                    $salesChart[] = [

                        'day' =>
                            $chartCursor
                                ->format('M'),

                        'sales' =>
                            (float) $sales,

                        'transactions' =>
                            $transactions,
                    ];

                    $chartCursor->addMonth();
                }

            } elseif (
                $period === 'this_month'
            ) {

                /*
                |--------------------------------------------------------------------------
                | Daily Chart — This Month
                |--------------------------------------------------------------------------
                */

                $chartCursor =
                    $chartStartDate
                        ->copy()
                        ->startOfDay();

                $chartEnd =
                    $chartEndDate
                        ->copy()
                        ->startOfDay();

                while (
                    $chartCursor->lte(
                        $chartEnd
                    )
                ) {

                    $dayStart =
                        $chartCursor
                            ->copy()
                            ->startOfDay();

                    $dayEnd =
                        $chartCursor
                            ->copy()
                            ->endOfDay();

                    $sales =
                        (clone $orderQuery)
                            ->completed()
                            ->whereBetween(
                                'created_at',
                                [
                                    $dayStart,
                                    $dayEnd,
                                ]
                            )
                            ->sum('amount_paid');

                    $transactions =
                        (clone $orderQuery)
                            ->completed()
                            ->whereBetween(
                                'created_at',
                                [
                                    $dayStart,
                                    $dayEnd,
                                ]
                            )
                            ->count();

                    $salesChart[] = [

                        'day' =>
                            $chartCursor
                                ->format('d M'),

                        'sales' =>
                            (float) $sales,

                        'transactions' =>
                            $transactions,
                    ];

                    $chartCursor->addDay();
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | Daily Chart
                |--------------------------------------------------------------------------
                |
                | Today / Yesterday / This Week
                |
                */

                $chartCursor =
                    $chartStartDate
                        ->copy()
                        ->startOfDay();

                $chartEnd =
                    $chartEndDate
                        ->copy()
                        ->startOfDay();

                while (
                    $chartCursor->lte(
                        $chartEnd
                    )
                ) {

                    $dayStart =
                        $chartCursor
                            ->copy()
                            ->startOfDay();

                    $dayEnd =
                        $chartCursor
                            ->copy()
                            ->endOfDay();

                    $sales =
                        (clone $orderQuery)
                            ->completed()
                            ->whereBetween(
                                'created_at',
                                [
                                    $dayStart,
                                    $dayEnd,
                                ]
                            )
                            ->sum('amount_paid');

                    $transactions =
                        (clone $orderQuery)
                            ->completed()
                            ->whereBetween(
                                'created_at',
                                [
                                    $dayStart,
                                    $dayEnd,
                                ]
                            )
                            ->count();

                    $salesChart[] = [

                        'day' =>
                            $chartCursor
                                ->format('D'),

                        'sales' =>
                            (float) $sales,

                        'transactions' =>
                            $transactions,
                    ];

                    $chartCursor->addDay();
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        if($role === 'cashier') {
            return redirect()->route('pos.cashier');
        }else {
            return view(
                'dashboard.index',
                compact(
                    'user',
                    'todaySales',
                    'todayTransactions',
                    'totalCustomers',
                    'newCustomersToday',
                    'inventoryValue',
                    'cashSales',
                    'cardSales',
                    'transferSales',
                    'walletSales',
                    'refunds',
                    'pendingOrders',
                    'recentOrders',
                    'lowStockProducts',
                    'topProducts',
                    'salesChart',
                    'period',
                    'startDate',
                    'endDate',
                    'canViewSales',
                    'canViewOrders',
                    'canViewCustomers',
                    'canViewInventory',
                    'canViewLowStock',
                    'canViewPayments',
                    'canViewReports',
                    'canViewTerminals',
                    'canManageAllBranches',
                    'currentBranchId',
                    'isBranchManager',
                    'isCashier'
                )
            );
        }

        return view(
            'dashboard.index',
            compact(

                /*
                |--------------------------------------------------------------------------
                | User
                |--------------------------------------------------------------------------
                */

                'user',

                /*
                |--------------------------------------------------------------------------
                | Dashboard KPIs
                |--------------------------------------------------------------------------
                */

                'todaySales',
                'todayTransactions',

                'totalCustomers',
                'newCustomersToday',

                'inventoryValue',

                'cashSales',
                'cardSales',
                'transferSales',
                'walletSales',

                'refunds',

                'pendingOrders',

                /*
                |--------------------------------------------------------------------------
                | Dashboard Lists
                |--------------------------------------------------------------------------
                */

                'recentOrders',
                'lowStockProducts',
                'topProducts',

                /*
                |--------------------------------------------------------------------------
                | Chart
                |--------------------------------------------------------------------------
                */

                'salesChart',

                /*
                |--------------------------------------------------------------------------
                | Date Period
                |--------------------------------------------------------------------------
                */

                'period',
                'startDate',
                'endDate',

                /*
                |--------------------------------------------------------------------------
                | Permission Flags
                |--------------------------------------------------------------------------
                */

                'canViewSales',
                'canViewOrders',
                'canViewCustomers',
                'canViewInventory',
                'canViewLowStock',
                'canViewPayments',
                'canViewReports',
                'canViewTerminals',

                /*
                |--------------------------------------------------------------------------
                | Access Scope
                |--------------------------------------------------------------------------
                */

                'canManageAllBranches',
                'currentBranchId',

                /*
                |--------------------------------------------------------------------------
                | Role Scope
                |--------------------------------------------------------------------------
                */

                'isBranchManager',
                'isCashier'
            )
        );
    }
    
}
