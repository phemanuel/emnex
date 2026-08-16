@extends('layouts.app')


@section('title', 'Customer Management')

@section('content')


    {{-- ==========================================================
    PAGE HEADER
=========================================================== --}}

<div class="customer-page-header">


    {{-- ==========================================================
        HEADER CONTENT
    =========================================================== --}}

    <div>

        <div class="customer-page-eyebrow">

            CUSTOMER MANAGEMENT

        </div>


        <h1 class="customer-page-title">

            Customers

        </h1>


        <p class="customer-page-description">

            Manage customers, customer groups and loyalty.

        </p>

    </div>


    {{-- ==========================================================
        MODULE WORKFLOW
    =========================================================== --}}

    <div class="d-flex align-items-center gap-2">


        {{-- Customer Groups --}}

        <div
            class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 bg-light"
        >

            <i class="bi bi-people text-primary"></i>

            <span class="small fw-medium">

                Groups

            </span>

        </div>


        <i
            class="bi bi-chevron-right text-muted small"
        ></i>


        {{-- Customers --}}

        <div
            class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 bg-light"
        >

            <i class="bi bi-person-vcard text-primary"></i>

            <span class="small fw-medium">

                Customers

            </span>

        </div>


        <i
            class="bi bi-chevron-right text-muted small"
        ></i>


        {{-- Loyalty --}}

        <div
            class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 bg-light"
        >

            <i class="bi bi-stars text-primary"></i>

            <span class="small fw-medium">

                Loyalty

            </span>

        </div>


    </div>

</div>


    {{-- ==========================================================
        KPI CARDS
    =========================================================== --}}

    <div class="row g-4 customer-kpi-row">


        {{-- TOTAL CUSTOMERS --}}

        <div class="col-xl-3 col-lg-6 col-md-6">


            <div class="customer-kpi-card">


                <div class="customer-kpi-icon">

                    <i class="bi bi-people"></i>

                </div>


                <div class="customer-kpi-content">


                    <span class="customer-kpi-label">

                        Total Customers

                    </span>


                    <strong
                        id="totalCustomersCount"
                        class="customer-kpi-value"
                    >

                        {{ $stats['customers'] ?? 0 }}

                    </strong>


                    <span class="customer-kpi-meta">

                        Registered customers

                    </span>


                </div>


            </div>


        </div>


        {{-- ACTIVE CUSTOMERS --}}

        <div class="col-xl-3 col-lg-6 col-md-6">


            <div class="customer-kpi-card">


                <div class="customer-kpi-icon">

                    <i class="bi bi-person-check"></i>

                </div>


                <div class="customer-kpi-content">


                    <span class="customer-kpi-label">

                        Active Customers

                    </span>


                    <strong
                        id="activeCustomersCount"
                        class="customer-kpi-value"
                    >

                        {{ $stats['active'] ?? 0 }}

                    </strong>


                    <span class="customer-kpi-meta">

                        Currently active

                    </span>


                </div>


            </div>


        </div>


        {{-- CUSTOMER GROUPS --}}

        <div class="col-xl-3 col-lg-6 col-md-6">


            <div class="customer-kpi-card">


                <div class="customer-kpi-icon">

                    <i class="bi bi-people-fill"></i>

                </div>


                <div class="customer-kpi-content">


                    <span class="customer-kpi-label">

                        Customer Groups

                    </span>


                    <strong
                        id="customerGroupsCount"
                        class="customer-kpi-value"
                    >

                        {{ $stats['groups'] ?? 0 }}

                    </strong>


                    <span class="customer-kpi-meta">

                        Active groups

                    </span>


                </div>


            </div>


        </div>


        {{-- LOYALTY POINTS --}}

        <div class="col-xl-3 col-lg-6 col-md-6">


            <div class="customer-kpi-card">


                <div class="customer-kpi-icon">

                    <i class="bi bi-stars"></i>

                </div>


                <div class="customer-kpi-content">


                    <span class="customer-kpi-label">

                        Loyalty Points

                    </span>


                    <strong
                        id="totalLoyaltyPoints"
                        class="customer-kpi-value"
                    >

                        {{ number_format($stats['loyalty_points'] ?? 0) }}

                    </strong>


                    <span class="customer-kpi-meta">

                        Points issued

                    </span>


                </div>


            </div>


        </div>


    </div>


    {{-- ==========================================================
        MANAGEMENT CARD
    =========================================================== --}}

    <div class="customer-management-card">


        {{-- ======================================================
            TABS
        ======================================================= --}}

        <div class="customer-tabs-wrapper">


            <ul
                class="nav customer-management-tabs"
                id="customerManagementTabs"
                role="tablist"         >                

                {{-- CUSTOMER GROUPS --}}

                <li
                    class="nav-item"
                    role="presentation"
                >

                    <button
                        type="button"
                        class="customer-tab active"
                        id="groups-tab"
                        data-section="groups"
                    >

                        <i class="bi bi-collection me-2"></i>

                        Customer Groups

                        <span
                            class="customer-tab-count"
                            id="groupsTabCount"
                        >

                            {{ $stats['groups'] ?? 0 }}

                        </span>

                    </button>

                </li>

                {{-- CUSTOMERS --}}

                <li
                    class="nav-item"
                    role="presentation"
                >

                    <button
                        type="button"
                        class="customer-tab"
                        id="customers-tab"
                        data-section="customers"
                    >

                        <i class="bi bi-people me-2"></i>

                        Customers

                        <span
                            class="customer-tab-count"
                            id="customersTabCount"
                        >

                            {{ $stats['customers'] ?? 0 }}

                        </span>

                    </button>

                </li>



                {{-- LOYALTY --}}

                <li
                    class="nav-item"
                    role="presentation"
                >

                    <button
                        type="button"
                        class="customer-tab"
                        id="loyalty-tab"
                        data-section="loyalty"
                    >

                        <i class="bi bi-stars me-2"></i>

                        Loyalty

                    </button>

                </li>


            </ul>


        </div>


        {{-- ======================================================
            CUSTOMERS SECTION
        ======================================================= --}}

        <div
            id="customersSection"
            class="customer-management-section"
        >


            <div class="customer-section-header">


                <div>

                    <h5>

                        Customers

                    </h5>


                    <p>

                        Manage customer records and account information.

                    </p>

                </div>


                @permission('customers.create')

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="sectionAddCustomerBtn"
                    >

                        <i class="bi bi-person-plus me-2"></i>

                        Add Customer

                    </button>

                @endpermission


            </div>


            {{-- FILTERS --}}

            <div class="customer-filter-bar">


                <div class="row g-3">


                    {{-- SEARCH --}}

                    <div class="col-xl-5 col-lg-5 col-md-6">


                        <div class="customer-search-box">


                            <i class="bi bi-search"></i>


                            <input
                                type="text"
                                class="form-control"
                                id="customerSearch"
                                placeholder="Search name, phone, email or customer code..."
                            >


                        </div>


                    </div>


                    {{-- GROUP --}}

                    <div class="col-xl-3 col-lg-3 col-md-6">


                        <select
                            class="form-select"
                            id="customerGroupFilter"
                        >

                            <option value="">

                                All Groups

                            </option>


                            @foreach($customerGroups ?? [] as $group)

                                <option value="{{ $group->id }}">

                                    {{ $group->name }}

                                </option>

                            @endforeach


                        </select>


                    </div>


                    {{-- STATUS --}}

                    <div class="col-xl-2 col-lg-2 col-md-6">


                        <select
                            class="form-select"
                            id="customerStatusFilter"
                        >

                            <option value="">

                                All Status

                            </option>


                            <option value="active">

                                Active

                            </option>


                            <option value="inactive">

                                Inactive

                            </option>


                        </select>


                    </div>


                    {{-- RESET --}}

                    <div class="col-xl-2 col-lg-2 col-md-6">


                        <button
                            type="button"
                            class="btn btn-light w-100"
                            id="resetCustomerFilters"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Reset

                        </button>


                    </div>


                </div>


            </div>


            {{-- TABLE --}}

            <div
                id="customerTableContainer"
                class="customer-table-container"
            >


                @include(
                    'customers.partials.table',
                    ['customers' => $customers ?? collect()]
                )


            </div>


            {{-- PAGINATION --}}

            <div
                id="customerPagination"
                class="customer-pagination"
            >

                @if(isset($customers))

                    {{ $customers->links() }}

                @endif

            </div>


        </div>


        {{-- ======================================================
            CUSTOMER GROUPS SECTION
        ======================================================= --}}

        <div
            id="groupsSection"
            class="customer-management-section active"
        >


            <div class="customer-section-header">


                <div>

                    <h5>

                        Customer Groups

                    </h5>


                    <p>

                        Organize customers and apply group-level benefits.

                    </p>

                </div>


                @permission('customer_groups.create')

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="addCustomerGroupBtn"
                    >

                        <i class="bi bi-plus-lg me-2"></i>

                        Add Group

                    </button>

                @endpermission


            </div>


            {{-- GROUP SEARCH --}}

            <div class="customer-filter-bar">


                <div class="row g-3">


                    <div class="col-xl-6 col-lg-6 col-md-8">


                        <div class="customer-search-box">


                            <i class="bi bi-search"></i>


                            <input
                                type="text"
                                class="form-control"
                                id="customerGroupSearch"
                                placeholder="Search group name or code..."
                            >


                        </div>


                    </div>


                    <div class="col-xl-3 col-lg-3 col-md-4">


                        <select
                            class="form-select"
                            id="customerGroupStatusFilter"
                        >

                            <option value="">

                                All Status

                            </option>


                            <option value="active">

                                Active

                            </option>


                            <option value="inactive">

                                Inactive

                            </option>


                        </select>


                    </div>


                    <div class="col-xl-3 col-lg-3">


                        <button
                            type="button"
                            class="btn btn-light w-100"
                            id="resetCustomerGroupFilters"
                        >

                            <i class="bi bi-arrow-counterclockwise me-1"></i>

                            Reset

                        </button>


                    </div>


                </div>


            </div>


            {{-- GROUP TABLE --}}

            <div
                id="customerGroupTableContainer"
                class="customer-table-container"
            >


                @include(
                    'customers.partials.groups-table',
                    ['groups' => $customerGroups ?? collect()]
                )


            </div>


            <div
                id="customerGroupPagination"
                class="customer-pagination"
            ></div>


        </div>


        {{-- ======================================================
            LOYALTY SECTION
        ======================================================= --}}

        <div
            id="loyaltySection"
            class="customer-management-section"
        >


            <div class="customer-section-header">


                <div>

                    <h5>

                        Customer Loyalty

                    </h5>


                    <p>

                        Monitor customer loyalty points and engagement.

                    </p>

                </div>


            </div>


            {{-- LOYALTY KPI STRIP --}}

            <div class="row g-3 mb-4">


                <div class="col-xl-4 col-md-4">


                    <div class="loyalty-summary-card">


                        <div class="loyalty-summary-icon">

                            <i class="bi bi-stars"></i>

                        </div>


                        <div>

                            <span>

                                Total Points

                            </span>


                            <strong id="loyaltyTotalPoints">

                                {{ number_format($stats['loyalty_points'] ?? 0) }}

                            </strong>

                        </div>


                    </div>


                </div>


                <div class="col-xl-4 col-md-4">


                    <div class="loyalty-summary-card">


                        <div class="loyalty-summary-icon">

                            <i class="bi bi-person-check"></i>

                        </div>


                        <div>

                            <span>

                                Loyalty Customers

                            </span>


                            <strong id="loyaltyCustomerCount">

                                {{ $stats['loyalty_customers'] ?? 0 }}

                            </strong>

                        </div>


                    </div>


                </div>


                <div class="col-xl-4 col-md-4">


                    <div class="loyalty-summary-card">


                        <div class="loyalty-summary-icon">

                            <i class="bi bi-award"></i>

                        </div>


                        <div>

                            <span>

                                Average Points

                            </span>


                            <strong id="loyaltyAveragePoints">

                                {{ number_format($stats['average_loyalty'] ?? 0, 2) }}

                            </strong>

                        </div>


                    </div>


                </div>


            </div>


            {{-- LOYALTY SEARCH --}}

            <div class="customer-filter-bar">


                <div class="row g-3">


                    <div class="col-xl-8 col-lg-8 col-md-8">


                        <div class="customer-search-box">


                            <i class="bi bi-search"></i>


                            <input
                                type="text"
                                class="form-control"
                                id="loyaltySearch"
                                placeholder="Search customer..."
                            >


                        </div>


                    </div>


                    <div class="col-xl-4 col-lg-4 col-md-4">


                        <select
                            class="form-select"
                            id="loyaltySortFilter"
                        >

                            <option value="points_desc">

                                Highest Points

                            </option>


                            <option value="points_asc">

                                Lowest Points

                            </option>


                            <option value="name">

                                Customer Name

                            </option>


                            <option value="recent">

                                Recent Purchase

                            </option>


                        </select>


                    </div>


                </div>


            </div>


            {{-- LOYALTY TABLE --}}

            <div
                id="loyaltyTableContainer"
                class="customer-table-container"
            >


                @include(
                    'customers.partials.loyalty-table',
                    ['customers' => $loyaltyCustomers ?? collect()]
                )


            </div>


            <div
                id="loyaltyPagination"
                class="customer-pagination"
            ></div>


        </div>


    </div>


</div>





@include('customers.modals.customer-modal')

@include('customers.modals.group-modal')

@include('customers.modals.group-delete-modal')

@include('customers.modals.delete-modal')

@include('customers.modals.confirmation-modal')

@include('customers.modals.group-confirmation-modal')

@include('customers.partials.inspector')

@include('customers.partials.group-inspector')



<script src="{{ asset('assets/js/customer-management.js') }}"></script>
@endsection



    

