@extends('layouts.app')


@section('title', 'Settings')


@section('content')

<div class="container-fluid settings-page">


    {{-- Header --}}
    <div class="settings-header mb-4">


        <div>

            <h3>

                <i class="bi bi-gear-fill me-2"></i>

                System Settings

            </h3>


            <p>

                Configure company information, POS behaviour,
                receipts and system preferences.

            </p>

        </div>





        <div class="settings-status-card">


            <span class="status-dot"></span>


            <div>

                <small>
                    System Status
                </small>


                <strong>

                    {{ $settings->status ? 'Active' : 'Disabled' }}

                </strong>


            </div>


        </div>


    </div>






    <form id="settingsForm">


        @csrf

        @method('PUT')



        <div class="row g-4">





            {{-- Sidebar --}}
            <div class="col-xl-3 col-lg-4">


                <div class="settings-sidebar">


                    <div class="settings-sidebar-title">

                        Settings

                    </div>




                    <div class="nav flex-column"
                         role="tablist">





                        <button type="button"

                                class="settings-menu-item active"

                                data-bs-toggle="pill"

                                data-bs-target="#general"

                                role="tab">


                            <span class="icon">

                                <i class="bi bi-building"></i>

                            </span>



                            <div>

                                <strong>
                                    General
                                </strong>


                                <small>
                                    Company information
                                </small>

                            </div>


                        </button>









                        <button type="button"

                                class="settings-menu-item"

                                data-bs-toggle="pill"

                                data-bs-target="#pos"

                                role="tab">


                            <span class="icon">

                                <i class="bi bi-cart-check"></i>

                            </span>



                            <div>

                                <strong>
                                    POS Settings
                                </strong>


                                <small>
                                    Sales behaviour
                                </small>

                            </div>


                        </button>









                        <button type="button"

                                class="settings-menu-item"

                                data-bs-toggle="pill"

                                data-bs-target="#receipt"

                                role="tab">


                            <span class="icon">

                                <i class="bi bi-receipt"></i>

                            </span>



                            <div>

                                <strong>
                                    Receipt
                                </strong>


                                <small>
                                    Printing options
                                </small>

                            </div>


                        </button>









                        <button type="button"

                                class="settings-menu-item"

                                data-bs-toggle="pill"

                                data-bs-target="#inventory"

                                role="tab">


                            <span class="icon">

                                <i class="bi bi-box-seam"></i>

                            </span>



                            <div>

                                <strong>
                                    Inventory
                                </strong>


                                <small>
                                    Stock controls
                                </small>

                            </div>


                        </button>









                        <button type="button"

                                class="settings-menu-item"

                                data-bs-toggle="pill"

                                data-bs-target="#tax"

                                role="tab">


                            <span class="icon">

                                <i class="bi bi-percent"></i>

                            </span>



                            <div>

                                <strong>
                                    Tax
                                </strong>


                                <small>
                                    Tax configuration
                                </small>

                            </div>


                        </button>




                    </div>


                </div>


            </div>







            {{-- Content --}}
            <div class="col-xl-9 col-lg-8">



                <div class="tab-content">



                    @include(
                        'settings.tabs.general'
                    )



                    @include(
                        'settings.tabs.pos'
                    )



                    @include(
                        'settings.tabs.receipt'
                    )



                    @include(
                        'settings.tabs.inventory'
                    )



                    @include(
                        'settings.tabs.tax'
                    )



                </div>







                {{-- Save Area --}}
                <div class="settings-save-card mt-4">


                    <div>

                        <strong>
                            Save Changes
                        </strong>


                        <small>
                            Update your company configuration.
                        </small>


                    </div>




                    <button type="submit"

                            class="btn btn-primary">


                        <i class="bi bi-save me-2"></i>

                        Save Settings


                    </button>


                </div>



            </div>


        </div>


    </form>



</div>

<script>
    window.settingsUpdateUrl =
        "{{ route('settings.update') }}";
</script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
@endsection




