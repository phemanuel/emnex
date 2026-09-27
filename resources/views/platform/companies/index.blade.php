@extends('platform.layouts.app')

@section('title', 'Companies | EMNEX Control Center')
@section('page_context', 'Companies')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Clients
        </span>

        <h1>
            Companies
        </h1>

        <p>
            Monitor every business operating on EMNEX from one place.
        </p>

    </div>


    <div class="pc-page-heading-stat">

        <span>
            Total companies
        </span>

        <strong>
            {{ number_format($companies->total()) }}
        </strong>

    </div>

</section>


<section class="pc-company-toolbar">

    <form
        method="GET"
        class="pc-search-box"
    >

        <i class="bi bi-search"></i>

        <input
            type="text"
            name="search"
            value="{{ $search }}"
            placeholder="Search company or ID"
        >

        @if($search)

            <a
                href="{{ route('platform.companies.index') }}"
                class="pc-search-clear"
                title="Clear search"
            >
                <i class="bi bi-x-lg"></i>
            </a>

        @endif

    </form>


    <div class="pc-company-filter-pills">

        <button
            type="button"
            class="active"
        >
            All
        </button>

        <button type="button">
            Active
        </button>

        <button type="button">
            Storefront
        </button>

        <button type="button">
            Inactive
        </button>

    </div>

</section>


<section class="pc-company-list">

    <div class="pc-company-list-header">

        <span>Company</span>
        <span>Platform status</span>
        <span>Users</span>
        <span>Branches</span>
        <span>Storefront</span>
        <span>Joined</span>
        <span></span>

    </div>


    @forelse($companies as $company)

        @php

            $storefront =
                $storefronts[$company->id] ?? null;

        @endphp

        <article class="pc-company-row">

            <div class="pc-company-identity">

                <span class="pc-company-mark large">
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


            <div>

                <span class="pc-status-with-dot">

                    <span
                        class="pc-status-dot {{ $company->status ? 'active' : 'inactive' }}"
                    ></span>

                    {{ $company->status ? 'Active' : 'Inactive' }}

                </span>

            </div>


            <div class="pc-company-number">

                <strong>
                    {{ $userCounts[$company->id] ?? 0 }}
                </strong>

                <span>
                    users
                </span>

            </div>


            <div class="pc-company-number">

                <strong>
                    {{ $branchCounts[$company->id] ?? 0 }}
                </strong>

                <span>
                    branches
                </span>

            </div>


            <div>

                @if($storefront)

                    <span
                        class="pc-status-pill {{ strtolower($storefront->status) }}"
                    >
                        {{ $storefront->status }}
                    </span>

                @else

                    <span class="pc-status-pill neutral">
                        Not configured
                    </span>

                @endif

            </div>


            <div class="pc-company-date">

                <strong>
                    {{ $company->created_at?->format('d M Y') }}
                </strong>

                <span>
                    {{ $company->created_at?->diffForHumans() }}
                </span>

            </div>


            <div class="pc-company-action">

                <a
                    href="{{ route(
                        'platform.companies.show',
                        $company
                    ) }}"
                    title="Inspect company"
                >
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>

        </article>

    @empty

        <div class="pc-empty-state large">
            No companies matched your search.
        </div>

    @endforelse

</section>


<div class="pc-pagination">
    {{ $companies->links() }}
</div>

@endsection