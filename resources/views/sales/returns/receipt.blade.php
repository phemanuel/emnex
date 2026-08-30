{{-- ==========================================================
Return / Refund Receipt
=========================================================== --}}

@extends('layouts.app')

@section('title', 'Refund Receipt')

@section('content')

<div class="container-fluid receipt-page">


{{-- ==========================================================
    Page Header
=========================================================== --}}

<div class="page-header d-print-none">

    <div>

        <h1 class="h4 mb-1">
            Refund Receipt
        </h1>

        <p class="text-muted mb-0">
            Refund transaction receipt.
        </p>

    </div>

</div>


{{-- ==========================================================
    Receipt
=========================================================== --}}

<div class="receipt-container">

    <div class="receipt">
       
        {{-- ==========================================================
            Header
        =========================================================== --}}

        <div class="receipt-header">

            <div class="receipt-header-company">


                {{-- Company Logo --}}

                <div class="receipt-company-logo">

                    @if ($return->company?->logo)

                        <img
                            src="{{ asset(
                                'uploads/company/' .
                                ltrim(
                                    $return->company->logo,
                                    '/'
                                )
                            ) }}"
                            alt="{{ $return->company?->name ?? 'Company Logo' }}"
                        >

                    @else

                        <div class="receipt-company-logo-placeholder">

                            <i class="bi bi-buildings"></i>

                        </div>

                    @endif

                </div>


                {{-- Company Details --}}

                <div class="receipt-company-details">

                    <div class="receipt-company-name">

                        {{ $return->company?->name ?? 'EMNEX POS' }}

                    </div>


                    @if ($return->company?->address)

                        <div class="receipt-company-detail">

                            {{ $return->company->address }}

                        </div>

                    @endif


                    <div class="receipt-company-contact">

                        @if ($return->company?->phone)

                            <span>
                                {{ $return->company->phone }}
                            </span>

                        @endif


                        @if ($return->company?->email)

                            <span>

                                @if ($return->company?->phone)
                                    •
                                @endif

                                {{ $return->company->email }}

                            </span>

                        @endif

                    </div>


                    <div class="receipt-title">

                        REFUND RECEIPT

                    </div>

                </div>

            </div>


            {{-- Header Actions --}}

            <div class="receipt-header-actions">

                <button
                    type="button"
                    class="btn btn-light btn-sm"
                    onclick="window.close();"
                >

                    <i class="bi bi-x-lg me-1"></i>

                    Close

                </button>


                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    onclick="window.print();"
                >

                    <i class="bi bi-printer me-1"></i>

                    Print

                </button>

            </div>

        </div>




        {{-- ==========================================================
            Refund Information
        =========================================================== --}}

        <div class="receipt-meta">

            <div class="receipt-meta-row">


                <div>

                    <span class="receipt-label">
                        Refund No.
                    </span>

                    <strong>
                        {{ $return->return_number ?? '—' }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Refund Date
                    </span>

                    <strong>
                        {{ $return->created_at ? $return->created_at->format('d M Y, h:i A') : '—' }}
                    </strong>

                </div>

            </div>


            <div class="receipt-meta-row">


                <div>

                    <span class="receipt-label">
                        Order No.
                    </span>

                    <strong>
                        {{ $return->order?->order_no ?? '—' }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Invoice No.
                    </span>

                    <strong>
                        {{ $return->order?->invoice?->invoice_no ?? '—' }}
                    </strong>

                </div>

            </div>


            <div class="receipt-meta-row">


                <div>

                    <span class="receipt-label">
                        Customer
                    </span>

                    <strong>
                        {{ $return->customer?->displayName() ?? 'Walk-in Customer' }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Branch
                    </span>

                    <strong>
                        {{ $return->branch?->name ?? '—' }}
                    </strong>

                </div>

            </div>


            <div class="receipt-meta-row">


                <div>

                    <span class="receipt-label">
                        Terminal
                    </span>

                    <strong>
                        {{ $return->terminal?->displayName() ?? '—' }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Refund Status
                    </span>

                    <strong>
                        {{ $return->return_status ?? 'Refunded' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Original Order
        =========================================================== --}}

        <div class="receipt-section">

            <div class="receipt-section-title">

                Original Order

            </div>


            <div class="receipt-info-grid">

                <div>

                    <span class="receipt-label">
                        Order Total
                    </span>

                    <strong>
                        {{ number_format((float) ($return->order?->grand_total ?? 0), 2) }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Amount Paid
                    </span>

                    <strong>
                        {{ number_format((float) ($return->order?->amount_paid ?? 0), 2) }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Balance
                    </span>

                    <strong>
                        {{ number_format((float) ($return->order?->balance ?? 0), 2) }}
                    </strong>

                </div>


                <div>

                    <span class="receipt-label">
                        Order Status
                    </span>

                    <strong>
                        {{ $return->order?->order_status ?? '—' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Refund Payments
        =========================================================== --}}

        <div class="receipt-section">

            <div class="receipt-section-title">

                Refunded Payments

            </div>


            <table class="receipt-table">

                <thead>

                    <tr>

                        <th>
                            Payment No.
                        </th>

                        <th>
                            Method
                        </th>

                        <th>
                            Reference
                        </th>

                        <th class="text-end">
                            Amount
                        </th>

                    </tr>

                </thead>


               
                <tbody>

                    @forelse ($return->payments ?? [] as $returnPayment)

                        @php

                            $payment =
                                $returnPayment->payment;

                        @endphp


                        <tr>

                            <td>
                                {{ $payment?->payment_number ?? '—' }}
                            </td>

                            <td>
                                {{ $payment?->payment_method ?? '—' }}
                            </td>

                            <td>
                                {{ $payment?->reference_no ?? '—' }}
                            </td>

                          
                            <td class="text-end">

                                {{ \App\Helpers\CurrencyHelper::format(
                                    (float) $returnPayment->amount
                                ) }}

                            </td>



                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center"
                            >
                                No payment records available.
                            </td>

                        </tr>

                    @endforelse

                </tbody>



            </table>

        </div>


        {{-- ==========================================================
            Refund Summary
        =========================================================== --}}

        <div class="receipt-total-section">

            <div class="receipt-total-row">

                <span>
                    Total Amount Paid
                </span>

               
                <strong>

                    {{ \App\Helpers\CurrencyHelper::format(
                        (float) (
                            $return->total_paid
                            ?? $return->order?->amount_paid
                            ?? 0
                        )
                    ) }}

                </strong>



            </div>


            <div class="receipt-total-row receipt-grand-total">

                <span>
                    Total Refund
                </span>

              
                <strong>

                    {{ \App\Helpers\CurrencyHelper::format(
                        (float) $return->refund_amount
                    ) }}

                </strong>



            </div>

        </div>


        {{-- ==========================================================
            Refund Reason
        =========================================================== --}}

        @if ($return->reason || $return->remarks)

            <div class="receipt-section">

                <div class="receipt-section-title">

                    Refund Details

                </div>


                @if ($return->reason)

                    <div class="receipt-detail-row">

                        <span class="receipt-label">
                            Reason
                        </span>

                        <span>
                            {{ $return->reason }}
                        </span>

                    </div>

                @endif


                @if ($return->remarks)

                    <div class="receipt-detail-row">

                        <span class="receipt-label">
                            Remarks
                        </span>

                        <span>
                            {{ $return->remarks }}
                        </span>

                    </div>

                @endif

            </div>

        @endif


        {{-- ==========================================================
            Activity
        =========================================================== --}}

        <div class="receipt-section">

            <div class="receipt-section-title">

                Activity

            </div>


            <div class="receipt-detail-row">

                <span class="receipt-label">
                    Processed By
                </span>

                <span>
                    {{ $return->processedBy?->name ?? '—' }}
                </span>

            </div>


            <div class="receipt-detail-row">

                <span class="receipt-label">
                    Created
                </span>

                <span>

                    {{ optional($return->created_at)
                        ->format('d M Y, H:i') ?? '—' }}

                </span>

            </div>


            <div class="receipt-detail-row">

                <span class="receipt-label">
                    Updated
                </span>

                <span>

                    {{ optional($return->updated_at)
                        ->format('d M Y, H:i') ?? '—' }}

                </span>

            </div>

        </div>


        {{-- ==========================================================
            Footer
        =========================================================== --}}

        <div class="receipt-footer">

            <div class="receipt-footer-message">

                Refund processed successfully.

            </div>


            <div class="receipt-footer-note">

                This receipt confirms the refund transaction
                associated with the original sales order.

            </div>

        </div>


    </div>

</div>


</div>

@endsection

@push('styles')


<style>

    /*
    |--------------------------------------------------------------------------
    | Hide Page Header During Print
    |--------------------------------------------------------------------------
    */

    @media print {

        .page-header {

            display: none !important;

        }


        .receipt-page {

            padding: 0 !important;

            margin: 0 !important;

        }


        .receipt-container {

            margin: 0 !important;

            padding: 0 !important;

        }


        .receipt {

            box-shadow: none !important;

            border: 0 !important;

        }

    }

</style>


@endpush
