@extends('layouts.app')

@section('title', 'Inventory Report')


@section('content')

<div class="container-fluid inventory-report-page">

    <div class="inventory-report-header">
        <div>
            <div class="inventory-report-eyebrow">
                Reports
            </div>

            <h1 class="inventory-report-title">
                Inventory Report
            </h1>

            <p class="inventory-report-description">
                Monitor current stock levels, inventory valuation, movements,
                product performance, and stock availability.
            </p>
        </div>

        <div class="inventory-report-actions">
            @permission('reports.inventory')
                <div class="dropdown">
                    <button
                        type="button"
                        class="btn btn-primary dropdown-toggle"
                        id="inventoryExportBtn"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        <i class="bi bi-download me-1"></i>
                        Export
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button
                                type="button"
                                class="dropdown-item"
                                data-export-format="xlsx"
                            >
                                <i class="bi bi-file-earmark-excel me-2"></i>
                                Excel (.xlsx)
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                class="dropdown-item"
                                data-export-format="csv"
                            >
                                <i class="bi bi-filetype-csv me-2"></i>
                                CSV (.csv)
                            </button>
                        </li>

                        <li>
                            <button
                                type="button"
                                class="dropdown-item"
                                data-export-format="pdf"
                            >
                                <i class="bi bi-file-earmark-pdf me-2"></i>
                                PDF (.pdf)
                            </button>
                        </li>
                    </ul>
                </div>
            @endpermission
        </div>
    </div>

    <div id="inventoryReportPage">

        @include('reports.inventory.partials.filters')

        <div
            id="inventoryReportLoading"
            class="inventory-report-state inventory-report-loading d-none"
        >
            <div class="spinner-border spinner-border-sm" role="status"></div>
            <span>Loading inventory report...</span>
        </div>

        <div
            id="inventoryReportEmpty"
            class="inventory-report-state inventory-report-empty d-none"
        >
            <div class="inventory-state-icon">
                <i class="bi bi-box-seam"></i>
            </div>

            <h5>No inventory data found</h5>

            <p>
                There is no inventory information matching the selected filters.
            </p>

            <button
                type="button"
                class="btn btn-light btn-sm"
                id="inventoryEmptyReset"
            >
                Reset Filters
            </button>
        </div>

        <div
            id="inventoryReportError"
            class="inventory-report-state inventory-report-error d-none"
        >
            <div class="inventory-state-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>

            <h5>Unable to load inventory report</h5>

            <p id="inventoryReportErrorMessage">
                Something went wrong while loading the report.
            </p>

            <button
                type="button"
                class="btn btn-light btn-sm"
                id="inventoryRetryBtn"
            >
                <i class="bi bi-arrow-clockwise me-1"></i>
                Retry
            </button>
        </div>

        <div id="inventoryReportContent">

            @include('reports.inventory.partials.stats')

            @include('reports.inventory.partials.charts')

            @include('reports.inventory.partials.products')

            @include('reports.inventory.partials.categories')

            @include('reports.inventory.partials.movements')

            @include('reports.inventory.partials.low-stock')

            @include('reports.inventory.partials.valuation')

        </div>

    </div>

</div>

@include('reports.inventory.modals.inspector')

  <script>
        window.InventoryReportConfig = {
            dataUrl: @json(route('reports.inventory.data')),
            exportUrl: @json(route('reports.inventory.export')),
            csrfToken: @json(csrf_token())
        };
    </script>

    <script src="{{ asset('assets/js/inventory-report.js') }}"></script>

@endsection

