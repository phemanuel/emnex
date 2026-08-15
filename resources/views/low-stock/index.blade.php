@extends('layouts.app')

@section('title', 'Low Stock')

@section('content')


<div class="low-stock-page">


    {{-- ==========================================================
    PAGE HEADER
    =========================================================== --}}


    <div class="low-stock-header mb-4">


        <div>


            <div class="d-flex align-items-center gap-2 mb-1">


                <span class="low-stock-header-icon">

                    <i class="bi bi-exclamation-triangle"></i>

                </span>


                <h4 class="mb-0">

                    Low Stock

                </h4>


            </div>


            <p class="text-muted mb-0">

                Monitor products that are running low and need replenishment.

            </p>


        </div>


    </div>



    {{-- ==========================================================
    KPI CARDS
    =========================================================== --}}


    <div class="row g-4 mb-4">


        {{-- TOTAL LOW STOCK --}}


        <div class="col-xl-3 col-md-6">


            <div class="low-stock-kpi">


                <div class="low-stock-kpi-icon">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>


                <div class="low-stock-kpi-content">


                    <span>

                        Low Stock Items

                    </span>


                    <h3 id="lowStockTotal">

                        {{ $stats['total'] ?? 0 }}

                    </h3>


                    <small>

                        Require attention

                    </small>


                </div>


            </div>


        </div>



        {{-- OUT OF STOCK --}}


        <div class="col-xl-3 col-md-6">


            <div class="low-stock-kpi">


                <div class="low-stock-kpi-icon">

                    <i class="bi bi-box-seam"></i>

                </div>


                <div class="low-stock-kpi-content">


                    <span>

                        Out Of Stock

                    </span>


                    <h3 id="lowStockOut">

                        {{ $stats['out'] ?? 0 }}

                    </h3>


                    <small>

                        No stock available

                    </small>


                </div>


            </div>


        </div>



        {{-- LOW STOCK --}}


        <div class="col-xl-3 col-md-6">


            <div class="low-stock-kpi">


                <div class="low-stock-kpi-icon">

                    <i class="bi bi-graph-down-arrow"></i>

                </div>


                <div class="low-stock-kpi-content">


                    <span>

                        Low Stock

                    </span>


                    <h3 id="lowStockLow">

                        {{ $stats['low'] ?? 0 }}

                    </h3>


                    <small>

                        Below reorder level

                    </small>


                </div>


            </div>


        </div>



        {{-- REQUIRED QUANTITY --}}


        <div class="col-xl-3 col-md-6">


            <div class="low-stock-kpi">


                <div class="low-stock-kpi-icon">

                    <i class="bi bi-boxes"></i>

                </div>


                <div class="low-stock-kpi-content">


                    <span>

                        Replenishment Needed

                    </span>


                    <h3 id="lowStockRequired">

                        {{ number_format(
                            $stats['required'] ?? 0,
                            2
                        ) }}

                    </h3>


                    <small>

                        Estimated quantity

                    </small>


                </div>


            </div>


        </div>


    </div>



    {{-- ==========================================================
    FILTER CARD
    =========================================================== --}}


    <div class="low-stock-card mb-4">


        <div class="row g-3 align-items-center">


            {{-- SEARCH --}}


            <div class="col-xl-4 col-lg-4 col-md-6">


                <div class="input-group">


                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>


                    <input
                        type="text"
                        class="form-control"
                        id="lowStockSearch"
                        placeholder="Search product, SKU or barcode"
                    >


                </div>


            </div>



            {{-- CATEGORY --}}


            <div class="col-xl-3 col-lg-3 col-md-6">


                <select
                    class="form-select"
                    id="lowStockCategoryFilter"
                >


                    <option value="">

                        All Categories

                    </option>


                    @foreach($categories as $category)


                        <option value="{{ $category->id }}">

                            {{ $category->name }}

                        </option>


                    @endforeach


                </select>


            </div>



            {{-- BRANCH --}}


            <div class="col-xl-3 col-lg-3 col-md-6">


                <select
                    class="form-select"
                    id="lowStockBranchFilter"
                >


                    <option value="">

                        All Branches

                    </option>


                    @foreach($branches as $branch)


                        <option value="{{ $branch->id }}">

                            {{ $branch->name }}

                        </option>


                    @endforeach


                </select>


            </div>



            {{-- STATUS --}}


            <div class="col-xl-2 col-lg-2 col-md-6">


                <select
                    class="form-select"
                    id="lowStockStatusFilter"
                >


                    <option value="">

                        All Status

                    </option>


                    <option value="low">

                        Low Stock

                    </option>


                    <option value="out">

                        Out Of Stock

                    </option>


                </select>


            </div>


        </div>


    </div>



    {{-- ==========================================================
    STOCK TABLE
    =========================================================== --}}


    <div class="low-stock-card">


        <div class="low-stock-table-header">


            <div>


                <h6 class="mb-1">

                    Products Requiring Attention

                </h6>


                <p class="text-muted mb-0">

                    Products currently below their configured stock level.

                </p>


            </div>


            <div id="lowStockResultCount"
                 class="text-muted">

                {{ $stocks->total() ?? 0 }} items

            </div>


        </div>



        <div id="lowStockTableContainer">


            @include(
                'low-stock.partials.table'
            )


        </div>


    </div>


</div>



{{-- ==========================================================
INSPECTOR
=========================================================== --}}


@include(
    'low-stock.partials.inspector'
)



{{-- ==========================================================
LOW STOCK JAVASCRIPT
=========================================================== --}}


<script src="{{ asset('assets/js/low-stock.js') }}"></script>


@endsection