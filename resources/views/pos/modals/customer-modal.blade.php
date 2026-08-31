<div
    class="modal fade pos-modal"
    id="posCustomerModal"
    tabindex="-1"
    aria-labelledby="posCustomerModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <div class="pos-modal-heading">

                    <div class="pos-modal-icon">

                        <i class="bi bi-person"></i>

                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="posCustomerModalLabel"
                        >
                            Select Customer
                        </h5>

                        <p class="text-muted small mb-0">
                            Search and attach a customer to this sale.
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


                <div class="pos-modal-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="search"
                        class="form-control"
                        id="pos-customer-search"
                        placeholder="Search customer name or phone..."
                        autocomplete="off"
                    >

                </div>


                <div
                    class="pos-customer-results"
                    id="pos-customer-results"
                >

                    <div class="pos-modal-empty">

                        <i class="bi bi-person-plus"></i>

                        <span>
                            Search for a customer.
                        </span>

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    id="pos-walk-in-customer"
                    data-bs-dismiss="modal"
                >

                    <i class="bi bi-person-walking me-1"></i>

                    Walk-in Customer

                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="pos-new-customer"
                >

                    <i class="bi bi-person-plus me-1"></i>

                    New Customer

                </button>

            </div>

        </div>

    </div>

</div>