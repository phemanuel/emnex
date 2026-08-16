{{-- ==============================================================
    Purchase Order Modal
============================================================== --}}

<div
    class="modal fade"
    id="purchaseOrderModal"
    tabindex="-1"
    aria-labelledby="purchaseOrderModalLabel"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable"
    >

        <div class="modal-content border-0 shadow-lg">

            {{-- ==================================================
                Header
            ================================================== --}}

            <div class="modal-header border-bottom">

                <div>

                    <h5
                        class="modal-title fw-semibold"
                        id="purchaseOrderModalLabel"
                    >
                        Create Purchase Order
                    </h5>

                    <div class="text-muted small">
                        Create and manage supplier purchase orders.
                    </div>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==================================================
                Form
            ================================================== --}}

            <form
                id="purchaseOrderForm"
                enctype="multipart/form-data"
            >

                <input
                    type="hidden"
                    id="purchaseOrderId"
                    name="id"
                >

                <div class="modal-body">

                    {{-- ==========================================
                        Supplier / Order Information
                    =========================================== --}}

                    <div class="purchase-form-section mb-4">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-file-earmark-text me-2"></i>

                            Order Information

                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label
                                    for="purchaseOrderSupplier"
                                    class="form-label"
                                >
                                    Supplier
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="purchaseOrderSupplier"
                                    name="supplier_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select supplier
                                    </option>

                                </select>

                                <div
                                    class="invalid-feedback"
                                    data-error="supplier_id"
                                ></div>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="purchaseOrderBranch"
                                    class="form-label"
                                >
                                    Receiving Branch
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="purchaseOrderBranch"
                                    name="branch_id"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select branch
                                    </option>

                                </select>

                                <div
                                    class="invalid-feedback"
                                    data-error="branch_id"
                                ></div>

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="purchaseOrderDate"
                                    class="form-label"
                                >
                                    Order Date
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="purchaseOrderDate"
                                    name="order_date"
                                    class="form-control"
                                    required
                                >

                            </div>


                            <div class="col-md-6">

                                <label
                                    for="purchaseOrderExpectedDate"
                                    class="form-label"
                                >
                                    Expected Delivery
                                </label>

                                <input
                                    type="date"
                                    id="purchaseOrderExpectedDate"
                                    name="expected_date"
                                    class="form-control"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- ==========================================
                        Products
                    =========================================== --}}

                    <div class="purchase-form-section mb-4">

                        <div
                            class="d-flex align-items-center justify-content-between mb-3"
                        >

                            <div>

                                <div class="purchase-form-section-title">

                                    <i class="bi bi-box-seam me-2"></i>

                                    Order Items

                                </div>

                                <div class="text-muted small mt-1">
                                    Add products and specify purchase quantities.
                                </div>

                            </div>

                            <button
                                type="button"
                                class="btn btn-primary btn-sm"
                                id="addPurchaseOrderItemBtn"
                            >

                                <i class="bi bi-plus-lg me-1"></i>

                                Add Product

                            </button>

                        </div>


                        <div
                            class="table-responsive border rounded-3"
                        >

                            <table
                                class="table table-sm align-middle mb-0"
                                id="purchaseOrderItemsTable"
                            >

                                <thead class="table-light">

                                    <tr>

                                        <th style="min-width: 260px;">
                                            Product
                                        </th>

                                        <th style="width: 130px;">
                                            Quantity
                                        </th>

                                        <th style="width: 150px;">
                                            Unit Cost
                                        </th>

                                        <th style="width: 150px;">
                                            Amount
                                        </th>

                                        <th
                                            class="text-end"
                                            style="width: 70px;"
                                        >
                                            #
                                        </th>

                                    </tr>

                                </thead>

                                <tbody id="purchaseOrderItems">

                                    <tr
                                        id="purchaseOrderEmptyItems"
                                    >

                                        <td
                                            colspan="5"
                                            class="text-center text-muted py-4"
                                        >

                                            <i
                                                class="bi bi-box-seam fs-4 d-block mb-2"
                                            ></i>

                                            No products added yet.

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- ==========================================
                        Totals
                    =========================================== --}}

                    <div class="row justify-content-end">

                        <div class="col-lg-5">

                            <div class="purchase-summary-card">

                                <div class="purchase-summary-row">

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong
                                        id="purchaseOrderSubtotal"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <!-- <div class="purchase-summary-row">

                                    <span>
                                        Discount
                                    </span>

                                    <div class="input-group input-group-sm">

                                        <input
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            id="purchaseOrderDiscount"
                                            name="discount"
                                            class="form-control text-end"
                                            value="0"
                                        >

                                    </div>

                                </div> -->


                                <!-- <div class="purchase-summary-row">

                                    <span>
                                        Tax
                                    </span>

                                    <strong
                                        id="purchaseOrderTax"
                                    >
                                        0.00
                                    </strong>

                                </div> -->


                                <div class="purchase-summary-row purchase-summary-total">

                                    <span>
                                        Total
                                    </span>

                                    <strong
                                        id="purchaseOrderTotal"
                                    >
                                        0.00
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==========================================
                        Notes
                    =========================================== --}}

                    <div class="mt-4">

                        <label
                            for="purchaseOrderNotes"
                            class="form-label"
                        >
                            Notes
                        </label>

                        <textarea
                            id="purchaseOrderNotes"
                            name="notes"
                            class="form-control"
                            rows="3"
                            placeholder="Optional notes..."
                        ></textarea>

                    </div>

                </div>


                {{-- ==================================================
                    Footer
                ================================================== --}}

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
                        id="purchaseOrderSubmitBtn"
                    >

                        <span
                            class="purchase-order-submit-text"
                        >
                            Save Purchase Order
                        </span>

                        <span
                            class="spinner-border spinner-border-sm d-none"
                            id="purchaseOrderSubmitSpinner"
                            role="status"
                            aria-hidden="true"
                        ></span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>