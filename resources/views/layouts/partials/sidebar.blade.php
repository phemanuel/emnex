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

                <img src="{{ asset('storage/'.auth()->user()->company->logo) }}">

            @else

                <div class="sidebar-brand-icon">
                    <i class="bi bi-grid-1x2-fill"></i>
                </div>

            @endif

            <div class="sidebar-brand-content">

                <div class="sidebar-brand-title">
                    EMNEX
                </div>

                <small class="sidebar-brand-subtitle">
                    Enterprise POS
                </small>

            </div>

        </a>

    </div>


    <!-- ==========================================
        Sidebar Navigation
    =========================================== -->

    <div class="sidebar-menu">

    <!-- ========================= -->
    <!-- MAIN -->
    <!-- ========================= -->

    <div class="menu-title">MAIN</div>

    <a href="javascript:void(0)" class="nav-link active">

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

    <div class="nav-group">

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

            <a href="#">
                <span class="sub-icon"><i class="bi bi-cart-plus"></i></span>
                <span>New Sale</span>
            </a>

            <a href="#">
                <span class="sub-icon"><i class="bi bi-receipt"></i></span>
                <span>Open Orders</span>
            </a>

            <a href="#">
                <span class="sub-icon"><i class="bi bi-pause-circle"></i></span>
                <span>Held Sales</span>
            </a>

            <a href="#">
                <span class="sub-icon"><i class="bi bi-arrow-return-left"></i></span>
                <span>Returns</span>
            </a>

            <a href="#">
                <span class="sub-icon"><i class="bi bi-cash-stack"></i></span>
                <span>Cash Drawer</span>
            </a>

        </div>

    </div>


    <!-- Catalog -->

    <div class="nav-group">

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

            <a href="#"><span class="sub-icon"><i class="bi bi-box"></i></span><span>Products</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-grid-3x3-gap"></i></span><span>Categories</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-rulers"></i></span><span>Units</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-percent"></i></span><span>Tax Rates</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-tag"></i></span><span>Discounts</span></a>

        </div>

    </div>


    <!-- Inventory -->

    <div class="nav-group">

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

            <a href="#"><span class="sub-icon"><i class="bi bi-boxes"></i></span><span>Stock Overview</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-sliders2"></i></span><span>Stock Adjustment</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-arrow-left-right"></i></span><span>Stock Transfer</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-clipboard-check"></i></span><span>Stock Count</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-exclamation-triangle"></i></span><span>Low Stock</span></a>

        </div>

    </div>


    <!-- Sales -->

    <div class="nav-group">

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

            <a href="#"><span class="sub-icon"><i class="bi bi-bag-check"></i></span><span>Orders</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-file-earmark-text"></i></span><span>Invoices</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-credit-card"></i></span><span>Payments</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-arrow-counterclockwise"></i></span><span>Returns</span></a>

        </div>

    </div>


    <!-- Customers -->

    <div class="nav-group">

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

            <a href="#"><span class="sub-icon"><i class="bi bi-person-lines-fill"></i></span><span>Customer List</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-people-fill"></i></span><span>Customer Groups</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-award"></i></span><span>Loyalty Program</span></a>

        </div>

    </div>


    <!-- Purchases -->

    <div class="nav-group">

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

            <a href="#"><span class="sub-icon"><i class="bi bi-building"></i></span><span>Suppliers</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-cart-check"></i></span><span>Purchase Orders</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-box-arrow-in-down"></i></span><span>Goods Received</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-arrow-return-left"></i></span><span>Purchase Returns</span></a>

        </div>

    </div>


    <!-- ========================= -->
    <!-- MANAGEMENT -->
    <!-- ========================= -->

    <div class="menu-title">MANAGEMENT</div>

    <!-- Reports -->

    <div class="nav-group">

        <button class="nav-parent">

            <div class="nav-left">

                <span class="nav-icon"><i class="bi bi-graph-up-arrow"></i></span>

                <span class="nav-title">Reports</span>

            </div>

            <i class="bi bi-chevron-right nav-chevron"></i>

        </button>

        <div class="nav-children">

            <a href="#"><span class="sub-icon"><i class="bi bi-graph-up"></i></span><span>Sales Report</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-bar-chart"></i></span><span>Inventory Report</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-cash-coin"></i></span><span>Profit & Loss</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-percent"></i></span><span>Tax Report</span></a>

        </div>

    </div>


    <!-- Administration -->

    <div class="nav-group">

        <button class="nav-parent">

            <div class="nav-left">

                <span class="nav-icon"><i class="bi bi-person-gear"></i></span>

                <span class="nav-title">Administration</span>

            </div>

            <i class="bi bi-chevron-right nav-chevron"></i>

        </button>

        <div class="nav-children">

            <a href="#"><span class="sub-icon"><i class="bi bi-person"></i></span><span>Users</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-person-badge"></i></span><span>Roles</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-shield-lock"></i></span><span>Permissions</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-shop"></i></span><span>Branches</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-display"></i></span><span>Terminals</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-building"></i></span><span>Company</span></a>

        </div>

    </div>


    <!-- ========================= -->
    <!-- SYSTEM -->
    <!-- ========================= -->

    <div class="menu-title">SYSTEM</div>

    <!-- Settings -->

    <div class="nav-group">

        <button class="nav-parent">

            <div class="nav-left">

                <span class="nav-icon"><i class="bi bi-sliders"></i></span>

                <span class="nav-title">Settings</span>

            </div>

            <i class="bi bi-chevron-right nav-chevron"></i>

        </button>

        <div class="nav-children">

            <a href="#"><span class="sub-icon"><i class="bi bi-gear"></i></span><span>General</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-display"></i></span><span>POS Settings</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-receipt-cutoff"></i></span><span>Receipt Settings</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-123"></i></span><span>Document Sequences</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-wallet2"></i></span><span>Payment Methods</span></a>

            <a href="#"><span class="sub-icon"><i class="bi bi-journal-text"></i></span><span>Audit Logs</span></a>

        </div>

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