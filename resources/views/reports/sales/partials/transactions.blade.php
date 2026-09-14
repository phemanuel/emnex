{{-- ==========================================================
    SALES REPORT — TRANSACTIONS
========================================================== --}}

<section
    class="sales-report-section sales-report-transactions-section"
    aria-labelledby="salesReportTransactionsHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportTransactionsHeading"
            >
                Transactions
            </h2>

            <p class="sales-report-section-description">
                Review completed sales included in this report.
            </p>
        </div>

        <div class="sales-report-section-count">
            <span id="salesTransactionsCount">
                0 transactions
            </span>
        </div>

    </div>


    <div class="sales-report-table-card">

        <div class="table-responsive">

            <table class="table sales-report-table sales-report-transactions-table">

                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Cashier</th>
                        <th>Branch</th>
                        <th>Payment</th>
                        <th class="text-end">Gross</th>
                        <th class="text-end">Discount</th>
                        <th class="text-end">Tax</th>
                        <th class="text-end">Total</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody id="salesTransactionsTableBody">

                    <tr class="sales-report-table-placeholder">
                        <td colspan="12">
                            <div class="sales-report-inline-empty">
                                <i class="bi bi-receipt"></i>
                                <span>
                                    Transactions will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>


        {{-- ==================================================
            TABLE FOOTER / PAGINATION
        =================================================== --}}
        <div
            class="sales-report-table-footer"
            id="salesTransactionsPagination"
        >
            <div class="sales-report-pagination-info">
                Showing 0 transactions
            </div>

            <div class="sales-report-pagination-controls">
                {{-- JavaScript will populate pagination --}}
            </div>
        </div>

    </div>

</section>