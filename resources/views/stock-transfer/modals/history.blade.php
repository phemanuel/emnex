
<div class="modal fade"
     id="stockTransferHistoryModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content stock-transfer-history-modal">


            {{-- ==========================================================
                 HEADER
            =========================================================== --}}

            <div class="modal-header">

                <div>

                    <h5 class="modal-title">

                        <i class="bi bi-clock-history me-2"></i>

                        Transfer History

                    </h5>


                    <small class="text-muted">

                        View stock transfers for this product.

                    </small>

                </div>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>



            {{-- ==========================================================
                 BODY
            =========================================================== --}}

            <div class="modal-body">


                {{-- ======================================================
                     PRODUCT HEADER
                ======================================================= --}}

                <div class="stock-transfer-history-product mb-4">

                    <div class="d-flex align-items-center gap-3">


                        <div
                            class="stock-product-avatar"
                            id="historyProductImage"
                        >

                            <i class="bi bi-box"></i>

                        </div>


                        <div class="flex-grow-1">

                            <h6
                                class="mb-1"
                                id="historyProductName"
                            >

                                Product

                            </h6>


                            <div class="small text-muted">

                                SKU:

                                <span id="historyProductSku">
                                    -
                                </span>

                                <span class="mx-2">
                                    •
                                </span>

                                Category:

                                <span id="historyProductCategory">
                                    -
                                </span>

                            </div>

                        </div>


                        <div class="text-end">

                            <small class="text-muted d-block">

                                Current Head Office Stock

                            </small>


                            <strong
                                class="fs-5"
                                id="historyCurrentStock"
                            >

                                0.00

                            </strong>

                        </div>

                    </div>

                </div>



                {{-- ======================================================
                     FILTERS
                ======================================================= --}}

                <div class="row g-3 mb-4">


                    <div class="col-md-4">

                        <label
                            for="historyBranchFilter"
                            class="form-label"
                        >

                            Branch

                        </label>


                        <select
                            id="historyBranchFilter"
                            class="form-select"
                        >

                            <option value="">

                                All Branches

                            </option>


                            @foreach($branches as $branch)

                                <option value="{{ $branch->id }}">

                                    {{ $branch->displayName() }}

                                </option>

                            @endforeach

                        </select>

                    </div>



                    <div class="col-md-4">

                        <label
                            for="historyDateFrom"
                            class="form-label"
                        >

                            From

                        </label>


                        <input
                            type="date"
                            id="historyDateFrom"
                            class="form-control"
                        >

                    </div>



                    <div class="col-md-4">

                        <label
                            for="historyDateTo"
                            class="form-label"
                        >

                            To

                        </label>


                        <input
                            type="date"
                            id="historyDateTo"
                            class="form-control"
                        >

                    </div>

                </div>



                {{-- ======================================================
                     HISTORY TABLE
                ======================================================= --}}

                <div class="table-responsive">

                    <table class="table align-middle stock-transfer-history-table">

                        <thead>

                            <tr>

                                <th>
                                    Date
                                </th>

                                <th>
                                    Reference
                                </th>

                                <th>
                                    From
                                </th>

                                <th>
                                    To
                                </th>

                                <th>
                                    Quantity
                                </th>

                                <th>
                                    Balance
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Remarks
                                </th>

                            </tr>

                        </thead>


                        <tbody id="stockTransferHistoryTableBody">

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5"
                                >

                                    <div class="text-muted">

                                        <i class="bi bi-clock-history fs-3 d-block mb-2"></i>

                                        Select a product to view transfer history.

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>



                {{-- ======================================================
                     EMPTY STATE
                ======================================================= --}}

                <div
                    id="stockTransferHistoryEmpty"
                    class="stock-empty-state d-none"
                >

                    <i class="bi bi-arrow-left-right"></i>

                    <h6>
                        No transfer history found
                    </h6>

                    <p>
                        No stock transfers have been recorded for this
                        product.
                    </p>

                </div>


            </div>



            {{-- ==========================================================
                 FOOTER
            =========================================================== --}}

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal"
                >

                    Close

                </button>

            </div>


        </div>

    </div>

</div>
