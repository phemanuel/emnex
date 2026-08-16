{{-- ==========================================================
    CUSTOMER GROUP CONFIRMATION MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="customerGroupConfirmModal"
    tabindex="-1"
    aria-hidden="true"
>


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">


                <div>

                    <h5
                        class="modal-title"
                        id="customerGroupConfirmTitle"
                    >

                        Confirm Action

                    </h5>


                    <small class="text-muted">

                        Customer Group

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
                            id="customerGroupConfirmIcon"
                        ></i>

                    </div>


                    <div>

                        <div
                            class="fw-semibold mb-1"
                            id="customerGroupConfirmMessage"
                        >

                            Are you sure?

                        </div>


                        <div
                            class="text-muted small"
                            id="customerGroupConfirmDescription"
                        >

                            This action will affect this customer group.

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
                    id="customerGroupConfirmBtn"
                >

                    Confirm

                </button>


            </div>


        </div>


    </div>


</div>