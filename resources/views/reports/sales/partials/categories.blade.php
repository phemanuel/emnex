{{-- ==========================================================
    SALES REPORT — CATEGORY PERFORMANCE
========================================================== --}}

<section
    class="sales-report-section"
    aria-labelledby="salesReportCategoriesHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportCategoriesHeading"
            >
                Category Performance
            </h2>

            <p class="sales-report-section-description">
                Compare sales performance across product categories.
            </p>
        </div>

    </div>


    <div class="sales-report-table-card">

        <div class="table-responsive">

            <table class="table sales-report-table">

                <thead>
                    <tr>
                        <th>Category</th>
                        <th class="text-end">Products</th>
                        <th class="text-end">Units Sold</th>
                        <th class="text-end">Orders</th>
                        <th class="text-end">Gross Sales</th>
                        <th class="text-end">Discount</th>
                        <th class="text-end">Net Sales</th>
                        <th class="text-end">% of Sales</th>
                    </tr>
                </thead>

                <tbody id="salesCategoriesTableBody">

                    <tr class="sales-report-table-placeholder">
                        <td colspan="8">
                            <div class="sales-report-inline-empty">
                                <i class="bi bi-grid"></i>
                                <span>
                                    Category performance will appear here.
                                </span>
                            </div>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</section>