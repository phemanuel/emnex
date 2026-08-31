<div
    class="modal fade pos-modal"
    id="posDiscountModal"
    tabindex="-1"
    aria-labelledby="posDiscountModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div class="pos-modal-heading">

                    <div class="pos-modal-icon">

                        <i class="bi bi-percent"></i>

                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="posDiscountModalLabel"
                        >
                            Apply Discount
                        </h5>

                        <p class="text-muted small mb-0">
                            Select a discount for this sale.
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


            <div class="modal-body">

                <div
                    class="pos-discount-list"
                    id="pos-discount-list"
                >

                    <div class="pos-modal-empty">

                        <i class="bi bi-percent"></i>

                        <span>
                            Loading discounts...
                        </span>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="pos-apply-discount"
                >

                    Apply Discount

                </button>

            </div>

        </div>

    </div>

</div>