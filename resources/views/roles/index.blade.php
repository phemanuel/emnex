@extends('layouts.app')

@section('content')

<div class="container-fluid">


    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Roles Management
            </h4>

            <p class="text-muted mb-0">
                Manage user roles and access permissions.
            </p>

        </div>



        @permission('roles.create')

        <button
            class="btn btn-primary"
            onclick="openCreateRoleModal()">

            <i class="bi bi-plus-circle me-1"></i>

            Add Role

        </button>

        @endpermission


    </div>





    @include('components.alerts')





    {{-- Roles Card --}}
    <div class="card border-0 shadow-sm">


        <div class="card-body">


            <div class="table-responsive">


                <table class="table align-middle"
                       id="rolesTable">


                    <thead class="table-light">


                        <tr>

                            <th>
                                Role
                            </th>

                            <th>
                                Code
                            </th>

                            <th>
                                Users
                            </th>

                            <th>
                                Permissions
                            </th>

                            <th>
                                Status
                            </th>

                            <th class="text-end">
                                Actions
                            </th>


                        </tr>


                    </thead>



                    <tbody id="rolesTableBody">


                    @foreach($roles as $role)


                    <tr id="roleRow{{ $role->id }}">


                        <td>


                            <div class="fw-semibold">

                                {{ $role->displayLabel() }}

                            </div>


                            <small class="text-muted">

                                {{ Str::limit($role->description,50) }}

                            </small>


                        </td>




                        <td>

                            <code>

                                {{ $role->code }}

                            </code>

                        </td>




                        <td>

                            <span class="badge bg-light text-dark">

                                {{ $role->users_count }}

                            </span>

                        </td>




                        <td>

                            <span class="badge bg-light text-dark">

                                {{ $role->permissions_count }}

                            </span>

                        </td>




                        <td>


                            @if($role->status)

                                <span class="badge bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Disabled
                                </span>

                            @endif


                        </td>





                        <td class="text-end">


                            <div class="dropdown">


                                <button
                                    class="btn btn-sm btn-light"
                                    data-bs-toggle="dropdown">

                                    <i class="bi bi-three-dots"></i>

                                </button>



                                <ul class="dropdown-menu dropdown-menu-end">



                                    @permission('roles.update')

                                    <li>

                                        <button
                                            class="dropdown-item"
                                            onclick="openEditRoleModal({{ $role->id }})">


                                            <i class="bi bi-pencil me-2"></i>

                                            Edit


                                        </button>

                                    </li>

                                    @endpermission





                                    @permission('roles.permissions')

                                    <li>

                                        <a class="dropdown-item"
                                           href="{{ route('roles.permissions',$role) }}">


                                            <i class="bi bi-shield-lock me-2"></i>

                                            Permissions


                                        </a>


                                    </li>

                                    @endpermission






                                    @permission('roles.delete')


                                    @if(!$role->is_system)

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>


                                    <li>


                                        <button
                                            class="dropdown-item text-danger"
                                            onclick="confirmDeleteRole({{ $role->id }})">


                                            <i class="bi bi-trash me-2"></i>

                                            Delete


                                        </button>


                                    </li>


                                    @endif


                                    @endpermission



                                </ul>


                            </div>


                        </td>


                    </tr>


                    @endforeach



                    </tbody>


                </table>


            </div>



            <div class="mt-3">

                {{ $roles->links() }}

            </div>


        </div>


    </div>


</div>


<!-- EMNEX Modal -->
<div class="emnex-modal-overlay" id="roleModal">

    <div class="emnex-modal emnex-modal-xl">

        <!-- Header -->
        <div class="emnex-modal-header">

            <div>

                <h4 id="roleModalTitle">

                    <i class="bi bi-shield-lock-fill text-primary me-2"></i>

                    Create Role

                </h4>

                <small>

                    Define a security role and control access permissions.

                </small>

            </div>

            <button
                class="emnex-modal-close"
                onclick="closeRoleModal()">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <form id="roleForm">

            @csrf

            <div class="emnex-modal-body">

                {{-- KEEP YOUR EXISTING FORM HERE --}}

                <form id="roleForm">

                @csrf

                <div class="modal-body">

                    <div class="row g-4">

                        <!-- LEFT -->
                        <div class="col-lg-8">

                            <div class="card border-0 shadow-sm">

                                <div class="card-header bg-white">

                                    <h6 class="fw-bold mb-0">

                                        <i class="bi bi-info-circle text-primary me-2"></i>

                                        General Information

                                    </h6>

                                </div>

                                <div class="card-body">

                                    <div class="row g-3">

                                        <!-- Role Name -->
                                        <div class="col-md-6">

                                            <label class="form-label fw-semibold">

                                                Role Name

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">

                                                    <i class="bi bi-person-badge"></i>

                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="name"
                                                    name="name"
                                                    placeholder="e.g Administrator">

                                            </div>

                                            <small class="text-muted">

                                                Internal role name.

                                            </small>

                                        </div>

                                        <!-- Role Code -->
                                        <div class="col-md-6">

                                            <label class="form-label fw-semibold">

                                                Role Code

                                                <span class="text-danger">*</span>

                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">

                                                    <i class="bi bi-key-fill"></i>

                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="code"
                                                    name="code"
                                                    placeholder="administrator">

                                            </div>

                                            <small class="text-muted">

                                                Used by the authorization engine.

                                            </small>

                                        </div>

                                        <!-- Display Name -->
                                        <div class="col-12">

                                            <label class="form-label fw-semibold">

                                                Display Name

                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text">

                                                    <i class="bi bi-card-heading"></i>

                                                </span>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="display_name"
                                                    name="display_name"
                                                    placeholder="Administrator">

                                            </div>

                                            <small class="text-muted">

                                                Friendly name displayed throughout the system.

                                            </small>

                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">

                                            <label class="form-label fw-semibold">

                                                Description

                                            </label>

                                            <textarea
                                                class="form-control"
                                                rows="5"
                                                id="description"
                                                name="description"
                                                placeholder="Describe the responsibilities of this role..."></textarea>

                                            <small class="text-muted">

                                                This helps administrators understand the purpose of the role.

                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- RIGHT -->
                        <div class="col-lg-4">

                            <div class="card border-0 shadow-sm">

                                <div class="card-header bg-white">

                                    <h6 class="fw-bold mb-0">

                                        <i class="bi bi-sliders text-primary me-2"></i>

                                        Role Settings

                                    </h6>

                                </div>

                                <div class="card-body">

                                    <label class="form-label fw-semibold">

                                        Status

                                    </label>

                                    <div class="form-check form-switch mb-3">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="status"
                                            name="status"
                                            value="1"
                                            checked>

                                        <label
                                            class="form-check-label"
                                            for="status">

                                            Active Role

                                        </label>

                                    </div>

                                    <hr>

                                    <div class="alert alert-light border">

                                        <h6 class="fw-bold">

                                            <i class="bi bi-lightbulb text-warning me-2"></i>

                                            Information

                                        </h6>

                                        <ul class="small mb-0 ps-3">

                                            <li>Permissions are assigned after the role is created.</li>

                                            <li>Users inherit permissions from their assigned role.</li>

                                            <li>Inactive roles cannot be assigned to new users.</li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer border-top">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                        id="saveRoleBtn">

                        <i class="bi bi-check-circle me-2"></i>

                        Save Role

                    </button>

                </div>

            </form>


            </div>


            <div class="emnex-modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    onclick="closeRoleModal()">

                    Cancel

                </button>

                <button
                    class="btn btn-primary"
                    id="saveRoleBtn"
                    type="submit">

                    <i class="bi bi-check-circle me-2"></i>

                    Save Role

                </button>

            </div>

        </form>

    </div>

</div>



<!-- ==========================================================
    EMNEX Delete Role Modal
=========================================================== -->

<div
    class="emnex-modal-overlay"
    id="deleteRoleModal">

    <div class="emnex-modal emnex-modal-confirm">

        <!-- Header -->

        <div class="emnex-modal-header border-danger">

            <div>

                <h4 class="mb-1 text-danger">

                    <i class="bi bi-trash-fill me-2"></i>

                    Delete Role

                </h4>

                <small class="text-muted">

                    This action cannot be undone.

                </small>

            </div>

            <button
                type="button"
                class="emnex-modal-close"
                onclick="Role.closeDelete()">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>

        <!-- Body -->

        <div class="emnex-modal-body">

            <div class="text-center py-3">

                <div class="delete-icon mb-4">

                    <i class="bi bi-exclamation-triangle-fill"></i>

                </div>

                <h5 class="fw-bold">

                    Delete this role?

                </h5>

                <p class="text-muted mb-0">

                    You are about to permanently remove this role.

                    Users assigned to this role may lose access to the system.

                </p>

            </div>

        </div>

        <!-- Footer -->

        <div class="emnex-modal-footer">

            <button
                type="button"
                class="btn btn-light"
                onclick="Role.closeDelete()">

                Cancel

            </button>

            <button
                type="button"
                class="btn btn-danger"
                id="deleteRoleBtn"
                onclick="Role.delete()">

                <i class="bi bi-trash me-2"></i>

                Delete Role

            </button>

        </div>

    </div>

</div>

<script src="{{ asset('assets/js/admin/roles.js') }}"></script>
@endsection


