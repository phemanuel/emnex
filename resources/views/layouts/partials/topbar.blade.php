<header class="topbar">

    <!-- Left -->
    <div class="topbar-left">

        <button class="branch-switcher">

            <div class="branch-info">

                <div class="branch-icon">

                    <i class="bi bi-shop"></i>

                </div>

                <div>

                    <div class="branch-name">

                        Main Branch

                    </div>

                    <small>

                        Lagos, Nigeria

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


        <!-- User -->

        <div class="user-dropdown">

            <div class="user-avatar">

                {{ strtoupper(substr(auth()->user()->first_name,0,1)) }}

            </div>

            <div class="user-info">

                <div class="user-name">

                    {{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}

                </div>

                <small>

                    Administrator

                </small>

            </div>

            <i class="bi bi-chevron-down"></i>

        </div>

    </div>

</header>