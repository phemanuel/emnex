@extends('layouts.app')


@section('title', 'Terminal Management')


@section('content')

<div class="container-fluid">


    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">


        <div>

            <h2 class="fw-bold mb-1">
                Terminal Management
            </h2>

            <p class="text-muted mb-0">
                Manage POS terminals across company branches.
            </p>

        </div>



        <button 
            id="addTerminalBtn"
            class="btn btn-primary px-4">

            <i class="bi bi-plus-circle me-2"></i>

            New Terminal

        </button>


    </div>





    {{-- KPI Cards --}}
    <div class="row g-3 mb-4">


        <div class="col-xl-3 col-md-6">

            <div class="terminal-stat-card">


                <div class="terminal-stat-icon">

                    <i class="bi bi-pc-display"></i>

                </div>


                <div>

                    <span>
                        Total Terminals
                    </span>


                    <h3>
                        {{ $totalTerminals }}
                    </h3>

                </div>


            </div>

        </div>





        <div class="col-xl-3 col-md-6">

            <div class="terminal-stat-card">


                <div class="terminal-stat-icon">

                    <i class="bi bi-check-circle"></i>

                </div>


                <div>

                    <span>
                        Active Terminals
                    </span>


                    <h3>
                        {{ $activeTerminals }}
                    </h3>

                </div>


            </div>

        </div>





        <div class="col-xl-3 col-md-6">

            <div class="terminal-stat-card">


                <div class="terminal-stat-icon">

                    <i class="bi bi-pause-circle"></i>

                </div>


                <div>

                    <span>
                        Disabled
                    </span>


                    <h3>
                        {{ $disabledTerminals }}
                    </h3>

                </div>


            </div>

        </div>





        <div class="col-xl-3 col-md-6">

            <div class="terminal-stat-card">


                <div class="terminal-stat-icon">

                    <i class="bi bi-diagram-3"></i>

                </div>


                <div>

                    <span>
                        Connected Branches
                    </span>


                    <h3>
                        {{ $branchCount }}
                    </h3>

                </div>


            </div>

        </div>


    </div>






    {{-- Terminal Directory --}}

    <div class="terminal-card">



        <div class="terminal-card-header">


            <div>

                <h5>
                    Terminal Directory
                </h5>


                <small>
                    View, edit and manage POS terminals.
                </small>

            </div>




            <div class="terminal-search">


                <i class="bi bi-search"></i>


                <input 
                    type="text"
                    id="terminalSearch"
                    class="form-control"
                    placeholder="Search terminals">


            </div>


        </div>






        <div class="table-responsive">


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
                        data-id="{{ $terminal->id }}">



                        <td>


                            <div class="terminal-name">

                                {{ $terminal->terminal_name }}

                            </div>


                            <div class="terminal-code">

                                {{ $terminal->terminal_code }}

                            </div>


                        </td>





                        <td>


                            <div class="fw-semibold">

                                {{ $terminal->branch->name ?? 'N/A' }}

                            </div>


                        </td>





                        <td>


                            {{ $terminal->device_name ?? '-' }}


                        </td>





                        <td>


                            {{ $terminal->ip_address ?? '-' }}


                        </td>






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





                        <td class="text-end">


                            <button
                                class="terminal-action-btn viewTerminal"
                                data-id="{{ $terminal->id }}">
                                
                                <i class="bi bi-eye"></i>

                            </button>



                        </td>



                    </tr>



                @empty



                    <tr>


                        <td colspan="6">


                            <div class="terminal-empty">


                                <i class="bi bi-pc-display"></i>


                                <h5>
                                    No terminals found
                                </h5>


                                <p class="text-muted">
                                    Start by creating your first POS terminal.
                                </p>


                                <button
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#createTerminalModal">


                                    <i class="bi bi-plus-circle me-2"></i>

                                    Create Terminal


                                </button>


                            </div>


                        </td>


                    </tr>



                @endforelse



                </tbody>



            </table>


        </div>






        {{-- Pagination --}}

        @if($terminals->hasPages())

            <div class="p-3">

                {{ $terminals->links() }}

            </div>

        @endif



    </div>



</div>

@include('terminals.modals.create')

@include('terminals.modals.edit')

@include('terminals.modals.delete')

@include('terminals.modals.toggle-status')

 @include('terminals.partials.inspector')
 


 <script src="{{ asset('assets/js/terminal.js') }}"></script>
@endsection