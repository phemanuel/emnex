 {{-- Users Table --}}

            <div class="table-responsive">


            <table class="table users-table align-middle">


            <thead>

            <tr>


            <th>

            User

            </th>


            <th>

            Role

            </th>


            <th>

            Branch

            </th>


            <th>

            Status

            </th>


            <th>

            Last Activity

            </th>


            <th class="text-end">

            Action

            </th>


            </tr>

            </thead>



            <tbody>


            @forelse($users as $user)


            <tr>


            <td>


            <div class="user-info">


            @if($user->profile_photo)


            <img src="{{ asset('storage/'.$user->profile_photo) }}"
                class="user-avatar-image">


            @else


            <div class="user-avatar">


            {{ strtoupper(
                substr($user->first_name,0,1)
                .
                substr($user->last_name,0,1)
            ) }}


            </div>


            @endif





            <div>


            <h6 class="mb-1">

            {{ $user->full_name }}

            </h6>


            <div class="user-email">

            {{ $user->email }}

            </div>



            <div class="user-username">

            <i class="bi bi-person me-1"></i>

            {{ $user->username }}

            </div>


            </div>


            </div>


            </td>





            <td>


            @if($user->role)


            <div class="role-info">


            <div class="role-icon">


            <i class="bi bi-shield-lock"></i>


            </div>



            <div>


            <strong>

            {{ $user->role->displayLabel() }}

            </strong>


            <small>

            {{ $user->role->code }}

            </small>


            </div>


            </div>


            @else


            <span class="text-muted">

            No Role

            </span>


            @endif


            </td>





            <td>


            <div class="branch-info">


            <i class="bi bi-building"></i>


            <span>

            {{ $user->branch?->name ?? 'All Branches' }}

            </span>


            </div>


            </td>





            <td>


            @if($user->status)


            <span class="user-status active">


            <span></span>

            Active


            </span>


            @else


            <span class="user-status inactive">


            <span></span>

            Disabled


            </span>


            @endif


            </td>





            <td>


            @if($user->last_activity_at)


            <div class="activity-main">

            {{ $user->last_activity_at->diffForHumans() }}

            </div>


            <small class="text-muted">

            {{ $user->last_activity_at->format('d M Y, h:i A') }}

            </small>


            @else


            <span class="text-muted">

            Never

            </span>


            @endif


            </td>





            <td class="text-end">


            <div class="dropdown">


            <button class="btn btn-light action-btn"
                    data-bs-toggle="dropdown">


            <i class="bi bi-three-dots"></i>


            </button>



            <ul class="dropdown-menu dropdown-menu-end">

    {{-- View --}}
    @permission('users.view')

    <li>

        <button
            class="dropdown-item"
            onclick="openUserDetailsPanel({{ $user->id }})">

            <i class="bi bi-eye me-2"></i>

            View Details

        </button>

    </li>

    @endpermission



    {{-- Edit --}}
    @permission('users.update')

    <li>

        <button
            class="dropdown-item"
            onclick="openEditUserModal({{ $user->id }})">

            <i class="bi bi-pencil-square me-2"></i>

            Edit User

        </button>

    </li>

    @endpermission


    <li>

        <hr class="dropdown-divider">

    </li>



    {{-- Reset Password --}}
    @permission('users.reset_password')

    <li>

        <button
            type="button"
            class="dropdown-item"
            onclick='openResetPasswordModal(@json([
                "id" => $user->id,
                "first_name" => $user->first_name,
                "last_name" => $user->last_name
            ]))'>

            <i class="bi bi-key me-2"></i>

            Reset Password

        </button>

    </li>

    @endpermission



    {{-- Toggle Status --}}
    @permission('users.update')

    <li>

        <button
            type="button"
            class="dropdown-item"
            onclick="openToggleStatusModal({
                id: {{ $user->id }},
                first_name: '{{ e($user->first_name) }}',
                last_name: '{{ e($user->last_name) }}',
                status: {{ $user->status ? 'true' : 'false' }}
            })">

            @if($user->status)

                <i class="bi bi-person-x me-2"></i>

                Disable User

            @else

                <i class="bi bi-person-check me-2"></i>

                Enable User

            @endif

        </button>

    </li>

    @endpermission

    <li>

        <hr class="dropdown-divider">

    </li>



    {{-- Delete --}}
    @permission('users.delete')

    <li>

        <button
            class="dropdown-item text-danger"
            onclick="openDeleteUserModal({
                id: {{ $user->id }},
                first_name: '{{ addslashes($user->first_name) }}',
                last_name: '{{ addslashes($user->last_name) }}'
            })">

            <i class="bi bi-trash me-2"></i>

            Delete User

        </button>

    </li>

    @endpermission

</ul>


            </div>


            </td>


            </tr>


            @empty


            <tr>


            <td colspan="6">


            <div class="empty-state">


            <i class="bi bi-people"></i>


            <h6>

            No Users Found

            </h6>


            <p>

            Create your first system user.

            </p>


            </div>


            </td>


            </tr>


            @endforelse


            </tbody>


            </table>


            </div>




            {{-- Pagination --}}

            <div class="mt-4">


            {{ $users->links() }}


            </div>



        </div>


    </div>
