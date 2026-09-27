@extends('platform.layouts.app')

@section('title', 'Company Inspector | EMNEX Control Center')
@section('page_context', 'Company Inspector')

@section('content')

<section class="pc-company-hero">

    <div class="pc-company-hero-main">

        <a
            href="{{ route('platform.companies.index') }}"
            class="pc-back-link"
        >
            <i class="bi bi-arrow-left"></i>
            Back to companies
        </a>

        <div class="pc-company-hero-identity">

            <span class="pc-company-hero-mark">
                {{ strtoupper(
                    substr(
                        $company->name ?? 'C',
                        0,
                        1
                    )
                ) }}
            </span>

            <div>

                <span class="pc-kicker">
                    Company Dossier
                </span>

                <h1>
                    {{ $company->name ?? 'Company #' . $company->id }}
                </h1>

                <div class="pc-company-hero-meta">

                    <span>
                        Company ID #{{ $company->id }}
                    </span>

                    <span class="pc-meta-divider"></span>

                    <span class="pc-status-with-dot">
                        <span
                            class="pc-status-dot {{ $company->status ? 'active' : 'inactive' }}"
                        ></span>

                        {{ $company->status ? 'Active' : 'Inactive' }}
                    </span>

                    <span class="pc-meta-divider"></span>

                    <span>
                        Joined {{ $company->created_at?->format('d M Y') }}
                    </span>

                </div>

            </div>

        </div>

    </div>


    <div class="pc-company-hero-actions">

        @if($storefront)

            <a
                href="{{ route(
                    'storefront.public.home',
                    [
                        'storefrontSlug' => $storefront->slug
                    ]
                ) }}"
                target="_blank"
                class="pc-action-button secondary"
            >
                <i class="bi bi-shop-window"></i>
                Open storefront
            </a>

        @endif

        <button
            type="button"
            class="pc-action-button"
        >
            <i class="bi bi-three-dots"></i>
            More actions
        </button>

    </div>

</section>


<section class="pc-company-summary-strip">

    <article>

        <span>
            Users
        </span>

        <strong>
            {{ number_format($stats['users']) }}
        </strong>

    </article>

    <article>

        <span>
            Branches
        </span>

        <strong>
            {{ number_format($stats['branches']) }}
        </strong>

    </article>

    <article>

        <span>
            Total orders
        </span>

        <strong>
            {{ number_format($stats['orders']) }}
        </strong>

    </article>

    <article>

        <span>
            Online orders
        </span>

        <strong>
            {{ number_format($stats['online_orders']) }}
        </strong>

    </article>

    <article>

        <span>
            Payments
        </span>

        <strong>
            {{ number_format($stats['payments']) }}
        </strong>

    </article>

</section>


<section class="pc-company-tabs">

    <button
        type="button"
        class="active"
        data-company-tab="overview"
    >
        Overview
    </button>

    <button
        type="button"
        data-company-tab="onboarding"
    >
        Onboarding
    </button>

    <button
        type="button"
        data-company-tab="storefront"
    >
        Storefront
    </button>

    <button
        type="button"
        data-company-tab="lifecycle"
    >
        Lifecycle
    </button>

</section>


<div
    class="pc-company-tab-panel active"
    data-company-panel="overview"
>

    <div class="pc-inspector-layout">

        <section class="pc-inspector-main">

            <article class="pc-inspector-panel">

                <div class="pc-inspector-panel-heading">

                    <div>

                        <span class="pc-panel-eyebrow">
                            Account
                        </span>

                        <h2>
                            Company overview
                        </h2>

                    </div>

                </div>


                <div class="pc-company-detail-grid">

                    <div>

                        <span>
                            Company name
                        </span>

                        <strong>
                            {{ $company->name ?? '—' }}
                        </strong>

                    </div>

                    <div>

                        <span>
                            Company ID
                        </span>

                        <strong>
                            #{{ $company->id }}
                        </strong>

                    </div>

                    <div>

                        <span>
                            Status
                        </span>

                        <strong>
                            {{ $company->status ? 'Active' : 'Inactive' }}
                        </strong>

                    </div>

                    <div>

                        <span>
                            Created
                        </span>

                        <strong>
                            {{ $company->created_at?->format('d M Y') ?? '—' }}
                        </strong>

                    </div>

                </div>

            </article>


            <article class="pc-inspector-panel">

                <div class="pc-inspector-panel-heading">

                    <div>

                        <span class="pc-panel-eyebrow">
                            Ownership
                        </span>

                        <h2>
                            Company owner
                        </h2>

                    </div>

                </div>


                @if($owner)

                    <div class="pc-owner-card">

                        <span class="pc-owner-avatar">
                            {{ $owner->initials() }}
                        </span>

                        <div class="pc-owner-main">

                            <strong>
                                {{ $owner->fullName() }}
                            </strong>

                            <span>
                                {{ $owner->email }}
                            </span>

                        </div>

                        <span
                            class="pc-status-pill {{ $owner->status ? 'active' : 'disabled' }}"
                        >
                            {{ $owner->status ? 'Active' : 'Disabled' }}
                        </span>

                    </div>


                    <div class="pc-owner-activity-grid">

                        <div>

                            <span>
                                Last login
                            </span>

                            <strong>
                                {{ $owner->last_login_at?->diffForHumans() ?? 'Never' }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                Last activity
                            </span>

                            <strong>
                                {{ $owner->last_activity_at?->diffForHumans() ?? 'Unknown' }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                Role
                            </span>

                            <strong>
                                {{ $owner->role?->displayLabel() ?? 'Owner' }}
                            </strong>

                        </div>

                    </div>

                @else

                    <div class="pc-inspector-warning">

                        <i class="bi bi-exclamation-triangle"></i>

                        <div>

                            <strong>
                                No company owner detected
                            </strong>

                            <span>
                                This company does not currently have an owner role linked to a user.
                            </span>

                        </div>

                    </div>

                @endif

            </article>

        </section>


        <aside class="pc-inspector-side">

            <article class="pc-inspector-panel">

                <div class="pc-inspector-panel-heading">

                    <div>

                        <span class="pc-panel-eyebrow">
                            Provisioning
                        </span>

                        <h2>
                            Setup health
                        </h2>

                    </div>

                    <span class="pc-onboarding-score">
                        {{ $completedSteps }}/{{ $totalSteps }}
                    </span>

                </div>


                @php

                    $setupPercentage =
                        $totalSteps > 0
                            ? (int) round(
                                ($completedSteps / $totalSteps)
                                * 100
                            )
                            : 0;

                @endphp


                <div class="pc-setup-progress">

                    <div>

                        <strong>
                            {{ $setupPercentage }}%
                        </strong>

                        <span>
                            complete
                        </span>

                    </div>

                    <div class="pc-progress-track">

                        <span
                            class="{{ $setupPercentage === 100 ? 'complete' : '' }}"
                            style="width: {{ $setupPercentage }}%"
                        ></span>

                    </div>

                </div>


                <div class="pc-setup-mini-list">

                    @foreach([
                        'company_created' => 'Company created',
                        'head_office' => 'Head Office',
                        'owner_created' => 'Owner account',
                        'roles_created' => 'Roles',
                        'payment_methods' => 'Payment methods',
                        'document_sequences' => 'Document sequences',
                        'storefront_enabled' => 'Storefront',
                    ] as $key => $label)

                        <div>

                            <span>
                                {{ $label }}
                            </span>

                            @if($onboarding[$key])

                                <i class="bi bi-check-circle-fill complete"></i>

                            @else

                                <i class="bi bi-circle incomplete"></i>

                            @endif

                        </div>

                    @endforeach

                </div>

            </article>


            <article class="pc-inspector-panel">

                <div class="pc-inspector-panel-heading">

                    <div>

                        <span class="pc-panel-eyebrow">
                            Fulfilment
                        </span>

                        <h2>
                            Head Office
                        </h2>

                    </div>

                </div>


                @if($headOffice)

                    <div class="pc-office-card">

                        <span class="pc-office-icon">
                            <i class="bi bi-building"></i>
                        </span>

                        <div>

                            <strong>
                                {{ $headOffice->name ?? 'Head Office' }}
                            </strong>

                            <span>
                                Primary fulfilment branch
                            </span>

                        </div>

                    </div>

                @else

                    <div class="pc-inspector-warning compact">

                        <i class="bi bi-exclamation-circle"></i>

                        <span>
                            No Head Office found.
                        </span>

                    </div>

                @endif

            </article>

        </aside>

    </div>

</div>


<div
    class="pc-company-tab-panel"
    data-company-panel="onboarding"
>

    <section class="pc-inspector-panel">

        <div class="pc-inspector-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Setup Journey
                </span>

                <h2>
                    Onboarding checklist
                </h2>

            </div>

            <span class="pc-onboarding-score">
                {{ $completedSteps }}/{{ $totalSteps }}
            </span>

        </div>


        <div class="pc-onboarding-checklist">

            @foreach([
                'company_created' => [
                    'Company created',
                    'The company record exists in EMNEX.'
                ],

                'head_office' => [
                    'Head Office created',
                    'A primary branch is available for operations and Storefront stock.'
                ],

                'owner_created' => [
                    'Owner account created',
                    'A company owner can access the business workspace.'
                ],

                'roles_created' => [
                    'Roles provisioned',
                    'Company roles are available for assigning staff.'
                ],

                'payment_methods' => [
                    'Payment methods provisioned',
                    'Payment options have been created for the company.'
                ],

                'document_sequences' => [
                    'Document sequences provisioned',
                    'Order, invoice, customer and payment numbering is available.'
                ],

                'storefront_enabled' => [
                    'Storefront configured',
                    'The company has created an online Storefront.'
                ],
            ] as $key => $item)

                <div class="pc-onboarding-check-item">

                    <span
                        class="pc-onboarding-check-icon {{ $onboarding[$key] ? 'complete' : 'pending' }}"
                    >

                        <i
                            class="bi {{ $onboarding[$key] ? 'bi-check-lg' : 'bi-dash' }}"
                        ></i>

                    </span>

                    <div>

                        <strong>
                            {{ $item[0] }}
                        </strong>

                        <span>
                            {{ $item[1] }}
                        </span>

                    </div>

                    <span
                        class="pc-status-pill {{ $onboarding[$key] ? 'active' : 'setup' }}"
                    >
                        {{ $onboarding[$key] ? 'Complete' : 'Pending' }}
                    </span>

                </div>

            @endforeach

        </div>

    </section>

</div>


<div
    class="pc-company-tab-panel"
    data-company-panel="storefront"
>

    <section class="pc-inspector-panel">

        <div class="pc-inspector-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Online Commerce
                </span>

                <h2>
                    Storefront
                </h2>

            </div>

        </div>


        @if($storefront)

            <div class="pc-storefront-dossier">

                <div class="pc-storefront-dossier-main">

                    <span class="pc-storefront-symbol large">
                        <i class="bi bi-shop-window"></i>
                    </span>

                    <div>

                        <span class="pc-storefront-company">
                            {{ $company->name ?? 'Company' }}
                        </span>

                        <h3>
                            {{ $storefront->name }}
                        </h3>

                        <span class="pc-storefront-slug">
                            /store/{{ $storefront->slug }}
                        </span>

                    </div>

                </div>


                <div>

                    <span
                        class="pc-status-pill {{ strtolower($storefront->status) }}"
                    >
                        {{ $storefront->status }}
                    </span>

                </div>

            </div>


            <div class="pc-company-detail-grid storefront">

                <div>

                    <span>
                        Storefront status
                    </span>

                    <strong>
                        {{ $storefront->status }}
                    </strong>

                </div>

                <div>

                    <span>
                        Enabled
                    </span>

                    <strong>
                        {{ $storefront->enabled_at?->format('d M Y') ?? 'Not yet' }}
                    </strong>

                </div>

                <div>

                    <span>
                        Online orders
                    </span>

                    <strong>
                        {{ number_format($stats['online_orders']) }}
                    </strong>

                </div>

                <div>

                    <span>
                        Fulfilment branch
                    </span>

                    <strong>
                        {{ $headOffice?->name ?? 'Not available' }}
                    </strong>

                </div>

            </div>


            <a
                href="{{ route(
                    'storefront.public.home',
                    [
                        'storefrontSlug' => $storefront->slug
                    ]
                ) }}"
                target="_blank"
                class="pc-action-button secondary inline"
            >
                Open public store
                <i class="bi bi-box-arrow-up-right"></i>
            </a>

        @else

            <div class="pc-storefront-empty">

                <span>
                    <i class="bi bi-shop"></i>
                </span>

                <h3>
                    No Storefront configured
                </h3>

                <p>
                    This company currently operates without a public online store.
                </p>

            </div>

        @endif

    </section>

</div>


<div
    class="pc-company-tab-panel"
    data-company-panel="lifecycle"
>

    <section class="pc-inspector-panel">

        <div class="pc-inspector-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Data Lifecycle
                </span>

                <h2>
                    Retention & archival
                </h2>

            </div>

            <span class="pc-status-pill neutral">
                Monitoring
            </span>

        </div>


        <div class="pc-lifecycle-placeholder">

            <span class="pc-lifecycle-icon">
                <i class="bi bi-archive"></i>
            </span>

            <div>

                <h3>
                    Lifecycle monitoring is ready for the next phase
                </h3>

                <p>
                    This section will show company inactivity,
                    archive eligibility, scheduled archival,
                    archive history and restoration status.
                </p>

            </div>

        </div>

    </section>

</div>

@endsection