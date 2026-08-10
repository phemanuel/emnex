{{-- ==============================================================
STOCK TRANSFER MODAL
================================================================= --}}

<div
    class="modal fade"
    id="stockTransferModal"
    tabindex="-1"
    aria-labelledby="stockTransferModalLabel"
    aria-hidden="true"
>

    {{-- ==============================================================
STOCK TRANSFER MODAL
================================================================= --}}

<div class="modal-dialog modal-xl modal-dialog-centered">


<div class="modal-content stock-transfer-modal">

    {{-- ======================================================
        HEADER
    ======================================================= --}}

    <div class="modal-header stock-transfer-modal-header">

        <div class="stock-transfer-modal-heading">

            <div class="stock-transfer-modal-icon">

                <i class="bi bi-arrow-left-right"></i>

            </div>

            <div>

                <h5
                    class="modal-title"
                    id="stockTransferModalLabel"
                >
                    Transfer Stock
                </h5>

                <p class="stock-transfer-modal-subtitle">
                    Review the selected products and specify the quantity
                    to transfer.
                </p>

            </div>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
        ></button>

    </div>


    {{-- ======================================================
        BODY
    ======================================================= --}}

    <div class="modal-body stock-transfer-modal-body">

        <form
            id="stockTransferForm"
            novalidate
        >

            {{-- ==================================================
                TRANSFER DESTINATION
            =================================================== --}}

            <section class="stock-transfer-modal-section">

                <div class="stock-transfer-section-heading">

                    <div class="stock-transfer-section-icon">

                        <i class="bi bi-building"></i>

                    </div>

                    <div>

                        <h6>
                            Transfer Destination
                        </h6>

                        <p>
                            Select the branch that will receive the stock.
                        </p>

                    </div>

                </div>


                <div class="stock-transfer-destination-grid">

                    {{-- FROM --}}

                    <div class="stock-transfer-destination-field">

                        <label class="form-label">
                            From
                        </label>

                        <div class="stock-transfer-source-field">

                            <div class="stock-transfer-source-icon">

                                <i class="bi bi-building"></i>

                            </div>

                            <div class="stock-transfer-source-content">

                                <span class="stock-transfer-source-label">
                                    Source Location
                                </span>

                                <strong>
                                    {{ $headOffice->name }}
                                </strong>

                            </div>

                            <span class="stock-transfer-source-badge">
                                Head Office
                            </span>

                        </div>

                    </div>


                    {{-- TO --}}

                    <div class="stock-transfer-destination-field">

                        <label
                            for="destinationBranch"
                            class="form-label"
                        >
                            To
                        </label>

                        <select
                            class="form-select stock-transfer-destination-select"
                            id="destinationBranch"
                            name="branch_id"
                            required
                        >

                            <option value="">
                                Select destination branch
                            </option>

                            @foreach ($branches as $branch)

                                <option value="{{ $branch->id }}">
                                    {{ $branch->displayName() }}
                                </option>

                            @endforeach

                        </select>

                        <div class="invalid-feedback">
                            Please select a destination branch.
                        </div>

                    </div>

                </div>

            </section>


            {{-- ==================================================
                SELECTED PRODUCTS
            =================================================== --}}

            <section class="stock-transfer-modal-section">

                {{-- SECTION HEADER --}}

                <div class="stock-transfer-products-heading">

                    <div class="stock-transfer-section-heading mb-0">

                        <div class="stock-transfer-section-icon">

                            <i class="bi bi-box-seam"></i>

                        </div>

                        <div>

                            <h6>
                                Selected Products
                            </h6>

                            <p>
                                Specify how much stock should be transferred
                                for each selected product.
                            </p>

                        </div>

                    </div>


                    <div class="stock-transfer-selection-summary">

                        <span
                            id="transferModalProductCount"
                            class="stock-transfer-product-count"
                        >
                            0 products
                        </span>

                    </div>

                </div>


                {{-- PRODUCT GRID --}}

                <div
                    class="stock-transfer-review-list"
                    id="transferItemsContainer"
                >

                    {{-- ==================================================
                        JS POPULATES SELECTED PRODUCTS HERE

                        IMPORTANT:
                        Keep this container ID unchanged.
                    =================================================== --}}

                    <div class="stock-transfer-review-empty">

                        <div class="stock-transfer-review-empty-icon">

                            <i class="bi bi-box-seam"></i>

                        </div>

                        <h6>
                            No products selected
                        </h6>

                        <p>
                            Select products from the stock list to
                            continue with the transfer.
                        </p>

                    </div>

                </div>

            </section>


            {{-- ==================================================
                TRANSFER DETAILS
            =================================================== --}}

            <section class="stock-transfer-modal-section">

                <div class="stock-transfer-section-heading">

                    <div class="stock-transfer-section-icon">

                        <i class="bi bi-card-text"></i>

                    </div>

                    <div>

                        <h6>
                            Transfer Details
                        </h6>

                        <p>
                            Add an optional reference or note for this transfer.
                        </p>

                    </div>

                </div>


                <div class="stock-transfer-details-grid">

                    {{-- REFERENCE --}}

                    <div>

                         <label class="form-label">
                            Transfer Reference
                        </label>

                        <div class="stock-transfer-reference-info">

                            <span class="stock-transfer-reference-info-icon">
                                <i class="bi bi-magic"></i>
                            </span>

                            <div class="stock-transfer-reference-info-content">

                                <span class="stock-transfer-reference-info-title">
                                    Automatically generated
                                </span>

                                <span class="stock-transfer-reference-info-text">
                                    A unique transfer reference will be assigned when the transfer is completed.
                                </span>

                            </div>

                        </div>
                    </div>


                    {{-- REMARKS --}}

                    <div>

                        <label
                            for="remarks"
                            class="form-label"
                        >
                            Remarks
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="remarks"
                            name="remarks"
                            placeholder="Optional transfer note"
                        >

                    </div>

                </div>

            </section>


            {{-- ==================================================
                HIDDEN TRANSFER PAYLOAD
            =================================================== --}}

            <div id="stockTransferPayloadContainer"></div>

        </form>

    </div>


    {{-- ======================================================
        FOOTER
    ======================================================= --}}

    <div class="modal-footer stock-transfer-modal-footer">

        {{-- TOTAL --}}

        <div class="stock-transfer-total">

            <div class="stock-transfer-total-icon">

                <i class="bi bi-box-seam"></i>

            </div>

            <div>

                <span>
                    Total Quantity
                </span>

                <strong id="transferModalTotalQuantity">
                    0.00
                </strong>

            </div>

        </div>


        {{-- ACTIONS --}}

        <div class="stock-transfer-footer-actions">

            <button
                type="button"
                class="btn btn-light stock-transfer-cancel-btn"
                data-bs-dismiss="modal"
            >
                Cancel
            </button>


            <button
                type="button"
                class="btn btn-primary stock-transfer-submit-btn"
                id="submitTransfer"
            >

                <i class="bi bi-arrow-left-right me-2"></i>

                Complete Transfer

            </button>

        </div>

    </div>

</div>


</div>


</div>