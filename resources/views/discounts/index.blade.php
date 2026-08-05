@extends('layouts.app')

@section('title', 'Discounts')


@section('content')

<div class="discount-page">

    <!-- ==========================================
        Page Header
    =========================================== -->

    <div class="page-header">

        <div>

            <h1 class="page-title">
                Discount Management
            </h1>

            <p class="page-subtitle mb-0">
                Manage promotional discounts, fixed discounts and automatic pricing rules.
            </p>

        </div>

        <button
            class="btn btn-primary"
            type="button"
            id="btnCreateDiscount">

            <i class="bi bi-plus-circle me-2"></i>

            New Discount

        </button>

    </div>

    <!-- ==========================================
        KPI Cards
    =========================================== -->

    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card">

                <div class="kpi-icon primary">

                    <i class="bi bi-tags"></i>

                </div>

                <div class="kpi-content">

                    <span class="kpi-label">
                        Total Discounts
                    </span>

                    <h3 id="totalDiscounts">
                        {{ $total ?? 0 }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card">

                <div class="kpi-icon success">

                    <i class="bi bi-check-circle"></i>

                </div>

                <div class="kpi-content">

                    <span class="kpi-label">
                        Active
                    </span>

                    <h3 id="activeDiscounts">
                        {{ $active ?? 0 }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card">

                <div class="kpi-icon danger">

                    <i class="bi bi-x-circle"></i>

                </div>

                <div class="kpi-content">

                    <span class="kpi-label">
                        Inactive
                    </span>

                    <h3 id="inactiveDiscounts">
                        {{ $inactive ?? 0 }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="kpi-card">

                <div class="kpi-icon warning">

                    <i class="bi bi-calendar-check"></i>

                </div>

                <div class="kpi-content">

                    <span class="kpi-label">
                        Current
                    </span>

                    <h3 id="currentDiscounts">
                        {{ $current ?? 0 }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- ==========================================
        Table Card
    =========================================== -->

    <div class="card module-card">

        <div class="card-header">

            <div class="row g-3 align-items-center">

                <div class="col-lg-5">

                    <div class="search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            class="form-control"
                            id="searchDiscount"
                            placeholder="Search discounts...">

                    </div>

                </div>

                <div class="col-lg-3">

                    <select
                        class="form-select"
                        id="statusFilter">

                        <option value="">
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

            </div>

        </div>

        <div
            class="card-body p-0"
            id="discountTableContainer">

            {{-- AJAX Table --}}

                    @include('discounts.partials.table', [
                'discounts' => $discounts
            ])

        </div>

    </div>

</div>

@include('discounts.modals.modals')

@include('discounts.partials.inspector')

@include('discounts.modals.toggle-status')

@include('discounts.modals.delete')

<script src="{{ asset('assets/js/discount.js') }}"></script>

@endsection

