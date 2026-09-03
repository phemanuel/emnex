<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Sales Receipt
    </title>

</head>

<body class="pos-receipt-page">

@php

    $orderItems =
        $order->orderItems ?? collect();

    $payments =
        $order->payments ?? collect();

@endphp


<div class="receipt-print-wrapper">


    {{-- ==========================================================
        Receipt Toolbar
    =========================================================== --}}

    <div class="receipt-print-toolbar no-print">

        <div>

            <div class="receipt-toolbar-label">
                Sales Receipt
            </div>

            <div class="receipt-toolbar-order">
                {{ $order->order_no }}
            </div>

        </div>


        <div class="receipt-toolbar-actions">

            <button
                type="button"
                class="receipt-close-button"
                onclick="
                    window.parent?.CashierShell?.showHome()
                "
            >

                <i class="bi bi-x-lg"></i>

                <span>
                    Close
                </span>

            </button>


            <button
                type="button"
                class="receipt-print-button"
                onclick="printReceipt()"
            >

                <i class="bi bi-printer"></i>

                <span>
                    Print Receipt
                </span>

            </button>

        </div>

    </div>



    {{-- ==========================================================
        Receipt Document
    =========================================================== --}}

    <div class="receipt-print-document">


        {{-- ======================================================
            Header
        ======================================================= --}}

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


                {{-- Company Information --}}

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



        {{-- ======================================================
            Order Information
        ======================================================= --}}

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
                    Cashier
                </span>

                <span class="receipt-info-value">

                    {{
                        trim(
                            ($order->cashier?->first_name ?? '')
                            . ' '
                            . ($order->cashier?->last_name ?? '')
                        )
                        ?: '—'
                    }}

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



        {{-- ======================================================
            Items
        ======================================================= --}}

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

                                    {{
                                        \App\Helpers\CurrencyHelper::format(
                                            (float) $item->unit_price
                                        )
                                    }}

                                    each

                                </div>

                            </td>


                            <td class="text-end">

                                {{
                                    number_format(
                                        (float) $item->quantity,
                                        2
                                    )
                                }}

                            </td>


                            <td class="text-end receipt-item-total">

                                {{
                                    \App\Helpers\CurrencyHelper::format(
                                        (float) $item->total
                                    )
                                }}

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



        {{-- ======================================================
            Totals
        ======================================================= --}}

        <div class="receipt-totals">


            <div class="receipt-total-row">

                <span>
                    Subtotal
                </span>

                <strong>

                    {{
                        \App\Helpers\CurrencyHelper::format(
                            (float) $order->subtotal
                        )
                    }}

                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Discount
                </span>

                <strong>

                    {{
                        \App\Helpers\CurrencyHelper::format(
                            (float) $order->discount
                        )
                    }}

                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Tax
                </span>

                <strong>

                    {{
                        \App\Helpers\CurrencyHelper::format(
                            (float) $order->tax
                        )
                    }}

                </strong>

            </div>


            <div class="receipt-total-row receipt-grand-total">

                <span>
                    Grand Total
                </span>

                <strong>

                    {{
                        \App\Helpers\CurrencyHelper::format(
                            (float) $order->grand_total
                        )
                    }}

                </strong>

            </div>

        </div>



        {{-- ======================================================
            Payment
        ======================================================= --}}

        <div class="receipt-payment">


            <div class="receipt-payment-title">

                Payment Summary

            </div>


            @forelse (
                $payments
                as $payment
            )

                <div class="receipt-total-row">

                    <span>
                        Payment Method
                    </span>

                    <strong>

                        {{ $payment->payment_method ?? '—' }}

                    </strong>

                </div>


                <div class="receipt-total-row">

                    <span>
                        Amount Paid
                    </span>

                    <strong>

                        {{
                            \App\Helpers\CurrencyHelper::format(
                                (float) $payment->amount
                            )
                        }}

                    </strong>

                </div>


                @if (
                    filled(
                        $payment->reference_no
                    )
                )

                    <div class="receipt-total-row">

                        <span>
                            Reference
                        </span>

                        <strong>

                            {{ $payment->reference_no }}

                        </strong>

                    </div>

                @endif

            @empty

                <div class="receipt-total-row">

                    <span>
                        Payment Method
                    </span>

                    <strong>
                        —
                    </strong>

                </div>

            @endforelse


            <div class="receipt-total-row">

                <span>
                    Balance
                </span>

                <strong>

                    {{
                        \App\Helpers\CurrencyHelper::format(
                            (float) $order->balance
                        )
                    }}

                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Change
                </span>

                <strong>

                    {{
                        \App\Helpers\CurrencyHelper::format(
                            (float) $order->change_given
                        )
                    }}

                </strong>

            </div>

        </div>



        {{-- ======================================================
            Footer
        ======================================================= --}}

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


            <div class="receipt-footer-order">

                <strong>
                    {{ $order->order_no }}
                </strong>

            </div>

        </div>


    </div>

</div>



<style>

/*
|--------------------------------------------------------------------------
| Page
|--------------------------------------------------------------------------
*/

html,
body {

    width:
        100%;

    min-height:
        100%;

    margin:
        0;

    padding:
        0;

    background:
        #f8fafc;
}


body {

    color:
        #101828;

    font-family:
        Arial,
        Helvetica,
        sans-serif;
}


/*
|--------------------------------------------------------------------------
| Wrapper
|--------------------------------------------------------------------------
*/

.receipt-print-wrapper {

    width:
        100%;

    min-height:
        100vh;

    box-sizing:
        border-box;

    padding:
        28px;
}


/*
|--------------------------------------------------------------------------
| Toolbar
|--------------------------------------------------------------------------
*/

.receipt-print-toolbar {

    width:
        min(
            100%,
            1000px
        );

    margin:
        0 auto 24px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        20px;
}


.receipt-toolbar-label {

    color:
        #98a2b3;

    font-size:
        10px;

    font-weight:
        700;

    text-transform:
        uppercase;

    letter-spacing:
        .08em;
}


.receipt-toolbar-order {

    margin-top:
        3px;

    color:
        #101828;

    font-size:
        13px;

    font-weight:
        700;
}


.receipt-toolbar-actions {

    display:
        flex;

    align-items:
        center;

    gap:
        8px;
}


/*
|--------------------------------------------------------------------------
| Toolbar Buttons
|--------------------------------------------------------------------------
*/

.receipt-close-button,
.receipt-print-button {

    min-height:
        36px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    gap:
        7px;

    padding:
        0 14px;

    border-radius:
        8px;

    font-size:
        11px;

    font-weight:
        700;

    cursor:
        pointer;

    transition:
        .18s ease;
}


.receipt-close-button {

    border:
        1px solid #dfe3e8;

    background:
        #ffffff;

    color:
        #475467;
}


.receipt-close-button:hover {

    background:
        #f8fafc;

    border-color:
        #cfd4dc;

    color:
        #101828;
}


.receipt-print-button {

    border:
        1px solid #172033;

    background:
        #172033;

    color:
        #ffffff;
}


.receipt-print-button:hover {

    border-color:
        #0f172a;

    background:
        #0f172a;
}


/*
|--------------------------------------------------------------------------
| Receipt
|--------------------------------------------------------------------------
*/

.receipt-print-document {

    width:
        100%;

    max-width:
        420px;

    margin:
        0 auto;

    padding:
        28px;

    box-sizing:
        border-box;

    background:
        #ffffff;

    border:
        1px solid #e5e7eb;

    border-radius:
        12px;

    box-shadow:
        0 12px 35px rgba(
            15,
            23,
            42,
            .08
        );
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

    width:
        100%;

    height:
        100%;

    object-fit:
        contain;

    padding:
        5px;

    box-sizing:
        border-box;
}


.receipt-company-logo-placeholder {

    width:
        100%;

    height:
        100%;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    background:
        #f2f4f7;

    color:
        #98a2b3;

    font-size:
        20px;
}


.receipt-company-details {

    flex:
        1;

    min-width:
        0;
}


.receipt-company-name {

    color:
        #101828;

    font-size:
        16px;

    font-weight:
        700;

    line-height:
        1.25;
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

    text-align:
        left;

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
}


.receipt-item-total {

    font-weight:
        600;
}


.text-end {

    text-align:
        right !important;
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


.receipt-footer-order {

    margin-top:
        4px;
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

        width:
            100% !important;

        min-height:
            0 !important;

        margin:
            0 !important;

        padding:
            0 !important;

        background:
            #ffffff !important;
    }


    .no-print {

        display:
            none !important;
    }


    .receipt-print-wrapper {

        width:
            100% !important;

        min-height:
            0 !important;

        margin:
            0 !important;

        padding:
            0 !important;
    }


    .receipt-print-document {

        width:
            100% !important;

        max-width:
            420px !important;

        margin:
            0 auto !important;

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

</style>


<script>

function printReceipt() {

    window.print();

}

</script>

</body>

</html>