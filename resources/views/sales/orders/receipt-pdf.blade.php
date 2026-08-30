    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>
            Receipt - {{ $order->order_no }}
        </title>


        <style>

            @page {

                margin:
                    24px;

            }


            * {

                box-sizing:
                    border-box;

            }


            body {

                margin:
                    0;

                color:
                    #101828;

                font-family:
                    DejaVu Sans,
                    sans-serif;

                font-size:
                    10px;

            }


            .receipt {

                width:
                    100%;

            }


            .header {

                text-align:
                    center;

                padding-bottom:
                    12px;

                border-bottom:
                    1px dashed #b0b7c3;

            }


            .brand {

                font-size:
                    18px;

                font-weight:
                    bold;

            }


            .subtitle {

                margin-top:
                    4px;

                color:
                    #667085;

                font-size:
                    10px;

            }


            .status {

                margin-top:
                    6px;

                color:
                    #157347;

                font-size:
                    9px;

                font-weight:
                    bold;

            }


            .info {

                padding:
                    10px 0;

                border-bottom:
                    1px dashed #b0b7c3;

            }


            .info-row {

                width:
                    100%;

                margin-bottom:
                    4px;

            }


            .info-label {

                width:
                    30%;

                color:
                    #667085;

            }


            .info-value {

                width:
                    70%;

                text-align:
                    right;

                font-weight:
                    bold;

            }


            table {

                width:
                    100%;

                border-collapse:
                    collapse;

            }


            .items {

                margin-top:
                    12px;

            }


            .items th {

                padding:
                    0 0 6px;

                border-bottom:
                    1px solid #b0b7c3;

                color:
                    #667085;

                font-size:
                    8px;

                text-transform:
                    uppercase;

            }


            .items td {

                padding:
                    7px 0;

                border-bottom:
                    1px solid #eeeeee;

                font-size:
                    9px;

            }


            .right {

                text-align:
                    right;

            }


            .meta {

                margin-top:
                    2px;

                color:
                    #98a2b3;

                font-size:
                    7px;

            }


            .totals {

                margin-top:
                    10px;

                padding-top:
                    8px;

                border-top:
                    1px dashed #b0b7c3;

            }


            .total-row {

                width:
                    100%;

                margin-bottom:
                    4px;

            }


            .grand-total {

                margin-top:
                    7px;

                padding-top:
                    7px;

                border-top:
                    1px solid #101828;

                font-size:
                    12px;

                font-weight:
                    bold;

            }


            .payment {

                margin-top:
                    10px;

                padding:
                    8px;

                border:
                    1px solid #dddddd;

            }


            .payment-title {

                margin-bottom:
                    6px;

                font-weight:
                    bold;

                text-transform:
                    uppercase;

            }


            .footer {

                margin-top:
                    16px;

                padding-top:
                    10px;

                border-top:
                    1px dashed #b0b7c3;

                text-align:
                    center;

                color:
                    #667085;

                font-size:
                    8px;

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
                Header
            =================================================== --}}

            <div class="header">

                <table class="company-header">

                    <tr>

                        <td class="logo-cell">

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
                                    class="company-logo"
                                    alt="Company Logo"
                                >

                            @else

                                <div class="logo-placeholder">
                                    EMNEX
                                </div>

                            @endif

                        </td>


                        <td class="company-details">

                            <div class="brand">

                                {{ $order->company?->name ?? 'EMNEX POS' }}

                            </div>


                            @if (
                                $order->company?->address
                            )

                                <div>
                                    {{ $order->company->address }}
                                </div>

                            @endif


                            @if (
                                $order->company?->phone ||
                                $order->company?->email
                            )

                                <div>

                                    {{ $order->company?->phone }}

                                    @if (
                                        $order->company?->phone &&
                                        $order->company?->email
                                    )
                                        •
                                    @endif

                                    {{ $order->company?->email }}

                                </div>

                            @endif


                            <div class="receipt-title">

                                SALES RECEIPT

                            </div>

                        </td>

                    </tr>

                </table>


                <!-- <div class="status">

                    COMPLETED

                </div> -->

            </div>


            {{-- ==================================================
                Order Information
            =================================================== --}}

            <table class="info">

                <tr class="info-row">

                    <td class="info-label">
                        Order No.
                    </td>

                    <td class="info-value">
                        {{ $order->order_no }}
                    </td>

                </tr>


                <tr class="info-row">

                    <td class="info-label">
                        Date
                    </td>

                    <td class="info-value">

                        {{
                            $order->completed_at
                                ? $order->completed_at->format(
                                    'd M Y, h:i A'
                                )
                                : '-'
                        }}

                    </td>

                </tr>


                <tr class="info-row">

                    <td class="info-label">
                        Branch
                    </td>

                    <td class="info-value">
                        {{ $order->branch?->name ?? '-' }}
                    </td>

                </tr>


                <tr class="info-row">

                    <td class="info-label">
                        Terminal
                    </td>

                    <td class="info-value">
                        {{ $order->terminal?->name ?? '-' }}
                    </td>

                </tr>


                <tr class="info-row">

                    <td class="info-label">
                        Customer
                    </td>

                    <td class="info-value">
                        {{ $order->customer?->name ?? 'Walk-in Customer' }}
                    </td>

                </tr>

            </table>


            {{-- ==================================================
                Items
            =================================================== --}}

            <table class="items">

                <thead>

                    <tr>

                        <th>
                            Item
                        </th>

                        <th class="right">
                            Qty
                        </th>

                        <th class="right">
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

                                {{ $item->product_name }}

                                <div class="meta">

                                    {{ number_format(
                                        $item->unit_price,
                                        2
                                    ) }}
                                    each

                                </div>

                            </td>


                            <td class="right">

                                {{ number_format(
                                    $item->quantity,
                                    2
                                ) }}

                            </td>


                            <td class="right">

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

            <div class="totals">

                <table>

                    <tr class="total-row">

                        <td>
                            Subtotal
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->subtotal
                            ) }}
                        </td>

                    </tr>


                    <tr class="total-row">

                        <td>
                            Discount
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->discount
                            ) }}
                        </td>

                    </tr>


                    <tr class="total-row">

                        <td>
                            Tax
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->tax
                            ) }}
                        </td>

                    </tr>


                    <tr class="grand-total">

                        <td>
                            Grand Total
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->grand_total
                            ) }}
                        </td>

                    </tr>

                </table>

            </div>


            {{-- ==================================================
                Payment
            =================================================== --}}

            <div class="payment">

                <div class="payment-title">
                    Payment Summary
                </div>


                <table>

                    <tr class="total-row">

                        <td>
                            Amount Paid
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->amount_paid
                            ) }}
                        </td>

                    </tr>


                    <tr class="total-row">

                        <td>
                            Balance
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->balance
                            ) }}
                        </td>

                    </tr>


                    <tr class="total-row">

                        <td>
                            Change
                        </td>

                        <td class="right">
                            {{ \App\Helpers\CurrencyHelper::format(
                                $order->change_given
                            ) }}
                        </td>

                    </tr>

                </table>

            </div>




            {{-- ==================================================
                Footer
            =================================================== --}}

            <div class="footer">

           @if (
                filled(
                    $receiptSettings?->receipt_footer
                )
            )

                <div class="footer-message">

                    {!! nl2br(
                        e(
                            $receiptSettings->receipt_footer
                        )
                    ) !!}

                </div>

            @endif


                <br>


                {{ $order->order_no }}

            </div>

        </div>

    </body>

    </html>