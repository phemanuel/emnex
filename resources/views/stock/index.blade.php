@extends('layouts.app')
@section('title', 'Stock Management')
@section('content')


<div class="stock-page">

    <!-- {{-- ================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================= --}} -->



    <div class="stock-header mb-4">


        <div>


            <h4 class="mb-1">

                Stock Management

            </h4>


            <p class="text-muted mb-0">

                Monitor inventory levels and make stock adjustments.

            </p>


        </div>


        <div>


            @permission('stock.update')

                <button
                    class="btn btn-primary"
                    id="openStockAdjustmentBtn">

                    <i class="bi bi-sliders me-2"></i>

                    Adjust Stock

                </button>

            @endpermission


        </div>


    </div>

<!-- 
    {{-- ================================================= --}}
    {{-- KPI CARDS --}}
    {{-- ================================================= --}} -->



    <div class="row g-4 mb-4">



        <div class="col-md-3">


            <div class="stock-kpi">


                <div class="stock-kpi-icon">


                    <i class="bi bi-box-seam"></i>


                </div>


                <div>


                    <small>

                        Total Products

                    </small>


                    <h3>

                        {{ $stats['products'] ?? 0 }}

                    </h3>


                </div>


            </div>


        </div>

        <div class="col-md-3">


            <div class="stock-kpi">


                <div class="stock-kpi-icon">


                    <i class="bi bi-check-circle"></i>


                </div>


                <div>


                    <small>

                        Available Stock

                    </small>


                    <h3>

                        {{ $stats['available'] ?? 0 }}

                    </h3>


                </div>


            </div>


        </div>

        <div class="col-md-3">


            <div class="stock-kpi">


                <div class="stock-kpi-icon">


                    <i class="bi bi-exclamation-triangle"></i>


                </div>


                <div>


                    <small>

                        Low Stock

                    </small>


                    <h3>

                        {{ $stats['low'] ?? 0 }}

                    </h3>


                </div>


            </div>


        </div>

        <div class="col-md-3">


            <div class="stock-kpi">


                <div class="stock-kpi-icon">


                    <i class="bi bi-x-circle"></i>


                </div>


                <div>


                    <small>

                        Out Of Stock

                    </small>


                    <h3>

                        {{ $stats['out'] ?? 0 }}

                    </h3>


                </div>


            </div>


        </div>



    </div>

    <!-- {{-- ================================================= --}}
    {{-- FILTER CARD --}}
    {{-- ================================================= --}}
 -->


    <div class="stock-card mb-4">


        <div class="row g-3">



            <div class="col-md-4">


                <div class="input-group">


                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>

                    <input

                        type="text"

                        class="form-control"

                        id="stockSearch"

                        placeholder="Search product, SKU or barcode"

                    >


                </div>


            </div>

            <div class="col-md-3">


                <select

                    class="form-select"

                    id="stockCategoryFilter"

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

            <div class="col-md-3">


                <select

                    class="form-select"

                    id="stockBranchFilter"

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

            <div class="col-md-2">


                <select

                    class="form-select"

                    id="stockStatusFilter"

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


    <!-- {{-- ================================================= --}}
    {{-- TABLE --}}
    {{-- ================================================= --}} -->



    <div class="stock-card">


        <div id="stockTableContainer">


            @include('stock.partials.table')


        </div>


    </div>

</div>

@include('stock.modals.modal')

@include('stock.modals.delete')

@include('stock.modals.toggle-status')

@include('stock.partials.inspector')


<script src="{{ asset('assets/js/stock.js') }}"></script>

@endsection



