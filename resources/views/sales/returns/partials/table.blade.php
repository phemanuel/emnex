
{{-- ==========================================================
    Returns Table
=========================================================== --}}

<div id="returns-table-container">


    {{-- ======================================================
        Table Toolbar
    ======================================================= --}}

    <div class="p-4 border-bottom">

        <div class="row g-3 align-items-end">


            {{-- Search --}}

            <div class="col-lg-4">

                <label
                    for="returnsSearch"
                    class="form-label"
                >
                    Search
                </label>

                <div class="input-group">

                    <span class="input-group-text bg-white">

                        <i class="bi bi-search"></i>

                    </span>

                    <input
                        type="text"
                        class="form-control"
                        id="returnsSearch"
                        placeholder="Return no., order no., customer..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- Return Status --}}

            <!-- <div class="col-lg-2">

                <label
                    for="returnsStatusFilter"
                    class="form-label"
                >
                    Return Status
                </label>

                <select
                    class="form-select"
                    id="returnsStatusFilter"
                >

                    <option value="">
                        All
                    </option>

                    <option value="Completed">
                        Completed
                    </option>

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Cancelled">
                        Cancelled
                    </option>

                </select>

            </div> -->


            {{-- Branch --}}

            <div class="col-lg-2">

                <label
                    for="returnsBranchFilter"
                    class="form-label"
                >
                    Branch
                </label>

                <select
                    class="form-select"
                    id="returnsBranchFilter"
                >

                    <option value="">
                        All Branches
                    </option>

                    @foreach ($branches as $branch)

                        <option value="{{ $branch->id }}">
                            {{ $branch->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Date From --}}

            <div class="col-lg-2">

                <label
                    for="returnsDateFrom"
                    class="form-label"
                >
                    From
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="returnsDateFrom"
                >

            </div>


            {{-- Date To --}}

            <div class="col-lg-2">

                <label
                    for="returnsDateTo"
                    class="form-label"
                >
                    To
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="returnsDateTo"
                >

            </div>

        </div>


        {{-- ==================================================
            Active Filters / Reset
        =================================================== --}}

        <div class="d-flex align-items-center justify-content-between mt-3">

            <div
                class="text-muted small"
                id="returnsTableInfo"
            >
                Showing returns
            </div>


            <button
                type="button"
                class="btn btn-light btn-sm"
                id="clearReturnsFilters"
            >

                <i class="bi bi-arrow-counterclockwise me-1"></i>

                Clear Filters

            </button>

        </div>

    </div>


    {{-- ======================================================
        Table
    ======================================================= --}}

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead>

                <tr>

                    <th class="ps-4">
                        Return No.
                    </th>

                    <th>
                        Order No.
                    </th>

                    <th>
                        Customer
                    </th>

                    <th>
                        Order Status
                    </th>

                    <th>
                        Refund Amount
                    </th>

                    <th>
                        Return Status
                    </th>

                    <th>
                        Processed By
                    </th>

                    <th>
                        Date
                    </th>

                    <th class="text-end pe-4">
                        Actions
                    </th>

                </tr>

            </thead>


            {{-- ==================================================
                Loading State
            =================================================== --}}

            <tbody id="returnsTableLoading">

                <tr>

                    <td
                        colspan="9"
                        class="text-center py-5"
                    >

                        <div class="text-muted">

                            <div
                                class="spinner-border spinner-border-sm text-primary mb-3"
                                role="status"
                            >

                                <span class="visually-hidden">
                                    Loading...
                                </span>

                            </div>

                            <div>
                                Loading returns...
                            </div>

                        </div>

                    </td>

                </tr>

            </tbody>


            {{-- ==================================================
                Data
            =================================================== --}}

            <tbody
                id="returnsTableBody"
                class="d-none"
            ></tbody>


            {{-- ==================================================
                Empty State
            =================================================== --}}

            <tbody
                id="returnsTableEmpty"
                class="d-none"
            >

                <tr>

                    <td
                        colspan="9"
                        class="text-center py-5"
                    >

                        <div class="emnex-empty-icon mx-auto mb-3">

                            <i class="bi bi-arrow-counterclockwise"></i>

                        </div>


                        <h6 class="fw-semibold mb-1">
                            No sales returns found
                        </h6>


                        <p class="text-muted small mb-0">

                            There are no sales returns matching your
                            search or selected filters.

                        </p>

                    </td>

                </tr>

            </tbody>


            {{-- ==================================================
                Error State
            =================================================== --}}

            <tbody
                id="returnsTableError"
                class="d-none"
            >

                <tr>

                    <td
                        colspan="9"
                        class="text-center py-5"
                    >

                        <div class="emnex-empty-icon mx-auto mb-3">

                            <i class="bi bi-exclamation-triangle"></i>

                        </div>


                        <h6 class="fw-semibold mb-1">
                            Unable to load returns
                        </h6>


                        <p
                            class="text-muted small mb-3"
                            id="returnsTableErrorMessage"
                        >
                            Something went wrong while loading sales returns.
                        </p>


                        <button
                            type="button"
                            class="btn btn-light btn-sm"
                            id="returnsTableRetry"
                        >

                            <i class="bi bi-arrow-clockwise me-1"></i>

                            Try Again

                        </button>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    {{-- ======================================================
        Pagination
    ======================================================= --}}

    <div
        id="returnsPagination"
        class="px-4 py-3 border-top"
    ></div>

</div>

