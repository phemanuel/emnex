{{-- ==========================================================
    SALES REPORT — PRODUCT PERFORMANCE
========================================================== --}}

<section
    class="sales-report-section"
    aria-labelledby="salesReportProductsHeading"
>

    <div class="sales-report-section-header">

        <div>
            <h2
                class="sales-report-section-title"
                id="salesReportProductsHeading"
            >
                Product Performance
            </h2>

            <p class="sales-report-section-description">
                Identify your best-performing products by units and sales.
            </p>
        </div>

        <div class="sales-report-section-count">
            <span id="salesProductsCount">
                0 products
            </span>
        </div>

    </div>


    <div class="sales-report-table-card">

        <div class="table-responsive">
            <table class="table align-middle mb-0" id="product-performance-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th class="text-end">Units Sold</th>
                        <th class="text-end">Revenue</th>
                        <th class="text-end">COGS</th>
                        <th class="text-end">Gross Profit</th>
                        <th class="text-end">Margin</th>
                    </tr>
                </thead>

                <tbody id="product-performance-body">
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No product sales found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</section>