@extends('layouts.app')

@section('title', 'Purchase')



@section('content')

<div
    class="container-fluid purchase-page"
    id="purchasePage"
>

    {{-- ==============================================================
        Page Header
    ============================================================== --}}

    <div class="purchase-page-header">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <span
                    class="text-muted small"
                >
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


        <div
            class="d-flex align-items-center gap-2"
            id="purchaseHeaderActions"
        >

            @permission('purchases.create')

                <button
                    type="button"
                    class="btn btn-primary"
                    id="newPurchaseOrderBtn"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    <span id="purchaseCreateBtnText">
                        New Purchase Order
                    </span>

                </button>

            @endpermission

        </div>

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
                    id="purchaseOrdersPending"
                >
                    0
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
                    0
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
                    0.00
                </div>

            </div>

        </div>


        {{-- ==============================================================
        Purchase Tabs
    ============================================================== --}}

    <div
        class="purchase-tabs"
        role="tablist"
    >

        <button
            type="button"
            class="purchase-tab active"
            id="purchaseOrdersTab"
            data-purchase-tab="orders"
            role="tab"
            aria-selected="true"
        >

            <i class="bi bi-cart3"></i>

            <span>
                Purchase Orders
            </span>

            <span
                class="purchase-tab-count"
                id="purchaseOrdersCount"
            >
                0
            </span>

        </button>


        <button
            type="button"
            class="purchase-tab"
            id="purchaseReceivedTab"
            data-purchase-tab="received"
            role="tab"
            aria-selected="false"
        >

            <i class="bi bi-box-seam"></i>

            <span>
                Goods Received
            </span>

            <span
                class="purchase-tab-count"
                id="purchaseReceivedCount"
            >
                0
            </span>

        </button>


        <button
            type="button"
            class="purchase-tab"
            id="purchaseReturnsTab"
            data-purchase-tab="returns"
            role="tab"
            aria-selected="false"
        >

            <i class="bi bi-arrow-return-left"></i>

            <span>
                Purchase Returns
            </span>

            <span
                class="purchase-tab-count"
                id="purchaseReturnsCount"
            >
                0
            </span>

        </button>

    </div>

        {{-- Orders Table Card --}}

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
                            id="purchaseOrdersSearch"
                            placeholder="Search purchase orders..."
                            autocomplete="off"
                        >

                    </div>


                    <select
                        class="form-select"
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


                    <select
                        class="form-select"
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


                    <select
                        class="form-select"
                        id="purchaseOrdersStatus"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option value="draft">
                            Draft
                        </option>

                        <option value="pending">
                            Pending
                        </option>

                        <option value="approved">
                            Approved
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                        <option value="cancelled">
                            Cancelled
                        </option>

                    </select>

                </div>


                <button
                    type="button"
                    class="btn btn-light border"
                    id="purchaseOrdersRefresh"
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
    ============================================================== --}}

    <section
        id="purchaseReceivedPanel"
        class="purchase-tab-panel d-none"
        data-purchase-panel="received"
    >

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
                            id="purchaseReceivedSearch"
                            placeholder="Search goods received..."
                            autocomplete="off"
                        >

                    </div>


                    <select
                        class="form-select"
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


                    <select
                        class="form-select"
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


                    <select
                        class="form-select"
                        id="purchaseReceivedStatus"
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
                    id="purchaseReceivedRefresh"
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
            class="dropdown-item d-none"
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
            class="dropdown-item"
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
            class="dropdown-item text-warning"
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




   

