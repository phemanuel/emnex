<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Customer;
use App\Models\ProductStock;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\OrderItem;
use Carbon\Carbon;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $companyId = $user->company_id;

        /*
        |--------------------------------------------------------------------------
        | Access Scope
        |--------------------------------------------------------------------------
        */

        $role = $user->role?->code;

        $canManageAllBranches = in_array($role, [
            'owner',
            'administrator',
        ]);

       $currentBranchId = $user->branch_id;


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

        $period = request('period', 'this_week');


        switch ($period) {

            case 'today':

                $startDate = Carbon::today();
                $endDate = Carbon::today();

                break;


            case 'yesterday':

                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday();

                break;


            case 'this_month':

                $startDate =
                    Carbon::now()->startOfMonth();

                $endDate =
                    Carbon::now()->endOfMonth();

                break;


            case 'this_year':

                $startDate =
                    Carbon::now()->startOfYear();

                $endDate =
                    Carbon::now()->endOfYear();

                break;


            default:

                $startDate =
                    Carbon::now()->startOfWeek();

                $endDate =
                    Carbon::now()->endOfWeek();

                break;

        }


        /*
        |--------------------------------------------------------------------------
        | Order Query
        |--------------------------------------------------------------------------
        */

        $orderQuery = Order::forCompany($companyId);


        if (!$canManageAllBranches) {

            $orderQuery->where(
                'branch_id',
                $currentBranchId
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Query
        |--------------------------------------------------------------------------
        */

        $paymentQuery =
            Payment::forCompany($companyId);


        if (!$canManageAllBranches) {

            $paymentQuery->where(
                'branch_id',
                $currentBranchId
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Product Stock Query
        |--------------------------------------------------------------------------
        */

        $stockQuery =
            ProductStock::query()
                ->where(
                    'company_id',
                    $companyId
                );


        if (!$canManageAllBranches) {

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
                            $endDate
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
                            $endDate
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
                Customer::forCompany($companyId);


            /*
            |--------------------------------------------------------------------------
            | Branch Customer Scope
            |--------------------------------------------------------------------------
            |
            | If your customers table has branch_id, this keeps customers
            | branch-specific.
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


            $totalCustomers =
                (clone $customerQuery)
                    ->count();


            $newCustomersToday =
                (clone $customerQuery)
                    ->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate
                        ]
                    )
                    ->count();

        }


        /*
        |--------------------------------------------------------------------------
        | Inventory Value
        |--------------------------------------------------------------------------
        */

        $inventoryQuery = ProductStock::query()

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


        if (! canManageAllBranches()) {

            $inventoryQuery->where(
                'product_stocks.branch_id',
                currentBranchId()
            );

        }


        $inventoryValue = $inventoryQuery->sum(
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


        if ($canViewPayments) {

            $todayPayments =
                (clone $paymentQuery)
                    ->completed()
                    ->whereBetween(
                        'created_at',
                        [
                            $startDate,
                            $endDate
                        ]
                    );


            /*
            | Cash
            */

            $cashSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Cash'
                    )
                    ->sum('amount');


            /*
            | Card / POS
            */

            $cardSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Card'
                    )
                    ->sum('amount');


            /*
            | Bank Transfer
            */

            $transferSales =
                (clone $todayPayments)
                    ->where(
                        'payment_method',
                        'Transfer'
                    )
                    ->sum('amount');

             /*
            | Wallet
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

        $refunds = 0;


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
                OrderItem::forCompany($companyId);


            /*
            |--------------------------------------------------------------------------
            | Branch Scope
            |--------------------------------------------------------------------------
            |
            | Only apply this if order_items has branch_id.
            |
            */

            if (
                !$canManageAllBranches &&
                Schema::hasColumn(
                    'order_items',
                    'branch_id'
                )
            ) {

                $orderItemQuery->where(
                    'branch_id',
                    $currentBranchId
                );

            }


            $topProducts =
                $orderItemQuery
                    ->selectRaw("
                        product_id,
                        product_name,
                        SUM(quantity) as total_quantity,
                        SUM(total) as total_sales
                    ")
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

            for (
                $i = 6;
                $i >= 0;
                $i--
            ) {

                $date =
                    Carbon::today()
                        ->subDays($i);


                $sales =
                    (clone $orderQuery)
                        ->whereDate(
                            'created_at',
                            $date
                        )
                        ->where(
                            'order_status',
                            'Completed'
                        )
                        ->sum('amount_paid');


                $transactions =
                    (clone $orderQuery)
                        ->whereDate(
                            'created_at',
                            $date
                        )
                        ->where(
                            'order_status',
                            'Completed'
                        )
                        ->count();


                $salesChart[] = [

                    'day' =>
                        $date->format('D'),

                    'sales' =>
                        (float) $sales,

                    'transactions' =>
                        $transactions,

                ];

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

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
                | Branch Scope
                |--------------------------------------------------------------------------
                */

                'canManageAllBranches',
                'currentBranchId'

            )
        );
    }
    
}
