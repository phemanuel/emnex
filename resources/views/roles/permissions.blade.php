@extends('layouts.app')

@section('title', 'Role Permissions')

@section('content')

<div class="container-fluid">

    {{-- ==========================================
    Permission Header
========================================== --}}
<div class="permission-header-card">

    <div class="permission-header-left">

        <a href="{{ route('roles.index') }}"
           class="permission-back">

            <i class="bi bi-arrow-left"></i>

            <span>Back to Roles</span>

        </a>

        <div class="permission-title">

            <div class="permission-icon">

                <i class="bi bi-shield-lock-fill"></i>

            </div>

            <div>

                <h2>

                    {{ $role->displayLabel() }}

                </h2>

                <p>

                    Configure the permissions assigned to this role across the EMNEX POS platform.

                </p>

            </div>

        </div>

    </div>

    <div class="permission-header-right">

        @permission('roles.assign_permissions')

        <button
            class="btn btn-primary btn-lg"
            id="savePermissionsBtn">

            <i class="bi bi-check-circle-fill me-2"></i>

            Save Changes

        </button>

        @endpermission

    </div>

</div>


<div class="permission-stats">

    <div class="permission-stat">

        <div class="permission-stat-icon bg-primary-subtle">

            <i class="bi bi-person-badge"></i>

        </div>

        <div>

            <small>Role Code</small>

            <h6>{{ $role->code }}</h6>

        </div>

    </div>


    <div class="permission-stat">

        <div class="permission-stat-icon bg-success-subtle">

            <i class="bi bi-grid-3x3-gap-fill"></i>

        </div>

        <div>

            <small>Modules</small>

            <h6>{{ $permissions->count() }}</h6>

        </div>

    </div>


    <div class="permission-stat">

        <div class="permission-stat-icon bg-warning-subtle">

            <i class="bi bi-shield-check"></i>

        </div>

        <div>

            <small>Assigned Permissions</small>

            <h6 id="selectedPermissionCount">

                {{ count($assignedPermissions) }}

            </h6>

        </div>

    </div>


    <div class="permission-stat">

        <div class="permission-stat-icon bg-info-subtle">

            <i class="bi bi-diagram-3"></i>

        </div>

        <div>

            <small>Total Modules</small>

            <h6>{{ $permissions->count() }}</h6>

        </div>

    </div>

</div>



    {{-- Toolbar --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <div class="position-relative">

                        <i class="bi bi-search permission-search-icon"></i>

                        <input
                            type="text"
                            id="permissionSearch"
                            class="form-control permission-search-input"
                            placeholder="Search permissions...">

                    </div>

                </div>

                <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">

                    <button
                        type="button"
                        class="btn btn-light"
                        id="selectAllBtn">

                        Select All

                    </button>

                    <button
                        type="button"
                        class="btn btn-light"
                        id="clearAllBtn">

                        Clear All

                    </button>

                </div>

            </div>

        </div>

    </div>



    <form id="permissionForm">

        @csrf

        <div class="row g-4">

            @foreach($permissions as $module => $items)

            <div
                class="col-xl-4 col-lg-6 permission-module">

                <div class="card permission-card h-100 border-0 shadow-sm">

                    <div class="card-header bg-white">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <h6 class="fw-bold mb-1">

                                    {{ $module }}

                                </h6>

                                <small class="text-muted">

                                    {{ $items->count() }} Permissions

                                </small>

                            </div>

                            <button
                                type="button"
                                class="btn btn-sm btn-outline-primary module-select-btn">

                                Select All

                            </button>

                        </div>

                    </div>

                    <div class="card-body">

                        @foreach($items as $permission)

                        <div class="permission-item">

                            <label
                                class="permission-label">

                                <input
                                    type="checkbox"
                                    class="permission-checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    {{ in_array($permission->id,$assignedPermissions) ? 'checked' : '' }}>

                                <span>

                                    {{ $permission->display_name }}

                                </span>

                            </label>

                        </div>

                        @endforeach

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </form>



    {{-- Sticky Save Bar --}}

    <div
        class="permission-save-bar"
        id="permissionSaveBar">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <strong id="footerPermissionCount">

                    {{ count($assignedPermissions) }}

                </strong>

                permissions selected

            </div>

            <div>

                <button
                    type="button"
                    class="btn btn-light me-2"
                    id="cancelPermissionChanges">

                    Cancel

                </button>

                @permission('roles.assign_permissions')

                <button
                    type="button"
                    class="btn btn-primary"
                    id="savePermissionsFooterBtn">

                    <i class="bi bi-check-circle me-2"></i>

                    Save Changes

                </button>

                @endpermission

            </div>

        </div>

    </div>

</div>


{{-- Bottom Action Bar --}}
<div class="permission-footer-actions">

    <div>

        <h6 class="mb-1">

            Finished reviewing permissions?

        </h6>

        <small class="text-muted">

            Click <strong>Save Changes</strong> to apply your updates to this role.

        </small>

    </div>

    <div class="d-flex gap-2">

        <a href="{{ route('roles.index') }}"
           class="btn btn-light">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

        <button
            type="button"
            class="btn btn-primary"
            id="savePermissionsBtnBottom">

            <i class="bi bi-check-circle-fill me-2"></i>

            Save Changes

        </button>

    </div>

</div>
@endsection


<script>

    window.roleId = {{ $role->id }};

</script>

<script>
    const topSaveBtn = document.getElementById('savePermissionsBtn');
const bottomSaveBtn = document.getElementById('savePermissionsBtnBottom');

if (topSaveBtn) {

    topSaveBtn.addEventListener('click', savePermissions);

}

if (bottomSaveBtn) {

    bottomSaveBtn.addEventListener('click', savePermissions);

}
</script>

<script src="{{ asset('assets/js/role-permissions.js') }}"></script>
