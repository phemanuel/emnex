
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Get Started') · EMNEX
    </title>

    <meta
        name="description"
        content="@yield('meta_description', 'Set up your EMNEX POS business account.')"
    >

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}">

    {{-- Bootstrap 5 --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    {{-- Onboarding Styles --}}
    <link
        rel="stylesheet"
        href="{{ asset('assets/css/onboarding.css') }}"
    >

    @stack('styles')

</head>

<body class="onboarding-body">

    <div
        id="onboardingApp"
        class="onboarding-app"
    >

        @yield('content')

    </div>

    {{-- Bootstrap --}}
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

    {{-- Onboarding JavaScript --}}
    <script
        src="{{ asset('assets/js/onboarding.js') }}"
        defer
    ></script>

    @stack('scripts')

</body>

</html>

