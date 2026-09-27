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
        EMNEX Control Center
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


<body class="pc-login-body">

<div class="pc-login-shell">

    <section class="pc-login-visual">

        <div class="pc-login-visual-overlay"></div>

        <div class="pc-login-brand">

            <span class="pc-login-brand-mark">
                E
            </span>

            <div>

                <strong>
                    EMNEX
                </strong>

                <span>
                    Control Center
                </span>

            </div>

        </div>


        <div class="pc-login-visual-content">

            <span class="pc-login-kicker">
                Platform Operations
            </span>

            <h1>
                One place to operate the entire EMNEX ecosystem.
            </h1>

            <p>
                Monitor companies, storefronts, orders, payments,
                onboarding and platform health from a single control layer.
            </p>


            <div class="pc-login-capabilities">

                <div>

                    <span class="pc-login-capability-icon">
                        <i class="bi bi-buildings"></i>
                    </span>

                    <div>

                        <strong>
                            Client oversight
                        </strong>

                        <span>
                            See every company, user and onboarding state.
                        </span>

                    </div>

                </div>


                <div>

                    <span class="pc-login-capability-icon">
                        <i class="bi bi-shop-window"></i>
                    </span>

                    <div>

                        <strong>
                            Commerce monitoring
                        </strong>

                        <span>
                            Track storefronts, orders and payment activity.
                        </span>

                    </div>

                </div>


                <div>

                    <span class="pc-login-capability-icon">
                        <i class="bi bi-shield-check"></i>
                    </span>

                    <div>

                        <strong>
                            Platform control
                        </strong>

                        <span>
                            Manage operational access and critical platform actions.
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <div class="pc-login-visual-footer">

            <span>
                EMNEX Platform Administration
            </span>

            <span>
                Secure access only
            </span>

        </div>

    </section>


    <section class="pc-login-form-side">

        <div class="pc-login-form-wrap">

            <div class="pc-login-form-heading">

                <span class="pc-login-form-kicker">
                    Authorized access
                </span>

                <h2>
                    Welcome back
                </h2>

                <p>
                    Sign in to continue to the EMNEX Control Center.
                </p>

            </div>


            @if(session('status'))

                <div class="pc-login-alert success">

                    <i class="bi bi-check-circle"></i>

                    <span>
                        {{ session('status') }}
                    </span>

                </div>

            @endif


            @if($errors->any())

                <div class="pc-login-alert error">

                    <i class="bi bi-exclamation-circle"></i>

                    <div>

                        @foreach($errors->all() as $error)

                            <span>
                                {{ $error }}
                            </span>

                        @endforeach

                    </div>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('platform.login.store') }}"
                class="pc-login-form"
            >

                @csrf


                <div class="pc-login-field">

                    <label for="email">
                        Email address
                    </label>

                    <div class="pc-login-input-wrap">

                        <i class="bi bi-envelope"></i>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@emNEX.com"
                            autocomplete="email"
                            required
                            autofocus
                        >

                    </div>

                </div>


                <div class="pc-login-field">

                    <div class="pc-login-label-row">

                        <label for="password">
                            Password
                        </label>

                    </div>

                    <div class="pc-login-input-wrap">

                        <i class="bi bi-lock"></i>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="pc-login-password-toggle"
                            id="platformPasswordToggle"
                            aria-label="Show password"
                        >
                            <i class="bi bi-eye"></i>
                        </button>

                    </div>

                </div>


                <div class="pc-login-options">

                    <label class="pc-login-remember">

                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >

                        <span>
                            Keep me signed in
                        </span>

                    </label>

                </div>


                <button
                    type="submit"
                    class="pc-login-submit"
                >

                    <span>
                        Enter Control Center
                    </span>

                    <i class="bi bi-arrow-right"></i>

                </button>

            </form>


            <div class="pc-login-security-note">

                <i class="bi bi-shield-lock"></i>

                <p>
                    This area is restricted to authorized EMNEX platform administrators.
                </p>

            </div>

        </div>

    </section>

</div>


<script>
document.addEventListener(
    'DOMContentLoaded',
    function () {

        const toggle =
            document.getElementById(
                'platformPasswordToggle'
            );

        const password =
            document.getElementById(
                'password'
            );


        toggle?.addEventListener(
            'click',
            function () {

                const hidden =
                    password.type ===
                    'password';


                password.type =
                    hidden
                        ? 'text'
                        : 'password';


                this.innerHTML =
                    hidden
                        ? '<i class="bi bi-eye-slash"></i>'
                        : '<i class="bi bi-eye"></i>';


                this.setAttribute(
                    'aria-label',
                    hidden
                        ? 'Hide password'
                        : 'Show password'
                );

            }
        );

    }
);
</script>

</body>

</html>