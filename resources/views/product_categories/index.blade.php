@extends('layouts.app')


@section('title', 'Product Categories')


@section('content')


<div class="product-category-page">



    <!-- =====================================================
        PAGE HEADER
    ====================================================== -->

    <div class="page-header d-flex justify-content-between align-items-center mb-4">


        <div>

            <h1 class="page-title">
                Product Categories
            </h1>


            <p class="page-description">

                Manage product classification and organize your catalog.

            </p>


        </div>



        @permission('categories.create')

        <button 
            class="btn btn-primary"
            onclick="ProductCategories.openCreateModal()"
        >

            <i class="bi bi-plus-circle"></i>

            New Category

        </button>

        @endpermission


    </div>





    <!-- =====================================================
        STATISTICS
    ====================================================== -->


    <div class="row g-3 mb-4">


        <div class="col-md-4">

            <div class="category-stat-card">


                <div class="stat-icon">

                    <i class="bi bi-tags"></i>

                </div>


                <div>

                    <span>
                        Total Categories
                    </span>


                    <h3 id="totalCategories">
                        {{ $categories->total() }}
                    </h3>

                </div>


            </div>

        </div>




        <div class="col-md-4">

            <div class="category-stat-card">


                <div class="stat-icon">

                    <i class="bi bi-check-circle"></i>

                </div>


                <div>

                    <span>
                        Active Categories
                    </span>


                    <h3 id="activeCategories">
                        -
                    </h3>

                </div>


            </div>

        </div>





        <div class="col-md-4">


            <div class="category-stat-card">


                <div class="stat-icon">

                    <i class="bi bi-slash-circle"></i>

                </div>


                <div>

                    <span>
                        Inactive Categories
                    </span>


                    <h3 id="inactiveCategories">
                        -
                    </h3>

                </div>


            </div>


        </div>


    </div>





    <!-- =====================================================
        FILTERS
    ====================================================== -->


    <div class="category-filter-card mb-4">


        <div class="row g-3">


            <div class="col-md-8">


                <div class="input-group">


                    <span class="input-group-text">

                        <i class="bi bi-search"></i>

                    </span>


                    <input 
                        type="text"
                        class="form-control"
                        id="categorySearch"
                        placeholder="Search category..."
                    >


                </div>


            </div>





            <div class="col-md-4">


                <select 
                    class="form-select"
                    id="categoryStatusFilter"
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





    <!-- =====================================================
        TABLE
    ====================================================== -->


    <div 
        id="categoryTableWrapper"
        class="category-table-card"
    >

        @include(
            'product_categories.partials.table',
            [
                'categories'=>$categories
            ]
        )


    </div>

</div>


<!-- =====================================================
    INSPECTOR
====================================================== -->

@include('product_categories.modals.create')
@include('product_categories.partials.inspector')
@include('product_categories.modals.toggle-status')
@include('product_categories.modals.delete')





<script src="{{ asset('assets/js/product-category.js') }}"></script>
@endsection


