{{-- ==============================================================
    Sales Order Modal
============================================================== --}}

<div
    class="modal fade"
    id="orderModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable sales-order-modal-dialog"
    >

        <div class="modal-content border-0 shadow-lg">

            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header border-bottom">

                <div>

                    <div class="text-muted small mb-1">
                        Sales Order
                    </div>

                    <h5
                        class="modal-title fw-semibold"
                        id="orderModalLabel"
                    >
                        Create Sales Order
                    </h5>

                    <div
                        class="text-muted small"
                        id="orderModalDescription"
                    >
                        Create a new customer sales order.
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
            =================================================== --}}

            <form
                id="orderForm"
            >

                <input
                    type="hidden"
                    id="orderId"
                    name="id"
                >


                {{-- ==================================================
                    Body
                =================================================== --}}

                <div class="modal-body">

                    {{-- ==================================================
                        Order Information
                    =================================================== --}}

                    <div class="purchase-form-section sales-order-info-section mb-3">

                        <div class="purchase-form-section-title mb-3">

                            <i class="bi bi-receipt me-2"></i>

                            Order Information

                        </div>


                        <div class="row g-2">

                            {{-- Customer --}}

                            <div class="col-lg-3">

                                <div class="sales-order-field">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <label
                                            for="orderCustomer"
                                            class="form-label"
                                        >
                                            Customer
                                        </label>

                                        <a
                                            href="#"
                                            id="createCustomerFromOrderBtn"
                                            class="sales-order-new-customer"
                                        >
                                            <i class="bi bi-plus-circle me-1"></i>
                                            New
                                        </a>

                                    </div>


                                    <select
                                        id="orderCustomer"
                                        name="customer_id"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Walk-in Customer
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Branch --}}

                            <div class="col-lg-3">

                                <div class="sales-order-field">

                                    <label
                                        for="orderBranch"
                                        class="form-label"
                                    >
                                        Branch
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="orderBranch"
                                        name="branch_id"
                                        class="form-select"
                                        required
                                    >

                                        <option value="">
                                            Select branch
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Terminal --}}

                            <div class="col-lg-3">

                                <div class="sales-order-field">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <label
                                            for="orderTerminal"
                                            class="form-label"
                                        >
                                            Terminal
                                        </label>

                                        <div
                                            id="orderCreateTerminalWrap"
                                            class="d-none"
                                        >

                                            <a
                                                href="#"
                                                id="createTerminalFromOrderBtn"
                                                class="sales-order-new-customer"
                                            >

                                                <i class="bi bi-plus-circle me-1"></i>

                                                New Terminal

                                            </a>

                                        </div>

                                    </div>


                                    <select
                                        id="orderTerminal"
                                        name="terminal_id"
                                        class="form-select"
                                    >

                                        <option value="">
                                            Select branch first
                                        </option>

                                    </select>

                                </div>

                            </div>


                            {{-- Sales Channel --}}

                            <div class="col-lg-3">

                                <div class="sales-order-field">

                                    <label
                                        for="orderSalesChannel"
                                        class="form-label"
                                    >
                                        Sales Channel
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        id="orderSalesChannel"
                                        name="sales_channel"
                                        class="form-select"
                                        required
                                    >

                                        <option value="POS">
                                            POS
                                        </option>

                                        <option value="Online">
                                            Online
                                        </option>

                                        <option value="Phone">
                                            Phone
                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ==================================================
                        Order Items
                    =================================================== --}}

                    <div class="purchase-form-section sales-order-items-section mb-3">

                        <div class="sales-order-items-header">

                            <div>

                                <div class="purchase-form-section-title">

                                    <i class="bi bi-box-seam me-2"></i>

                                    Order Items

                                </div>

                                <div class="text-muted small mt-1">

                                    Search and select products to add to this order.

                                </div>

                            </div>


                            <button
                                type="button"
                                class="btn btn-primary btn-sm sales-order-add-item"
                                id="addOrderItemBtn"
                            >

                                <i class="bi bi-plus-lg me-1"></i>

                                Add Product

                            </button>

                        </div>


                        <div class="sales-order-items-container">

                            <div class="table-responsive">

                                <table
                                    class="table table-sm align-middle mb-0"
                                    id="orderItemsTable"
                                >

                                    <thead class="table-light">

                                        <tr>

                                            <th style="min-width: 300px;">
                                                Product
                                            </th>

                                            <th
                                                class="text-end"
                                                style="width: 110px;"
                                            >
                                                Qty
                                            </th>

                                            <th
                                                class="text-end"
                                                style="width: 145px;"
                                            >
                                                Unit Price
                                            </th>

                                            <th
                                                class="text-end"
                                                style="width: 125px;"
                                            >
                                                Discount
                                            </th>

                                            <th
                                                class="text-end"
                                                style="width: 125px;"
                                            >
                                                Tax
                                            </th>

                                            <th
                                                class="text-end"
                                                style="width: 140px;"
                                            >
                                                Line Total
                                            </th>

                                            <th
                                                class="text-end"
                                                style="width: 55px;"
                                            >
                                                #
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody id="orderItems">

                                        <tr id="orderEmptyItems">

                                            <td
                                                colspan="7"
                                                class="text-center text-muted"
                                            >

                                                <div class="sales-order-empty-items">

                                                    <i class="bi bi-box-seam"></i>

                                                    <div class="fw-semibold">
                                                        No products added
                                                    </div>

                                                    <div class="small">
                                                        Click "Add Product" to start building this order.
                                                    </div>

                                                </div>

                                            </td>

                                        </tr>

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    {{-- ==================================================
                        Order Totals
                    =================================================== --}}

                    <div class="row g-4">

                        <div class="col-lg-7">

                            <div class="purchase-form-section">

                                <div class="purchase-form-section-title mb-3">

                                    <i class="bi bi-chat-left-text me-2"></i>

                                    Remarks

                                </div>


                                <textarea
                                    id="orderRemarks"
                                    name="remarks"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Add notes or remarks about this order..."
                                ></textarea>

                            </div>

                        </div>


                        <div class="col-lg-5">

                            <div class="purchase-inspector-card">

                                <div
                                    class="purchase-form-section-title mb-3"
                                >

                                    Order Summary

                                </div>


                                <div class="purchase-summary-row">

                                    <span>
                                        Subtotal
                                    </span>

                                    <strong
                                        id="orderSubtotal"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <div class="purchase-summary-row">

                                    <span>
                                        Discount
                                    </span>

                                    <strong
                                        id="orderDiscount"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <div class="purchase-summary-row">

                                    <span>
                                        Tax
                                    </span>

                                    <strong
                                        id="orderTax"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <div
                                    class="purchase-summary-row purchase-summary-total"
                                >

                                    <span>
                                        Grand Total
                                    </span>

                                    <strong
                                        id="orderTotal"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <div class="purchase-summary-row">

                                    <span>
                                        Amount Paid
                                    </span>

                                    <strong
                                        id="orderAmountPaid"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <div class="purchase-summary-row">

                                    <span>
                                        Balance
                                    </span>

                                    <strong
                                        id="orderBalance"
                                    >
                                        0.00
                                    </strong>

                                </div>


                                <div class="purchase-summary-row">

                                    <span>
                                        Change Given
                                    </span>

                                    <strong
                                        id="orderChange"
                                    >
                                        0.00
                                    </strong>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ==================================================
                    Footer
                =================================================== --}}

                <div class="goods-received-modal-footer">

                    <button
                        type="button"
                        class="btn btn-light border"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    @permission('orders.create')

                        <button
                            type="submit"
                            class="btn btn-primary"
                            id="orderSubmitBtn"
                        >

                            <span id="orderSubmitText">
                                Create Order
                            </span>

                            <span
                                class="spinner-border spinner-border-sm d-none"
                                id="orderSubmitSpinner"
                            ></span>

                        </button>

                    @endpermission

                </div>

            </form>

        </div>

    </div>

</div>