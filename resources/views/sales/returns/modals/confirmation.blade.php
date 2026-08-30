
{{-- ==========================================================
    Refund Confirmation Modal
=========================================================== --}}

<div
    class="modal fade"
    id="refundConfirmationModal"
    tabindex="-1"
    aria-labelledby="refundConfirmationModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">


            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="refundConfirmationModalLabel"
                >
                    Process Refund
                </h5>


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

                <div class="text-center mb-4">

                    <div class="emnex-confirmation-icon mx-auto mb-3">

                        <i class="bi bi-arrow-counterclockwise"></i>

                    </div>


                    <h6 class="fw-semibold mb-2">
                        Process this refund?
                    </h6>


                    <p class="text-muted small mb-0">

                        You are about to refund all payments associated
                        with this order.

                    </p>

                </div>


                {{-- ==================================================
                    Refund Summary
                =================================================== --}}

                <div class="border rounded p-3 mb-4">

                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Order No.
                        </span>

                        <strong id="confirmationOrderNumber">
                            —
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-2">

                        <span class="text-muted">
                            Order Status
                        </span>

                        <strong id="confirmationOrderStatus">
                            —
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Refund Amount
                        </span>

                       
                        <strong
                            id="confirmationRefundAmount"
                            class="text-danger"
                        >
                            {{ \App\Helpers\CurrencyHelper::symbol() }}0.00
                        </strong>



                    </div>

                </div>


                {{-- ==================================================
                    Warning
                =================================================== --}}

                <div class="alert alert-warning mb-0">

                    <div class="d-flex">

                        <i class="bi bi-exclamation-triangle me-2 mt-1"></i>

                        <div class="small">

                            <strong>
                                Please confirm this action.
                            </strong>

                            <div class="mt-1">

                                The associated payments will be marked as
                                refunded and the order and invoice statuses
                                will be updated.

                                If this is a completed order, the sold
                                quantities will also be returned to stock.

                                Held orders will not affect stock.

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ==================================================
                Footer
            =================================================== --}}

            <div class="modal-footer">

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
                        class="btn btn-danger"
                        id="confirmProcessRefundButton"
                    >

                        <i class="bi bi-arrow-counterclockwise me-2"></i>

                        Yes, Process Refund

                    </button>

                @endpermission

            </div>

        </div>

    </div>

</div>

