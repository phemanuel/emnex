<table class="table terminal-table mb-0">

                <thead>
                    <tr>

                        <th>
                            Terminal
                        </th>

                        <th>
                            Branch
                        </th>

                        <th>
                            Assigned Cashier
                        </th>

                        <th>
                            Device
                        </th>

                        <th>
                            IP Address
                        </th>

                        <th>
                            Status
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>
                </thead>


                <tbody id="terminalTable">

                    @forelse($terminals as $terminal)

                        <tr
                            class="terminal-row"
                            data-id="{{ $terminal->id }}"
                        >

                            {{-- ==================================================
                                TERMINAL
                                ================================================== --}}
                            <td>

                                <div class="terminal-name">
                                    {{ $terminal->terminal_name }}
                                </div>

                                <div class="terminal-code">
                                    {{ $terminal->terminal_code }}
                                </div>

                            </td>


                            {{-- ==================================================
                                BRANCH
                                ================================================== --}}
                            <td>

                                <div class="fw-semibold">
                                    {{ $terminal->branch->name ?? 'N/A' }}
                                </div>

                            </td>


                            {{-- ==================================================
                                ASSIGNED CASHIER
                                ================================================== --}}
                            <td>

                                @if($terminal->activeAssignment?->user)

                                    <div class="terminal-cashier">

                                        <div class="terminal-cashier-avatar">

                                            <i class="bi bi-person"></i>

                                        </div>

                                        <div class="terminal-cashier-info">

                                            <div class="terminal-cashier-name">

                                                {{ $terminal->activeAssignment->user->full_name }}

                                            </div>

                                            <div class="terminal-cashier-status">

                                                <span class="terminal-assignment-dot"></span>

                                                In Use

                                            </div>

                                        </div>

                                    </div>

                                @else

                                    <div class="terminal-cashier terminal-cashier-empty">

                                        <div class="terminal-cashier-avatar">

                                            <i class="bi bi-person"></i>

                                        </div>

                                        <div class="terminal-cashier-info">

                                            <div class="terminal-cashier-name">

                                                Unassigned

                                            </div>

                                            <div class="terminal-cashier-status">

                                                Available

                                            </div>

                                        </div>

                                    </div>

                                @endif

                            </td>


                            {{-- ==================================================
                                DEVICE
                                ================================================== --}}
                            <td>

                                {{ $terminal->device_name ?? '-' }}

                            </td>


                            {{-- ==================================================
                                IP ADDRESS
                                ================================================== --}}
                            <td>

                                {{ $terminal->ip_address ?? '-' }}

                            </td>


                            {{-- ==================================================
                                STATUS
                                ================================================== --}}
                            <td>

                                @if($terminal->status)

                                    <span class="terminal-status active">
                                        Active
                                    </span>

                                @else

                                    <span class="terminal-status disabled">
                                        Disabled
                                    </span>

                                @endif

                            </td>


                            {{-- ==================================================
                                ACTION
                                ================================================== --}}
                            <td class="text-end">

                                @permission('terminals.view')

                                <button
                                    type="button"
                                    class="terminal-action-btn viewTerminal"
                                    data-id="{{ $terminal->id }}"
                                >

                                    <i class="bi bi-eye"></i>

                                </button>

                                @endpermission

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                <div class="terminal-empty">

                                    <i class="bi bi-pc-display"></i>

                                    <h5>
                                        No terminals found
                                    </h5>

                                    <p class="text-muted">
                                        Start by creating your first POS terminal.
                                    </p>

                                    @permission('terminals.create')

                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#createTerminalModal"
                                    >

                                        <i class="bi bi-plus-circle me-2"></i>

                                        Create Terminal

                                    </button>

                                    @endpermission

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>