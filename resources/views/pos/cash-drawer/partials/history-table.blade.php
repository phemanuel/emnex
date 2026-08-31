<div class="emnex-card cash-drawer-table-card mb-4">

    <div class="cash-drawer-table-header">

        <div>

            <h6 class="cash-drawer-table-title">
                Drawer History
            </h6>

            <p class="cash-drawer-table-description">
                Previous cash drawer sessions and reconciliation results.
            </p>

        </div>


        <div class="cash-drawer-table-tools">

            <div class="cash-drawer-search history-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    class="form-control"
                    id="drawer-history-search"
                    placeholder="Search drawer history..."
                >

            </div>

        </div>

    </div>


    <div class="cash-drawer-table-wrapper">

        <table
            class="table cash-drawer-table align-middle mb-0"
            id="cash-drawer-history-table"
        >

            <thead>

                <tr>
                                        
                    <th>Drawer Opened By</th>
                    <th>Opened At</th>
                    <th>Opening</th>
                    <th>Expected</th>
                    <th>Actual</th>
                    <th>Variance</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>

                </tr>

            </thead>


            <tbody id="cash-drawer-history-body">

                <tr>

                    <td
                        colspan="9"
                        class="cash-drawer-empty-state"
                    >

                        <div class="empty-state-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <strong>
                            No drawer history found
                        </strong>

                        <span>
                            Completed drawer sessions will appear here.
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    <div
        class="cash-drawer-pagination"
        id="drawer-history-pagination"
    ></div>

</div>