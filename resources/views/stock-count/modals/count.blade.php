{{-- ==========================================================
    STOCK COUNTING MODAL
=========================================================== --}}

<div
    class="modal fade"
    id="stockCountCountingModal"
    tabindex="-1"
    aria-labelledby="stockCountCountingModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg">


            {{-- ======================================================
                HEADER
            ======================================================= --}}

            <div class="modal-header stock-count-counting-header border-bottom">

                {{-- ==================================================
                    TITLE
                =================================================== --}}

                <div class="d-flex align-items-center gap-3 min-width-0">

                    <div class="stock-count-counting-icon">

                        <i class="bi bi-clipboard2-check"></i>

                    </div>


                    <div class="min-width-0">

                        <h5
                            class="modal-title fw-semibold mb-1"
                            id="stockCountCountingModalLabel"
                        >
                            Stock Count
                        </h5>

                        <div
                            class="small text-muted text-truncate"
                            id="stockCountCountingReference"
                        >
                            —
                        </div>

                    </div>

                </div>


                {{-- ==================================================
                    TIMER
                =================================================== --}}

                <div class="stock-count-counting-timer">

                    <div class="stock-count-counting-timer-icon">

                        <i class="bi bi-stopwatch"></i>

                    </div>

                    <div>

                        <div class="stock-count-counting-timer-label">
                            Counting Time
                        </div>

                        <div
                            class="stock-count-counting-timer-value"
                            id="stockCountTimer"
                        >
                            00:00:00
                        </div>

                    </div>

                </div>


                {{-- ==================================================
                    CLOSE
                =================================================== --}}

                <button
                    type="button"
                    class="btn-close ms-2"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            {{-- ======================================================
                PROGRESS
            ======================================================= --}}

            <div class="px-4 py-3 border-bottom">

                <div class="d-flex justify-content-between align-items-center mb-2">

                    <div>

                        <span class="small text-muted">
                            Counting Progress
                        </span>

                        <div class="fw-semibold">

                            <span id="stockCountCountedProgress">
                                0
                            </span>

                            /
                            
                            <span id="stockCountTotalProgress">
                                0
                            </span>

                            items counted

                        </div>

                    </div>


                    <div
                        class="fw-semibold"
                        id="stockCountProgressPercentage"
                    >
                        0%
                    </div>

                </div>


                <div
                    class="progress"
                    style="height: 7px;"
                >

                    <div
                        class="progress-bar"
                        id="stockCountProgressBar"
                        role="progressbar"
                        style="width: 0%;"
                    ></div>

                </div>

            </div>


            {{-- ======================================================
                SEARCH
            ======================================================= --}}

            <div class="px-4 py-3 border-bottom">

                <div class="input-group">

                    <span class="input-group-text bg-white">

                        <i class="bi bi-search text-muted"></i>

                    </span>

                    <input
                        type="search"
                        class="form-control"
                        id="stockCountCountingSearch"
                        placeholder="Search product, SKU or barcode..."
                        autocomplete="off"
                    >

                </div>

            </div>


            {{-- ======================================================
                ITEMS
            ======================================================= --}}

            <div class="modal-body p-0">

                <div class="table-responsive">

                    <table
                        class="table align-middle mb-0"
                        id="stockCountCountingTable"
                    >

                        <thead class="table-light">

                            <tr>

                                <th>
                                    Product
                                </th>

                                <th>
                                    SKU
                                </th>

                                <th class="text-end">
                                    System Qty
                                </th>

                                <th
                                    class="text-end"
                                    style="width: 180px;"
                                >
                                    Physical Qty
                                </th>

                                <th class="text-end">
                                    Variance
                                </th>

                            </tr>

                        </thead>


                        <tbody id="stockCountCountingItems">

                            {{-- JavaScript renders snapshot items --}}

                        </tbody>

                    </table>

                </div>


                {{-- Empty state --}}

                <div
                    id="stockCountCountingEmpty"
                    class="text-center py-5 d-none"
                >

                    <div class="stock-count-state-icon mb-2">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <div class="fw-semibold">
                        No Items Found
                    </div>

                    <div class="small text-muted">
                        No stock count items match your search.
                    </div>

                </div>

            </div>


            {{-- ======================================================
                FOOTER
            ======================================================= --}}

            <div class="modal-footer border-top">

                <div class="me-auto">

                    <span class="small text-muted">
                        Total Variance:
                    </span>

                    <strong
                        id="stockCountTotalVariance"
                    >
                        0
                    </strong>

                </div>


                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>


                <button
                    type="button"
                    class="btn btn-success"
                    id="stockCountCompleteButton"
                    disabled
                >

                    <i class="bi bi-check2-circle me-1"></i>

                    Complete Counting

                </button>

            </div>

        </div>

    </div>

</div>