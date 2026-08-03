<!-- =====================================================
    DELETE UNIT MODAL
====================================================== -->

<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-hidden="true"
>


    <div class="modal-dialog modal-dialog-centered">


        <div class="modal-content emnex-modal border-0 shadow-lg">


            <!-- ==========================================
                Header
            =========================================== -->

            <div class="modal-header border-0 pb-0">


                <div class="d-flex align-items-center">


                    <div class="modal-icon bg-danger-subtle text-danger me-3">

                        <i class="bi bi-trash3"></i>

                    </div>


                    <div>


                        <h5 class="modal-title mb-1">

                            Delete Unit

                        </h5>


                        <small class="text-muted">

                            This action requires confirmation.

                        </small>


                    </div>


                </div>



                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>


            </div>





            <!-- ==========================================
                Body
            =========================================== -->

            <div class="modal-body pt-4">


                <input
                    type="hidden"
                    id="deleteUnitId"
                >



                <div class="text-center">


                    <div class="delete-circle mb-4">


                        <i class="bi bi-exclamation-triangle-fill"></i>

                    </div>



                    <h5 class="mb-3">

                        Delete this Unit?

                    </h5>



                    <p class="text-muted mb-2">

                        You are about to delete

                    </p>



                    <h5
                        class="fw-bold text-dark"
                        id="deleteUnitName"
                    >

                        Unit Name

                    </h5>



                    <div class="alert alert-warning mt-4 mb-0 text-start">


                        <div class="d-flex">


                            <i class="bi bi-info-circle me-2 mt-1"></i>


                            <div>


                                <strong>

                                    What happens next?

                                </strong>


                                <ul class="mb-0 mt-2 ps-3">


                                    <li>

                                        The unit will be <strong>soft deleted</strong>.

                                    </li>


                                    <li>

                                        It can be restored automatically if created again.

                                    </li>


                                    <li>

                                        Existing records using this unit will remain intact.

                                    </li>


                                </ul>


                            </div>


                        </div>


                    </div>


                </div>


            </div>





            <!-- ==========================================
                Footer
            =========================================== -->

            <div class="modal-footer border-0 justify-content-center">


                <button
                    type="button"
                    class="btn btn-light px-4"
                    data-bs-dismiss="modal"
                >

                    Cancel

                </button>



                <button
                    type="button"
                    class="btn btn-danger px-4"
                    id="confirmDeleteBtn"
                >

                    <i class="bi bi-trash3 me-2"></i>

                    Delete Unit

                </button>


            </div>


        </div>


    </div>


</div>