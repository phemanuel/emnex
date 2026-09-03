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
    <link rel="stylesheet" href="{{ asset('assets/css/unit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tax-rate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/discount.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stock.css') }}">    
    <link rel="stylesheet" href="{{ asset('assets/css/stock-transfer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stock-movement.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/stock-count.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/low-stock.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customer-management.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/supplier.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/purchase.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/payment.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/returns.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/cash-drawer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cashier.css') }}"> -->
  

</head>

<body>

<div class="app-layout">


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


<!-- {-- ==========================================================
    GLOBAL TOAST NOTIFICATIONS
=========================================================== --}} -->

<div class="toast-container position-fixed top-0 end-0 p-3"
     style="z-index: 99999;">

</div>


@php

    $appSettings =
        \App\Models\Setting::active()
            ->where(
                'company_id',
                companyId()
            )
            ->first();

@endphp


<script>

    window.EmnexSettings = {

        currency:
            @json(
                $appSettings?->currency
                ?? 'NGN'
            ),

        currencySymbol:
            @json(
                $appSettings?->currency_symbol
                ?? '₦'
            ),

    };

</script>



@include('layouts.partials.scripts')
@include('layouts.partials.profile-modal')
@include('layouts.partials.change-password-modal')
</body>
</html>
