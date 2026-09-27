@extends('platform.layouts.app')

@section('title', 'Data Lifecycle | EMNEX Control Center')
@section('page_context', 'Data Lifecycle')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Operations
        </span>

        <h1>
            Data Lifecycle
        </h1>

        <p>
            Identify inactive companies, create verified cold archives
            and manage long-term platform storage safely.
        </p>

    </div>


    <button
        type="button"
        class="pc-action-button"
        id="lifecycleScanButton"
        data-url="{{ route('platform.data-lifecycle.scan') }}"
    >
        <i class="bi bi-arrow-repeat"></i>

        Scan companies
    </button>

</section>


<section class="pc-lifecycle-metrics">

    @foreach([
        ['Active', $stats['active'], 'active'],
        ['Monitoring', $stats['monitoring'], 'monitoring'],
        ['Eligible', $stats['eligible'], 'eligible'],
        ['Archive Ready', $stats['archive_ready'], 'ready'],
        ['Archived', $stats['archived'], 'archived'],
    ] as $metric)

        <article>

            <span
                class="pc-lifecycle-metric-dot {{ $metric[2] }}"
            ></span>

            <span>
                {{ $metric[0] }}
            </span>

            <strong>
                {{ number_format($metric[1]) }}
            </strong>

        </article>

    @endforeach

</section>


<div class="pc-lifecycle-layout">

    <section class="pc-lifecycle-main">

        <div class="pc-panel-heading">

            <div>

                <span class="pc-panel-eyebrow">
                    Company Retention
                </span>

                <h2>
                    Lifecycle queue
                </h2>

            </div>

        </div>


        <div class="pc-lifecycle-company-list">

            @forelse($companies as $company)

                <article class="pc-lifecycle-company-row">

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


                    <div class="pc-lifecycle-company-activity">

                        <span>
                            Last activity
                        </span>

                        <strong>
                            {{ $company->last_activity_at?->diffForHumans() ?? 'Not scanned' }}
                        </strong>

                    </div>


                    <div class="pc-lifecycle-company-activity">

                        <span>
                            Eligible
                        </span>

                        <strong>
                            {{ $company->archive_eligible_at?->format('d M Y') ?? '—' }}
                        </strong>

                    </div>


                    <div>

                        <span
                            class="pc-lifecycle-state {{ \Illuminate\Support\Str::slug($company->lifecycle_status) }}"
                        >
                            {{ $company->lifecycle_status }}
                        </span>

                    </div>


                    <div class="pc-lifecycle-row-actions">

                        <a
                            href="{{ route(
                                'platform.companies.show',
                                $company
                            ) }}"
                            title="Inspect company"
                        >
                            <i class="bi bi-eye"></i>
                        </a>


                        @if(
                            $company->lifecycle_status ===
                            'Eligible'
                        )

                            <button
                                type="button"
                                class="pc-lifecycle-archive-button"
                                data-archive-company
                                data-company-name="{{ $company->name }}"
                                data-url="{{ route(
                                    'platform.data-lifecycle.archive',
                                    $company
                                ) }}"
                                title="Generate archive"
                            >
                                <i class="bi bi-archive"></i>
                            </button>

                        @endif

                    </div>

                </article>

            @empty

                <div class="pc-empty-state large">
                    No companies found.
                </div>

            @endforelse

        </div>


        <div class="pc-pagination">
            {{ $companies->links() }}
        </div>

    </section>


    <aside class="pc-lifecycle-side">

        <section class="pc-inspector-panel">

            <div class="pc-inspector-panel-heading">

                <div>

                    <span class="pc-panel-eyebrow">
                        Retention Policy
                    </span>

                    <h2>
                        Lifecycle settings
                    </h2>

                </div>

            </div>


            <form
                id="lifecycleSettingsForm"
                data-url="{{ route(
                    'platform.data-lifecycle.settings.update'
                ) }}"
            >

                @csrf

                <div class="pc-lifecycle-form-field">

                    <label>
                        Inactivity threshold
                    </label>

                    <div>

                        <input
                            type="number"
                            name="inactivity_days"
                            min="30"
                            value="{{ $settings->inactivity_days }}"
                        >

                        <span>
                            days
                        </span>

                    </div>

                </div>


                <div class="pc-lifecycle-form-field">

                    <label>
                        Grace period
                    </label>

                    <div>

                        <input
                            type="number"
                            name="grace_period_days"
                            min="0"
                            value="{{ $settings->grace_period_days }}"
                        >

                        <span>
                            days
                        </span>

                    </div>

                </div>


                <div class="pc-lifecycle-form-field">

                    <label>
                        Archive disk
                    </label>

                    <input
                        type="text"
                        name="archive_disk"
                        value="{{ $settings->archive_disk }}"
                    >

                </div>


                <div class="pc-lifecycle-form-field">

                    <label>
                        Archive directory
                    </label>

                    <input
                        type="text"
                        name="archive_directory"
                        value="{{ $settings->archive_directory }}"
                    >

                </div>


                <label class="pc-lifecycle-toggle">

                    <input
                        type="checkbox"
                        name="automatic_scheduling"
                        value="1"
                        @checked(
                            $settings
                                ->automatic_scheduling
                        )
                    >

                    <span>

                        <strong>
                            Automatic scheduling
                        </strong>

                        <small>
                            Automatically queue eligible companies later.
                        </small>

                    </span>

                </label>


                <div class="pc-lifecycle-locked-setting">

                    <i class="bi bi-lock"></i>

                    <div>

                        <strong>
                            Automatic purge disabled
                        </strong>

                        <span>
                            Purging stays locked until archive coverage is fully verified.
                        </span>

                    </div>

                </div>


                <button
                    type="submit"
                    class="pc-action-button pc-full-button"
                >
                    Save policy
                </button>

            </form>

        </section>

    </aside>

</div>


<section class="pc-inspector-panel pc-archive-history">

    <div class="pc-inspector-panel-heading">

        <div>

            <span class="pc-panel-eyebrow">
                Cold Storage
            </span>

            <h2>
                Recent archives
            </h2>

        </div>

    </div>


    <div class="pc-archive-list">

        @forelse($archives as $archive)

            <div class="pc-archive-row">

                <div>

                    <strong>
                        {{ $archive->company_name }}
                    </strong>

                    <span>
                        Company #{{ $archive->original_company_id }}
                    </span>

                </div>


                <div>

                    <span>
                        Records
                    </span>

                    <strong>
                        {{ number_format(
                            $archive->manifest['record_count']
                            ?? 0
                        ) }}
                    </strong>

                </div>


                <div>

                    <span>
                        Size
                    </span>

                    <strong>

                        @if($archive->archive_size)

                            {{ number_format(
                                $archive->archive_size
                                / 1024
                                / 1024,
                                2
                            ) }} MB

                        @else

                            —

                        @endif

                    </strong>

                </div>


                <span
                    class="pc-lifecycle-state {{ \Illuminate\Support\Str::slug($archive->status) }}"
                >
                    {{ $archive->status }}
                </span>


                @if(
                    $archive->status ===
                    'Verified'
                )

                    <a
                        href="{{ route(
                            'platform.data-lifecycle.archives.download',
                            $archive
                        ) }}"
                        class="pc-archive-download"
                    >
                        <i class="bi bi-download"></i>
                    </a>

                @else

                    <span></span>

                @endif

            </div>

        @empty

            <div class="pc-empty-state">
                No company archives have been generated.
            </div>

        @endforelse

    </div>

</section>


<div
    class="pc-modal-backdrop"
    id="archiveConfirmModal"
    hidden
>

    <div class="pc-confirm-modal">

        <span class="pc-confirm-modal-icon">
            <i class="bi bi-archive"></i>
        </span>

        <h3>
            Generate company archive?
        </h3>

        <p id="archiveConfirmMessage"></p>

        <div class="pc-confirm-modal-actions">

            <button
                type="button"
                class="pc-action-button secondary"
                id="archiveCancelButton"
            >
                Cancel
            </button>

            <button
                type="button"
                class="pc-action-button"
                id="archiveConfirmButton"
            >
                Generate archive
            </button>

        </div>

    </div>

</div>

@endsection