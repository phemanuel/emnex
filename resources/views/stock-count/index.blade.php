@extends('layouts.app')

@section('title', 'Stock Count')

@section('content')

{{-- ==========================================================
    PAGE HEADER
=========================================================== --}}

<div class="container-fluid">

    <div
        class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"
    >

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <span
                    class="stock-count-page-icon"
                >
                    <i class="bi bi-clipboard2-check"></i>
                </span>

                <h4 class="mb-0 fw-semibold">
                    Stock Count
                </h4>

            </div>

            <p class="text-muted mb-0">

                Physically count inventory and identify
                stock variances.

            </p>

        </div>


        @permission('inventory.stock_count')

            <button
                type="button"
                class="btn btn-primary d-flex align-items-center gap-2"
                id="createStockCountButton"
            >

                <i class="bi bi-plus-lg"></i>

                <span>
                    New Stock Count
                </span>

            </button>

        @endpermission

    </div>


    {{-- ==========================================================
        KPI CARDS
    =========================================================== --}}

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">

            <div
                class="stock-count-kpi-card"
                data-kpi="total"
            >

                <div class="stock-count-kpi-icon">

                    <i class="bi bi-clipboard-data"></i>

                </div>

                <div class="stock-count-kpi-content">

                    <span class="stock-count-kpi-label">
                        Total Counts
                    </span>

                    <span
                        class="stock-count-kpi-value"
                        id="stockCountTotalKpi"
                    >
                        0
                    </span>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-xl-3">

            <div
                class="stock-count-kpi-card"
                data-kpi="draft"
            >

                <div class="stock-count-kpi-icon">

                    <i class="bi bi-file-earmark"></i>

                </div>

                <div class="stock-count-kpi-content">

                    <span class="stock-count-kpi-label">
                        Draft
                    </span>

                    <span
                        class="stock-count-kpi-value"
                        id="stockCountDraftKpi"
                    >
                        0
                    </span>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-xl-3">

            <div
                class="stock-count-kpi-card"
                data-kpi="progress"
            >

                <div class="stock-count-kpi-icon">

                    <i class="bi bi-arrow-repeat"></i>

                </div>

                <div class="stock-count-kpi-content">

                    <span class="stock-count-kpi-label">
                        In Progress
                    </span>

                    <span
                        class="stock-count-kpi-value"
                        id="stockCountProgressKpi"
                    >
                        0
                    </span>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-xl-3">

            <div
                class="stock-count-kpi-card"
                data-kpi="completed"
            >

                <div class="stock-count-kpi-icon">

                    <i class="bi bi-check2-circle"></i>

                </div>

                <div class="stock-count-kpi-content">

                    <span class="stock-count-kpi-label">
                        Completed
                    </span>

                    <span
                        class="stock-count-kpi-value"
                        id="stockCountCompletedKpi"
                    >
                        0
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        MAIN CARD
    =========================================================== --}}

    <div class="card border-0 shadow-sm stock-count-main-card">

        {{-- ======================================================
            TOOLBAR
        ======================================================= --}}

        <div class="card-body border-bottom">

            <div class="row g-3 align-items-end">

                {{-- Search --}}

                <div class="col-12 col-lg-4">

                    <label
                        for="stockCountSearch"
                        class="form-label small fw-semibold"
                    >
                        Search
                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search text-muted"></i>

                        </span>

                        <input
                            type="search"
                            class="form-control"
                            id="stockCountSearch"
                            placeholder="Reference or notes..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- Branch --}}

                <div class="col-12 col-md-4 col-lg-2">

                    <label
                        for="stockCountBranchFilter"
                        class="form-label small fw-semibold"
                    >
                        Branch
                    </label>

                    <select
                        class="form-select"
                        id="stockCountBranchFilter"
                    >

                        <option value="">
                            All Branches
                        </option>

                        @foreach ($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}

                <div class="col-12 col-md-4 col-lg-2">

                    <label
                        for="stockCountStatusFilter"
                        class="form-label small fw-semibold"
                    >
                        Status
                    </label>

                    <select
                        class="form-select"
                        id="stockCountStatusFilter"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option value="Draft">
                            Draft
                        </option>

                        <option value="In Progress">
                            In Progress
                        </option>

                        <option value="Completed">
                            Completed
                        </option>

                        <option value="Cancelled">
                            Cancelled
                        </option>

                    </select>

                </div>


                {{-- Date From --}}

                <div class="col-12 col-md-4 col-lg-2">

                    <label
                        for="stockCountDateFrom"
                        class="form-label small fw-semibold"
                    >
                        From
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="stockCountDateFrom"
                    >

                </div>


                {{-- Date To --}}

                <div class="col-12 col-md-4 col-lg-2">

                    <label
                        for="stockCountDateTo"
                        class="form-label small fw-semibold"
                    >
                        To
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="stockCountDateTo"
                    >

                </div>

            </div>


            {{-- Filter actions --}}

            <div class="d-flex justify-content-end mt-3">

                <button
                    type="button"
                    class="btn btn-light btn-sm d-flex align-items-center gap-2"
                    id="stockCountClearFilters"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Clear Filters

                </button>

            </div>

        </div>


        {{-- ======================================================
            TABLE
        ======================================================= --}}

        <div class="table-responsive">

            <table
                class="table align-middle mb-0 stock-count-table"
            >

                <thead>

                    <tr>

                        <th>
                            Reference
                        </th>

                        <th>
                            Branch
                        </th>

                        <th>
                            Count Date
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Created By
                        </th>

                        <th>
                            Created
                        </th>

                        <th
                            class="text-end"
                            style="width: 80px;"
                        >
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody id="stockCountTableBody">

                    {{-- JavaScript renders rows --}}

                </tbody>

            </table>

        </div>


        {{-- ======================================================
            EMPTY / LOADING / ERROR
        ======================================================= --}}

        <div
            id="stockCountTableState"
            class="stock-count-table-state d-none"
        >

            <div class="stock-count-state-icon">

                <i class="bi bi-clipboard2-x"></i>

            </div>

            <h6
                class="fw-semibold mb-1"
                id="stockCountStateTitle"
            >
                No Stock Counts Found
            </h6>

            <p
                class="text-muted small mb-0"
                id="stockCountStateMessage"
            >
                There are no Stock Counts matching your filters.
            </p>

        </div>


        {{-- ======================================================
            PAGINATION
        ======================================================= --}}

        <div
            class="card-footer bg-white border-0"
            id="stockCountPaginationWrapper"
        >

            <div
                class="d-flex flex-wrap justify-content-between align-items-center gap-3"
            >

                <div
                    class="small text-muted"
                    id="stockCountPaginationInfo"
                >
                    Showing 0 to 0 of 0
                </div>

                <nav
                    aria-label="Stock Count pagination"
                >

                    <ul
                        class="pagination pagination-sm mb-0"
                        id="stockCountPagination"
                    ></ul>

                </nav>

            </div>

        </div>

    </div>

</div>



{{-- ==========================================================
    CONFIG
=========================================================== --}}

<script>

    window.STOCK_COUNT = {

        tableUrl:
            @json(
                route(
                    'stock-count.table'
                )
            ),

        detailsUrl:
            @json(
                route(
                    'stock-count.details',
                    ':id'
                )
            ),

        storeUrl:
            @json(
                route(
                    'stock-count.store'
                )
            ),

        updateUrl:
            @json(
                route(
                    'stock-count.update',
                    ':id'
                )
            ),

        destroyUrl:
            @json(
                route(
                    'stock-count.destroy',
                    ':id'
                )
            ),

        startUrl:
            @json(
                route(
                    'stock-count.start',
                    ':id'
                )
            ),

    };

</script>

@include('stock-count.partials.inspector')

@include('stock-count.modals.modal')

@include('stock-count.modals.count')

@include('stock-count.modals.delete')

<script src="{{ asset('assets/js/stock-count.js') }}"></script>



@endsection