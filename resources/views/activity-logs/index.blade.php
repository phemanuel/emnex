@extends('layouts.app')

@section('title', 'Audit Logs')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/modules/activity-log.css') }}">
@endpush

@section('content')

<!-- ==========================================================
    Page Header
=========================================================== -->

<div class="page-header">

    <div>
        <h1 class="page-title">
            <i class="bi bi-journal-text me-2"></i>
            Audit Logs
        </h1>

        <p class="page-subtitle">
            View and inspect system activities performed across your company.
        </p>
    </div>

</div>

<!-- =====================================================
    Audit Statistics
====================================================== -->

<div class="audit-stat-strip mb-4">


    @php

        $stats = [

            [
                'title'=>'Total',
                'value'=>$statistics['total'],
                'icon'=>'bi-journal-text',
                'class'=>'primary'
            ],

            [
                'title'=>'Created',
                'value'=>$statistics['created'],
                'icon'=>'bi-plus-circle',
                'class'=>'success'
            ],

            [
                'title'=>'Updated',
                'value'=>$statistics['updated'],
                'icon'=>'bi-pencil',
                'class'=>'warning'
            ],

            [
                'title'=>'Deleted',
                'value'=>$statistics['deleted'],
                'icon'=>'bi-trash',
                'class'=>'danger'
            ],

            [
                'title'=>'Restored',
                'value'=>$statistics['restored'],
                'icon'=>'bi-arrow-counterclockwise',
                'class'=>'info'
            ],

            [
                'title'=>'Enabled',
                'value'=>$statistics['enabled'],
                'icon'=>'bi-toggle-on',
                'class'=>'success'
            ],

            [
                'title'=>'Disabled',
                'value'=>$statistics['disabled'],
                'icon'=>'bi-toggle-off',
                'class'=>'secondary'
            ],

            [
                'title'=>'Reset',
                'value'=>$statistics['password_reset'],
                'icon'=>'bi-key',
                'class'=>'purple'
            ],

            [
                'title'=>'Permissions',
                'value'=>$statistics['permissions_updated'],
                'icon'=>'bi-shield-check',
                'class'=>'dark'
            ],

        ];

    @endphp



    @foreach($stats as $stat)

        <div class="audit-mini-stat">


            <div class="audit-mini-icon {{ $stat['class'] }}">

                <i class="bi {{ $stat['icon'] }}"></i>

            </div>


            <div>

                <small>
                    {{ $stat['title'] }}
                </small>


                <strong>
                    {{ number_format($stat['value']) }}
                </strong>

            </div>


        </div>


    @endforeach


</div>

<!-- ==========================================================
    Audit Activity Center
=========================================================== -->

<div class="audit-panel">

    <!-- ===================================== -->
    <!-- Toolbar -->
    <!-- ===================================== -->

    <div class="audit-toolbar">

        <div class="audit-toolbar-left">

            <div class="audit-title">

                <h4>

                    Activity Center

                </h4>

                <span>

                    {{ number_format($activityLogs->total()) }}
                    recorded activities

                </span>

            </div>

        </div>

        <form 
        method="GET" 
        action="{{ route('activity-logs.index') }}" 
        id="filterForm"
        class="audit-toolbar-right">

        <!-- Search -->

        <div class="audit-search">

            <i class="bi bi-search"></i>

            <input
                type="text"
                name="search"
                id="searchLogs"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="Search user, activity, module...">

        </div>


        <!-- Module -->

        <select
            name="module"
            id="filterModule"
            class="form-select">


            <option value="">
                All Modules
            </option>


            @foreach($modules as $module)

                <option
                    value="{{ $module }}"
                    @selected(request('module') == $module)>

                    {{ ucfirst($module) }}

                </option>

            @endforeach


        </select>



        <!-- Action -->

        <select
            name="action"
            id="filterAction"
            class="form-select">


            <option value="">
                All Actions
            </option>


            @foreach($actions as $action)

                <option
                    value="{{ $action }}"
                    @selected(request('action') == $action)>

                    {{ ucfirst($action) }}

                </option>

            @endforeach


        </select>


    </form>

    </div>
    
    <div id="activityLogTable">

        @include(
            'activity-logs.partials.table',
            [
                'activityLogs' => $activityLogs
            ]
        )

    </div>

    

</div>

<!-- ==========================================================
    Inspector
=========================================================== -->

@include('activity-logs.partials.inspector')

<script>
window.activityLogRoutes = {
    show: "{{ route('activity-logs.show', ':id') }}"
};
</script>

<script src="{{ asset('assets/js/activity-log.js') }}"></script>
@endsection





