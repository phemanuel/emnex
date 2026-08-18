@extends('layouts.app')

@section('title', 'Purchase')



@section('content')

<div
    class="container-fluid purchase-page"
    id="purchasePage"
>

    {{-- ==============================================================
        Page Header
    =============================================================== --}}

    <div class="purchase-page-header">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <span class="text-muted small">
                    Purchase
                </span>

            </div>

            <h1 class="purchase-page-title">
                Purchase Management
            </h1>

            <p class="purchase-page-subtitle">
                Manage purchase orders, goods received and supplier returns.
            </p>

        </div>


        {{-- ==========================================================
            Header Actions
        =========================================================== --}}

        <div
            class="d-flex align-items-center gap-2"
            id="purchaseHeaderActions"
        >

            {{-- ======================================================
                New Purchase Order
            ======================================================= --}}

            @permission('purchases.create')

                <button
                    type="button"
                    class="btn btn-primary"
                    id="newPurchaseOrderBtn"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    New Purchase Order

                </button>

            @endpermission


            {{-- ======================================================
                New Goods Received
            ======================================================= --}}

            @permission('purchases.create')

                <button
                    type="button"
                    class="btn btn-primary d-none"
                    id="newGoodsReceivedBtn"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    New Goods Received

                </button>

            @endpermission


            {{-- ======================================================
                New Purchase Return
            ======================================================= --}}

            @permission('purchases.create')

                <button
                    type="button"
                    class="btn btn-primary d-none"
                    id="newPurchaseReturnBtn"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    New Purchase Return

                </button>

            @endpermission

        </div>

    </div>

     {{-- ==========================================================
                Purchase Navigation
            ========================================================== --}}

            <div
            class="purchase-tabs"
            id="purchaseTabs"
            role="tablist"
            aria-label="Purchase management"
        >

                {{-- ======================================================
                    Purchase Orders
                ======================================================= --}}

                <button
                    type="button"
                    class="purchase-tab active"
                    id="purchaseOrdersTab"
                    data-purchase-tab="orders"
                    role="tab"
                    aria-selected="true"
                >

                    <span class="purchase-tab-icon">

                        <i class="bi bi-receipt"></i>

                    </span>


                    <span class="purchase-tab-content">

                        <span class="purchase-tab-title">
                            Purchase Orders
                        </span>

                        <span class="purchase-tab-description">
                            Manage supplier orders
                        </span>

                    </span>


                    <span
                        class="purchase-tab-count"
                        id="purchaseOrdersCount"
                    >
                        0
                    </span>

                </button>


                {{-- ======================================================
                    Goods Received
                ======================================================= --}}

                <button
                    type="button"
                    class="purchase-tab"
                    id="purchaseReceivedTab"
                    data-purchase-tab="received"
                    role="tab"
                    aria-selected="false"
                >

                    <span class="purchase-tab-icon">

                        <i class="bi bi-box-seam"></i>

                    </span>


                    <span class="purchase-tab-content">

                        <span class="purchase-tab-title">
                            Goods Received
                        </span>

                        <span class="purchase-tab-description">
                            Track received inventory
                        </span>

                    </span>


                    <span
                        class="purchase-tab-count"
                        id="purchaseReceivedCount"
                    >
                        0
                    </span>

                </button>


                {{-- ======================================================
                    Purchase Returns
                ======================================================= --}}

                <button
                    type="button"
                    class="purchase-tab"
                    id="purchaseReturnsTab"
                    data-purchase-tab="returns"
                    role="tab"
                    aria-selected="false"
                >

                    <span class="purchase-tab-icon">

                        <i class="bi bi-arrow-return-left"></i>

                    </span>


                    <span class="purchase-tab-content">

                        <span class="purchase-tab-title">
                            Purchase Returns
                        </span>

                        <span class="purchase-tab-description">
                            Manage returned goods
                        </span>

                    </span>


                    <span
                        class="purchase-tab-count"
                        id="purchaseReturnsCount"
                    >
                        0
                    </span>

                </button>

            </div>


    {{-- ==============================================================
        Purchase Orders Workspace
    ============================================================== --}}

    <section
        id="purchaseOrdersPanel"
        class="purchase-tab-panel"
        data-purchase-panel="orders"
    >

        {{-- KPI Cards --}}

        <div
            class="purchase-kpi-grid"
            id="purchaseOrdersKpis"
        >

            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-cart3"></i>
                </div>

                <div class="purchase-kpi-label">
                    Total Orders
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseOrdersTotal"
                >
                   {{ number_format(
                        $purchaseOrderStats['total'] ?? 0
                    ) }}
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="purchase-kpi-label">
                    Pending
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseOrdersPending"
                >
                   {{ number_format(
                        $purchaseOrderStats['pending'] ?? 0
                    ) }}
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div class="purchase-kpi-label">
                    Approved
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseOrdersApproved"
                >
                    {{ number_format(
                        $purchaseOrderStats['approved'] ?? 0
                    ) }}
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>

                <div class="purchase-kpi-label">
                    Purchase Value
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseOrdersValue"
                >
                    {{ number_format(
                        $purchaseOrderStats['total_value'] ?? 0,
                        2
                    ) }}
                </div>

            </div>

        </div>
           

            {{-- ==========================================================
                Purchase Orders Toolbar
            ========================================================== --}}

            <div class="purchase-toolbar purchase-orders-toolbar">

                {{-- ======================================================
                    Primary Search
                ======================================================= --}}

                <div class="purchase-toolbar-search">

                    <div class="purchase-search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            class="form-control"
                            id="purchaseOrdersSearch"
                            placeholder="Search order number or supplier..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- ======================================================
                    Filters
                ======================================================= --}}

                <div class="purchase-toolbar-filters">

                    {{-- ==================================================
                        Branch
                    =================================================== --}}

                    <div class="purchase-filter">

                        <label
                            for="purchaseOrdersBranch"
                            class="purchase-filter-label"
                        >
                            Branch
                        </label>

                        <select
                            class="form-select purchase-filter-control"
                            id="purchaseOrdersBranch"
                        >

                            <option value="">
                                All Branches
                            </option>

                            @foreach($branches as $branch)

                                <option
                                    value="{{ $branch->id }}"
                                >
                                    {{ $branch->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ==================================================
                        Supplier
                    =================================================== --}}

                    <div class="purchase-filter">

                        <label
                            for="purchaseOrdersSupplier"
                            class="purchase-filter-label"
                        >
                            Supplier
                        </label>

                        <select
                            class="form-select purchase-filter-control"
                            id="purchaseOrdersSupplier"
                        >

                            <option value="">
                                All Suppliers
                            </option>

                            @foreach($suppliers as $supplier)

                                <option
                                    value="{{ $supplier->id }}"
                                >
                                    {{ $supplier->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ==================================================
                        Status
                    =================================================== --}}

                    <div class="purchase-filter">

                        <label
                            for="purchaseOrdersStatus"
                            class="purchase-filter-label"
                        >
                            Status
                        </label>

                        <select
                            class="form-select purchase-filter-control"
                            id="purchaseOrdersStatus"
                        >

                            <option value="">
                                All Statuses
                            </option>

                            <option value="Draft">
                                Draft
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Approved">
                                Approved
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                            <option value="Cancelled">
                                Cancelled
                            </option>

                        </select>

                    </div>


                    {{-- ==================================================
                        Date Range
                    =================================================== --}}

                    <div class="purchase-filter purchase-filter-date">

                        <label class="purchase-filter-label">
                            Order Date
                        </label>

                        <div class="purchase-date-range">

                            <div class="purchase-date-field">

                                <i class="bi bi-calendar3"></i>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="purchaseOrdersDateFrom"
                                    title="Order date from"
                                >

                            </div>


                            <span class="purchase-date-separator">
                                to
                            </span>


                            <div class="purchase-date-field">

                                <i class="bi bi-calendar3"></i>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="purchaseOrdersDateTo"
                                    title="Order date to"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Reset
                    =================================================== --}}

                    <button
                        type="button"
                        class="btn purchase-filter-reset"
                        id="purchaseOrdersReset"
                        title="Reset filters"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                        <span>
                            Reset
                        </span>

                    </button>

                </div>


                {{-- ======================================================
                    Refresh
                ======================================================= --}}

                <div class="purchase-toolbar-actions">

                    <button
                        type="button"
                        class="btn purchase-refresh-btn"
                        id="purchaseOrdersRefresh"
                        title="Refresh"
                    >

                        <i class="bi bi-arrow-clockwise"></i>

                    </button>

                </div>

            </div>

            <div class="purchase-table-wrapper">

                <table class="table purchase-table">

                    <thead>

                        <tr>

                            <th>
                                Purchase Order
                            </th>

                            <th>
                                Supplier
                            </th>

                            <th>
                                Branch
                            </th>

                            <th>
                                Order Date
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="purchaseOrdersTable">

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="spinner-border spinner-border-sm"></div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            <div
                class="d-flex justify-content-between align-items-center px-3 py-3 border-top"
            >

                <div
                    class="small text-muted"
                    id="purchaseOrdersPaginationInfo"
                ></div>

                <div id="purchaseOrdersPagination"></div>

            </div>

        </div>

    </section>


    {{-- ==============================================================
        Goods Received Workspace
    =============================================================== --}}

    <section
        id="purchaseReceivedPanel"
        class="purchase-tab-panel d-none"
        data-purchase-panel="received"
    >

        {{-- ==========================================================
            Goods Received KPI Cards
        =========================================================== --}}

        <div
            class="purchase-kpi-grid"
            id="purchaseReceivedKpis"
        >

            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <div class="purchase-kpi-label">
                    Total Received
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReceivedTotal"
                >
                    0
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="purchase-kpi-label">
                    Pending
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReceivedPending"
                >
                    0
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div class="purchase-kpi-label">
                    Completed
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReceivedCompleted"
                >
                    0
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>

                <div class="purchase-kpi-label">
                    Received Value
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReceivedValue"
                >
                    0.00
                </div>

            </div>

        </div>


        {{-- ==========================================================
            Goods Received Table Card
        =========================================================== --}}

        <div class="purchase-workspace-card">


            {{-- ======================================================
                Goods Received Toolbar
            ======================================================= --}}

            <div class="purchase-toolbar purchase-received-toolbar">


                {{-- ==================================================
                    Primary Search
                =================================================== --}}

                <div class="purchase-toolbar-search">

                    <div class="purchase-search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            class="form-control"
                            id="purchaseReceivedSearch"
                            placeholder="Search reference, supplier..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- ==================================================
                    Filters
                =================================================== --}}

                <div class="purchase-toolbar-filters">


                    {{-- ==================================================
                        Branch
                    =================================================== --}}

                    <div class="purchase-filter">

                        <label
                            for="purchaseReceivedBranch"
                            class="purchase-filter-label"
                        >
                            Branch
                        </label>

                        <select
                            class="form-select purchase-filter-control"
                            id="purchaseReceivedBranch"
                        >

                            <option value="">
                                All Branches
                            </option>

                            @foreach($branches as $branch)

                                <option
                                    value="{{ $branch->id }}"
                                >
                                    {{ $branch->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ==================================================
                        Supplier
                    =================================================== --}}

                    <div class="purchase-filter">

                        <label
                            for="purchaseReceivedSupplier"
                            class="purchase-filter-label"
                        >
                            Supplier
                        </label>

                        <select
                            class="form-select purchase-filter-control"
                            id="purchaseReceivedSupplier"
                        >

                            <option value="">
                                All Suppliers
                            </option>

                            @foreach($suppliers as $supplier)

                                <option
                                    value="{{ $supplier->id }}"
                                >
                                    {{ $supplier->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ==================================================
                        Status
                    =================================================== --}}

                    <div class="purchase-filter">

                        <label
                            for="purchaseReceivedStatus"
                            class="purchase-filter-label"
                        >
                            Status
                        </label>

                        <select
                            class="form-select purchase-filter-control"
                            id="purchaseReceivedStatus"
                        >

                            <option value="">
                                All Statuses
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                        </select>

                    </div>


                    {{-- ==================================================
                        Date Range
                    =================================================== --}}

                    <div class="purchase-filter purchase-filter-date">

                        <label class="purchase-filter-label">
                            Received Date
                        </label>

                        <div class="purchase-date-range">

                            <div class="purchase-date-field">

                                <i class="bi bi-calendar3"></i>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="purchaseReceivedDateFrom"
                                    title="Received date from"
                                >

                            </div>


                            <span class="purchase-date-separator">
                                to
                            </span>


                            <div class="purchase-date-field">

                                <i class="bi bi-calendar3"></i>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="purchaseReceivedDateTo"
                                    title="Received date to"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Reset
                    =================================================== --}}

                    <button
                        type="button"
                        class="btn purchase-filter-reset"
                        id="purchaseReceivedReset"
                        title="Reset filters"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                        <span>
                            Reset
                        </span>

                    </button>

                </div>


                {{-- ==================================================
                    Refresh
                =================================================== --}}

                <div class="purchase-toolbar-actions">

                    <button
                        type="button"
                        class="btn purchase-refresh-btn"
                        id="purchaseReceivedRefresh"
                        title="Refresh"
                    >

                        <i class="bi bi-arrow-clockwise"></i>

                    </button>

                </div>

            </div>


            {{-- ======================================================
                Goods Received Table
            ======================================================= --}}

            <div class="purchase-table-wrapper">

                <table class="table purchase-table">

                    <thead>

                        <tr>

                            <th>
                                Reference
                            </th>

                            <th>
                                Supplier
                            </th>

                            <th>
                                Branch
                            </th>

                            <th>
                                Received Date
                            </th>

                            <th>
                                Items
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="purchaseReceivedTable">

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="spinner-border spinner-border-sm"></div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- ======================================================
                Pagination
            ======================================================= --}}

            <div
                class="d-flex justify-content-between align-items-center px-3 py-3 border-top"
            >

                <div
                    class="small text-muted"
                    id="purchaseReceivedPaginationInfo"
                ></div>

                <div id="purchaseReceivedPagination"></div>

            </div>

        </div>

    </section>


    {{-- ==============================================================
        Purchase Returns Workspace
    ============================================================== --}}

    <section
        id="purchaseReturnsPanel"
        class="purchase-tab-panel d-none"
        data-purchase-panel="returns"
    >

        <div
            class="purchase-kpi-grid"
            id="purchaseReturnsKpis"
        >

            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-arrow-return-left"></i>
                </div>

                <div class="purchase-kpi-label">
                    Total Returns
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReturnsTotal"
                >
                    0
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="purchase-kpi-label">
                    Pending
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReturnsPending"
                >
                    0
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div class="purchase-kpi-label">
                    Completed
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReturnsCompleted"
                >
                    0
                </div>

            </div>


            <div class="purchase-kpi-card">

                <div class="purchase-kpi-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>

                <div class="purchase-kpi-label">
                    Returned Value
                </div>

                <div
                    class="purchase-kpi-value"
                    id="purchaseReturnsValue"
                >
                    0.00
                </div>

            </div>

        </div>


        <div class="purchase-workspace-card">

            <div class="purchase-toolbar">

                <div class="purchase-toolbar-left">

                    <div class="input-group purchase-search">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="search"
                            class="form-control"
                            id="purchaseReturnsSearch"
                            placeholder="Search purchase returns..."
                            autocomplete="off"
                        >

                    </div>


                    <select
                        class="form-select"
                        id="purchaseReturnsBranch"
                    >

                        <option value="">
                            All Branches
                        </option>

                        @foreach($branches as $branch)

                            <option
                                value="{{ $branch->id }}"
                            >
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>


                    <select
                        class="form-select"
                        id="purchaseReturnsSupplier"
                    >

                        <option value="">
                            All Suppliers
                        </option>

                        @foreach($suppliers as $supplier)

                            <option
                                value="{{ $supplier->id }}"
                            >
                                {{ $supplier->name }}
                            </option>

                        @endforeach

                    </select>


                    <select
                        class="form-select"
                        id="purchaseReturnsStatus"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                    </select>

                </div>


                <button
                    type="button"
                    class="btn btn-light border"
                    id="purchaseReturnsRefresh"
                    title="Refresh"
                >

                    <i class="bi bi-arrow-clockwise"></i>

                </button>

            </div>


            <div class="purchase-table-wrapper">

                <table class="table purchase-table">

                    <thead>

                        <tr>

                            <th>
                                Return
                            </th>

                            <th>
                                Supplier
                            </th>

                            <th>
                                Branch
                            </th>

                            <th>
                                Return Date
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="purchaseReturnsTable">

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                            >

                                <div class="spinner-border spinner-border-sm"></div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            <div
                class="d-flex justify-content-between align-items-center px-3 py-3 border-top"
            >

                <div
                    class="small text-muted"
                    id="purchaseReturnsPaginationInfo"
                ></div>

                <div id="purchaseReturnsPagination"></div>

            </div>

        </div>

    </section>


</div>


{{-- ==============================================================
    Global Purchase Action Menu
============================================================== --}}

<div
    class="dropdown-menu shadow"
    id="purchaseGlobalActionMenu"
    style="display: none;"
>

    <div id="purchaseGlobalActionItems"></div>

</div>




{{-- ==============================================================
    Product Item Template
============================================================== --}}

<template id="purchaseOrderItemTemplate">

    <tr class="purchase-order-item">

        <td>

            <select
                class="form-select purchase-item-product"
                name="items[INDEX][product_id]"
                required
            >

                <option value="">
                    Select Product
                </option>

            </select>

        </td>


        <td>

            <input
                type="number"
                class="form-control purchase-item-quantity"
                name="items[INDEX][quantity]"
                min="0.01"
                step="0.01"
                value="1"
                required
            >

        </td>


        <td>

            <input
                type="number"
                class="form-control purchase-item-cost"
                name="items[INDEX][unit_cost]"
                min="0"
                step="0.01"
                value="0"
                required
            >

        </td>


        <td>

            <span
                class="purchase-item-total fw-semibold"
            >
                0.00
            </span>

        </td>


        <td class="text-end">

            <button
                type="button"
                class="btn btn-light btn-sm text-danger purchase-remove-item"
                title="Remove"
            >

                <i class="bi bi-trash3"></i>

            </button>

        </td>

    </tr>

</template>


{{-- ==============================================================
    Global Product Options
============================================================== --}}

<select
    id="purchaseProductOptions"
    class="d-none"
>

    <option value="">
        Select Product
    </option>

</select>

{{-- ==============================================================
    Purchase Action Menu
============================================================== --}}

<div
    class="dropdown-menu purchase-action-menu"
    id="purchaseActionMenu"
>

    {{-- ==========================================================
        View
    =========================================================== --}}

    @permission('purchases.view')

        <button
            type="button"
            class="dropdown-item"
            id="purchaseActionView"
        >

            <i class="bi bi-eye me-2"></i>

            View

        </button>

    @endpermission


    {{-- ==========================================================
        Edit
    =========================================================== --}}

    @permission('purchases.update')

        <button
            type="button"
            class="dropdown-item"
            id="purchaseActionEdit"
        >

            <i class="bi bi-pencil me-2"></i>

            Edit

        </button>

    @endpermission


    {{-- ==========================================================
        Submit for Approval
    =========================================================== --}}

    @permission('purchases.submit')

        <button
            type="button"
            class="dropdown-item purchase-status-action d-none"
            id="purchaseActionSubmit"
        >

            <i class="bi bi-send me-2"></i>

            Submit for Approval

        </button>

    @endpermission


    {{-- ==========================================================
        Approve
    =========================================================== --}}

    @permission('purchases.approve')

        <button
            type="button"
            class="dropdown-item purchase-status-action d-none"
            id="purchaseActionApprove"
        >

            <i class="bi bi-check-circle me-2"></i>

            Approve

        </button>

    @endpermission


    {{-- ==========================================================
        Cancel
    =========================================================== --}}

    @permission('purchases.cancel')

        <button
            type="button"
            class="dropdown-item text-danger purchase-status-action d-none"
            id="purchaseActionCancel"
        >

            <i class="bi bi-x-circle me-2"></i>

            Cancel

        </button>

    @endpermission


    {{-- ==========================================================
        Divider
    =========================================================== --}}

    <div
        class="dropdown-divider"
        id="purchaseActionDivider"
    ></div>


    {{-- ==========================================================
        Delete
    =========================================================== --}}

    @permission('purchases.delete')

        <button
            type="button"
            class="dropdown-item text-danger"
            id="purchaseActionDelete"
        >

            <i class="bi bi-trash me-2"></i>

            Delete

        </button>

    @endpermission

</div>
{{-- ==============================================================
    Purchase Modals
============================================================== --}}

@include(
    'purchase.modals.purchase-order'
)

@include(
    'purchase.modals.goods-received'
)

@include(
    'purchase.modals.purchase-return'
)

@include(
    'purchase.modals.confirmation'
)


{{-- ==============================================================
    Purchase Inspectors
============================================================== --}}

@include(
    'purchase.partials.order-inspector'
)

@include(
    'purchase.partials.goods-inspector'
)

@include(
    'purchase.partials.return-inspector'
)

 <script
        src="{{ asset('assets/js/purchase.js') }}"
    ></script>
@endsection




   

