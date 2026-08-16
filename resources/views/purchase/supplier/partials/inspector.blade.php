 {{-- ==============================================================
        Supplier Inspector
    ============================================================== --}}

    <div
        class="offcanvas offcanvas-end supplier-inspector"
        tabindex="-1"
        id="supplierInspector"
        aria-labelledby="supplierInspectorLabel"
    >

        <div class="offcanvas-header">

            <div>

                <span class="supplier-inspector-eyebrow">
                    SUPPLIER
                </span>

                <h5
                    class="offcanvas-title"
                    id="supplierInspectorName"
                >
                    —
                </h5>

                <div
                    id="supplierInspectorCode"
                    class="text-muted small"
                >
                    —
                </div>

            </div>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
            ></button>

        </div>


        <div class="offcanvas-body">

            <div class="supplier-inspector-status mb-4">

                <span
                    id="supplierInspectorStatus"
                    class="badge rounded-pill"
                >
                    —
                </span>

            </div>


            {{-- ==========================================================
                Contact
            =========================================================== --}}

            <div class="supplier-inspector-section">

                <div class="supplier-inspector-section-title">
                    Contact
                </div>

                <div class="supplier-detail-row">

                    <span>
                        Contact Person
                    </span>

                    <strong id="supplierInspectorContact">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Email
                    </span>

                    <strong id="supplierInspectorEmail">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Phone
                    </span>

                    <strong id="supplierInspectorPhone">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Alternate Phone
                    </span>

                    <strong id="supplierInspectorAlternatePhone">
                        —
                    </strong>

                </div>

            </div>


            {{-- ==========================================================
                Address
            =========================================================== --}}

            <div class="supplier-inspector-section">

                <div class="supplier-inspector-section-title">
                    Address
                </div>

                <div
                    id="supplierInspectorAddress"
                    class="supplier-inspector-address"
                >
                    —
                </div>

            </div>


            {{-- ==========================================================
                Financial
            =========================================================== --}}

            <div class="supplier-inspector-section">

                <div class="supplier-inspector-section-title">
                    Financial
                </div>

                <div class="supplier-financial-grid">

                    <div class="supplier-financial-item">

                        <span>
                            Credit Limit
                        </span>

                        <strong id="supplierInspectorCreditLimit">
                            0.00
                        </strong>

                    </div>


                    <div class="supplier-financial-item">

                        <span>
                            Current Balance
                        </span>

                        <strong id="supplierInspectorBalance">
                            0.00
                        </strong>

                    </div>


                    <div class="supplier-financial-item">

                        <span>
                            Available Credit
                        </span>

                        <strong id="supplierInspectorAvailableCredit">
                            0.00
                        </strong>

                    </div>

                </div>

            </div>


            {{-- ==========================================================
                Business
            =========================================================== --}}

            <div class="supplier-inspector-section">

                <div class="supplier-inspector-section-title">
                    Business Information
                </div>

                <div class="supplier-detail-row">

                    <span>
                        Tax Number
                    </span>

                    <strong id="supplierInspectorTaxNumber">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Payment Terms
                    </span>

                    <strong id="supplierInspectorPaymentTerms">
                        —
                    </strong>

                </div>

            </div>


            {{-- ==========================================================
                Notes
            =========================================================== --}}

            <div class="supplier-inspector-section">

                <div class="supplier-inspector-section-title">
                    Notes
                </div>

                <div
                    id="supplierInspectorNotes"
                    class="supplier-inspector-notes"
                >
                    —
                </div>

            </div>


            {{-- ==========================================================
                Metadata
            =========================================================== --}}

            <div class="supplier-inspector-section">

                <div class="supplier-detail-row">

                    <span>
                        Created By
                    </span>

                    <strong id="supplierInspectorCreatedBy">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Created
                    </span>

                    <strong id="supplierInspectorCreatedAt">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Updated By
                    </span>

                    <strong id="supplierInspectorUpdatedBy">
                        —
                    </strong>

                </div>


                <div class="supplier-detail-row">

                    <span>
                        Updated
                    </span>

                    <strong id="supplierInspectorUpdatedAt">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>
