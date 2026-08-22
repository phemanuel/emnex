@extends('layouts.app')

@section('title', 'Units')

@section('content')

<div class="container-fluid">


    <!-- =====================================================
        PAGE HEADER
    ====================================================== -->

    <div class="page-header">


        <div>


            <h3>

                Units

            </h3>


            <p class="text-muted mb-0">

                Manage product measurement units.

            </p>


        </div>



        @permission('units.create')

        <button
            type="button"
            class="btn btn-primary"
            onclick="Units.openCreateModal()"
        >

            <i class="bi bi-plus-circle me-1"></i>

            New Unit

        </button>

        @endpermission

    </div>




    <!-- =====================================================
        STATISTICS
    ====================================================== -->

    <div class="row g-3 mb-4">


        <div class="col-md-4">


            <div class="summary-card">


                <span>

                    Total Units

                </span>


                <h3 id="totalUnits">

                    --

                </h3>


            </div>


        </div>




        <div class="col-md-4">


            <div class="summary-card">


                <span>

                    Active

                </span>


                <h3 id="activeUnits">

                    --

                </h3>


            </div>


        </div>




        <div class="col-md-4">


            <div class="summary-card">


                <span>

                    Inactive

                </span>


                <h3 id="inactiveUnits">

                    --

                </h3>


            </div>


        </div>


    </div>




    <!-- =====================================================
        TABLE CARD
    ====================================================== -->

    <div class="card shadow-sm border-0 units-table-card">


        <div class="card-header bg-white">


            <div class="row g-3 align-items-center">


                <div class="col-md-6">


                    <input

                        type="text"

                        id="search"

                        class="form-control"

                        placeholder="Search by code, name or short name..."

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

                            Disabled

                        </option>

                    </select>


                </div>




                <div class="col-md-3 text-end">


                    <button

                        type="button"

                        class="btn btn-outline-secondary"

                        onclick="Units.loadData()"

                    >

                        <i class="bi bi-arrow-clockwise"></i>

                        Refresh

                    </button>


                </div>


            </div>


        </div>





        <div
            class="card-body p-0"
            id="unitsTable"
        >


            <div class="text-center py-5">


                <div class="spinner-border text-primary"></div>


                <p class="mt-3 text-muted">

                    Loading units...

                </p>


            </div>


        </div>


    </div>


</div>



<!-- =====================================================
    MODALS
====================================================== -->

@include('units.modals.modal')

@include('units.modals.toggle-status')

@include('units.modals.delete')

@include('units.partials.inspector')

<script src="{{ asset('assets/js/unit.js') }}"></script>

@endsection


