{{-- ==========================================================
    EMNEX POS — SALES REPORT
    ----------------------------------------------------------
    File:
    resources/views/admin/reports/sales/index.blade.php

    Purpose:
    Main Sales Report workspace.

    Structure:
    - Page Header
    - Filters
    - KPI Statistics
    - Sales Charts
    - Product Performance
    - Category Performance
    - Payment Performance
    - Cashier Performance
    - Customer Performance
    - Transactions
    - Transaction Inspector

    Notes:
    - This is the dedicated Sales Report index.
    - There is NO general Reports index.
    - Data loading will be handled by sales-report.js.
========================================================== --}}

@extends('layouts.app')

@section('title', 'Sales Report')


@section('content')

    {{-- ======================================================
        SALES REPORT WORKSPACE
    ======================================================= --}}
    <div
        class="sales-report-page"
        id="sales-report-page"
        data-report-url="{{ route('reports.sales.data') }}"
        data-export-url="{{ route('reports.sales.export') }}"
    >

        {{-- ==================================================
            PAGE HEADER
        =================================================== --}}
        <div class="sales-report-header">

            <div class="sales-report-header-content">

                <div class="sales-report-heading">

                    <div class="sales-report-eyebrow">
                        <i class="bi bi-bar-chart-line"></i>
                        Reports
                    </div>

                    <h1 class="sales-report-title">
                        Sales Report
                    </h1>

                    <p class="sales-report-description">
                        Monitor sales performance, transactions, products,
                        customers, cashiers and payment activity.
                    </p>

                </div>

                {{-- ------------------------------------------
                    HEADER ACTIONS
                ------------------------------------------- --}}
                @permission('reports.export')
                    <div class="sales-report-actions">

                        <div class="dropdown">

                            <button
                                type="button"
                                class="btn sales-report-export-btn dropdown-toggle"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                id="salesReportExportBtn"
                            >
                                <i class="bi bi-download"></i>
                                <span>Export Report</span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end sales-report-export-menu">

                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-export-format="xlsx"
                                    >
                                        <i class="bi bi-file-earmark-excel"></i>
                                        Excel
                                    </button>
                                </li>

                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-export-format="csv"
                                    >
                                        <i class="bi bi-filetype-csv"></i>
                                        CSV
                                    </button>
                                </li>

                                <li>
                                    <button
                                        type="button"
                                        class="dropdown-item"
                                        data-export-format="pdf"
                                    >
                                        <i class="bi bi-file-earmark-pdf"></i>
                                        PDF
                                    </button>
                                </li>

                            </ul>

                        </div>

                    </div>
                @endpermission

            </div>

        </div>


        {{-- ==================================================
            FILTERS
        =================================================== --}}
        @include('reports.sales.partials.filters')


        {{-- ==================================================
            REPORT CONTENT
        =================================================== --}}
        <div
            class="sales-report-content"
            id="salesReportContent"
        >

            {{-- ----------------------------------------------
                INITIAL LOADING STATE
            ----------------------------------------------- --}}
            <div
                class="sales-report-loading"
                id="salesReportLoading"
                aria-hidden="true"
            >
                <div class="sales-report-loading-card">

                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">
                            Loading sales report...
                        </span>
                    </div>

                    <span>
                        Loading sales report...
                    </span>

                </div>
            </div>


            {{-- ----------------------------------------------
                REPORT DATA
            ----------------------------------------------- --}}
            <div
                class="sales-report-data d-none"
                id="salesReportData"
            >

                {{-- ==========================================
                    KPI STATISTICS
                =========================================== --}}
                @include('reports.sales.partials.stats')


                {{-- ==========================================
                    SALES CHARTS
                =========================================== --}}
                @include('reports.sales.partials.charts')


                {{-- ==========================================
                    PRODUCT PERFORMANCE
                =========================================== --}}
                @include('reports.sales.partials.products')


                {{-- ==========================================
                    CATEGORY PERFORMANCE
                =========================================== --}}
                @include('reports.sales.partials.categories')


                {{-- ==========================================
                    PAYMENT PERFORMANCE
                =========================================== --}}
                @include('reports.sales.partials.payments')


                {{-- ==========================================
                    CASHIER PERFORMANCE
                =========================================== --}}
                @include('reports.sales.partials.cashiers')


                {{-- ==========================================
                    CUSTOMER PERFORMANCE
                =========================================== --}}
                @include('reports.sales.partials.customers')


                {{-- ==========================================
                    TRANSACTIONS
                =========================================== --}}
                @include('reports.sales.partials.transactions')

            </div>


            {{-- ----------------------------------------------
                EMPTY STATE
            ----------------------------------------------- --}}
            <div
                class="sales-report-empty d-none"
                id="salesReportEmpty"
            >
                <div class="sales-report-empty-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>

                <h3>
                    No sales data found
                </h3>

                <p>
                    There are no completed sales matching the selected
                    filters and date range.
                </p>

                <button
                    type="button"
                    class="btn btn-light sales-report-empty-reset"
                    id="salesReportEmptyReset"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset Filters
                </button>
            </div>


            {{-- ----------------------------------------------
                ERROR STATE
            ----------------------------------------------- --}}
            <div
                class="sales-report-error d-none"
                id="salesReportError"
            >
                <div class="sales-report-error-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>

                <h3>
                    Unable to load report
                </h3>

                <p id="salesReportErrorMessage">
                    Something went wrong while loading the sales report.
                </p>

                <button
                    type="button"
                    class="btn btn-light"
                    id="salesReportRetry"
                >
                    <i class="bi bi-arrow-clockwise"></i>
                    Try Again
                </button>
            </div>

        </div>

    </div>


    {{-- ======================================================
        TRANSACTION INSPECTOR
    ======================================================= --}}
    @include('reports.sales.modals.inspector')

      <script src="{{ asset('assets/js/sales-report.js') }}"></script>
@endsection


