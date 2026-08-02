<!-- ===================================== -->
    <!-- Table -->
    <!-- ===================================== -->

    <div class="table-responsive">

        <table class="table audit-modern-table">

            <thead>

                <tr>

                    <th style="width:170px">

                        Time

                    </th>

                    <th>

                        Activity

                    </th>

                    <th style="width:260px">

                        User

                    </th>

                    <th style="width:200px">

                        Location

                    </th>

                    <th class="text-center" width="80">

                        View

                    </th>

                </tr>

            </thead>

            <tbody id="auditTable">

            @forelse($activityLogs as $log)

                <tr

                    data-module="{{ strtolower($log->module) }}"
                    data-action="{{ strtolower($log->action) }}"
                    data-search="{{ strtolower(($log->description ?? '') . ' ' . ($log->module ?? '') . ' ' . ($log->action ?? '') . ' ' . (optional($log->user)->full_name ?? '') . ' ' . (optional($log->branch)->name ?? '')) }}"

                >

                    <!-- Time -->

                    <td>

                        <div class="audit-time">

                            <strong>

                                {{ $log->created_at->diffForHumans() }}

                            </strong>

                            <small>

                                {{ $log->created_at->format('d M Y • h:i A') }}

                            </small>

                        </div>

                    </td>

                    <!-- Activity -->

                    <td>

                        <div class="audit-activity">

                            <span class="activity-badge activity-{{ strtolower($log->action) }}">

                                {{ strtoupper($log->action) }}

                            </span>

                            <div class="activity-content">

                                <div class="activity-description">

                                    {{ $log->description }}

                                </div>

                                <div class="activity-meta">

                                    <span>

                                        {{ ucfirst($log->module) }}

                                    </span>

                                    @if($log->record_id)

                                        <span>

                                            Record #{{ $log->record_id }}

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </td>

                    <!-- User -->

                    <td>

                        <div class="audit-user-card">

                            <div class="audit-avatar">

                                {{ strtoupper(substr(optional($log->user)->first_name ?? 'S',0,1)) }}

                            </div>

                            <div>

                                <div class="audit-user-name">

                                    {{ optional($log->user)->full_name ?? 'System' }}

                                </div>

                                <div class="audit-user-role">

                                    {{ optional(optional($log->user)->role)->name ?? 'System User' }}

                                </div>

                            </div>

                        </div>

                    </td>

                    <!-- Branch -->

                    <td>

                        <div class="audit-location">

                            <div>

                                <i class="bi bi-building"></i>

                                {{ optional($log->branch)->name ?? '-' }}

                            </div>

                            <div>

                                <i class="bi bi-pc-display"></i>

                                {{ optional($log->terminal)->name ?? '-' }}

                            </div>

                        </div>

                    </td>

                    <!-- Action -->

                    <td class="text-center">

                        <button

                            class="btn btn-inspect"

                            onclick="ActivityLogs.openInspector({{ $log->id }})">

                            <i class="bi bi-arrow-right-circle"></i>

                        </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5">

                        <div class="audit-empty">

                            <i class="bi bi-clock-history"></i>

                            <h5>

                                No Activity Found

                            </h5>

                            <p>

                                Audit events generated across the company will appear here.

                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <!-- ===================================== -->
    <!-- Footer -->
    <!-- ===================================== -->

    <div class="audit-footer">

        {{ $activityLogs->links() }}

    </div>