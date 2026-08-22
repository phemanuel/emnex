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

        @permission('users.create')

        <button 
            class="btn btn-primary"
            id="openCreateUserModal">

            <i class="bi bi-person-plus"></i>
            New User

        </button>

        @endpermission


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
            <form
                method="GET"
                action="{{ route('users.index') }}"
                class="users-toolbar mb-4"
            >

                <div class="users-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        class="form-control"
                        placeholder="Search users..."
                        id="userSearch"
                        value="{{ request('search') }}"
                    >

                </div>


                <div class="d-flex gap-2">

                    <select
                        class="form-select"
                        id="roleFilter"
                    >

                        <option value="">
                            All Roles
                        </option>

                        @foreach($roles as $role)

                            <option
                                value="{{ $role->id }}"
                                {{ request('role') == $role->id ? 'selected' : '' }}
                            >

                                {{ $role->displayLabel() }}

                            </option>

                        @endforeach

                    </select>



                    <select
                        class="form-select"
                        id="branchFilter"
                    >

                        <option value="">
                            All Branches
                        </option>

                        @foreach($branches as $branch)

                            <option
                                value="{{ $branch->id }}"
                                {{ request('branch') == $branch->id ? 'selected' : '' }}
                            >

                                {{ $branch->name }}

                            </option>

                        @endforeach

                    </select>



                    <select
                        class="form-select"
                        id="statusFilter"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="1"
                            {{ request('status') === '1' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="0"
                            {{ request('status') === '0' ? 'selected' : '' }}
                        >
                            Disabled
                        </option>

                    </select>


                    <!-- <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-search"></i>
                    </button> -->

                </div>

            </form>
            
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


        <tbody id="usersTableBody">

            <tr>

                <td colspan="6">

                    <div class="text-center py-5">

                        <div class="spinner-border text-primary"></div>

                        <p class="text-muted mt-3 mb-0">
                            Loading users...
                        </p>

                    </div>

                </td>

            </tr>

        </tbody>

    </table>

</div>

<div
    id="usersPagination"
    class="mt-4"
>
</div>


</div>




    @include('users.modals.create')

    @include('users.modals.edit')

    @include('users.modals.delete')

    @include('users.modals.reset-password')

    @include('users.panels.details')

    @include('users.modals.toggle-status')



<script>

const USERS = {

    store: "{{ route('users.store') }}",

    edit: "{{ url('users') }}/",

    update: "{{ url('users') }}",

    details: "{{ url('users') }}",

    resetPassword: "{{ url('users') }}",

    toggleStatus: "{{ url('users') }}",    

    destroy: "{{ url('users') }}"
    

};

</script>

<script>

    window.usersPermission = {

        view:
            @json(canAccess('users.view')),

        update:
            @json(canAccess('users.update')),

        resetPassword:
            @json(canAccess('users.reset_password')),

        delete:
            @json(canAccess('users.delete'))

    };

</script>

<script>

    window.usersRoutes = {

        table: "{{ route('users.table') }}"

    };

</script>

<script src="{{ asset('assets/js/users.js') }}"></script>


@endsection