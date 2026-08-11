@extends('layouts.app')

@section('title', 'Stock Transfer')


@section('content')

<div class="container-fluid stock-transfer-page">

    {{-- ==============================================================
STOCK TRANSFER HEADER
============================================================== --}}

<div class="st-page-header">


    <div class="st-page-header-main">

        <div class="st-page-eyebrow">

            <span class="st-page-eyebrow-icon">
                <i class="bi bi-arrow-left-right"></i>
            </span>

            <span>
                INVENTORY
            </span>

            <i class="bi bi-chevron-right"></i>

            <span class="st-page-eyebrow-current">
                STOCK TRANSFER
            </span>

        </div>


        <div class="st-page-title-row">

            <h1 class="st-page-title">
                Stock Transfer
            </h1>

        </div>


        <p class="st-page-subtitle">
            Transfer products from the Head Office to your branches.
        </p>

    </div>


    <div class="st-page-header-actions">

        {{-- Transfer History --}}

        <a
            href="{{ route('stock-transfer.stock-movement.index') }}"
            class="st-cart-header-btn st-history-back-btn"
        >

            <span class="st-cart-header-icon">
                <i class="bi bi-clock-history"></i>
            </span>

            <span class="st-cart-header-text">
                Stock Movement History
            </span>

        </a>


        {{-- Transfer Cart --}}

        <button
            type="button"
            class="st-cart-header-btn"
            id="openTransferCartBtn"
        >

            <span class="st-cart-header-icon">
                <i class="bi bi-cart3"></i>
            </span>

            <span class="st-cart-header-text">
                Transfer Cart
            </span>

            <span
                class="st-cart-header-count"
                id="transferCartCount"
            >
                0
            </span>

        </button>

    </div>


</div>

{{-- ==============================================================
STOCK TRANSFER KPI CARDS
============================================================== --}}

<div class="st-kpi-grid">


{{-- Products --}}

<div class="st-kpi-card">

    <div class="st-kpi-card-content">

        <div class="st-kpi-top">

            <span class="st-kpi-label">
                Products
            </span>

            <span class="st-kpi-icon primary">
                <i class="bi bi-box-seam"></i>
            </span>

        </div>


        <strong
            class="stock-transfer-kpi-value"
            id="transferProductCount"
        >
            {{ number_format($transferProductCount ?? 0) }}
        </strong>


        <div class="st-kpi-meta">

            <span class="st-kpi-meta-dot primary"></span>

            <span>
                Transferable products
            </span>

        </div>

    </div>

</div>


{{-- Available Stock --}}

<div class="st-kpi-card">

    <div class="st-kpi-card-content">

        <div class="st-kpi-top">

            <span class="st-kpi-label">
                Available Stock
            </span>

            <span class="st-kpi-icon success">
                <i class="bi bi-boxes"></i>
            </span>

        </div>


        <strong
            class="stock-transfer-kpi-value"
            id="transferAvailableStock"
        >
            {{ number_format($transferAvailableStock ?? 0) }}
        </strong>


        <div class="st-kpi-meta">

            <span class="st-kpi-meta-dot success"></span>

            <span>
                Head Office available quantity
            </span>

        </div>

    </div>

</div>


{{-- Low Stock --}}

<div class="st-kpi-card">

    <div class="st-kpi-card-content">

        <div class="st-kpi-top">

            <span class="st-kpi-label">
                Low Stock
            </span>

            <span class="st-kpi-icon warning">
                <i class="bi bi-exclamation-triangle"></i>
            </span>

        </div>


        <strong
            class="stock-transfer-kpi-value"
            id="transferLowStock"
        >
            {{ number_format($transferLowStock ?? 0) }}
        </strong>


        <div class="st-kpi-meta">

            <span class="st-kpi-meta-dot warning"></span>

            <span>
                Products requiring attention
            </span>

        </div>

    </div>

</div>


{{-- Out of Stock --}}

<div class="st-kpi-card">

    <div class="st-kpi-card-content">

        <div class="st-kpi-top">

            <span class="st-kpi-label">
                Out of Stock
            </span>

            <span class="st-kpi-icon danger">
                <i class="bi bi-box2"></i>
            </span>

        </div>


        <strong
            class="stock-transfer-kpi-value"
            id="transferOutStock"
        >
            {{ number_format($transferOutStock ?? 0) }}
        </strong>


        <div class="st-kpi-meta">

            <span class="st-kpi-meta-dot danger"></span>

            <span>
                Products unavailable
            </span>

        </div>

    </div>

</div>


</div>


    

    {{-- ==============================================================
        MAIN STOCK CARD
    ============================================================== --}}

    <div class="stock-transfer-card">

        {{-- ----------------------------------------------------------
            Card Header
        ----------------------------------------------------------- --}}

        
        <div class="stock-transfer-panel-header">

            {{-- Panel Information --}}

            <div class="stock-transfer-panel-heading">

                <div class="stock-transfer-panel-title-row">

                    <span class="stock-transfer-panel-title-icon">
                        <i class="bi bi-box-seam"></i>
                    </span>

                    <div>

                        <h5 class="stock-transfer-panel-title mb-0">
                            Head Office Stock
                        </h5>

                        <p class="stock-transfer-panel-subtitle">
                            Select one or more products to add them to the transfer cart.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Transfer Source --}}

            <div class="stock-transfer-source">

                <span class="stock-transfer-source-label">
                    Transfer From
                </span>

                <div class="stock-transfer-source-value">

                    <span class="stock-transfer-source-icon">
                        <i class="bi bi-building"></i>
                    </span>

                    <span>
                        {{ $headOffice->name }}
                    </span>

                </div>

            </div>

        </div>

        {{-- ----------------------------------------------------------
            FILTER BAR
        ----------------------------------------------------------- --}}

        <div class="stock-transfer-filter-bar">

            {{-- Search --}}

            <div class="stock-transfer-filter-search">

                <label
                    for="transferSearch"
                    class="stock-transfer-filter-label"
                >
                    Search Products
                </label>

                <div class="stock-transfer-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        class="form-control"
                        id="transferSearch"
                        placeholder="Search by product name, code, SKU or barcode..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- Category --}}

            <div class="stock-transfer-filter-field">

                <label
                    for="transferCategoryFilter"
                    class="stock-transfer-filter-label"
                >
                    Category
                </label>

                <select
                    class="form-select"
                    id="transferCategoryFilter"
                >

                    <option value="">
                        All Categories
                    </option>

                    @foreach ($categories as $category)

                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Stock Status --}}

            <div class="stock-transfer-filter-field">

                <label
                    for="transferStatusFilter"
                    class="stock-transfer-filter-label"
                >
                    Stock Status
                </label>

                <select
                    class="form-select"
                    id="transferStatusFilter"
                >

                    <option value="">
                        All Stock
                    </option>

                    <option value="in_stock">
                        In Stock
                    </option>

                    <option value="low_stock">
                        Low Stock
                    </option>

                    <option value="out_stock">
                        Out of Stock
                    </option>

                </select>

            </div>


            {{-- Reset --}}

            <div class="stock-transfer-filter-action">

                <label class="stock-transfer-filter-label filter-label-hidden">
                    Filter
                </label>

                <button
                    type="button"
                    class="stock-transfer-reset"
                    id="resetTransferFilters"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    <span>
                        Reset
                    </span>

                </button>

            </div>

        </div>


        {{-- ----------------------------------------------------------
            SELECTION TOOLBAR
        ----------------------------------------------------------- --}}

        <div class="stock-transfer-selection-toolbar">

            {{-- Selection Information --}}

            <div class="stock-transfer-selection-info">

                <label
                    class="stock-transfer-select-all"
                    for="selectAllTransferProducts"
                >

                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="selectAllTransferProducts"
                    >

                    <span>
                        Select All
                    </span>

                </label>


                <span class="stock-transfer-selection-divider"></span>


                <span
                    class="stock-transfer-selected-count"
                    id="selectedProductsLabel"
                >
                    0 products selected
                </span>

            </div>


            {{-- Add To Cart --}}

            <button
                type="button"
                class="stock-transfer-add-cart-btn"
                id="addSelectedToCartBtn"
                disabled
            >

                <span class="stock-transfer-add-cart-icon">
                    <i class="bi bi-cart-plus"></i>
                </span>

                <span class="stock-transfer-add-cart-text">
                    Add Selected to Cart
                </span>

                <span
                    class="stock-transfer-add-cart-count"
                    id="selectedProductsCartCount"
                >
                    0
                </span>

            </button>

        </div>



        {{-- ----------------------------------------------------------
            Table
        ----------------------------------------------------------- --}}

        <div
            class="stock-transfer-table-container"
            id="stockTransferTableContainer"
        >

            @include(
                'stock-transfer.partials.table',
                ['stocks' => $stocks]
            )

        </div>


        {{-- ----------------------------------------------------------
            Pagination
        ----------------------------------------------------------- --}}

        <div
            class="stock-transfer-pagination"
            id="stockTransferPagination"
        >

            {{ $stocks->links() }}

        </div>

    </div>


    {{-- ==============================================================
        TRANSFER CART PANEL
    ============================================================== --}}

    <div
        class="stock-transfer-cart-card d-none"
        id="stockTransferCartCard"
    >

        <div class="stock-transfer-cart-header">

            <div>

                <div class="d-flex align-items-center gap-2">

                    <span class="stock-transfer-cart-icon">
                        <i class="bi bi-cart3"></i>
                    </span>

                    <h5 class="stock-transfer-card-title mb-0">
                        Transfer Cart
                    </h5>

                </div>

                <p class="stock-transfer-card-subtitle mb-0 mt-1">
                    Review the products and quantities before transferring.
                </p>

            </div>


            <button
                type="button"
                class="btn btn-light"
                id="clearTransferCartBtn"
            >

                <i class="bi bi-trash3 me-2"></i>

                Clear Cart

            </button>

        </div>


        {{-- Destination --}}

        <div class="stock-transfer-cart-destination">

            <div class="row g-3 align-items-end">

                <div class="col-lg-6">

                    <label
                        for="cartDestinationBranch"
                        class="form-label"
                    >
                        Transfer To
                    </label>

                    <select
                        class="form-select"
                        id="cartDestinationBranch"
                    >

                        <option value="">
                            Select destination branch
                        </option>

                        @foreach ($branches as $branch)

                            <option value="{{ $branch->id }}">
                                {{ $branch->displayName() }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-lg-6">

                    <div class="stock-transfer-cart-summary">

                        <div>

                            <span>
                                Products
                            </span>

                            <strong id="cartSummaryProducts">
                                0
                            </strong>

                        </div>

                        <div>

                            <span>
                                Total Units
                            </span>

                            <strong id="cartSummaryQuantity">
                                0
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Cart Items --}}

        <div
            class="stock-transfer-cart-items"
            id="stockTransferCartItems"
        >

            <div class="stock-transfer-cart-empty">

                <div class="stock-transfer-cart-empty-icon">
                    <i class="bi bi-cart3"></i>
                </div>

                <h6>
                    Your transfer cart is empty
                </h6>

                <p>
                    Select products above and add them to the cart.
                </p>

            </div>

        </div>


        {{-- Cart Footer --}}

        <div class="stock-transfer-cart-footer">

            <div>

                <span class="text-muted">
                    Destination
                </span>

                <strong id="cartDestinationLabel">
                    Not selected
                </strong>

            </div>


            <div class="d-flex gap-2">

                <button
                    type="button"
                    class="btn btn-light"
                    id="closeTransferCartBtn"
                >

                    Close

                </button>


                <button
                    type="button"
                    class="btn btn-primary"
                    id="reviewTransferBtn"
                    disabled
                >

                    <i class="bi bi-arrow-left-right me-2"></i>

                    Review Transfer

                </button>

            </div>

        </div>

    </div> 


    
@include('stock-transfer.modals.transfer')

@include('stock-transfer.modals.history')

{{-- ==============================================================
    JAVASCRIPT CONFIGURATION
================================================================ --}}

<script>

    window.STOCK_TRANSFER = {

        tableUrl:
            @json(route('stock-transfer.table')),

        detailsUrl:
            @json(url('stock-transfer/details/:id')),

        transferUrl:
            @json(route('stock-transfer.transfer')),       

    };

</script>  


<script src="{{ asset('assets/js/stock-transfer.js') }}"></script>



@endsection