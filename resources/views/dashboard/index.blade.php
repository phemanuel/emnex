@extends('layouts.app')


@section('content')

<div class="emnex-dashboard">


    {{-- Dashboard Header --}}
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
                Monitor sales, inventory and terminal activity from one place.
            </p>


        </div>




        <div class="welcome-info">


            <div class="info-item">

                <i class="bi bi-shop"></i>

                <div>
                    <small>
                        Branch
                    </small>

                    <strong>
                        {{ auth()->user()->branch?->name ?? 'All Branches' }}
                    </strong>
                </div>

            </div>



            <div class="info-item">

                <i class="bi bi-pc-display"></i>

                <div>
                    <small>
                        Terminal
                    </small>

                    <strong>
                        {{ auth()->user()->terminal?->displayName() ?? 'All Terminals' }}
                    </strong>
                </div>

            </div>



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



    {{-- KPI CARDS --}}
    <div class="row g-4 mb-4">


        {{-- Today's Sales --}}
        <div class="col-xl-3 col-md-6">

            <div class="kpi-card">


                <div class="kpi-top">

                    <div class="kpi-icon sales">
                        <i class="bi bi-cash-stack"></i>
                    </div>


                    <span class="kpi-trend positive">

                        <i class="bi bi-arrow-up"></i>
                        12.5%

                    </span>

                </div>



                <div class="kpi-content">


                    <span>
                        Today's Sales
                    </span>


                    <h2>
                       ₦{{ number_format($todaySales,2) }}
                    </h2>


                    <small>
                        Compared with yesterday
                    </small>


                </div>


            </div>

        </div>





        {{-- Transactions --}}
        <div class="col-xl-3 col-md-6">

            <div class="kpi-card">


                <div class="kpi-top">


                    <div class="kpi-icon transaction">
                        <i class="bi bi-receipt"></i>
                    </div>


                    <span class="kpi-trend neutral">
                        Today
                    </span>


                </div>



                <div class="kpi-content">


                    <span>
                        Transactions
                    </span>


                    <h2>
                        {{ $todayTransactions }}
                    </h2>


                    <small>
                        Completed sales
                    </small>


                </div>


            </div>

        </div>





        {{-- Customers --}}
        <div class="col-xl-3 col-md-6">


            <div class="kpi-card">


                <div class="kpi-top">


                    <div class="kpi-icon customer">
                        <i class="bi bi-people"></i>
                    </div>


                    <span class="kpi-trend positive">

                        <i class="bi bi-person-plus"></i>
                        {{ $newCustomersToday }}

                    </span>


                </div>



                <div class="kpi-content">


                    <span>
                        Customers
                    </span>


                    <h2>
                       {{ number_format($totalCustomers) }}

                    </h2>


                    <small>
                        New customers today
                    </small>


                </div>


            </div>


        </div>





        {{-- Inventory --}}
        <div class="col-xl-3 col-md-6">


            <div class="kpi-card">


                <div class="kpi-top">


                    <div class="kpi-icon inventory">
                        <i class="bi bi-box-seam"></i>
                    </div>


                    <span class="kpi-trend warning">

                        Stock

                    </span>


                </div>



                <div class="kpi-content">


                    <span>
                        Inventory Value
                    </span>


                    <h2>
                        ₦{{ number_format($inventoryValue,2) }}
                    </h2>


                    <small>
                        Current stock valuation
                    </small>


                </div>


            </div>


        </div>


    </div>



    {{-- MAIN DASHBOARD GRID --}}

    <div class="row g-4">


        {{-- Sales Performance --}}
        <div class="col-xl-8">


            <div class="dashboard-card">


                <div class="card-header-custom">

                    <h5>
                        Sales Performance
                    </h5>

                    <button>
                        This Week
                        <i class="bi bi-chevron-down"></i>
                    </button>

                </div>


                <div class="sales-chart-placeholder">

                    <div>
                        <i class="bi bi-bar-chart-line"></i>

                       <canvas id="salesChart"></canvas>

                    </div>

                </div>


            </div>


        </div>




        {{-- Today's Activity --}}

        <div class="col-xl-4">


            <div class="dashboard-card">


                <div class="card-header-custom">

                    <h5>
                        Today's Activity
                    </h5>

                </div>



                <div class="activity-list">


                    <div>
                        <span>
                            Cash Sales
                        </span>

                        <strong>
                           ₦{{ number_format($cashSales,2) }}
                        </strong>
                    </div>


                    <div>
                        <span>
                            Card Sales
                        </span>

                        <strong>
                            ₦{{ number_format($cardSales,2) }}
                        </strong>
                    </div>


                    <div>
                        <span>
                            Refunds
                        </span>

                        <strong>
                            ₦{{ number_format($refund,2) }}
                        </strong>
                    </div>


                    <div>
                        <span>
                            Pending Orders
                        </span>

                        <strong>
                            ₦{{ number_format($pendingOrders,2) }}
                        </strong>
                    </div>


                </div>


            </div>


        </div>





        {{-- Recent Transactions --}}

        <div class="col-xl-7">


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
                                    Invoice
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


                            @foreach($recentOrders as $order)

                            <tr>

                            <td>
                            {{ $order->order_number }}
                            </td>


                            <td>
                            {{ $order->customer?->name ?? 'Walk-in Customer' }}
                            </td>


                            <td>
                            ₦{{ number_format($order->total,2) }}
                            </td>


                            <td>

                            <span class="status success">

                            {{ $order->payment_status }}

                            </span>

                            </td>

                            </tr>

                            @endforeach

                            <tr>

                                <td>
                                    #INV-1002
                                </td>

                                <td>
                                    Mary James
                                </td>

                                <td>
                                    ₦18,500
                                </td>

                                <td>
                                    <span class="status success">
                                        Paid
                                    </span>
                                </td>

                            </tr>


                        </tbody>


                    </table>


                </div>


            </div>


        </div>





        {{-- Low Stock --}}

        <div class="col-xl-5">


            <div class="dashboard-card">


                <div class="card-header-custom">

                    <h5>
                        Low Stock Products
                    </h5>


                </div>


                <div class="stock-list">


                    @foreach($lowStockProducts as $stock)

                    <div>

                    <span>
                    {{ $stock->product->name }}
                    </span>


                    <strong class="danger">

                    {{ $stock->quantity }} left

                    </strong>

                    </div>

                    @endforeach
                </div>


            </div>


        </div>





        {{-- Top Selling Products --}}

        <div class="col-xl-7">


            <div class="dashboard-card">


                <div class="card-header-custom">

                    <h5>
                        Top Selling Products
                    </h5>


                </div>



                @foreach($topProducts as $product)

                <div class="product-row">

                <span>
                {{ $product->product_name }}
                </span>


                <strong>
                {{ $product->total_quantity }} units
                </strong>


                <b>
                ₦{{ number_format($product->total_sales,2) }}
                </b>


                </div>

                @endforeach



            </div>


        </div>




        {{-- Terminal Status --}}

        <div class="col-xl-5">


            <div class="dashboard-card">


                <div class="card-header-custom">

                    <h5>
                        Terminal Status
                    </h5>

                </div>


                <div class="terminal-status">


                    <h6>
                        POS-001
                    </h6>


                    <span class="online">
                        ● Active
                    </span>


                    <p>
                        Cashier: Admin User
                    </p>


                </div>


            </div>


        </div>



    </div>


</div>


@endsection