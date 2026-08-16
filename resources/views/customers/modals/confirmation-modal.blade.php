{{-- ==========================================================
    CUSTOMER CONFIRMATION MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="customerConfirmModal"
    tabindex="-1"
    aria-hidden="true"
>


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">


                <div>

                    <h5
                        class="modal-title"
                        id="customerConfirmTitle"
                    >

                        Confirm Action

                    </h5>


                    <small class="text-muted">

                        Customer

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>


            <div class="modal-body">


                <div class="d-flex gap-3 align-items-start">


                    <div
                        class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:48px;height:48px;"
                    >

                        <i
                            class="bi bi-question-circle fs-4"
                            id="customerConfirmIcon"
                        ></i>

                    </div>


                    <div>

                        <div
                            class="fw-semibold mb-1"
                            id="customerConfirmMessage"
                        >

                            Are you sure?

                        </div>


                        <div
                            class="text-muted small"
                            id="customerConfirmDescription"
                        >

                            This action will affect this customer.

                        </div>

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
                    id="customerConfirmBtn"
                >

                    Confirm

                </button>


            </div>


        </div>


    </div>


</div>