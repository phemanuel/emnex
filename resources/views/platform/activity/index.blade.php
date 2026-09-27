@extends('platform.layouts.app')

@section('title', 'Activity | EMNEX Control Center')
@section('page_context', 'Activity')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Operations
        </span>

        <h1>
            Activity
        </h1>

        <p>
            Review operational events recorded across EMNEX
            and trace who performed important actions.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Activity records
        </span>

        <strong>
            {{ number_format($activities->total()) }}
        </strong>

    </div>

</section>


<section class="pc-activity-list">

    <div class="pc-activity-list-header">

        <span>Actor</span>
        <span>Activity</span>
        <span>Record</span>
        <span>Date</span>

    </div>


    @forelse($activities as $activity)

        <article class="pc-activity-row">

            <div class="pc-activity-actor">

                <span class="pc-user-avatar">

                    @if($activity->user)

                        {{ $activity->user->initials() }}

                    @else

                        SY

                    @endif

                </span>

                <div>

                    <strong>
                        {{ $activity->user?->fullName() ?? 'System' }}
                    </strong>

                    <span>
                        {{ $activity->user?->email ?? 'Automated activity' }}
                    </span>

                </div>

            </div>


            <div class="pc-activity-description">

                <strong>
                    {{ $activity->action ?? $activity->description ?? 'Activity recorded' }}
                </strong>

                @if(!empty($activity->module))

                    <span>
                        {{ $activity->module }}
                    </span>

                @endif

            </div>


            <div class="pc-activity-record">

                @if(!empty($activity->subject_type))

                    <strong>
                        {{ class_basename($activity->subject_type) }}
                    </strong>

                    <span>
                        #{{ $activity->subject_id ?? '—' }}
                    </span>

                @else

                    <span>
                        —
                    </span>

                @endif

            </div>


            <div class="pc-date-stack">

                <strong>
                    {{ $activity->created_at?->format('d M Y') }}
                </strong>

                <span>
                    {{ $activity->created_at?->format('H:i') }}
                </span>

            </div>

        </article>

    @empty

        <div class="pc-empty-state large">
            No activity has been recorded yet.
        </div>

    @endforelse

</section>


<div class="pc-pagination">
    {{ $activities->links() }}
</div>

@endsection