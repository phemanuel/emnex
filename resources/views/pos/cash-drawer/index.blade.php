@extends('layouts.app')

@section('title', 'Cash Drawer')

@section('content')

<div class="container-fluid px-0 cash-drawer-page">

    {{-- Page Header --}}
    <div class="cash-drawer-page-header">

        <div class="cash-drawer-page-heading">

            <div class="cash-drawer-eyebrow">
                POS OPERATIONS
            </div>

            <div class="cash-drawer-title-row">

                <h4 class="cash-drawer-title mb-0">
                    Cash Drawer
                </h4>

               <span
                    id="drawer-status-badge"
                    class="drawer-status-badge {{ $currentDrawer ? 'is-open' : 'is-closed' }}"
                >
                    <span class="drawer-status-dot"></span>

                    {{ $currentDrawer ? 'Open' : 'Closed' }}
                </span>

            </div>

            <p class="cash-drawer-subtitle mb-0">
                Manage your current cash drawer, monitor cash movements,
                and reconcile drawer sessions.
            </p>

        </div>

        <div class="cash-drawer-header-actions">

            @if(canAccess('pos.cash_drawer'))

                <button
                    type="button"
                    class="btn cash-drawer-btn cash-drawer-btn-primary"
                    id="open-drawer-btn"
                >
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Open Drawer</span>
                </button>

                <button
                    type="button"
                    class="btn cash-drawer-btn cash-drawer-btn-secondary d-none"
                    id="refresh-drawer-btn"
                >
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Refresh</span>
                </button>

            @endif

        </div>

    </div>


    {{-- Current Drawer --}}
    @include('pos.cash-drawer.partials.current-drawer')


    {{-- Financial Overview --}}
    @include('pos.cash-drawer.partials.financial-overview')


    {{-- Balance Position --}}
    @include('pos.cash-drawer.partials.balance-position')


    {{-- Cash Operations --}}
    @include('pos.cash-drawer.partials.cash-operations')


    {{-- Cash Transactions --}}
    @include('pos.cash-drawer.partials.transactions-table')


    {{-- Drawer History --}}
    @include('pos.cash-drawer.partials.history-table')

</div>


{{-- Modals --}}
@include('pos.cash-drawer.modals.open')
@include('pos.cash-drawer.modals.cash-in')
@include('pos.cash-drawer.modals.cash-out')
@include('pos.cash-drawer.modals.close')
@include('pos.cash-drawer.modals.confirmation')


{{-- Inspectors --}}
@include('pos.cash-drawer.partials.transaction-inspector')
@include('pos.cash-drawer.partials.drawer-inspector')


<script>

    window.CashDrawerConfig = {

        urls: {

            index:
                "{{ route('cash-drawer.index') }}",

            current:
                "{{ route('cash-drawer.current') }}",

            open:
                "{{ route('cash-drawer.open') }}",

           close:  "{{ route( 'cash-drawer.close',['id' => '__ID__']) }}",

            cashIn:
                "{{ route('cash-drawer.cash-in') }}",

            cashOut:
                "{{ route('cash-drawer.cash-out') }}",

            transactions:
                "{{ route('cash-drawer.transactions') }}",

            history:
                "{{ route('cash-drawer.history') }}",

            transactionDetails:
                "{{ route('cash-drawer.transaction-details', ['id' => '__ID__']) }}",

            details:
                "{{ route('cash-drawer.details', ['id' => '__ID__']) }}"
        },

        permissions: {

            access:
                @json(canAccess('pos.cash_drawer'))

        },

        terminal: {
            id:
                @json($currentTerminal?->id),

            name:
                @json($currentTerminal?->terminal_name),

            branchId:
                @json($currentBranch?->id),

            branchName:
                @json($currentBranch?->name)
        },

        drawer: {
            id:
                @json($currentDrawer?->id),

            status:
                @json($currentDrawer?->status),

            openingBalance:
                @json($currentDrawer?->opening_balance),

            openedAt:
                @json(
                    $currentDrawer?->opened_at?->toISOString()
                )
        }

    };

</script>

<script src="{{ asset('assets/js/cash-drawer.js') }}"></script>

@endsection