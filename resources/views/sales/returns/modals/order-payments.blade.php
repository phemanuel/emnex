
{{-- ==========================================================
    Order Payments Modal
=========================================================== --}}

<div
    class="modal fade"
    id="orderPaymentsModal"
    tabindex="-1"
    aria-labelledby="orderPaymentsModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable returns-payment-modal-dialog">

        <div class="modal-content">


            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title mb-1"
                        id="orderPaymentsModalLabel"
                    >
                        Order Payments
                    </h5>

                    <p
                        class="text-muted small mb-0"
                        id="orderPaymentsSubtitle"
                    >
                        Review payments before processing the refund.
                    </p>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ==================================================
                Body
            =================================================== --}}

            <div class="modal-body">


                {{-- ==================================================
                    Order Summary
                =================================================== --}}

                <div class="card bg-light border-0 mb-4">

                    <div class="card-body">

                        <div class="row g-3">


                            <div class="col-md-4">

                                <span class="text-muted small d-block">
                                    Order No.
                                </span>

                                <strong id="refundOrderNumber">
                                    —
                                </strong>

                            </div>


                            <div class="col-md-4">

                                <span class="text-muted small d-block">
                                    Invoice No.
                                </span>

                                <strong id="refundInvoiceNumber">
                                    —
                                </strong>

                            </div>


                            <div class="col-md-4">

                                <span class="text-muted small d-block">
                                    Customer
                                </span>

                                <strong id="refundCustomer">
                                    —
                                </strong>

                            </div>


                            <div class="col-md-4">

                                <span class="text-muted small d-block">
                                    Order Status
                                </span>

                                <span
                                    id="orderPaymentOrderStatus"
                                    class="badge"
                                >
                                    —
                                </span>

                            </div>


                            <div class="col-md-4">

                                <span class="text-muted small d-block">
                                    Payment Status
                                </span>

                                <span
                                    id="orderPaymentPaymentStatus"
                                    class="badge"
                                >
                                    —
                                </span>

                            </div>


                            <div class="col-md-4">

                                <span class="text-muted small d-block">
                                    Branch
                                </span>

                                <strong id="refundBranch">
                                    —
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


              
            {{-- ==================================================
                Financial Summary
            =================================================== --}}

           
            <div class="row g-3 mb-4">


                {{-- Order Total --}}

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <span class="text-muted small d-block mb-1">
                            Order Total
                        </span>

                        <strong
                            class="fs-5"
                            id="refundOrderTotal"
                        >
                            {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                        </strong>

                    </div>

                </div>


                {{-- Discount --}}

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <span class="text-muted small d-block mb-1">
                            Discount
                        </span>

                        <strong
                            class="fs-5"
                            id="refundDiscount"
                        >
                            0%
                        </strong>

                    </div>

                </div>


                {{-- Tax --}}

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <span class="text-muted small d-block mb-1">
                            Tax
                        </span>

                        <strong
                            class="fs-5"
                            id="refundTax"
                        >
                            0%
                        </strong>

                    </div>

                </div>


                {{-- Amount Paid --}}

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <span class="text-muted small d-block mb-1">
                            Amount Paid
                        </span>

                        <strong
                            class="fs-5"
                            id="refundAmountPaid"
                        >
                            {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                        </strong>

                    </div>

                </div>


                {{-- Change Given --}}

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <span class="text-muted small d-block mb-1">
                            Change Given
                        </span>

                        <strong
                            class="fs-5"
                            id="refundChangeGiven"
                        >
                            {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                        </strong>

                    </div>

                </div>


                {{-- Balance --}}

                <div class="col-md-4">

                    <div class="border rounded p-3">

                        <span class="text-muted small d-block mb-1">
                            Balance
                        </span>

                        <strong
                            class="fs-5"
                            id="refundBalance"
                        >
                            {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                        </strong>

                    </div>

                </div>


            </div>






                {{-- ==================================================
                    Payments
                =================================================== --}}

                <div class="mb-2">

                    <h6 class="fw-semibold mb-1">
                        Payments
                    </h6>

                    <p class="text-muted small mb-0">
                        All payments associated with this order will be refunded.
                    </p>

                </div>


                <div class="table-responsive border rounded">

                    <table
                        class="table align-middle mb-0"
                        id="orderPaymentsTable"
                    >

                        <thead class="table-light">

                            <tr>

                                <th>
                                    Payment No.
                                </th>

                                <th>
                                    Method
                                </th>

                                <th>
                                    Reference
                                </th>

                                <th>
                                    Amount
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Date
                                </th>

                            </tr>

                        </thead>


                        <tbody id="orderPaymentsTableBody">

                            {{-- Populated by JavaScript --}}

                        </tbody>

                    </table>

                </div>


                {{-- ==================================================
                    Loading
                =================================================== --}}

                <div
                    id="orderPaymentsLoading"
                    class="d-none text-center py-4"
                >

                    <div
                        class="spinner-border spinner-border-sm text-primary mb-2"
                        role="status"
                    >

                        <span class="visually-hidden">
                            Loading...
                        </span>

                    </div>

                    <div class="text-muted small">
                        Loading payments...
                    </div>

                </div>


                {{-- ==================================================
                    Empty State
                =================================================== --}}

                <div
                    id="orderPaymentsEmpty"
                    class="d-none text-center py-4"
                >

                    <div class="text-muted small">

                        <i class="bi bi-credit-card fs-4 d-block mb-2"></i>

                        No payments found for this order.

                    </div>

                </div>

            </div>


            {{-- ==================================================
                Footer
            =================================================== --}}

            <div class="modal-footer">

                <div class="me-auto">

                    <span class="text-muted small d-block">
                        Total Amount to Refund
                    </span>

                  
                    <strong
                        class="fs-5"
                        id="totalRefundAmount"
                    >
                        {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                    </strong>



                </div>


                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                @permission('returns.create')

                    <button
                        type="button"
                        class="btn btn-primary"
                        id="processRefundButton"
                    >

                        <i class="bi bi-arrow-counterclockwise me-2"></i>

                        Process Refund

                    </button>

                @endpermission

            </div>

        </div>

    </div>

</div>

