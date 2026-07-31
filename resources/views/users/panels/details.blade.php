<div
    class="emx-user-panel"
    id="userDetailsPanel">

    {{-- Backdrop --}}
    <div
        class="emx-user-panel-backdrop"
        onclick="closeUserDetailsPanel()"></div>

    {{-- Panel --}}
    <div class="emx-user-panel-content">

        {{-- ==========================
            Header
        ========================== --}}
        <div class="emx-user-panel-header">

            <div>

                <h4>

                    <i class="bi bi-person-vcard-fill"></i>

                    User Details

                </h4>

                <small>

                    View employee profile and account information.

                </small>

            </div>

            <button
                type="button"
                class="btn-close"
                onclick="closeUserDetailsPanel()"></button>

        </div>



        {{-- ==========================
            Profile Card
        ========================== --}}
        <div class="emx-user-profile">

            <div
                class="emx-user-avatar"
                id="detailAvatar">

                PA

            </div>

            <h4 id="detailFullName">

                Paul Awolola

            </h4>

            <div class="emx-user-profile-meta">

                <span
                    class="badge bg-primary"
                    id="detailRole">

                    Administrator

                </span>

                <span
                    class="badge bg-secondary"
                    id="detailBranch">

                    Lekki Branch

                </span>

                <span
                    class="badge bg-success"
                    id="detailStatus">

                    Active

                </span>

            </div>

        </div>



        {{-- ==========================
            Scrollable Body
        ========================== --}}
        <div class="emx-user-panel-body">



            {{-- Personal --}}
            <div class="emx-user-info-card">

                <div class="emx-user-info-title">

                    <i class="bi bi-person"></i>

                    Personal Information

                </div>

                <div class="emx-info-grid">

                    <div>

                        <label>Employee No</label>

                        <span id="detailEmployeeNo">-</span>

                    </div>

                    <div>

                        <label>Username</label>

                        <span id="detailUsername">-</span>

                    </div>

                    <div>

                        <label>Email</label>

                        <span id="detailEmail">-</span>

                    </div>

                    <div>

                        <label>Phone</label>

                        <span id="detailPhone">-</span>

                    </div>

                    <div>

                        <label>Gender</label>

                        <span id="detailGender">-</span>

                    </div>

                    <div>

                        <label>Date of Birth</label>

                        <span id="detailDOB">-</span>

                    </div>

                </div>

            </div>



            {{-- Employment --}}
            <div class="emx-user-info-card">

                <div class="emx-user-info-title">

                    <i class="bi bi-briefcase"></i>

                    Employment Information

                </div>

                <div class="emx-info-grid">

                    <div>

                        <label>Branch</label>

                        <span id="detailBranchName">-</span>

                    </div>

                    <div>

                        <label>Role</label>

                        <span id="detailRoleName">-</span>

                    </div>

                    <div>

                        <label>Employment Date</label>

                        <span id="detailEmploymentDate">-</span>

                    </div>

                </div>

            </div>



            {{-- Address --}}
            <div class="emx-user-info-card">

                <div class="emx-user-info-title">

                    <i class="bi bi-geo-alt"></i>

                    Address

                </div>

                <p id="detailAddress">

                    -

                </p>

            </div>



            {{-- Notes --}}
            <div class="emx-user-info-card">

                <div class="emx-user-info-title">

                    <i class="bi bi-journal-text"></i>

                    Notes

                </div>

                <p id="detailNotes">

                    -

                </p>

            </div>



            {{-- Audit --}}
            <div class="emx-user-info-card">

                <div class="emx-user-info-title">

                    <i class="bi bi-clock-history"></i>

                    Audit Information

                </div>

                <div class="emx-info-grid">

                    <div>

                        <label>Created</label>

                        <span id="detailCreated">-</span>

                    </div>

                    <div>

                        <label>Updated</label>

                        <span id="detailUpdated">-</span>

                    </div>

                </div>

            </div>

        </div>



        {{-- ==========================
            Footer
        ========================== --}}
        <div class="emx-user-panel-footer">

            <button
                class="btn btn-outline-primary"
                id="panelEditUser">

                <i class="bi bi-pencil-square"></i>

                Edit

            </button>

            <button
                class="btn btn-outline-warning"
                id="panelResetPassword">

                <i class="bi bi-key"></i>

                Reset Password

            </button>

            <button
                class="btn btn-outline-secondary"
                id="panelToggleStatus">

                <i class="bi bi-person-lock"></i>

                Disable

            </button>

            <button
                class="btn btn-outline-danger"
                id="panelDeleteUser">

                <i class="bi bi-trash"></i>

                Delete

            </button>

        </div>

    </div>

</div>