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



        @permission('terminals.create')

        <button
            id="addTerminalBtn"
            class="btn btn-primary px-4">

            <i class="bi bi-plus-circle me-2"></i>

            New Terminal

        </button>

        @endpermission


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




            <form
            method="GET"
            action="{{ route('terminals.index') }}"
            class="terminal-search"
        >
            <i class="bi bi-search"></i>

            <input
                type="text"
                name="search"
                id="terminalSearch"
                class="form-control"
                placeholder="Search terminal, cashier or branch"
                value="{{ request('search') }}"
            >

        </form>


        </div>

        <div class="table-responsive">  
           
             @include(
                'terminals.partials.table',
                ['terminals' => $terminals]
                )
                
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
 

<script>
    window.terminalPermissions = {
        view: @json(canAccess('terminals.view')),
        create: @json(canAccess('terminals.create')),
        update: @json(canAccess('terminals.update')),
        delete: @json(canAccess('terminals.delete')),
    };
</script>
 <script src="{{ asset('assets/js/terminal.js') }}"></script>
@endsection