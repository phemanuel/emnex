{{--
|--------------------------------------------------------------------------
| EMNEX POS - CASHIER SHELL
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

    <title>
        EMNEX POS | Cashier
    </title>


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

</head>


<body class="emnex-cashier-screen">


<div
    class="cashier-app"
    id="cashier-shell"
>


    {{--
    |--------------------------------------------------------------------------
    | Cashier Header
    |--------------------------------------------------------------------------
    --}}

    <header class="cashier-topbar">


        {{-- Left --}}

        <div class="cashier-topbar-left">


            {{-- Brand --}}

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


            <div class="cashier-context-divider"></div>


            {{-- Branch / Terminal / Cashier --}}

            <div class="cashier-context">


                <div class="cashier-context-item">

                    <span class="cashier-context-label">
                        Branch
                    </span>

                    <span class="cashier-context-value">

                        {{ $branch?->name ?? '—' }}

                    </span>

                </div>


                <div class="cashier-context-item">

                    <span class="cashier-context-label">
                        Terminal
                    </span>

                    <span class="cashier-context-value">

                        {{ $terminal?->terminal_name ?? '—' }}

                    </span>

                </div>


                <div class="cashier-context-item">

                    <span class="cashier-context-label">
                        Cashier
                    </span>

                    <span class="cashier-context-value">

                        {{ $user?->last_name ?? '' }}
                        {{ $user?->first_name ?? '' }}

                    </span>

                </div>

            </div>

        </div>


        {{-- Company --}}

        <div class="cashier-company-brand">

            <div class="cashier-company-brand-icon">

                <i class="bi bi-building"></i>

            </div>


            <span class="cashier-company-brand-name">

                {{ $company?->name ?? 'EMNEX POS' }}

            </span>

        </div>


        {{-- Right --}}

        <div class="cashier-topbar-right">


            {{-- Drawer Status --}}

            <div
                class="cashier-drawer-status"
                id="cashier-shell-drawer-status"
            >

                <span
                    class="cashier-status-dot"
                    id="cashier-shell-status-dot"
                ></span>


                <span id="cashier-shell-status-text">

                    {{ $drawer ? 'Drawer Open' : 'Drawer Closed' }}

                </span>

            </div>

            <button
                type="button"
                class="cashier-header-action"
                id="cashier-home-button"
            >
                <i class="bi bi-grid"></i>

                <span>
                    Cashier Home
                </span>
            </button>


            {{-- Cash Drawer --}}

            <button
                type="button"
                class="cashier-header-action cashier-header-action-drawer"
                data-cashier-page="{{ route('cash-drawer.index') }}"
            >

                <i class="bi bi-cash-stack"></i>

                <span>
                    Cash Drawer
                </span>

            </button>


            {{-- New Sale --}}

            <button
                type="button"
                class="cashier-header-action"
                data-cashier-page="{{ route('pos.index') }}"
            >

                <i class="bi bi-cart-plus"></i>

                <span>
                    New Sale
                </span>

            </button>


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
    | Cashier Workspace
    |--------------------------------------------------------------------------
    --}}

    <main
        class="cashier-shell-workspace"
        id="cashier-shell-workspace"
    >


        {{-- Cashier Home --}}

        <div
            id="cashier-home-view"
            class="cashier-shell-view cashier-home-view"
        >

            @include(
                'pos.partials.cashier-home-content'
            )

        </div>


        {{-- Embedded Page --}}

        <div
            id="cashier-frame-view"
            class="cashier-shell-view cashier-frame-view d-none"
        >

            <iframe
                id="cashier-shell-frame"
                class="cashier-shell-frame"
                title="EMNEX POS Cashier"
            ></iframe>

        </div>


    </main>


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
                Switch to full screen to continue using the cashier interface.

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

                Your cashier screen will remain locked until
                full screen mode is enabled.

            </small>

        </div>

    </div> -->


</div>


{{-- Bootstrap JS --}}

<script
    src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"
></script>


{{-- Existing POS JS --}}

<script
    src="{{ asset('assets/js/pos.js') }}"
></script>


{{-- Cashier Shell JS --}}

<script
    src="{{ asset('assets/js/cashier-shell.js') }}"
></script>


</body>

</html>