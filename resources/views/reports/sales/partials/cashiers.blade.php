{{-- ==========================================================
    SALES REPORT — CASHIER PERFORMANCE
========================================================== --}}

<section
    class="sales-report-section"
    aria-labelledby="salesReportCashiersHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportCashiersHeading"
            >
                Cashier Performance
            </h2>

            <p class="sales-report-section-description">
                Compare completed sales handled by each cashier.
            </p>
        </div>

    </div>


    <div class="sales-report-table-card">

        <div class="table-responsive">

            <table class="table sales-report-table">

                <thead>
                    <tr>
                        <th>Salesperson</th>
                        <th class="text-end">Transactions</th>
                        <th class="text-end">Sales</th>
                        <th class="text-end">Average Sale</th>
                        <th class="text-end">Share</th>
                    </tr>
                </thead>

                <tbody id="salesCashiersTableBody">

                    <tr class="sales-report-table-placeholder">
                        <td colspan="5">
                            <div class="sales-report-inline-empty">
                                <i class="bi bi-person-badge"></i>
                                <span>
                                    Cashier performance will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</section>