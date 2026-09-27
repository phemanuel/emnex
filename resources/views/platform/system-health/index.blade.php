@extends('platform.layouts.app')

@section('title', 'System Health | EMNEX Control Center')
@section('page_context', 'System Health')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Platform
        </span>

        <h1>
            System Health
        </h1>

        <p>
            Verify the core infrastructure required by EMNEX
            and quickly spot operational problems.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Healthy checks
        </span>

        <strong>
            {{ $healthyCount }}/{{ count($checks) }}
        </strong>

    </div>

</section>


<section class="pc-health-summary">

    <div>

        <span class="pc-health-summary-icon">

            @if($healthyCount === count($checks))

                <i class="bi bi-check2-circle"></i>

            @else

                <i class="bi bi-exclamation-triangle"></i>

            @endif

        </span>

        <div>

            <strong>
                {{ $healthyCount === count($checks)
                    ? 'Core systems operational'
                    : 'Some checks need attention'
                }}
            </strong>

            <p>
                These checks inspect the current application
                and database infrastructure.
            </p>

        </div>

    </div>

</section>


<div class="pc-health-grid">

    @foreach($checks as $check)

        <article class="pc-health-card">

            <div class="pc-health-card-top">

                <span
                    class="pc-health-state {{ $check['healthy'] ? 'healthy' : 'failed' }}"
                >

                    <i
                        class="bi {{ $check['healthy']
                            ? 'bi-check-lg'
                            : 'bi-x-lg'
                        }}"
                    ></i>

                </span>

                <span
                    class="pc-status-pill {{ $check['healthy'] ? 'active' : 'disabled' }}"
                >
                    {{ $check['healthy'] ? 'Operational' : 'Problem' }}
                </span>

            </div>

            <h2>
                {{ $check['name'] }}
            </h2>

            <p>
                {{ $check['description'] }}
            </p>

        </article>

    @endforeach

</div>

@endsection