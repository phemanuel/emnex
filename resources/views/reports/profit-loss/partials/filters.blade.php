<div class="card profit-loss-filter-card mb-4">
    <div class="card-body">

        {{-- -------------------------------------------------------------------
             Filter Header
        -------------------------------------------------------------------- --}}

        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">

            <div>
                <h6 class="mb-1 fw-semibold">
                    Report Filters
                </h6>

                <p class="text-muted small mb-0">
                    Select the reporting period and branch to analyse profitability.
                </p>
            </div>

            <div class="d-flex align-items-center gap-2">

                <button
                    type="button"
                    class="btn btn-outline-secondary btn-sm"
                    id="profitLossResetBtn"
                >
                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Reset
                </button>

                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    id="profitLossApplyBtn"
                >
                    <i class="bi bi-funnel me-1"></i>
                    Apply Filters
                </button>

            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Filters
        -------------------------------------------------------------------- --}}

        <div class="row g-3">

            {{-- Period Preset --}}
            <div class="col-12 col-md-6 col-xl-3">
                <label
                    for="profitLossDatePreset"
                    class="form-label"
                >
                    Period
                </label>

                <select
                    class="form-select"
                    id="profitLossDatePreset"
                >
                    <option value="this_month">
                        This Month
                    </option>

                    <option value="last_month">
                        Last Month
                    </option>

                    <option value="this_quarter">
                        This Quarter
                    </option>

                    <option value="last_quarter">
                        Last Quarter
                    </option>

                    <option value="this_year">
                        This Year
                    </option>

                    <option value="last_year">
                        Last Year
                    </option>

                    <option value="custom">
                        Custom Range
                    </option>
                </select>
            </div>


            {{-- Date From --}}
            <div class="col-12 col-md-6 col-xl-3">
                <label
                    for="profitLossDateFrom"
                    class="form-label"
                >
                    Date From
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="profitLossDateFrom"
                    name="date_from"
                >
            </div>


            {{-- Date To --}}
            <div class="col-12 col-md-6 col-xl-3">
                <label
                    for="profitLossDateTo"
                    class="form-label"
                >
                    Date To
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="profitLossDateTo"
                    name="date_to"
                >
            </div>


            {{-- Branch --}}
            <div class="col-12 col-md-6 col-xl-3">
                <label
                    for="profitLossBranch"
                    class="form-label"
                >
                    Branch
                </label>

                <select
                    class="form-select"
                    id="profitLossBranch"
                    name="branch_id"
                >

                    @if(
                        $filters['branches']->count() > 1 ||
                        auth()->user()->isOwner() ||
                        auth()->user()->hasRole('administrator')
                    )
                        <option value="">
                            All Branches
                        </option>
                    @endif

                    @foreach($filters['branches'] as $branch)
                        <option value="{{ $branch->id }}">
                            {{ $branch->name }}
                        </option>
                    @endforeach

                </select>
            </div>

        </div>


        {{-- -------------------------------------------------------------------
             Active Filter Summary
        -------------------------------------------------------------------- --}}

        <div
            class="profit-loss-filter-summary"
            id="profitLossFilterSummary"
        >

            <span class="profit-loss-filter-summary-label">
                Active filters:
            </span>

            <span
                class="profit-loss-filter-badge"
                id="profitLossDateSummary"
            >
                <i class="bi bi-calendar3"></i>
                <span>Current Period</span>
            </span>

            <span
                class="profit-loss-filter-badge"
                id="profitLossBranchSummary"
            >
                <i class="bi bi-building"></i>
                <span>All Branches</span>
            </span>

        </div>

    </div>
</div>

