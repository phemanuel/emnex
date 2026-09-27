<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title }}
    </title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('assets/css/storefront-unavailable.css') }}"
    >

</head>

<body class="sf-unavailable-body">

    <main class="sf-unavailable-page">

        <div class="sf-unavailable-card">

            {{-- ==========================================================
                BRAND
            =========================================================== --}}

            <div class="sf-unavailable-brand">

                <div class="sf-unavailable-brand-mark">

                    @if($storefront)

                        {{ strtoupper(
                            substr(
                                $storefront->name,
                                0,
                                1
                            )
                        ) }}

                    @else

                        <i class="bi bi-shop-window"></i>

                    @endif

                </div>


                <div class="sf-unavailable-brand-copy">

                    <strong>

                        {{ $storefront?->name ?? 'Online Store' }}

                    </strong>

                    <span>
                        Powered by EMNEX
                    </span>

                </div>

            </div>


            {{-- ==========================================================
                STATUS ICON
            =========================================================== --}}

            <div
                class="
                    sf-unavailable-status-icon
                    is-{{ $statusType }}
                "
            >

                @if($statusType === 'setup')

                    <i class="bi bi-tools"></i>

                @elseif($statusType === 'disabled')

                    <i class="bi bi-pause-circle"></i>

                @else

                    <i class="bi bi-shop"></i>

                @endif

            </div>


            {{-- ==========================================================
                MESSAGE
            =========================================================== --}}

            <div class="sf-unavailable-copy">

                <span class="sf-unavailable-kicker">

                    @if($statusType === 'setup')

                        Store setup

                    @elseif($statusType === 'disabled')

                        Store status

                    @else

                        Storefront

                    @endif

                </span>


                <h1>
                    {{ $title }}
                </h1>


                <p>
                    {{ $message }}
                </p>

            </div>


            {{-- ==========================================================
                STATUS DETAIL
            =========================================================== --}}

            @if($statusType === 'setup')

                <div class="sf-unavailable-info">

                    <i class="bi bi-info-circle"></i>

                    <span>
                        The store owner is still preparing this storefront.
                        Products and shopping will become available once setup is complete.
                    </span>

                </div>

            @elseif($statusType === 'disabled')

                <div class="sf-unavailable-info">

                    <i class="bi bi-clock-history"></i>

                    <span>
                        This store may become available again later.
                        No action is required from you.
                    </span>

                </div>

            @else

                <div class="sf-unavailable-info">

                    <i class="bi bi-link-45deg"></i>

                    <span>
                        The store link may be incorrect, or the storefront has not been created yet.
                    </span>

                </div>

            @endif


            {{-- ==========================================================
                STORE CONTACT
            =========================================================== --}}

            @if($company && ($company->phone || $company->email))

                <div class="sf-unavailable-contact">

                    <span class="sf-unavailable-contact-label">
                        Need to reach the store?
                    </span>


                    <div class="sf-unavailable-contact-actions">

                        @if($company->phone)

                            <a
                                href="tel:{{ $company->phone }}"
                                class="sf-unavailable-contact-button"
                            >

                                <i class="bi bi-telephone"></i>

                                Call store

                            </a>

                        @endif


                        @if($company->email)

                            <a
                                href="mailto:{{ $company->email }}"
                                class="sf-unavailable-contact-button"
                            >

                                <i class="bi bi-envelope"></i>

                                Email store

                            </a>

                        @endif

                    </div>

                </div>

            @endif


            {{-- ==========================================================
                FOOTER
            =========================================================== --}}

            <div class="sf-unavailable-footer">

                <span>
                    Secure commerce powered by
                    <strong>EMNEX</strong>
                </span>

            </div>

        </div>

    </main>

</body>

</html>