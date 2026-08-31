<div
    class="cash-operations-card cash-operations-sticky"
    id="cash-actions-card"
>

    <input
        type="checkbox"
        id="cash-operations-toggle"
        class="cash-operations-toggle-input"
    >

    <label
        for="cash-operations-toggle"
        class="cash-operations-header"
    >

        <div class="cash-operations-heading">

            <div class="cash-operations-icon">

                <i class="bi bi-arrow-left-right"></i>

            </div>

            <div>

                <h6 class="cash-operations-title">

                    Cash Operations

                </h6>

                <p class="cash-operations-description mb-0">

                    Quick cash movements

                </p>

            </div>

        </div>

        <i class="bi bi-chevron-up cash-operations-toggle-icon"></i>

    </label>


    <div class="cash-operations-body">

        @if(canAccess('pos.cash_drawer'))

            <button
                type="button"
                class="cash-operation-tile cash-operation-tile-in"
                id="cash-in-btn"
                disabled
            >

                <span class="cash-operation-tile-icon">

                    <i class="bi bi-arrow-down"></i>

                </span>

                <span class="cash-operation-tile-content">

                    <strong>
                        Cash In
                    </strong>

                    <small>
                        Add cash
                    </small>

                </span>

                <i class="bi bi-chevron-right cash-operation-arrow"></i>

            </button>


            <button
                type="button"
                class="cash-operation-tile cash-operation-tile-out"
                id="cash-out-btn"
                disabled
            >

                <span class="cash-operation-tile-icon">

                    <i class="bi bi-arrow-up"></i>

                </span>

                <span class="cash-operation-tile-content">

                    <strong>
                        Cash Out
                    </strong>

                    <small>
                        Remove cash
                    </small>

                </span>

                <i class="bi bi-chevron-right cash-operation-arrow"></i>

            </button>

        @endif

    </div>

</div>