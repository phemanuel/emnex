
{{-- ==========================================================
    Return Inspector
=========================================================== --}}

<div
    class="offcanvas offcanvas-end emnex-inspector"
    tabindex="-1"
    id="returnInspector"
    aria-labelledby="returnInspectorLabel"
    style="width: 520px;"
>

    {{-- ======================================================
        Header
    ======================================================= --}}

    <div class="offcanvas-header border-bottom">

        <div>

            <h5
                class="offcanvas-title mb-1"
                id="returnInspectorLabel"
            >
                Sales Return
            </h5>

            <div class="text-muted small">
                Refund details and activity
            </div>

        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
        ></button>

    </div>


    {{-- ======================================================
        Body
    ======================================================= --}}

    <div class="offcanvas-body">

        {{-- Status --}}

        <div class="mb-4">

            <span class="text-muted small d-block mb-2">
                Return Status
            </span>

            <span
                id="returnInspectorStatus"
                class="badge"
            >
                —
            </span>

        </div>


        {{-- ==================================================
            Return Information
        =================================================== --}}

        <div class="inspector-section">

            <div class="inspector-section-title">
                Return Information
            </div>


            <div class="inspector-details">

                <div>

                    <span class="purchase-inspector-label">
                        Return No.
                    </span>

                    <strong id="returnInspectorNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Order No.
                    </span>

                    <strong id="returnInspectorOrderNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Invoice No.
                    </span>

                    <strong id="returnInspectorInvoiceNumber">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Customer
                    </span>

                    <strong id="returnInspectorCustomer">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Branch
                    </span>

                    <strong id="returnInspectorBranch">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Terminal
                    </span>

                    <strong id="returnInspectorTerminal">
                        —
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==================================================
            Order & Refund Summary
        =================================================== --}}

        <div class="inspector-section">

            <div class="inspector-section-title">
                Order & Refund Summary
            </div>


           
            <div class="inspector-summary">

                <div>

                    <span>
                        Order Total
                    </span>

                    <strong id="returnInspectorOrderTotal">
                        {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                    </strong>

                </div>


                <div>

                    <span>
                        Amount Paid
                    </span>

                    <strong id="returnInspectorAmountPaid">
                        {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                    </strong>

                </div>


                <div>

                    <span>
                        Refund Amount
                    </span>

                    <strong id="returnInspectorRefundAmount">
                        {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                    </strong>

                </div>


                <div>

                    <span>
                        Balance
                    </span>

                    <strong id="returnInspectorBalance">
                        {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                    </strong>

                </div>

            </div>



        </div>


        {{-- ==================================================
            Status Information
        =================================================== --}}

        <div class="inspector-section">

            <div class="inspector-section-title">
                Order Status
            </div>


            <div class="inspector-details">

                <div>

                    <span class="purchase-inspector-label">
                        Order Status
                    </span>

                    <span
                        id="returnInspectorOrderStatus"
                        class="badge"
                    >
                        —
                    </span>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Payment Status
                    </span>

                    <span
                        id="returnInspectorPaymentStatus"
                        class="badge"
                    >
                        —
                    </span>

                </div>

            </div>

        </div>


        {{-- ==================================================
            Refunded Payments
        =================================================== --}}

        <div class="inspector-section">

            <div class="inspector-section-title">
                Refunded Payments
            </div>


            <div id="returnInspectorPayments">

                <div class="text-muted small">
                    No refunded payments.
                </div>

            </div>

        </div>


        {{-- ==================================================
            Remarks
        =================================================== --}}

        <div class="inspector-section">

            <div class="inspector-section-title">
                Remarks
            </div>


            <div
                id="returnInspectorRemarks"
                class="text-muted"
            >
                —
            </div>

        </div>


        {{-- ==================================================
            Activity
        =================================================== --}}

        <div class="inspector-section">

            <div class="inspector-section-title">
                Activity
            </div>


            <div class="inspector-details">

                <div>

                    <span class="purchase-inspector-label">
                        Processed By
                    </span>

                    <strong id="returnInspectorProcessedBy">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Created
                    </span>

                    <strong id="returnInspectorCreatedAt">
                        —
                    </strong>

                </div>


                <div>

                    <span class="purchase-inspector-label">
                        Updated
                    </span>

                    <strong id="returnInspectorUpdatedAt">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- ======================================================
        Footer
    ======================================================= --}}

    <div class="offcanvas-footer border-top p-3">

        <button
            type="button"
            class="btn btn-light w-100"
            id="returnInspectorPrintReceipt"
        >

            <i class="bi bi-printer me-2"></i>

            Print Refund Receipt

        </button>

    </div>

</div>

