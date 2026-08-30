@extends('layouts.app')

@section('title', 'Sales Returns & Refunds')

@section('content')

<div class="container-fluid">

    {{-- ==========================================================
        Page Header
    =========================================================== --}}

    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h4 class="mb-1">
                Sales Returns & Refunds
            </h4>

            <p class="text-muted mb-0">
                Manage sales returns and process customer refunds.
            </p>

        </div>


        <div>

            @permission('returns.create')

                <button
                    type="button"
                    class="btn btn-primary"
                    id="openRefundOrdersButton"
                >

                    <i class="bi bi-arrow-counterclockwise me-2"></i>

                    Return / Refund

                </button>

            @endpermission

        </div>

    </div>


    {{-- ==========================================================
        KPI Cards
    =========================================================== --}}

    <div class="row g-3 mb-4">

        {{-- Total Returns --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Total Returns
                            </div>

                            <h4
                                class="mb-0"
                                id="totalReturns"
                            >
                                0
                            </h4>

                        </div>


                        <div class="emnex-kpi-icon">

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Refunded --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Refunded
                            </div>

                            <h4
                                class="mb-0"
                                id="completedReturns"
                            >
                                0
                            </h4>

                        </div>


                        <div class="emnex-kpi-icon">

                            <i class="bi bi-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Pending --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Pending
                            </div>

                            <h4
                                class="mb-0"
                                id="pendingReturns"
                            >
                                0
                            </h4>

                        </div>


                        <div class="emnex-kpi-icon">

                            <i class="bi bi-clock-history"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Total Refunded Amount --}}

        <div class="col-xl-3 col-md-6">

            <div class="card emnex-card h-100">

                <div class="card-body">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="text-muted small mb-1">
                                Total Refunded
                            </div>

                         
                            <h4
                                class="mb-0"
                                id="totalRefundedAmount"
                            >
                                {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                            </h4>



                        </div>


                        <div class="emnex-kpi-icon">

                            <i class="bi bi-cash-stack"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        Main Table Card
    =========================================================== --}}

    <div class="card emnex-card">

        <div class="card-body p-0">

            @include(
                'sales.returns.partials.table'
            )

        </div>

    </div>

</div>


{{-- ==========================================================
    Inspector
=========================================================== --}}

@include(
    'sales.returns.partials.inspector'
)


{{-- ==========================================================
    Modals
=========================================================== --}}


@include(
    'sales.returns.modals.refund-orders'
)

@include(
    'sales.returns.modals.refund-items'
)

@include(
    'sales.returns.modals.order-payments'
)

@include(
    'sales.returns.modals.confirmation'
)

    <script src="{{ asset('assets/js/returns.js') }}"></script>

@endsection









