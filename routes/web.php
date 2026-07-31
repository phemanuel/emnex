<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\Admin\DiscountController;

use App\Http\Controllers\Admin\StockOverviewController;
use App\Http\Controllers\Admin\StockAdjustmentController;
use App\Http\Controllers\Admin\StockTransferController;
use App\Http\Controllers\Admin\StockCountController;
use App\Http\Controllers\Admin\LowStockController;

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SalesReturnController;

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerGroupController;
use App\Http\Controllers\Admin\LoyaltyController;

use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\GoodsReceivedController;
use App\Http\Controllers\Admin\PurchaseReturnController;

use App\Http\Controllers\Admin\CashDrawerController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\TerminalController;

use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DocumentSequenceController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\AuditLogController;


Route::middleware('guest')->group(function () {

    Route::redirect('/', '/login');

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

});

Route::middleware('auth')->group(function () {
    

    Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | POS
    |--------------------------------------------------------------------------
    */

    Route::prefix('pos')
        ->name('pos.')
        ->controller(PosController::class)
        ->group(function () {

            Route::get('/', 'index')->name('index');

            Route::get('/open-orders', 'openOrders')
                ->name('open-orders');

            Route::get('/held-sales', 'heldSales')
                ->name('held-sales');

            Route::get('/returns', 'returns')
                ->name('returns');

        });


    Route::resource('cash-drawer', CashDrawerController::class)
        ->only(['index']);



    /*
    |--------------------------------------------------------------------------
    | Catalog
    |--------------------------------------------------------------------------
    */

    Route::resource('products', ProductController::class);

    Route::resource('categories', CategoryController::class);

    Route::resource('units', UnitController::class);

    Route::resource('tax-rates', TaxRateController::class);

    Route::resource('discounts', DiscountController::class);



    /*
    |--------------------------------------------------------------------------
    | Inventory
    |--------------------------------------------------------------------------
    */

    Route::resource('stock-overview', StockOverviewController::class)
        ->only(['index']);

    Route::resource('stock-adjustments', StockAdjustmentController::class);

    Route::resource('stock-transfers', StockTransferController::class);

    Route::resource('stock-counts', StockCountController::class);

    Route::resource('low-stock', LowStockController::class)
        ->only(['index']);



    /*
    |--------------------------------------------------------------------------
    | Sales
    |--------------------------------------------------------------------------
    */

    Route::resource('orders', OrderController::class);

    Route::resource('invoices', InvoiceController::class);

    Route::resource('payments', PaymentController::class);

    Route::resource('sales-returns', SalesReturnController::class);



    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */

    Route::resource('customers', CustomerController::class);

    Route::resource('customer-groups', CustomerGroupController::class);


    Route::get('/loyalty',
        [LoyaltyController::class,'index']
    )->name('loyalty.index');



    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */

    Route::resource('suppliers', SupplierController::class);

    Route::resource('purchase-orders', PurchaseOrderController::class);

    Route::resource('goods-received', GoodsReceivedController::class);

    Route::resource('purchase-returns', PurchaseReturnController::class);



    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */

    Route::prefix('reports')
        ->name('reports.')
        ->controller(ReportController::class)
        ->group(function(){

            Route::get('/sales','sales')
                ->name('sales');

            Route::get('/inventory','inventory')
                ->name('inventory');

            Route::get('/profit-loss','profitLoss')
                ->name('profit-loss');

            Route::get('/tax','tax')
                ->name('tax');

        });



    /*
    |--------------------------------------------------------------------------
    | Administration
    |--------------------------------------------------------------------------
    */

     /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    Route::prefix('users')
    ->name('users.')
    ->group(function(){


        Route::get('/', 
            [UserController::class,'index']
        )->name('index');


        Route::post('/store',
            [UserController::class,'store']
        )->name('store');


        Route::get('/{user}/edit',
            [UserController::class,'edit']
        )->name('edit');


        Route::put('/{user}',
            [UserController::class,'update']
        )->name('update');


        Route::delete('/{user}',
            [UserController::class,'destroy']
        )->name('destroy');


        Route::patch('/{user}/toggle-status',
            [UserController::class,'toggleStatus']
        )->name('toggleStatus');


        Route::post('/{user}/reset-password',
            [UserController::class,'resetPassword']
        )->name('resetPassword');

        Route::get('/{user}/details',
            [UserController::class, 'details']
        )->name('details');


    });

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'roles',
        RoleController::class
    );


    Route::get(
        '/roles/{role}/permissions',
        [RoleController::class, 'permissions']
    )
    ->middleware('permission:roles.permissions')
    ->name('roles.permissions');

    Route::put(
        '/roles/{role}/permissions',
        [RoleController::class, 'updatePermissions']
    )
    ->middleware('permission:roles.permissions')
    ->name('roles.permissions.update');


    // ------------------------------------------    

    Route::resource('terminals', TerminalController::class);



    /*
    |--------------------------------------------------------------------------
    | Company
    |--------------------------------------------------------------------------
    */

    Route::prefix('company')
        ->name('company.')
        ->controller(CompanyController::class)
        ->group(function () {

            Route::get('/', 'index')
                ->name('index');

            Route::get('/show', 'show')
                ->name('show');

            Route::put('/update', 'update')
                ->name('update');

            Route::post('/logo', 'updateLogo')
                ->name('logo.update');

        });

    
        /*
        |--------------------------------------------------------------------------
        | Branches
        |--------------------------------------------------------------------------
        */

        Route::prefix('branches')
            ->name('branches.')
            ->controller(BranchController::class)
            ->group(function(){


                Route::get('/', 'index')
                    ->name('index');

                Route::get('/test-permission', function () {

                    return 'Permission Passed';

                })
                ->middleware('permission:branches.view');


                Route::get('/{branch}/details', 'details')
                    ->name('details');

                Route::get('/{branch}/users', 
                    [BranchController::class, 'users']
                )->name('users');


                Route::get('/{branch}/terminals', 
                    [BranchController::class, 'terminals']
                )->name('terminals');


                Route::get('/{branch}/orders', 
                    [BranchController::class, 'orders']
                )->name('orders');

                Route::get(
                    '/{branch}/customers',
                    [BranchController::class,'customers']
                );


            });



    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    Route::prefix('settings')
        ->name('settings.')
        ->controller(SettingController::class)
        ->group(function(){

            Route::get('/', 'index')
                ->name('index');

            Route::get('/pos','pos')
                ->name('pos');

            Route::get('/receipt','receipt')
                ->name('receipt');

        });



    Route::resource(
        'document-sequences',
        DocumentSequenceController::class
    );


    Route::resource(
        'payment-methods',
        PaymentMethodController::class
    );


    Route::resource(
        'audit-logs',
        AuditLogController::class
    );

});





