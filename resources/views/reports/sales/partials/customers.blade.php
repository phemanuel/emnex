{{-- ==========================================================
    SALES REPORT — CUSTOMER PERFORMANCE
========================================================== --}}

<section
    class="sales-report-section"
    aria-labelledby="salesReportCustomersHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportCustomersHeading"
            >
                Customer Performance
            </h2>

            <p class="sales-report-section-description">
                Understand purchasing activity across customers.
            </p>
        </div>

    </div>


    <div class="sales-report-table-card">

        <div class="table-responsive">

            <table class="table sales-report-table">

                <thead>
                    <tr>
                        <th>Customer</th>
                        <th class="text-end">Transactions</th>
                        <th class="text-end">Items</th>
                        <th class="text-end">Sales</th>
                        <th class="text-end">Average Order</th>
                    </tr>
                </thead>

                <tbody id="salesCustomersTableBody">

                    <tr class="sales-report-table-placeholder">
                        <td colspan="5">
                            <div class="sales-report-inline-empty">
                                <i class="bi bi-people"></i>
                                <span>
                                    Customer performance will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</section>