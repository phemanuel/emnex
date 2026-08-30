@extends('layouts.app')

@section('title', 'Cash Drawer')

@section('content')

<div class="container-fluid px-0">

    {{-- 
    |--------------------------------------------------------------------------
    | Page Header
    |--------------------------------------------------------------------------
    --}}

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">

        <div>

            <div class="d-flex align-items-center gap-2 mb-1">

                <h4 class="mb-0 fw-semibold">
                    Cash Drawer
                </h4>

                <span
                    id="drawer-status-badge"
                    class="badge bg-secondary-subtle text-secondary"
                >
                    Closed
                </span>

            </div>

            <p class="text-muted mb-0">
                Manage your current cash drawer and monitor cash movements.
            </p>

        </div>

        <div class="d-flex align-items-center gap-2">

            @if(canAccess('pos.cash_drawer'))

                <button
                    type="button"
                    class="btn btn-primary"
                    id="open-drawer-btn"
                >
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Open Drawer
                </button>

                <button
                    type="button"
                    class="btn btn-outline-secondary d-none"
                    id="refresh-drawer-btn"
                >
                    <i class="bi bi-arrow-clockwise me-1"></i>
                    Refresh
                </button>

            @endif

        </div>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Drawer Information
    |--------------------------------------------------------------------------
    --}}

    <div
        class="card emnex-card mb-4"
        id="drawer-summary-card"
    >

        <div class="card-body">

            <div class="row g-4 align-items-center">

                <div class="col-lg-4">

                    <div class="d-flex align-items-center gap-3">

                        <div class="drawer-icon">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                        <div>

                            <div class="text-muted small mb-1">
                                Current Drawer
                            </div>

                            <div
                                class="fw-semibold"
                                id="drawer-terminal-name"
                            >
                                —
                            </div>

                            <div
                                class="text-muted small"
                                id="drawer-branch-name"
                            >
                                —
                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-lg-3">

                    <div class="small text-muted mb-1">
                        Opened By
                    </div>

                    <div
                        class="fw-medium"
                        id="drawer-opened-by"
                    >
                        —
                    </div>

                    <div
                        class="small text-muted"
                        id="drawer-opened-at"
                    >
                        —
                    </div>

                </div>


                <div class="col-lg-3">

                    <div class="small text-muted mb-1">
                        Opening Balance
                    </div>

                    <div
                        class="fs-5 fw-semibold"
                        id="drawer-opening-balance"
                    >
                        ₦0.00
                    </div>

                </div>


                <div class="col-lg-2 text-lg-end">

                    @if(canAccess('pos.cash_drawer'))

                        <button
                            type="button"
                            class="btn btn-outline-danger d-none"
                            id="close-drawer-btn"
                        >
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Close Drawer
                        </button>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | KPI Cards
    |--------------------------------------------------------------------------
    --}}

    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="text-muted small mb-2">
                                Opening Balance
                            </div>

                            <div
                                class="fs-4 fw-semibold"
                                id="kpi-opening-balance"
                            >
                                ₦0.00
                            </div>

                        </div>

                        <div class="kpi-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="text-muted small mb-2">
                                Cash Sales
                            </div>

                            <div
                                class="fs-4 fw-semibold"
                                id="kpi-cash-sales"
                            >
                                ₦0.00
                            </div>

                        </div>

                        <div class="kpi-icon">
                            <i class="bi bi-cart-check"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="text-muted small mb-2">
                                Cash In
                            </div>

                            <div
                                class="fs-4 fw-semibold"
                                id="kpi-cash-in"
                            >
                                ₦0.00
                            </div>

                        </div>

                        <div class="kpi-icon">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>

                            <div class="text-muted small mb-2">
                                Cash Out
                            </div>

                            <div
                                class="fs-4 fw-semibold"
                                id="kpi-cash-out"
                            >
                                ₦0.00
                            </div>

                        </div>

                        <div class="kpi-icon">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Balance Summary
    |--------------------------------------------------------------------------
    --}}

    <div class="row g-3 mb-4">

        <div class="col-lg-4">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Cash Refunds
                    </div>

                    <div
                        class="fs-4 fw-semibold"
                        id="kpi-cash-refunds"
                    >
                        ₦0.00
                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Expected Balance
                    </div>

                    <div
                        class="fs-4 fw-semibold"
                        id="kpi-expected-balance"
                    >
                        ₦0.00
                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-4">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Current Cash Balance
                    </div>

                    <div
                        class="fs-4 fw-semibold"
                        id="kpi-current-balance"
                    >
                        ₦0.00
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Cash Actions
    |--------------------------------------------------------------------------
    --}}

    <div
        class="card emnex-card mb-4"
        id="cash-actions-card"
    >

        <div class="card-header bg-transparent border-0 pt-4 px-4">

            <div>

                <h6 class="mb-1 fw-semibold">
                    Cash Operations
                </h6>

                <p class="text-muted small mb-0">
                    Record cash movements that are not customer sales.
                </p>

            </div>

        </div>

        <div class="card-body px-4 pb-4">

            <div class="d-flex flex-wrap gap-2">

                @if(canAccess('pos.cash_drawer'))

                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        id="cash-in-btn"
                        disabled
                    >
                        <i class="bi bi-arrow-down-circle me-1"></i>
                        Cash In
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        id="cash-out-btn"
                        disabled
                    >
                        <i class="bi bi-arrow-up-circle me-1"></i>
                        Cash Out
                    </button>

                @endif

            </div>

        </div>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Transactions
    |--------------------------------------------------------------------------
    --}}

    <div class="card emnex-card mb-4">

        <div class="card-header bg-transparent border-0 pt-4 px-4">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                <div>

                    <h6 class="mb-1 fw-semibold">
                        Cash Transactions
                    </h6>

                    <p class="text-muted small mb-0">
                        All cash movements recorded against the current drawer.
                    </p>

                </div>

                <div class="d-flex align-items-center gap-2">

                    <select
                        class="form-select form-select-sm"
                        id="transaction-type-filter"
                    >
                        <option value="">
                            All Types
                        </option>

                        <option value="Sale">
                            Cash Sales
                        </option>

                        <option value="Cash In">
                            Cash In
                        </option>

                        <option value="Cash Out">
                            Cash Out
                        </option>

                        <option value="Refund">
                            Refunds
                        </option>
                    </select>

                    <input
                        type="text"
                        class="form-control form-control-sm"
                        id="transaction-search"
                        placeholder="Search..."
                    >

                </div>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle mb-0"
                    id="cash-drawer-transactions-table"
                >

                    <thead>

                        <tr>

                            <th>
                                Transaction
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Reference
                            </th>

                            <th>
                                Amount
                            </th>

                            <th>
                                Balance
                            </th>

                            <th>
                                Created By
                            </th>

                            <th>
                                Date
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="cash-drawer-transactions-body">

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5 text-muted"
                            >
                                No transactions found.
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <div
            class="card-footer bg-transparent border-0 px-4 py-3"
            id="transactions-pagination"
        >

        </div>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Drawer History
    |--------------------------------------------------------------------------
    --}}

    <div class="card emnex-card mb-4">

        <div class="card-header bg-transparent border-0 pt-4 px-4">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">

                <div>

                    <h6 class="mb-1 fw-semibold">
                        Drawer History
                    </h6>

                    <p class="text-muted small mb-0">
                        Previous cash drawer sessions.
                    </p>

                </div>

                <input
                    type="text"
                    class="form-control form-control-sm"
                    id="drawer-history-search"
                    placeholder="Search drawer history..."
                    style="max-width: 240px;"
                >

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table table-hover align-middle mb-0"
                    id="cash-drawer-history-table"
                >

                    <thead>

                        <tr>

                            <th>
                                Drawer
                            </th>

                            <th>
                                Opened By
                            </th>

                            <th>
                                Opened At
                            </th>

                            <th>
                                Opening
                            </th>

                            <th>
                                Expected
                            </th>

                            <th>
                                Actual
                            </th>

                            <th>
                                Variance
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="cash-drawer-history-body">

                        <tr>

                            <td
                                colspan="9"
                                class="text-center py-5 text-muted"
                            >
                                No drawer history found.
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <div
            class="card-footer bg-transparent border-0 px-4 py-3"
            id="drawer-history-pagination"
        >

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Open Drawer Modal
|--------------------------------------------------------------------------
--}}

<div
    class="modal fade"
    id="openDrawerModal"
    tabindex="-1"
    aria-labelledby="openDrawerModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="openDrawerModalLabel"
                    >
                        Open Cash Drawer
                    </h5>

                    <p class="text-muted small mb-0">
                        Start a new cash drawer session.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="open-drawer-form">

                <div class="modal-body">

                    <div class="mb-3">

                        <label
                            for="opening_balance"
                            class="form-label"
                        >
                            Opening Balance
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₦
                            </span>

                            <input
                                type="number"
                                class="form-control"
                                id="opening_balance"
                                name="opening_balance"
                                min="0"
                                step="0.01"
                                value="0.00"
                                required
                            >

                        </div>

                        <div
                            class="invalid-feedback"
                            data-error="opening_balance"
                        ></div>

                    </div>


                    <div class="mb-0">

                        <label
                            for="opening_remarks"
                            class="form-label"
                        >
                            Opening Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="opening_remarks"
                            name="opening_remarks"
                            rows="3"
                            placeholder="Optional opening remarks..."
                        ></textarea>

                        <div
                            class="invalid-feedback"
                            data-error="opening_remarks"
                        ></div>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="open-drawer-submit"
                    >
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        Open Drawer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Cash In Modal
|--------------------------------------------------------------------------
--}}

<div
    class="modal fade"
    id="cashInModal"
    tabindex="-1"
    aria-labelledby="cashInModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="cashInModalLabel"
                    >
                        Cash In
                    </h5>

                    <p class="text-muted small mb-0">
                        Add cash to the drawer.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="cash-in-form">

                <div class="modal-body">

                    <div class="mb-3">

                        <label
                            for="cash_in_amount"
                            class="form-label"
                        >
                            Amount
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₦
                            </span>

                            <input
                                type="number"
                                class="form-control"
                                id="cash_in_amount"
                                name="amount"
                                min="0.01"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>


                    <div class="mb-3">

                        <label
                            for="cash_in_reference_no"
                            class="form-label"
                        >
                            Reference No.
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="cash_in_reference_no"
                            name="reference_no"
                            placeholder="Optional reference..."
                        >

                    </div>


                    <div class="mb-0">

                        <label
                            for="cash_in_remarks"
                            class="form-label"
                        >
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="cash_in_remarks"
                            name="remarks"
                            rows="3"
                            placeholder="Reason for cash in..."
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="cash-in-submit"
                    >
                        <i class="bi bi-arrow-down-circle me-1"></i>
                        Record Cash In
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Cash Out Modal
|--------------------------------------------------------------------------
--}}

<div
    class="modal fade"
    id="cashOutModal"
    tabindex="-1"
    aria-labelledby="cashOutModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="cashOutModalLabel"
                    >
                        Cash Out
                    </h5>

                    <p class="text-muted small mb-0">
                        Remove cash from the drawer.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="cash-out-form">

                <div class="modal-body">

                    <div class="mb-3">

                        <label
                            for="cash_out_amount"
                            class="form-label"
                        >
                            Amount
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₦
                            </span>

                            <input
                                type="number"
                                class="form-control"
                                id="cash_out_amount"
                                name="amount"
                                min="0.01"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>


                    <div class="mb-3">

                        <label
                            for="cash_out_reference_no"
                            class="form-label"
                        >
                            Reference No.
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="cash_out_reference_no"
                            name="reference_no"
                            placeholder="Optional reference..."
                        >

                    </div>


                    <div class="mb-0">

                        <label
                            for="cash_out_remarks"
                            class="form-label"
                        >
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="cash_out_remarks"
                            name="remarks"
                            rows="3"
                            placeholder="Reason for cash out..."
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                        id="cash-out-submit"
                    >
                        <i class="bi bi-arrow-up-circle me-1"></i>
                        Record Cash Out
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Close Drawer Modal
|--------------------------------------------------------------------------
--}}

<div
    class="modal fade"
    id="closeDrawerModal"
    tabindex="-1"
    aria-labelledby="closeDrawerModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="closeDrawerModalLabel"
                    >
                        Close Cash Drawer
                    </h5>

                    <p class="text-muted small mb-0">
                        Count the physical cash before closing the drawer.
                    </p>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="close-drawer-form">

                <div class="modal-body">

                    <div class="drawer-close-summary mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                Expected Balance
                            </span>

                            <strong id="close-expected-balance">
                                ₦0.00
                            </strong>

                        </div>

                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                Cash Sales
                            </span>

                            <strong id="close-cash-sales">
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <div class="mb-3">

                        <label
                            for="actual_balance"
                            class="form-label"
                        >
                            Actual Cash Count
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                ₦
                            </span>

                            <input
                                type="number"
                                class="form-control"
                                id="actual_balance"
                                name="actual_balance"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                        <div class="form-text">
                            Enter the physical cash currently in the drawer.
                        </div>

                    </div>


                    <div
                        class="alert d-none"
                        id="variance-preview"
                    >

                        <div class="d-flex justify-content-between">

                            <span>
                                Variance
                            </span>

                            <strong id="variance-preview-value">
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <div class="mb-0">

                        <label
                            for="closing_remarks"
                            class="form-label"
                        >
                            Closing Remarks
                        </label>

                        <textarea
                            class="form-control"
                            id="closing_remarks"
                            name="closing_remarks"
                            rows="3"
                            placeholder="Optional closing remarks..."
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                        id="close-drawer-submit"
                    >
                        <i class="bi bi-box-arrow-right me-1"></i>
                        Close Drawer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Transaction Inspector
|--------------------------------------------------------------------------
--}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="cashDrawerTransactionInspector"
    aria-labelledby="cashDrawerTransactionInspectorLabel"
>

    <div class="offcanvas-header border-bottom">

        <div>

            <h5
                class="offcanvas-title"
                id="cashDrawerTransactionInspectorLabel"
            >
                Transaction Details
            </h5>

            <div
                class="small text-muted"
                id="transaction-inspector-number"
            >
                —
            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    <div class="offcanvas-body">

        <div class="mb-4">

            <div class="small text-muted mb-1">
                Transaction Type
            </div>

            <div id="inspector-transaction-type">
                —
            </div>

        </div>


        <div class="mb-4">

            <div class="small text-muted mb-1">
                Amount
            </div>

            <div
                class="fs-4 fw-semibold"
                id="inspector-amount"
            >
                ₦0.00
            </div>

        </div>


        <div class="row g-3 mb-4">

            <div class="col-6">

                <div class="small text-muted mb-1">
                    Balance Before
                </div>

                <div
                    class="fw-medium"
                    id="inspector-balance-before"
                >
                    ₦0.00
                </div>

            </div>


            <div class="col-6">

                <div class="small text-muted mb-1">
                    Balance After
                </div>

                <div
                    class="fw-medium"
                    id="inspector-balance-after"
                >
                    ₦0.00
                </div>

            </div>

        </div>


        <div class="mb-4">

            <div class="small text-muted mb-1">
                Reference No.
            </div>

            <div id="inspector-reference">
                —
            </div>

        </div>


        <div class="mb-4">

            <div class="small text-muted mb-1">
                Created By
            </div>

            <div id="inspector-created-by">
                —
            </div>

        </div>


        <div class="mb-4">

            <div class="small text-muted mb-1">
                Date
            </div>

            <div id="inspector-created-at">
                —
            </div>

        </div>


        <div>

            <div class="small text-muted mb-1">
                Remarks
            </div>

            <div
                class="text-break"
                id="inspector-remarks"
            >
                —
            </div>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Drawer History Inspector
|--------------------------------------------------------------------------
--}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="cashDrawerInspector"
    aria-labelledby="cashDrawerInspectorLabel"
>

    <div class="offcanvas-header border-bottom">

        <div>

            <h5
                class="offcanvas-title"
                id="cashDrawerInspectorLabel"
            >
                Drawer Details
            </h5>

            <div
                class="small text-muted"
                id="drawer-inspector-status"
            >
                —
            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    <div class="offcanvas-body">

        <div class="row g-3 mb-4">

            <div class="col-6">

                <div class="small text-muted mb-1">
                    Opening Balance
                </div>

                <div
                    class="fw-semibold"
                    id="history-opening-balance"
                >
                    ₦0.00
                </div>

            </div>


            <div class="col-6">

                <div class="small text-muted mb-1">
                    Cash Sales
                </div>

                <div
                    class="fw-semibold"
                    id="history-cash-sales"
                >
                    ₦0.00
                </div>

            </div>


            <div class="col-6">

                <div class="small text-muted mb-1">
                    Cash In
                </div>

                <div
                    class="fw-semibold"
                    id="history-cash-in"
                >
                    ₦0.00
                </div>

            </div>


            <div class="col-6">

                <div class="small text-muted mb-1">
                    Cash Out
                </div>

                <div
                    class="fw-semibold"
                    id="history-cash-out"
                >
                    ₦0.00
                </div>

            </div>


            <div class="col-6">

                <div class="small text-muted mb-1">
                    Expected
                </div>

                <div
                    class="fw-semibold"
                    id="history-expected-balance"
                >
                    ₦0.00
                </div>

            </div>


            <div class="col-6">

                <div class="small text-muted mb-1">
                    Actual
                </div>

                <div
                    class="fw-semibold"
                    id="history-actual-balance"
                >
                    ₦0.00
                </div>

            </div>

        </div>


        <div class="border-top pt-3">

            <div class="small text-muted mb-1">
                Variance
            </div>

            <div
                class="fs-5 fw-semibold"
                id="history-variance"
            >
                ₦0.00
            </div>

        </div>


        <div class="border-top mt-4 pt-4">

            <div class="mb-3">

                <div class="small text-muted mb-1">
                    Opened By
                </div>

                <div id="history-opened-by">
                    —
                </div>

            </div>


            <div class="mb-3">

                <div class="small text-muted mb-1">
                    Opened At
                </div>

                <div id="history-opened-at">
                    —
                </div>

            </div>


            <div class="mb-3">

                <div class="small text-muted mb-1">
                    Closed By
                </div>

                <div id="history-closed-by">
                    —
                </div>

            </div>


            <div class="mb-3">

                <div class="small text-muted mb-1">
                    Closed At
                </div>

                <div id="history-closed-at">
                    —
                </div>

            </div>


            <div>

                <div class="small text-muted mb-1">
                    Closing Remarks
                </div>

                <div
                    class="text-break"
                    id="history-closing-remarks"
                >
                    —
                </div>

            </div>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Confirmation Modal
|--------------------------------------------------------------------------
--}}

<div
    class="modal fade"
    id="cashDrawerConfirmationModal"
    tabindex="-1"
    aria-labelledby="cashDrawerConfirmationModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="cashDrawerConfirmationModalLabel"
                >
                    Confirm Action
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="text-center py-2">

                    <div class="confirmation-icon mb-3">

                        <i
                            class="bi bi-exclamation-circle"
                            id="confirmation-icon"
                        ></i>

                    </div>

                    <h6
                        class="fw-semibold mb-2"
                        id="confirmation-title"
                    >
                        Confirm Action
                    </h6>

                    <p
                        class="text-muted mb-0"
                        id="confirmation-message"
                    >
                        Are you sure you want to continue?
                    </p>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-danger"
                    id="confirmation-submit"
                >
                    Confirm
                </button>

            </div>

        </div>

    </div>

</div>


{{-- 
|--------------------------------------------------------------------------
| Page Data
|--------------------------------------------------------------------------
--}}

<script>

    window.CashDrawerConfig = {

        urls: {

            index:
                "{{ route('cash-drawer.index') }}",

            current:
                "{{ route('cash-drawer.current') }}",

            open:
                "{{ route('cash-drawer.open') }}",

            close:
                "{{ route('cash-drawer.close') }}",

            cashIn:
                "{{ route('cash-drawer.cash-in') }}",

            cashOut:
                "{{ route('cash-drawer.cash-out') }}",

            transactions:
                "{{ route('cash-drawer.transactions') }}",

            history:
                "{{ route('cash-drawer.history') }}",

            transactionDetails:
                "{{ route('cash-drawer.transaction-details', ['id' => '__ID__']) }}",

            details:
                "{{ route('cash-drawer.details', ['id' => '__ID__']) }}"

        },

        permissions: {

            access:
                @json(canAccess('pos.cash_drawer'))

        }

    };

</script>

@endsection