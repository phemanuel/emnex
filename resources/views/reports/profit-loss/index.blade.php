@extends('layouts.app')

@section('title', 'Profit & Loss Report')

@section('content')

<div class="container-fluid profit-loss-report">

    {{-- -----------------------------------------------------------------------
         Report Header
    ------------------------------------------------------------------------ --}}

    <div class="profit-loss-header">
        <div class="profit-loss-header-content">
            <h4 class="mb-1">Profit & Loss Report</h4>

            <p class="text-muted mb-0">
                Analyse revenue, cost of goods, inventory losses and profitability.
            </p>
        </div>

        <div class="profit-loss-header-actions">
         
            @permission('report.profit_loss')
                <div class="dropdown">
                    <button
                        type="button"
                        class="btn btn-outline-secondary dropdown-toggle"
                        id="profitLossExportBtn"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="bi bi-download me-1"></i>
                        Export
                    </button>

                    <ul
                        class="dropdown-menu dropdown-menu-end profit-loss-export-menu"
                        aria-labelledby="profitLossExportBtn"
                    >
                        <li>
                            <button
                                type="button"
                                class="dropdown-item"
                                data-export-format="xlsx"
                            >
                                <i class="bi bi-file-earmark-excel me-2"></i>
                                Excel
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                class="dropdown-item"
                                data-export-format="csv"
                            >
                                <i class="bi bi-filetype-csv me-2"></i>
                                CSV
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                class="dropdown-item"
                                data-export-format="pdf"
                            >
                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                PDF
                            </button>
                        </li>
                    </ul>
                </div>
            @endpermission


        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Page Content
    ------------------------------------------------------------------------ --}}

    <div id="profitLossPageContent">

        {{-- Filters --}}
        @include('reports.profit-loss.partials.filters')

        {{-- Statistics --}}
        @include('reports.profit-loss.partials.stats')

        {{-- Charts --}}
        @include('reports.profit-loss.partials.charts')

        {{-- Revenue --}}
        @include('reports.profit-loss.partials.revenue')

        {{-- Cost of Goods --}}
        @include('reports.profit-loss.partials.cost-of-goods')

        {{-- Inventory Losses --}}
        @include('reports.profit-loss.partials.expenses')

        {{-- Profit --}}
        @include('reports.profit-loss.partials.profit')

        @include('reports.profit-loss.partials.profit-loss-summary')

        {{-- Breakdown --}}
        @include('reports.profit-loss.partials.breakdown')

    </div>


    {{-- -----------------------------------------------------------------------
         Loading State
    ------------------------------------------------------------------------ --}}

    <div
        id="profitLossLoadingState"
        class="d-none"
    >
        <div class="card border-0 shadow-sm">
            <div class="card-body py-5 text-center">

                <div
                    class="spinner-border text-primary mb-3"
                    role="status"
                    aria-hidden="true"
                ></div>

                <div class="fw-semibold">
                    Loading Profit & Loss report...
                </div>

                <div class="text-muted small mt-1">
                    Please wait while we prepare your report.
                </div>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Empty State
    ------------------------------------------------------------------------ --}}

    <div
        id="profitLossEmptyState"
        class="d-none"
    >
        <div class="card border-0 shadow-sm">
            <div class="card-body py-5 text-center">

                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-3">
                        <i class="bi bi-bar-chart-line fs-4 text-muted"></i>
                    </span>
                </div>

                <h6 class="mb-1">
                    No Profit & Loss Data
                </h6>

                <p class="text-muted small mb-3">
                    There is no financial activity matching the selected filters.
                </p>

                <button
                    type="button"
                    class="btn btn-outline-secondary btn-sm"
                    id="profitLossEmptyResetBtn"
                >
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Reset Filters
                </button>

            </div>
        </div>
    </div>


    {{-- -----------------------------------------------------------------------
         Error State
    ------------------------------------------------------------------------ --}}

    <div
        id="profitLossErrorState"
        class="d-none"
    >
        <div class="card border-0 shadow-sm">
            <div class="card-body py-5 text-center">

                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-3">
                        <i class="bi bi-exclamation-triangle fs-4 text-danger"></i>
                    </span>
                </div>

                <h6 class="mb-1">
                    Unable to Load Report
                </h6>

                <p
                    class="text-muted small mb-3"
                    id="profitLossErrorMessage"
                >
                    Something went wrong while loading the report.
                </p>

                <button
                    type="button"
                    class="btn btn-outline-primary btn-sm"
                    id="profitLossRetryBtn"
                >
                    <i class="bi bi-arrow-repeat me-1"></i>
                    Retry
                </button>

            </div>
        </div>
    </div>

</div>

  <script>
        window.profitLossReportConfig = {
            dataUrl: @json(route('reports.profit-loss.data')),
            exportUrl: @json(route('reports.profit-loss.export')),
        };
    </script>

    <script src="{{ asset('assets/js/profit-loss.js') }}"></script>
@endsection




