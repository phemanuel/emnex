<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();

                break;

            case 'this_year':

                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();

                break;

            default:

                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();

        }
        /*
        |--------------------------------------------------------------------------
        | Today's Sales
        |--------------------------------------------------------------------------
        */

        $todaySales = Order::forCompany($companyId)
            ->completed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');



        /*
        |--------------------------------------------------------------------------
        | Today's Transactions
        |--------------------------------------------------------------------------
        */

        $todayTransactions = Order::forCompany($companyId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();



        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        $totalCustomers = Customer::forCompany($companyId)
            ->count();


        $newCustomersToday = Customer::forCompany($companyId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();



        /*
        |--------------------------------------------------------------------------
        | Inventory Value
        |--------------------------------------------------------------------------
        */

        $inventoryValue = ProductStock::where(
        'product_stocks.company_id',
        $companyId
        )
        ->join(
            'products',
            'products.id',
            '=',
            'product_stocks.product_id'
        )
        ->sum(
            DB::raw(
                'product_stocks.available_quantity * products.cost_price'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Today's Activity
        |--------------------------------------------------------------------------
        */

        $todayPayments = Payment::forCompany($companyId)
            ->completed()
            ->whereBetween('created_at', [$startDate, $endDate]);



        /*
        | Cash Sales
        */

        $cashSales = (clone $todayPayments)
            ->where('payment_method', 'Cash')
            ->sum('amount');



        /*
        | Card Sales
        */

        $cardSales = (clone $todayPayments)
            ->where('payment_method', 'Card')
            ->sum('amount');



        /*
        | Bank Transfer Sales
        */

        $transferSales = (clone $todayPayments)
            ->where('payment_method', 'Bank Transfer')
            ->sum('amount');



        /*
        | Refunds
        |
        | We will adjust this when Refund model/module is added.
        | For now use 0.
        */

        $refunds = 0;



        /*
        | Pending Orders
        */

        $pendingOrders = Order::forCompany($companyId)
            ->pending()
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Recent Orders
        |--------------------------------------------------------------------------
        */

        $recentOrders = Order::forCompany($companyId)
            ->with([
                'customer',
                'cashier',
            ])
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Low Stock Products
        |--------------------------------------------------------------------------
        */

        $lowStockProducts = ProductStock::forCompany($companyId)
            ->lowStock()
            ->with('product')
            ->orderBy('quantity')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Selling Products
        |--------------------------------------------------------------------------
        */

        $topProducts = OrderItem::forCompany($companyId)
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
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

       /*
        |--------------------------------------------------------------------------
        | Sales Chart (Last 7 Days)
        |--------------------------------------------------------------------------
        */

        $salesChart = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $sales = Order::where('company_id', $companyId)
                ->whereDate('created_at', $date)
                ->where('order_status', 'Completed')
                ->sum('amount_paid');

            $transactions = Order::where('company_id', $companyId)
                ->whereDate('created_at', $date)
                ->where('order_status', 'Completed')
                ->count();

            $salesChart[] = [

                'day' => $date->format('D'),

                'sales' => (float) $sales,

                'transactions' => $transactions,

            ]; 

        }


        return view('dashboard.index', compact(

            'user',

            'todaySales',
            'todayTransactions',

            'totalCustomers',
            'newCustomersToday',

            'inventoryValue',

            'cashSales',
            'cardSales',
            'transferSales',

            'refunds',

            'pendingOrders',

            'recentOrders',

            'lowStockProducts',

            'topProducts',
            'salesChart',
            'period',
            'startDate',
            'endDate'

        ));
    }
    
}
