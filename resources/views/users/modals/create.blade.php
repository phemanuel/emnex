<div class="modal fade"
     id="createUserModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered emx-user-create-dialog">

        <div class="modal-content emx-user-create-container">

            <form id="createUserForm">

                @csrf

                {{-- =========================
                    Header
                ========================== --}}
                <div class="emx-user-create-header">

                    <div>

                        <h4 class="emx-user-create-title">

                            <i class="bi bi-person-plus-fill"></i>

                            Create New User

                        </h4>

                        <p class="emx-user-create-subtitle">

                            Create a new employee account and assign access permissions.

                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                    </button>

                </div>



                {{-- =========================
                    Scrollable Content
                ========================== --}}
                <div class="emx-user-create-content">



                    {{-- PERSONAL INFORMATION --}}
                    <div class="emx-user-card">

                        <div class="emx-user-card-header">

                            <div class="emx-user-card-icon">

                                <i class="bi bi-person"></i>

                            </div>

                            <div>

                                <h6>

                                    Personal Information

                                </h6>

                                <small>

                                    Basic personal details.

                                </small>

                            </div>

                        </div>

                        <div class="row g-4">

                        <div class="col-md-4">

                                <label class="form-label">

                                    Last Name
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="last_name"
                                    name="last_name">

                                <div class="invalid-feedback"></div>

                            </div>


                            <div class="col-md-4">

                                <label class="form-label">

                                    First Name
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="first_name"
                                    name="first_name">

                                <div class="invalid-feedback"></div>

                            </div>                           


                            <div class="col-md-4">

                                <label class="form-label">

                                    Other Name

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="other_name"
                                    name="other_name">

                            </div>



                            <div class="col-md-4">

                                <label class="form-label">

                                    Gender

                                </label>

                                <select
                                    class="form-select"
                                    id="gender"
                                    name="gender">

                                    <option value="">

                                        Select Gender

                                    </option>

                                    <option value="Male">

                                        Male

                                    </option>

                                    <option value="Female">

                                        Female

                                    </option>

                                </select>

                            </div>



                            <div class="col-md-4">

                                <label class="form-label">

                                    Date of Birth

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="date_of_birth"
                                    name="date_of_birth">

                            </div>



                            <div class="col-md-4">

                                <label class="form-label">

                                    Phone Number

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone">

                            </div>



                            <div class="col-12">

                                <label class="form-label">

                                    Address

                                </label>

                                <textarea
                                    class="form-control"
                                    rows="3"
                                    id="address"
                                    name="address"></textarea>

                            </div>

                        </div>

                    </div>



                    {{-- EMPLOYMENT --}}
                    <div class="emx-user-card">

                        <div class="emx-user-card-header">

                            <div class="emx-user-card-icon">

                                <i class="bi bi-briefcase"></i>

                            </div>

                            <div>

                                <h6>

                                    Employment Information

                                </h6>

                                <small>

                                    Branch and role assignment.

                                </small>

                            </div>

                        </div>

                        <div class="row g-4">

                            <div class="col-md-3">

                                <label class="form-label">

                                    Employee No

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="employee_no"
                                    name="employee_no">

                            </div>



                            <div class="col-md-3">

                                <label class="form-label">

                                    Role

                                </label>

                                <select
                                    class="form-select"
                                    id="role_id"
                                    name="role_id">

                                    <option value="">

                                        Select Role

                                    </option>

                                    @foreach($roles as $role)

                                        <option value="{{ $role->id }}">

                                            {{ $role->displayLabel() }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <div class="col-md-3">

                                <label class="form-label">

                                    Branch

                                </label>

                                <select
                                    class="form-select"
                                    id="branch_id"
                                    name="branch_id">

                                    <option value="">

                                        Select Branch

                                    </option>

                                    @foreach($branches as $branch)

                                        <option value="{{ $branch->id }}">

                                            {{ $branch->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>



                            <div class="col-md-3">

                                <label class="form-label">

                                    Employment Date

                                </label>

                                <input
                                    type="date"
                                    class="form-control"
                                    id="employment_date"
                                    name="employment_date">

                            </div>

                        </div>

                    </div>



                    {{-- ACCOUNT --}}
                    <div class="emx-user-card">

                        <div class="emx-user-card-header">

                            <div class="emx-user-card-icon">

                                <i class="bi bi-shield-lock"></i>

                            </div>

                            <div>

                                <h6>

                                    Account Information

                                </h6>

                                <small>

                                    Login credentials and status.

                                </small>

                            </div>

                        </div>

                        <div class="row g-4">

                            <div class="col-md-4">

                                <label class="form-label">

                                    Email Address
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email">

                                <div class="invalid-feedback"></div>

                            </div>



                            <div class="col-md-4">

                                <label class="form-label">

                                    Username
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="username"
                                    name="username">

                                <div class="invalid-feedback"></div>

                            </div>



                            <div class="col-md-4">

                                <label class="form-label">

                                    Password
                                    <span class="text-danger">*</span>

                                </label>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password">

                                <div class="invalid-feedback"></div>

                            </div>



                            <div class="col-md-4">

                                <label class="form-label">

                                    Status

                                </label>

                                <select
                                    class="form-select"
                                    id="status"
                                    name="status">

                                    <option value="1">

                                        Active

                                    </option>

                                    <option value="0">

                                        Disabled

                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>



                    {{-- NOTES --}}
                    <div class="emx-user-card">

                        <div class="emx-user-card-header">

                            <div class="emx-user-card-icon">

                                <i class="bi bi-journal-text"></i>

                            </div>

                            <div>

                                <h6>

                                    Additional Notes

                                </h6>

                                <small>

                                    Optional internal remarks.

                                </small>

                            </div>

                        </div>

                        <textarea
                            class="form-control"
                            rows="4"
                            id="notes"
                            name="notes"
                            placeholder="Enter notes..."></textarea>

                    </div>



                </div>



                {{-- =========================
                    Footer
                ========================== --}}
                <div class="emx-user-create-footer">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button 
                type="submit"
                class="btn btn-primary">

                Create User

                </button>

                </div>

            </form>

        </div>

    </div>

</div>