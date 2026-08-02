@extends('layouts.app')

@section('title', 'Document Sequences')

@section('content')

<div class="container-fluid">

    {{-- ==========================================================
        PAGE HEADER
    =========================================================== --}}

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="bi bi-123 me-2 text-primary"></i>

                Document Sequences

            </h3>

            <p class="text-muted mb-0">

                Configure automatic numbering for invoices, receipts,
                purchase orders and other business documents.

            </p>

        </div>

    </div>





    {{-- ==========================================================
        KPI CARDS
    =========================================================== --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card sequence-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Total Sequences

                            </small>

                            <h3 class="mt-2 mb-0 fw-bold">

                                {{ $documentSequences->count() }}

                            </h3>

                        </div>

                        <div class="icon-circle bg-primary-subtle text-primary">

                            <i class="bi bi-files"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl-3 col-md-6">

            <div class="card sequence-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Active

                            </small>

                            <h3 class="mt-2 mb-0 fw-bold text-success">

                                {{ $documentSequences->where('status', true)->count() }}

                            </h3>

                        </div>

                        <div class="icon-circle bg-success-subtle text-success">

                            <i class="bi bi-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl-3 col-md-6">

            <div class="card sequence-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Disabled

                            </small>

                            <h3 class="mt-2 mb-0 fw-bold text-danger">

                                {{ $documentSequences->where('status', false)->count() }}

                            </h3>

                        </div>

                        <div class="icon-circle bg-danger-subtle text-danger">

                            <i class="bi bi-pause-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="col-xl-3 col-md-6">

            <div class="card sequence-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">

                                Next Invoice

                            </small>

                            <h6 class="mt-2 mb-0 fw-bold">

                                {{
                                    optional(
                                        $documentSequences
                                            ->firstWhere('document_type', 'Invoice')
                                    )?->nextNumber() ?? '-'
                                }}

                            </h6>

                        </div>

                        <div class="icon-circle bg-warning-subtle text-warning">

                            <i class="bi bi-receipt"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>





    {{-- ==========================================================
        INFORMATION CARD
    =========================================================== --}}

    <div class="sequence-info mb-4">

        <div class="card-body">

            <div class="d-flex align-items-start">

                <div class="icon me-4">

                    <i class="bi bi-info-circle-fill"></i>

                </div>

                <div>

                    <h5 class="mb-2">

                        Automatic Document Numbering

                    </h5>

                    <p>

                        Every document generated by EMNEX POS uses these
                        numbering rules. Changes made here affect only
                        future documents and do not modify numbers already
                        assigned to existing records.

                    </p>

                </div>

            </div>

        </div>

    </div>

        {{-- ==========================================================
        DOCUMENT SEQUENCES TABLE
    =========================================================== --}}

    <div class="card sequence-card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <h5>
                    Document Sequence Configuration
                </h5>

                <small class="text-muted">
                    Manage numbering formats for business documents.
                </small>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table sequence-table align-middle">

                    <thead>

                        <tr>

                            <th style="width:25%">
                                Document Type
                            </th>

                            <th style="width:20%">
                                Preview
                            </th>

                            <th class="text-center">
                                Current
                            </th>

                            <th class="text-center">
                                Length
                            </th>

                            <th class="text-center">
                                Reset
                            </th>

                            <th class="text-center">
                                Status
                            </th>

                            <th class="text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($documentSequences as $sequence)

                            <tr>

                                {{-- Document Type --}}
                                <td>

                                    <div class="sequence-title">

                                        {{ $sequence->document_type }}

                                    </div>

                                    <div class="sequence-subtitle">

                                        {{ $sequence->prefix }}{{ $sequence->separator }}{{ str_repeat('0', $sequence->number_length) }}

                                        @if($sequence->suffix)

                                            {{ $sequence->suffix }}

                                        @endif

                                    </div>

                                </td>



                                {{-- Preview --}}
                                <td>

                                    <span class="sequence-preview">

                                        {{ $sequence->nextNumber() }}

                                    </span>

                                </td>



                                {{-- Current Number --}}
                                <td class="text-center">

                                    <span class="sequence-number">

                                        {{ number_format($sequence->current_number) }}

                                    </span>

                                </td>



                                {{-- Number Length --}}
                                <td class="text-center">

                                    <span class="length-badge">

                                        {{ $sequence->number_length }}

                                    </span>

                                </td>



                                {{-- Reset Frequency --}}
                                <td class="text-center">

                                    <span class="reset-badge">

                                        {{ $sequence->reset_frequency }}

                                    </span>

                                </td>



                                {{-- Status --}}
                                <td class="text-center">

                                    @if($sequence->status)

                                        <span class="status-badge status-active">

                                            <i class="bi bi-check-circle-fill"></i>

                                            Active

                                        </span>

                                    @else

                                        <span class="status-badge status-disabled">

                                            <i class="bi bi-pause-circle-fill"></i>

                                            Disabled

                                        </span>

                                    @endif

                                </td>



                                {{-- Actions --}}
                                <td class="text-end">

                                    <div class="btn-group">

                                        <button
                                            type="button"
                                            class="btn btn-outline-primary btn-sequence edit-sequence-btn"
                                            data-id="{{ $sequence->id }}"
                                            title="Edit">

                                            <i class="bi bi-pencil-square"></i>

                                        </button>

                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary btn-sequence toggle-status-btn"
                                            data-id="{{ $sequence->id }}"
                                            title="{{ $sequence->status ? 'Disable' : 'Enable' }}">

                                            <i class="bi {{ $sequence->status ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7">

                                    <div class="sequence-empty">

                                        <i class="bi bi-inbox"></i>

                                        <h5>

                                            No document sequences found

                                        </h5>

                                        <p>

                                            Default document sequences will
                                            automatically be created for your
                                            company.

                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


@include('document-sequences.modals.edit')

<script>

window.documentSequenceRoutes = {

    edit: "{{ route('document-sequences.edit', ':id') }}",

    update: "{{ route('document-sequences.update', ':id') }}",

    toggle: "{{ route('document-sequences.toggle-status', ':id') }}"

};

</script>

<script src="{{ asset('assets/js/document-sequences.js') }}"></script>

@endsection





