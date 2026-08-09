<header class="topbar">

<!-- Mobile Sidebar Toggle -->
<button id="mobileMenuToggle" class="mobile-menu-toggle">

    <i class="bi bi-list"></i>

</button>

    <!-- Left -->
    <div class="topbar-left">

        <button class="branch-switcher">

            <div class="branch-info">

                <div class="branch-icon">

                    <i class="bi bi-shop"></i>

                </div>

                <div>

                    <div class="branch-name">

                        {{ auth()->user()->branch->name}}

                    </div>

                    <small>

                        {{ auth()->user()->branch->address}}

                    </small>

                </div>

            </div>

            <i class="bi bi-chevron-down"></i>

        </button>
        
        <!-- Divider -->

        <div class="topbar-divider"></div>       

    </div>



    <!-- Center -->

    <div class="topbar-center">

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                class="form-control"
                placeholder="Search products, customers, invoices..."
            >

        </div>

    </div>



    <!-- Right -->

    <div class="topbar-right">

        <!-- Quick Action -->

        <button class="topbar-btn">

            <i class="bi bi-plus-lg"></i>

        </button>


        <!-- Notifications -->

        <button class="topbar-btn position-relative">

            <i class="bi bi-bell"></i>

            <span class="notification-badge">

                3

            </span>

        </button>


        {{-- =========================================================
            USER ACCOUNT DROPDOWN
        ========================================================= --}}

        <div class="dropdown user-account-dropdown">

            <button
                type="button"
                class="user-dropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                {{-- Avatar --}}
                <div class="user-avatar">

                    {{ strtoupper(
                        substr(
                            auth()->user()->first_name ?? 'U',
                            0,
                            1
                        )
                    ) }}

                </div>


                {{-- User Info --}}
                <div class="user-info">

                    <div class="user-name">

                        {{ auth()->user()->first_name }}
                        {{ auth()->user()->last_name }}

                    </div>


                    <small>

                        {{ auth()->user()->role?->display_name ?? 'User' }}

                    </small>

                </div>


                <i class="bi bi-chevron-down user-dropdown-icon"></i>

            </button>



            {{-- =====================================================
                DROPDOWN
            ====================================================== --}}

            <div class="dropdown-menu dropdown-menu-end user-menu">


                {{-- Profile Header --}}
                <div class="user-menu-header">

                    <div class="user-menu-avatar">

                        {{ strtoupper(
                            substr(
                                auth()->user()->first_name ?? 'U',
                                0,
                                1
                            )
                        ) }}

                    </div>


                    <div>

                        <strong>

                            {{ auth()->user()->first_name }}
                            {{ auth()->user()->last_name }}

                        </strong>


                        <small>

                            {{ auth()->user()->email }}

                        </small>

                    </div>

                </div>



                <div class="dropdown-divider"></div>



                {{-- My Profile --}}
                <button
                    type="button"
                    class="dropdown-item"
                    id="openProfileModalBtn"
                >

                    <i class="bi bi-person"></i>

                    <span>
                        My Profile
                    </span>

                </button>



                {{-- Change Password --}}
                <button
                    type="button"
                    class="dropdown-item"
                    id="openPasswordModalBtn"
                >

                    <i class="bi bi-key"></i>

                    <span>
                        Change Password
                    </span>

                </button>



                <div class="dropdown-divider"></div>



                {{-- Logout --}}
                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="dropdown-item text-danger"
                    >

                        <i class="bi bi-box-arrow-right"></i>

                        <span>
                            Logout
                        </span>

                    </button>

                </form>

            </div>

        </div>

    </div>

</header>