@extends('layouts.app')

@section('content')

<div class="emnex-dashboard">


{{-- ==========================================================
    DASHBOARD HEADER
=========================================================== --}}

<div class="dashboard-welcome mb-4">

    <div class="welcome-content">

        <span class="welcome-label">
            Dashboard Overview
        </span>

        <h2>
            Good morning, {{ auth()->user()->first_name }} 👋
        </h2>

        <p>
            Here is what is happening in your business today.
            Monitor the areas available to your account from one place.
        </p>

    </div>


    <div class="welcome-info">

        {{-- Branch --}}

        <div class="info-item">

            <i class="bi bi-shop"></i>

            <div>

                <small>
                    Branch
                </small>

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

            <div class="info-item">

                <i class="bi bi-pc-display"></i>

                <div>

                    <small>
                        Terminal
                    </small>

                    <strong>
                        {{ auth()->user()->terminal?->terminal_name() ?? 'All Terminals' }}
                    </strong>

                </div>

            </div>

        @endif


        {{-- Date --}}

        <div class="info-item">

            <i class="bi bi-calendar3"></i>

            <div>

                <small>
                    Today
                </small>

                <strong>
                    {{ now()->format('d M Y') }}
                </strong>

            </div>

        </div>

    </div>

</div>

{{-- ==========================================================
    KPI CARDS
=========================================================== --}}

<div class="row g-4 dashboard-kpi-row">


    {{-- ======================================================
        SALES
    ======================================================= --}}

    @if($canViewSales)

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card kpi-card-sales">

                {{-- TOP ROW --}}
                <div class="kpi-card-header">

                    <div class="kpi-card-heading">

                        <div class="kpi-icon sales">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <div>

                            <span class="kpi-label">
                                Sales
                            </span>

                            <small class="kpi-period">
                                {{ ucfirst(str_replace('_', ' ', $period)) }}
                            </small>

                        </div>

                    </div>


                    <span class="kpi-trend positive">

                        <i class="bi bi-arrow-up"></i>

                        12.5%

                    </span>

                </div>


                {{-- VALUE --}}
                <div class="kpi-value-section">


                <h2 class="kpi-value">
                    {{ \App\Helpers\CurrencyHelper::format($todaySales) }}
                </h2>



                    <span class="kpi-description">
                        Revenue generated
                    </span>

                </div>


                {{-- FOOTER --}}
                <div class="kpi-card-footer">

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

            <div class="kpi-card kpi-card-transactions">

                {{-- TOP ROW --}}
                <div class="kpi-card-header">

                    <div class="kpi-card-heading">

                        <div class="kpi-icon transaction">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <div>

                            <span class="kpi-label">
                                Transactions
                            </span>

                            <small class="kpi-period">
                                Today
                            </small>

                        </div>

                    </div>


                    <span class="kpi-trend neutral">

                        <i class="bi bi-clock"></i>

                        Today

                    </span>

                </div>


                {{-- VALUE --}}
                <div class="kpi-value-section">

                    <h2 class="kpi-value">
                        {{ number_format($todayTransactions) }}
                    </h2>

                    <span class="kpi-description">
                        Orders processed
                    </span>

                </div>


                {{-- FOOTER --}}
                <div class="kpi-card-footer">

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

            <div class="kpi-card kpi-card-customers">

                {{-- TOP ROW --}}
                <div class="kpi-card-header">

                    <div class="kpi-card-heading">

                        <div class="kpi-icon customer">
                            <i class="bi bi-people"></i>
                        </div>

                        <div>

                            <span class="kpi-label">
                                Customers
                            </span>

                            <small class="kpi-period">
                                Total
                            </small>

                        </div>

                    </div>


                    <span class="kpi-trend positive">

                        <i class="bi bi-person-plus"></i>

                        {{ $newCustomersToday }}

                    </span>

                </div>


                {{-- VALUE --}}
                <div class="kpi-value-section">

                    <h2 class="kpi-value">
                        {{ number_format($totalCustomers) }}
                    </h2>

                    <span class="kpi-description">
                        New customers this period
                    </span>

                </div>


                {{-- FOOTER --}}
                <div class="kpi-card-footer">

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

            <div class="kpi-card kpi-card-inventory">

                {{-- TOP ROW --}}
                <div class="kpi-card-header">

                    <div class="kpi-card-heading">

                        <div class="kpi-icon inventory">
                            <i class="bi bi-box-seam"></i>
                        </div>

                        <div>

                            <span class="kpi-label">
                                Inventory Value
                            </span>

                            <small class="kpi-period">
                                Current
                            </small>

                        </div>

                    </div>


                    <span class="kpi-trend warning">

                        <i class="bi bi-box"></i>

                        Stock

                    </span>

                </div>


                {{-- VALUE --}}
                <div class="kpi-value-section">

                  
                    <h2 class="kpi-value">
                        {{ \App\Helpers\CurrencyHelper::format($inventoryValue) }}
                    </h2>



                    <span class="kpi-description">
                        Current stock valuation
                    </span>

                </div>


                {{-- FOOTER --}}
                <div class="kpi-card-footer">

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


    {{-- ======================================================
        SALES PERFORMANCE
    ======================================================= --}}

    @if($canViewSales)

        <div class="col-xl-8">

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <h5>
                        Sales Performance
                    </h5>


                    <div class="dashboard-filter">

                        <button id="dashboardFilterBtn">

                            <span id="dashboardFilterLabel">
                                {{ ucfirst(str_replace('_', ' ', $period ?? 'this_week')) }}
                            </span>

                            <i class="bi bi-chevron-down"></i>

                        </button>


                        <div class="dashboard-filter-menu">

                            <a href="{{ route('dashboard', ['period' => 'today']) }}">
                                Today
                            </a>

                            <a href="{{ route('dashboard', ['period' => 'yesterday']) }}">
                                Yesterday
                            </a>

                            <a href="{{ route('dashboard', ['period' => 'this_week']) }}">
                                This Week
                            </a>

                            <a href="{{ route('dashboard', ['period' => 'this_month']) }}">
                                This Month
                            </a>

                            <a href="{{ route('dashboard', ['period' => 'this_year']) }}">
                                This Year
                            </a>

                            <a href="#" id="customRangeBtn">
                                Custom Range
                            </a>

                        </div>

                    </div>

                </div>


                @php

                    $hasChartData =
                        collect($salesChart)->sum('sales') > 0
                        ||
                        collect($salesChart)->sum('transactions') > 0;

                @endphp


                <div class="sales-chart-container">

                    @if($hasChartData)

                        <canvas id="salesChart"></canvas>

                    @else

                        <div class="chart-empty-state">

                            <div class="empty-icon">
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

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <h5>
                        Today's Activity
                    </h5>

                    <small class="text-muted">
                        {{ now()->format('d M Y') }}
                    </small>

                </div>


                <div class="activity-grid">


              
                {{-- Cash --}}

                <div class="activity-item">

                    <div class="activity-icon cash">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div class="activity-content">

                        <span>
                            Cash Sales
                        </span>

                        <h6>
                            {{ \App\Helpers\CurrencyHelper::format($cashSales) }}
                        </h6>

                    </div>

                </div>


                {{-- Card --}}

                <div class="activity-item">

                    <div class="activity-icon card">
                        <i class="bi bi-credit-card"></i>
                    </div>

                    <div class="activity-content">

                        <span>
                            Card / POS
                        </span>

                        <h6>
                            {{ \App\Helpers\CurrencyHelper::format($cardSales) }}
                        </h6>

                    </div>

                </div>


                {{-- Refund --}}

                <div class="activity-item">

                    <div class="activity-icon refund">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </div>

                    <div class="activity-content">

                        <span>
                            Refunds
                        </span>

                        <h6>
                            {{ \App\Helpers\CurrencyHelper::format($refunds) }}
                        </h6>

                    </div>

                </div>




                    {{-- Pending Orders --}}

                    @if($canViewOrders)

                        <div class="activity-item">

                            <div class="activity-icon pending">
                                <i class="bi bi-clock-history"></i>
                            </div>

                            <div class="activity-content">

                                <span>
                                    Pending Orders
                                </span>

                                <h6>
                                    {{ number_format($pendingOrders) }}
                                </h6>

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

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <h5>
                        Recent Transactions
                    </h5>

                </div>


                <div class="table-responsive">

                    <table class="table dashboard-table">

                        <thead>

                            <tr>

                                <th>
                                    Order No
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

                                    <td>
                                        {{ $order->order_number }}
                                    </td>

                                    <td>
                                        {{ $order->customer?->name ?? 'Walk-in Customer' }}
                                    </td>

                                  
                                    <td>
                                        {{ \App\Helpers\CurrencyHelper::format(
                                            $order->total_amount
                                        ) }}
                                    </td>



                                    <td>

                                        <span class="status success">
                                            {{ $order->payment_status }}
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center py-4">
                                        No transactions found.
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
        LOW STOCK
    ======================================================= --}}

    @if($canViewLowStock)

        <div class="{{ $canViewOrders ? 'col-xl-5' : 'col-xl-12' }}">

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <h5>
                        Low Stock Products
                    </h5>

                </div>


                <div class="stock-list">

                    @forelse($lowStockProducts as $stock)

                        <div>

                            <span>
                                {{ $stock->product->name }}
                            </span>

                            <strong class="danger">
                                {{ $stock->quantity }} left
                            </strong>

                        </div>

                    @empty

                        <div class="text-center py-4">
                            No low stock products.
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

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <h5>
                        Top Selling Products
                    </h5>

                </div>


                @forelse($topProducts as $product)

                    <div class="product-row">

                        <span>
                            {{ $product->product_name }}
                        </span>

                        <strong>
                            {{ number_format($product->total_quantity, 2) }}
                            units
                        </strong>

                       
                        <b>
                            {{ \App\Helpers\CurrencyHelper::format(
                                $product->total_sales
                            ) }}
                        </b>



                    </div>

                @empty

                    <div class="text-center py-4">
                        No sales recorded yet.
                    </div>

                @endforelse

            </div>

        </div>

    @endif



    {{-- ======================================================
        TERMINAL STATUS
    ======================================================= --}}

    @if($canViewTerminals)

        <div class="{{ $canViewSales ? 'col-xl-5' : 'col-xl-12' }}">

            <div class="dashboard-card">

                <div class="card-header-custom">

                    <h5>
                        Terminal Status
                    </h5>

                </div>


                <div class="terminal-status">

                    <h6>
                        {{ auth()->user()->terminal?->terminal_code ?? 'POS Terminal' }}
                    </h6>


                    <span class="online">
                        ● Active
                    </span>


                    <p>
                        Cashier:
                        {{ auth()->user()->first_name }}
                        {{ auth()->user()->last_name }}
                    </p>

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

const chartCanvas =
    document.getElementById('salesChart');


if (chartCanvas) {

    const chartData =
        @json($salesChart);


    const labels =
        chartData.map(
            item => item.day
        );


    const sales =
        chartData.map(
            item => item.sales
        );


    const transactions =
        chartData.map(
            item => item.transactions
        );


    new Chart(
        chartCanvas,
        {

            type: 'line',

            data: {

                labels,

                datasets: [

                    {

                        label: 'Sales',

                        data: sales,

                        tension: .35,

                        borderWidth: 3,

                        fill: true,

                    },


                    {

                        label: 'Transactions',

                        data: transactions,

                        tension: .35,

                        borderWidth: 2,

                        yAxisID: 'y1',

                    }

                ]

            },


            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {

                    mode: 'index',

                    intersect: false,

                },


                scales: {

                    y: {

                        beginAtZero: true

                    },


                    y1: {

                        position: 'right',

                        grid: {

                            drawOnChartArea: false

                        }

                    }

                }

            }

        }
    );

}

</script>

@endif

{{-- ==============================================================
DASHBOARD FILTER
=============================================================== --}}

@if($canViewSales)

<script>

const filterBtn =
    document.getElementById(
        'dashboardFilterBtn'
    );


const filterMenu =
    document.querySelector(
        '.dashboard-filter-menu'
    );


if (filterBtn && filterMenu) {

    filterBtn.addEventListener(
        'click',
        function (e) {

            e.stopPropagation();

            filterMenu.classList.toggle(
                'show'
            );

        }
    );


    document.addEventListener(
        'click',
        function () {

            filterMenu.classList.remove(
                'show'
            );

        }
    );

}

</script>

@endif

@endsection
