@extends('layouts.app')


@section('title', 'Products')


@section('content')

<div class="products-page">


    {{-- ======================================================
        PAGE HEADER
    ======================================================= --}}

    <div class="products-header">

        <div>

            <h2 class="products-title">

                Products

            </h2>


            <p class="products-subtitle">

                Manage your product catalog, pricing and inventory.

            </p>

        </div>


        <button type="button"
                class="btn btn-primary products-create-btn"
                onclick="Products.openCreateModal()">

            <i class="bi bi-plus-circle me-2"></i>

            New Product

        </button>


    </div>




    {{-- ======================================================
        KPI CARDS
    ======================================================= --}}

    <div class="row g-4 mb-4">


        <div class="col-xl-3 col-md-6">

            <div class="product-kpi-card">

                <div class="kpi-icon">

                    <i class="bi bi-box-seam"></i>

                </div>


                <div>

                    <span>
                        Total Products
                    </span>


                    <h3>
                        {{ $stats['total'] }}
                    </h3>

                </div>


            </div>

        </div>




        <div class="col-xl-3 col-md-6">

            <div class="product-kpi-card">

                <div class="kpi-icon">

                    <i class="bi bi-check-circle"></i>

                </div>


                <div>

                    <span>
                        Active
                    </span>


                    <h3>
                        {{ $stats['active'] }}
                    </h3>

                </div>


            </div>

        </div>




        <div class="col-xl-3 col-md-6">

            <div class="product-kpi-card">

                <div class="kpi-icon">

                    <i class="bi bi-exclamation-triangle"></i>

                </div>


                <div>

                    <span>
                        Low Stock
                    </span>


                    <h3>
                        {{ $stats['low_stock'] }}
                    </h3>

                </div>


            </div>

        </div>




        <div class="col-xl-3 col-md-6">

            <div class="product-kpi-card">

                <div class="kpi-icon">

                    <i class="bi bi-x-circle"></i>

                </div>


                <div>

                    <span>
                        Out Of Stock
                    </span>


                    <h3>
                        {{ $stats['out_of_stock'] }}
                    </h3>

                </div>


            </div>

        </div>



    </div>





    {{-- ======================================================
        PRODUCT DIRECTORY
    ======================================================= --}}

    <div class="product-card">


        <div class="product-card-header">


            <div class="product-search-box">


                <i class="bi bi-search"></i>


                <input type="text"
                       id="product-search"
                       class="form-control"
                       placeholder="Search products...">


            </div>




            <div class="product-filter">


                <select id="product-status-filter"
                        class="form-select">


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





        {{-- ==================================================
            TABLE
        =================================================== --}}


        <div id="products-table-container">


            @include(
                'products.partials.table',
                [
                    'products'=>$products
                ]
            )


        </div>



    </div>



</div>



{{-- ======================================================
    MODALS
======================================================= --}}


@include('products.modals.modal')
@include('products.modals.toggle-status')
@include('products.modals.delete')
@include('products.partials.inspector')

<script src="{{ asset('assets/js/product.js') }}"></script>

@endsection


