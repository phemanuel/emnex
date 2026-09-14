{{-- ==========================================================
    SALES REPORT — PAYMENT PERFORMANCE
========================================================== --}}

<section
    class="sales-report-section"
    aria-labelledby="salesReportPaymentsHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportPaymentsHeading"
            >
                Payment Performance
            </h2>

            <p class="sales-report-section-description">
                Review how customers are paying for completed sales.
            </p>
        </div>

    </div>


    <div class="sales-report-table-card">

        <div class="table-responsive">

            <table class="table sales-report-table">

                <thead>
                    <tr>
                        <th>Payment Method</th>
                        <th class="text-end">Transactions</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end">% of Sales</th>
                    </tr>
                </thead>

                <tbody id="salesPaymentsTableBody">

                    <tr class="sales-report-table-placeholder">
                        <td colspan="4">
                            <div class="sales-report-inline-empty">
                                <i class="bi bi-credit-card"></i>
                                <span>
                                    Payment performance will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</section>