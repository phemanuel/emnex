
{{-- ==============================================================
    Goods Received Modal
============================================================== --}}

<div
    class="modal fade"
    id="goodsReceivedModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
    class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable goods-received-modal-dialog"
>

        <div class="modal-content border-0 shadow-lg">

            {{-- ======================================================
                Header
            ======================================================= --}}

            <div class="modal-header border-bottom">

                <div>

                    <h5
                        class="modal-title fw-semibold"
                        id="goodsReceivedModalLabel"
                    >
                        Record Goods Received
                    </h5>

                    <div class="text-muted small">
                        Receive inventory against an approved purchase order.
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
                Form
            ======================================================= --}}

            <form id="goodsReceivedForm">

                <input
                    type="hidden"
                    id="goodsReceivedId"
                    name="id"
                >


                <div class="modal-body">

                    {{-- ==================================================
                        Receiving Information
                    =================================================== --}}

                    <div class="purchase-form-section mb-4">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-box-arrow-in-down me-2"></i>

                            Receiving Information

                        </div>


                        <div class="row g-3">

                            {{-- ==================================================
                                Purchase Order
                            =================================================== --}}

                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedPurchaseOrder"
                                    class="form-label"
                                >

                                    Purchase Order

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    id="goodsReceivedPurchaseOrder"
                                    name="purchase_order_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select approved purchase order
                                    </option>

                                </select>


                                <div
                                    class="form-text"
                                    id="goodsReceivedPurchaseOrderHelp"
                                >
                                    Only approved purchase orders available
                                    for receiving will be shown.
                                </div>

                            </div>


                            {{-- ==================================================
                                Supplier
                            =================================================== --}}

                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedSupplier"
                                    class="form-label"
                                >
                                    Supplier
                                </label>


                                <input
                                    type="text"
                                    id="goodsReceivedSupplier"
                                    class="form-control"
                                    placeholder="Supplier will be populated"
                                    readonly
                                >

                            </div>


                            {{-- ==================================================
                                Receiving Branch
                            =================================================== --}}

                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedBranch"
                                    class="form-label"
                                >
                                    Receiving Branch
                                </label>


                                <input
                                    type="text"
                                    id="goodsReceivedBranch"
                                    class="form-control"
                                    placeholder="Branch will be populated"
                                    readonly
                                >

                            </div>


                            {{-- ==================================================
                                Received Date
                            =================================================== --}}

                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedDate"
                                    class="form-label"
                                >

                                    Received Date

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="date"
                                    id="goodsReceivedDate"
                                    name="received_date"
                                    class="form-control"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Items
                    =================================================== --}}

                    <div class="purchase-form-section mb-4">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-boxes me-2"></i>

                            Items to Receive

                        </div>


                        <div
                            class="table-responsive border rounded-3"
                        >

                            <table
                                class="table table-sm align-middle mb-0"
                                id="goodsReceivedItemsTable"
                            >

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            Product
                                        </th>

                                        <th class="text-end">
                                            Ordered
                                        </th>

                                        <th class="text-end">
                                            Previously Received
                                        </th>

                                        <th class="text-end">
                                            Remaining
                                        </th>

                                        <th class="text-end">
                                            Current Stock
                                        </th>

                                        <th class="text-end">
                                            Maximum Stock
                                        </th>

                                        <th style="width: 150px;">
                                            Receive Now
                                        </th>

                                        <th class="text-end">
                                            Unit Cost
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="goodsReceivedItems">

                                    <tr
                                        id="goodsReceivedEmptyItems"
                                    >

                                        <td
                                            colspan="8"
                                            class="text-center text-muted py-5"
                                        >

                                            <div class="mb-2">

                                                <i
                                                    class="bi bi-box-seam fs-3"
                                                ></i>

                                            </div>

                                            Select an approved purchase order
                                            to load items available for receiving.

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- ==================================================
                        Notes
                    =================================================== --}}

                    <div class="purchase-form-section">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-sticky me-2"></i>

                            Notes

                        </div>


                        <textarea
                            id="goodsReceivedNotes"
                            name="notes"
                            class="form-control"
                            rows="3"
                            placeholder="Optional receiving notes..."
                        ></textarea>

                    </div>

                </div>


                <div class="goods-received-modal-footer">

                    <div class="goods-received-modal-footer-actions">

                        <button
                            type="button"
                            class="goods-received-modal-cancel"
                            data-bs-dismiss="modal"
                        >

                            Cancel

                        </button>


                        <button
                            type="submit"
                            class="goods-received-modal-submit"
                            id="goodsReceivedSubmitBtn"
                        >

                            <span id="goodsReceivedSubmitText">
                                Receive Goods
                            </span>

                            <span
                                class="spinner-border spinner-border-sm d-none"
                                id="goodsReceivedSubmitSpinner"
                            ></span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

