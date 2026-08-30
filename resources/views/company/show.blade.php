@extends('layouts.app')

@section('title', 'Company')

@section('content')

<div class="company-page">

    {{-- ==========================================
        Page Header
    =========================================== --}}
    <div class="page-header">

        <div>

            <span class="page-label">
                Administration
            </span>

            <h2>
                Company Profile
            </h2>

            <p>
                Manage your company information, branding, subscription and business identity.
            </p>

        </div>

        <div>

            <button
                class="btn btn-primary company-edit-btn"
                data-bs-toggle="modal"
                data-bs-target="#editCompanyModal">

                <i class="bi bi-pencil-square"></i>

                Edit Company

            </button>

        </div>

    </div>



    {{-- ==========================================
        Company Hero Card
    =========================================== --}}

    <div class="company-hero">

        <div class="company-left">

            <div class="company-logo">

                @if($company->logo)

                    <img
                        src="{{ asset('uploads/company/'.$company->logo) }}"
                        alt="{{ $company->name }}" class="rounded-circle company-logo-preview">

                @else

                    <div class="company-logo-placeholder">

                        {{ strtoupper(substr($company->name,0,2)) }}

                    </div>

                @endif

            </div>



            <div class="company-info">

                <h3>

                    {{ $company->name }}

                </h3>

                <p>

                    {{ $company->business_type ?: 'Business Type not specified' }}

                </p>



                <div class="company-tags">

                    <span class="company-code">

                        {{ $company->company_code }}

                    </span>



                    @if($company->status)

                        <span class="status active">

                            Active

                        </span>

                    @else

                        <span class="status inactive">

                            Inactive

                        </span>

                    @endif



                    @if($company->subscription_status=='Active')

                        <span class="subscription active">

                            Subscription Active

                        </span>

                    @else

                        <span class="subscription expired">

                            Subscription Expired

                        </span>

                    @endif

                </div>

            </div>

        </div>



        <div class="company-right">

            <div class="hero-item">

                <small>Email</small>

                <strong>

                    {{ $company->email ?: 'Not Available' }}

                </strong>

            </div>

            <div class="hero-item">

                <small>Phone</small>

                <strong>

                    {{ $company->phone ?: 'Not Available' }}

                </strong>

            </div>

            <div class="hero-item">

                <small>Registration No.</small>

                <strong>

                    {{ $company->registration_no ?: 'Not Available' }}

                </strong>

            </div>

            <div class="hero-item">

                <small>TIN</small>

                <strong>

                    {{ $company->tin ?: 'Not Available' }}

                </strong>

            </div>

        </div>

    </div>

    {{-- ==========================================
        Business Statistics
    =========================================== --}}

    <div class="company-section">

        <div class="section-header">

            <h4>
                Business Overview
            </h4>

            <span>
                Real-time company statistics
            </span>

        </div>

        <div class="row g-4">

            {{-- Branches --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon branch">
                        <i class="bi bi-shop"></i>
                    </div>

                    <div class="stat-body">

                        <small>Branches</small>

                        <h3>{{ number_format($stats['branches']) }}</h3>

                        <span>Registered Branches</span>

                    </div>

                </div>

            </div>



            {{-- Users --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon user">
                        <i class="bi bi-people"></i>
                    </div>

                    <div class="stat-body">

                        <small>Users</small>

                        <h3>{{ number_format($stats['users']) }}</h3>

                        <span>System Users</span>

                    </div>

                </div>

            </div>



            {{-- Products --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon product">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="stat-body">

                        <small>Products</small>

                        <h3>{{ number_format($stats['products']) }}</h3>

                        <span>Products in Catalog</span>

                    </div>

                </div>

            </div>



            {{-- Orders --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon order">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div class="stat-body">

                        <small>Orders</small>

                        <h3>{{ number_format($stats['orders']) }}</h3>

                        <span>Total Orders</span>

                    </div>

                </div>

            </div>



            {{-- Customers --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon customer">
                        <i class="bi bi-person-heart"></i>
                    </div>

                    <div class="stat-body">

                        <small>Customers</small>

                        <h3>{{ number_format($stats['customers']) }}</h3>

                        <span>Registered Customers</span>

                    </div>

                </div>

            </div>



            {{-- Revenue --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon revenue">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div class="stat-body">

                        <small>Revenue</small>

                     
                    <h3>
                        {{ \App\Helpers\CurrencyHelper::format($stats['revenue']) }}
                    </h3>



                        <span>Total Sales</span>

                    </div>

                </div>

            </div>



            {{-- Inventory --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon inventory">
                        <i class="bi bi-boxes"></i>
                    </div>

                    <div class="stat-body">

                        <small>Inventory</small>

                      
                        <h3>
                            {{ \App\Helpers\CurrencyHelper::format($stats['inventory_value']) }}
                        </h3>



                        <span>Current Stock Value</span>

                    </div>

                </div>

            </div>



            {{-- Terminals --}}
            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div class="stat-icon terminal">
                        <i class="bi bi-pc-display"></i>
                    </div>

                    <div class="stat-body">

                        <small>Terminals</small>

                        <h3>{{ number_format($stats['terminals']) }}</h3>

                        <span>POS Devices</span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4">

    {{-- Business Information --}}
    <div class="col-xl-8">

        <div class="company-card">

            <div class="company-card-header">

                <h5>
                    Business Information
                </h5>

            </div>

            <div class="company-info-grid">

                <div class="info-field">

                    <label>Company Code</label>

                    <div class="info-box">
                        {{ $company->company_code }}
                    </div>

                </div>



                <div class="info-field">

                    <label>Business Type</label>

                    <div class="info-box">
                        {{ $company->business_type ?: 'Not specified' }}
                    </div>

                </div>



                <div class="info-field">

                    <label>Registration Number</label>

                    <div class="info-box">
                        {{ $company->registration_no ?: 'Not available' }}
                    </div>

                </div>



                <div class="info-field">

                    <label>TIN</label>

                    <div class="info-box">
                        {{ $company->tin ?: 'Not available' }}
                    </div>

                </div>



                <div class="info-field">

                    <label>Email</label>

                    <div class="info-box">
                        {{ $company->email }}
                    </div>

                </div>



                <div class="info-field">

                    <label>Phone</label>

                    <div class="info-box">
                        {{ $company->phone }}
                    </div>

                </div>



                <div class="info-field full-width">

                    <label>Address</label>

                    <div class="info-box">
                        {{ $company->address ?: 'No address available.' }}
                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Quick Actions --}}
    <div class="company-card">

        <div class="company-card-header">

            <h5>
                Quick Actions
            </h5>

        </div>

        <div class="company-actions-grid">

            @if(canAccess('company.update'))

                <button
                    class="action-card"
                    data-bs-toggle="modal"
                    data-bs-target="#editCompanyModal">

                    <div class="action-icon bg-primary">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div class="action-text">
                        <h6>Edit Company</h6>
                        <small>Update company information</small>
                    </div>

                </button>


                <button
                    class="action-card"
                    data-bs-toggle="modal"
                    data-bs-target="#logoModal">

                    <div class="action-icon bg-success">
                        <i class="bi bi-image"></i>
                    </div>

                    <div class="action-text">
                        <h6>Company Logo</h6>
                        <small>Upload a new logo</small>
                    </div>

                </button>

            @endif

        </div>
    </div>

    <div class="company-section mt-4">

    <div class="section-header">

        <h4>
            Branches
        </h4>

        <!-- <span>
            Company operating locations
        </span> -->

    </div>


    <div class="row g-4">


        @forelse($branches as $branch)


        <div class="col-xl-4 col-md-6">


            <div class="company-card branch-card">


                <div class="company-card-header">

                    <h5>
                        {{ $branch->name }}
                    </h5>


                    @if($branch->status)

                        <span class="status active">
                            Active
                        </span>

                    @else

                        <span class="status inactive">
                            Inactive
                        </span>

                    @endif

                </div>



                <div class="branch-details">


                    <p>
                        <strong>Code:</strong>
                        {{ $branch->branch_code }}
                    </p>


                    <p>
                        <strong>Address:</strong>
                        {{ $branch->address ?? 'No address' }}
                    </p>


                    <div class="branch-stats">


                        <div>
                            <small>Terminals</small>
                            <strong>
                                {{ $branch->terminals->count() }}
                            </strong>
                        </div>


                        <div>
                            <small>Users</small>
                            <strong>
                                {{ $branch->users->count() }}
                            </strong>
                        </div>


                    </div>


                </div>


            </div>


        </div>


        @empty


        <div class="col-12">

            <div class="empty-state">

                No branches registered.

            </div>

        </div>


        @endforelse


    </div>

</div>

{{-- Company Modals --}}
@include('company.modals.edit-modal')

@include('company.modals.upload-logo-modal')
    @endsection