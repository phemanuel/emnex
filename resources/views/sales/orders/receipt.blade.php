@extends('layouts.app')

@section('title', 'Order Receipt')

@section('content')

@php


$orderItems =
    $order->orderItems ??
    collect();


@endphp

<div class="receipt-print-wrapper">


{{-- ==============================================================
    Print Toolbar
=============================================================== --}}

<div class="receipt-print-toolbar d-print-none">

    <div>

        <div class="text-muted small">
            Sales Receipt
        </div>

        <div class="fw-semibold">
            {{ $order->order_no }}
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


{{-- ==============================================================
    Receipt Document
=============================================================== --}}

<div class="receipt-print-document">

    {{-- ==========================================================
        Header
    =========================================================== --}}

    <div class="receipt-header">

        <div class="receipt-header-company">

            {{-- Company Logo --}}

            <div class="receipt-company-logo">

                @if ($order->company?->logo)

                    <img
                        src="{{ asset(
                            'uploads/company/' .
                            ltrim(
                                $order->company->logo,
                                '/'
                            )
                        ) }}"
                        alt="{{ $order->company?->name ?? 'Company Logo' }}"
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

                    {{ $order->company?->name ?? 'EMNEX POS' }}

                </div>


                @if ($order->company?->address)

                    <div class="receipt-company-detail">

                        {{ $order->company->address }}

                    </div>

                @endif


                <div class="receipt-company-contact">

                    @if ($order->company?->phone)

                        <span>
                            {{ $order->company->phone }}
                        </span>

                    @endif


                    @if ($order->company?->email)

                        <span>

                            @if ($order->company?->phone)
                                •
                            @endif

                            {{ $order->company->email }}

                        </span>

                    @endif

                </div>


                <div class="receipt-title">

                    SALES RECEIPT

                </div>

            </div>

        </div>

    </div>


    {{-- ==========================================================
        Order Information
    =========================================================== --}}

    <div class="receipt-info">

        <div class="receipt-info-row">

            <span class="receipt-info-label">
                Order No.
            </span>

            <span class="receipt-info-value">
                {{ $order->order_no }}
            </span>

        </div>


        <div class="receipt-info-row">

            <span class="receipt-info-label">
                Date
            </span>

            <span class="receipt-info-value">

                {{
                    $order->completed_at
                        ? $order->completed_at->format(
                            'd M Y, h:i A'
                        )
                        : '—'
                }}

            </span>

        </div>


        <div class="receipt-info-row">

            <span class="receipt-info-label">
                Branch
            </span>

            <span class="receipt-info-value">

                {{ $order->branch?->name ?? '—' }}

            </span>

        </div>


        <div class="receipt-info-row">

            <span class="receipt-info-label">
                Terminal
            </span>

            <span class="receipt-info-value">

                {{ $order->terminal?->displayName() ?? '—' }}

            </span>

        </div>


        <div class="receipt-info-row">

            <span class="receipt-info-label">
                Customer
            </span>

            <span class="receipt-info-value">

                {{ $order->customer?->displayName() ?? 'Walk-in Customer' }}

            </span>

        </div>

    </div>


    {{-- ==========================================================
        Items
    =========================================================== --}}

    <div class="receipt-items-wrapper">

        <table class="receipt-items">

            <thead>

                <tr>

                    <th>
                        Item
                    </th>

                    <th class="text-end">
                        Qty
                    </th>

                    <th class="text-end">
                        Amount
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse (
                    $orderItems
                    as $item
                )

                    <tr>

                        <td>

                            <div class="receipt-item-name">

                                {{
                                    $item->product_name
                                    ?? $item->product?->name
                                    ?? 'Unknown Product'
                                }}

                            </div>


                            <div class="receipt-item-meta">

                                {{ \App\Helpers\CurrencyHelper::format(
                                    (float) $item->unit_price
                                ) }}

                                each

                            </div>



                        </td>


                        <td class="text-end">

                            {{ number_format(
                                (float) $item->quantity,
                                2
                            ) }}

                        </td>


                        <td class="text-end fw-semibold">

                            {{ \App\Helpers\CurrencyHelper::format(
                                (float) $item->total
                            ) }}

                        </td>
                       


                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="text-center text-muted"
                        >

                            No items available.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


 
    {{-- ==========================================================
        Totals
    =========================================================== --}}

    <div class="receipt-totals">

        <div class="receipt-total-row">

            <span>
                Subtotal
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->subtotal
                ) }}

            </strong>

        </div>


        <div class="receipt-total-row">

            <span>
                Discount
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->discount
                ) }}

            </strong>

        </div>


        <div class="receipt-total-row">

            <span>
                Tax
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->tax
                ) }}

            </strong>

        </div>


        <div class="receipt-total-row receipt-grand-total">

            <span>
                Grand Total
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->grand_total
                ) }}

            </strong>

        </div>

    </div>


    {{-- ==========================================================
        Payment
    =========================================================== --}}

    <div class="receipt-payment">

        <div class="receipt-payment-title">

            Payment Summary

        </div>


        <div class="receipt-total-row">

            <span>
                Amount Paid
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->amount_paid
                ) }}

            </strong>

        </div>


        <div class="receipt-total-row">

            <span>
                Balance
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->balance
                ) }}

            </strong>

        </div>


        <div class="receipt-total-row">

            <span>
                Change
            </span>

            <strong>

                {{ \App\Helpers\CurrencyHelper::format(
                    (float) $order->change_given
                ) }}

            </strong>

        </div>

    </div>




    {{-- ==========================================================
        Footer
    =========================================================== --}}

    <div class="receipt-footer">

        @if (
            filled(
                $receiptSettings?->receipt_footer
            )
        )

            <div>

                {!! nl2br(
                    e(
                        $receiptSettings->receipt_footer
                    )
                ) !!}

            </div>

        @else

            <div>
                Thank you for your business.
            </div>

        @endif


        <div class="mt-1">

            <strong>
                {{ $order->order_no }}
            </strong>

        </div>

    </div>

</div>


</div>

{{-- ==============================================================
Receipt Styles
=============================================================== --}}

<style>

.receipt-print-wrapper {

    padding:
        24px;

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


.receipt-print-document {

    width:
        100%;

    max-width:
        420px;

    margin:
        0 auto;

    padding:
        28px;

    background:
        #ffffff;

    border:
        1px solid #e5e7eb;

    border-radius:
        12px;

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
| Information
|--------------------------------------------------------------------------
*/

.receipt-info {

    padding:
        14px 0;

    border-bottom:
        1px dashed #d0d5dd;

}


.receipt-info-row {

    display:
        flex;

    justify-content:
        space-between;

    gap:
        15px;

    margin-bottom:
        6px;

    font-size:
        10px;

}


.receipt-info-row:last-child {

    margin-bottom:
        0;

}


.receipt-info-label {

    color:
        #667085;

}


.receipt-info-value {

    max-width:
        65%;

    color:
        #101828;

    text-align:
        right;

    font-weight:
        600;

}


/*
|--------------------------------------------------------------------------
| Items
|--------------------------------------------------------------------------
*/

.receipt-items-wrapper {

    margin-top:
        14px;

}


.receipt-items {

    width:
        100%;

    border-collapse:
        collapse;

}


.receipt-items th {

    padding:
        0 0 7px;

    border-bottom:
        1px solid #d0d5dd;

    color:
        #667085;

    font-size:
        9px;

    font-weight:
        700;

    text-transform:
        uppercase;

}


.receipt-items td {

    padding:
        8px 0;

    border-bottom:
        1px solid #f2f4f7;

    color:
        #101828;

    font-size:
        10px;

    vertical-align:
        top;

}


.receipt-item-name {

    max-width:
        190px;

    padding-right:
        8px;

    font-weight:
        600;

}


.receipt-item-meta {

    margin-top:
        2px;

    color:
        #98a2b3;

    font-size:
        8px;

    font-weight:
        400;

}


.text-end {

    text-align:
        right;

}


/*
|--------------------------------------------------------------------------
| Totals
|--------------------------------------------------------------------------
*/

.receipt-totals {

    margin-top:
        12px;

    padding-top:
        10px;

    border-top:
        1px dashed #d0d5dd;

}


.receipt-total-row {

    display:
        flex;

    justify-content:
        space-between;

    gap:
        12px;

    margin-bottom:
        5px;

    font-size:
        10px;

}


.receipt-total-row span {

    color:
        #667085;

}


.receipt-total-row strong {

    color:
        #101828;

    font-weight:
        600;

}


.receipt-grand-total {

    margin-top:
        8px;

    padding-top:
        8px;

    border-top:
        1px solid #101828;

    font-size:
        13px;

}


.receipt-grand-total span {

    color:
        #101828;

    font-weight:
        700;

}


.receipt-grand-total strong {

    color:
        #157347;

    font-size:
        14px;

}


/*
|--------------------------------------------------------------------------
| Payment
|--------------------------------------------------------------------------
*/

.receipt-payment {

    margin-top:
        14px;

    padding:
        11px;

    background:
        #f8fafc;

    border:
        1px solid #eaecf0;

    border-radius:
        7px;

}


.receipt-payment-title {

    margin-bottom:
        8px;

    color:
        #344054;

    font-size:
        9px;

    font-weight:
        700;

    text-transform:
        uppercase;

}


/*
|--------------------------------------------------------------------------
| Footer
|--------------------------------------------------------------------------
*/

.receipt-footer {

    margin-top:
        18px;

    padding-top:
        12px;

    border-top:
        1px dashed #d0d5dd;

    text-align:
        center;

    color:
        #667085;

    font-size:
        9px;

    line-height:
        1.5;

}


.receipt-footer strong {

    color:
        #344054;

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
