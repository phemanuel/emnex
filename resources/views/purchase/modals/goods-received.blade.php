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
        class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable"
    >

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header border-bottom">

                <div>

                    <h5
                        class="modal-title fw-semibold"
                        id="goodsReceivedModalLabel"
                    >
                        Receive Goods
                    </h5>

                    <div class="text-muted small">
                        Record products received against a purchase order.
                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="goodsReceivedForm">

                <input
                    type="hidden"
                    id="goodsReceivedId"
                    name="id"
                >

                <div class="modal-body">

                    {{-- ==================================================
                        Purchase Information
                    ================================================== --}}

                    <div class="purchase-form-section mb-4">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-box-arrow-in-down me-2"></i>

                            Receiving Information

                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedPurchaseOrder"
                                    class="form-label"
                                >
                                    Purchase Order
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="goodsReceivedPurchaseOrder"
                                    name="purchase_order_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select purchase order
                                    </option>

                                </select>

                            </div>


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
                                    readonly
                                >

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedDate"
                                    class="form-label"
                                >
                                    Received Date
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="goodsReceivedDate"
                                    name="received_date"
                                    class="form-control"
                                    required
                                >

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="goodsReceivedReference"
                                    class="form-label"
                                >
                                    Supplier Reference
                                </label>

                                <input
                                    type="text"
                                    id="goodsReceivedReference"
                                    name="supplier_reference"
                                    class="form-control"
                                    placeholder="Optional reference"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Items
                    ================================================== --}}

                    <div class="purchase-form-section mb-4">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-boxes me-2"></i>

                            Items to Receive

                        </div>

                        <div class="table-responsive border rounded-3">

                            <table
                                class="table table-sm align-middle mb-0"
                                id="goodsReceivedItemsTable"
                            >

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            Product
                                        </th>

                                        <th>
                                            Ordered
                                        </th>

                                        <th>
                                            Previously Received
                                        </th>

                                        <th style="width: 150px;">
                                            Receive Now
                                        </th>

                                        <th>
                                            Remaining
                                        </th>

                                    </tr>

                                </thead>

                                <tbody id="goodsReceivedItems">

                                    <tr
                                        id="goodsReceivedEmptyItems"
                                    >

                                        <td
                                            colspan="5"
                                            class="text-center text-muted py-4"
                                        >

                                            Select a purchase order to load items.

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    <div class="mt-4">

                        <label
                            for="goodsReceivedNotes"
                            class="form-label"
                        >
                            Notes
                        </label>

                        <textarea
                            id="goodsReceivedNotes"
                            name="notes"
                            class="form-control"
                            rows="3"
                            placeholder="Optional receiving notes..."
                        ></textarea>

                    </div>

                </div>


                <div class="modal-footer border-top">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
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

            </form>

        </div>

    </div>

</div>