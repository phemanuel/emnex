
<aside id="sidebar" class="sidebar">

    <!-- ==========================================
        Mobile Sidebar Header
    =========================================== -->

    <div class="mobile-sidebar-header">

        <button
            id="closeSidebarBtn"
            class="close-sidebar-btn"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>


    <!-- ==========================================
        Sidebar Header
    =========================================== -->

    <div class="sidebar-header">

        <a
            href="{{ route('dashboard') }}"
            class="sidebar-brand"
        >

            @if(auth()->user()->company->logo)

                <img
                    src="{{ asset('uploads/company/'.auth()->user()->company->logo) }}"
                    class="sidebar-company-logo"
                >

            @else

                <div class="sidebar-brand-icon">

                    {{ strtoupper(
                        substr(
                            auth()->user()->company->name,
                            0,
                            2
                        )
                    ) }}

                </div>

            @endif


            <div class="sidebar-brand-content">

                <div class="sidebar-company-name">

                    {{ auth()->user()->company->name }}

                </div>


                <div class="sidebar-product-name">

                    EMNEX POS

                </div>

            </div>

        </a>

    </div>


    @php

        /*
        |--------------------------------------------------------------------------
        | Active Menu State
        |--------------------------------------------------------------------------
        */

        $dashboardOpen =
            request()->routeIs('dashboard');


        $posOpen =
            request()->routeIs(
                'pos.*',
                'cash-drawer.*'
            );


        $catalogOpen =
            request()->routeIs(
                'products.*',
                'product-categories.*',
                'units.*',
                'tax-rates.*',
                'discounts.*'
            );


        $inventoryOpen =
            request()->routeIs(
                'stock.*',
                'stock-transfer.*',
                'stock-count.*',
                'low-stock.*'
            );


        $salesOpen =
            request()->routeIs(
                'orders.*',
                'invoices.*',
                'payments.*',
                'sales-returns.*'
            );


        $customerOpen =
            request()->routeIs(
                'customers.*',
                'customer-groups.*',
                'loyalty.*'
            );


        $purchaseOpen =
            request()->routeIs(
                'purchase.suppliers.*',
                'purchase-orders.*',
            );


        $reportOpen =
            request()->routeIs(
                'reports.*'
            );


        $adminOpen =
            request()->routeIs(
                'company.*',
                'branches.*',
                'terminals.*',
                'roles.*',
                'permissions.*',
                'users.*'
            );


        $settingsOpen =
            request()->routeIs(
                'settings.*',
                'document-sequences.*',
                'payment-methods.*',
                'activity-logs.*'
            );


        /*
        |--------------------------------------------------------------------------
        | Permission Groups
        |--------------------------------------------------------------------------
        */

        /*
        | POS
        */

        $canViewPos =
            canAccess('pos.sell') ||
            canAccess('pos.hold_sale') ||
            canAccess('pos.open_orders') ||
            canAccess('pos.return_sale') ||
            canAccess('pos.cash_drawer');


        /*
        | Catalog
        */

        $canViewCatalog =
            canAccess('products.view') ||
            canAccess('categories.view') ||
            canAccess('units.view') ||
            canAccess('tax_rates.view') ||
            canAccess('discounts.view');


        /*
        | Inventory
        */

        $canViewInventory =
            canAccess('inventory.view') ||
            canAccess('inventory.adjust_stock') ||
            canAccess('inventory.transfer_stock') ||
            canAccess('inventory.stock_count') ||
            canAccess('inventory.low_stock');


        /*
        | Sales
        */

        $canViewSales =
            canAccess('orders.view') ||
            canAccess('payments.view');


        /*
        | Customers
        */

        $canViewCustomers =
            canAccess('customers.view');


        /*
        | Purchases
        */

        $canViewPurchases =
            canAccess('suppliers.view') ||
            canAccess('purchases.view');


        /*
        | Reports
        */

        $canViewReports =
            canAccess('reports.sales') ||
            canAccess('reports.inventory') ||
            canAccess('reports.profit_loss') ||
            canAccess('reports.tax');


        /*
        | Administration
        */

        $canViewAdministration =
            canAccess('company.view') ||
            canAccess('branches.view') ||
            canAccess('terminals.view') ||
            canAccess('roles.view') ||
            canAccess('permissions.view') ||
            canAccess('users.view');


        /*
        | Settings
        */

        $canViewSettings =
            canAccess('settings.view') ||
            canAccess('document_sequences.view') ||
            canAccess('payment_methods.view') ||
            canAccess('audit_logs.view');

    @endphp


    <!-- ==========================================
        Sidebar Navigation
    =========================================== -->

    <div class="sidebar-menu">


        <!-- ========================= -->
        <!-- MAIN -->
        <!-- ========================= -->

        @if(canAccess('dashboard.view'))

            <div class="menu-title">

                MAIN

            </div>


            <a
                href="{{ route('dashboard') }}"
                class="nav-link
                    {{ request()->routeIs('dashboard') ? 'active' : '' }}"
            >

                <span class="nav-icon">

                    <i class="bi bi-grid-1x2-fill"></i>

                </span>

                <span class="nav-title">

                    Dashboard

                </span>

            </a>

        @endif



        <!-- ========================= -->
        <!-- OPERATIONS -->
        <!-- ========================= -->

        @if(
            $canViewPos ||
            $canViewCatalog ||
            $canViewInventory ||
            $canViewSales ||
            $canViewCustomers ||
            $canViewPurchases
        )

            <div class="menu-title">

                OPERATIONS

            </div>

        @endif



        <!-- ==========================================
            POINT OF SALE
        =========================================== -->

        @if($canViewPos)

            <div class="nav-group {{ $posOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-cart-check"></i>

                        </span>

                        <span class="nav-title">

                            Point of Sale

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('pos.sell'))

                        <a
                            href="{{ route('pos.index') }}"
                            class="{{ request()->routeIs('pos.index') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-cart-plus"></i>

                            </span>

                            <span>

                                New Sale

                            </span>

                        </a>

                    @endif


                    @if(canAccess('pos.open_orders'))

                        <a
                            href="{{ route('pos.open-orders') }}"
                            class="{{ request()->routeIs('pos.open-orders') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-receipt"></i>

                            </span>

                            <span>

                                Open Orders

                            </span>

                        </a>

                    @endif


                    @if(canAccess('pos.hold_sale'))

                        <a
                            href="{{ route('pos.held-sales') }}"
                            class="{{ request()->routeIs('pos.held-sales') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-pause-circle"></i>

                            </span>

                            <span>

                                Held Sales

                            </span>

                        </a>

                    @endif


                    @if(canAccess('pos.return_sale'))

                        <a
                            href="{{ route('pos.returns') }}"
                            class="{{ request()->routeIs('pos.returns') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-arrow-return-left"></i>

                            </span>

                            <span>

                                Returns

                            </span>

                        </a>

                    @endif


                    @if(canAccess('pos.cash_drawer'))

                        <a
                            href="{{ route('cash-drawer.index') }}"
                            class="{{ request()->routeIs('cash-drawer.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-cash-stack"></i>

                            </span>

                            <span>

                                Cash Drawer

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif



        <!-- ==========================================
            CATALOG
        =========================================== -->

        @if($canViewCatalog)

            <div class="nav-group {{ $catalogOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-box-seam"></i>

                        </span>

                        <span class="nav-title">

                            Catalog

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('categories.view'))

                        <a
                            href="{{ route('product-categories.index') }}"
                            class="{{ request()->routeIs('product-categories.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-grid-3x3-gap"></i>

                            </span>

                            <span>

                                Categories

                            </span>

                        </a>

                    @endif


                    @if(canAccess('units.view'))

                        <a
                            href="{{ route('units.index') }}"
                            class="{{ request()->routeIs('units.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-rulers"></i>

                            </span>

                            <span>

                                Units

                            </span>

                        </a>

                    @endif


                    @if(canAccess('tax_rates.view'))

                        <a
                            href="{{ route('tax-rates.index') }}"
                            class="{{ request()->routeIs('tax-rates.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-percent"></i>

                            </span>

                            <span>

                                Tax Rates

                            </span>

                        </a>

                    @endif


                    @if(canAccess('discounts.view'))

                        <a
                            href="{{ route('discounts.index') }}"
                            class="{{ request()->routeIs('discounts.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-tag"></i>

                            </span>

                            <span>

                                Discounts

                            </span>

                        </a>

                    @endif


                    @if(canAccess('products.view'))

                        <a
                            href="{{ route('products.index') }}"
                            class="{{ request()->routeIs('products.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-box"></i>

                            </span>

                            <span>

                                Products

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif



        <!-- ==========================================
            INVENTORY
        =========================================== -->

        @if($canViewInventory)

            <div class="nav-group {{ $inventoryOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-stack"></i>

                        </span>

                        <span class="nav-title">

                            Inventory

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('inventory.view'))

                        <a
                            href="{{ route('stock.index') }}"
                            class="{{ request()->routeIs('stock.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-boxes"></i>

                            </span>

                            <span>

                                Stock

                            </span>

                        </a>

                    @endif


                    @if(canAccess('inventory.transfer_stock'))

                        <a
                            href="{{ route('stock-transfer.index') }}"
                            class="{{ request()->routeIs('stock-transfer.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-arrow-left-right"></i>

                            </span>

                            <span>

                                Stock Transfer

                            </span>

                        </a>

                    @endif


                    @if(canAccess('inventory.stock_count'))

                        <a
                            href="{{ route('stock-count.index') }}"
                            class="{{ request()->routeIs('stock-count.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-clipboard-check"></i>

                            </span>

                            <span>

                                Stock Count

                            </span>

                        </a>

                    @endif


                    @if(canAccess('inventory.low_stock'))

                        <a
                            href="{{ route('low-stock.index') }}"
                            class="{{ request()->routeIs('low-stock.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-exclamation-triangle"></i>

                            </span>

                            <span>

                                Low Stock

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif



        <!-- ==========================================
            SALES
        =========================================== -->

        @if($canViewSales)

            <div class="nav-group {{ $salesOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-receipt"></i>

                        </span>

                        <span class="nav-title">

                            Sales

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('orders.view'))

                        <a
                            href="{{ route('orders.index') }}"
                            class="{{ request()->routeIs('orders.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-bag-check"></i>

                            </span>

                            <span>

                                Orders

                            </span>

                        </a>

                    @endif


                    @if(canAccess('orders.view'))

                        <a
                            href="{{ route('invoices.index') }}"
                            class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-file-earmark-text"></i>

                            </span>

                            <span>

                                Invoices

                            </span>

                        </a>

                    @endif


                    @if(canAccess('payments.view'))

                        <a
                            href="{{ route('payments.index') }}"
                            class="{{ request()->routeIs('payments.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-credit-card"></i>

                            </span>

                            <span>

                                Payments

                            </span>

                        </a>

                    @endif


                    @if(canAccess('orders.refund'))

                        <a
                            href="{{ route('sales-returns.index') }}"
                            class="{{ request()->routeIs('sales-returns.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-arrow-counterclockwise"></i>

                            </span>

                            <span>

                                Returns

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif



        <!-- ==========================================
            CUSTOMERS
        =========================================== -->

        @if($canViewCustomers)

            <div class="nav-group {{ $customerOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-people"></i>

                        </span>

                        <span class="nav-title">

                            Customers

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('customers.view'))

                        <a
                            href="{{ route('customers.index') }}"
                            class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-person-lines-fill"></i>

                            </span>

                            <span>

                                Customer Center

                            </span>

                        </a>

                    @endif


                    {{-- No customer-groups permission currently exists --}}


                </div>

            </div>

        @endif



        <!-- ==========================================
            PURCHASES
        =========================================== -->

        @if($canViewPurchases)

            <div class="nav-group {{ $purchaseOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-truck"></i>

                        </span>

                        <span class="nav-title">

                            Purchases

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('suppliers.view'))

                        <a
                            href="{{ route('purchase.suppliers.index') }}"
                            class="{{ request()->routeIs('purchase.suppliers.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-building"></i>

                            </span>

                            <span>

                                Suppliers

                            </span>

                        </a>

                    @endif


                    @if(canAccess('purchases.view'))

                        <a
                            href="{{ route('purchase-orders.index') }}"
                            class="{{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-cart-check"></i>

                            </span>

                            <span>

                                Purchase Orders

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif



        <!-- ========================= -->
        <!-- MANAGEMENT -->
        <!-- ========================= -->

        @if($canViewReports || $canViewAdministration)

            <div class="menu-title">

                MANAGEMENT

            </div>

        @endif



        <!-- ==========================================
            REPORTS
        =========================================== -->

        @if($canViewReports)

            <div class="nav-group {{ $reportOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-graph-up-arrow"></i>

                        </span>

                        <span class="nav-title">

                            Reports

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('reports.sales'))

                        <a
                            href="{{ route('reports.sales') }}"
                            class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-graph-up"></i>

                            </span>

                            <span>

                                Sales Report

                            </span>

                        </a>

                    @endif


                    @if(canAccess('reports.inventory'))

                        <a
                            href="{{ route('reports.inventory') }}"
                            class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-bar-chart"></i>

                            </span>

                            <span>

                                Inventory Report

                            </span>

                        </a>

                    @endif


                    @if(canAccess('reports.profit_loss'))

                        <a
                            href="{{ route('reports.profit-loss') }}"
                            class="{{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-cash-coin"></i>

                            </span>

                            <span>

                                Profit &amp; Loss

                            </span>

                        </a>

                    @endif


                    @if(canAccess('reports.tax'))

                        <a
                            href="{{ route('reports.tax') }}"
                            class="{{ request()->routeIs('reports.tax') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-percent"></i>

                            </span>

                            <span>

                                Tax Report

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif



        <!-- ==========================================
            ADMINISTRATION
        =========================================== -->

        @if($canViewAdministration)

            <div class="nav-group {{ $adminOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-person-gear"></i>

                        </span>

                        <span class="nav-title">

                            Administration

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('roles.view'))

                        <a
                            href="{{ route('roles.index') }}"
                            class="{{ request()->routeIs('roles.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-person-badge"></i>

                            </span>

                            <span>

                                Roles

                            </span>

                        </a>

                    @endif


                    @if(canAccess('users.view'))

                        <a
                            href="{{ route('users.index') }}"
                            class="{{ request()->routeIs('users.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-person"></i>

                            </span>

                            <span>

                                Users

                            </span>

                        </a>

                    @endif


                    @if(canAccess('company.view'))

                        <a
                            href="{{ route('company.index') }}"
                            class="{{ request()->routeIs('company.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-building"></i>

                            </span>

                            <span>

                                Company

                            </span>

                        </a>

                    @endif


                    @if(canAccess('branches.view'))

                        <a
                            href="{{ route('branches.index') }}"
                            class="{{ request()->routeIs('branches.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-shop"></i>

                            </span>

                            <span>

                                Branches

                            </span>

                        </a>

                    @endif


                    @if(canAccess('terminals.view'))

                        <a
                            href="{{ route('terminals.index') }}"
                            class="{{ request()->routeIs('terminals.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-display"></i>

                            </span>

                            <span>

                                Terminals

                            </span>

                        </a>

                    @endif


                    

                </div>

            </div>

        @endif



        <!-- ========================= -->
        <!-- SYSTEM -->
        <!-- ========================= -->

        @if($canViewSettings)

            <div class="menu-title">

                SYSTEM

            </div>



            <!-- ==========================================
                SETTINGS
            =========================================== -->

            <div class="nav-group {{ $settingsOpen ? 'open' : '' }}">

                <button class="nav-parent">

                    <div class="nav-left">

                        <span class="nav-icon">

                            <i class="bi bi-sliders"></i>

                        </span>

                        <span class="nav-title">

                            Settings

                        </span>

                    </div>

                    <i class="bi bi-chevron-right nav-chevron"></i>

                </button>


                <div class="nav-children">


                    @if(canAccess('settings.view'))

                        <a
                            href="{{ route('settings.index') }}"
                            class="{{ request()->routeIs('settings.index') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-gear"></i>

                            </span>

                            <span>

                                General

                            </span>

                        </a>

                    @endif


                    @if(canAccess('document_sequences.view'))

                        <a
                            href="{{ route('document-sequences.index') }}"
                            class="{{ request()->routeIs('document-sequences.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-123"></i>

                            </span>

                            <span>

                                Document Sequences

                            </span>

                        </a>

                    @endif


                    @if(canAccess('payment_methods.view'))

                        <a
                            href="{{ route('payment-methods.index') }}"
                            class="{{ request()->routeIs('payment-methods.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-wallet2"></i>

                            </span>

                            <span>

                                Payment Methods

                            </span>

                        </a>

                    @endif


                    @if(canAccess('audit_logs.view'))

                        <a
                            href="{{ route('activity-logs.index') }}"
                            class="{{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"
                        >

                            <span class="sub-icon">

                                <i class="bi bi-journal-text"></i>

                            </span>

                            <span>

                                Audit Logs

                            </span>

                        </a>

                    @endif


                </div>

            </div>

        @endif


    </div>


    <!-- ==========================================
        Sidebar Footer
    =========================================== -->

    <div class="sidebar-footer">

        <div class="user-card">

            <div class="user-avatar">

                {{ strtoupper(
                    substr(
                        auth()->user()->first_name,
                        0,
                        1
                    )
                ) }}

            </div>


            <div class="user-details">

                <div class="user-name">

                    {{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}

                </div>


                <small>

                    {{ auth()->user()->role?->display_name ?? 'User' }}

                </small>

            </div>

        </div>

    </div>

</aside>



<div id="sidebarOverlay" class="sidebar-overlay"></div>