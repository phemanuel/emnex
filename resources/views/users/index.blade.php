@extends('layouts.app')


@section('content')

<div class="users-page">


    {{-- Page Header --}}
    <div class="users-header mb-4">


        <div>


            <h3 class="fw-bold mb-1">

                <i class="bi bi-people-fill text-primary me-2"></i>

                Users Management

            </h3>



            <p class="text-muted mb-0">

                Manage users, roles, branches and system access.

            </p>


        </div>




        <button 
            class="btn btn-primary"
            id="openCreateUserModal">

            <i class="bi bi-person-plus"></i>
            New User

        </button>


    </div>





    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">



        <div class="col-xl-3 col-md-6">


            <div class="user-summary-card">


                <div class="summary-icon primary">


                    <i class="bi bi-people"></i>


                </div>



                <div>


                    <span>
                        Total Users
                    </span>



                    <h3>
                        {{ $totalUsers }}
                    </h3>


                </div>


            </div>


        </div>





        <div class="col-xl-3 col-md-6">


            <div class="user-summary-card">


                <div class="summary-icon success">


                    <i class="bi bi-person-check"></i>


                </div>



                <div>


                    <span>
                        Active Users
                    </span>



                    <h3>
                        {{ $activeUsers }}
                    </h3>


                </div>


            </div>


        </div>





        <div class="col-xl-3 col-md-6">


            <div class="user-summary-card">


                <div class="summary-icon warning">


                    <i class="bi bi-person-x"></i>


                </div>



                <div>


                    <span>
                        Disabled Users
                    </span>



                    <h3>
                        {{ $disabledUsers }}
                    </h3>


                </div>


            </div>


        </div>





        <div class="col-xl-3 col-md-6">


            <div class="user-summary-card">


                <div class="summary-icon info">


                    <i class="bi bi-shield-lock"></i>


                </div>



                <div>


                    <span>
                        Roles
                    </span>



                    <h3>
                        {{ $roleCount }}
                    </h3>


                </div>


            </div>


        </div>



    </div>






    {{-- Users Card --}}
    <div class="card users-card border-0 shadow-sm">


        <div class="card-body">



            {{-- Toolbar --}}
            <div class="users-toolbar mb-4">


                <div class="users-search">


                    <i class="bi bi-search"></i>


                    <input type="text"
                           class="form-control"
                           placeholder="Search users..."
                           id="userSearch">


                </div>




                <div class="d-flex gap-2">


                    <select class="form-select"
                            id="roleFilter">


                        <option value="">

                            All Roles

                        </option>


                        @foreach($roles as $role)


                            <option value="{{ $role->id }}">

                                {{ $role->displayLabel() }}

                            </option>


                        @endforeach


                    </select>





                    <select class="form-select"
                            id="branchFilter">


                        <option value="">

                            All Branches

                        </option>


                        @foreach($branches as $branch)


                            <option value="{{ $branch->id }}">

                                {{ $branch->name }}

                            </option>


                        @endforeach


                    </select>





                    <select class="form-select"
                            id="statusFilter">


                        <option value="">

                            All Status

                        </option>


                        <option value="1">

                            Active

                        </option>


                        <option value="0">

                            Disabled

                        </option>


                    </select>



                </div>



            </div>


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
    <li>

        <button
            class="dropdown-item"
            onclick="viewUser({{ $user->id }})">

            <i class="bi bi-eye me-2"></i>

            View Details

        </button>

    </li>



    {{-- Edit --}}
    <li>

        <button
            class="dropdown-item"
            onclick="openEditUserModal({{ $user->id }})">

            <i class="bi bi-pencil-square me-2"></i>

            Edit User

        </button>

    </li>



    <li>

        <hr class="dropdown-divider">

    </li>



    {{-- Reset Password --}}
    <li>

        <button
            class="dropdown-item"
            onclick="confirmResetPassword({{ $user->id }})">

            <i class="bi bi-key me-2"></i>

            Reset Password

        </button>

    </li>



    {{-- Toggle Status --}}
    <li>

        <button
            class="dropdown-item"
            onclick="toggleUserStatus({{ $user->id }})">

            @if($user->status)

                <i class="bi bi-person-x me-2 text-warning"></i>

                Disable User

            @else

                <i class="bi bi-person-check me-2 text-success"></i>

                Enable User

            @endif

        </button>

    </li>



    <li>

        <hr class="dropdown-divider">

    </li>



    {{-- Delete --}}
    <li>

        <button
            class="dropdown-item text-danger"
            onclick="confirmDeleteUser({{ $user->id }})">

            <i class="bi bi-trash me-2"></i>

            Delete User

        </button>

    </li>

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



</div>




    @include('users.modals.create')

    @include('users.modals.edit')

    @include('users.modals.delete')



<script>

const USERS = {

    store: "{{ route('users.store') }}",

    edit: "{{ url('users') }}/",

    update: "{{ url('users') }}/"

};

</script>
<script src="{{ asset('assets/js/users.js') }}"></script>


@endsection