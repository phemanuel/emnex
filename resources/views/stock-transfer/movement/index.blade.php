@extends('layouts.app')

@section('title', 'Stock Movement')

@section('content')

<div class="st-history-page">

    {{-- ==========================================================
        PAGE HEADER
    =========================================================== --}}

    <div class="st-history-header">

        <div class="st-history-header-content">

            <div class="st-history-header-icon">

                <i class="bi bi-arrow-left-right"></i>

            </div>

            <div>

                <h1 class="st-history-title">
                    Stock Movement
                </h1>

                <p class="st-history-subtitle">
                    View and track all inventory movements across your branches.
                </p>

            </div>

        </div>


        <div class="st-history-header-actions">

            <a
                href="{{ route('stock-transfer.index') }}"
                class="btn btn-light st-history-back-btn"
            >

                <i class="bi bi-arrow-left me-2"></i>

                Back to Stock Transfer

            </a>

        </div>

    </div>


    {{-- ==========================================================
        KPI CARDS
    =========================================================== --}}

    <div class="row g-3 st-history-kpis">

        <div class="col-xl-3 col-md-6">

            <div class="st-history-kpi-card">

                <div class="st-history-kpi-icon primary">

                    <i class="bi bi-arrow-left-right"></i>

                </div>

                <div class="st-history-kpi-content">

                    <span>
                        Total Movements
                    </span>

                    <strong id="historyTotalMovements">

                        {{ number_format($totalMovements ?? 0) }}

                    </strong>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="st-history-kpi-card">

                <div class="st-history-kpi-icon success">

                    <i class="bi bi-box-seam"></i>

                </div>

                <div class="st-history-kpi-content">

                    <span>
                        Products Moved
                    </span>

                    <strong id="historyTotalProducts">

                        {{ number_format($totalProducts ?? 0) }}

                    </strong>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="st-history-kpi-card">

                <div class="st-history-kpi-icon warning">

                    <i class="bi bi-stack"></i>

                </div>

                <div class="st-history-kpi-content">

                    <span>
                        Total Quantity
                    </span>

                    <strong id="historyTotalQuantity">

                        {{ number_format($totalQuantity ?? 0, 2) }}

                    </strong>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="st-history-kpi-card">

                <div class="st-history-kpi-icon info">

                    <i class="bi bi-building"></i>

                </div>

                <div class="st-history-kpi-content">

                    <span>
                        Branches
                    </span>

                    <strong id="historyDestinationBranches">

                        {{ number_format($totalBranches ?? 0) }}

                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        MAIN CARD
    =========================================================== --}}

    <div class="card st-history-card">

        <div class="st-history-card-header">

            <div>

                <h5 class="st-history-card-title">
                    Inventory Movements
                </h5>

                <p class="st-history-card-subtitle">
                    Complete record of stock entering, leaving and changing inventory.
                </p>

            </div>


            <div class="st-history-filter-area">

                <div class="st-history-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        class="form-control"
                        id="stockMovementSearch"
                        placeholder="Search reference or product..."
                    >

                </div>


                <select
                    class="form-select st-history-branch-filter"
                    id="stockMovementTypeFilter"
                >

                    <option value="">
                        All Movements
                    </option>

                    @foreach ($movementTypes as $movementType)

                        <option value="{{ $movementType }}">
                            {{ $movementType }}
                        </option>

                    @endforeach

                </select>


                <select
                    class="form-select st-history-branch-filter"
                    id="stockMovementBranchFilter"
                >

                    <option value="">
                        All Branches
                    </option>

                    @foreach ($branches as $branch)

                        <option value="{{ $branch->id }}">
                            {{ $branch->displayName() }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>


        {{-- ======================================================
            TABLE
        ======================================================= --}}

        <div class="st-history-table-wrapper">

            <table class="table st-history-table">

                <thead>

                    <tr>

                        <th>
                            Reference
                        </th>

                        <th>
                            Movement
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Branch
                        </th>

                        <th>
                            Quantity
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Created By
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody id="stockMovementTableBody">

                    @forelse ($movements as $movement)

                        <tr
                            class="st-history-row"
                            data-reference="{{ strtolower($movement->reference_no ?? '') }}"
                            data-movement-type="{{ $movement->movement_type }}"
                            data-branch="{{ $movement->branch_id }}"
                            data-product="{{ strtolower($movement->product?->name ?? '') }}"
                        >

                            <td>

                                <div class="st-history-reference">

                                    <span class="st-history-reference-icon">

                                        <i class="bi bi-receipt"></i>

                                    </span>

                                    <div>

                                        <strong>
                                            {{ $movement->reference_no ?? '-' }}
                                        </strong>

                                        <small>
                                            Stock Movement
                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="st-history-product-count">

                                    {{ $movement->movement_type }}

                                </span>

                            </td>


                            <td>

                                <div>

                                    <strong>
                                        {{ $movement->product?->name ?? '-' }}
                                    </strong>

                                    @if ($movement->product?->sku)

                                        <small class="d-block text-muted">
                                            {{ $movement->product->sku }}
                                        </small>

                                    @endif

                                </div>

                            </td>


                            <td>

                                <div class="st-history-branch">

                                    <span class="st-history-branch-icon">

                                        <i class="bi bi-building"></i>

                                    </span>

                                    <span>
                                        {{ $movement->branch?->name ?? '-' }}
                                    </span>

                                </div>

                            </td>


                            <td>

                                <strong class="st-history-quantity">

                                    {{ number_format((float) $movement->quantity, 2) }}

                                </strong>

                            </td>


                            <td>

                                <div class="st-history-date">

                                    <strong>
                                        {{ $movement->created_at?->format('d M Y') ?? '-' }}
                                    </strong>

                                    <small>
                                        {{ $movement->created_at?->format('h:i A') ?? '-' }}
                                    </small>

                                </div>

                            </td>


                            <td>

                                <div class="st-history-user">

                                    <span class="st-history-user-avatar">

                                        {{ strtoupper(
                                            substr(
                                                $movement->createdBy?->name ?? 'S',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </span>

                                    <span>
                                        {{ $movement->createdBy?->name ?? 'System' }}
                                    </span>

                                </div>

                            </td>


                            <td class="text-end">

                                <button
                                    type="button"
                                    class="btn btn-sm st-history-view-btn"
                                    data-reference="{{ $movement->reference_no }}"
                                >

                                    <i class="bi bi-eye me-1"></i>

                                    View

                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr id="stockMovementEmptyRow">

                            <td
                                colspan="8"
                                class="st-history-empty-cell"
                            >

                                <div class="st-history-empty">

                                    <div class="st-history-empty-icon">

                                        <i class="bi bi-arrow-left-right"></i>

                                    </div>

                                    <h6>
                                        No stock movements
                                    </h6>

                                    <p>
                                        Stock movements will appear here once inventory activity is recorded.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ======================================================
            FOOTER
        ======================================================= --}}

        @if ($movements->hasPages())

            <div class="st-history-card-footer">

                <div class="st-history-pagination-info">

                    Showing

                    <strong>
                        {{ $movements->firstItem() ?? 0 }}
                    </strong>

                    to

                    <strong>
                        {{ $movements->lastItem() ?? 0 }}
                    </strong>

                    of

                    <strong>
                        {{ $movements->total() }}
                    </strong>

                    movements

                </div>


                <div class="st-history-pagination">

                    {{ $movements->links() }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- ==========================================================
    STOCK MOVEMENT CONFIG
=========================================================== --}}

<script>

    window.STOCK_MOVEMENT = {

        tableUrl:
            @json(
                route(
                    'stock-transfer.stock-movement.table'
                )
            ),

        detailsUrl:
            @json(
                route(
                    'stock-transfer.stock-movement.details',
                    ':reference'
                )
            ),

    };

</script>


<script src="{{ asset('assets/js/stock-movement.js') }}"></script>

@endsection