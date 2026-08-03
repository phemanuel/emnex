<!-- =====================================================
    ENABLE / DISABLE UNIT MODAL
====================================================== -->

<div
    class="modal fade"
    id="statusModal"
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


                    <div
                        class="modal-icon bg-warning-subtle text-warning me-3"
                        id="statusModalIcon"
                    >

                        <i class="bi bi-power"></i>

                    </div>


                    <div>


                        <h5
                            class="modal-title mb-1"
                            id="statusModalTitle"
                        >

                            Change Status

                        </h5>


                        <small class="text-muted">

                            Confirm this action before continuing.

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
                    id="statusUnitId"
                >


                <input
                    type="hidden"
                    id="statusAction"
                >


                <div class="text-center">


                    <div
                        class="status-circle mb-4"
                        id="statusCircle"
                    >

                        <i
                            class="bi bi-power"
                            id="statusCircleIcon"
                        ></i>

                    </div>



                    <h5
                        class="mb-3"
                        id="statusHeading"
                    >

                        Disable Unit?

                    </h5>



                    <p
                        class="text-muted mb-0"
                        id="statusMessage"
                    >

                        You are about to disable this unit.

                    </p>


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
                    class="btn btn-warning px-4"
                    id="confirmStatusBtn"
                >

                    <i class="bi bi-check-circle me-2"></i>

                    Confirm

                </button>


            </div>


        </div>


    </div>


</div>