<aside id="sidebar" class="sidebar">

<div class="mobile-sidebar-header">    

    <button id="closeSidebarBtn" class="close-sidebar-btn">

        <i class="bi bi-x-lg"></i>

    </button>

</div>
    <!-- ==========================================
        Sidebar Header
    =========================================== -->

   <div class="sidebar-header">

    <a href="{{ route('dashboard') }}" class="sidebar-brand">


        @if(auth()->user()->company->logo)

            <img 
                src="{{ asset('uploads/company/'.auth()->user()->company->logo) }}"
                class="sidebar-company-logo">

        @else

            <div class="sidebar-brand-icon">
                {{ strtoupper(substr(auth()->user()->company->name,0,2)) }}
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

    $dashboardOpen = request()->routeIs('dashboard');

    $posOpen = request()->routeIs(
        'pos.*',
        'cash-drawer.*'
    );

    $catalogOpen = request()->routeIs(
        'products.*',
        'categories.*',
        'units.*',
        'tax-rates.*',
        'discounts.*'
    );

    $inventoryOpen = request()->routeIs(
        'stock-overview.*',
        'stock-adjustments.*',
        'stock-transfers.*',
        'stock-counts.*',
        'low-stock.*'
    );

    $salesOpen = request()->routeIs(
        'orders.*',
        'invoices.*',
        'payments.*',
        'sales-returns.*'
    );

    $customerOpen = request()->routeIs(
        'customers.*',
        'customer-groups.*',
        'loyalty.*'
    );

    $purchaseOpen = request()->routeIs(
        'suppliers.*',
        'purchase-orders.*',
        'goods-received.*',
        'purchase-returns.*'
    );

    $reportOpen = request()->routeIs('reports.*');

    $adminOpen = request()->routeIs(
        'company.*',
        'branches.*',
        'terminals.*',
        'roles.*',
        'permissions.*',
        'users.*'
    );

    $settingsOpen = request()->routeIs(
        'settings.*',
        'document-sequences.*',
        'payment-methods.*',
        'audit-logs.*'
    );

    @endphp

    <!-- ==========================================
        Sidebar Navigation
    =========================================== -->

    <div class="sidebar-menu">

    <!-- ========================= -->
    <!-- MAIN -->
    <!-- ========================= -->

    <div class="menu-title">MAIN</div>

    <a href="{{ route('dashboard') }}"
    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

        <span class="nav-icon">
            <i class="bi bi-grid-1x2-fill"></i>
        </span>

        <span class="nav-title">
            Dashboard
        </span>

    </a>


    <!-- ========================= -->
    <!-- OPERATIONS -->
    <!-- ========================= -->

    <div class="menu-title">OPERATIONS</div>

    <!-- POS -->

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

            <a href="{{ route('pos.index') }}"
            class="{{ request()->routeIs('pos.index') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-cart-plus"></i>
                </span>

                <span>New Sale</span>

            </a>

            <a href="{{ route('pos.open-orders') }}"
            class="{{ request()->routeIs('pos.open-orders') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-receipt"></i>
                </span>

                <span>Open Orders</span>

            </a>

            <a href="{{ route('pos.held-sales') }}"
            class="{{ request()->routeIs('pos.held-sales') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-pause-circle"></i>
                </span>

                <span>Held Sales</span>

            </a>

            <a href="{{ route('pos.returns') }}"
            class="{{ request()->routeIs('pos.returns') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-arrow-return-left"></i>
                </span>

                <span>Returns</span>

            </a>

            <a href="{{ route('cash-drawer.index') }}"
            class="{{ request()->routeIs('cash-drawer.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-cash-stack"></i>
                </span>

                <span>Cash Drawer</span>

            </a>

        </div>

    </div>


    <!-- Catalog -->

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

            <a href="{{ route('products.index') }}"
            class="{{ request()->routeIs('products.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-box"></i>
                </span>

                <span>Products</span>

            </a>

            <a href="{{ route('categories.index') }}"
            class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-grid-3x3-gap"></i>
                </span>

                <span>Categories</span>

            </a>

            <a href="{{ route('units.index') }}"
            class="{{ request()->routeIs('units.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-rulers"></i>
                </span>

                <span>Units</span>

            </a>

            <a href="{{ route('tax-rates.index') }}"
            class="{{ request()->routeIs('tax-rates.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-percent"></i>
                </span>

                <span>Tax Rates</span>

            </a>

            <a href="{{ route('discounts.index') }}"
            class="{{ request()->routeIs('discounts.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-tag"></i>
                </span>

                <span>Discounts</span>

            </a>

        </div>

    </div>


    <!-- Inventory -->

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

            <a href="{{ route('stock-overview.index') }}"
            class="{{ request()->routeIs('stock-overview.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-boxes"></i>
                </span>

                <span>Stock Overview</span>

            </a>

            <a href="{{ route('stock-adjustments.index') }}"
            class="{{ request()->routeIs('stock-adjustments.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-sliders2"></i>
                </span>

                <span>Stock Adjustment</span>

            </a>

            <a href="{{ route('stock-transfers.index') }}"
            class="{{ request()->routeIs('stock-transfers.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-arrow-left-right"></i>
                </span>

                <span>Stock Transfer</span>

            </a>

            <a href="{{ route('stock-counts.index') }}"
            class="{{ request()->routeIs('stock-counts.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-clipboard-check"></i>
                </span>

                <span>Stock Count</span>

            </a>

            <a href="{{ route('low-stock.index') }}"
            class="{{ request()->routeIs('low-stock.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </span>

                <span>Low Stock</span>

            </a>

        </div>

    </div>


    <!-- Sales -->

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

            <a href="{{ route('orders.index') }}"
            class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-bag-check"></i>
                </span>

                <span>Orders</span>

            </a>

            <a href="{{ route('invoices.index') }}"
            class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </span>

                <span>Invoices</span>

            </a>

            <a href="{{ route('payments.index') }}"
            class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-credit-card"></i>
                </span>

                <span>Payments</span>

            </a>

            <a href="{{ route('sales-returns.index') }}"
            class="{{ request()->routeIs('sales-returns.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </span>

                <span>Returns</span>

            </a>

        </div>

    </div>

    <!-- Customers -->

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

            <a href="{{ route('customers.index') }}"
            class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </span>

                <span>Customer List</span>

            </a>

            <a href="{{ route('customer-groups.index') }}"
            class="{{ request()->routeIs('customer-groups.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-people-fill"></i>
                </span>

                <span>Customer Groups</span>

            </a>

            <a href="{{ route('loyalty.index') }}"
            class="{{ request()->routeIs('loyalty.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-award"></i>
                </span>

                <span>Loyalty Program</span>

            </a>

        </div>

    </div>


    <!-- Purchases -->

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

            <a href="{{ route('suppliers.index') }}"
            class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-building"></i>
                </span>

                <span>Suppliers</span>

            </a>

            <a href="{{ route('purchase-orders.index') }}"
            class="{{ request()->routeIs('purchase-orders.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-cart-check"></i>
                </span>

                <span>Purchase Orders</span>

            </a>

            <a href="{{ route('goods-received.index') }}"
            class="{{ request()->routeIs('goods-received.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-box-arrow-in-down"></i>
                </span>

                <span>Goods Received</span>

            </a>

            <a href="{{ route('purchase-returns.index') }}"
            class="{{ request()->routeIs('purchase-returns.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-arrow-return-left"></i>
                </span>

                <span>Purchase Returns</span>

            </a>

        </div>

    </div>


    <!-- ========================= -->
    <!-- MANAGEMENT -->
    <!-- ========================= -->

    <div class="menu-title">MANAGEMENT</div>

    <!-- Reports -->

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

            <a href="{{ route('reports.sales') }}"
            class="{{ request()->routeIs('reports.sales') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-graph-up"></i>
                </span>

                <span>Sales Report</span>

            </a>

            <a href="{{ route('reports.inventory') }}"
            class="{{ request()->routeIs('reports.inventory') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-bar-chart"></i>
                </span>

                <span>Inventory Report</span>

            </a>

            <a href="{{ route('reports.profit-loss') }}"
            class="{{ request()->routeIs('reports.profit-loss') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-cash-coin"></i>
                </span>

                <span>Profit &amp; Loss</span>

            </a>

            <a href="{{ route('reports.tax') }}"
            class="{{ request()->routeIs('reports.tax') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-percent"></i>
                </span>

                <span>Tax Report</span>

            </a>

        </div>

    </div>


    <!-- Administration -->

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

            <a href="{{ route('roles.index') }}"
            class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-person-badge"></i>
                </span>

                <span>Roles</span>

            </a>   
            
                <a href="{{ route('users.index') }}"
            class="{{ request()->routeIs('users.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-person"></i>
                </span>

                <span>Users</span>

            </a>
            

            <a href="{{ route('company.index') }}"
            class="{{ request()->routeIs('company.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-building"></i>
                </span>

                <span>Company</span>

            </a>

            <a href="{{ route('branches.index') }}"
            class="{{ request()->routeIs('branches.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-shop"></i>
                </span>

                <span>Branches</span>

            </a>

            <a href="{{ route('terminals.index') }}"
            class="{{ request()->routeIs('terminals.*') ? 'active' : '' }}">

                <span class="sub-icon">
                    <i class="bi bi-display"></i>
                </span>

                <span>Terminals</span>

            </a>        

        </div>

    </div>


    <!-- ========================= -->
    <!-- SYSTEM -->
    <!-- ========================= -->

    <div class="menu-title">SYSTEM</div>

    <!-- Settings -->

    <div class="nav-group {{ $settingsOpen ? 'open' : '' }}">

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

        <a href="{{ route('settings.index') }}"
           class="{{ request()->routeIs('settings.index') ? 'active' : '' }}">

            <span class="sub-icon">
                <i class="bi bi-gear"></i>
            </span>

            <span>General</span>

        </a>

        <a href="{{ route('settings.pos') }}"
           class="{{ request()->routeIs('settings.pos') ? 'active' : '' }}">

            <span class="sub-icon">
                <i class="bi bi-display"></i>
            </span>

            <span>POS Settings</span>

        </a>

        <a href="{{ route('settings.receipt') }}"
           class="{{ request()->routeIs('settings.receipt') ? 'active' : '' }}">

            <span class="sub-icon">
                <i class="bi bi-receipt-cutoff"></i>
            </span>

            <span>Receipt Settings</span>

        </a>

        <a href="{{ route('document-sequences.index') }}"
           class="{{ request()->routeIs('document-sequences.*') ? 'active' : '' }}">

            <span class="sub-icon">
                <i class="bi bi-123"></i>
            </span>

            <span>Document Sequences</span>

        </a>

        <a href="{{ route('payment-methods.index') }}"
           class="{{ request()->routeIs('payment-methods.*') ? 'active' : '' }}">

            <span class="sub-icon">
                <i class="bi bi-wallet2"></i>
            </span>

            <span>Payment Methods</span>

        </a>

        <a href="{{ route('audit-logs.index') }}"
           class="{{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">

            <span class="sub-icon">
                <i class="bi bi-journal-text"></i>
            </span>

            <span>Audit Logs</span>

        </a>

    </div>

</div>

    <!-- ==========================================
        Sidebar Footer
    =========================================== -->

    <div class="sidebar-footer">

        <div class="user-card">

            <div class="user-avatar">

                {{ strtoupper(substr(auth()->user()->first_name,0,1)) }}

            </div>

            <div class="user-details">

                <div class="user-name">

                    {{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}

                </div>

                <small>

                    Administrator

                </small>

            </div>

        </div>

    </div>

</aside>

<div id="sidebarOverlay" class="sidebar-overlay"></div>