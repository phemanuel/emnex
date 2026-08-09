@extends('layouts.app')

@section('title', 'Tax Rates')


@section('content')

<div class="container-fluid">

    <!-- ==========================================
        PAGE HEADER
    =========================================== -->

    <div class="page-header">

        <div>

            <h1 class="page-title">

                Tax Rates

            </h1>

            <p class="page-subtitle">

                Manage company tax rates.

            </p>

        </div>



        @permissions('tax_rates.create')

            <button
                type="button"
                class="btn btn-primary"
                onclick="TaxRates.openCreateModal()"
            >

                <i class="bi bi-plus-circle me-1"></i>

                New Tax Rate

            </button>

        @endpermissions 

    </div>



    <!-- ==========================================
        STATISTICS
    =========================================== -->

    <div class="row g-3 mb-4">

        <div class="col-lg-4">

            <div class="summary-card">

                <div class="summary-icon bg-primary-subtle">

                    <i class="bi bi-percent"></i>

                </div>

                <div>

                    <small>Total Tax Rates</small>

                    <h3 id="totalTaxRates">

                        {{ $statistics['total'] }}

                    </h3>

                </div>

            </div>

        </div>



        <div class="col-lg-4">

            <div class="summary-card">

                <div class="summary-icon bg-success-subtle">

                    <i class="bi bi-check-circle"></i>

                </div>

                <div>

                    <small>Active</small>

                    <h3 id="activeTaxRates">

                        {{ $statistics['active'] }}

                    </h3>

                </div>

            </div>

        </div>



        <div class="col-lg-4">

            <div class="summary-card">

                <div class="summary-icon bg-danger-subtle">

                    <i class="bi bi-x-circle"></i>

                </div>

                <div>

                    <small>Inactive</small>

                    <h3 id="inactiveTaxRates">

                        {{ $statistics['inactive'] }}

                    </h3>

                </div>

            </div>

        </div>

    </div>



    <!-- ==========================================
        TABLE CARD
    =========================================== -->

    <div class="card emnex-card">

        <div class="card-header">

            <div class="row g-3 align-items-center">

                <div class="col-md-6">

                    <input
                        type="text"
                        id="searchTaxRate"
                        class="form-control"
                        placeholder="Search tax rates..."
                    >

                </div>



                <div class="col-md-3">

                    <select
                        id="statusFilter"
                        class="form-select"
                    >

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
            id="taxRateTable"
        >

            @include(
                'tax-rates.partials.table'
            )

        </div>

    </div>

</div>



@include('tax-rates.modals.modal')

@include('tax-rates.partials.inspector')

@include('tax-rates.modals.toggle-status')

@include('tax-rates.modals.delete')

<script src="{{ asset('assets/js/tax-rate.js') }}"></script>

@endsection







