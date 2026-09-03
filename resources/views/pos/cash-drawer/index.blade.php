{{--
|--------------------------------------------------------------------------
| EMNEX POS - CASH DRAWER
|--------------------------------------------------------------------------
--}}

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    
        <meta name="csrf-token"
      content="{{ csrf_token() }}">

    <title>
        Cash Drawer | EMNEX POS
    </title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}"> 


    {{-- Bootstrap --}}

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/bootstrap.min.css') }}"
    >


    {{-- Bootstrap Icons --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    {{-- Cashier CSS --}}

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/cashier.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/cash-drawer.css') }}"
    >

</head>


<body class="emnex-cashier-screen">


<div class="cashier-app">


    {{--
    |--------------------------------------------------------------------------
    | Cashier Header
    |--------------------------------------------------------------------------
    --}}

    <header class="cashier-topbar">


        {{--
        |--------------------------------------------------------------------------
        | Left
        |--------------------------------------------------------------------------
        --}}

        <div class="cashier-topbar-left">


            {{-- EMNEX POS Brand --}}

            <div class="cashier-brand">

                <div class="cashier-brand-mark">

                    <i class="bi bi-shop"></i>

                </div>


                <div class="cashier-brand-content">

                    <span class="cashier-brand-title">

                        EMNEX POS

                    </span>


                    <span class="cashier-brand-subtitle">

                        CASHIER

                    </span>

                </div>

            </div>


            {{-- Divider --}}

            <div class="cashier-context-divider"></div>


            {{-- Branch / Terminal / Cashier --}}

            <div class="cashier-context">


                {{-- Branch --}}

                <div class="cashier-context-item">

                    <span class="cashier-context-label">

                        Branch

                    </span>


                    <span class="cashier-context-value">

                        {{ $currentBranch?->name ?? '—' }}

                    </span>

                </div>


                {{-- Terminal --}}

                <div class="cashier-context-item">

                    <span class="cashier-context-label">

                        Terminal

                    </span>


                    <span class="cashier-context-value">

                        {{ $currentTerminal?->terminal_name ?? '—' }}

                    </span>

                </div>


                {{-- Cashier --}}

                <div class="cashier-context-item">

                    <span class="cashier-context-label">

                        Cashier

                    </span>


                    <span class="cashier-context-value">

                        {{ auth()->user()?->last_name ?? '' }}
                        {{ auth()->user()?->first_name ?? '' }}

                    </span>

                </div>

            </div>

        </div>


        {{--
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        --}}

        <div class="cashier-company-brand">

            <div class="cashier-company-brand-icon">

                <i class="bi bi-building"></i>

            </div>


            <span class="cashier-company-brand-name">

                EMNEX POS

            </span>

        </div>


        {{--
        |--------------------------------------------------------------------------
        | Right
        |--------------------------------------------------------------------------
        --}}

        <div class="cashier-topbar-right">


            {{-- Drawer Status --}}

            <div
                class="cashier-drawer-status"
                id="header-drawer-status"
            >

                <span class="cashier-status-dot"></span>


                <span id="header-drawer-status-text">

                    {{ $currentDrawer ? 'Drawer Open' : 'Drawer Closed' }}

                </span>

            </div>


            {{-- Cashier Home --}}

            <a
                href="{{ route('pos.cashier') }}"
                class="cashier-header-action cashier-header-action-drawer"
            >

                <i class="bi bi-grid"></i>

                <span>

                    Cashier Home

                </span>

            </a>


            {{-- Logout --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="d-inline"
            >

                @csrf

                <button
                    type="submit"
                    class="cashier-header-action cashier-header-action-exit"
                >

                    <i class="bi bi-box-arrow-right"></i>

                    <span>

                        Logout

                    </span>

                </button>

            </form>

        </div>

    </header>


    {{--
    |--------------------------------------------------------------------------
    | Main
    |--------------------------------------------------------------------------
    --}}

    <main class="cashier-main">


        <div class="container-fluid px-0 cash-drawer-page">


            {{--
            |--------------------------------------------------------------------------
            | Page Header
            |--------------------------------------------------------------------------
            --}}

            <div class="cash-drawer-page-header">


                <div class="cash-drawer-page-heading">


                    <div class="cash-drawer-eyebrow">

                        POS OPERATIONS

                    </div>


                    <div class="cash-drawer-title-row">


                        <h4 class="cash-drawer-title mb-0">

                            Cash Drawer

                        </h4>


                        <span
                            id="drawer-status-badge"
                            class="drawer-status-badge {{ $currentDrawer ? 'is-open' : 'is-closed' }}"
                        >

                            <span class="drawer-status-dot"></span>

                            {{ $currentDrawer ? 'Open' : 'Closed' }}

                        </span>

                    </div>


                    <p class="cash-drawer-subtitle mb-0">

                        Manage your current cash drawer, monitor cash movements,
                        and reconcile drawer sessions.

                    </p>

                </div>


                <div class="cash-drawer-header-actions">


                    @if(canAccess('pos.cash_drawer'))


                        <button
                            type="button"
                            class="btn cash-drawer-btn cash-drawer-btn-primary"
                            id="open-drawer-btn"
                        >

                            <i class="bi bi-box-arrow-in-right"></i>

                            <span>
                                Open Drawer
                            </span>

                        </button>


                        <button
                            type="button"
                            class="btn cash-drawer-btn cash-drawer-btn-secondary d-none"
                            id="refresh-drawer-btn"
                        >

                            <i class="bi bi-arrow-clockwise"></i>

                            <span>
                                Refresh
                            </span>

                        </button>


                    @endif


                </div>

            </div>


            {{--
            |--------------------------------------------------------------------------
            | Current Drawer
            |--------------------------------------------------------------------------
            --}}

            @include(
                'pos.cash-drawer.partials.current-drawer'
            )


            {{--
            |--------------------------------------------------------------------------
            | Financial Overview
            |--------------------------------------------------------------------------
            --}}

            @include(
                'pos.cash-drawer.partials.financial-overview'
            )


            {{--
            |--------------------------------------------------------------------------
            | Balance Position
            |--------------------------------------------------------------------------
            --}}

            @include(
                'pos.cash-drawer.partials.balance-position'
            )


            {{--
            |--------------------------------------------------------------------------
            | Cash Operations
            |--------------------------------------------------------------------------
            --}}

            @include(
                'pos.cash-drawer.partials.cash-operations'
            )


            {{--
            |--------------------------------------------------------------------------
            | Cash Transactions
            |--------------------------------------------------------------------------
            --}}

            @include(
                'pos.cash-drawer.partials.transactions-table'
            )


            {{--
            |--------------------------------------------------------------------------
            | Drawer History
            |--------------------------------------------------------------------------
            --}}

            @include(
                'pos.cash-drawer.partials.history-table'
            )


        </div>

    </main>

</div>

<!-- {-- ==========================================================
    GLOBAL TOAST NOTIFICATIONS
=========================================================== --}} -->

<div class="toast-container position-fixed top-0 end-0 p-3"
     style="z-index: 99999;">

</div>

{{--
|--------------------------------------------------------------------------
| Modals
|--------------------------------------------------------------------------
--}}

@include(
    'pos.cash-drawer.modals.open'
)

@include(
    'pos.cash-drawer.modals.cash-in'
)

@include(
    'pos.cash-drawer.modals.cash-out'
)

@include(
    'pos.cash-drawer.modals.close'
)

@include(
    'pos.cash-drawer.modals.confirmation'
)


{{--
|--------------------------------------------------------------------------
| Inspectors
|--------------------------------------------------------------------------
--}}

@include(
    'pos.cash-drawer.partials.transaction-inspector'
)

@include(
    'pos.cash-drawer.partials.drawer-inspector'
)

@include('layouts.partials.scripts')


{{--
|--------------------------------------------------------------------------
| Cash Drawer Configuration
|--------------------------------------------------------------------------
--}}

<script>

    window.CashDrawerConfig = {

        urls: {

            index:
                "{{ route('cash-drawer.index') }}",

            current:
                "{{ route('cash-drawer.current') }}",

            open:
                "{{ route('cash-drawer.open') }}",

            close:
                "{{ route(
                    'cash-drawer.close',
                    ['id' => '__ID__']
                ) }}",

            cashIn:
                "{{ route('cash-drawer.cash-in') }}",

            cashOut:
                "{{ route('cash-drawer.cash-out') }}",

            transactions:
                "{{ route('cash-drawer.transactions') }}",

            history:
                "{{ route('cash-drawer.history') }}",

            transactionDetails:
                "{{ route(
                    'cash-drawer.transaction-details',
                    ['id' => '__ID__']
                ) }}",

            details:
                "{{ route(
                    'cash-drawer.details',
                    ['id' => '__ID__']
                ) }}"

        },


        permissions: {

            access:
                @json(
                    canAccess('pos.cash_drawer')
                )

        },


        terminal: {

            id:
                @json(
                    $currentTerminal?->id
                ),

            name:
                @json(
                    $currentTerminal?->terminal_name
                ),

            branchId:
                @json(
                    $currentBranch?->id
                ),

            branchName:
                @json(
                    $currentBranch?->name
                )

        },


        drawer: {

            id:
                @json(
                    $currentDrawer?->id
                ),

            status:
                @json(
                    $currentDrawer?->status
                ),

            openingBalance:
                @json(
                    $currentDrawer?->opening_balance
                ),

            openedAt:
                @json(
                    $currentDrawer?->opened_at?->toISOString()
                )

        }

    };

</script>


<script
    src="{{ asset('assets/js/cash-drawer.js') }}"
></script>


</body>

</html>