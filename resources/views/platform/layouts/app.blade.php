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
        @yield('title', 'EMNEX Control Center')
    </title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/platform-admin.css') }}"
    >

</head>

<body>

<div class="pc-shell">

    <aside
        class="pc-sidebar"
        id="platformSidebar"
    >

        <div class="pc-sidebar-header">

            <a
                href="{{ route('platform.dashboard') }}"
                class="pc-brand"
            >

                <span class="pc-brand-symbol">
                    E
                </span>

                <span class="pc-brand-copy">

                    <strong>
                        EMNEX
                    </strong>

                    <small>
                        Control Center
                    </small>

                </span>

            </a>

        </div>


        <div class="pc-sidebar-scroll">

            <nav class="pc-nav">

                <div class="pc-nav-group">

                    <span class="pc-nav-label">
                        Command Center
                    </span>

                    <a
                        href="{{ route('platform.dashboard') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.dashboard') ? 'active' : '' }}"
                    >
                        <i class="bi bi-grid-1x2"></i>
                        <span>Overview</span>
                    </a>

                </div>


                <div class="pc-nav-group">

                    <span class="pc-nav-label">
                        Clients
                    </span>

                    <a
                        href="{{ route('platform.companies.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.companies.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-buildings"></i>
                        <span>Companies</span>
                    </a>

                    <a
                        href="{{ route('platform.onboarding.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.onboarding.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-person-check"></i>
                        <span>Onboarding</span>
                    </a>

                    <a
                        href="{{ route('platform.storefronts.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.storefronts.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-shop-window"></i>
                        <span>Storefronts</span>
                    </a>

                </div>


                <div class="pc-nav-group">

                    <span class="pc-nav-label">
                        Commerce
                    </span>

                    <a
                        href="{{ route('platform.orders.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.orders.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Orders</span>
                    </a>

                    <a
                        href="{{ route('platform.payments.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.payments.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-credit-card-2-front"></i>
                        <span>Payments</span>
                    </a>

                </div>


                <div class="pc-nav-group">

                    <span class="pc-nav-label">
                        Operations
                    </span>

                    <a
                        href="{{ route('platform.users.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.users.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>

                    <a
                        href="{{ route('platform.activity.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.activity.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-clock-history"></i>
                        <span>Activity</span>
                    </a>

                    <a
                        href="{{ route('platform.data-lifecycle.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.data-lifecycle.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-archive"></i>
                        <span>Data Lifecycle</span>
                    </a>

                    <a
                        href="{{ route('platform.system-health.index') }}"
                        class="pc-nav-link {{ request()->routeIs('platform.system-health.*') ? 'active' : '' }}"
                    >
                        <i class="bi bi-heart-pulse"></i>
                        <span>System Health</span>
                    </a>
                </div>

            </nav>

        </div>


        <div class="pc-sidebar-footer">

            <div class="pc-admin-card">

                <span class="pc-admin-avatar">
                    {{ auth('platform')->user()->initials() }}
                </span>

                <div class="pc-admin-copy">

                    <strong>
                        {{ auth('platform')->user()->fullName() }}
                    </strong>

                    <small>
                        {{ ucfirst(auth('platform')->user()->access_level) }}
                    </small>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('platform.logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="pc-logout-button"
                >
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Sign out</span>
                </button>

            </form>

        </div>

    </aside>


    <div class="pc-main">

        <header class="pc-topbar">

            <div class="pc-topbar-left">

                <button
                    type="button"
                    class="pc-mobile-menu"
                    id="platformMenuButton"
                >
                    <i class="bi bi-list"></i>
                </button>

                <div>

                    <span class="pc-topbar-eyebrow">
                        EMNEX Platform
                    </span>

                    <span class="pc-topbar-context">
                        @yield('page_context', 'Control Center')
                    </span>

                </div>

            </div>


            <div class="pc-topbar-right">

                <button
                    type="button"
                    class="pc-icon-button"
                    title="Search"
                >
                    <i class="bi bi-search"></i>
                </button>

                <button
                    type="button"
                    class="pc-icon-button"
                    title="Notifications"
                >
                    <i class="bi bi-bell"></i>

                    <span class="pc-notification-dot"></span>
                </button>


                <div class="pc-topbar-admin">

                    <span class="pc-admin-avatar compact">
                        {{ auth('platform')->user()->initials() }}
                    </span>

                    <div>

                        <strong>
                            {{ auth('platform')->user()->first_name }}
                        </strong>

                        <small>
                            {{ ucfirst(auth('platform')->user()->access_level) }}
                        </small>

                    </div>

                </div>

            </div>

        </header>


        <main class="pc-content">

            @yield('content')

        </main>

    </div>

</div>


<div
    class="pc-sidebar-backdrop"
    id="platformSidebarBackdrop"
></div>


<script src="{{ asset('assets/js/platform-admin.js') }}"></script>

</body>

</html>