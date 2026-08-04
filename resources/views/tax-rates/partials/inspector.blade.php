<!-- =====================================================
    TAX RATE INSPECTOR
====================================================== -->

<div
    class="offcanvas offcanvas-end inspector-offcanvas"
    tabindex="-1"
    id="taxRateInspector"
>

    <!-- ==========================================
        Header
    =========================================== -->

    <div class="offcanvas-header inspector-header">

        <div>

            <h4 class="offcanvas-title mb-1">

                Tax Rate Details

            </h4>

            <p class="text-muted mb-0">

                View tax rate information.

            </p>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
        ></button>

    </div>

    <!-- ==========================================
        Body
    =========================================== -->

    <div class="offcanvas-body p-0">

        <div id="taxRateInspectorContent">

            <!-- ==========================================
                Loading
            =========================================== -->

            <div class="inspector-loading">

                <div
                    class="spinner-border text-primary"
                    role="status"
                ></div>

                <h6 class="mt-4">

                    Loading Tax Rate...

                </h6>

                <p class="text-muted mb-0">

                    Please wait while we retrieve the details.

                </p>

            </div>

        </div>

    </div>

</div>