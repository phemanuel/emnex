@extends('platform.layouts.app')

@section('title', 'Overview | EMNEX Control Center')
@section('page_context', 'Overview')

@section('content')

<section class="pc-page-heading">

    <div>

        <span class="pc-kicker">
            Command Center
        </span>

        <h1>
            Platform overview
        </h1>

        <p>
            A live view of companies, commerce and platform activity across EMNEX.
        </p>

    </div>

</section>


<section class="pc-platform-summary">

    <div class="pc-platform-summary-main">

        <span class="pc-summary-label">
            Companies on EMNEX
        </span>

        <div class="pc-summary-value-row">

            <strong class="pc-summary-value">
                {{ number_format($stats['companies']) }}
            </strong>

            <span class="pc-summary-chip positive">
                {{ number_format($stats['active_companies']) }} active
            </span>

        </div>

        <p>
            {{ number_format($stats['users']) }} users currently belong to businesses running on the platform.
        </p>

    </div>


    <div class="pc-platform-summary-side">

        <div class="pc-summary-side-item">

            <span>
                Active storefronts
            </span>

            <strong>
                {{ number_format($stats['active_storefronts']) }}
            </strong>

        </div>

        <div class="pc-summary-side-item">

            <span>
                In setup
            </span>

            <strong>
                {{ number_format($stats['setup_storefronts']) }}
            </strong>

        </div>

    </div>

</section>


<section class="pc-metric-strip">

    <article>

        <span class="pc-metric-icon">
            <i class="bi bi-bag-check"></i>
        </span>

        <div>

            <span>
                Online orders today
            </span>

            <strong>
                {{ number_format($stats['online_orders_today']) }}
            </strong>

        </div>

    </article>


    <article>

        <span class="pc-metric-icon">
            <i class="bi bi-receipt"></i>
        </span>

        <div>

            <span>
                POS orders today
            </span>

            <strong>
                {{ number_format($stats['pos_orders_today']) }}
            </strong>

        </div>

    </article>


    <article>

        <span class="pc-metric-icon">
            <i class="bi bi-shop"></i>
        </span>

        <div>

            <span>
                Storefront coverage
            </span>

            <strong>
                {{ number_format($stats['storefronts']) }}
            </strong>

        </div>

    </article>


    <article>

        <span class="pc-metric-icon">
            <i class="bi bi-people"></i>
        </span>

        <div>

            <span>
                Platform users
            </span>

            <strong>
                {{ number_format($stats['users']) }}
            </strong>

        </div>

    </article>

</section>


<div class="pc-dashboard-grid">

    <section class="pc-panel pc-panel-large">

        <div class="pc-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Client growth
                </span>

                <h2>
                    Recently onboarded companies
                </h2>

            </div>

            <a
                href="{{ route('platform.companies.index') }}"
                class="pc-text-link"
            >
                View all
                <i class="bi bi-arrow-up-right"></i>
            </a>

        </div>


        <div class="pc-company-feed">

            @forelse($recentCompanies as $company)

                <a
                    href="{{ route(
                        'platform.companies.show',
                        $company
                    ) }}"
                    class="pc-company-feed-row"
                >

                    <div class="pc-company-feed-main">

                        <span class="pc-company-mark">
                            {{ strtoupper(
                                substr(
                                    $company->name ?? 'C',
                                    0,
                                    1
                                )
                            ) }}
                        </span>

                        <div>

                            <strong>
                                {{ $company->name ?? 'Company #' . $company->id }}
                            </strong>

                            <span>
                                Company ID #{{ $company->id }}
                            </span>

                        </div>

                    </div>


                    <div class="pc-company-feed-meta">

                        <span class="pc-status-dot {{ $company->status ? 'active' : 'inactive' }}"></span>

                        <span>
                            {{ $company->status ? 'Active' : 'Inactive' }}
                        </span>

                        <small>
                            {{ $company->created_at?->diffForHumans() }}
                        </small>

                    </div>

                </a>

            @empty

                <div class="pc-empty-state">
                    No companies have been created yet.
                </div>

            @endforelse

        </div>

    </section>


    <section class="pc-panel">

        <div class="pc-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Commerce
                </span>

                <h2>
                    Recent online orders
                </h2>

            </div>

        </div>


        <div class="pc-order-feed">

            @forelse($recentOnlineOrders as $order)

                <div class="pc-order-feed-row">

                    <div>

                        <strong>
                            {{ $order->order_no }}
                        </strong>

                        <span>
                            {{ $order->company?->name ?? 'Unknown company' }}
                        </span>

                    </div>

                    <div class="pc-order-feed-value">

                        <strong>
                            ₦{{ number_format(
                                (float) $order->grand_total,
                                2
                            ) }}
                        </strong>

                        <span
                            class="pc-status-pill {{ strtolower($order->payment_status) }}"
                        >
                            {{ $order->payment_status }}
                        </span>

                    </div>

                </div>

            @empty

                <div class="pc-empty-state">
                    No online orders yet.
                </div>

            @endforelse

        </div>

    </section>


    <section class="pc-panel">

        <div class="pc-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Attention
                </span>

                <h2>
                    Platform pulse
                </h2>

            </div>

        </div>


        <div class="pc-pulse-list">

            <div class="pc-pulse-item">

                <span class="pc-pulse-icon warning">
                    <i class="bi bi-tools"></i>
                </span>

                <div>

                    <strong>
                        Storefronts in setup
                    </strong>

                    <span>
                        {{ number_format($stats['setup_storefronts']) }} storefronts are not yet active.
                    </span>

                </div>

            </div>


            <div class="pc-pulse-item">

                <span class="pc-pulse-icon good">
                    <i class="bi bi-check2-circle"></i>
                </span>

                <div>

                    <strong>
                        Active companies
                    </strong>

                    <span>
                        {{ number_format($stats['active_companies']) }} companies are currently active.
                    </span>

                </div>

            </div>


            <div class="pc-pulse-item">

                <span class="pc-pulse-icon info">
                    <i class="bi bi-shop-window"></i>
                </span>

                <div>

                    <strong>
                        Storefront adoption
                    </strong>

                    <span>
                        {{ number_format($stats['storefronts']) }} companies have a storefront record.
                    </span>

                </div>

            </div>

        </div>

    </section>

</div>

@endsection