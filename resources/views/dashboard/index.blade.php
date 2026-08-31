@extends('layouts.app')

@section('content')

<div class="emnex-dashboard">


{{-- ==========================================================
     DASHBOARD HEADER
     =========================================================== --}}

<div class="dashboard-header mb-4">

    {{-- ======================================================
         TOAST
         ====================================================== --}}

    @if(session('error'))

        <script>

            document.addEventListener(
                'DOMContentLoaded',
                function () {

                    showToast(
                        @json(session('error')),
                        'error'
                    );

                }
            );

        </script>

    @endif


    {{-- ======================================================
         HERO CONTENT
         ====================================================== --}}

    <div class="dashboard-header-main">

        <div class="dashboard-header-content">

            <span class="dashboard-header-eyebrow">
                Dashboard Overview
            </span>

            <h2 class="dashboard-header-title">
                Good morning,
                {{ auth()->user()->first_name }}
                <span>👋</span>
            </h2>

            <p class="dashboard-header-description">
                Here is what is happening in your business today.
                Monitor the areas available to your account from one place.
            </p>

        </div>


        {{-- ==================================================
             CONTEXT INFORMATION
             ================================================== --}}

        <div class="dashboard-context">

            {{-- Branch --}}
            <div class="dashboard-context-item">

                <div class="dashboard-context-icon">

                    <i class="bi bi-shop"></i>

                </div>

                <div class="dashboard-context-content">

                    <span>
                        Branch
                    </span>

                    <strong>

                        @if($canManageAllBranches)

                            All Branches

                        @else

                            {{ auth()->user()->branch?->name ?? 'Branch' }}

                        @endif

                    </strong>

                </div>

            </div>


            {{-- Terminal --}}
            @if($canViewTerminals)

                <div
                    class="dashboard-context-item
                    {{ auth()->user()->hasRole('cashier') ? 'dashboard-context-terminal' : '' }}
                    {{ auth()->user()->hasRole('cashier') && !auth()->user()->activeTerminalAssignment ? 'dashboard-context-warning' : '' }}"
                >

                    <div class="dashboard-context-icon">

                        <i class="bi bi-pc-display"></i>

                    </div>

                    <div class="dashboard-context-content">

                        <span>
                            Terminal
                        </span>

                        <strong>

                            @if(auth()->user()->hasRole('cashier'))

                                {{ auth()->user()->activeTerminalAssignment?->terminal?->terminal_name ?? 'No Terminal Assigned' }}

                            @else

                                All Terminals

                            @endif

                        </strong>

                    </div>

                </div>

            @endif


            {{-- Today --}}
            <div class="dashboard-context-item">

                <div class="dashboard-context-icon">

                    <i class="bi bi-calendar3"></i>

                </div>

                <div class="dashboard-context-content">

                    <span>
                        Today
                    </span>

                    <strong>
                        {{ now()->format('d M Y') }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ==========================================================
    DASHBOARD KPI CARDS
=========================================================== --}}

<div class="row g-4 dashboard-kpi-grid">


    {{-- ======================================================
        SALES
    ======================================================= --}}

    @if($canViewSales)

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-kpi-card dashboard-kpi-sales">

                {{-- Header --}}

                <div class="dashboard-kpi-top">

                    <div class="dashboard-kpi-title-group">

                        <div class="dashboard-kpi-icon">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                        <div>

                            <span class="dashboard-kpi-label">
                                Sales
                            </span>

                            <span class="dashboard-kpi-period">
                                {{ ucfirst(str_replace('_', ' ', $period)) }}
                            </span>

                        </div>

                    </div>


                    <span class="dashboard-kpi-indicator dashboard-kpi-indicator-positive">

                        <i class="bi bi-arrow-up"></i>

                        12.5%

                    </span>

                </div>


                {{-- Main Value --}}

                <div class="dashboard-kpi-main">

                    <h2 class="dashboard-kpi-value">

                        {{ \App\Helpers\CurrencyHelper::format($todaySales) }}

                    </h2>

                    <span class="dashboard-kpi-description">
                        Revenue generated
                    </span>

                </div>


                {{-- Footer --}}

                <div class="dashboard-kpi-footer">

                    <a href="{{ route('orders.index') }}">

                        <span>
                            View Sales
                        </span>

                        <i class="bi bi-arrow-up-right"></i>

                    </a>

                </div>

            </div>

        </div>

    @endif


    {{-- ======================================================
        TRANSACTIONS
    ======================================================= --}}

    @if($canViewOrders)

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-kpi-card dashboard-kpi-transactions">

                {{-- Header --}}

                <div class="dashboard-kpi-top">

                    <div class="dashboard-kpi-title-group">

                        <div class="dashboard-kpi-icon">

                            <i class="bi bi-receipt"></i>

                        </div>

                        <div>

                            <span class="dashboard-kpi-label">
                                Transactions
                            </span>

                            <span class="dashboard-kpi-period">
                                Today
                            </span>

                        </div>

                    </div>


                    <span class="dashboard-kpi-indicator dashboard-kpi-indicator-neutral">

                        <i class="bi bi-clock"></i>

                        Today

                    </span>

                </div>


                {{-- Main Value --}}

                <div class="dashboard-kpi-main">

                    <h2 class="dashboard-kpi-value">

                        {{ number_format($todayTransactions) }}

                    </h2>

                    <span class="dashboard-kpi-description">
                        Orders processed
                    </span>

                </div>


                {{-- Footer --}}

                <div class="dashboard-kpi-footer">

                    <a href="{{ route('orders.index') }}">

                        <span>
                            View Orders
                        </span>

                        <i class="bi bi-arrow-up-right"></i>

                    </a>

                </div>

            </div>

        </div>

    @endif


    {{-- ======================================================
        CUSTOMERS
    ======================================================= --}}

    @if($canViewCustomers)

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-kpi-card dashboard-kpi-customers">

                {{-- Header --}}

                <div class="dashboard-kpi-top">

                    <div class="dashboard-kpi-title-group">

                        <div class="dashboard-kpi-icon">

                            <i class="bi bi-people"></i>

                        </div>

                        <div>

                            <span class="dashboard-kpi-label">
                                Customers
                            </span>

                            <span class="dashboard-kpi-period">
                                Total
                            </span>

                        </div>

                    </div>


                    <span class="dashboard-kpi-indicator dashboard-kpi-indicator-positive">

                        <i class="bi bi-person-plus"></i>

                        {{ $newCustomersToday }}

                    </span>

                </div>


                {{-- Main Value --}}

                <div class="dashboard-kpi-main">

                    <h2 class="dashboard-kpi-value">

                        {{ number_format($totalCustomers) }}

                    </h2>

                    <span class="dashboard-kpi-description">
                        New customers this period
                    </span>

                </div>


                {{-- Footer --}}

                <div class="dashboard-kpi-footer">

                    <a href="{{ route('customers.index') }}">

                        <span>
                            Manage Customers
                        </span>

                        <i class="bi bi-arrow-up-right"></i>

                    </a>

                </div>

            </div>

        </div>

    @endif


    {{-- ======================================================
        INVENTORY
    ======================================================= --}}

    @if($canViewInventory)

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-kpi-card dashboard-kpi-inventory">

                {{-- Header --}}

                <div class="dashboard-kpi-top">

                    <div class="dashboard-kpi-title-group">

                        <div class="dashboard-kpi-icon">

                            <i class="bi bi-box-seam"></i>

                        </div>

                        <div>

                            <span class="dashboard-kpi-label">
                                Inventory Value
                            </span>

                            <span class="dashboard-kpi-period">
                                Current
                            </span>

                        </div>

                    </div>


                    <span class="dashboard-kpi-indicator dashboard-kpi-indicator-warning">

                        <i class="bi bi-box"></i>

                        Stock

                    </span>

                </div>


                {{-- Main Value --}}

                <div class="dashboard-kpi-main">

                    <h2 class="dashboard-kpi-value">

                        {{ \App\Helpers\CurrencyHelper::format($inventoryValue) }}

                    </h2>

                    <span class="dashboard-kpi-description">
                        Current stock valuation
                    </span>

                </div>


                {{-- Footer --}}

                <div class="dashboard-kpi-footer">

                    <a href="{{ route('stock.index') }}">

                        <span>
                            View Inventory
                        </span>

                        <i class="bi bi-arrow-up-right"></i>

                    </a>

                </div>

            </div>

        </div>

    @endif


</div>



{{-- ==========================================================
    MAIN DASHBOARD GRID
=========================================================== --}}

<div class="row g-4">

   
    {{-- ==================================================
        PERIOD FILTER
    =================================================== --}}

    <div class="dashboard-period-filter-card">

        <div class="dashboard-period-filter-content">

            <div class="dashboard-period-filter-heading">

                <span class="dashboard-period-filter-label">
                    Period
                </span>

                <span class="dashboard-period-filter-description">
                    Dashboard performance
                </span>

            </div>


            <div
                class="dashboard-sales-filter"
                id="dashboardSalesFilter"
            >

                <button
                    type="button"
                    class="dashboard-sales-filter-button"
                    id="dashboardFilterBtn"
                    aria-expanded="false"
                >

                    <span>

                        {{ ucfirst(
                            str_replace(
                                '_',
                                ' ',
                                $period ?? 'this_week'
                            )
                        ) }}

                    </span>

                    <i class="bi bi-chevron-down"></i>

                </button>


                <div
                    class="dashboard-sales-filter-menu"
                    id="dashboardSalesFilterMenu"
                >

                    <a
                        href="{{ route(
                            'dashboard',
                            ['period' => 'today']
                        ) }}"
                    >
                        Today
                    </a>


                    <a
                        href="{{ route(
                            'dashboard',
                            ['period' => 'yesterday']
                        ) }}"
                    >
                        Yesterday
                    </a>


                    <a
                        href="{{ route(
                            'dashboard',
                            ['period' => 'this_week']
                        ) }}"
                    >
                        This Week
                    </a>


                    <a
                        href="{{ route(
                            'dashboard',
                            ['period' => 'this_month']
                        ) }}"
                    >
                        This Month
                    </a>


                    <a
                        href="{{ route(
                            'dashboard',
                            ['period' => 'this_year']
                        ) }}"
                    >
                        This Year
                    </a>


                    <a
                        href="#"
                        id="customRangeBtn"
                    >
                        Custom Range
                    </a>

                </div>

            </div>

        </div>

    </div>


    
    {{-- ======================================================
    SALES PERFORMANCE
    ======================================================= --}}

    @if($canViewSales)

    
    <div class="col-xl-8 dashboard-sales-column">

        <div class="dashboard-sales-card">


            {{-- ==================================================
                HEADER
            =================================================== --}}

            <div class="dashboard-sales-header">

                <div class="dashboard-sales-heading">

                    <span class="dashboard-sales-eyebrow">
                        Overview
                    </span>

                    <h5 class="dashboard-sales-title">
                        Sales Performance
                    </h5>

                    <span class="dashboard-sales-subtitle">
                        Revenue and transaction activity
                    </span>

                </div>
                

            </div>


            {{-- ==================================================
                CHART
            =================================================== --}}

            @php

                $hasChartData =
                    collect($salesChart)->sum('sales') > 0
                    ||
                    collect($salesChart)->sum('transactions') > 0;

            @endphp


            <div class="dashboard-sales-chart">

                @if($hasChartData)

                    <canvas id="salesChart"></canvas>

                @else

                    <div class="dashboard-sales-empty">

                        <div class="dashboard-sales-empty-icon">

                            <i class="bi bi-bar-chart-line"></i>

                        </div>


                        <h5>
                            No Sales Data Available
                        </h5>


                        <p>
                            There are no completed sales for the selected period.
                            Once transactions are recorded, your sales performance
                            chart will appear here automatically.
                        </p>

                    </div>

                @endif

            </div>


        </div>

    </div>


    @endif



    
    {{-- ======================================================
        TODAY'S ACTIVITY
    ======================================================= --}}

    @if($canViewPayments)

        <div class="col-xl-4">

            <div class="dashboard-activity-card">


                {{-- ==================================================
                    HEADER
                =================================================== --}}

                <div class="dashboard-activity-header">

                    <div>

                        <span class="dashboard-activity-eyebrow">
                            Today
                        </span>

                        <h5 class="dashboard-activity-title">
                            Today's Activity
                        </h5>

                    </div>


                    <span class="dashboard-activity-date">

                        {{ now()->format('d M Y') }}

                    </span>

                </div>


              
              
                {{-- ==================================================
                    ACTIVITY LIST
                =================================================== --}}

                <div class="dashboard-activity-list">


                    {{-- ==================================================
                        Cash
                    =================================================== --}}

                    <div class="dashboard-activity-item dashboard-activity-cash">

                        <div class="dashboard-activity-icon">

                            <i class="bi bi-cash-stack"></i>

                        </div>


                        <div class="dashboard-activity-content">

                            <span class="dashboard-activity-label">
                                Cash Sales
                            </span>


                            <strong
                                class="dashboard-activity-value dashboard-activity-value-clickable"
                                title="{{ \App\Helpers\CurrencyHelper::format($cashSales) }}"
                            >

                                {{ \App\Helpers\CurrencyHelper::format($cashSales) }}

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                        Card / POS
                    =================================================== --}}

                    <div class="dashboard-activity-item dashboard-activity-card-payment">

                        <div class="dashboard-activity-icon">

                            <i class="bi bi-credit-card"></i>

                        </div>


                        <div class="dashboard-activity-content">

                            <span class="dashboard-activity-label">
                                Card / POS
                            </span>


                            <strong
                                class="dashboard-activity-value dashboard-activity-value-clickable"
                                title="{{ \App\Helpers\CurrencyHelper::format($cardSales) }}"
                            >

                                {{ \App\Helpers\CurrencyHelper::format($cardSales) }}

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                        Bank Transfer
                    =================================================== --}}

                    <div class="dashboard-activity-item dashboard-activity-transfer">

                        <div class="dashboard-activity-icon">

                            <i class="bi bi-bank"></i>

                        </div>


                        <div class="dashboard-activity-content">

                            <span class="dashboard-activity-label">
                                Bank Transfer
                            </span>


                            <strong
                                class="dashboard-activity-value dashboard-activity-value-clickable"
                                title="{{ \App\Helpers\CurrencyHelper::format($transferSales) }}"
                            >

                                {{ \App\Helpers\CurrencyHelper::format($transferSales) }}

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                        Wallet
                    =================================================== --}}

                    <div class="dashboard-activity-item dashboard-activity-wallet">

                        <div class="dashboard-activity-icon">

                            <i class="bi bi-wallet2"></i>

                        </div>


                        <div class="dashboard-activity-content">

                            <span class="dashboard-activity-label">
                                Wallet
                            </span>


                            <strong
                                class="dashboard-activity-value dashboard-activity-value-clickable"
                                title="{{ \App\Helpers\CurrencyHelper::format($walletSales) }}"
                            >

                                {{ \App\Helpers\CurrencyHelper::format($walletSales) }}

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                        Refunds
                    =================================================== --}}

                    <div class="dashboard-activity-item dashboard-activity-refund">

                        <div class="dashboard-activity-icon">

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </div>


                        <div class="dashboard-activity-content">

                            <span class="dashboard-activity-label">
                                Refunds
                            </span>


                            <strong
                                class="dashboard-activity-value dashboard-activity-value-clickable"
                                title="{{ \App\Helpers\CurrencyHelper::format($refunds) }}"
                            >

                                {{ \App\Helpers\CurrencyHelper::format($refunds) }}

                            </strong>

                        </div>

                    </div>


                    {{-- ==================================================
                        Pending Orders
                    =================================================== --}}

                    @if($canViewOrders)

                        <div class="dashboard-activity-item dashboard-activity-pending">

                            <div class="dashboard-activity-icon">

                                <i class="bi bi-clock-history"></i>

                            </div>


                            <div class="dashboard-activity-content">

                                <span class="dashboard-activity-label">
                                    Pending Orders
                                </span>


                                <strong
                                    class="dashboard-activity-value"
                                >

                                    {{ number_format($pendingOrders) }}

                                </strong>

                            </div>

                        </div>

                    @endif


                </div>

            </div>

        </div>

    @endif
    
    {{-- ======================================================
        RECENT TRANSACTIONS
    ======================================================= --}}

    @if($canViewOrders)

        <div class="{{ $canViewLowStock ? 'col-xl-7' : 'col-xl-12' }}">

            <div class="dashboard-transactions-card">


                {{-- ==================================================
                    Header
                =================================================== --}}

                <div class="dashboard-transactions-header">

                    <div>

                        <span class="dashboard-transactions-eyebrow">
                            Sales activity
                        </span>

                        <h5 class="dashboard-transactions-title">
                            Recent Transactions
                        </h5>

                        <p class="dashboard-transactions-subtitle">
                            Latest orders and payment activity
                        </p>

                    </div>


                    <a
                        href="{{ route('orders.index') }}"
                        class="dashboard-transactions-view-all"
                    >

                        <span>
                            View all
                        </span>

                        <i class="bi bi-arrow-up-right"></i>

                    </a>

                </div>


                {{-- ==================================================
                    Table
                =================================================== --}}

                <div class="table-responsive">

                    <table class="dashboard-transactions-table">

                        <thead>

                            <tr>

                                <th>
                                    Order
                                </th>

                                <th>
                                    Customer
                                </th>

                                <th>
                                    Amount
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($recentOrders as $order)

                                <tr>


                                    {{-- Order --}}

                                    <td>

                                        <div class="dashboard-transaction-order">

                                            <span class="dashboard-transaction-order-number">

                                                {{ $order->order_no }}

                                            </span>

                                        </div>

                                    </td>

                                    
                                  
                                  
                                    {{-- ==================================================
                                        Customer
                                    =================================================== --}}

                                    <td>

                                        <div class="dashboard-transaction-customer">

                                            <div class="dashboard-transaction-avatar">

                                                @if($order->customer)

                                                    {{ strtoupper(
                                                        substr(
                                                            $order->customer->displayName(),
                                                            0,
                                                            1
                                                        )
                                                    ) }}

                                                @else

                                                    <i class="bi bi-person"></i>

                                                @endif

                                            </div>


                                            <span class="dashboard-transaction-customer-name">

                                                {{ $order->customer
                                                    ? $order->customer->displayName()
                                                    : 'Walk-in Customer'
                                                }}

                                            </span>

                                        </div>

                                    </td>



                                    {{-- Amount --}}

                                    <td>

                                        <strong class="dashboard-transaction-amount">

                                            {{ \App\Helpers\CurrencyHelper::format(
                                                $order->total
                                            ) }}

                                        </strong>

                                    </td>


                                    {{-- Status --}}

                                    <td>

                                        <span
                                            class="dashboard-transaction-status dashboard-transaction-status-success"
                                        >

                                            <span class="dashboard-transaction-status-dot"></span>

                                            {{ $order->payment_status }}

                                        </span>

                                    </td>


                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="dashboard-transactions-empty"
                                    >

                                        <div class="dashboard-transactions-empty-icon">

                                            <i class="bi bi-receipt"></i>

                                        </div>

                                        <strong>
                                            No transactions found
                                        </strong>

                                        <span>
                                            Recent sales transactions will appear here.
                                        </span>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif
   
    {{-- ======================================================
        LOW STOCK PRODUCTS
    ======================================================= --}}

    @if($canViewLowStock)

        <div class="{{ $canViewOrders ? 'col-xl-5' : 'col-xl-12' }}">

            <div class="dashboard-low-stock-card">


                {{-- ==================================================
                    Header
                =================================================== --}}

                <div class="dashboard-low-stock-header">

                    <div>

                        <span class="dashboard-low-stock-eyebrow">
                            Inventory Alert
                        </span>

                        <h5 class="dashboard-low-stock-title">
                            Low Stock Products
                        </h5>

                    </div>


                    <div class="dashboard-low-stock-header-icon">

                        <i class="bi bi-box-seam"></i>

                    </div>

                </div>


                {{-- ==================================================
                    Product List
                =================================================== --}}

                <div class="dashboard-low-stock-list">

                    @forelse($lowStockProducts as $stock)

                        <div class="dashboard-low-stock-item">


                            {{-- Product Icon --}}

                            <div class="dashboard-low-stock-product-icon">

                                <i class="bi bi-box"></i>

                            </div>


                            {{-- Product Information --}}

                            <div class="dashboard-low-stock-product">

                                <span class="dashboard-low-stock-product-name">

                                    {{ $stock->product->name }}

                                </span>

                                <span class="dashboard-low-stock-product-label">

                                    Stock remaining

                                </span>

                            </div>


                            {{-- Quantity --}}

                            <div class="dashboard-low-stock-quantity">

                                <strong>

                                    {{ $stock->quantity }}

                                </strong>

                                <span>
                                    left
                                </span>

                            </div>


                            {{-- Arrow --}}

                            <i class="bi bi-chevron-right dashboard-low-stock-arrow"></i>

                        </div>

                    @empty

                        <div class="dashboard-low-stock-empty">

                            <div class="dashboard-low-stock-empty-icon">

                                <i class="bi bi-check2-circle"></i>

                            </div>

                            <strong>
                                Inventory looks good
                            </strong>

                            <span>
                                No low stock products at the moment.
                            </span>

                        </div>

                    @endforelse

                </div>


            </div>

        </div>

    @endif


    {{-- ======================================================
        TOP SELLING PRODUCTS
    ======================================================= --}}

    @if($canViewSales)

        <div class="{{ $canViewTerminals ? 'col-xl-7' : 'col-xl-12' }}">

            <div class="dashboard-top-products-card">


                {{-- ==================================================
                    Header
                =================================================== --}}

                <div class="dashboard-top-products-header">

                    <div>

                        <span class="dashboard-top-products-eyebrow">
                            Sales Performance
                        </span>

                        <h5 class="dashboard-top-products-title">
                            Top Selling Products
                        </h5>

                    </div>


                    <div class="dashboard-top-products-header-icon">

                        <i class="bi bi-trophy"></i>

                    </div>

                </div>


                {{-- ==================================================
                    Product List
                =================================================== --}}

                <div class="dashboard-top-products-list">

                    @forelse($topProducts as $index => $product)

                        <div class="dashboard-top-products-item">


                            {{-- Ranking --}}

                            <div class="dashboard-top-products-rank">

                                {{ $index + 1 }}

                            </div>


                            {{-- Product Information --}}

                            <div class="dashboard-top-products-product">

                                <span class="dashboard-top-products-name">

                                    {{ $product->product_name }}

                                </span>

                                <span class="dashboard-top-products-units">

                                    {{ number_format(
                                        $product->total_quantity,
                                        2
                                    ) }}

                                    units sold

                                </span>

                            </div>


                            {{-- Sales Value --}}

                            <div class="dashboard-top-products-sales">

                                <span>
                                    Sales
                                </span>

                                <strong>

                                    {{ \App\Helpers\CurrencyHelper::format(
                                        $product->total_sales
                                    ) }}

                                </strong>

                            </div>


                            {{-- Arrow --}}

                            <i class="bi bi-chevron-right dashboard-top-products-arrow"></i>

                        </div>

                    @empty

                        <div class="dashboard-top-products-empty">

                            <div class="dashboard-top-products-empty-icon">

                                <i class="bi bi-bar-chart-line"></i>

                            </div>

                            <strong>
                                No sales recorded yet
                            </strong>

                            <span>
                                Product performance will appear here once sales are recorded.
                            </span>

                        </div>

                    @endforelse

                </div>


            </div>

        </div>

    @endif

    {{-- ======================================================
        TERMINAL STATUS
    ======================================================= --}}

    @if($canViewTerminals)

        <div class="{{ $canViewSales ? 'col-xl-5' : 'col-xl-12' }}">

            <div class="dashboard-terminal-card">


                {{-- ==================================================
                    Header
                =================================================== --}}

                <div class="dashboard-terminal-header">

                    <div>

                        <span class="dashboard-terminal-eyebrow">
                            Point of Sale
                        </span>

                        <h5 class="dashboard-terminal-title">
                            Terminal Status
                        </h5>

                    </div>


                    <div class="dashboard-terminal-header-icon">

                        <i class="bi bi-pc-display"></i>

                    </div>

                </div>


                {{-- ==================================================
                    Terminal Content
                =================================================== --}}

                <div class="dashboard-terminal-body">


                    {{-- Terminal Identity --}}

                    <div class="dashboard-terminal-identity">

                        <div class="dashboard-terminal-icon">

                            <i class="bi bi-display"></i>

                        </div>


                        <div class="dashboard-terminal-info">

                            <span class="dashboard-terminal-label">
                                Terminal
                            </span>

                            <strong class="dashboard-terminal-code">

                                {{ auth()->user()->terminal?->terminal_code
                                    ?? 'POS Terminal' }}

                            </strong>

                        </div>


                        {{-- Status --}}

                        <div class="dashboard-terminal-status">

                            <span class="dashboard-terminal-status-dot"></span>

                            <span>
                                Active
                            </span>

                        </div>

                    </div>


                    {{-- Divider --}}

                    <div class="dashboard-terminal-divider"></div>


                    {{-- Cashier --}}

                    <div class="dashboard-terminal-cashier">

                        <div class="dashboard-terminal-cashier-icon">

                            <i class="bi bi-person"></i>

                        </div>


                        <div class="dashboard-terminal-cashier-info">

                            <span>
                                Cashier
                            </span>

                            <strong>

                                {{ auth()->user()->first_name }}
                                {{ auth()->user()->last_name }}

                            </strong>

                        </div>

                    </div>


                </div>


            </div>

        </div>

    @endif



</div>


</div>

{{-- ==============================================================
SALES CHART
=============================================================== --}}

@if($canViewSales)

<script>
(function () {

    function initializeDashboardSalesFilter() {

        console.log(
            'SALES FILTER: INITIALIZE RUNNING'
        );


        const filter =
            document.getElementById(
                'dashboardSalesFilter'
            );

        const button =
            document.getElementById(
                'dashboardFilterBtn'
            );

        const menu =
            document.getElementById(
                'dashboardSalesFilterMenu'
            );


        console.log(
            'SALES FILTER ELEMENTS:',
            {
                filter: filter,
                button: button,
                menu: menu
            }
        );


        if (
            !filter ||
            !button ||
            !menu
        ) {

            console.log(
                'SALES FILTER: ELEMENT MISSING'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Test Direct Click
        |--------------------------------------------------------------------------
        */

        button.onclick = function (event) {

            console.log(
                'SALES FILTER: CLICK FIRED'
            );


            event.preventDefault();


            const isOpen =
                filter.classList.contains(
                    'is-open'
                );


            console.log(
                'SALES FILTER: BEFORE',
                filter.className
            );


            if (isOpen) {

                filter.classList.remove(
                    'is-open'
                );

                button.setAttribute(
                    'aria-expanded',
                    'false'
                );

            } else {

                filter.classList.add(
                    'is-open'
                );

                button.setAttribute(
                    'aria-expanded',
                    'true'
                );

            }


            console.log(
                'SALES FILTER: AFTER',
                filter.className
            );

        };

    }


    if (
        document.readyState ===
        'loading'
    ) {

        document.addEventListener(
            'DOMContentLoaded',
            initializeDashboardSalesFilter
        );

    } else {

        initializeDashboardSalesFilter();

    }

})();
    </script>
<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const chartCanvas =
                document.getElementById(
                    'salesChart'
                );


            if (
                !chartCanvas ||
                typeof Chart === 'undefined'
            ) {

                return;

            }


            const chartData =
                @json($salesChart ?? []);


            if (
                !Array.isArray(chartData) ||
                chartData.length === 0
            ) {

                return;

            }


            const labels =
                chartData.map(
                    item => item.day ?? ''
                );


            const sales =
                chartData.map(
                    item =>
                        Number(item.sales ?? 0)
                );


            const transactions =
                chartData.map(
                    item =>
                        Number(item.transactions ?? 0)
                );


            new Chart(
                chartCanvas,
                {

                    type: 'line',


                    data: {

                        labels: labels,

                        datasets: [

                            {
                                label: 'Sales',

                                data: sales,

                                tension: 0.35,

                                borderWidth: 3,

                                fill: true,

                                pointRadius: 3,

                                pointHoverRadius: 5
                            },


                            {
                                label: 'Transactions',

                                data: transactions,

                                tension: 0.35,

                                borderWidth: 2,

                                yAxisID: 'y1',

                                pointRadius: 3,

                                pointHoverRadius: 5
                            }

                        ]

                    },


                    options: {

                        responsive: true,

                        maintainAspectRatio: false,


                        interaction: {

                            mode: 'index',

                            intersect: false

                        },


                        plugins: {

                            legend: {

                                display: true,

                                position: 'top',

                                align: 'end'

                            },

                            tooltip: {

                                mode: 'index',

                                intersect: false

                            }

                        },


                        scales: {

                            x: {

                                grid: {

                                    display: false

                                }

                            },


                            y: {

                                beginAtZero: true,

                                ticks: {

                                    precision: 0

                                }

                            },


                            y1: {

                                beginAtZero: true,

                                position: 'right',

                                grid: {

                                    drawOnChartArea: false

                                },

                                ticks: {

                                    precision: 0

                                }

                            }

                        }

                    }

                }
            );

        }
    );

</script>


@endif


{{-- ==============================================================
DASHBOARD FILTER
=============================================================== --}}

@if($canViewSales)


<script>
document.addEventListener(
    'click',
    function (event) {

        const value =
            event.target.closest(
                '.dashboard-activity-value-clickable'
            );


        document
            .querySelectorAll(
                '.dashboard-activity-value-clickable.dashboard-value-expanded'
            )
            .forEach(
                element => {

                    if (element !== value) {

                        element.classList.remove(
                            'dashboard-value-expanded'
                        );

                    }

                }
            );


        if (!value) {

            return;

        }


        value.classList.toggle(
            'dashboard-value-expanded'
        );

    }
);
    </script>

@endif

@endsection
