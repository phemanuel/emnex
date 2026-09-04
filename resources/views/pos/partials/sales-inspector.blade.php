{{-- 
|--------------------------------------------------------------------------
| Sale Details Inspector
|--------------------------------------------------------------------------
--}}

<div
    class="offcanvas offcanvas-end pos-sale-inspector"
    tabindex="-1"
    id="posSaleDetailsInspector"
    aria-labelledby="posSaleDetailsInspectorLabel"
>

    {{-- 
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    --}}

    <div class="offcanvas-header">

        <div class="pos-inspector-heading">

            <div class="pos-inspector-icon">

                <i class="bi bi-receipt"></i>

            </div>

            <div>

                <h5
                    class="offcanvas-title"
                    id="posSaleDetailsInspectorLabel"
                >
                    Sale Details
                </h5>

                <p
                    class="text-muted small mb-0"
                    id="pos-sale-inspector-order-no"
                >
                    —
                </p>

            </div>

        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Body
    |--------------------------------------------------------------------------
    --}}

    <div class="offcanvas-body">


        {{-- 
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        --}}

        <div
            id="pos-sale-inspector-loading"
            class="text-center py-5 d-none"
        >

            <span
                class="spinner-border spinner-border-sm me-1"
            ></span>

            Loading sale details...

        </div>


        {{-- 
        |--------------------------------------------------------------------------
        | Content
        |--------------------------------------------------------------------------
        --}}

        <div id="pos-sale-inspector-content">


            {{-- 
            |--------------------------------------------------------------------------
            | Sale Summary
            |--------------------------------------------------------------------------
            --}}

            <div class="pos-sale-inspector-section">

                <div class="pos-sale-inspector-section-header">

                    <div>

                        <span class="pos-sale-inspector-section-label">
                            Sale Summary
                        </span>

                        <strong
                            id="pos-sale-inspector-order-number"
                            class="pos-sale-inspector-section-value"
                        >
                            —
                        </strong>

                    </div>

                    <span
                        id="pos-sale-inspector-status"
                        class="badge bg-success"
                    >
                        Completed
                    </span>

                </div>


                <div class="row g-3 mt-1">

                    <div class="col-6">

                        <span class="pos-sale-inspector-label">
                            Date
                        </span>

                        <strong
                            id="pos-sale-inspector-date"
                            class="pos-sale-inspector-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="col-6">

                        <span class="pos-sale-inspector-label">
                            Time
                        </span>

                        <strong
                            id="pos-sale-inspector-time"
                            class="pos-sale-inspector-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="col-6">

                        <span class="pos-sale-inspector-label">
                            Cashier
                        </span>

                        <strong
                            id="pos-sale-inspector-cashier"
                            class="pos-sale-inspector-value"
                        >
                            —
                        </strong>

                    </div>


                    <div class="col-6">

                        <span class="pos-sale-inspector-label">
                            Payment
                        </span>

                        <strong
                            id="pos-sale-inspector-payment"
                            class="pos-sale-inspector-value"
                        >
                            —
                        </strong>

                    </div>

                </div>

            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Customer
            |--------------------------------------------------------------------------
            --}}

            <div class="pos-sale-inspector-section">

                <div class="pos-sale-inspector-section-title">

                    <i class="bi bi-person"></i>

                    Customer

                </div>


                <div class="pos-sale-inspector-customer">

                    <strong
                        id="pos-sale-inspector-customer-name"
                    >
                        Walk-in Customer
                    </strong>

                    <span
                        id="pos-sale-inspector-customer-phone"
                    >
                        —
                    </span>

                </div>

            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Items
            |--------------------------------------------------------------------------
            --}}

            <div class="pos-sale-inspector-section">

                <div class="pos-sale-inspector-section-title">

                    <i class="bi bi-basket"></i>

                    Items

                </div>


                <div
                    id="pos-sale-inspector-items"
                    class="pos-sale-inspector-items"
                >

                    <div class="text-center py-4 text-muted">

                        No items available.

                    </div>

                </div>

            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Totals
            |--------------------------------------------------------------------------
            --}}

            <div class="pos-sale-inspector-section">

                <div class="pos-sale-inspector-section-title">

                    <i class="bi bi-calculator"></i>

                    Summary

                </div>


                <div class="pos-sale-inspector-totals">


                    <div class="pos-sale-inspector-total-row">

                        <span>
                            Subtotal
                        </span>

                        <strong
                            id="pos-sale-inspector-subtotal"
                        >
                            ₦0.00
                        </strong>

                    </div>


                    <div class="pos-sale-inspector-total-row">

                        <span>
                            Discount
                        </span>

                        <strong
                            id="pos-sale-inspector-discount"
                        >
                            ₦0.00
                        </strong>

                    </div>


                    <div class="pos-sale-inspector-total-row">

                        <span>
                            Tax
                        </span>

                        <strong
                            id="pos-sale-inspector-tax"
                        >
                            ₦0.00
                        </strong>

                    </div>


                    <div class="pos-sale-inspector-total-row pos-sale-inspector-grand-total">

                        <span>
                            Total
                        </span>

                        <strong
                            id="pos-sale-inspector-total"
                        >
                            ₦0.00
                        </strong>

                    </div>


                </div>

            </div>


            {{-- 
            |--------------------------------------------------------------------------
            | Payments
            |--------------------------------------------------------------------------
            --}}

            <div class="pos-sale-inspector-section">

                <div class="pos-sale-inspector-section-title">

                    <i class="bi bi-credit-card"></i>

                    Payment Details

                </div>


                <div
                    id="pos-sale-inspector-payments"
                    class="pos-sale-inspector-payments"
                >

                    <div class="text-center py-4 text-muted">

                        No payment details available.

                    </div>

                </div>

            </div>


        </div>


        {{-- 
        |--------------------------------------------------------------------------
        | Error
        |--------------------------------------------------------------------------
        --}}

        <div
            id="pos-sale-inspector-error"
            class="d-none"
        >

            <div class="text-center py-5">

                <div class="mb-3">

                    <i
                        class="bi bi-exclamation-circle text-danger"
                        style="font-size: 2rem;"
                    ></i>

                </div>

                <h6>
                    Unable to load sale
                </h6>

                <p
                    class="text-muted small mb-0"
                    id="pos-sale-inspector-error-message"
                >
                    Unable to load sale details.
                </p>

            </div>

        </div>


    </div>


    {{-- 
    |--------------------------------------------------------------------------
    | Footer
    |--------------------------------------------------------------------------
    --}}

    <div class="offcanvas-footer border-top p-3">

        <button
            type="button"
            class="btn btn-light w-100"
            data-bs-dismiss="offcanvas"
        >

            <i class="bi bi-x-lg me-1"></i>

            Close

        </button>

    </div>


</div>