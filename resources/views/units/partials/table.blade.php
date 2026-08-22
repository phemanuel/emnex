<!-- =====================================================
    UNITS TABLE
====================================================== -->

@if($units->count())

<div class="table-responsive">


    <table class="table table-hover align-middle mb-0">


        <thead>


            <tr>

                <th width="80">
                    Code
                </th>

                <th>
                    Unit
                </th>

                <th>
                    Short Name
                </th>

                <th>
                    Description
                </th>

                <th width="120">
                    Status
                </th>

                <th width="150">
                    Created
                </th>

                <th width="80" class="text-end">
                    Action
                </th>

            </tr>


        </thead>




        <tbody>


            @foreach($units as $unit)


            <tr>


                <td>

                    <span class="table-code">

                        {{ $unit->unit_code }}

                    </span>

                </td>




                <td>


                    <div class="fw-semibold">

                        {{ $unit->name }}

                    </div>


                </td>




                <td>

                    <span class="badge bg-light text-dark">

                        {{ $unit->short_name }}

                    </span>

                </td>




                <td>


                    {{ $unit->description ?: '-' }}


                </td>




                <td>


                    @if($unit->status)

                        <span class="badge bg-success">

                            Active

                        </span>

                    @else

                        <span class="badge bg-secondary">

                            Disabled

                        </span>

                    @endif


                </td>




                <td>

                    {{ $unit->created_at->format('d M Y') }}

                </td>




                <td class="text-end">


                    <div class="dropdown">


                        <button

                            class="btn btn-light btn-sm"

                            data-bs-toggle="dropdown"

                        >

                            <i class="bi bi-three-dots-vertical"></i>

                        </button>




                        <ul class="dropdown-menu dropdown-menu-end">


                           <li>

                                @permission('units.view')

                                    <button
                                        class="dropdown-item"
                                        onclick="Units.openInspector({{ $unit->id }})"
                                    >

                                        <i class="bi bi-eye me-2"></i>

                                        View

                                    </button>

                                @endpermission

                            </li>


                            <li>

                                @permission('units.edit')

                                    <button
                                        class="dropdown-item"
                                        onclick="Units.edit({{ $unit->id }})"
                                    >

                                        <i class="bi bi-pencil me-2"></i>

                                        Edit

                                    </button>

                                @endpermission

                            </li>


                            <li>

                                @permission('units.update')

                                    @if($unit->status)

                                        <button
                                            class="dropdown-item text-warning"
                                            onclick="Units.openStatusModal(
                                                {{ $unit->id }},
                                                'Disable',
                                                '{{ addslashes($unit->name) }}'
                                            )"
                                        >

                                            <i class="bi bi-pause-circle me-2"></i>

                                            Disable

                                        </button>

                                    @else

                                        <button
                                            class="dropdown-item text-success"
                                            onclick="Units.openStatusModal(
                                                {{ $unit->id }},
                                                'Enable',
                                                '{{ addslashes($unit->name) }}'
                                            )"
                                        >

                                            <i class="bi bi-check-circle me-2"></i>

                                            Enable

                                        </button>

                                    @endif

                                @endpermission

                            </li>


                            @permission('units.delete')

                                <li>

                                    <hr class="dropdown-divider">

                                </li>


                                <li>

                                    <button
                                        class="dropdown-item text-danger"
                                        onclick="Units.openDeleteModal(
                                            {{ $unit->id }},
                                            '{{ addslashes($unit->name) }}'
                                        )"
                                    >

                                        <i class="bi bi-trash me-2"></i>

                                        Delete

                                    </button>

                                </li>

                            @endpermission


                        </ul>


                    </div>


                </td>


            </tr>


            @endforeach


        </tbody>


    </table>


</div>





<div class="px-3 py-3 border-top">


    {{ $units->links() }}


</div>


@else



<div class="empty-state">


    <div class="empty-state-icon">

        <i class="bi bi-rulers"></i>

    </div>


    <h5>

        No Units Found

    </h5>


    <p>

        No units match your current search or filter.

    </p>


    <button

        class="btn btn-primary"

        onclick="Units.openCreateModal()"

    >

        <i class="bi bi-plus-circle me-1"></i>

        Create First Unit

    </button>


</div>


@endif