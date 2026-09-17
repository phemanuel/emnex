@extends('onboarding.layouts.app')

@section('title', 'Create your business')

@section('meta_description', 'Create your EMNEX POS business account and get started.')

@section('content')

    <main class="onboarding-shell">

        {{-- ================================================================
             BRAND / HEADER
        ================================================================= --}}

        <header class="onboarding-header">

            <a
                href="{{ url('/') }}"
                class="onboarding-brand"
                aria-label="EMNEX"
            >

                <span class="onboarding-brand-mark">
                    E
                </span>

                <span class="onboarding-brand-name">
                    EMNEX
                </span>

            </a>

            <div class="onboarding-header-help">

                <span class="onboarding-help-text">
                    Already have an account?
                </span>

                <a
                    href="{{ route('login') }}"
                    class="onboarding-login-link"
                >
                    Sign in
                </a>

            </div>

        </header>


        {{-- ================================================================
             MAIN CONTENT
        ================================================================= --}}

        <section class="onboarding-content">

            <div class="onboarding-container">

                {{-- ========================================================
                     INTRO
                ========================================================= --}}

                <div
                    id="onboardingIntro"
                    class="onboarding-intro"
                >

                    <div class="onboarding-intro-badge">

                        <i class="bi bi-stars"></i>

                        <span>
                            Get started with EMNEX
                        </span>

                    </div>

                    <h1 class="onboarding-title">
                        Set up your business
                    </h1>

                    <p class="onboarding-subtitle">
                        Create your business account and configure your
                        workspace in just a few steps.
                    </p>

                </div>


                {{-- ========================================================
                     PROGRESS
                ========================================================= --}}

                <div
                    id="onboardingProgress"
                    class="onboarding-progress"
                    aria-label="Registration progress"
                >

                    <div
                        class="onboarding-progress-line"
                        aria-hidden="true"
                    ></div>

                    {{-- Step 1 --}}

                    <div
                        class="onboarding-step-indicator is-active"
                        data-step-indicator="1"
                    >

                        <div class="onboarding-step-number">
                            <span>1</span>
                            <i class="bi bi-check"></i>
                        </div>

                        <div class="onboarding-step-label">
                            Business
                        </div>

                    </div>


                    {{-- Step 2 --}}

                    <div
                        class="onboarding-step-indicator"
                        data-step-indicator="2"
                    >

                        <div class="onboarding-step-number">
                            <span>2</span>
                            <i class="bi bi-check"></i>
                        </div>

                        <div class="onboarding-step-label">
                            Owner
                        </div>

                    </div>


                    {{-- Step 3 --}}

                    <div
                        class="onboarding-step-indicator"
                        data-step-indicator="3"
                    >

                        <div class="onboarding-step-number">
                            <span>3</span>
                            <i class="bi bi-check"></i>
                        </div>

                        <div class="onboarding-step-label">
                            Review
                        </div>

                    </div>

                </div>


                {{-- ========================================================
                     GLOBAL ERROR
                ========================================================= --}}

                <div
                    id="onboardingAlert"
                    class="onboarding-alert d-none"
                    role="alert"
                >

                    <div class="onboarding-alert-icon">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>

                    <div
                        id="onboardingAlertMessage"
                        class="onboarding-alert-message"
                    ></div>

                    <button
                        type="button"
                        class="btn-close"
                        id="onboardingAlertClose"
                        aria-label="Close"
                    ></button>

                </div>


                {{-- ========================================================
                     REGISTRATION FORM
                ========================================================= --}}

                <form
                    id="onboardingForm"
                    method="POST"
                    action="{{ route('onboarding.register.store') }}"
                    novalidate
                >

                    @csrf


                    {{-- ====================================================
                         STEP 1 — COMPANY
                    ===================================================== --}}

                    <section
                        id="onboardingStep1"
                        class="onboarding-form-step is-active"
                        data-step="1"
                        aria-labelledby="step1Title"
                    >

                        <div class="onboarding-card">

                            <div class="onboarding-card-header">

                                <div class="onboarding-card-icon">
                                    <i class="bi bi-building"></i>
                                </div>

                                <div>

                                    <h2
                                        id="step1Title"
                                        class="onboarding-card-title"
                                    >
                                        Tell us about your business
                                    </h2>

                                    <p class="onboarding-card-description">
                                        Enter the basic information for your
                                        company workspace.
                                    </p>

                                </div>

                            </div>


                            <div class="onboarding-card-body">

                                <div class="row g-4">

                                    {{-- Company Name --}}

                                    <div class="col-12">

                                        <label
                                            for="company_name"
                                            class="form-label"
                                        >
                                            Company name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="company_name"
                                            name="company_name"
                                            class="form-control"
                                            value="{{ old('company_name') }}"
                                            placeholder="e.g. Emmanex Supermarket"
                                            autocomplete="organization"
                                            maxlength="255"
                                            required
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="company_name"
                                        ></div>

                                    </div>


                                    {{-- Business Type --}}

                                   <div class="col-md-6">
                                        <label for="businessType" class="form-label">
                                            Business Type
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            class="form-select"
                                            id="businessType"
                                            name="business_type"
                                            required
                                        >
                                            <option value="">Select business type</option>

                                            <option value="Retail Store">Retail Store</option>
                                            <option value="Supermarket">Supermarket</option>
                                            <option value="Convenience Store">Convenience Store</option>
                                            <option value="Mini Mart">Mini Mart</option>
                                            <option value="Grocery Store">Grocery Store</option>
                                            <option value="Pharmacy">Pharmacy</option>
                                            <option value="Electronics Store">Electronics Store</option>
                                            <option value="Fashion & Clothing">Fashion & Clothing</option>
                                            <option value="Beauty & Cosmetics">Beauty & Cosmetics</option>
                                            <option value="Restaurant">Restaurant</option>
                                            <option value="Cafe & Coffee Shop">Cafe & Coffee Shop</option>
                                            <option value="Bakery">Bakery</option>
                                            <option value="Fast Food">Fast Food</option>
                                            <option value="Wholesale">Wholesale</option>
                                            <option value="Distributor">Distributor</option>
                                            <option value="Hardware & Building Materials">
                                                Hardware & Building Materials
                                            </option>
                                            <option value="Auto Parts">Auto Parts</option>
                                            <option value="Furniture & Home Goods">
                                                Furniture & Home Goods
                                            </option>
                                            <option value="General Merchandise">
                                                General Merchandise
                                            </option>
                                            <option value="Other">Other</option>
                                        </select>

                                        <div class="invalid-feedback">
                                            Please select your business type.
                                        </div>
                                    </div>


                                    {{-- Company Email --}}

                                    <div class="col-md-6">

                                        <label
                                            for="company_email"
                                            class="form-label"
                                        >
                                            Business email
                                        </label>

                                        <input
                                            type="email"
                                            id="company_email"
                                            name="company_email"
                                            class="form-control"
                                            value="{{ old('company_email') }}"
                                            placeholder="business@example.com"
                                            autocomplete="organization"
                                            maxlength="255"
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="company_email"
                                        ></div>

                                    </div>


                                    {{-- Phone --}}

                                    <div class="col-md-6">

                                        <label
                                            for="company_phone"
                                            class="form-label"
                                        >
                                            Business phone
                                        </label>

                                        <input
                                            type="tel"
                                            id="company_phone"
                                            name="company_phone"
                                            class="form-control"
                                            value="{{ old('company_phone') }}"
                                            placeholder="08012345678"
                                            autocomplete="tel"
                                            maxlength="30"
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="company_phone"
                                        ></div>

                                    </div>


                                    {{-- Currency --}}

                                    <div class="col-md-6">

                                        <label
                                            for="currency"
                                            class="form-label"
                                        >
                                            Currency
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            id="currency"
                                            name="currency"
                                            class="form-select"
                                            required
                                        >

                                            <option value="">
                                                Select currency
                                            </option>

                                            <option
                                                value="NGN"
                                                @selected(old('currency', 'NGN') === 'NGN')
                                            >
                                                NGN — Nigerian Naira (₦)
                                            </option>

                                            <option
                                                value="USD"
                                                @selected(old('currency') === 'USD')
                                            >
                                                USD — US Dollar ($)
                                            </option>

                                            <option
                                                value="GBP"
                                                @selected(old('currency') === 'GBP')
                                            >
                                                GBP — British Pound (£)
                                            </option>

                                            <option
                                                value="EUR"
                                                @selected(old('currency') === 'EUR')
                                            >
                                                EUR — Euro (€)
                                            </option>

                                        </select>

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="currency"
                                        ></div>

                                    </div>


                                    {{-- Timezone --}}

                                    <div class="col-md-6">

                                        <label
                                            for="timezone"
                                            class="form-label"
                                        >
                                            Timezone
                                            <span class="text-danger">*</span>
                                        </label>

                                        <select
                                            id="timezone"
                                            name="timezone"
                                            class="form-select"
                                            required
                                        >

                                            <option value="">
                                                Select timezone
                                            </option>

                                            <option
                                                value="Africa/Lagos"
                                                @selected(old('timezone', 'Africa/Lagos') === 'Africa/Lagos')
                                            >
                                                Africa/Lagos — West Africa Time
                                            </option>

                                            <option
                                                value="Africa/Accra"
                                                @selected(old('timezone') === 'Africa/Accra')
                                            >
                                                Africa/Accra — Ghana
                                            </option>

                                            <option
                                                value="Europe/London"
                                                @selected(old('timezone') === 'Europe/London')
                                            >
                                                Europe/London — United Kingdom
                                            </option>

                                            <option
                                                value="America/New_York"
                                                @selected(old('timezone') === 'America/New_York')
                                            >
                                                America/New_York — Eastern Time
                                            </option>

                                            <option
                                                value="America/Los_Angeles"
                                                @selected(old('timezone') === 'America/Los_Angeles')
                                            >
                                                America/Los_Angeles — Pacific Time
                                            </option>

                                        </select>

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="timezone"
                                        ></div>

                                    </div>


                                    {{-- Address --}}

                                    <div class="col-12">

                                        <label
                                            for="company_address"
                                            class="form-label"
                                        >
                                            Business address
                                        </label>

                                        <textarea
                                            id="company_address"
                                            name="company_address"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Enter your business address"
                                            maxlength="1000"
                                        >{{ old('company_address') }}</textarea>

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="company_address"
                                        ></div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Step Navigation --}}

                        <div class="onboarding-navigation">

                            <div></div>

                            <button
                                type="button"
                                id="onboardingNextStep"
                                class="btn onboarding-btn-primary"
                                data-next-step="2"
                            >
                                <span>
                                    Continue
                                </span>

                                <i class="bi bi-arrow-right"></i>
                            </button>

                        </div>

                    </section>


                    {{-- ====================================================
                         STEP 2 — OWNER
                    ===================================================== --}}

                    <section
                        id="onboardingStep2"
                        class="onboarding-form-step"
                        data-step="2"
                        aria-labelledby="step2Title"
                        hidden
                    >

                        <div class="onboarding-card">

                            <div class="onboarding-card-header">

                                <div class="onboarding-card-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>

                                <div>

                                    <h2
                                        id="step2Title"
                                        class="onboarding-card-title"
                                    >
                                        Create your owner account
                                    </h2>

                                    <p class="onboarding-card-description">
                                        This account will become the primary
                                        owner of your EMNEX workspace.
                                    </p>

                                </div>

                            </div>


                            <div class="onboarding-card-body">

                                <div class="row g-4">

                                    {{-- First Name --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_first_name"
                                            class="form-label"
                                        >
                                            First name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="owner_first_name"
                                            name="first_name"
                                            class="form-control"
                                            value="{{ old('first_name') }}"
                                            placeholder="First name"
                                            autocomplete="given-name"
                                            maxlength="100"
                                            required
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="first_name"
                                        ></div>

                                    </div>


                                    {{-- Last Name --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_last_name"
                                            class="form-label"
                                        >
                                            Last name
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="text"
                                            id="owner_last_name"
                                            name="last_name"
                                            class="form-control"
                                            value="{{ old('last_name') }}"
                                            placeholder="Last name"
                                            autocomplete="family-name"
                                            maxlength="100"
                                            required
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="last_name"
                                        ></div>

                                    </div>


                                    {{-- Username --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_username"
                                            class="form-label"
                                        >
                                            Username
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="onboarding-input-prefix">

                                            <span>
                                                @
                                            </span>

                                            <input
                                                type="text"
                                                id="owner_username"
                                                name="username"
                                                class="form-control"
                                                value="{{ old('username') }}"
                                                placeholder="Choose a username"
                                                autocomplete="username"
                                                maxlength="100"
                                                required
                                            >

                                        </div>

                                        <div class="form-text">
                                            You'll use this username to sign in.
                                        </div>

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="username"
                                        ></div>

                                    </div>


                                    {{-- Owner Email --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_email"
                                            class="form-label"
                                        >
                                            Email address
                                            <span class="text-danger">*</span>
                                        </label>

                                        <input
                                            type="email"
                                            id="owner_email"
                                            name="email"
                                            class="form-control"
                                            value="{{ old('email') }}"
                                            placeholder="you@example.com"
                                            autocomplete="email"
                                            maxlength="255"
                                            required
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="email"
                                        ></div>

                                    </div>


                                    {{-- Owner Phone --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_phone"
                                            class="form-label"
                                        >
                                            Phone number
                                        </label>

                                        <input
                                            type="tel"
                                            id="owner_phone"
                                            name="phone"
                                            class="form-control"
                                            value="{{ old('phone') }}"
                                            placeholder="08012345678"
                                            autocomplete="tel"
                                            maxlength="30"
                                        >

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="phone"
                                        ></div>

                                    </div>


                                    {{-- Password --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_password"
                                            class="form-label"
                                        >
                                            Password
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="onboarding-password-field">

                                            <input
                                                type="password"
                                                id="owner_password"
                                                name="password"
                                                class="form-control"
                                                placeholder="Create a password"
                                                autocomplete="new-password"
                                                minlength="8"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="onboarding-password-toggle"
                                                data-password-target="owner_password"
                                                aria-label="Show password"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

                                        <div class="form-text">
                                            Use at least 8 characters.
                                        </div>

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="password"
                                        ></div>

                                    </div>


                                    {{-- Confirm Password --}}

                                    <div class="col-md-6">

                                        <label
                                            for="owner_password_confirmation"
                                            class="form-label"
                                        >
                                            Confirm password
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="onboarding-password-field">

                                            <input
                                                type="password"
                                                id="owner_password_confirmation"
                                                name="password_confirmation"
                                                class="form-control"
                                                placeholder="Confirm your password"
                                                autocomplete="new-password"
                                                minlength="8"
                                                required
                                            >

                                            <button
                                                type="button"
                                                class="onboarding-password-toggle"
                                                data-password-target="owner_password_confirmation"
                                                aria-label="Show password"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                        </div>

                                        <div
                                            class="invalid-feedback"
                                            data-error-for="password_confirmation"
                                        ></div>

                                    </div>

                                </div>


                                {{-- Security Note --}}

                                <div class="onboarding-security-note">

                                    <div class="onboarding-security-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>

                                    <div>

                                        <strong>
                                            Your account is secure
                                        </strong>

                                        <p>
                                            Your password will be securely
                                            encrypted before your account is
                                            created.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Step Navigation --}}

                        <div class="onboarding-navigation">

                            <button
                                type="button"
                                id="onboardingPreviousStep"
                                class="btn onboarding-btn-secondary"
                                data-previous-step="1"
                            >

                                <i class="bi bi-arrow-left"></i>

                                <span>
                                    Back
                                </span>

                            </button>

                            <button
                                type="button"
                                id="onboardingNextStep2"
                                class="btn onboarding-btn-primary"
                                data-next-step="3"
                            >

                                <span>
                                    Review details
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </button>

                        </div>

                    </section>


                    {{-- ====================================================
                         STEP 3 — REVIEW
                    ===================================================== --}}

                    <section
                        id="onboardingStep3"
                        class="onboarding-form-step"
                        data-step="3"
                        aria-labelledby="step3Title"
                        hidden
                    >

                        <div class="onboarding-card">

                            <div class="onboarding-card-header">

                                <div class="onboarding-card-icon">
                                    <i class="bi bi-check2-circle"></i>
                                </div>

                                <div>

                                    <h2
                                        id="step3Title"
                                        class="onboarding-card-title"
                                    >
                                        Review your information
                                    </h2>

                                    <p class="onboarding-card-description">
                                        Make sure everything looks correct
                                        before creating your workspace.
                                    </p>

                                </div>

                            </div>


                            <div class="onboarding-card-body">

                                {{-- Company Review --}}

                                <div class="onboarding-review-section">

                                    <div class="onboarding-review-heading">

                                        <div>

                                            <span class="onboarding-review-kicker">
                                                Business
                                            </span>

                                            <h3>
                                                Company information
                                            </h3>

                                        </div>

                                        <button
                                            type="button"
                                            class="onboarding-review-edit"
                                            data-edit-step="1"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </button>

                                    </div>


                                    <div class="onboarding-review-grid">

                                        <div class="onboarding-review-item">

                                            <span>
                                                Company name
                                            </span>

                                            <strong
                                                id="reviewCompanyName"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Business type
                                            </span>

                                            <strong
                                                id="reviewBusinessType"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Business email
                                            </span>

                                            <strong
                                                id="reviewCompanyEmail"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Business phone
                                            </span>

                                            <strong
                                                id="reviewCompanyPhone"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Currency
                                            </span>

                                            <strong
                                                id="reviewCurrency"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Timezone
                                            </span>

                                            <strong
                                                id="reviewTimezone"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item onboarding-review-item-full">

                                            <span>
                                                Business address
                                            </span>

                                            <strong
                                                id="reviewCompanyAddress"
                                            >
                                                —
                                            </strong>

                                        </div>

                                    </div>

                                </div>


                                {{-- Owner Review --}}

                                <div class="onboarding-review-section">

                                    <div class="onboarding-review-heading">

                                        <div>

                                            <span class="onboarding-review-kicker">
                                                Account
                                            </span>

                                            <h3>
                                                Owner information
                                            </h3>

                                        </div>

                                        <button
                                            type="button"
                                            class="onboarding-review-edit"
                                            data-edit-step="2"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </button>

                                    </div>


                                    <div class="onboarding-review-grid">

                                        <div class="onboarding-review-item">

                                            <span>
                                                Full name
                                            </span>

                                            <strong
                                                id="reviewOwnerName"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Username
                                            </span>

                                            <strong
                                                id="reviewOwnerUsername"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Email address
                                            </span>

                                            <strong
                                                id="reviewOwnerEmail"
                                            >
                                                —
                                            </strong>

                                        </div>

                                        <div class="onboarding-review-item">

                                            <span>
                                                Phone number
                                            </span>

                                            <strong
                                                id="reviewOwnerPhone"
                                            >
                                                —
                                            </strong>

                                        </div>

                                    </div>

                                </div>


                                {{-- Provisioning Information --}}

                                <div class="onboarding-provisioning-preview">

                                    <div class="onboarding-provisioning-icon">
                                        <i class="bi bi-magic"></i>
                                    </div>

                                    <div>

                                        <h3>
                                            Your workspace will be prepared
                                        </h3>

                                        <p>
                                            When you create your account,
                                            EMNEX will automatically prepare
                                            your company workspace, Head Office,
                                            owner role, permissions, settings,
                                            document sequences, and payment
                                            methods.
                                        </p>

                                    </div>

                                </div>


                                {{-- Terms --}}

                                <div class="onboarding-terms">

                                    <div class="form-check">

                                        <input
                                            type="checkbox"
                                            id="accept_terms"
                                            name="accept_terms"
                                            class="form-check-input"
                                            value="1"
                                            required
                                        >

                                        <label
                                            for="accept_terms"
                                            class="form-check-label"
                                        >
                                            I confirm that the information
                                            provided is accurate and I agree
                                            to the terms of using EMNEX.
                                            <span class="text-danger">*</span>
                                        </label>

                                    </div>

                                    <div
                                        class="invalid-feedback"
                                        data-error-for="accept_terms"
                                    ></div>

                                </div>

                            </div>

                        </div>


                        {{-- Step Navigation --}}

                        <div class="onboarding-navigation">

                            <button
                                type="button"
                                id="onboardingPreviousStep2"
                                class="btn onboarding-btn-secondary"
                                data-previous-step="2"
                            >

                                <i class="bi bi-arrow-left"></i>

                                <span>
                                    Back
                                </span>

                            </button>

                            <button
                                type="submit"
                                id="onboardingSubmit"
                                class="btn onboarding-btn-primary onboarding-btn-create"
                            >

                                <span class="onboarding-submit-label">
                                    Create workspace
                                </span>

                                <span
                                    class="onboarding-submit-loading d-none"
                                >
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        aria-hidden="true"
                                    ></span>

                                    <span>
                                        Creating workspace...
                                    </span>
                                </span>

                                <i class="bi bi-arrow-right onboarding-submit-icon"></i>

                            </button>

                        </div>

                    </section>

                </form>


                {{-- ========================================================
                     SUCCESS STATE
                ========================================================= --}}

                <section
                    id="onboardingSuccess"
                    class="onboarding-success d-none"
                    aria-live="polite"
                >

                    <div class="onboarding-success-icon">

                        <i class="bi bi-check-lg"></i>

                    </div>

                    <span class="onboarding-success-kicker">
                        You're all set
                    </span>

                    <h2>
                        Your workspace is ready
                    </h2>

                    <p>
                        Your EMNEX business account has been created
                        successfully. We're taking you to your dashboard.
                    </p>

                    <div class="onboarding-success-loader">

                        <span
                            class="spinner-border spinner-border-sm"
                            aria-hidden="true"
                        ></span>

                        <span>
                            Preparing your dashboard...
                        </span>

                    </div>

                </section>

            </div>

        </section>


        {{-- ================================================================
             FOOTER
        ================================================================= --}}

        <footer class="onboarding-footer">

            <span>
                © {{ date('Y') }} EMNEX
            </span>

            <span class="onboarding-footer-divider">
                ·
            </span>

            <span>
                Business management made simple.
            </span>

        </footer>

    </main>

@endsection

