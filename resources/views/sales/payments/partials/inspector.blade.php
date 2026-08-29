{{-- ==============================================================
Payment Inspector
=============================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="paymentInspector"
    aria-labelledby="paymentInspectorLabel"
>


{{-- ==========================================================
    Header
=========================================================== --}}

<div class="offcanvas-header border-bottom">

    <div>

        <div class="text-muted small mb-1">
            Payment
        </div>

        <div class="fw-semibold">
            Payment Details
        </div>

    </div>


    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
    ></button>

</div>


{{-- ==========================================================
    Body
=========================================================== --}}

<div class="offcanvas-body">


    {{-- ======================================================
        Payment Status
    ======================================================= --}}

    <div
        class="d-flex align-items-center justify-content-between mb-4"
    >

        <div>

            <div class="text-muted small">
                Payment Status
            </div>

            <div class="small text-muted">
                Current payment state
            </div>

        </div>


        <span
            id="paymentInspectorStatus"
            class="badge bg-secondary-subtle text-secondary"
        >
            —
        </span>

    </div>


    {{-- ======================================================
        Payment Information
    ======================================================= --}}

    <div class="payment-inspector-card mb-4">

        <div class="payment-inspector-grid">


            <div>

                <span class="payment-inspector-label">
                    Payment No.
                </span>

                <strong id="paymentInspectorNumber">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Order No.
                </span>

                <strong id="paymentInspectorOrderNumber">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Invoice No.
                </span>

                <strong id="paymentInspectorInvoiceNumber">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Customer
                </span>

                <strong id="paymentInspectorCustomer">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Branch
                </span>

                <strong id="paymentInspectorBranch">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Terminal
                </span>

                <strong id="paymentInspectorTerminal">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Payment Method
                </span>

                <strong id="paymentInspectorMethod">
                    —
                </strong>

            </div>


            <div>

                <span class="payment-inspector-label">
                    Payment Date
                </span>

                <strong id="paymentInspectorDate">
                    —
                </strong>

            </div>

        </div>

    </div>


    {{-- ======================================================
        Amount
    ======================================================= --}}

    <div class="payment-inspector-amount-card mb-4">

        <div>

            <div class="payment-inspector-label">
                Payment Amount
            </div>

            <strong id="paymentInspectorAmount">
                ₦0.00
            </strong>

        </div>

    </div>


    {{-- ======================================================
        Transaction Information
    ======================================================= --}}

    <div class="payment-inspector-section mb-4">

        <div class="payment-inspector-section-header">

            <div class="payment-inspector-section-icon">

                <i class="bi bi-receipt"></i>

            </div>


            <div>

                <div class="payment-inspector-section-title">
                    Transaction Information
                </div>

                <div class="payment-inspector-section-description">
                    Payment reference and gateway information
                </div>

            </div>

        </div>


        <div class="payment-inspector-card">

            <div class="payment-inspector-grid">


                <div>

                    <span class="payment-inspector-label">
                        Reference No.
                    </span>

                    <strong id="paymentInspectorReference">
                        —
                    </strong>

                </div>


                <div>

                    <span class="payment-inspector-label">
                        Transaction Reference
                    </span>

                    <strong id="paymentInspectorTransactionReference">
                        —
                    </strong>

                </div>


                <div>

                    <span class="payment-inspector-label">
                        Payment Gateway
                    </span>

                    <strong id="paymentInspectorGateway">
                        —
                    </strong>

                </div>


                <div>

                    <span class="payment-inspector-label">
                        Received By
                    </span>

                    <strong id="paymentInspectorReceivedBy">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- ======================================================
        Receipt Action
    ======================================================= --}}

    <div class="payment-inspector-action mb-4">

        <div class="d-flex align-items-start gap-3">

            <div class="text-primary">

                <i class="bi bi-printer fs-5"></i>

            </div>


            <div class="flex-grow-1">

                <div class="fw-semibold mb-1">
                    Payment Receipt
                </div>

                <div class="text-muted small mb-3">
                    Print a receipt for this payment transaction.
                </div>


                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    id="paymentPrintReceipt"
                >

                    <i class="bi bi-printer me-1"></i>

                    Print Receipt

                </button>

            </div>

        </div>

    </div>


    {{-- ======================================================
        Remarks
    ======================================================= --}}

    <div class="mb-4">

        <div class="payment-inspector-heading mb-3">
            Remarks
        </div>


        <div
            id="paymentInspectorRemarks"
            class="text-muted small"
        >
            —
        </div>

    </div>


    {{-- ======================================================
        Activity
    ======================================================= --}}

    <div class="payment-inspector-card">

        <div class="payment-inspector-heading mb-3">
            Activity
        </div>


        <div class="payment-inspector-meta">


            <div>

                <span>
                    Received By
                </span>

                <strong id="paymentInspectorReceivedBy">
                    —
                </strong>

            </div>


            <div>

                <span>
                    Created
                </span>

                <strong id="paymentInspectorCreatedAt">
                    —
                </strong>

            </div>


            <div>

                <span>
                    Updated
                </span>

                <strong id="paymentInspectorUpdatedAt">
                    —
                </strong>

            </div>

        </div>

    </div>

</div>


</div>
