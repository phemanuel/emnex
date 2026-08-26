<!-- {{-- ==============================================================
    Purchase Return Modal
============================================================== --}} -->

<div
    class="modal fade"
    id="purchaseReturnModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
    class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable goods-received-modal-dialog"
>

        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header border-bottom">

                <div>

                    <h5
                        class="modal-title fw-semibold"
                        id="purchaseReturnModalLabel"
                    >
                        Create Purchase Return
                    </h5>

                    <div class="text-muted small">
                        Return received goods to a supplier.
                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <form id="purchaseReturnForm">

                <input
                    type="hidden"
                    id="purchaseReturnId"
                    name="id"
                >

                <div class="modal-body">

                    <!-- {{-- ==================================================
                        Return Information
                    ================================================== --}} -->

                    <div class="purchase-form-section mb-4">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-arrow-return-left me-2"></i>

                            Return Information

                        </div>

                        <div class="row g-3">

                        <div class="col-md-6">

                                <label
                                    for="purchaseReturnPurchaseOrder"
                                    class="form-label"
                                >
                                    Purchase Order
                                </label>

                                <select
                                    id="purchaseReturnPurchaseOrder"
                                    name="purchase_order_id"
                                    class="form-select"
                                >

                                    <option value="">
                                        Select purchase order
                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label
                                    for="purchaseReturnSupplier"
                                    class="form-label"
                                >
                                    Supplier
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="purchaseReturnSupplier"
                                    name="supplier_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select supplier
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="purchaseReturnBranch"
                                    class="form-label"
                                >
                                    Branch
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="purchaseReturnBranch"
                                    name="branch_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select branch
                                    </option>

                                </select>

                            </div>                           


                            <div class="col-md-6">

                                <label
                                    for="purchaseReturnDate"
                                    class="form-label"
                                >
                                    Return Date
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="purchaseReturnDate"
                                    name="return_date"
                                    class="form-control"
                                    required
                                >

                            </div>

                        </div>

                    </div>


                    <!-- {{-- ==================================================
                        Items
                    ================================================== --}} -->

                    <div class="purchase-form-section mb-4">

                        <div
                            class="d-flex align-items-center justify-content-between mb-3"
                        >

                            <div>

                                <div class="purchase-form-section-title">

                                    <i class="bi bi-box-seam me-2"></i>

                                    Return Items

                                </div>

                                <div class="text-muted small mt-1">
                                   Products received against the selected purchase order are available for return.
                                </div>

                            </div>

                            <!-- <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                id="addPurchaseReturnItemBtn"
                            >

                                <i class="bi bi-plus-lg me-1"></i>

                                Add Product

                            </button> -->

                        </div>


                        <div class="table-responsive border rounded-3">

                           <table
                                class="table table-sm align-middle mb-0"
                                id="purchaseReturnItemsTable"
                            >

                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            Product
                                        </th>

                                        <th>
                                            Date
                                        </th>

                                        <th class="text-end">
                                            Received
                                        </th>

                                        <th class="text-end">
                                            Already Returned
                                        </th>

                                        <th class="text-end">
                                            Available
                                        </th>

                                        <th style="width: 150px;">
                                            Return Qty
                                        </th>

                                        <th style="min-width: 220px;">
                                            Reason
                                        </th>

                                        <th
                                            class="text-end"
                                            style="width: 120px;"
                                        >
                                            Unit Cost
                                        </th>

                                    </tr>

                                </thead>


                                <tbody id="purchaseReturnItems">

                                    <tr
                                        id="purchaseReturnEmptyItems"
                                    >

                                        <td
                                            colspan="8"
                                            class="text-center text-muted py-5"
                                        >

                                            <i
                                                class="bi bi-box-seam fs-4 d-block mb-2"
                                            ></i>

                                            Select a purchase order to load
                                            returnable products.

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    <div class="mt-4">

                        <label
                            for="purchaseReturnNotes"
                            class="form-label"
                        >
                            Notes
                        </label>

                        <textarea
                            id="purchaseReturnNotes"
                            name="notes"
                            class="form-control"
                            rows="3"
                            placeholder="Reason or additional notes..."
                        ></textarea>

                    </div>

                </div>


                <div class="goods-received-modal-footer">                   

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger"
                        id="purchaseReturnSubmitBtn"
                    >

                        <span id="purchaseReturnSubmitText">
                            Process Return
                        </span>

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="purchaseReturnSubmitSpinner"
                        ></span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>