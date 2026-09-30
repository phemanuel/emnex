@extends('layouts.app')

@section('title', 'Storefront')

@section('content')

@php

    $isActive =
        $storefront->status === 'Active';

    $isDisabled =
        $storefront->status === 'Disabled';

    $isSetup =
        $storefront->status === 'Setup';

    $storeUrl =
        url('/store/' . $storefront->slug);

    $identityComplete =
        filled($storefront->name) &&
        filled($storefront->slug);

    $setupPercentage =
        $isActive
            ? 100
            : ($identityComplete ? 75 : 35);

@endphp


<div class="storefront-page">

    <div
        id="storefrontAlert"
        class="alert storefront-alert d-none"
        role="alert"
    >

        <i
            id="storefrontAlertIcon"
            class="bi bi-check-circle-fill"
        ></i>

        <span id="storefrontAlertMessage"></span>

    </div>

    {{-- ============================================================
        FLASH MESSAGES
    ============================================================ --}}

    @if(session('success'))

        <div class="alert alert-success storefront-alert">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger storefront-alert">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}

    <div class="storefront-header">

        <div>

            <div class="storefront-header-eyebrow">

                <i class="bi bi-shop-window"></i>

                Online Storefront

            </div>

            <h1>
                Manage your Storefront
            </h1>

            <p>
                Configure how your online store appears,
                manage its public URL and control whether
                customers can access it.
            </p>

        </div>


        <div class="storefront-header-actions">

            @if($isActive)

                <a
                    href="{{ $storeUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="btn storefront-btn-secondary"
                >

                    <i class="bi bi-box-arrow-up-right"></i>

                    View Store

                </a>

            @endif

        </div>

    </div>


    {{-- ============================================================
        STATUS HERO
    ============================================================ --}}

    <section class="storefront-status-card">

        <div class="storefront-status-main">

            <div class="storefront-status-icon">

                @if($isActive)

                    <i class="bi bi-check-lg"></i>

                @elseif($isDisabled)

                    <i class="bi bi-pause-fill"></i>

                @else

                    <i class="bi bi-tools"></i>

                @endif

            </div>


            <div>

                <div class="storefront-status-heading">

                    <h2>
                        {{ $storefront->name }}
                    </h2>


                    @if($isActive)

                        <span class="storefront-status-badge is-active">

                            <span></span>

                            Live

                        </span>

                    @elseif($isDisabled)

                        <span class="storefront-status-badge is-disabled">

                            <span></span>

                            Disabled

                        </span>

                    @else

                        <span class="storefront-status-badge is-setup">

                            <span></span>

                            Setup

                        </span>

                    @endif

                </div>


                @if($isActive)

                    <p>
                        Your Storefront is active and available
                        for customers to visit.
                    </p>

                @elseif($isDisabled)

                    <p>
                        Your Storefront is currently hidden from
                        customers. Your configuration and history
                        are still intact.
                    </p>

                @else

                    <p>
                        Your Storefront has been created but is
                        not live yet. Complete the setup and
                        activate it when you're ready.
                    </p>

                @endif

            </div>

        </div>


        <div class="storefront-progress">

            <div class="storefront-progress-top">

                <span>
                    Setup progress
                </span>

                <strong>
                    {{ $setupPercentage }}%
                </strong>

            </div>

            <div class="storefront-progress-bar">

                <div
                    class="storefront-progress-value"
                    style="width: {{ $setupPercentage }}%;"
                ></div>

            </div>

        </div>

    </section>


    {{-- ============================================================
        MAIN GRID
    ============================================================ --}}

    <div class="storefront-grid">


        {{-- ========================================================
            LEFT COLUMN
        ======================================================== --}}

        <div class="storefront-main-column">


            {{-- ====================================================
                STORE IDENTITY
            ==================================================== --}}

            <section class="storefront-panel">

                <div class="storefront-panel-header">

                    <div class="storefront-panel-heading">

                        <div class="storefront-panel-icon">

                            <i class="bi bi-shop"></i>

                        </div>

                        <div>

                            <h2>
                                Store identity
                            </h2>

                            <p>
                                Configure the basic information
                                customers will associate with your store.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="storefront-panel-body">

                    <form
                        method="POST"
                        action="{{ route('storefront.update') }}"
                        id="storefrontUpdateForm"
                    >

                        @csrf
                        @method('PUT')


                        <div class="storefront-form-group">

                            <label
                                for="storefront_name"
                                class="form-label"
                            >
                                Store name

                                <span class="text-danger">
                                    *
                                </span>
                            </label>


                            <input
                                type="text"
                                id="storefront_name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $storefront->name) }}"
                                maxlength="255"
                                required
                            >


                            <div class="form-text">

                                This is the public name customers
                                will see on your online store.

                            </div>


                           <div
                                class="invalid-feedback"
                                data-error-for="name"
                            >
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>

                        </div>


                        <div class="storefront-form-group">

                            <label
                                for="storefront_slug"
                                class="form-label"
                            >
                                Store URL
                            </label>


                            <div class="storefront-slug-input">

                                <span class="storefront-slug-prefix">
                                    {{ url('/store') }}/
                                </span>


                                <input
                                    type="text"
                                    id="storefront_slug"
                                    name="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $storefront->slug) }}"
                                    maxlength="255"
                                    required
                                >

                            </div>   

                            <div class="form-text">

                                Use a short and memorable URL.
                                Spaces will automatically become hyphens.

                            </div>


                           <div
                                class="invalid-feedback"
                                data-error-for="slug"
                            >
                                @error('slug')
                                    {{ $message }}
                                @enderror
                            </div>

                        </div>

                        {{-- ============================================================
                                STOREFRONT THEME
                            ============================================================= --}}

                            <div class="storefront-form-group storefront-theme-group">

                                <div class="storefront-theme-heading">

                                    <div>

                                        <label class="form-label">
                                            Store theme
                                        </label>

                                        <p>
                                            Choose how your online store should
                                            look to customers.
                                        </p>

                                    </div>


                                    <span class="storefront-theme-current">

                                        Current:

                                        <strong>
                                            {{ ucfirst(
                                                $storefront->theme_key
                                                ?? 'editorial'
                                            ) }}
                                        </strong>

                                    </span>

                                </div>



                                @php

                                    $storefrontThemes = [

                                        'editorial' => [
                                            'name' => 'Editorial',
                                            'description' =>
                                                'Magazine-inspired shopping with warm tones, serif typography and story-led layouts.',
                                            'icon' => 'bi-journal-richtext',
                                            'tone' => 'editorial',
                                        ],

                                        'modern' => [
                                            'name' => 'Modern',
                                            'description' =>
                                                'Clean black-and-white ecommerce with simple structure and polished product cards.',
                                            'icon' => 'bi-grid-1x2',
                                            'tone' => 'modern',
                                        ],

                                        'marketplace' => [
                                            'name' => 'Marketplace',
                                            'description' =>
                                                'Blue-accented, product-dense shopping built for larger catalogues and fast browsing.',
                                            'icon' => 'bi-shop-window',
                                            'tone' => 'marketplace',
                                        ],

                                        'boutique' => [
                                            'name' => 'Boutique',
                                            'description' =>
                                                'Premium contemporary retail with burgundy accents, curated collections and modern styling.',
                                            'icon' => 'bi-stars',
                                            'tone' => 'boutique',
                                        ],

                                    ];

                                    $selectedTheme =
                                        old(
                                            'theme_key',
                                            $storefront->theme_key
                                                ?? 'editorial'
                                        );

                                @endphp



                                <div class="storefront-theme-grid">

                                    @foreach(
                                        $storefrontThemes
                                        as $themeKey => $theme
                                    )

                                        <label
                                            class="
                                                storefront-theme-option
                                                storefront-theme-option--{{ $theme['tone'] }}
                                                {{ $selectedTheme === $themeKey
                                                    ? 'is-selected'
                                                    : ''
                                                }}
                                            "
                                        >

                                            <input
                                                type="radio"
                                                name="theme_key"
                                                value="{{ $themeKey }}"
                                                class="storefront-theme-input"
                                                {{ $selectedTheme === $themeKey
                                                    ? 'checked'
                                                    : ''
                                                }}
                                                required
                                            >


                                            <div class="storefront-theme-preview">


                                                <div class="storefront-theme-preview-top">

                                                    <span></span>
                                                    <span></span>
                                                    <span></span>

                                                </div>


                                                <div class="storefront-theme-preview-body">

                                                    <div class="storefront-theme-preview-copy">

                                                        <span></span>
                                                        <strong></strong>
                                                        <small></small>

                                                    </div>


                                                    <div class="storefront-theme-preview-image">

                                                        <i class="bi {{ $theme['icon'] }}"></i>

                                                    </div>

                                                </div>


                                                <div class="storefront-theme-preview-products">

                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>

                                                </div>

                                            </div>



                                            <div class="storefront-theme-option-content">

                                                <div class="storefront-theme-option-title">

                                                    <div>

                                                        <strong>
                                                            {{ $theme['name'] }}
                                                        </strong>

                                                        @if($selectedTheme === $themeKey)

                                                            <span class="storefront-theme-active-badge">
                                                                Active
                                                            </span>

                                                        @endif

                                                    </div>


                                                    <span class="storefront-theme-check">

                                                        <i class="bi bi-check-lg"></i>

                                                    </span>

                                                </div>


                                                <p>
                                                    {{ $theme['description'] }}
                                                </p>

                                            </div>

                                        </label>

                                    @endforeach

                                </div>



                                <div
                                    class="invalid-feedback d-block"
                                    data-error-for="theme_key"
                                >
                                    @error('theme_key')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>


                        <div class="storefront-form-actions">

                            <button
                                type="submit"
                                class="btn storefront-btn-primary"
                                id="storefrontUpdateButton"
                            >
                                <i class="bi bi-check2"></i>

                                Save Changes
                            </button>

                        </div>

                    </form>

                </div>

            </section>


            {{-- ====================================================
                PUBLIC URL
            ==================================================== --}}

            <section class="storefront-panel">

                <div class="storefront-panel-header">

                    <div class="storefront-panel-heading">

                        <div class="storefront-panel-icon">

                            <i class="bi bi-link-45deg"></i>

                        </div>

                        <div>

                            <h2>
                                Dedicated Store URL
                            </h2>

                            <p>
                                This is the address customers will
                                use to access your online store.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="storefront-panel-body">

                    <div class="storefront-url-box">

                        <div class="storefront-url-content">

                            <span class="storefront-url-label">
                                Public URL
                            </span>

                            <strong id="storefrontPublicUrl">
                                {{ $storeUrl }}
                            </strong>

                        </div>


                        <div class="storefront-url-actions">

                            <button
                                type="button"
                                class="btn storefront-icon-btn"
                                id="copyStorefrontUrl"
                                title="Copy URL"
                            >

                                <i class="bi bi-copy"></i>

                            </button>


                            @if($isActive)

                                <a
                                    href="{{ $storeUrl }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="btn storefront-icon-btn"
                                    title="Open Storefront"
                                >

                                    <i class="bi bi-box-arrow-up-right"></i>

                                </a>

                            @endif

                        </div>

                    </div>


                    @if(!$isActive)

                        <div class="storefront-url-notice">

                            <i class="bi bi-info-circle"></i>

                            <span>
                                This URL is reserved for your business,
                                but customers cannot access the Storefront
                                until it is activated.
                            </span>

                        </div>

                    @endif

                </div>

            </section>


            {{-- ====================================================
                OPERATING INFORMATION
            ==================================================== --}}

            <section class="storefront-panel">

                <div class="storefront-panel-header">

                    <div class="storefront-panel-heading">

                        <div class="storefront-panel-icon">

                            <i class="bi bi-diagram-3"></i>

                        </div>

                        <div>

                            <h2>
                                Store operations
                            </h2>

                            <p>
                                How EMNEX will handle orders placed
                                through your Storefront.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="storefront-panel-body">

                    <div class="storefront-info-grid">

                        <div class="storefront-info-item">

                            <div class="storefront-info-icon">

                                <i class="bi bi-building"></i>

                            </div>

                            <div>

                                <span>
                                    Inventory source
                                </span>

                                <strong>
                                    Head Office
                                </strong>

                                <p>
                                    Online stock is always checked
                                    and deducted from Head Office.
                                </p>

                            </div>

                        </div>


                        <div class="storefront-info-item">

                            <div class="storefront-info-icon">

                                <i class="bi bi-globe2"></i>

                            </div>

                            <div>

                                <span>
                                    Sales channel
                                </span>

                                <strong>
                                    Online
                                </strong>

                                <p>
                                    Storefront orders are recorded
                                    within your existing EMNEX sales.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>


        {{-- ========================================================
            RIGHT COLUMN
        ======================================================== --}}

        <aside class="storefront-side-column">


            {{-- ====================================================
                SETUP CHECKLIST
            ==================================================== --}}

            <section class="storefront-panel">

                <div class="storefront-panel-header">

                    <div>

                        <h2>
                            Setup status
                        </h2>

                        <p>
                            Prepare your Storefront for customers.
                        </p>

                    </div>

                </div>


                <div class="storefront-panel-body">

                    <div class="storefront-checklist">


                        <div class="storefront-checklist-item is-complete">

                            <div class="storefront-check-icon">

                                <i class="bi bi-check-lg"></i>

                            </div>

                            <div>

                                <strong>
                                    Storefront created
                                </strong>

                                <span>
                                    Your Storefront workspace exists.
                                </span>

                            </div>

                        </div>


                        <div class="storefront-checklist-item {{ $identityComplete ? 'is-complete' : '' }}">

                            <div class="storefront-check-icon">

                                @if($identityComplete)

                                    <i class="bi bi-check-lg"></i>

                                @else

                                    <i class="bi bi-circle"></i>

                                @endif

                            </div>

                            <div>

                                <strong>
                                    Store identity
                                </strong>

                                <span>
                                    Store name and dedicated URL.
                                </span>

                            </div>

                        </div>


                        <div class="storefront-checklist-item {{ $isActive ? 'is-complete' : '' }}">

                            <div class="storefront-check-icon">

                                @if($isActive)

                                    <i class="bi bi-check-lg"></i>

                                @else

                                    <i class="bi bi-circle"></i>

                                @endif

                            </div>

                            <div>

                                <strong>
                                    Store activation
                                </strong>

                                <span>
                                    Make the store available publicly.
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            {{-- ====================================================
                VISIBILITY
            ==================================================== --}}

            <section class="storefront-panel">

                <div class="storefront-panel-header">

                    <div>

                        <h2>
                            Store visibility
                        </h2>

                        <p>
                            Control whether customers can access
                            your online store.
                        </p>

                    </div>

                </div>


                <div class="storefront-panel-body">


                    @if($isActive)

                        <div class="storefront-visibility-state is-live">

                            <div class="storefront-visibility-icon">

                                <i class="bi bi-broadcast"></i>

                            </div>

                            <div>

                                <strong>
                                    Your Storefront is live
                                </strong>

                                <p>
                                    Customers can currently access
                                    and visit your online store.
                                </p>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('storefront.disable') }}"
                            class="mt-3"
                            id="storefrontDisableForm"
                        >

                            @csrf

                           <button
                                type="button"
                                class="btn storefront-btn-danger w-100"
                                id="storefrontDisableButton"
                            >
                                <i class="bi bi-pause-circle"></i>

                                Disable Storefront
                            </button>

                        </form>


                        <p class="storefront-action-note">

                            Disabling your Storefront does not delete
                            products, orders or Storefront history.

                        </p>


                    @else

                        <div class="storefront-visibility-state">

                            <div class="storefront-visibility-icon">

                                <i class="bi bi-eye-slash"></i>

                            </div>

                            <div>

                                <strong>
                                    Storefront is not public
                                </strong>

                                <p>

                                    @if($isDisabled)

                                        Your Storefront is currently disabled.
                                        You can reactivate it at any time.

                                    @else

                                        Activate your Storefront when
                                        you're ready for customers.

                                    @endif

                                </p>

                            </div>

                        </div>


                        <form
                            method="POST"
                            action="{{ route('storefront.activate') }}"
                            id="storefrontActivateForm"
                        >

                            @csrf

                            <button
                                type="button"
                                class="btn storefront-btn-primary w-100"
                                id="storefrontActivateButton"
                            >
                                <i class="bi bi-rocket-takeoff"></i>

                                {{ $isDisabled
                                    ? 'Reactivate Storefront'
                                    : 'Activate Storefront'
                                }}
                            </button>

                        </form>

                    @endif

                </div>

            </section>


            {{-- ====================================================
                DETAILS
            ==================================================== --}}

            <section class="storefront-panel">

                <div class="storefront-panel-header">

                    <div>

                        <h2>
                            Store details
                        </h2>

                    </div>

                </div>


                <div class="storefront-panel-body">

                    <dl class="storefront-meta-list">

                        <div>

                            <dt>
                                Status
                            </dt>

                            <dd>
                                {{ $storefront->status }}
                            </dd>

                        </div>


                        <div>

                            <dt>
                                Created
                            </dt>

                            <dd>
                                {{ $storefront->created_at?->format('d M Y') }}
                            </dd>

                        </div>


                        <div>

                            <dt>
                                First activated
                            </dt>

                            <dd>

                                {{ $storefront->enabled_at
                                    ? $storefront->enabled_at->format('d M Y')
                                    : 'Not yet'
                                }}

                            </dd>

                        </div>

                    </dl>

                </div>

            </section>

        </aside>

    </div>

</div>

<div
    class="modal fade"
    id="activateStorefrontModal"
    tabindex="-1"
    aria-labelledby="activateStorefrontModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content storefront-modal">

            <div class="modal-header border-0">

                <div>

                    <span class="storefront-modal-kicker">
                        Store visibility
                    </span>

                    <h5
                        class="modal-title"
                        id="activateStorefrontModalLabel"
                    >
                        {{ $isDisabled
                            ? 'Reactivate Storefront'
                            : 'Activate Storefront'
                        }}
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="storefront-modal-icon storefront-modal-icon-success">

                    <i class="bi bi-rocket-takeoff"></i>

                </div>

                <p class="storefront-modal-message">

                    @if($isDisabled)

                        Your Storefront will become publicly available again
                        and customers will be able to access its dedicated URL.

                    @else

                        Your Storefront will become publicly available and
                        customers will be able to access its dedicated URL.

                    @endif

                </p>

                <div class="storefront-modal-notice">

                    <i class="bi bi-info-circle"></i>

                    <span>
                        You can disable the Storefront again later without
                        deleting its configuration or sales history.
                    </span>

                </div>

            </div>


            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn storefront-btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn storefront-btn-primary"
                    id="confirmActivateStorefront"
                >
                    <i class="bi bi-rocket-takeoff"></i>

                    {{ $isDisabled
                        ? 'Reactivate Storefront'
                        : 'Activate Storefront'
                    }}
                </button>

            </div>

        </div>

    </div>
</div>


<div
    class="modal fade"
    id="disableStorefrontModal"
    tabindex="-1"
    aria-labelledby="disableStorefrontModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content storefront-modal">

            <div class="modal-header border-0">

                <div>

                    <span class="storefront-modal-kicker">
                        Store visibility
                    </span>

                    <h5
                        class="modal-title"
                        id="disableStorefrontModalLabel"
                    >
                        Disable Storefront
                    </h5>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body">

                <div class="storefront-modal-icon storefront-modal-icon-warning">

                    <i class="bi bi-pause-circle"></i>

                </div>

                <p class="storefront-modal-message">

                    Customers will no longer be able to access your
                    Storefront while it is disabled.

                </p>

                <div class="storefront-modal-notice">

                    <i class="bi bi-shield-check"></i>

                    <span>
                        Your Storefront details, products, orders and sales
                        history will remain intact.
                    </span>

                </div>

            </div>


            <div class="modal-footer border-0">

                <button
                    type="button"
                    class="btn storefront-btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Keep Storefront Live
                </button>

                <button
                    type="button"
                    class="btn storefront-btn-danger"
                    id="confirmDisableStorefront"
                >
                    <i class="bi bi-pause-circle"></i>

                    Disable Storefront
                </button>

            </div>

        </div>

    </div>
</div>

<script src="{{ asset('assets/js/storefront.js') }}"></script>

@endsection