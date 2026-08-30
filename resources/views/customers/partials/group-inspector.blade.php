{{-- ==========================================================
    CUSTOMER GROUP INSPECTOR
=========================================================== --}}

<div
    class="offcanvas offcanvas-end customer-group-inspector"
    tabindex="-1"
    id="customerGroupInspector"
    aria-labelledby="customerGroupInspectorLabel"
>


    {{-- ======================================================
        HEADER
    ======================================================= --}}

    <div class="offcanvas-header customer-group-inspector-header">


        <div>

            <div class="customer-group-inspector-eyebrow">

                CUSTOMER GROUP

            </div>


            <h5
                class="offcanvas-title"
                id="customerGroupInspectorLabel"
            >

                Group Details

            </h5>

        </div>


        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas"
        ></button>


    </div>


    <div class="offcanvas-body">


        {{-- ==================================================
            GROUP PROFILE
        =================================================== --}}

        <div class="customer-group-profile">


            <div class="customer-group-profile-top">


                <div class="customer-group-inspector-avatar">

                    <i class="bi bi-people"></i>

                </div>


                <div class="customer-group-profile-info">


                    <h4
                        id="customerGroupInspectorName"
                        class="customer-group-profile-name"
                    >

                        -

                    </h4>


                    <div class="customer-group-profile-meta">


                        <span
                            id="customerGroupInspectorCode"
                            class="customer-group-code"
                        >

                            -

                        </span>


                        <span class="customer-group-meta-dot">

                            •

                        </span>


                        <span>

                            Customer Group

                        </span>

                    </div>


                </div>


            </div>


            <div class="customer-group-profile-status">


                <span
                    id="customerGroupInspectorStatus"
                    class="customer-group-status-badge"
                >

                    -

                </span>


            </div>


        </div>


        {{-- ==================================================
            DESCRIPTION
        =================================================== --}}

        <div class="customer-group-inspector-section">


            <div class="customer-group-section-label">

                DESCRIPTION

            </div>


            <div
                id="customerGroupInspectorDescription"
                class="customer-group-description"
            >

                -

            </div>


        </div>


        {{-- ==================================================
            KEY METRICS
        =================================================== --}}

        <div class="customer-group-inspector-section">


            <div class="customer-group-section-label">

                GROUP OVERVIEW

            </div>


            <div class="customer-group-metrics">


                {{-- DISCOUNT --}}

                <div class="customer-group-metric-card">


                    <div class="customer-group-metric-icon">

                        <i class="bi bi-percent"></i>

                    </div>


                    <div>

                        <div class="customer-group-metric-label">

                            Discount

                        </div>


                        <div
                            id="customerGroupInspectorDiscount"
                            class="customer-group-metric-value"
                        >

                            0.00%

                        </div>

                    </div>


                </div>


                {{-- CUSTOMERS --}}

                <div class="customer-group-metric-card">


                    <div class="customer-group-metric-icon">

                        <i class="bi bi-people"></i>

                    </div>


                    <div>

                        <div class="customer-group-metric-label">

                            Customers

                        </div>


                        <div
                            id="customerGroupInspectorCustomers"
                            class="customer-group-metric-value"
                        >

                            0

                        </div>

                    </div>


                </div>


            </div>


        </div>


        {{-- ==================================================
            CREDIT INFORMATION
        =================================================== --}}

        <div class="customer-group-inspector-section">


            <div class="customer-group-section-label">

                CREDIT SETTINGS

            </div>


            <div class="customer-group-credit-card">


                <div class="customer-group-credit-icon">

                    <i class="bi bi-wallet2"></i>

                </div>


                <div class="customer-group-credit-content">


                    <div class="customer-group-metric-label">

                        Credit Limit

                    </div>
              
                    <div
                        id="customerGroupInspectorCreditLimit"
                        class="customer-group-credit-value"
                    >

                        {{ \App\Helpers\CurrencyHelper::symbol() }}0.00

                    </div>




                    <div class="customer-group-credit-description">

                        Maximum credit available to customers in this group.

                    </div>

                </div>


            </div>


        </div>


        {{-- ==================================================
            RECORD INFORMATION
        =================================================== --}}

        <div class="customer-group-inspector-section">


            <div class="customer-group-section-label">

                RECORD INFORMATION

            </div>


            <div class="customer-group-record">


                <div class="customer-group-record-row">


                    <span>

                        Created

                    </span>


                    <strong
                        id="customerGroupInspectorCreated"
                    >

                        -

                    </strong>

                </div>


            </div>


        </div>


    </div>


</div>