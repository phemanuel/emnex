<div
    class="current-drawer-card"
    id="drawer-summary-card"
>

    <div class="current-drawer-card-inner">

        <div class="current-drawer-main">

            <div class="current-drawer-icon">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="current-drawer-context">

                <div class="current-drawer-label">
                    CURRENT DRAWER
                </div>

                <div
                    class="current-drawer-terminal"
                    id="drawer-terminal-name"
                >
                    {{ $currentTerminal?->terminal_name ?? 'No terminal assigned' }}
                </div>

                <div
                    class="current-drawer-branch"
                    id="drawer-branch-name"
                >
                    {{ $currentBranch?->name ?? '—' }}
                </div>

            </div>

        </div>


        <div class="current-drawer-divider"></div>


        <div class="current-drawer-meta">

            <div class="drawer-meta-item">

                <span class="drawer-meta-label">
                    Opened By
                </span>

                <strong
                    class="drawer-meta-value"
                    id="drawer-opened-by"
                >
                    {{ $currentDrawer?->openedBy?->name ?? '—' }}
                </strong>

                <span
                    class="drawer-meta-secondary"
                    id="drawer-opened-at"
                >
                    {{ $currentDrawer?->opened_at?->format('d M Y, h:i A') ?? '—' }}
                </span>

            </div>


            <div class="drawer-meta-item">

                <span class="drawer-meta-label">
                    Opening Balance
                </span>

                <strong
                    class="drawer-meta-value drawer-meta-amount"
                    id="drawer-opening-balance"
                >
                    ₦{{ number_format($currentDrawer?->opening_balance ?? 0, 2) }}
                </strong>

            </div>


            <div class="drawer-meta-item drawer-meta-current">

                <span class="drawer-meta-label">
                    Current Cash Balance
                </span>

                <strong
                    class="drawer-meta-value drawer-meta-amount"
                    id="hero-current-balance"
                >
                    ₦0.00
                </strong>

            </div>

        </div>


        <div class="current-drawer-actions">

            @if(canAccess('pos.cash_drawer'))

                <button
                    type="button"
                    class="btn cash-drawer-operation-btn cash-drawer-operation-in d-none"
                    id="hero-cash-in-btn"
                >
                    <i class="bi bi-arrow-down-circle"></i>
                    Cash In
                </button>

                <button
                    type="button"
                    class="btn cash-drawer-operation-btn cash-drawer-operation-out d-none"
                    id="hero-cash-out-btn"
                >
                    <i class="bi bi-arrow-up-circle"></i>
                    Cash Out
                </button>

                <button
                    type="button"
                    class="btn cash-drawer-operation-btn cash-drawer-operation-close d-none"
                    id="close-drawer-btn"
                >
                    <i class="bi bi-box-arrow-right"></i>
                    Close Drawer
                </button>

            @endif

        </div>

    </div>

</div>