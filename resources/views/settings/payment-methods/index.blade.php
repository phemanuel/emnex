@extends('layouts.app')


@section('title', 'Payment Methods')


@section('content')

<div class="container-fluid">


    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="mb-1">

                <i class="bi bi-credit-card me-2"></i>

                Payment Methods

            </h4>


            <p class="text-muted mb-0">

                Configure payment options available for your POS.

            </p>

        </div>



        @permission('payment_methods.create')

        <button
            class="btn btn-primary"
            onclick="PaymentMethods.openCreateModal()">

            <i class="bi bi-plus-circle me-2"></i>

            New Payment Method

        </button>

        @endpermission


    </div>





    {{-- Payment Methods Table Card --}}
    <div class="card border-0 shadow-sm">


        <div class="card-body">


            <div class="table-responsive">


                <table class="table align-middle payment-methods-table">


                    <thead>

                        <tr>

                            <th width="50">
                                #
                            </th>

                            <th>
                                Payment Method
                            </th>

                            <th>
                                Code
                            </th>

                            <th>
                                Features
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="100">
                                Action
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                    @forelse($paymentMethods as $method)


                        <tr>


                            <td>

                                {{ $loop->iteration }}

                            </td>



                            {{-- Payment Method --}}
                            <td>


                                <div class="d-flex align-items-center">


                                    <div
                                        class="payment-icon bg-{{ $method->color }} bg-opacity-10 text-{{ $method->color }}">

                                        <i class="bi {{ $method->icon }}"></i>

                                    </div>



                                    <div class="ms-3">


                                        <div class="fw-semibold">

                                            {{ $method->name }}

                                        </div>


                                        <small class="text-muted">

                                            Payment option

                                        </small>


                                    </div>


                                </div>


                            </td>





                            {{-- Code --}}
                            <td>

                                <span class="badge bg-light text-dark">

                                    {{ $method->code }}

                                </span>

                            </td>





                            {{-- Features --}}
                            <td>


                                <div class="d-flex gap-1 flex-wrap">


                                    @if($method->is_cash)

                                        <span class="badge bg-success payment-feature-badge">

                                            Cash

                                        </span>

                                    @endif



                                    @if($method->requires_reference)

                                        <span class="badge bg-info payment-feature-badge">

                                            Reference

                                        </span>

                                    @endif



                                    @if($method->allow_change)

                                        <span class="badge bg-warning text-dark payment-feature-badge">

                                            Change

                                        </span>

                                    @endif


                                </div>


                            </td>





                            {{-- Status --}}
                            <td>


                                @if($method->status)

                                    <span class="badge bg-success payment-status">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-secondary payment-status">

                                        Disabled

                                    </span>

                                @endif


                            </td>





                            {{-- Actions --}}
                            <td>


                                <div class="dropdown">


                                    <button
                                        class="btn btn-sm btn-light"
                                        data-bs-toggle="dropdown">


                                        <i class="bi bi-three-dots"></i>


                                    </button>




                                    <ul class="dropdown-menu dropdown-menu-end">

                                        @permission('payment_methods.update')

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item"
                                                onclick="PaymentMethods.openEditModal({{ $method->id }})">

                                                <i class="bi bi-pencil-square me-2"></i>

                                                Edit

                                            </button>

                                        </li>

                                        @endpermission


                                        @permission('payment_methods.toggle_status')

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item"
                                                onclick="PaymentMethods.openToggleModal(
                                                    {{ $method->id }},
                                                    {{ $method->status ? 'true' : 'false' }}
                                                )">

                                                <i class="bi {{ $method->status ? 'bi-toggle-on text-success' : 'bi-toggle-off text-secondary' }} me-2"></i>

                                                {{ $method->status ? 'Disable' : 'Enable' }}

                                            </button>

                                        </li>

                                        @endpermission


                                        @permission('payment_methods.delete')

                                        <li>

                                            <hr class="dropdown-divider">

                                        </li>

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                onclick="PaymentMethods.delete({{ $method->id }})">

                                                <i class="bi bi-trash me-2"></i>

                                                Delete

                                            </button>

                                        </li>

                                        @endpermission

                                    </ul>

                                </div>


                            </td>



                        </tr>


                    @empty


                        <tr>

                            <td colspan="6">


                                <div class="payment-empty-state">


                                    <i class="bi bi-credit-card"></i>


                                    <h6 class="mt-3">

                                        No Payment Methods

                                    </h6>


                                    <p class="text-muted">

                                        Create payment methods to use in your POS.

                                    </p>


                                </div>


                            </td>

                        </tr>


                    @endforelse


                    </tbody>


                </table>


            </div>


        </div>


    </div>


</div>





@include('settings.payment-methods.modals.create')

@include('settings.payment-methods.modals.edit')

@include('settings.payment-methods.modals.delete')

@include('settings.payment-methods.modals.toggle-status')


<script>

window.paymentMethodRoutes = {

    store:
        "{{ route('payment-methods.store') }}",


    edit:
        "{{ route('payment-methods.edit', ':id') }}",


    update:
        "{{ route('payment-methods.update', ':id') }}",


    toggleStatus:
        "{{ route('payment-methods.toggle-status', ':id') }}",


    destroy:
        "{{ route('payment-methods.destroy', ':id') }}"

};


</script>


<script src="{{ asset('assets/js/payment-method.js') }}"></script>
@endsection



