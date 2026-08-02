<!-- ==========================================================
    Audit Log Inspector
=========================================================== -->

<div
    class="offcanvas offcanvas-end"
    tabindex="-1"
    id="activityLogInspector"
    aria-labelledby="activityLogInspectorLabel">

    <!-- ===================================== -->
    <!-- Header -->
    <!-- ===================================== -->

    <div class="offcanvas-header border-bottom">

        <div>

            <h5
                class="offcanvas-title"
                id="activityLogInspectorLabel">

                <i class="bi bi-journal-text me-2"></i>

                Audit Log Details

            </h5>

            <small class="text-muted">
                Complete activity information
            </small>

        </div>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>

    </div>

    <!-- ===================================== -->
    <!-- Body -->
    <!-- ===================================== -->

    <div
        class="offcanvas-body p-0"
        id="activityLogInspectorContent">

        <!-- ================================= -->
        <!-- Loading -->
        <!-- ================================= -->

        <div class="audit-loader">

            <div class="text-center">

                <div
                    class="spinner-border text-primary mb-3"
                    role="status">
                </div>

                <div class="text-muted">

                    Loading activity details...

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================================
    Inspector Templates (AJAX)
=========================================================== -->

<template id="activityLogInspectorTemplate">

    <div class="p-4">

        <!-- ===================================== -->
        <!-- Activity Summary -->
        <!-- ===================================== -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <span class="audit-label">

                            Module

                        </span>

                        <h5
                            class="mb-1"
                            id="logModule">

                            —

                        </h5>

                    </div>

                    <span
                        class="badge fs-6"
                        id="logActionBadge">

                        —

                    </span>

                </div>

                <hr>

                <div class="row g-3">

                    <div class="col-12">

                        <span class="audit-label">

                            Description

                        </span>

                        <div id="logDescription">

                            —

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================== -->
        <!-- User Information -->
        <!-- ===================================== -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white">

                <strong>

                    User Information

                </strong>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-12">

                        <span class="audit-label">

                            User

                        </span>

                        <div id="logUser">

                            —

                        </div>

                    </div>

                    <div class="col-12">

                        <span class="audit-label">

                            Email

                        </span>

                        <div id="logEmail">

                            —

                        </div>

                    </div>

                    <div class="col-md-6">

                        <span class="audit-label">

                            Branch

                        </span>

                        <div id="logBranch">

                            —

                        </div>

                    </div>

                    <div class="col-md-6">

                        <span class="audit-label">

                            Terminal

                        </span>

                        <div id="logTerminal">

                            —

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================== -->
        <!-- Record Information -->
        <!-- ===================================== -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white">

                <strong>

                    Record Information

                </strong>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <span class="audit-label">

                            Record Type

                        </span>

                        <div id="logRecordType">

                            —

                        </div>

                    </div>

                    <div class="col-md-6">

                        <span class="audit-label">

                            Record ID

                        </span>

                        <div id="logRecordId">

                            —

                        </div>

                    </div>

                    <div class="col-md-6">

                        <span class="audit-label">

                            Date

                        </span>

                        <div id="logDate">

                            —

                        </div>

                    </div>

                    <div class="col-md-6">

                        <span class="audit-label">

                            Time

                        </span>

                        <div id="logTime">

                            —

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================== -->
        <!-- Request Information -->
        <!-- ===================================== -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white">

                <strong>

                    Request Information

                </strong>

            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-4">

                        <span class="audit-label">

                            Method

                        </span>

                        <div id="logMethod">

                            —

                        </div>

                    </div>

                    <div class="col-md-8">

                        <span class="audit-label">

                            URL

                        </span>

                        <div
                            id="logUrl"
                            class="text-break">

                            —

                        </div>

                    </div>

                    <div class="col-12">

                        <span class="audit-label">

                            IP Address

                        </span>

                        <div id="logIp">

                            —

                        </div>

                    </div>

                    <div class="col-12">

                        <span class="audit-label">

                            User Agent

                        </span>

                        <div
                            id="logUserAgent"
                            class="small text-muted text-break">

                            —

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ===================================== -->
        <!-- Data Changes -->
        <!-- ===================================== -->

        <div
            class="card border-0 shadow-sm mb-4"
            id="changesCard">

            <div class="card-header bg-white">

                <strong>

                    Data Changes

                </strong>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-lg-6">

                        <span class="audit-label">

                            Previous Values

                        </span>

                        <pre
                            class="bg-light rounded p-3 small mb-0"
                            id="oldValues">
—
</pre>

                    </div>

                    <div class="col-lg-6">

                        <span class="audit-label">

                            New Values

                        </span>

                        <pre
                            class="bg-light rounded p-3 small mb-0"
                            id="newValues">
—
</pre>

                    </div>

                </div>

            </div>

        </div>

    </div>

</template>

<!-- ==========================================================
    Error Template
=========================================================== -->

<template id="activityLogInspectorError">

    <div class="audit-loader">

        <div class="text-center">

            <i class="bi bi-exclamation-triangle display-4 text-danger mb-3"></i>

            <h5>

                Unable to Load Activity

            </h5>

            <p class="text-muted mb-0">

                An error occurred while loading the selected audit log.

            </p>

        </div>

    </div>

</template>