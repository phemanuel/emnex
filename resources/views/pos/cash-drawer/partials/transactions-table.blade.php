<div class="emnex-card cash-drawer-table-card mb-4">

    <div class="cash-drawer-table-header">

        <div>

            <h6 class="cash-drawer-table-title">
                Cash Transactions
            </h6>

            <p class="cash-drawer-table-description">
                All cash movements recorded against the current drawer.
            </p>

        </div>


        <div class="cash-drawer-table-tools">

            <div class="cash-drawer-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    class="form-control"
                    id="transaction-search"
                    placeholder="Search transactions..."
                >

            </div>


            <select
                class="form-select"
                id="transaction-type-filter"
            >

                <option value="">
                    All Types
                </option>

                <option value="Sale">
                    Cash Sales
                </option>

                <option value="Cash In">
                    Cash In
                </option>

                <option value="Cash Out">
                    Cash Out
                </option>

                <option value="Refund">
                    Refunds
                </option>

            </select>

        </div>

    </div>


    <div class="cash-drawer-table-wrapper">

        <table
            class="table cash-drawer-table align-middle mb-0"
            id="cash-drawer-transactions-table"
        >

            <thead>

                <tr>                   
                    <th>TransactionType</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Created By</th>
                    <th>Date</th>
                    <th class="text-end">Action</th>

                </tr>

            </thead>

            <tbody id="cash-drawer-transactions-body">

                <tr>

                    <td
                        colspan="8"
                        class="cash-drawer-empty-state"
                    >

                        <div class="empty-state-icon">
                            <i class="bi bi-receipt"></i>
                        </div>

                        <strong>
                            No transactions found
                        </strong>

                        <span>
                            Cash movements will appear here once the drawer is active.
                        </span>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    <div
        class="cash-drawer-pagination"
        id="transactions-pagination"
    ></div>

</div>