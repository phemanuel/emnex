{{-- ==========================================================
STOCK MOVEMENT INSPECTOR
=========================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="stockMovementInspector"
    aria-labelledby="stockMovementInspectorLabel"
>

{{-- ======================================================
    HEADER
======================================================= --}}

<div class="offcanvas-header">

    <div>

        <h5
            class="offcanvas-title"
            id="stockMovementInspectorLabel"
        >
            Stock Movement
        </h5>

        <small
            class="text-muted"
            id="stockMovementInspectorReference"
        >
            -
        </small>

    </div>


    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="offcanvas"
        aria-label="Close"
    ></button>

</div>


<div class="offcanvas-body">

    {{-- ==================================================
        LOADING
    =================================================== --}}

    <div
        id="stockMovementInspectorLoading"
        class="text-center py-5 d-none"
    >

        <div
            class="spinner-border text-primary"
            role="status"
        ></div>

        <p class="text-muted small mt-3 mb-0">
            Loading movement details...
        </p>

    </div>


    {{-- ==================================================
        ERROR
    =================================================== --}}

    <div
        id="stockMovementInspectorError"
        class="text-center py-5 d-none"
    >

        <div class="text-danger fs-2 mb-3">

            <i class="bi bi-exclamation-circle"></i>

        </div>

        <h6>
            Unable to Load Movement
        </h6>

        <p
            class="text-muted small mb-0"
            id="stockMovementInspectorErrorMessage"
        >
            Unable to load movement details.
        </p>

    </div>


    {{-- ==================================================
        CONTENT
    =================================================== --}}

    <div id="stockMovementInspectorContent">

        {{-- ==================================================
            MOVEMENT SUMMARY
        =================================================== --}}

        <div class="mb-4">

            <div class="d-flex align-items-center gap-3">

                <div
                    class="st-history-header-icon"
                    id="stockMovementInspectorIcon"
                >

                    <i class="bi bi-arrow-left-right"></i>

                </div>


                <div>

                    <h6
                        class="mb-1"
                        id="stockMovementInspectorType"
                    >
                        -
                    </h6>

                    <small
                        class="text-muted"
                        id="stockMovementInspectorDate"
                    >
                        -
                    </small>

                </div>

            </div>

        </div>


        {{-- ==================================================
            TRANSFER ROUTE
        =================================================== --}}

        <div
            id="stockMovementTransferRoute"
            class="mb-4 d-none"
        >

            <div class="card border-0 bg-light">

                <div class="card-body">

                    {{-- FROM --}}

                    <div class="mb-3">

                        <small
                            class="text-muted d-block mb-1"
                        >
                            From
                        </small>

                        <div
                            class="d-flex align-items-center gap-2"
                        >

                            <span class="text-primary">

                                <i class="bi bi-building"></i>

                            </span>

                            <strong
                                id="stockMovementInspectorSourceBranch"
                            >
                                -
                            </strong>

                        </div>

                    </div>


                    {{-- ROUTE ARROW --}}

                    <div
                        class="d-flex align-items-center gap-2 text-muted my-2"
                    >

                        <div
                            style="
                                width: 1px;
                                height: 20px;
                                background: #d1d5db;
                                margin-left: 5px;
                            "
                        ></div>

                        <i class="bi bi-arrow-down"></i>

                    </div>


                    {{-- TO --}}

                    <div>

                        <small
                            class="text-muted d-block mb-1"
                        >
                            To
                        </small>

                        <div
                            class="d-flex align-items-center gap-2"
                        >

                            <span class="text-success">

                                <i class="bi bi-building"></i>

                            </span>

                            <strong
                                id="stockMovementInspectorDestinationBranch"
                            >
                                -
                            </strong>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            NORMAL BRANCH
        =================================================== --}}

        <div
            id="stockMovementInspectorBranchSection"
            class="mb-3"
        >

            <small
                class="text-muted d-block mb-1"
            >
                Branch
            </small>

            <div
                class="d-flex align-items-center gap-2"
            >

                <span class="text-primary">

                    <i class="bi bi-building"></i>

                </span>

                <strong
                    id="stockMovementInspectorBranch"
                >
                    -
                </strong>

            </div>

        </div>


        {{-- ==================================================
            PRODUCT
        =================================================== --}}

        <div class="card border-0 bg-light mb-3">

            <div class="card-body">

                <div
                    class="d-flex align-items-start gap-3"
                >

                    <div
                        class="st-history-header-icon"
                    >

                        <i class="bi bi-box-seam"></i>

                    </div>


                    <div class="flex-grow-1">

                        <small
                            class="text-muted d-block mb-1"
                        >
                            Product
                        </small>

                        <strong
                            id="stockMovementInspectorProduct"
                            class="d-block"
                        >
                            -
                        </strong>

                        <small
                            class="text-muted d-block mt-1"
                            id="stockMovementInspectorSku"
                        >
                            -
                        </small>

                    </div>

                </div>


                <div
                    class="row g-3 mt-2"
                >

                    <div class="col-6">

                        <small
                            class="text-muted d-block"
                        >
                            Category
                        </small>

                        <span
                            id="stockMovementInspectorCategory"
                        >
                            -
                        </span>

                    </div>


                    <div class="col-6">

                        <small
                            class="text-muted d-block"
                        >
                            Unit
                        </small>

                        <span
                            id="stockMovementInspectorUnit"
                        >
                            -
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            MOVEMENT VALUES
        =================================================== --}}

        <div class="row g-3 mb-3">

            {{-- QUANTITY --}}

            <div class="col-6">

                <div
                    class="card border-0 bg-light h-100"
                >

                    <div class="card-body">

                        <small
                            class="text-muted d-block mb-1"
                        >
                            Quantity
                        </small>

                        <strong
                            id="stockMovementInspectorQuantity"
                            class="fs-5"
                        >
                            -
                        </strong>

                    </div>

                </div>

            </div>


            {{-- BALANCE AFTER --}}

            <div class="col-6">

                <div
                    class="card border-0 bg-light h-100"
                >

                    <div class="card-body">

                        <small
                            class="text-muted d-block mb-1"
                        >
                            Balance After
                        </small>

                        <strong
                            id="stockMovementInspectorBalance"
                            class="fs-5"
                        >
                            -
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==================================================
            UNIT COST
        =================================================== --}}

        <div class="card border-0 bg-light mb-3">

            <div class="card-body">

                <small
                    class="text-muted d-block mb-1"
                >
                    Unit Cost
                </small>

                <strong
                    id="stockMovementInspectorUnitCost"
                >
                    -
                </strong>

            </div>

        </div>


        {{-- ==================================================
            CREATED BY
        =================================================== --}}

        <div class="mb-3">

            <small
                class="text-muted d-block mb-1"
            >
                Created By
            </small>

            <div
                class="d-flex align-items-center gap-2"
            >

                <span
                    class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                    style="
                        width: 32px;
                        height: 32px;
                    "
                >

                    <i class="bi bi-person"></i>

                </span>

                <strong
                    id="stockMovementInspectorCreatedBy"
                >
                    -
                </strong>

            </div>

        </div>


        {{-- ==================================================
            REMARKS
        =================================================== --}}

        <div class="mb-3">

            <small
                class="text-muted d-block mb-1"
            >
                Remarks
            </small>

            <div
                class="p-3 rounded bg-light"
                id="stockMovementInspectorRemarks"
            >
                -
            </div>

        </div>

    </div>

</div>


</div>
