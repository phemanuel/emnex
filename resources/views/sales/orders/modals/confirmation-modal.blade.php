{{-- ==============================================================
    Delete Order Confirmation Modal
============================================================== --}}

<div
    class="modal fade"
    id="deleteOrderConfirmationModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div
    class="modal-dialog modal-dialog-centered delete-order-confirmation-dialog"
>

        <div class="modal-content border-0 shadow-lg">


            {{-- ==================================================
                Header
            =================================================== --}}

            <div class="modal-header">

                <div class="d-flex align-items-center gap-2">

                    <div
                        class="delete-order-confirmation-icon"
                    >

                        <i class="bi bi-trash3"></i>

                    </div>


                    <div>

                        <h5
                            class="modal-title fw-semibold mb-1"
                        >
                            Delete Sales Order
                        </h5>

                        <div
                            class="text-muted small"
                        >
                            This action will remove the order from the active list.
                        </div>

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
                Body
            =================================================== --}}

            <div class="modal-body">

                <p
                    class="mb-3 text-muted small"
                >
                    Are you sure you want to delete this sales order?
                </p>


                <div
                    class="delete-order-confirmation-order"
                >

                    <div>

                        <span class="delete-order-confirmation-label">
                            Sales Order
                        </span>

                        <strong
                            id="deleteOrderConfirmationNumber"
                        >
                            —
                        </strong>

                    </div>


                    <div>

                        <span class="delete-order-confirmation-label">
                            Total
                        </span>

                        <strong
                            id="deleteOrderConfirmationTotal"
                        >
                            0.00
                        </strong>

                    </div>

                </div>


                <div
                    class="alert alert-warning py-2 px-3 mb-0 mt-3"
                >

                    <div class="d-flex gap-2 align-items-start">

                        <i class="bi bi-exclamation-triangle mt-1"></i>

                        <div class="small">

                            The order will no longer appear in the active
                            Sales Orders list.

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
                    class="btn btn-light border"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>


                <button
                    type="button"
                    class="btn btn-danger"
                    id="deleteOrderConfirmationBtn"
                >

                    <span
                        id="deleteOrderConfirmationText"
                    >

                        <i class="bi bi-trash3 me-1"></i>

                        Delete Order

                    </span>


                    <span
                        id="deleteOrderConfirmationSpinner"
                        class="spinner-border spinner-border-sm d-none"
                    ></span>

                </button>

            </div>

        </div>

    </div>

</div>