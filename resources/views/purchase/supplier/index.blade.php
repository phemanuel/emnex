@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')

    <div
        class="container-fluid px-0"
        id="suppliersPage"
    >

        {{-- ==========================================================
            Page Header
        =========================================================== --}}

        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <div class="page-icon">

                        <i class="bi bi-truck"></i>

                    </div>

                    <h4 class="mb-0 fw-semibold">
                        Suppliers
                    </h4>

                </div>

                <p class="text-muted mb-0">
                    Manage your suppliers, contact information and supplier balances.
                </p>

            </div>


            @permission('suppliers.create')

                <button
                    type="button"
                    class="btn btn-primary"
                    onclick="Suppliers.openCreateModal()"
                >

                    <i class="bi bi-plus-lg me-1"></i>

                    Add Supplier

                </button>

            @endpermission

        </div>


        {{-- ==========================================================
            KPI Cards
        =========================================================== --}}

        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="supplier-kpi-card">

                    <div class="supplier-kpi-icon">

                        <i class="bi bi-buildings"></i>

                    </div>

                    <div class="supplier-kpi-content">

                        <span class="supplier-kpi-label">
                            Total Suppliers
                        </span>

                        <strong
                            id="supplierTotalCount"
                            class="supplier-kpi-value"
                        >
                            {{ number_format($stats['total']) }}
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-xl-3">

                <div class="supplier-kpi-card">

                    <div class="supplier-kpi-icon supplier-kpi-icon-success">

                        <i class="bi bi-check-circle"></i>

                    </div>

                    <div class="supplier-kpi-content">

                        <span class="supplier-kpi-label">
                            Active
                        </span>

                        <strong
                            id="supplierActiveCount"
                            class="supplier-kpi-value"
                        >
                            {{ number_format($stats['active']) }}
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-xl-3">

                <div class="supplier-kpi-card">

                    <div class="supplier-kpi-icon supplier-kpi-icon-warning">

                        <i class="bi bi-pause-circle"></i>

                    </div>

                    <div class="supplier-kpi-content">

                        <span class="supplier-kpi-label">
                            Inactive
                        </span>

                        <strong
                            id="supplierInactiveCount"
                            class="supplier-kpi-value"
                        >
                            {{ number_format($stats['inactive']) }}
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-12 col-sm-6 col-xl-3">

                <div class="supplier-kpi-card">

                    <div class="supplier-kpi-icon supplier-kpi-icon-danger">

                        <i class="bi bi-wallet2"></i>

                    </div>

                    <div class="supplier-kpi-content">

                        <span class="supplier-kpi-label">
                            Outstanding Payables
                        </span>

                        <strong
                            id="supplierPayables"
                            class="supplier-kpi-value"
                        >
                            {{ number_format($stats['payables'], 2) }}
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Main Card
        =========================================================== --}}

        <div class="card border-0 shadow-sm supplier-main-card">

            {{-- ======================================================
                Toolbar
            ======================================================= --}}

            <div class="card-body border-bottom supplier-toolbar">

                <div class="row g-2 align-items-center">

                    <div class="col-12 col-lg">

                        <div class="supplier-search">

                            <i class="bi bi-search"></i>

                            <input
                                type="search"
                                id="supplierSearch"
                                class="form-control"
                                placeholder="Search suppliers..."
                                autocomplete="off"
                            >

                        </div>

                    </div>


                    <div class="col-12 col-sm-auto">

                        <select
                            id="supplierStatusFilter"
                            class="form-select"
                        >

                            <option value="all">
                                All Status
                            </option>

                            <option value="1">
                                Active
                            </option>

                            <option value="0">
                                Inactive
                            </option>

                        </select>

                    </div>


                    <div class="col-12 col-sm-auto">

                        <button
                            type="button"
                            class="btn btn-light border"
                            id="supplierRefreshBtn"
                        >

                            <i class="bi bi-arrow-clockwise"></i>

                            <span class="d-none d-sm-inline ms-1">
                                Refresh
                            </span>

                        </button>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                Table
            ======================================================= --}}

            <div class="supplier-table-wrapper">

                <div
                    id="supplierTable"
                    class="table-responsive"
                >

                    <div class="supplier-loading-state">

                        <div
                            class="spinner-border spinner-border-sm text-primary"
                            role="status"
                        ></div>

                        <span>
                            Loading suppliers...
                        </span>

                    </div>

                </div>

            </div>


            {{-- ======================================================
                Pagination
            ======================================================= --}}

            <div
                class="card-footer bg-white border-0"
                id="supplierPagination"
            ></div>

        </div>

    </div>

    {{-- ==============================================================
        Global Supplier Action Menu
    ============================================================== --}}

    <div
        id="supplierGlobalActionMenu"
        class="dropdown-menu shadow border-0"
        style="display: none;"
    ></div>



@include('purchase.supplier.modals.modal')

@include('purchase.supplier.modals.delete')

@include('purchase.supplier.modals.toggle-status')

@include('purchase.supplier.modals.confirmation-modal')

@include('purchase.supplier.partials.inspector')


<script src="{{ asset('assets/js/supplier.js') }}"></script>
@endsection