<?php

return [

    /*
    |--------------------------------------------------------------------------
    | System Roles
    |--------------------------------------------------------------------------
    */

    'roles' => [

        'owner' => [
            'display_name' => 'Owner',
            'description'  => 'System owner with unrestricted access.',
            'is_system'    => true,
        ],

        'administrator' => [
            'display_name' => 'Administrator',
            'description'  => 'Company administrator.',
            'is_system'    => true,
        ],

        'branch_manager' => [
            'display_name' => 'Branch Manager',
            'description'  => 'Manages a business branch.',
            'is_system'    => true,
        ],

        'supervisor' => [
            'display_name' => 'Supervisor',
            'description'  => 'Supervises daily business operations.',
            'is_system'    => true,
        ],

        'cashier' => [
            'display_name' => 'Cashier',
            'description'  => 'Processes customer sales.',
            'is_system'    => true,
        ],

        'inventory_manager' => [
            'display_name' => 'Inventory Manager',
            'description'  => 'Manages inventory and stock.',
            'is_system'    => true,
        ],

        'accountant' => [
            'display_name' => 'Accountant',
            'description'  => 'Handles financial operations.',
            'is_system'    => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [

        'dashboard' => [
            'view',
        ],

        'company' => [
            'view',
            'update',
        ],

        'branches' => [
            'view',
            'create',
            'update',
            'delete',
            'analytics',
            'export',
        ],

        'terminals' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'users' => [
            'view',
            'create',
            'update',
            'delete',
            'reset_password',
        ],

        'roles' => [
            'view',
            'create',
            'update',
            'delete',
            'assign_permissions',
        ],

        'permissions' => [
            'view',
        ],

        'products' => [
            'view',
            'create',
            'update',
            'delete',
            'import',
            'export',
        ],

        'categories' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'units' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'tax_rates' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'discounts' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'inventory' => [
            'view',
            'adjust_stock',
            'transfer_stock',
            'stock_count',
            'low_stock',
        ],

        'customers' => [
            'view',
            'create',
            'update',
            'delete',
            'export',
        ],

        'suppliers' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'purchases' => [
            'view',
            'create',
            'update',
            'delete',
            'approve',
        ],

        'pos' => [
            'sell',
            'hold_sale',
            'open_orders',
            'return_sale',
            'cash_drawer',
        ],

        'orders' => [
            'view',
            'create',
            'update',
            'cancel',
            'refund',
        ],

        'payments' => [
            'view',
            'create',
            'refund',
        ],

        'reports' => [
            'sales',
            'inventory',
            'profit_loss',
            'tax',
        ],

        'settings' => [
            'view',
            'update',
        ],

        'document_sequences' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'payment_methods' => [
            'view',
            'create',
            'update',
            'delete',
        ],

        'audit_logs' => [
            'view',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Role Permissions
    |--------------------------------------------------------------------------
    */

    'defaults' => [

        /*
        |--------------------------------------------------------------------------
        | Owner
        |--------------------------------------------------------------------------
        */

        'owner' => [
            '*',
        ],

        /*
        |--------------------------------------------------------------------------
        | Administrator
        |--------------------------------------------------------------------------
        */

        'administrator' => [
            '*',
        ],

        /*
        |--------------------------------------------------------------------------
        | Branch Manager
        |--------------------------------------------------------------------------
        */

        'branch_manager' => [

            'dashboard.view',

            'branches.view',
            'branches.update',

            'terminals.view',

            'users.view',

            'products.*',
            'categories.*',
            'units.*',
            'tax_rates.*',
            'discounts.*',

            'inventory.*',

            'customers.*',

            'suppliers.*',

            'purchases.*',

            'orders.*',

            'payments.view',

            'reports.sales',
            'reports.inventory',

            'pos.*',

        ],

        /*
        |--------------------------------------------------------------------------
        | Supervisor
        |--------------------------------------------------------------------------
        */

        'supervisor' => [

            'dashboard.view',

            'products.view',

            'inventory.view',

            'customers.view',

            'orders.view',

            'reports.sales',

            'pos.sell',
            'pos.hold_sale',
            'pos.open_orders',

        ],

        /*
        |--------------------------------------------------------------------------
        | Cashier
        |--------------------------------------------------------------------------
        */

        'cashier' => [

            'dashboard.view',

            'customers.view',
            'customers.create',

            'products.view',

            'orders.view',
            'orders.create',

            'payments.view',
            'payments.create',

            'pos.sell',
            'pos.hold_sale',
            'pos.open_orders',
            'pos.return_sale',
            'pos.cash_drawer',

        ],

        /*
        |--------------------------------------------------------------------------
        | Inventory Manager
        |--------------------------------------------------------------------------
        */

        'inventory_manager' => [

            'dashboard.view',

            'products.*',

            'categories.*',

            'units.*',

            'inventory.*',

            'suppliers.*',

            'purchases.*',

            'reports.inventory',

        ],

        /*
        |--------------------------------------------------------------------------
        | Accountant
        |--------------------------------------------------------------------------
        */

        'accountant' => [

            'dashboard.view',

            'payments.*',

            'orders.view',

            'customers.view',

            'reports.*',

        ],

    ],

];