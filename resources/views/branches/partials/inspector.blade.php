<div class="branch-inspector" id="branchInspector">


    <div class="branch-inspector-header">

    <div>

        <h5>
            Branch Details
        </h5>

        <small>
            Branch information and operations
        </small>

    </div>


    <button class="inspector-close" id="closeBranchInspector">

        <i class="bi bi-x-lg"></i>

    </button>


</div>



<div class="branch-inspector-body">


    {{-- Branch Hero --}}

    <div class="branch-profile">


        <div class="branch-profile-icon">

            <i class="bi bi-shop"></i>

        </div>


        <div>

            <h4 id="inspectorBranchName">
                --
            </h4>


            <span id="inspectorBranchCode">
                --
            </span>

        </div>


    </div>



    {{-- Status --}}

    <div class="inspector-status mt-3">

        <span id="inspectorBranchStatus">
            --
        </span>

    </div>



    {{-- Information --}}

    <div class="inspector-section">


        <h6>
            Branch Information
        </h6>



        <div class="inspector-grid">


            <div>

                <label>
                    Phone
                </label>

                <strong id="inspectorPhone">
                    --
                </strong>

            </div>


            <div>

                <label>
                    Email
                </label>

                <strong id="inspectorEmail">
                    --
                </strong>

            </div>


            <div class="full">

                <label>
                    Address
                </label>

                <strong id="inspectorAddress">
                    --
                </strong>

            </div>


        </div>


    </div>



    {{-- Statistics --}}

    <div class="inspector-section">


        <h6>
            Operations
        </h6>


        <div class="inspector-kpis">


            <button
                class="inspector-kpi-card branch-preview-btn"
                data-type="users">

                <span>

                    <i class="bi bi-people"></i>

                    Users

                </span>


                <b id="inspectorUsers">
                    0
                </b>


                <small>
                    View
                </small>


            </button>




            <button
                class="inspector-kpi-card branch-preview-btn"
                data-type="terminals">

                <span>

                    <i class="bi bi-display"></i>

                    Terminals

                </span>


                <b id="inspectorTerminals">
                    0
                </b>


                <small>
                    View
                </small>


            </button>




            <button
                class="inspector-kpi-card branch-preview-btn"
                data-type="orders">

                <span>

                    <i class="bi bi-receipt"></i>

                    Orders

                </span>


                <b id="inspectorOrders">
                    0
                </b>


                <small>
                    View
                </small>


            </button>


            <button
                class="inspector-kpi-card branch-preview-btn"
                data-type="customers">

                <span>

                    <i class="bi bi-person-heart"></i>

                    Customers

                </span>


                <b id="inspectorCustomers">
                    0
                </b>


                <small>
                    View
                </small>


            </button>


        </div>


    </div>


</div>



<div class="branch-inspector-footer">

    <div class="d-flex gap-2">


        @permission('branches.update')

        <button
            class="btn btn-primary flex-fill"
            id="panelEditBranch">

            <i class="bi bi-pencil-square"></i>

            Edit

        </button>

        @endpermission


        @permission('branches.update')

        <button
            class="btn btn-outline-warning flex-fill"
            id="panelToggleBranchStatus">

            <i class="bi bi-pause-circle"></i>

            Disable

        </button>

        @endpermission


        @permission('branches.delete')

        <button
            class="btn btn-outline-danger flex-fill"
            id="panelDeleteBranch">

            <i class="bi bi-trash"></i>

            Delete

        </button>

        @endpermission


    </div>

</div>


</div>



<div class="branch-inspector-overlay" id="branchInspectorOverlay"></div>