@extends('layouts.app')

@section('title', 'Sales Orders')

@section('content')

{{-- ==============================================================
    Sales Orders
============================================================== --}}

<div class="container-fluid px-3 px-lg-4 sales-orders-page">

    {{-- ==========================================================
        Page Header
    =========================================================== --}}

    <div
        class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4"
    >

        <div>

            <div class="text-muted small mb-1">
                Sales
            </div>

            <h1 class="h4 fw-bold mb-1">
                Sales Orders
            </h1>

            <div class="text-muted small">
                Manage customer orders and sales activity.
            </div>

        </div>

       
        <div class="d-flex align-items-center gap-2">

            @if(
                canAccess('orders.create') &&
                in_array(
                    auth()->user()->role?->code,
                    [
                        'owner',
                        'administrator',
                    ]
                )
            )

                <button
                    type="button"
                    class="btn btn-primary"
                    id="newOrderBtn"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    New Order

                </button>

            @endif

        </div>



    </div>


    {{-- ==========================================================
        KPI Cards
    =========================================================== --}}

    <div
        class="purchase-kpi-grid mb-4"
        id="orderKpis"
    >

        <div class="purchase-kpi-card">

            <div class="purchase-kpi-icon">
                <i class="bi bi-receipt"></i>
            </div>

            <div class="purchase-kpi-label">
                Total Orders
            </div>

            <div
                class="purchase-kpi-value"
                id="ordersTotal"
            >
                0
            </div>

        </div>


        <div class="purchase-kpi-card">

            <div class="purchase-kpi-icon">
                <i class="bi bi-pencil-square"></i>
            </div>

            <div class="purchase-kpi-label">
                Draft
            </div>

            <div
                class="purchase-kpi-value"
                id="ordersDraft"
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
                id="ordersCompleted"
            >
                0
            </div>

        </div>


        <div class="purchase-kpi-card">

            <div class="purchase-kpi-icon">
                <i class="bi bi-currency-exchange"></i>
            </div>

            <div class="purchase-kpi-label">
                Sales Value
            </div>

            <div
                class="purchase-kpi-value"
                id="ordersSalesValue"
            >
                0.00
            </div>

        </div>

    </div>


    {{-- ==========================================================
        Orders Card
    =========================================================== --}}

    <div class="card border-0 shadow-sm sales-orders-card">

        {{-- ======================================================
            Toolbar
        ======================================================= --}}

        <div class="card-body">

            <div class="sales-orders-toolbar">

                {{-- Search --}}

                <div class="sales-orders-search">

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="bi bi-search"></i>

                        </span>

                        <input
                            type="search"
                            class="form-control"
                            id="ordersSearch"
                            placeholder="Search orders..."
                            autocomplete="off"
                        >

                    </div>

                </div>


                {{-- Customer --}}

                <div class="sales-orders-filter">

                    <select
                        class="form-select"
                        id="ordersCustomerFilter"
                        aria-label="Filter by customer"
                    >

                        <option value="">
                            All Customers
                        </option>

                        @foreach($customers as $customer)

                            <option
                                value="{{ $customer->id }}"
                            >
                                {{ $customer->displayName() }}
                            </option>

                        @endforeach

                    </select>

                </div>

              
                {{-- ==================================================
                    Branch
                =================================================== --}}

                <div class="sales-orders-filter">

                    <select
                        class="form-select"
                        id="ordersBranchFilter"
                        aria-label="Filter by branch"
                    >

                        @if($canManageAllBranches)

                            <option value="">
                                All Branches
                            </option>

                        @endif


                        @foreach($branches as $branch)

                            <option
                                value="{{ $branch->id }}"
                                @if(!$canManageAllBranches)
                                    selected
                                @endif
                            >
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>

                </div>



                {{-- Order Status --}}

                <div class="sales-orders-filter">

                    <select
                        class="form-select"
                        id="ordersStatusFilter"
                        aria-label="Filter by order status"
                    >

                        <option value="">
                            Order Status
                        </option>

                        <option value="Draft">
                            Draft
                        </option>

                        <option value="Held">
                            Held
                        </option>

                        <option value="Completed">
                            Completed
                        </option>

                        <option value="Cancelled">
                            Cancelled
                        </option>

                        <option value="Refunded">
                            Refunded
                        </option>

                    </select>

                </div>


                {{-- Payment Status --}}

                <div class="sales-orders-filter">

                    <select
                        class="form-select"
                        id="ordersPaymentStatusFilter"
                        aria-label="Filter by payment status"
                    >

                        <option value="">
                            Payment Status
                        </option>

                        <option value="Pending">
                            Pending
                        </option>

                        <option value="Partial">
                            Partial
                        </option>

                        <option value="Paid">
                            Paid
                        </option>

                        <option value="Refunded">
                            Refunded
                        </option>

                    </select>

                </div>


                {{-- Date Range --}}

                <div class="sales-orders-date-range">

                    <div class="sales-orders-date">

                        <i class="bi bi-calendar3"></i>

                        <input
                            type="date"
                            id="ordersDateFrom"
                            aria-label="Date from"
                        >

                    </div>


                    <span class="sales-orders-date-separator">
                        —
                    </span>


                    <div class="sales-orders-date">

                        <input
                            type="date"
                            id="ordersDateTo"
                            aria-label="Date to"
                        >

                    </div>

                </div>


                {{-- Reset --}}

                <button
                    type="button"
                    class="btn btn-light sales-orders-reset"
                    id="ordersReset"
                    title="Reset filters"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    <span class="d-none d-xl-inline">
                        Reset
                    </span>

                </button>


                {{-- Refresh --}}

                <button
                    type="button"
                    class="btn btn-light sales-orders-refresh"
                    id="ordersRefresh"
                    title="Refresh"
                >

                    <i class="bi bi-arrow-clockwise"></i>

                </button>

            </div>

        </div>

        {{-- ======================================================
            Orders Table
        ======================================================= --}}

        <div class="card-body pt-0">            

            <div class="table-responsive">

                <table
                    class="table align-middle mb-0"
                >

                    <thead>

                        <tr>

                            <th>
                                Order
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Branch
                            </th>

                            <th>
                                Date
                            </th>

                            <th class="text-end">
                                Items
                            </th>

                            <th class="text-end">
                                Total
                            </th>

                            <th>
                                Payment
                            </th>

                            <th>
                                Status
                            </th>

                            <th
                                class="text-end"
                                style="width: 90px;"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="ordersTable">

                        <tr>

                            <td
                                colspan="9"
                                class="text-center text-muted py-5"
                            >

                                <div
                                    class="spinner-border spinner-border-sm me-2"
                                ></div>

                                Loading sales orders...

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            <div
                class="d-flex justify-content-end mt-3"
                id="ordersPagination"
            ></div>


            {{-- ==================================================
                Pagination
            =================================================== --}}

            <div
                class="d-flex justify-content-end mt-3"
                id="ordersPagination"
            ></div>

        </div>

    </div>

</div>



<div
    id="salesOrderActionMenu"
    class="sales-order-global-action-menu"
    aria-hidden="true"
>

    {{-- ==================================================
        View
    =================================================== --}}

    @permission('orders.view')

    <button
        type="button"
        data-order-action="view"
        class="sales-order-global-action-button"
    >

        <span class="sales-order-global-action-icon">

            <i class="bi bi-eye"></i>

        </span>


        <span class="sales-order-global-action-label">
            View
        </span>

    </button>

    @endpermission


    {{-- ==================================================
        Edit
    =================================================== --}}

    @permission('orders.update')

    <button
        type="button"
        data-order-action="edit"
        class="sales-order-global-action-button"
    >

        <span class="sales-order-global-action-icon">

            <i class="bi bi-pencil"></i>

        </span>


        <span class="sales-order-global-action-label">
            Edit
        </span>

    </button>

    @endpermission


    {{-- ==================================================
        Complete
    =================================================== --}}

    @permission('orders.update')

    <button
        type="button"
        data-order-action="complete"
        class="sales-order-global-action-button sales-order-global-action-complete"
    >

        <span class="sales-order-global-action-icon">

            <i class="bi bi-check2-circle"></i>

        </span>


        <span class="sales-order-global-action-label">
            Finalize Order
        </span>

    </button>

    @endpermission


    {{-- ==================================================
        Print Receipt
    =================================================== --}}

    @permission('orders.view')

    <button
        type="button"
        data-order-action="print-receipt"
        class="sales-order-global-action-button sales-order-global-action-print"
    >

        <span class="sales-order-global-action-icon">

            <i class="bi bi-printer"></i>

        </span>


        <span class="sales-order-global-action-label">
            Print Receipt
        </span>

    </button>

    @endpermission

    @permission('orders.view')

    <button
        type="button"
        data-order-action="receipt-pdf"
        class="sales-order-global-action-button sales-order-global-action-print"
    >

        <span class="sales-order-global-action-icon">

            <i class="bi bi-file-earmark-pdf"></i>

        </span>


        <span class="sales-order-global-action-label">

            Download PDF

        </span>

    </button>

    @endpermission


    {{-- ==================================================
        Divider
    =================================================== --}}

    @if (
        canAccess('orders.update') ||
        canAccess('orders.delete')
    )

        <div
            class="sales-order-global-action-divider"
        ></div>

    @endif


    {{-- ==================================================
        Remove
    =================================================== --}}

    @permission('orders.delete')

    <button
        type="button"
        data-order-action="delete"
        class="sales-order-global-action-button sales-order-global-action-danger"
    >

        <span class="sales-order-global-action-icon">

            <i class="bi bi-trash"></i>

        </span>


        <span class="sales-order-global-action-label">
            Remove
        </span>

    </button>

    @endpermission

</div>

{{-- ==============================================================
    Create / Edit Order Modal
============================================================== --}}

@includeIf(
    'sales.orders.modals.modal'
)

{{-- ==============================================================
    Quick Customer Modal
============================================================== --}}

@includeIf(
    'sales.orders.modals.customer-modal'
)


{{-- ==============================================================
    Quick Terminal Modal
============================================================== --}}

@includeIf(
    'sales.orders.modals.terminal-modal'
)

{{-- ==============================================================
    Confirmation Order Modal
============================================================== --}}

@includeIf(
    'sales.orders.modals.confirmation-modal'
)

{{-- ==============================================================
    Complete Order Modal
============================================================== --}}

@includeIf(
    'sales.orders.modals.complete-modal'
)


{{-- ==============================================================
    Order Inspector
============================================================== --}}

@includeIf(
    'sales.orders.partials.inspector'
)

<script
        src="{{ asset('assets/js/order.js') }}"
    ></script>
@endsection