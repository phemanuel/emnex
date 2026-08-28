<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Sales Receipt - {{ $order->order_no }}
    </title>


    <style>

        * {

            box-sizing:
                border-box;

        }


        html,
        body {

            margin:
                0;

            padding:
                0;

            background:
                #ffffff;

            color:
                #101828;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

        }


        body {

            padding:
                24px;

        }


        .receipt {

            width:
                100%;

            max-width:
                420px;

            margin:
                0 auto;

        }


        /*
|--------------------------------------------------------------------------
| Receipt Header
|--------------------------------------------------------------------------
*/

.receipt-header {

    padding-bottom:
        14px;

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


/*
|--------------------------------------------------------------------------
| Company Logo
|--------------------------------------------------------------------------
*/

.receipt-company-logo {

    width:
        64px;

    height:
        64px;

    flex:
        0 0 64px;

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


/*
|--------------------------------------------------------------------------
| Company Details
|--------------------------------------------------------------------------
*/

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
        0.08em;

}


/*
|--------------------------------------------------------------------------
| Completed Status
|--------------------------------------------------------------------------
*/

.receipt-status {

    display:
        inline-block;

    margin-top:
        10px;

    padding:
        4px 9px;

    border:
        1px solid #abefc6;

    border-radius:
        999px;

    background:
        #ecfdf3;

    color:
        #157347;

    font-size:
        8px;

    font-weight:
        700;

    letter-spacing:
        0.04em;

}


/*
|--------------------------------------------------------------------------
| Responsive
|--------------------------------------------------------------------------
*/

@media (
    max-width: 480px
) {

    .receipt-company-logo {

        width:
            56px;

        height:
            56px;

        flex-basis:
            56px;

    }


    .receipt-company-name {

        font-size:
            14px;

    }

}

        /*
        |--------------------------------------------------------------------------
        | Information
        |--------------------------------------------------------------------------
        */

        .receipt-info {

            padding:
                12px 0;

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
                5px;

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

        .receipt-items {

            width:
                100%;

            margin-top:
                14px;

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


        .text-right {

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
                12px;

            padding:
                10px;

            background:
                #f8fafc;

            border:
                1px solid #eaecf0;

            border-radius:
                6px;

        }


        .receipt-payment-title {

            margin-bottom:
                7px;

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

            body {

                padding:
                    0;

            }


            .receipt {

                max-width:
                    none;

            }

        }

    </style>

</head>


<body>

@php

    $orderItems =
        $order->orderItems ??
        collect();

@endphp



    <div class="receipt">

                
        {{-- ==================================================
            Receipt Header
        =================================================== --}}

        <div class="receipt-header">

            <div class="receipt-header-company">

                {{-- ==================================================
                    Company Logo
                =================================================== --}}

                <div class="receipt-company-logo">

                    @if (
                        $order->company?->logo
                    )

                        <img
                            src="{{ asset(
                                'uploads/company/' .
                                ltrim(
                                    $order->company->logo,
                                    '/'
                                )
                            ) }}"
                            alt="{{ $order->company?->company_name ?? 'Company Logo' }}"
                        >

                    @else

                        <div class="receipt-company-logo-placeholder">

                            <i class="bi bi-buildings"></i>

                        </div>

                    @endif

                </div>


                {{-- ==================================================
                    Company Details
                =================================================== --}}

                <div class="receipt-company-details">

                    <div class="receipt-company-name">

                        {{ $order->company?->name ?? 'EMNEX POS' }}

                    </div>


                    @if (
                        $order->company?->address
                    )

                        <div class="receipt-company-detail">

                            {{ $order->company->address }}

                        </div>

                    @endif


                    <div class="receipt-company-contact">

                        @if (
                            $order->company?->phone
                        )

                            <span>
                                {{ $order->company->phone }}
                            </span>

                        @endif


                        @if (
                            $order->company?->email
                        )

                            <span>

                                @if (
                                    $order->company?->phone
                                )
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


            {{-- ==================================================
                Completed Status
            =================================================== --}}

            <!-- <div class="receipt-status">

                COMPLETED

            </div> -->

        </div>

        {{-- ==================================================
            Order Information
        =================================================== --}}

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
                            : '-'
                    }}

                </span>

            </div>


            <div class="receipt-info-row">

                <span class="receipt-info-label">
                    Branch
                </span>

                <span class="receipt-info-value">
                    {{ $order->branch?->name ?? '-' }}
                </span>

            </div>


            <div class="receipt-info-row">

                <span class="receipt-info-label">
                    Terminal
                </span>

                <span class="receipt-info-value">
                    {{ $order->terminal?->terminal_name ?? '-' }}
                </span>

            </div>


            <div class="receipt-info-row">

                <span class="receipt-info-label">
                    Customer
                </span>

                <span class="receipt-info-value">
                    {{ $order->customer?->name ?? 'Walk-in Customer' }}
                </span>

            </div>

        </div>


        {{-- ==================================================
            Items
        =================================================== --}}

        <table class="receipt-items">

            <thead>

                <tr>

                    <th>
                        Item
                    </th>

                    <th class="text-right">
                        Qty
                    </th>

                    <th class="text-right">
                        Amount
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach (
                    $orderItems
                    as $item
                )

                    <tr>

                        <td>

                            <div class="receipt-item-name">

                                {{ $item->product_name }}

                            </div>


                            <div class="receipt-item-meta">

                                {{ number_format(
                                    $item->unit_price,
                                    2
                                ) }}
                                each

                            </div>

                        </td>


                        <td class="text-right">

                            {{ number_format(
                                $item->quantity,
                                2
                            ) }}

                        </td>


                        <td class="text-right">

                            {{ number_format(
                                $item->total,
                                2
                            ) }}

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


        {{-- ==================================================
            Totals
        =================================================== --}}

        <div class="receipt-totals">

            <div class="receipt-total-row">

                <span>
                    Subtotal
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->subtotal,
                        2
                    ) }}
                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Discount
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->discount,
                        2
                    ) }}
                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Tax
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->tax,
                        2
                    ) }}
                </strong>

            </div>


            <div class="receipt-total-row receipt-grand-total">

                <span>
                    Grand Total
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->grand_total,
                        2
                    ) }}
                </strong>

            </div>

        </div>


        {{-- ==================================================
            Payment
        =================================================== --}}

        <div class="receipt-payment">

            <div class="receipt-payment-title">

                Payment Summary

            </div>


            <div class="receipt-total-row">

                <span>
                    Amount Paid
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->amount_paid,
                        2
                    ) }}
                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Balance
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->balance,
                        2
                    ) }}
                </strong>

            </div>


            <div class="receipt-total-row">

                <span>
                    Change
                </span>

                <strong>
                    ₦{{ number_format(
                        $order->change_given,
                        2
                    ) }}
                </strong>

            </div>

        </div>


        {{-- ==================================================
            Footer
        =================================================== --}}

        <div class="receipt-footer">

            @if (
                filled(
                    $receiptSettings?->receipt_footer
                )
            )

                <div class="receipt-footer-message">

                    {!! nl2br(
                        e(
                            $receiptSettings->receipt_footer
                        )
                    ) !!}

                </div>

            @endif


            <div>
                <strong>
                    {{ $order->order_no }}
                </strong>
            </div>

        </div>

        {{-- ==================================================
                    Receipt Actions
                =================================================== --}}

                <div class="receipt-actions no-print">

                    <button
                        type="button"
                        class="receipt-print-button"
                        onclick="window.print()"
                    >

                        <i class="bi bi-printer"></i>

                        <span>
                            Print Receipt
                        </span>

                    </button>

                </div>

    </div>


    

</body>

</html>