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

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $companyId = $user->company_id;


        /*
        |--------------------------------------------------------------------------
        | Today's Sales
        |--------------------------------------------------------------------------
        */

        $todaySales = Order::forCompany($companyId)
            ->completed()
            ->whereDate('created_at', today())
            ->sum('total');



        /*
        |--------------------------------------------------------------------------
        | Today's Transactions
        |--------------------------------------------------------------------------
        */

        $todayTransactions = Order::forCompany($companyId)
            ->whereDate('created_at', today())
            ->count();



        /*
        |--------------------------------------------------------------------------
        | Customers
        |--------------------------------------------------------------------------
        */

        $totalCustomers = Customer::forCompany($companyId)
            ->count();


        $newCustomersToday = Customer::forCompany($companyId)
            ->whereDate('created_at', today())
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
            ->whereDate('payment_date', today());



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
                'refunds',
                'pendingOrders'
            )
        );
    }
    
}
