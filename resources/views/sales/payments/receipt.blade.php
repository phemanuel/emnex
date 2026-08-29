<!-- | {{--                                                                       |
| -------------------------------------------------------------------------- |
| Payment Receipt                                                            |
| -------------------------------------------------------------------------- |
|                                                                            |
| This view is intentionally standalone.                                     |
| Do NOT extend layouts.app because this page is designed for printing.      |
|                                                                            |
| -------------------------------------------------------------------------- |
| --}}                                                                       | -->

@extends('layouts.app')

@section('title', 'Payment Receipt')

@section('content')



<div class="receipt">

{{-- ==============================================================
    Print Toolbar
=============================================================== --}}

<div class="receipt-print-toolbar d-print-none">

    <div>

        <div class="text-muted small">
            Payment Receipt
        </div>

        <div class="fw-semibold">
            {{ $payment->payment_number }}
        </div>

    </div>


    <div class="d-flex align-items-center gap-2">

        <button
            type="button"
            class="btn btn-light btn-sm"
            onclick="window.close()"
        >

            <i class="bi bi-x-lg me-1"></i>

            Close

        </button>


        <button
            type="button"
            class="receipt-print-button no-print"
            onclick="printReceipt()"
        >

            <i class="bi bi-printer me-1"></i>

            Print Receipt

        </button>

    </div>

</div>

{{-- ==========================================================
Header
=========================================================== --}}

<div class="receipt-header">


<div class="receipt-header-company">

    {{-- Company Logo --}}

    <div class="receipt-company-logo">

        @if ($payment->company?->logo)

            <img
                src="{{ asset(
                    'uploads/company/' .
                    ltrim(
                        $payment->company->logo,
                        '/'
                    )
                ) }}"
                alt="{{ $payment->company?->name ?? 'Company Logo' }}"
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

            {{ $payment->company?->name ?? 'EMNEX POS' }}

        </div>


        @if ($payment->company?->address)

            <div class="receipt-company-detail">

                {{ $payment->company->address }}

            </div>

        @endif


        <div class="receipt-company-contact">

            @if ($payment->company?->phone)

                <span>

                    {{ $payment->company->phone }}

                </span>

            @endif


            @if ($payment->company?->email)

                <span>

                    @if ($payment->company?->phone)
                        •
                    @endif

                    {{ $payment->company->email }}

                </span>

            @endif

        </div>


        <div class="receipt-title">

            PAYMENT RECEIPT

        </div>

    </div>

</div>


</div>



<div class="divider"></div>


{{-- ==============================================================
    Payment Status
=============================================================== --}}

<div class="section">

    <div class="section-title">
        Payment Status
    </div>


    @php

        $statusClass = match (
            $payment->payment_status
        ) {

            'Completed' =>
                'status-completed',

            'Pending' =>
                'status-pending',

            'Failed' =>
                'status-failed',

            'Cancelled' =>
                'status-cancelled',

            'Refunded' =>
                'status-refunded',

            default =>
                'status-pending',

        };

    @endphp


    <span class="status {{ $statusClass }}">

        {{ $payment->payment_status }}

    </span>

</div>


{{-- ==============================================================
    Payment Information
=============================================================== --}}

<div class="section">

    <div class="section-title">
        Payment Information
    </div>


    <div class="details-grid">


        <div class="detail">

            <span class="detail-label">
                Payment No.
            </span>

            <span class="detail-value">
                {{ $payment->payment_number }}
            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Payment Date
            </span>

            <span class="detail-value">

                {{ $payment->payment_date?->format('d M Y, H:i') ?? '—' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Order No.
            </span>

            <span class="detail-value">

                {{ $payment->order?->order_no ?? '—' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Invoice No.
            </span>

            <span class="detail-value">

                {{ $payment->order?->invoice?->invoice_no ?? '—' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Customer
            </span>

            <span class="detail-value">

                {{ $payment->customer?->displayName() ?? 'Walk-in Customer' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Payment Method
            </span>

            <span class="detail-value">

                {{ $payment->payment_method ?? '—' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Branch
            </span>

            <span class="detail-value">

                {{ $payment->branch?->name ?? '—' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Terminal
            </span>

            <span class="detail-value">

                {{ $payment->terminal?->displayName() ?? '—' }}

            </span>

        </div>


    </div>

</div>


{{-- ==============================================================
    Order & Payment Summary
=============================================================== --}}

<div class="section">

    <div class="section-title">
        Order & Payment Summary
    </div>


    <div class="summary">


        <div class="summary-row">

            <span>
                Order Total
            </span>

            <strong>

                ₦{{ number_format(
                    (float) ($payment->order?->grand_total ?? 0),
                    2
                ) }}

            </strong>

        </div>


        <div class="summary-row">

            <span>
                Amount Paid
            </span>

            <strong>

                ₦{{ number_format(
                    (float) ($payment->order?->amount_paid ?? 0),
                    2
                ) }}

            </strong>

        </div>


        <div class="summary-row total">

            <span>
                This Payment
            </span>

            <strong>

                ₦{{ number_format(
                    (float) $payment->amount,
                    2
                ) }}

            </strong>

        </div>


        <div class="summary-row balance">

            <span>
                Balance
            </span>

            <strong>

                ₦{{ number_format(
                    (float) ($payment->order?->balance ?? 0),
                    2
                ) }}

            </strong>

        </div>


        <div class="summary-row">

            <span>
                Order Status
            </span>

            <strong>

                {{ $payment->order?->order_status ?? '—' }}

            </strong>

        </div>


    </div>

</div>


{{-- ==============================================================
    References
=============================================================== --}}

<div class="section">

    <div class="section-title">
        References
    </div>


    <div class="details-grid">


        <div class="detail">

            <span class="detail-label">
                Reference No.
            </span>

            <span class="detail-value">

                {{ $payment->reference_no ?? '—' }}

            </span>

        </div>       


        <div class="detail">

            <span class="detail-label">
                Received By
            </span>

            <span class="detail-value">

                {{ $payment->receivedBy?->name
                    ??
                    trim(
                        ($payment->receivedBy?->first_name ?? '') .
                        ' ' .
                        ($payment->receivedBy?->last_name ?? '')
                    )
                    ?: '—'
                }}

            </span>

        </div>

        <div class="detail">

            <span class="detail-label">
                Transaction Reference
            </span>

            <span class="detail-value">

                {{ $payment->transaction_reference ?? '—' }}

            </span>

        </div>


        <div class="detail">

            <span class="detail-label">
                Payment Gateway
            </span>

            <span class="detail-value">

                {{ $payment->payment_gateway ?? '—' }}

            </span>

        </div>


    </div>

</div>


{{-- ==============================================================
    Remarks
=============================================================== --}}

@if ($payment->remarks)

    <div class="section">

        <div class="section-title">
            Remarks
        </div>


        <div class="remarks">

            {{ $payment->remarks }}

        </div>

    </div>

@endif


{{-- ==============================================================
    Footer
=============================================================== --}}

<div class="receipt-footer">

    <div>
        Payment received against
        {{ $payment->order?->order_no ?? 'sales order' }}.
    </div>

    <div style="margin-top: 5px;">

        Generated
        {{ now()->format('d M Y, H:i') }}

    </div>

</div>


</div>


<style>

    * {
        box-sizing: border-box;
    }


    html,
    body {
        margin: 0;
        padding: 0;
        background: #ffffff;
        color: #212529;
        font-family:
            Arial,
            Helvetica,
            sans-serif;
    }


    body {
        font-size: 13px;
    }


    .receipt {
        width: 100%;
        max-width: 760px;
        margin: 0 auto;
        padding: 32px;
    } 


    .divider {
        border-top: 1px solid #dee2e6;
        margin: 18px 0;
    }


    .section {
        margin-bottom: 20px;
    }


    .section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6c757d;
        margin-bottom: 10px;
    }


    .details-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px 24px;
    }


    .detail {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid #f1f3f5;
        padding-bottom: 7px;
    }


    .detail-label {
        color: #6c757d;
    }


    .detail-value {
        font-weight: 600;
        text-align: right;
    }


    .summary {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 14px 16px;
    }


    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 0;
    }


    .summary-row + .summary-row {
        border-top: 1px solid #f1f3f5;
    }


    .summary-row.total {
        margin-top: 6px;
        padding-top: 12px;
        border-top: 1px solid #dee2e6;
        font-size: 15px;
        font-weight: 700;
    }


    .summary-row.balance {
        font-weight: 700;
    }


    .status {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }


    .status-completed {
        background: #d1e7dd;
        color: #0f5132;
    }


    .status-pending {
        background: #fff3cd;
        color: #664d03;
    }


    .status-failed,
    .status-cancelled {
        background: #f8d7da;
        color: #842029;
    }


    .status-refunded {
        background: #e2e3e5;
        color: #41464b;
    }


    .remarks {
        color: #495057;
        line-height: 1.6;
    }


    .receipt-footer {
        text-align: center;
        margin-top: 28px;
        padding-top: 16px;
        border-top: 1px solid #dee2e6;
        color: #6c757d;
        font-size: 11px;
    }


    .print-only {
        display: block;
    }


    @media print {

        @page {
            margin: 12mm;
        }


        html,
        body {
            background: #ffffff;
        }


        .receipt {
            max-width: none;
            padding: 0;
        }

    }


    @media (max-width: 600px) {

        .receipt {
            padding: 20px;
        }


        .details-grid {
            grid-template-columns: 1fr;
        }

    }


    .receipt-print-toolbar {

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    max-width:
        1000px;

    margin:
        0 auto 24px;

}

/*
|--------------------------------------------------------------------------
| Header
|--------------------------------------------------------------------------
*/

.receipt-header {

    padding-bottom:
        16px;

    border-bottom:
        1px dashed #d0d5dd;

}


.receipt-header-company {

    display:
        flex;

    align-items:
        center;

    gap:
        14px;

}


.receipt-company-logo {

    width:
        58px;

    height:
        58px;

    flex:
        0 0 58px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    overflow:
        hidden;

    border:
        1px solid #e4e7ec;

    border-radius:
        10px;

    background:
        #ffffff;

}


.receipt-company-logo img {

    display:
        block;

    width:
        100%;

    height:
        100%;

    object-fit:
        contain;

    padding:
        5px;

}


.receipt-company-logo-placeholder {

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    width:
        100%;

    height:
        100%;

    background:
        #f2f4f7;

    color:
        #98a2b3;

    font-size:
        1.2rem;

}


.receipt-company-details {

    flex:
        1;

    min-width:
        0;

}


.receipt-company-name {

    overflow:
        hidden;

    color:
        #101828;

    font-size:
        16px;

    font-weight:
        700;

    line-height:
        1.25;

    text-overflow:
        ellipsis;

    white-space:
        nowrap;

}


.receipt-company-detail {

    margin-top:
        3px;

    color:
        #667085;

    font-size:
        9px;

    line-height:
        1.4;

}


.receipt-company-contact {

    display:
        flex;

    flex-wrap:
        wrap;

    gap:
        4px;

    margin-top:
        2px;

    color:
        #667085;

    font-size:
        8px;

}


.receipt-title {

    margin-top:
        7px;

    color:
        #344054;

    font-size:
        9px;

    font-weight:
        700;

    letter-spacing:
        .08em;

}

/*
|--------------------------------------------------------------------------
| Print
|--------------------------------------------------------------------------
*/

@media print {

    @page {

        margin:
            0;

    }


    html,
    body {

        margin:
            0 !important;

        padding:
            0 !important;

        background:
            #ffffff !important;

    }


    .receipt-print-wrapper {

        padding:
            0 !important;

        margin:
            0 !important;

    }


    .receipt-print-toolbar {

        display:
            none !important;

    }


    .receipt-print-document {

        width:
            100% !important;

        max-width:
            none !important;

        margin:
            0 !important;

        padding:
            0 !important;

        border:
            0 !important;

        border-radius:
            0 !important;

        box-shadow:
            none !important;

    }


    .receipt-items tr {

        break-inside:
            avoid;

    }


    .receipt-payment {

        break-inside:
            avoid;

    }


    .receipt-footer {

        break-inside:
            avoid;

    }

}


/*
|--------------------------------------------------------------------------
| Receipt Actions
|--------------------------------------------------------------------------
*/

.receipt-actions {

    margin-top:
        20px;

    padding-top:
        14px;

    border-top:
        1px dashed #d0d5dd;

    text-align:
        center;

}


.receipt-print-button {

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    gap:
        7px;

    min-height:
        36px;

    padding:
        8px 16px;

    border:
        1px solid #d0d5dd;

    border-radius:
        7px;

    background:
        #101828;

    color:
        #ffffff;

    font-size:
        11px;

    font-weight:
        600;

    cursor:
        pointer;

}


.receipt-print-button:hover {

    background:
        #1d2939;

}



/*
|--------------------------------------------------------------------------
| Print
|--------------------------------------------------------------------------
*/

@media print {

    @page {
        margin: 0;
    }


    html,
    body {
        margin: 0 !important;
        padding: 0 !important;
        background: #ffffff !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Hide EMNEX Application Layout
    |--------------------------------------------------------------------------
    */

    .sidebar,
    .navbar,
    .topbar,
    .app-header,
    .main-header,
    .page-header,
    header,
    nav {

        display: none !important;

    }


    /*
    |--------------------------------------------------------------------------
    | Reset Application Content Container
    |--------------------------------------------------------------------------
    */

    .main-content,
    .content,
    .content-wrapper,
    .page-content {

        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        max-width: none !important;

    }


    /*
    |--------------------------------------------------------------------------
    | Receipt
    |--------------------------------------------------------------------------
    */

    .receipt-page {

        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;

    }


    .receipt {

        width: 100% !important;
        max-width: 420px !important;

        margin: 0 auto !important;
        padding: 0 !important;

        background: #ffffff !important;

    }


    /*
    |--------------------------------------------------------------------------
    | Hide Receipt Controls
    |--------------------------------------------------------------------------
    */

    .receipt-actions,
    .no-print {

        display: none !important;

    }

}
</style>

<script>

function printReceipt() {

    window.print();

}

</script>

@endsection
