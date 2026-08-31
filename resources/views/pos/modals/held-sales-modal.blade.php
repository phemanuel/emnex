<div
    class="modal fade pos-modal"
    id="posHeldSalesModal"
    tabindex="-1"
    aria-labelledby="posHeldSalesModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered modal-xl">

        <div class="modal-content">

            <div class="modal-header">

                <div class="pos-modal-heading">

                    <div class="pos-modal-icon warning">

                        <i class="bi bi-pause-circle"></i>

                    </div>

                    <div>

                        <h5
                            class="modal-title"
                            id="posHeldSalesModalLabel"
                        >
                            Held Sales
                        </h5>

                        <p class="text-muted small mb-0">
                            Retrieve a previously held transaction.
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

                <div class="pos-held-toolbar">

                    <div class="pos-modal-search">

                        <i class="bi bi-search"></i>

                        <input
                            type="search"
                            class="form-control"
                            id="pos-held-sales-search"
                            placeholder="Search held sales..."
                        >

                    </div>

                </div>


                <div
                    class="pos-held-sales-list"
                    id="pos-held-sales-list"
                >

                    <div class="pos-modal-empty">

                        <i class="bi bi-pause-circle"></i>

                        <span>
                            No held sales found.
                        </span>

                    </div>

                </div>


                <div
                    class="pos-held-sales-pagination"
                    id="pos-held-sales-pagination"
                ></div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >

                    Close

                </button>

            </div>

        </div>

    </div>

</div>