{{-- ==========================================================
    CUSTOMER DELETE CONFIRMATION MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="customerDeleteConfirmModal"
    tabindex="-1"
    aria-hidden="true"
>


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content">


            <div class="modal-header">


                <div>

                    <h5
                        class="modal-title"
                        id="customerDeleteConfirmTitle"
                    >

                        Delete Customer

                    </h5>


                    <small class="text-muted">

                        Customer Management

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
                        class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width:48px;height:48px;"
                    >

                        <i
                            class="bi bi-trash fs-4 text-danger"
                            id="customerDeleteConfirmIcon"
                        ></i>

                    </div>


                    <div>

                        <div
                            class="fw-semibold mb-1"
                            id="customerDeleteConfirmMessage"
                        >

                            Delete customer?

                        </div>


                        <div
                            class="text-muted small"
                            id="customerDeleteConfirmDescription"
                        >

                            This action cannot be undone.

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
                    class="btn btn-danger"
                    id="customerDeleteConfirmBtn"
                >

                    Delete Customer

                </button>


            </div>


        </div>


    </div>


</div>