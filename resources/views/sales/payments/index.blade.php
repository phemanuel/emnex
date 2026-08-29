@extends('layouts.app')

@section('title', 'Sales Payments')

@section('content')

<div class="container-fluid py-4 payment-module">

    {{-- ==============================================================
        Page Header
    =============================================================== --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <div class="text-muted small mb-1">
                Sales
            </div>

            <h4 class="fw-semibold mb-1">
                Payments
            </h4>

            <div class="text-muted small">
                View and track payments received against sales orders.
            </div>

        </div>


        <button
            type="button"
            class="btn btn-light btn-sm"
            id="refreshPayments"
        >

            <i class="bi bi-arrow-clockwise me-1"></i>

            Refresh

        </button>

    </div>


    {{-- ==============================================================
        KPI Cards
    =============================================================== --}}

    <div class="row g-3 mb-4">

        {{-- Total Payments --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Total Payments
                    </div>

                    <div id="paymentTotalCount" class="fs-4 fw-semibold mt-1" > 
                        {{ number_format($paymentTotalCount) }} 
                    </div>

                </div>

            </div>

        </div>


        {{-- Completed --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Completed
                    </div>

                    <div id="paymentCompletedCount" class="fs-4 fw-semibold mt-1" > 
                        {{ number_format($paymentCompletedCount) }} 
                    </div>

                </div>

            </div>

        </div>


        {{-- Pending --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Pending
                    </div>

                    <div id="paymentPendingCount" class="fs-4 fw-semibold mt-1" > 
                        {{ number_format($paymentPendingCount) }} 
                    </div>

                </div>

            </div>

        </div>


        {{-- Total Amount --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small">
                        Completed Amount
                    </div>

                    <div id="paymentTotalAmount" class="fs-4 fw-semibold mt-1" > 
                        ₦{{ number_format( (float) $paymentTotalAmount, 2 ) }} 
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==============================================================
        Filters
    =============================================================== --}}

    <div class="card emnex-card mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- Search --}}

                <div class="col-xl-3 col-lg-4">

                    <label
                        for="paymentSearch"
                        class="form-label small fw-semibold"
                    >
                        Search
                    </label>

                    <input
                        type="text"
                        id="paymentSearch"
                        class="form-control"
                        placeholder="Payment, order, customer or reference..."
                    >

                </div>


                {{-- Branch --}}

                <div class="col-xl-2 col-lg-4">

                    <label
                        for="paymentBranchFilter"
                        class="form-label small fw-semibold"
                    >
                        Branch
                    </label>

                    <select
                        id="paymentBranchFilter"
                        class="form-select"
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


                {{-- Payment Method --}}

                <div class="col-xl-2 col-lg-4">

                    <label
                        for="paymentMethodFilter"
                        class="form-label small fw-semibold"
                    >
                        Payment Method
                    </label>

                    <select
                        id="paymentMethodFilter"
                        class="form-select"
                    >

                        <option value="">
                            All Methods
                        </option>

                        <option value="Cash">
                            Cash
                        </option>

                        <option value="POS">
                            POS
                        </option>

                        <option value="Transfer">
                            Transfer
                        </option>

                        <option value="Wallet">
                            Wallet
                        </option>

                        <option value="Credit">
                            Credit
                        </option>

                        <option value="Cheque">
                            Cheque
                        </option>

                    </select>

                </div>


                {{-- Payment Status --}}

                <div class="col-xl-2 col-lg-4">

                    <label
                        for="paymentStatusFilter"
                        class="form-label small fw-semibold"
                    >
                        Status
                    </label>

                    <select
                        id="paymentStatusFilter"
                        class="form-select"
                    >

                        <option value="">
                            All Statuses
                        </option>

                        <option value="Completed">
                            Completed
                        </option>

                        <option value="Pending">
                            Pending
                        </option>

                        <option value="Failed">
                            Failed
                        </option>

                        <option value="Cancelled">
                            Cancelled
                        </option>

                        <option value="Refunded">
                            Refunded
                        </option>

                    </select>

                </div>


                {{-- Date From --}}

                <div class="col-xl-1 col-lg-4">

                    <label
                        for="paymentDateFrom"
                        class="form-label small fw-semibold"
                    >
                        From
                    </label>

                    <input
                        type="date"
                        id="paymentDateFrom"
                        class="form-control"
                    >

                </div>


                {{-- Date To --}}

                <div class="col-xl-1 col-lg-4">

                    <label
                        for="paymentDateTo"
                        class="form-label small fw-semibold"
                    >
                        To
                    </label>

                    <input
                        type="date"
                        id="paymentDateTo"
                        class="form-control"
                    >

                </div>


                {{-- Reset --}}

                <div class="col-xl-1 col-lg-4 d-flex align-items-end">

                    <button
                        type="button"
                        class="btn btn-light w-100"
                        id="resetPaymentFilters"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>


    {{-- ==============================================================
        Payments Table
    =============================================================== --}}

    <div class="card emnex-card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead>

                       
                        <tr>

                            <th class="ps-4">
                                Payment
                            </th>

                            <th>
                                Order
                            </th>

                            <th>
                                Customer
                            </th>

                            <th>
                                Order Total
                            </th>

                            <th>
                                Amount Paid
                            </th>

                            <th>
                                Payment
                            </th>

                            <th>
                                Balance
                            </th>

                            <th>
                                Order Status
                            </th>

                            <th>
                                Payment Status
                            </th>

                            <th>
                                Date
                            </th>

                            <th class="text-end pe-4">
                                Actions
                            </th>

                        </tr>


                        </thead>



                    <tbody id="paymentsTableBody">

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <i class="bi bi-credit-card fs-3 d-block mb-2"></i>

                                    Loading payments...

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- ======================================================
                Pagination
            ======================================================= --}}

            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">

                <div
                    id="paymentPaginationInfo"
                    class="text-muted small"
                >
                    —
                </div>


                <div
                    id="paymentPagination"
                    class="d-flex align-items-center gap-1"
                ></div>

            </div>

        </div>

    </div>

</div>


{{-- ==============================================================
    Payment Inspector
=============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="paymentInspector"
    aria-labelledby="paymentInspectorLabel"
>

    <div class="offcanvas-header border-bottom">

        <div>

            <div class="text-muted small mb-1">
                Payment
            </div>

            <h5
                class="offcanvas-title fw-semibold"
                id="paymentInspectorLabel"
            >
                —
            </h5>

        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    <div class="offcanvas-body">

        {{-- ==========================================================
            Status
        =========================================================== --}}

        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                <div class="text-muted small">
                    Payment Status
                </div>

                <div class="small text-muted">
                    Current payment state
                </div>

            </div>


            <span
                id="paymentInspectorStatus"
                class="badge bg-secondary-subtle text-secondary"
            >
                —
            </span>

        </div>


        {{-- ==========================================================
            Payment Information
        =========================================================== --}}

        <div class="purchase-inspector-card mb-4">

            <div class="purchase-inspector-grid">

                <div>

                    <span class="purchase-inspector-label">
                        Payment No.
                    </span>

                    <strong id="paymentInspectorNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Order No.
                    </span>

                    <strong id="paymentInspectorOrderNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Invoice No.
                    </span>

                    <strong id="paymentInspectorInvoiceNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Customer
                    </span>

                    <strong id="paymentInspectorCustomer">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong id="paymentInspectorBranch">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Terminal
                    </span>

                    <strong id="paymentInspectorTerminal">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Payment Method
                    </span>

                    <strong id="paymentInspectorMethod">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Payment Date
                    </span>

                    <strong id="paymentInspectorDate">
                        —
                    </strong>

                </div>

            </div>

        </div>


       {{-- ==========================================================
        Order & Payment Summary
        =========================================================== --}}

        <div class="purchase-inspector-card mb-4">

        
        <div class="purchase-inspector-heading mb-3">
            Order & Payment Summary
        </div>


        {{-- Order Total --}}

        <div class="purchase-summary-row">

            <span>
                Order Total
            </span>

            <strong id="paymentInspectorOrderTotal">
                ₦0.00
            </strong>

        </div>


        {{-- Amount Paid --}}

        <div class="purchase-summary-row">

            <span>
                Amount Paid
            </span>

            <strong id="paymentInspectorAmountPaid">
                ₦0.00
            </strong>

        </div>


        {{-- This Payment --}}

        <div class="purchase-summary-row">

            <span>
                This Payment
            </span>

            <strong id="paymentInspectorAmount">
                ₦0.00
            </strong>

        </div>


        {{-- Balance --}}

        <div class="purchase-summary-row">

            <span>
                Balance
            </span>

            <strong id="paymentInspectorBalance">
                ₦0.00
            </strong>

        </div>


        {{-- Order Status --}}

        <div class="purchase-summary-row">

            <span>
                Order Status
            </span>

            <strong>

                <span
                    id="paymentInspectorOrderStatus"
                    class="badge bg-secondary-subtle text-secondary"
                >
                    —
                </span>

            </strong>

        </div>


        </div>



        {{-- ==========================================================
            Print Receipt
        =========================================================== --}}

        <div class="border rounded-3 p-3 mb-4">

            <div class="d-flex align-items-start gap-3">

                <div class="text-primary">

                    <i class="bi bi-receipt fs-5"></i>

                </div>


                <div class="flex-grow-1">

                    <div class="fw-semibold mb-1">
                        Payment Receipt
                    </div>

                    <div class="text-muted small mb-3">
                        Print a receipt for this payment transaction.
                    </div>


                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        id="paymentPrintReceipt"
                    >

                        <i class="bi bi-printer me-1"></i>

                        Print Receipt

                    </button>

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Remarks
        =========================================================== --}}

        <div class="mb-4">

            <div class="purchase-inspector-heading mb-3">
                Remarks
            </div>


            <div
                id="paymentInspectorRemarks"
                class="text-muted small"
            >
                —
            </div>

        </div>


        {{-- ==========================================================
            Activity
        =========================================================== --}}

        <div class="purchase-inspector-card">

            <div class="purchase-inspector-heading mb-3">
                Activity
            </div>


            <div class="purchase-inspector-meta">

                <div>

                    <span>
                        Received By
                    </span>

                    <strong id="paymentInspectorReceivedBy">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Created
                    </span>

                    <strong id="paymentInspectorCreatedAt">
                        —
                    </strong>

                </div>


                <div>

                    <span>
                        Updated
                    </span>

                    <strong id="paymentInspectorUpdatedAt">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>

</div>


<script
        src="{{ asset('assets/js/payment.js') }}"
    ></script>

@endsection