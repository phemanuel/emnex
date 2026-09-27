@extends('platform.layouts.app')

@section('title', 'Onboarding | EMNEX Control Center')
@section('page_context', 'Onboarding')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Client Setup
        </span>

        <h1>
            Onboarding
        </h1>

        <p>
            See where every company is in its EMNEX setup journey
            and quickly identify businesses that still need attention.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Companies tracked
        </span>

        <strong>
            {{ number_format($companies->total()) }}
        </strong>

    </div>

</section>


<section class="pc-section-intro">

    <div class="pc-section-intro-main">

        <span class="pc-section-intro-icon">
            <i class="bi bi-person-check"></i>
        </span>

        <div>

            <strong>
                Provisioning progress
            </strong>

            <p>
                Completion is based on the core setup checks currently
                configured for each company.
            </p>

        </div>

    </div>

</section>


<section class="pc-onboarding-list">

    <div class="pc-onboarding-list-header">

        <span>Company</span>
        <span>Setup progress</span>
        <span>Storefront</span>
        <span>Onboarding state</span>
        <span>Started</span>
        <span></span>

    </div>


    @forelse($rows as $row)

        @php

            $company =
                $row['company'];

            $percentage =
                $row['total'] > 0
                    ? (int) round(
                        (
                            $row['completed']
                            /
                            $row['total']
                        )
                        * 100
                    )
                    : 0;

            $isComplete =
                $row['completed']
                ===
                $row['total'];

            $storefront =
                $row['storefront'];

        @endphp


        <article class="pc-onboarding-row">

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


            <div class="pc-progress-cell">

                <div class="pc-progress-copy">

                    <strong>
                        {{ $percentage }}%
                    </strong>

                    <span>
                        {{ $row['completed'] }}/{{ $row['total'] }} complete
                    </span>

                </div>


                <div class="pc-progress-track">

                    <span
                        class="{{ $isComplete ? 'complete' : '' }}"
                        style="width: {{ $percentage }}%"
                    ></span>

                </div>

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


            <div>

                @if($isComplete)

                    <span class="pc-status-with-dot">

                        <span class="pc-status-dot active"></span>

                        Complete

                    </span>

                @else

                    <span class="pc-status-with-dot">

                        <span class="pc-status-dot warning"></span>

                        In progress

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
                    title="Inspect onboarding"
                >
                    <i class="bi bi-arrow-up-right"></i>
                </a>

            </div>

        </article>

    @empty

        <div class="pc-empty-state large">
            No companies are currently in the onboarding system.
        </div>

    @endforelse

</section>


<div class="pc-pagination">
    {{ $companies->links() }}
</div>

@endsection