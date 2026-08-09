@extends('layouts.app')


@section('content')


<div class="branch-page-header">


    <div class="branch-header-left">


        <div class="branch-title-row">

            <div class="branch-header-icon">

                <i class="bi bi-diagram-3-fill"></i>

            </div>


            <div>

                <h3>
                    Branch Management
                </h3>


                <p>
                    Manage locations, users, terminals and operations across your business.
                </p>

            </div>

        </div>



        <div class="branch-summary">


            <span>

                <i class="bi bi-shop"></i>

                {{ number_format($stats['branches']) }}
                Branches

            </span>



            <span>

                <i class="bi bi-check-circle"></i>

                {{ number_format($stats['active']) }}
                Active

            </span>


            <span>

                <i class="bi bi-pc-display"></i>

                {{ number_format($stats['terminals']) }}
                Terminals

            </span>


        </div>


    </div>

</div>

<div class="branch-section mt-4">

    {{-- Header --}}
    <div class="branch-section-header">

        <div>

            <h4 class="mb-1">
                Branch Directory
            </h4>

            <small class="text-muted">
                Manage all business locations
            </small>

        </div>

        <div class="branch-toolbar">

            <div class="branch-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    id="branchSearch"
                    placeholder="Search branches...">

            </div>

            @permission('branches.create')
            <button class="btn btn-primary" id="openCreateBranchModal">

                <i class="bi bi-plus-lg"></i>

                New Branch

            </button> 
            @endpermission
            

            @permission('branches.export')

            <button class="btn btn-outline-secondary">

                <i class="bi bi-download"></i>

                Export

            </button>

            @endpermission

        </div>

    </div>


    {{-- Branch Cards --}}
    <div class="row g-4 mt-1">

        @forelse($branches as $branch)

        <div class="col-12 col-md-6 col-xl-4">

            <div class="branch-item">

                {{-- Top --}}
                <div class="branch-top">

                    <div class="branch-icon">

                        <i class="bi bi-shop"></i>

                    </div>

                    <div class="flex-grow-1">

                        <h5 class="mb-1">

                            {{ $branch->name }}

                        </h5>

                        <div class="text-muted small">

                            {{ $branch->branch_code }}

                        </div>

                    </div>

                    <div>

                        @if($branch->is_head_office)

                            <span class="badge bg-primary mb-2">
                                Head Office
                            </span>

                        @endif

                        <br>

                        @if($branch->status)

                            <span class="badge bg-success">
                                Active
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        @endif

                    </div>

                </div>


                {{-- Address --}}
                <div class="branch-address">

                    <i class="bi bi-geo-alt"></i>

                    {{ $branch->address ?: 'No address added' }}

                </div>

                {{-- Phone --}}
                <div class="branch-address">

                    <i class="bi bi-telephone"></i>

                    {{ $branch->phone ?: '--' }}

                </div>

                {{-- Email --}}
                <div class="branch-address">

                    <i class="bi bi-envelope"></i>

                    {{ $branch->email ?: '--' }}

                </div>


                {{-- Stats --}}
                <div class="branch-metrics">

                    <div>

                        <strong>{{ number_format($branch->users_count) }}</strong>

                        <span>Users</span>

                    </div>

                    <div>

                        <strong>{{ number_format($branch->terminals_count) }}</strong>

                        <span>Terminals</span>

                    </div>

                    <div>

                        <strong>{{ number_format($branch->orders_count) }}</strong>

                        <span>Orders</span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="branch-footer">

                @permission('branches.view')

                <button
                        class="btn btn-outline-primary view-branch"
                        data-id="{{ $branch->id }}">

                        <i class="bi bi-eye"></i>

                        View

                    </button>

                @endpermission
                    

                    <!-- <button
                        class="btn btn-light edit-branch"
                        data-id="{{ $branch->id }}">

                        <i class="bi bi-pencil"></i>

                    </button> -->

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="branch-empty">

                <i class="bi bi-shop display-3 text-secondary"></i>

                <h5 class="mt-3">

                    No Branches Found

                </h5>

                <p class="text-muted">

                    Create your first business branch to get started.

                </p>

            </div>

        </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    <div class="mt-4">

        {{ $branches->links() }}

    </div>

</div>


@include('branches.partials.inspector')
@include('branches.modals.preview-modal')
@include('branches.modals.create')
@include('branches.modals.edit')
@include('branches.modals.delete')
@include('branches.modals.toggle-status')

<script>
    const BRANCHES = {

    store: "{{ route('branches.store') }}",
    
    edit: "{{ url('branches') }}",

    update: "{{ url('branches') }}",

    delete: '/branches',

    toggleStatus:'/branches'

};
</script>
@endsection