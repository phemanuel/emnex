<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        POS | {{ config('app.name', 'EMNEX POS') }}
    </title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

      <link rel="stylesheet" href="{{ asset('assets/css/pos.css') }}">

</head>


<body class="emnex-pos-screen">

    {{-- 
    |--------------------------------------------------------------------------
    | POS Application
    |--------------------------------------------------------------------------
    --}}

    {{-- 
    |--------------------------------------------------------------------------
    | Fullscreen Required Overlay
    |--------------------------------------------------------------------------
    --}}

    <!-- <div
        class="pos-fullscreen-overlay"
        id="pos-fullscreen-overlay"
    >

        <div class="pos-fullscreen-dialog">

            <div class="pos-fullscreen-icon">

                <i class="bi bi-fullscreen"></i>

            </div>


            <h3 class="pos-fullscreen-title">

                Full Screen Required

            </h3>


            <p class="pos-fullscreen-description">

                EMNEX POS is designed to operate in full screen.
                Switch to full screen to continue using the POS.

            </p>


            <button
                type="button"
                class="pos-fullscreen-button"
                id="pos-enter-fullscreen"
            >

                <i class="bi bi-fullscreen me-1"></i>

                Enter Full Screen

            </button>


            <small class="pos-fullscreen-hint">

                Your POS screen will remain locked until
                full screen mode is enabled.

            </small>

        </div>

    </div> -->

    <div
        class="pos-app"
        id="pos-app"
    >

        {{-- 
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        --}}

        <header class="pos-topbar">

            <div class="pos-topbar-left">

                <div class="pos-brand">

                    <div class="pos-brand-mark">

                        <i class="bi bi-cart3"></i>

                    </div>

                    <div class="pos-brand-content">

                        <strong class="pos-brand-title">
                            EMNEX POS
                        </strong>

                        <span class="pos-brand-subtitle">
                            Point of Sale
                        </span>

                    </div>

                </div>


                <div class="pos-context-divider"></div>


                <div class="pos-context">

                    <div class="pos-context-item">

                        <span class="pos-context-label">
                            Branch
                        </span>

                        <strong
                            class="pos-context-value"
                            id="pos-branch-name"
                        >
                            {{ $branch?->name ?? '—' }}
                        </strong>

                    </div>


                    <div class="pos-context-item">

                        <span class="pos-context-label">
                            Terminal
                        </span>

                        <strong
                            class="pos-context-value"
                            id="pos-terminal-name"
                        >
                            {{ $terminal?->terminal_name ?? '—' }}
                        </strong>

                    </div>


                    <div class="pos-context-item">

                        <span class="pos-context-label">
                            Cashier
                        </span>

                        <strong
                            class="pos-context-value"
                            id="pos-cashier-name"
                        >
                            {{ trim(
                                ($user->last_name ?? '')
                                . ' '
                                . ($user->first_name ?? '')
                            ) }}
                        </strong>

                    </div>

                </div>

            </div>

            <div class="pos-company-brand">

                <span class="pos-company-brand-icon">

                    <i class="bi bi-building"></i>

                </span>

                <span
                    class="pos-company-brand-name"
                    title="{{ $user->company?->name ?? 'EMNEX POS' }}"
                >

                    {{ $user->company?->name ?? 'EMNEX POS' }}

                </span>

            </div>


            <div class="pos-topbar-right">

                {{-- Drawer Status --}}
                <div
                    class="pos-drawer-status"
                    id="pos-drawer-status"
                >
                    <span class="pos-status-dot"></span>

                    <span>
                        Drawer Open
                    </span>
                </div>


                {{-- Sales History --}}
                <button
                    type="button"
                    class="pos-header-action pos-header-action-history"
                    id="pos-sales-history-btn"
                >
                    <i class="bi bi-clock-history"></i>

                    <span>
                        Sales History
                    </span>
                </button>


                {{-- Held Sales --}}
                <button
                    type="button"
                    class="pos-header-action pos-header-action-held"
                    id="pos-held-sales-btn"
                >
                    <i class="bi bi-pause-circle"></i>

                    <span>
                        Held Sales
                    </span>

                    <span
                        class="pos-header-count d-none"
                        id="pos-held-sales-count"
                    >
                        0
                    </span>
                </button>


                {{-- Customer --}}
                <button
                    type="button"
                    class="pos-header-action pos-header-action-customer"
                    id="pos-customer-header-btn"
                >
                    <i class="bi bi-person"></i>

                    <span>
                        Customer
                    </span>
                </button>


                {{-- Close POS --}}
                <a
                    href="{{ route('dashboard') }}"
                    class="pos-close-action"
                    id="pos-close-btn"
                >
                    <i class="bi bi-x-lg"></i>

                    <span>
                        Close POS
                    </span>
                </a>

            </div>

        </header>


        {{-- 
        |--------------------------------------------------------------------------
        | Main Workspace
        |--------------------------------------------------------------------------
        --}}

        <main class="pos-main">

            <div class="pos-workspace">


                {{-- 
                |--------------------------------------------------------------------------
                | Products Panel
                |--------------------------------------------------------------------------
                --}}

                <section class="pos-products-panel">

                    {{-- Toolbar --}}

                    <div class="pos-products-toolbar">

                        <div class="pos-search-container">

                            <i
                                class="bi bi-search pos-search-icon"
                            ></i>

                            <input
                                type="search"
                                class="form-control pos-search-input"
                                id="pos-product-search"
                                placeholder="Search products, SKU or barcode..."
                                autocomplete="off"
                            >

                            <button
                                type="button"
                                class="pos-search-clear d-none"
                                id="pos-product-search-clear"
                                aria-label="Clear search"
                            >

                                <i class="bi bi-x"></i>

                            </button>

                            <button
                                type="button"
                                class="pos-barcode-btn"
                                id="pos-barcode-btn"
                                title="Scan barcode"
                            >

                                <i class="bi bi-upc-scan"></i>

                            </button>

                        </div>


                        <button
                            type="button"
                            class="pos-toolbar-btn"
                            id="pos-refresh-products"
                            title="Refresh products"
                        >

                            <i class="bi bi-arrow-clockwise"></i>

                        </button>

                    </div>


                    {{-- Search results --}}

                    <div
                        class="pos-search-results d-none"
                        id="pos-search-results"
                    ></div>


                    {{-- Categories --}}

                    <div class="pos-categories-wrapper">

                        <button
                            type="button"
                            class="pos-category-scroll-btn"
                            id="pos-category-prev"
                        >

                            <i class="bi bi-chevron-left"></i>

                        </button>


                        <div
                            class="pos-category-list"
                            id="pos-category-list"
                        >

                            <button
                                type="button"
                                class="pos-category-btn active"
                                data-category-id=""
                            >

                                All

                            </button>

                        </div>


                        <button
                            type="button"
                            class="pos-category-scroll-btn"
                            id="pos-category-next"
                        >

                            <i class="bi bi-chevron-right"></i>

                        </button>

                    </div>


                    {{-- Products --}}

                    <div
                        class="pos-products-content"
                        id="pos-products-content"
                    >

                        <div
                            class="pos-product-grid"
                            id="pos-product-grid"
                        >

                            <div class="pos-products-loading">

                                <div
                                    class="spinner-border"
                                    role="status"
                                ></div>

                                <span>
                                    Loading products...
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Pagination --}}

                    <div
                        class="pos-products-footer"
                        id="pos-products-footer"
                    >

                        <div
                            class="pos-product-pagination"
                            id="pos-product-pagination"
                        ></div>

                    </div>

                </section>


                {{-- 
                |--------------------------------------------------------------------------
                | Sale Panel
                |--------------------------------------------------------------------------
                --}}

                <aside class="pos-sale-panel">

                    {{-- Sale Header --}}

                    <div class="pos-sale-header">

                        <div>

                            <span class="pos-sale-eyebrow">
                                CURRENT TRANSACTION
                            </span>

                            <h5 class="pos-sale-title">
                                New Sale
                            </h5>

                        </div>
                        

                        <div class="pos-sale-header-actions">

                            <button
                                type="button"
                                class="pos-icon-btn"
                                id="pos-hold-sale-btn"
                                title="Hold sale"
                            >

                                <i class="bi bi-pause"></i>

                            </button>


                            <button
                                type="button"
                                class="pos-icon-btn danger"
                                id="pos-clear-cart"
                                title="Clear sale"
                            >

                                <i class="bi bi-trash3"></i>

                            </button>

                        </div>

                    </div>

                    {{-- 
                        |--------------------------------------------------------------------------
                        | Sale Adjustments
                        |--------------------------------------------------------------------------
                        --}}

                        <div class="pos-adjustments-card">

                            <div class="pos-adjustments-header">

                                <div>

                                    <span class="pos-section-label">
                                        Sale Adjustments
                                    </span>

                                    <small>
                                        Manager approval required
                                    </small>

                                </div>

                            </div>


                            <div class="pos-adjustments-actions">

                                <button
                                    type="button"
                                    class="pos-adjustment-action pos-adjustment-action-discount"
                                    id="pos-discount-btn"
                                >

                                    <span class="pos-adjustment-action-icon">

                                        <i class="bi bi-percent"></i>

                                    </span>

                                    <span class="pos-adjustment-action-content">

                                        <strong>
                                            Discount
                                        </strong>

                                        <small
                                            id="pos-discount-display"
                                        >
                                            ₦0.00
                                        </small>

                                    </span>

                                </button>


                                <button
                                    type="button"
                                    class="pos-adjustment-action pos-adjustment-action-tax"
                                    id="pos-tax-btn"
                                >

                                    <span class="pos-adjustment-action-icon">

                                        <i class="bi bi-receipt"></i>

                                    </span>

                                    <span class="pos-adjustment-action-content">

                                        <strong>
                                            Tax
                                        </strong>

                                        <small
                                            id="pos-tax-display"
                                        >
                                            ₦0.00
                                        </small>

                                    </span>

                                </button>

                            </div>

                        </div>



                    {{-- Customer --}}

                    <div class="pos-sale-customer">

                        <button
                            type="button"
                            class="pos-customer-selector"
                            id="pos-customer-selector"
                        >

                            <span class="pos-customer-selector-icon">

                                <i class="bi bi-person"></i>

                            </span>

                            <span class="pos-customer-selector-content">

                                <strong
                                    id="pos-selected-customer-name"
                                >
                                    Walk-in Customer
                                </strong>

                                <small
                                    id="pos-selected-customer-detail"
                                >
                                    No customer selected
                                </small>

                            </span>

                            <i
                                class="bi bi-chevron-right"
                            ></i>

                        </button>

                    </div>


                    {{-- Cart Header --}}

                    <div class="pos-cart-heading">

                        <div>

                            <span class="pos-section-label">
                                Items
                            </span>

                            <span
                                class="pos-item-count"
                                id="pos-cart-item-count"
                            >
                                0
                            </span>

                        </div>

                        <span
                            class="pos-cart-quantity"
                            id="pos-cart-quantity"
                        >
                            0 items
                        </span>

                    </div>


                    {{-- Cart Items --}}

                    <div
                        class="pos-cart"
                        id="pos-cart"
                    >

                        <div class="pos-cart-empty">

                            <div class="pos-cart-empty-icon">

                                <i class="bi bi-cart3"></i>

                            </div>

                            <strong>
                                Your sale is empty
                            </strong>

                            <span>
                                Select products to add them here.
                            </span>

                        </div>

                    </div>                    


                    {{-- Summary --}}

                    <div class="pos-sale-summary">

                        <div class="pos-summary-row">

                            <span>
                                Subtotal
                            </span>

                            <strong
                                id="pos-subtotal"
                            >
                                ₦0.00
                            </strong>

                        </div>


                        <div class="pos-summary-row">

                            <span>
                                Discount
                            </span>

                            <strong
                                id="pos-summary-discount"
                            >
                                ₦0.00
                            </strong>

                        </div>


                        <div class="pos-summary-row">

                            <span>
                                Tax
                            </span>

                            <strong
                                id="pos-summary-tax"
                            >
                                ₦0.00
                            </strong>

                        </div>


                        <div class="pos-summary-divider"></div>


                        <div class="pos-total-row">

                            <span>
                                Total
                            </span>

                            <strong
                                id="pos-grand-total"
                            >
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    {{-- Checkout --}}

                    <div class="pos-checkout">

                        <button
                            type="button"
                            class="pos-checkout-btn"
                            id="pos-pay-btn"
                            disabled
                        >

                            <span>

                                <i class="bi bi-credit-card"></i>

                                Pay

                            </span>

                            <strong
                                id="pos-pay-total"
                            >
                                ₦0.00
                            </strong>

                        </button>


                        <div class="pos-secondary-actions">

                            <button
                                type="button"
                                class="pos-secondary-btn"
                                id="pos-save-order-btn"
                            >

                                <i class="bi bi-save"></i>

                                Save

                            </button>


                            <button
                                type="button"
                                class="pos-secondary-btn"
                                id="pos-print-preview-btn"
                            >

                                <i class="bi bi-printer"></i>

                                Preview

                            </button>

                        </div>

                    </div>

                </aside>

            </div>

        </main>


        {{-- 
        |--------------------------------------------------------------------------
        | Hidden POS Context
        |--------------------------------------------------------------------------
        --}}

        <input
            type="hidden"
            id="pos-company-id"
            value="{{ $user->company_id }}"
        >

        <input
            type="hidden"
            id="pos-branch-id"
            value="{{ $branch?->id }}"
        >

        <input
            type="hidden"
            id="pos-terminal-id"
            value="{{ $terminal?->id }}"
        >

        <input
            type="hidden"
            id="pos-drawer-id"
            value="{{ $drawer?->id }}"
        >

        <input
            type="hidden"
            id="pos-cashier-id"
            value="{{ $user->id }}"
        >


        {{-- 
        |--------------------------------------------------------------------------
        | Modals
        |--------------------------------------------------------------------------
        --}}

        @include(
            'pos.modals.customer-modal'
        )

        @include(
            'pos.modals.payment-modal'
        )

        @include(
            'pos.modals.held-sales-modal'
        )

        @include(
            'pos.modals.sales-history-modal'
        )

        @include(
            'pos.modals.discount-modal'
        )

        @include(
            'pos.modals.approval-modal'
        )

        @include(
            'pos.modals.sale-complete-modal'
        )


        {{-- 
        |--------------------------------------------------------------------------
        | Product Inspector
        |--------------------------------------------------------------------------
        --}}

        @include(
            'pos.partials.product-inspector'
        )
        

    </div>

<!-- {-- ==========================================================
    GLOBAL TOAST NOTIFICATIONS
=========================================================== --}} -->

<div class="toast-container position-fixed top-0 end-0 p-3"
     style="z-index: 99999;">

</div>
    <script>

        window.PosConfig = {

            userId:
                {{ $user->id }},

            companyId:
                {{ $user->company_id }},

            branchId:
                {{ $branch?->id ?? 'null' }},

            terminalId:
                {{ $terminal?->id ?? 'null' }},

            drawerId:
                {{ $drawer?->id ?? 'null' }},

            urls: {

                products:
                    "{{ route('pos.products') }}",

                productSearch:
                    "{{ route('pos.products.search') }}",

                productBarcode:
                    "{{ url('/pos/products/barcode') }}",

                categories:
                    "{{ route('pos.categories') }}",

                customers:
                    "{{ route('pos.customers') }}",

                customerDetails:
                    "{{ url('/pos/customers') }}",

                orders:
                    "{{ route('pos.orders.store') }}",

                orderDetails:
                    "{{ url('/pos/orders') }}",

                heldOrders:
                    "{{ route('pos.orders.held') }}",

                holdOrder:
                    "{{ route('pos.orders.hold') }}",

                retrieveOrder:
                    "{{ url('/pos/orders') }}",

                discounts:
                    "{{ route('pos.discounts') }}",

                taxRates:
                    "{{ route('pos.tax-rates') }}",

                payments:
                    "{{ url('/pos/orders') }}",

                completeSale:
                    "{{ url('/pos/orders') }}",

                receipt:
                    "{{ url('/pos/orders') }}",

                invoice:
                    "{{ url('/pos/orders') }}",

                context:
                    "{{ route('pos.context') }}",

                salesHistory:
                    "{{ route('pos.sales-history') }}",

                approvers:
                    "{{ route('pos.approvers') }}",

                approval:
                    "{{ route('pos.approval') }}",

            }

        };

    </script>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
></script>
    <script src="{{ asset('assets/js/toast.js') }}"></script>
    <script src="{{ asset('assets/js/pos.js') }}"></script>

</body>

</html>