@extends('layouts.app')

@section('title', 'Shipping Setup')

@section('content')



<div class="container-fluid shipping-page">

    {{-- ============================================================
        PAGE HEADER
    ============================================================= --}}
    <div class="shipping-page-header">

        <div>

            <div class="shipping-eyebrow">
                STOREFRONT
            </div>

            <h2>
                Shipping Setup
            </h2>

            <p>
                Configure how customers choose delivery and manage the
                shipping locations available on your online store.
            </p>

        </div>


        <div class="shipping-status-pill {{ $settings->enabled ? 'active' : 'inactive' }}">

            <span class="shipping-status-dot"></span>

            {{ $settings->enabled
                ? 'Shipping enabled'
                : 'Shipping disabled'
            }}

        </div>

    </div>


    <div class="row g-4">

        {{-- ========================================================
            SHIPPING MODE
        ========================================================= --}}
        <div class="col-xl-5">

            <div class="shipping-card">

                <div class="shipping-card-header">

                    <div class="shipping-card-icon">
                        <i class="bi bi-truck"></i>
                    </div>

                    <div>

                        <h5>
                            Shipping Method
                        </h5>

                        <p>
                            Choose how customers provide their
                            delivery destination.
                        </p>

                    </div>

                </div>


                <div class="shipping-card-body">

                    @if(canAccess('shipping.manage'))

                        <form
                            method="POST"
                            action="{{ route('shipping.settings.update') }}"
                            id="shippingSettingsForm"
                        >

                            @csrf
                            @method('PUT')


                            <div class="shipping-enable-row">

                                <div>

                                    <strong>
                                        Enable shipping
                                    </strong>

                                    <span>
                                        Add delivery charges to Storefront orders.
                                    </span>

                                </div>


                                <label class="shipping-switch">

                                    <input
                                        type="checkbox"
                                        name="enabled"
                                        value="1"
                                        {{ $settings->enabled ? 'checked' : '' }}
                                    >

                                    <span class="shipping-switch-slider"></span>

                                </label>

                            </div>


                            <div class="shipping-divider"></div>


                            <label class="shipping-field-label">
                                Checkout delivery method
                            </label>


                            <div class="shipping-mode-options">

                                <label class="shipping-mode-card">

                                    <input
                                        type="radio"
                                        name="shipping_mode"
                                        value="location"
                                        {{ $settings->shipping_mode === 'location' ? 'checked' : '' }}
                                    >

                                    <span class="shipping-mode-ui">

                                        <span class="shipping-mode-icon">
                                            <i class="bi bi-geo-alt"></i>
                                        </span>

                                        <span>

                                            <strong>
                                                Shipping locations
                                            </strong>

                                            <small>
                                                Customer selects from delivery
                                                areas you have configured.
                                            </small>

                                        </span>

                                        <span class="shipping-radio"></span>

                                    </span>

                                </label>


                                <label class="shipping-mode-card">

                                    <input
                                        type="radio"
                                        name="shipping_mode"
                                        value="manual"
                                        {{ $settings->shipping_mode === 'manual' ? 'checked' : '' }}
                                    >

                                    <span class="shipping-mode-ui">

                                        <span class="shipping-mode-icon">
                                            <i class="bi bi-house-door"></i>
                                        </span>

                                        <span>

                                            <strong>
                                                Manual address
                                            </strong>

                                            <small>
                                                Customer enters their address and
                                                a flat delivery fee is charged.
                                            </small>

                                        </span>

                                        <span class="shipping-radio"></span>

                                    </span>

                                </label>

                            </div>


                            <div
                                class="shipping-manual-fee"
                                id="manualShippingFeeWrap"
                            >

                                <label
                                    for="manual_shipping_fee"
                                    class="shipping-field-label"
                                >
                                    Flat shipping fee
                                </label>


                                <div class="shipping-money-input">

                                    <span>
                                        {{ auth()->user()->company->currency_symbol ?: '₦' }}
                                    </span>

                                    <input
                                        type="number"
                                        name="manual_shipping_fee"
                                        id="manual_shipping_fee"
                                        class="form-control"
                                        step="0.01"
                                        min="0"
                                        value="{{ old(
                                            'manual_shipping_fee',
                                            $settings->manual_shipping_fee
                                        ) }}"
                                    >

                                </div>

                                <small class="shipping-help">
                                    This amount will be added to every order
                                    when Manual Address mode is active.
                                </small>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary shipping-save-btn"
                            >
                                <i class="bi bi-check2-circle me-2"></i>
                                Save Shipping Settings
                            </button>

                        </form>

                    @else

                        <div class="shipping-readonly">

                            <i class="bi bi-eye"></i>

                            You can view these settings, but you do not
                            have permission to modify them.

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- ========================================================
            LOCATIONS
        ========================================================= --}}
        <div class="col-xl-7">

            <div class="shipping-card">

                <div class="shipping-card-header shipping-location-header">

                    <div class="d-flex align-items-center gap-3">

                        <div class="shipping-card-icon">
                            <i class="bi bi-pin-map"></i>
                        </div>

                        <div>

                            <h5>
                                Shipping Locations
                            </h5>

                            <p>
                                Delivery areas and their respective fees.
                            </p>

                        </div>

                    </div>


                    @if(canAccess('shipping.manage'))

                        <button
                            type="button"
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#addShippingLocationModal"
                        >
                            <i class="bi bi-plus-lg me-1"></i>
                            Add Location
                        </button>

                    @endif

                </div>


                <div class="shipping-card-body p-0">

                    @if($locations->isEmpty())

                        <div class="shipping-empty">

                            <div class="shipping-empty-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <h5>
                                No shipping locations yet
                            </h5>

                            <p>
                                Add the areas you currently deliver to
                                and set a fee for each one.
                            </p>

                        </div>

                    @else

                        <div class="table-responsive">

                            <table class="table shipping-table mb-0">

                                <thead>

                                    <tr>

                                        <th>
                                            Location
                                        </th>

                                        <th>
                                            Shipping Fee
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th width="70"></th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach($locations as $location)

                                        <tr id="shipping-location-{{ $location->id }}">

                                            <td>

                                                <strong class="shipping-location-name">
                                                    {{ $location->name }}
                                                </strong>

                                                @if($location->description)

                                                    <span class="shipping-location-description">
                                                        {{ $location->description }}
                                                    </span>

                                                @endif

                                            </td>


                                            <td>

                                                <strong>
                                                    {{ auth()->user()->company->currency_symbol ?: '₦' }}
                                                    {{ number_format(
                                                        (float) $location->shipping_fee,
                                                        2
                                                    ) }}
                                                </strong>

                                            </td>


                                            <td>

                                                <span
                                                    class="shipping-location-status
                                                    {{ $location->status ? 'active' : 'inactive' }}"
                                                >
                                                    {{ $location->status
                                                        ? 'Active'
                                                        : 'Disabled'
                                                    }}
                                                </span>

                                            </td>


                                            <td class="text-end">

                                                @if(canAccess('shipping.manage'))

                                                    <div class="dropdown">

                                                        <button
                                                            class="btn btn-sm btn-light"
                                                            type="button"
                                                            data-bs-toggle="dropdown"
                                                        >
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>


                                                        <ul class="dropdown-menu dropdown-menu-end">

                                                            <li>

                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editShippingLocationModal{{ $location->id }}"
                                                                >
                                                                    <i class="bi bi-pencil me-2"></i>
                                                                    Edit
                                                                </button>

                                                            </li>


                                                            <li>

                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item shipping-toggle-location"
                                                                    data-url="{{ route(
                                                                        'shipping.locations.toggle',
                                                                        $location
                                                                    ) }}"
                                                                >
                                                                    <i class="bi bi-power me-2"></i>

                                                                    {{ $location->status
                                                                        ? 'Disable'
                                                                        : 'Enable'
                                                                    }}

                                                                </button>

                                                            </li>


                                                            <li>
                                                                <hr class="dropdown-divider">
                                                            </li>


                                                            <li>

                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item text-danger shipping-delete-location"
                                                                    data-url="{{ route(
                                                                        'shipping.locations.destroy',
                                                                        $location
                                                                    ) }}"
                                                                    data-name="{{ $location->name }}"
                                                                >
                                                                    <i class="bi bi-trash me-2"></i>
                                                                    Delete
                                                                </button>

                                                            </li>

                                                        </ul>

                                                    </div>

                                                @endif

                                            </td>

                                        </tr>


                                        {{-- Edit Modal --}}
                                        @if(canAccess('shipping.manage'))

                                            <div
                                                class="modal fade"
                                                id="editShippingLocationModal{{ $location->id }}"
                                                tabindex="-1"
                                                aria-labelledby="editShippingLocationModalLabel{{ $location->id }}"
                                                aria-hidden="true"
                                            >

                                                <div class="modal-dialog modal-dialog-centered modal-lg">

                                                    <div class="modal-content shipping-modal">

                                                        <form
                                                            method="POST"
                                                            action="{{ route(
                                                                'shipping.locations.update',
                                                                $location
                                                            ) }}"
                                                             class="shipping-location-form"
                                                        >

                                                            @csrf
                                                            @method('PUT')


                                                            {{-- HEADER --}}
                                                            <div class="modal-header border-bottom">

                                                                <div>

                                                                    <h5
                                                                        class="modal-title"
                                                                        id="editShippingLocationModalLabel{{ $location->id }}"
                                                                    >
                                                                        Edit Shipping Location
                                                                    </h5>

                                                                    <small class="text-muted">
                                                                        Update this delivery area and fee.
                                                                    </small>

                                                                </div>


                                                                <button
                                                                    type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"
                                                                ></button>

                                                            </div>


                                                            {{-- BODY --}}
                                                            <div class="modal-body shipping-modal-scroll p-4">


                                                                {{-- LOCATION NAME --}}
                                                                <div class="mb-4">

                                                                    <label
                                                                        for="shipping_location_name_{{ $location->id }}"
                                                                        class="form-label fw-semibold"
                                                                    >
                                                                        Location
                                                                        <span class="text-danger">*</span>
                                                                    </label>


                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        id="shipping_location_name_{{ $location->id }}"
                                                                        name="name"
                                                                        maxlength="150"
                                                                        required
                                                                        placeholder="e.g. Lagos Mainland"
                                                                        value="{{ old(
                                                                            'name',
                                                                            $location->name
                                                                        ) }}"
                                                                    >


                                                                    <div class="form-text">
                                                                        Enter the delivery area customers will see at checkout.
                                                                    </div>

                                                                </div>


                                                                {{-- DESCRIPTION --}}
                                                                <div class="mb-4">

                                                                    <label
                                                                        for="shipping_location_description_{{ $location->id }}"
                                                                        class="form-label fw-semibold"
                                                                    >
                                                                        Description
                                                                    </label>


                                                                    <input
                                                                        type="text"
                                                                        class="form-control"
                                                                        id="shipping_location_description_{{ $location->id }}"
                                                                        name="description"
                                                                        maxlength="255"
                                                                        placeholder="e.g. Yaba, Surulere, Ikeja and nearby areas"
                                                                        value="{{ old(
                                                                            'description',
                                                                            $location->description
                                                                        ) }}"
                                                                    >


                                                                    <div class="form-text">
                                                                        Optional. You can use this to clarify the areas covered.
                                                                    </div>

                                                                </div>


                                                                {{-- SHIPPING FEE --}}
                                                                <div class="mb-4">

                                                                    <label
                                                                        for="shipping_location_fee_{{ $location->id }}"
                                                                        class="form-label fw-semibold"
                                                                    >
                                                                        Shipping Fee
                                                                        <span class="text-danger">*</span>
                                                                    </label>


                                                                    <div class="input-group">

                                                                        <span class="input-group-text">
                                                                            {{ auth()->user()->company->currency_symbol ?: '₦' }}
                                                                        </span>


                                                                        <input
                                                                            type="number"
                                                                            class="form-control"
                                                                            id="shipping_location_fee_{{ $location->id }}"
                                                                            name="shipping_fee"
                                                                            min="0"
                                                                            step="0.01"
                                                                            required
                                                                            placeholder="0.00"
                                                                            value="{{ old(
                                                                                'shipping_fee',
                                                                                $location->shipping_fee
                                                                            ) }}"
                                                                        >

                                                                    </div>


                                                                    <div class="form-text">
                                                                        This is the delivery fee charged when a customer selects this location.
                                                                    </div>

                                                                </div>


                                                                {{-- DISPLAY ORDER --}}
                                                                <div>

                                                                    <label
                                                                        for="shipping_location_sort_order_{{ $location->id }}"
                                                                        class="form-label fw-semibold"
                                                                    >
                                                                        Display Order
                                                                    </label>


                                                                    <input
                                                                        type="number"
                                                                        class="form-control"
                                                                        id="shipping_location_sort_order_{{ $location->id }}"
                                                                        name="sort_order"
                                                                        min="0"
                                                                        step="1"
                                                                        value="{{ old(
                                                                            'sort_order',
                                                                            $location->sort_order
                                                                        ) }}"
                                                                    >


                                                                    <div class="form-text">
                                                                        Lower numbers appear first in the checkout location list.
                                                                    </div>

                                                                </div>

                                                            </div>


                                                            {{-- FOOTER --}}
                                                            <div class="modal-footer border-top">

                                                                <button
                                                                    type="button"
                                                                    class="btn btn-light"
                                                                    data-bs-dismiss="modal"
                                                                >
                                                                    Cancel
                                                                </button>


                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-primary shipping-submit-btn"
                                                                    data-loading-text="Saving..."
                                                                >
                                                                    <span class="shipping-btn-default">
                                                                        <i class="bi bi-check-circle me-2"></i>
                                                                        Save Changes
                                                                    </span>

                                                                    <span
                                                                        class="shipping-btn-loading d-none"
                                                                    >
                                                                        <span
                                                                            class="spinner-border spinner-border-sm me-2"
                                                                            aria-hidden="true"
                                                                        ></span>

                                                                        Saving...
                                                                    </span>
                                                                </button>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        @endif

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
    ADD LOCATION MODAL
============================================================= --}}

@if(canAccess('shipping.manage'))

<div
    class="modal fade"
    id="addShippingLocationModal"
    tabindex="-1"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content shipping-modal">

            <form
                method="POST"
                action="{{ route('shipping.locations.store') }}"
                class="shipping-location-form"
            >

                @csrf


                <div class="modal-header border-bottom">

                    <div>

                        <h5 class="modal-title">
                            Add Shipping Location
                        </h5>

                        <small class="text-muted">
                            Create a delivery area and assign its fee.
                        </small>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>


                {{-- BODY --}}
                <div class="modal-body shipping-modal-scroll p-4">


                    {{-- LOCATION NAME --}}
                    <div class="mb-4">

                        <label
                            for="shipping_location_name"
                            class="form-label fw-semibold"
                        >
                            Location
                            <span class="text-danger">*</span>
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="shipping_location_name"
                            name="name"
                            maxlength="150"
                            required
                            placeholder="e.g. Lagos Mainland"
                            value="{{ old('name') }}"
                        >


                        <div class="form-text">
                            Enter the delivery area customers will see at checkout.
                        </div>

                    </div>


                    {{-- DESCRIPTION --}}
                    <div class="mb-4">

                        <label
                            for="shipping_location_description"
                            class="form-label fw-semibold"
                        >
                            Description
                        </label>


                        <input
                            type="text"
                            class="form-control"
                            id="shipping_location_description"
                            name="description"
                            maxlength="255"
                            placeholder="e.g. Yaba, Surulere, Ikeja and nearby areas"
                            value="{{ old('description') }}"
                        >


                        <div class="form-text">
                            Optional. You can use this to clarify the areas covered.
                        </div>

                    </div>


                    {{-- SHIPPING FEE --}}
                    <div class="mb-4">

                        <label
                            for="shipping_location_fee"
                            class="form-label fw-semibold"
                        >
                            Shipping Fee
                            <span class="text-danger">*</span>
                        </label>


                        <div class="input-group">

                            <span class="input-group-text">
                                {{ auth()->user()->company->currency_symbol ?: '₦' }}
                            </span>


                            <input
                                type="number"
                                class="form-control"
                                id="shipping_location_fee"
                                name="shipping_fee"
                                min="0"
                                step="0.01"
                                required
                                placeholder="0.00"
                                value="{{ old('shipping_fee') }}"
                            >

                        </div>


                        <div class="form-text">
                            This amount will be added to the customer's order when they select this location.
                        </div>

                    </div>


                    {{-- DISPLAY ORDER --}}
                    <div>

                        <label
                            for="shipping_location_sort_order"
                            class="form-label fw-semibold"
                        >
                            Display Order
                        </label>


                        <input
                            type="number"
                            class="form-control"
                            id="shipping_location_sort_order"
                            name="sort_order"
                            min="0"
                            step="1"
                            value="{{ old('sort_order', 0) }}"
                        >


                        <div class="form-text">
                            Lower numbers appear first in the checkout location list.
                        </div>

                    </div>

                </div>


                <div class="modal-footer border-top">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary shipping-submit-btn"
                        data-loading-text="Adding..."
                    >
                        <span class="shipping-btn-default">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add Location
                        </span>

                        <span
                            class="shipping-btn-loading d-none"
                        >
                            <span
                                class="spinner-border spinner-border-sm me-2"
                                aria-hidden="true"
                            ></span>

                            Adding...
                        </span>
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endif



<script>

document.addEventListener(
    'DOMContentLoaded',
    () => {

    document
        .querySelectorAll(
            '.shipping-location-form'
        )
        .forEach(form => {

            form.addEventListener(
                'submit',
                event => {

                    /*
                    |--------------------------------------------------------------------------
                    | Allow Browser Validation First
                    |--------------------------------------------------------------------------
                    */

                    if (!form.checkValidity()) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Get The Actual Button Used
                    |--------------------------------------------------------------------------
                    */

                    const button =
                        event.submitter ||
                        form.querySelector(
                            '.shipping-submit-btn'
                        );


                    if (!button) {
                        return;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Prevent Double Submit
                    |--------------------------------------------------------------------------
                    */

                    button.disabled =
                        true;


                    /*
                    |--------------------------------------------------------------------------
                    | Switch Button Content
                    |--------------------------------------------------------------------------
                    */

                    const defaultContent =
                        button.querySelector(
                            '.shipping-btn-default'
                        );

                    const loadingContent =
                        button.querySelector(
                            '.shipping-btn-loading'
                        );


                    if (defaultContent) {

                        defaultContent.classList.add(
                            'd-none'
                        );

                    }


                    if (loadingContent) {

                        loadingContent.classList.remove(
                            'd-none'
                        );

                    }

                }
            );

        });

        const modes =
            document.querySelectorAll(
                'input[name="shipping_mode"]'
            );

        const manualFeeWrap =
            document.getElementById(
                'manualShippingFeeWrap'
            );


        function updateShippingMode()
        {
            const selected =
                document.querySelector(
                    'input[name="shipping_mode"]:checked'
                );

            if (!manualFeeWrap || !selected) {
                return;
            }


            manualFeeWrap.style.display =
                selected.value === 'manual'
                    ? 'block'
                    : 'none';
        }


        modes.forEach(
            radio => {

                radio.addEventListener(
                    'change',
                    updateShippingMode
                );

            }
        );


        updateShippingMode();


        document
            .querySelectorAll(
                '.shipping-toggle-location'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        async () => {

                            try {

                                const response =
                                    await fetch(
                                        button.dataset.url,
                                        {
                                            method:
                                                'PATCH',

                                            headers: {
                                                'X-CSRF-TOKEN':
                                                    document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
                                                        )
                                                        .content,

                                                'Accept':
                                                    'application/json',
                                            },
                                        }
                                    );


                                const data =
                                    await response.json();


                                if (!response.ok) {
                                    throw new Error(
                                        data.message ||
                                        'Unable to update location.'
                                    );
                                }


                                showToast(
                                    data.message,
                                    'success'
                                );


                                window.location.reload();

                            }
                            catch (error) {

                                showToast(
                                    error.message,
                                    'danger'
                                );

                            }

                        }
                    );

                }
            );


        document
            .querySelectorAll(
                '.shipping-delete-location'
            )
            .forEach(
                button => {

                    button.addEventListener(
                        'click',
                        async () => {

                            const confirmed =
                                window.confirm(
                                    `Delete "${button.dataset.name}"?`
                                );


                            if (!confirmed) {
                                return;
                            }


                            try {

                                const response =
                                    await fetch(
                                        button.dataset.url,
                                        {
                                            method:
                                                'DELETE',

                                            headers: {
                                                'X-CSRF-TOKEN':
                                                    document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
                                                        )
                                                        .content,

                                                'Accept':
                                                    'application/json',
                                            },
                                        }
                                    );


                                const data =
                                    await response.json();


                                if (!response.ok) {
                                    throw new Error(
                                        data.message ||
                                        'Unable to delete location.'
                                    );
                                }


                                showToast(
                                    data.message,
                                    'success'
                                );


                                window.location.reload();

                            }
                            catch (error) {

                                showToast(
                                    error.message,
                                    'danger'
                                );

                            }

                        }
                    );

                }
            );

    }
);

</script>



@endsection