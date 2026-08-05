<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\TaxRateController;
use App\Http\Controllers\Admin\DiscountController;

use App\Http\Controllers\Admin\PosController;

use App\Http\Controllers\Admin\StockController;
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

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DocumentSequenceController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ActivityLogController;


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
   

    /*
|--------------------------------------------------------------------------
| Product Categories
|--------------------------------------------------------------------------
*/

Route::prefix('product-categories')
    ->name('product-categories.')
    ->group(function () {

        Route::get('/',[ProductCategoryController::class,'index'])
        ->name('index');

        Route::get('/statistics',[ProductCategoryController::class,'statistics'])
        ->name('statistics');

        Route::post('/',[ProductCategoryController::class,'store'])
        ->name('store');  
        
        Route::get('/next-code',[ProductCategoryController::class,'nextCode'])
        ->name('next-code');

        Route::get('/{id}/edit',[ProductCategoryController::class,'edit'])
        ->name('edit');        

        Route::put('/{id}',[ProductCategoryController::class,'update'])
        ->name('update');

        Route::get('/{id}/details',[ProductCategoryController::class,'details'])
        ->name('details');

        Route::delete('/{id}',[ProductCategoryController::class,'destroy'])
        ->name('destroy');

        Route::patch('/{id}/toggle-status',[ProductCategoryController::class,'toggleStatus'])
        ->name('toggle-status');

    });

    /*
|--------------------------------------------------------------------------
| Units
|--------------------------------------------------------------------------
*/

Route::prefix('units')

    ->name('units.')

    ->controller(UnitController::class)

    ->group(function () {

        Route::get('/','index')->name('index');

        Route::get('/table','table')->name('table');

        Route::get('/next-code','nextCode')->name('nextCode');

        Route::get('/{id}/details','details')->name('details');

        Route::post('/','store')->name('store');

        Route::get('/{id}/edit','edit')->name('edit');

        Route::put('/{id}','update')->name('update');

        Route::patch('/{id}/toggle-status','toggleStatus')->name('toggleStatus');

        Route::delete('/{id}','destroy')->name('destroy');

    });

    /*
|--------------------------------------------------------------------------
| Tax Rates
|--------------------------------------------------------------------------
*/

Route::prefix('tax-rates')

    ->name('tax-rates.')

    ->controller(TaxRateController::class)

    ->group(function () {
        Route::get('/','index')->name('index');

        Route::get('/table','table')->name('table');

        Route::post('/','store')->name('store');

        Route::get('/{taxRate}/edit','edit')->name('edit');

        Route::put('/{taxRate}','update')->name('update');

        Route::get('/{taxRate}/details','details')->name('details');

        Route::patch('/{taxRate}/toggle-status','toggleStatus')->name('toggle-status');

        Route::delete('/{taxRate}','destroy')->name('destroy');

    });

    /*
|--------------------------------------------------------------------------
| Discounts
|--------------------------------------------------------------------------
*/

Route::prefix('discounts')
    ->name('discounts.')
    ->controller(DiscountController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');

        Route::get('/table', 'table')->name('table');

        Route::post('/', 'store')->name('store');

        Route::get('/{discount}/edit', 'edit')->name('edit');

        Route::put('/{discount}', 'update')->name('update');

        Route::get('/{discount}/details', 'details')->name('details');

        Route::patch('/{discount}/toggle-status', 'toggleStatus')
            ->name('toggle-status');

        Route::delete('/{discount}', 'destroy')->name('destroy');

    });


  /*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/


Route::prefix('products')
    ->name('products.')
    ->controller(ProductController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/table', 'table')
            ->name('table');

        Route::post('/', 'store')
            ->name('store');

        Route::get('/{product}/edit', 'edit')
            ->name('edit');

        Route::put('/{product}', 'update')
            ->name('update');

        Route::get('/{product}/details', 'details')
            ->name('details');

        Route::patch('/{product}/toggle-status', 'toggleStatus')
            ->name('toggle-status');

        Route::delete('/{product}', 'destroy')
            ->name('destroy');

        Route::get('/next-code','nextCode')
        ->name('next-code');

    });



    /*
    |--------------------------------------------------------------------------
    | Inventory
    |--------------------------------------------------------------------------
    */

    Route::prefix('stock')
    ->name('stock.')
    ->controller(StockController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');        

        Route::get('/table', 'table')
            ->name('table');        

        Route::get('/{id}/details', 'details')
            ->name('details');

        Route::post('/', 'store')
            ->name('store');

        Route::get('products','products')
        ->name('products');

        Route::get('/adjustment-filters','adjustmentFilters')
        ->name('stock.adjustment.filters');

    });    

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

                Route::post('/',[BranchController::class, 'store'])
                ->name('store');

                Route::get('/{branch}/edit',[BranchController::class, 'edit']
                )->name('edit');

                Route::put('/{branch}',[BranchController::class, 'update']
                )->name('update');   
                
                Route::delete('/{branch}', [BranchController::class, 'destroy'])
                ->name('destroy');

                Route::patch('/{branch}/toggle-status',[BranchController::class,'toggleStatus'])
                ->name('toggleStatus');

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

    Route::prefix('terminals')
    ->name('terminals.')
    ->group(function () {       

        Route::get('/', [TerminalController::class, 'index'])
            ->name('index');

        Route::post('/', [TerminalController::class, 'store'])
            ->name('store');

        Route::get('/{terminal}/details', [TerminalController::class, 'details'])
            ->name('details');

        Route::get('/{terminal}/edit', [TerminalController::class, 'edit'])
            ->name('edit');


        Route::put('/{terminal}', [TerminalController::class, 'update'])
            ->name('update');

        Route::delete('/{terminal}', [TerminalController::class, 'destroy'])
            ->name('destroy');

        Route::patch('/{terminal}/toggle-status', [TerminalController::class, 'toggleStatus'])
            ->name('toggle-status');

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

           Route::get('/general', [SettingsController::class, 'index'])
                ->name('index');


            Route::put('/general', [SettingsController::class, 'update'])
                ->name('update');


            Route::patch('/settings/toggle-status', [SettingsController::class, 'toggleStatus'])
                ->name('toggle-status');

        });



    Route::prefix('document-sequences')
    ->name('document-sequences.')
    ->group(function () {

        Route::get(
            '/',
            [DocumentSequenceController::class, 'index']
        )->name('index');

        Route::get(
            '/{documentSequence}/edit',
            [DocumentSequenceController::class, 'edit']
        )->name('edit');

        Route::put(
            '/{documentSequence}',
            [DocumentSequenceController::class, 'update']
        )->name('update');

        Route::patch(
            '/{documentSequence}/toggle-status',
            [DocumentSequenceController::class, 'toggleStatus']
        )->name('toggle-status');

    });


    Route::prefix('payment-methods')
    ->name('payment-methods.')
    ->group(function () {

        Route::get(
            '/',
            [PaymentMethodController::class, 'index']
        )
        ->name('index');

        Route::post(
            '/',
            [PaymentMethodController::class, 'store']
        )
        ->name('store');

        Route::get(
            '/{paymentMethod}/edit',
            [PaymentMethodController::class, 'edit']
        )
        ->name('edit');

        Route::put(
            '/{paymentMethod}',
            [PaymentMethodController::class, 'update']
        )
        ->name('update');

        Route::delete(
            '/{paymentMethod}',
            [PaymentMethodController::class, 'destroy']
        )
        ->name('destroy');

        Route::patch(
            '/{paymentMethod}/toggle-status',
            [
                PaymentMethodController::class,
                'toggleStatus'
            ]
        )
        ->name('toggle-status');

        Route::post(
            '/{id}/restore',
            [
                PaymentMethodController::class,
                'restore'
            ]
        )
        ->name('restore');


    });


   Route::prefix('activity-logs')
    ->name('activity-logs.')
    ->controller(ActivityLogController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/{activityLog}', 'show')
            ->name('show');

    });

});





