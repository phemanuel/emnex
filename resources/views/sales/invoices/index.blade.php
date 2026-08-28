@extends('layouts.app')

@section('title', 'Sales Invoices')

@section('content')

{{-- ==============================================================
    Invoice Management
=============================================================== --}}

<div class="container-fluid px-0">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

        <div>

            <div class="text-muted small mb-1">
                Sales
            </div>

            <h4 class="fw-semibold mb-1">
                Invoices
            </h4>

            <p class="text-muted mb-0">
                View invoices for draft and held sales orders.
            </p>

        </div>


        <div class="d-flex align-items-center gap-2">

            <button
                type="button"
                class="btn btn-light btn-sm"
                id="refreshInvoices"
            >

                <i class="bi bi-arrow-clockwise me-1"></i>

                Refresh

            </button>

        </div>

    </div>

        {{-- ==========================================================
        Information Banner
    =========================================================== --}}

    <div class="alert alert-light border d-flex align-items-start gap-3 mb-4">

        <div class="flex-shrink-0">

            <i class="bi bi-info-circle text-primary fs-5"></i>

        </div>

        <div>

            <div class="fw-semibold">
                Invoice workspace
            </div>

            <div class="text-muted small">
                Invoices are read-only. To make a payment or finalize
                an order, open the related sales order from the invoice.
            </div>

        </div>

    </div>

        {{-- ==========================================================
        KPI Cards
    =========================================================== --}}

    <div class="row g-3 mb-4">

        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small">
                                Draft Invoices
                            </div>

                            <div
                                class="fs-4 fw-semibold mt-1"
                                id="invoiceDraftCount"
                            >
                                0
                            </div>

                        </div>

                        <div class="text-primary">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small">
                                Held Invoices
                            </div>

                            <div
                                class="fs-4 fw-semibold mt-1"
                                id="invoiceHeldCount"
                            >
                                0
                            </div>

                        </div>

                        <div class="text-warning">
                            <i class="bi bi-pause-circle fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small">
                                Invoice Value
                            </div>

                            <div
                                class="fs-4 fw-semibold mt-1"
                                id="invoiceTotalValue"
                            >
                                0.00
                            </div>

                        </div>

                        <div class="text-success">
                            <i class="bi bi-receipt fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small">
                                Outstanding
                            </div>

                            <div
                                class="fs-4 fw-semibold mt-1"
                                id="invoiceOutstandingBalance"
                            >
                                0.00
                            </div>

                        </div>

                        <div class="text-danger">
                            <i class="bi bi-wallet2 fs-4"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

        {{-- ==========================================================
        Filters
    =========================================================== --}}

    <div class="card emnex-card mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-end">

                <div class="col-12 col-lg-3">

                    <label
                        for="invoiceSearch"
                        class="form-label small fw-semibold"
                    >
                        Search
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="search"
                            class="form-control"
                            id="invoiceSearch"
                            placeholder="Invoice no., order no., customer..."
                        >

                    </div>

                </div>


                <div class="col-12 col-md-6 col-lg-2">

                    <label
                        for="invoiceBranchFilter"
                        class="form-label small fw-semibold"
                    >
                        Branch
                    </label>

                    <select
                        class="form-select"
                        id="invoiceBranchFilter"
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


                <div class="col-12 col-md-6 col-lg-2">

                    <label
                        for="invoiceStatusFilter"
                        class="form-label small fw-semibold"
                    >
                        Order Status
                    </label>

                    <select
                        class="form-select"
                        id="invoiceStatusFilter"
                    >

                        <option value="">
                            All
                        </option>

                        <option value="Draft">
                            Draft
                        </option>

                        <option value="Held">
                            Held
                        </option>

                    </select>

                </div>


                <div class="col-12 col-md-6 col-lg-2">

                    <label
                        for="invoicePaymentStatusFilter"
                        class="form-label small fw-semibold"
                    >
                        Payment
                    </label>

                    <select
                        class="form-select"
                        id="invoicePaymentStatusFilter"
                    >

                        <option value="">
                            All
                        </option>

                        <option value="Pending">
                            Pending
                        </option>

                        <option value="Partial">
                            Partial
                        </option>

                    </select>

                </div>


                <div class="col-6 col-lg-1">

                    <label
                        for="invoiceDateFrom"
                        class="form-label small fw-semibold"
                    >
                        From
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="invoiceDateFrom"
                    >

                </div>


                <div class="col-6 col-lg-1">

                    <label
                        for="invoiceDateTo"
                        class="form-label small fw-semibold"
                    >
                        To
                    </label>

                    <input
                        type="date"
                        class="form-control"
                        id="invoiceDateTo"
                    >

                </div>


                <div class="col-12 col-lg-1">

                    <button
                        type="button"
                        class="btn btn-light w-100"
                        id="resetInvoiceFilters"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

        {{-- ==========================================================
        Invoice Table
    =========================================================== --}}

    <div class="card emnex-card">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle mb-0"
                >

                    <thead>

                        <tr>

                            <th>
                                Invoice
                            </th>

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
                                Total
                            </th>

                            <th>
                                Paid
                            </th>

                            <th>
                                Balance
                            </th>

                            <th>
                                Payment
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="invoicesTableBody">

                        <tr>

                            <td
                                colspan="10"
                                class="text-center py-5"
                            >

                                <div class="text-muted">

                                    <i class="bi bi-receipt fs-3 d-block mb-2"></i>

                                    Loading invoices...

                                </div>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>


            {{-- ==================================================
                Pagination
            =================================================== --}}

            <div
                class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-3 border-top"
            >

                <div
                    class="text-muted small"
                    id="invoicePaginationInfo"
                >
                    Showing 0 of 0
                </div>


                <div
                    id="invoicePagination"
                    class="d-flex align-items-center gap-1"
                ></div>

            </div>

        </div>

    </div>

</div>


{{-- ==============================================================
    Order Inspector
============================================================== --}}

@includeIf(
    'sales.invoices.partials.inspector'
)

<script
        src="{{ asset('assets/js/invoice.js') }}"
    ></script>
@endsection