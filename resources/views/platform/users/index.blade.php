@extends('platform.layouts.app')

@section('title', 'Users | EMNEX Control Center')
@section('page_context', 'Users')

@section('content')

<section class="pc-page-heading pc-page-heading-split">

    <div>

        <span class="pc-kicker">
            Client Accounts
        </span>

        <h1>
            Users
        </h1>

        <p>
            A platform-wide view of the people accessing client
            companies across EMNEX.
        </p>

    </div>

    <div class="pc-page-heading-stat">

        <span>
            Total users
        </span>

        <strong>
            {{ number_format($users->total()) }}
        </strong>

    </div>

</section>


<section class="pc-user-list">

    <div class="pc-user-list-header">

        <span>User</span>
        <span>Company</span>
        <span>Role</span>
        <span>Branch</span>
        <span>Status</span>
        <span>Last seen</span>

    </div>


    @forelse($users as $user)

        <article class="pc-user-row">

            <div class="pc-user-identity">

                <span class="pc-user-avatar">
                    {{ $user->initials() }}
                </span>

                <div>

                    <strong>
                        {{ $user->fullName() }}
                    </strong>

                    <span>
                        {{ $user->email }}
                    </span>

                </div>

            </div>


            <div class="pc-user-company">

                <strong>
                    {{ $user->company?->name ?? '—' }}
                </strong>

                @if($user->company_id)

                    <span>
                        Company #{{ $user->company_id }}
                    </span>

                @endif

            </div>


            <div>

                <span class="pc-role-badge">
                    {{ $user->role?->displayLabel() ?? 'No role' }}
                </span>

            </div>


            <div class="pc-user-muted-value">
                {{ $user->branch?->name ?? '—' }}
            </div>


            <div>

                <span class="pc-status-with-dot">

                    <span
                        class="pc-status-dot {{ $user->status ? 'active' : 'inactive' }}"
                    ></span>

                    {{ $user->status ? 'Active' : 'Inactive' }}

                </span>

            </div>


            <div class="pc-last-seen">

                <strong>
                    {{ $user->last_activity_at?->diffForHumans() ?? 'Unknown' }}
                </strong>

                <span>
                    Login:
                    {{ $user->last_login_at?->diffForHumans() ?? 'Never' }}
                </span>

            </div>

        </article>

    @empty

        <div class="pc-empty-state large">
            No users were found.
        </div>

    @endforelse

</section>


<div class="pc-pagination">
    {{ $users->links() }}
</div>

@endsection