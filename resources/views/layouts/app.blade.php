<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.partials.head')

    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/company.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/branches.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components/modals.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/role-permissions.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/users.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/terminal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/document-sequences.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/payment-method.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/activity-log.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product-category.css') }}">

</head>

<body>

<div class="app-layout">


<div class="toast-container position-fixed top-0 end-0 p-3"
     style="z-index:9999">

</div>

    @include('layouts.partials.sidebar')


    <div class="app-main">


        @include('layouts.partials.topbar')


        <div class="app-body">


            <main class="app-content">

                @yield('content')

            </main>


            @include('layouts.partials.footer')


        </div>


    </div>


</div>


@include('layouts.partials.scripts')


</body>
</html>
