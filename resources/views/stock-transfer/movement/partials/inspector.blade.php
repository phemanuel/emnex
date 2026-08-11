{{-- ==========================================================
STOCK MOVEMENT INSPECTOR
=========================================================== --}}

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="stockMovementInspector"
    aria-labelledby="stockMovementInspectorLabel"
>

```
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

    {{-- Loading --}}

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


    {{-- Content --}}

    <div id="stockMovementInspectorContent">

        {{-- Movement Summary --}}

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


        {{-- Product --}}

        <div class="card border-0 bg-light mb-3">

            <div class="card-body">

                <small class="text-muted d-block mb-1">
                    Product
                </small>

                <strong
                    id="stockMovementInspectorProduct"
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


        {{-- Movement Information --}}

        <div class="row g-3 mb-3">

            <div class="col-6">

                <div class="card border-0 bg-light h-100">

                    <div class="card-body">

                        <small class="text-muted d-block">
                            Quantity
                        </small>

                        <strong
                            id="stockMovementInspectorQuantity"
                        >
                            -
                        </strong>

                    </div>

                </div>

            </div>


            <div class="col-6">

                <div class="card border-0 bg-light h-100">

                    <div class="card-body">

                        <small class="text-muted d-block">
                            Balance After
                        </small>

                        <strong
                            id="stockMovementInspectorBalance"
                        >
                            -
                        </strong>

                    </div>

                </div>

            </div>

        </div>


        {{-- Branch --}}

        <div class="mb-3">

            <small class="text-muted d-block mb-1">
                Branch
            </small>

            <strong
                id="stockMovementInspectorBranch"
            >
                -
            </strong>

        </div>


        {{-- Unit Cost --}}

        <div class="mb-3">

            <small class="text-muted d-block mb-1">
                Unit Cost
            </small>

            <strong
                id="stockMovementInspectorUnitCost"
            >
                -
            </strong>

        </div>


        {{-- Created By --}}

        <div class="mb-3">

            <small class="text-muted d-block mb-1">
                Created By
            </small>

            <strong
                id="stockMovementInspectorCreatedBy"
            >
                -
            </strong>

        </div>


        {{-- Remarks --}}

        <div class="mb-3">

            <small class="text-muted d-block mb-1">
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
```

</div>
