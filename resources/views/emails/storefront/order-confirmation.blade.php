<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Order confirmed
    </title>
</head>


<body
    style="
        margin:0;
        padding:0;
        background:#f4f7fb;
        font-family:Arial, Helvetica, sans-serif;
        color:#172033;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    role="presentation"
    style="
        width:100%;
        background:#f4f7fb;
    "
>

<tr>

<td
    align="center"
    style="
        padding:40px 16px;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    role="presentation"
    style="
        width:100%;
        max-width:640px;
    "
>

    {{-- ======================================================
        BRAND
    ======================================================= --}}
    <tr>

        <td
            align="center"
            style="
                padding:0 0 22px;
            "
        >

            @if($logoPath)

                <div
                    style="
                        margin-bottom:10px;
                        text-align:center;
                    "
                >

                    <img
                        src="{{ $message->embed($logoPath) }}"
                        alt="{{ $merchantName }}"
                        width="120"
                        style="
                            display:inline-block;
                            width:auto;
                            max-width:120px;
                            max-height:56px;
                            height:auto;
                            border:0;
                            outline:none;
                            text-decoration:none;
                        "
                    >

                </div>

            @endif


            <div
                style="
                    font-size:18px;
                    line-height:1.3;
                    font-weight:700;
                    color:#0f172a;
                    text-align:center;
                "
            >
                {{ $merchantName }}
            </div>

        </td>

    </tr>


    {{-- ======================================================
        MAIN CARD
    ======================================================= --}}
    <tr>

        <td
            style="
                background:#ffffff;
                border:1px solid #e9edf3;
                border-radius:18px;
                overflow:hidden;
                box-shadow:0 10px 30px rgba(15, 23, 42, 0.05);
            "
        >

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                role="presentation"
            >

                {{-- ==================================================
                    HERO
                =================================================== --}}
                <tr>

                    <td
                        style="
                            padding:34px 34px 26px;
                        "
                    >

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            role="presentation"
                        >

                            <tr>

                                <td
                                    width="54"
                                    valign="top"
                                >

                                    <div
                                        style="
                                            width:46px;
                                            height:46px;
                                            line-height:46px;
                                            text-align:center;
                                            border-radius:50%;
                                            background:#ecfdf3;
                                            color:#15803d;
                                            font-size:22px;
                                            font-weight:700;
                                        "
                                    >
                                        ✓
                                    </div>

                                </td>


                                <td
                                    valign="top"
                                    style="
                                        padding-left:14px;
                                    "
                                >

                                    <div
                                        style="
                                            margin:0 0 5px;
                                            font-size:11px;
                                            line-height:1.4;
                                            font-weight:700;
                                            letter-spacing:0.08em;
                                            text-transform:uppercase;
                                            color:#16a34a;
                                        "
                                    >
                                        Payment confirmed
                                    </div>


                                    <h1
                                        style="
                                            margin:0 0 8px;
                                            font-size:26px;
                                            line-height:1.25;
                                            font-weight:700;
                                            color:#0f172a;
                                        "
                                    >
                                        Your order is confirmed
                                    </h1>


                                    <p
                                        style="
                                            margin:0;
                                            font-size:14px;
                                            line-height:1.7;
                                            color:#667085;
                                        "
                                    >
                                        Hi {{ $order->customer?->first_name }},
                                        your payment was successful and
                                        {{ $merchantName }} has received your order.
                                    </p>

                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>


                {{-- ==================================================
                    ORDER META
                =================================================== --}}
                <tr>

                    <td
                        style="
                            padding:0 34px 26px;
                        "
                    >

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            role="presentation"
                            style="
                                background:#f8fafc;
                                border:1px solid #eef2f6;
                                border-radius:12px;
                            "
                        >

                            <tr>

                                <td
                                    style="
                                        padding:16px 18px;
                                    "
                                >

                                    <div
                                        style="
                                            margin-bottom:5px;
                                            font-size:10px;
                                            line-height:1.4;
                                            font-weight:700;
                                            letter-spacing:0.05em;
                                            text-transform:uppercase;
                                            color:#98a2b3;
                                        "
                                    >
                                        Order number
                                    </div>

                                    <div
                                        style="
                                            font-size:14px;
                                            line-height:1.5;
                                            font-weight:700;
                                            color:#101828;
                                        "
                                    >
                                        {{ $order->order_no }}
                                    </div>

                                </td>


                                <td
                                    align="right"
                                    style="
                                        padding:16px 18px;
                                    "
                                >

                                    <div
                                        style="
                                            margin-bottom:5px;
                                            font-size:10px;
                                            line-height:1.4;
                                            font-weight:700;
                                            letter-spacing:0.05em;
                                            text-transform:uppercase;
                                            color:#98a2b3;
                                        "
                                    >
                                        Order date
                                    </div>

                                    <div
                                        style="
                                            font-size:13px;
                                            line-height:1.5;
                                            font-weight:600;
                                            color:#344054;
                                        "
                                    >
                                        {{ $order->completed_at?->format('d M Y, g:i A') }}
                                    </div>

                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>


                {{-- ==================================================
                    SECTION TITLE
                =================================================== --}}
                <tr>

                    <td
                        style="
                            padding:0 34px 12px;
                        "
                    >

                        <div
                            style="
                                font-size:11px;
                                line-height:1.4;
                                font-weight:700;
                                letter-spacing:0.06em;
                                text-transform:uppercase;
                                color:#98a2b3;
                            "
                        >
                            Order summary
                        </div>

                    </td>

                </tr>


                {{-- ==================================================
                    ITEMS
                =================================================== --}}
                <tr>

                    <td
                        style="
                            padding:0 34px;
                        "
                    >

                        @foreach($order->orderItems as $item)

                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                role="presentation"
                                style="
                                    border-bottom:1px solid #eef2f6;
                                "
                            >

                                <tr>

                                    <td
                                        valign="top"
                                        style="
                                            padding:16px 0;
                                        "
                                    >

                                        <div
                                            style="
                                                margin-bottom:5px;
                                                font-size:14px;
                                                line-height:1.5;
                                                font-weight:700;
                                                color:#101828;
                                            "
                                        >
                                            {{ $item->product_name }}
                                        </div>


                                        <div
                                            style="
                                                font-size:12px;
                                                line-height:1.5;
                                                color:#98a2b3;
                                            "
                                        >
                                            Qty:
                                            {{ number_format(
                                                (float) $item->quantity,
                                                0
                                            ) }}

                                            &nbsp;•&nbsp;

                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $item->unit_price,
                                                2
                                            ) }}
                                            each
                                        </div>

                                    </td>


                                    <td
                                        align="right"
                                        valign="top"
                                        style="
                                            padding:16px 0 16px 16px;
                                            white-space:nowrap;
                                        "
                                    >

                                        <div
                                            style="
                                                font-size:14px;
                                                line-height:1.5;
                                                font-weight:700;
                                                color:#101828;
                                            "
                                        >
                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $item->total,
                                                2
                                            ) }}
                                        </div>

                                    </td>

                                </tr>

                            </table>

                        @endforeach

                    </td>

                </tr>


                {{-- ==================================================
                    TOTALS
                =================================================== --}}
                <tr>

                    <td
                        style="
                            padding:22px 34px 10px;
                        "
                    >

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            role="presentation"
                            style="
                                width:100%;
                            "
                        >

                            {{-- SUBTOTAL --}}
                            <tr>

                                <td
                                    style="
                                        padding:5px 0;
                                        font-size:13px;
                                        color:#667085;
                                    "
                                >
                                    Subtotal
                                </td>

                                <td
                                    align="right"
                                    style="
                                        padding:5px 0;
                                        font-size:13px;
                                        font-weight:600;
                                        color:#344054;
                                    "
                                >
                                    {{ $currencySymbol }}
                                    {{ number_format(
                                        (float) $order->subtotal,
                                        2
                                    ) }}
                                </td>

                            </tr>


                            {{-- DISCOUNT --}}
                            @if((float) $order->discount > 0)

                                <tr>

                                    <td
                                        style="
                                            padding:5px 0;
                                            font-size:13px;
                                            color:#667085;
                                        "
                                    >
                                        Discount
                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding:5px 0;
                                            font-size:13px;
                                            font-weight:600;
                                            color:#15803d;
                                        "
                                    >
                                        -{{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $order->discount,
                                            2
                                        ) }}
                                    </td>

                                </tr>

                            @endif


                            {{-- TAX --}}
                            @if((float) $order->tax > 0)

                                <tr>

                                    <td
                                        style="
                                            padding:5px 0;
                                            font-size:13px;
                                            color:#667085;
                                        "
                                    >
                                        Tax
                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding:5px 0;
                                            font-size:13px;
                                            font-weight:600;
                                            color:#344054;
                                        "
                                    >
                                        {{ $currencySymbol }}
                                        {{ number_format(
                                            (float) $order->tax,
                                            2
                                        ) }}
                                    </td>

                                </tr>

                            @endif


                            {{-- SHIPPING --}}
                            @if(
                                !is_null($order->shipping_fee) &&
                                $order->shipping_method
                            )

                                <tr>

                                    <td
                                        style="
                                            padding:5px 0;
                                            font-size:13px;
                                            color:#667085;
                                        "
                                    >
                                        Shipping
                                    </td>

                                    <td
                                        align="right"
                                        style="
                                            padding:5px 0;
                                            font-size:13px;
                                            font-weight:600;
                                            color:#344054;
                                        "
                                    >

                                        @if((float) $order->shipping_fee > 0)

                                            {{ $currencySymbol }}
                                            {{ number_format(
                                                (float) $order->shipping_fee,
                                                2
                                            ) }}

                                        @else

                                            Free

                                        @endif

                                    </td>

                                </tr>

                            @endif

                        </table>

                    </td>

                </tr>


                {{-- ==================================================
                    GRAND TOTAL
                =================================================== --}}
                <tr>

                    <td
                        style="
                            padding:10px 34px 26px;
                        "
                    >

                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            role="presentation"
                            style="
                                width:100%;
                                border-top:1px solid #e9edf3;
                            "
                        >

                            <tr>

                                <td
                                    style="
                                        padding-top:18px;
                                        font-size:15px;
                                        font-weight:700;
                                        color:#101828;
                                    "
                                >
                                    Total paid
                                </td>

                                <td
                                    align="right"
                                    style="
                                        padding-top:18px;
                                        font-size:20px;
                                        font-weight:700;
                                        color:#101828;
                                    "
                                >
                                    {{ $currencySymbol }}
                                    {{ number_format(
                                        (float) $order->grand_total,
                                        2
                                    ) }}
                                </td>

                            </tr>

                        </table>

                    </td>

                </tr>


                {{-- ==================================================
                    DELIVERY DETAILS
                =================================================== --}}
                @if($order->shipping_method)

                    <tr>

                        <td
                            style="
                                padding:0 34px 12px;
                            "
                        >

                            <div
                                style="
                                    font-size:11px;
                                    line-height:1.4;
                                    font-weight:700;
                                    letter-spacing:0.06em;
                                    text-transform:uppercase;
                                    color:#98a2b3;
                                "
                            >
                                Delivery details
                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td
                            style="
                                padding:0 34px 26px;
                            "
                        >

                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                role="presentation"
                                style="
                                    width:100%;
                                    background:#f8fafc;
                                    border:1px solid #eef2f6;
                                    border-radius:12px;
                                "
                            >

                                <tr>

                                    <td
                                        style="
                                            padding:18px;
                                        "
                                    >

                                        {{-- LOCATION SHIPPING --}}
                                        @if(
                                            $order->shipping_method === 'location'
                                        )

                                            <div
                                                style="
                                                    margin-bottom:5px;
                                                    font-size:10px;
                                                    line-height:1.4;
                                                    font-weight:700;
                                                    letter-spacing:0.05em;
                                                    text-transform:uppercase;
                                                    color:#98a2b3;
                                                "
                                            >
                                                Delivery location
                                            </div>


                                            <div
                                                style="
                                                    font-size:14px;
                                                    line-height:1.5;
                                                    font-weight:700;
                                                    color:#101828;
                                                "
                                            >
                                                {{ $order->shipping_location_name }}
                                            </div>


                                            <div
                                                style="
                                                    margin-top:7px;
                                                    font-size:12px;
                                                    line-height:1.6;
                                                    color:#667085;
                                                "
                                            >
                                                Your order will be delivered to the selected delivery area.
                                            </div>

                                        @endif


                                        {{-- MANUAL SHIPPING --}}
                                        @if(
                                            $order->shipping_method === 'manual'
                                        )

                                            <div
                                                style="
                                                    margin-bottom:5px;
                                                    font-size:10px;
                                                    line-height:1.4;
                                                    font-weight:700;
                                                    letter-spacing:0.05em;
                                                    text-transform:uppercase;
                                                    color:#98a2b3;
                                                "
                                            >
                                                Delivery address
                                            </div>


                                            <div
                                                style="
                                                    font-size:14px;
                                                    line-height:1.7;
                                                    font-weight:600;
                                                    color:#101828;
                                                "
                                            >

                                                @if($order->shipping_address)

                                                    {{ $order->shipping_address }}

                                                @endif


                                                @if($order->shipping_city)

                                                    <br>
                                                    {{ $order->shipping_city }}

                                                @endif


                                                @if($order->shipping_state)

                                                    @if($order->shipping_city)
                                                        ,
                                                    @endif

                                                    {{ $order->shipping_state }}

                                                @endif

                                            </div>

                                        @endif


                                        {{-- DELIVERY FEE --}}
                                        <table
                                            width="100%"
                                            cellpadding="0"
                                            cellspacing="0"
                                            role="presentation"
                                            style="
                                                width:100%;
                                                margin-top:16px;
                                                border-top:1px solid #e9edf3;
                                            "
                                        >

                                            <tr>

                                                <td
                                                    style="
                                                        padding-top:14px;
                                                        font-size:12px;
                                                        color:#667085;
                                                    "
                                                >
                                                    Delivery fee
                                                </td>


                                                <td
                                                    align="right"
                                                    style="
                                                        padding-top:14px;
                                                        font-size:13px;
                                                        font-weight:700;
                                                        color:#101828;
                                                    "
                                                >

                                                    @if((float) $order->shipping_fee > 0)

                                                        {{ $currencySymbol }}
                                                        {{ number_format(
                                                            (float) $order->shipping_fee,
                                                            2
                                                        ) }}

                                                    @else

                                                        Free

                                                    @endif

                                                </td>

                                            </tr>

                                        </table>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>

                @endif


                {{-- ==================================================
                    CTA
                =================================================== --}}
                <tr>

                    <td
                        align="center"
                        style="
                            padding:0 34px 34px;
                        "
                    >

                        <a
                            href="{{ $orderUrl }}"
                            style="
                                display:inline-block;
                                padding:14px 24px;
                                background:#111827;
                                color:#ffffff;
                                text-decoration:none;
                                border-radius:10px;
                                font-size:13px;
                                line-height:1;
                                font-weight:700;
                            "
                        >
                            View your order
                        </a>


                        <div
                            style="
                                margin-top:13px;
                                font-size:11px;
                                line-height:1.6;
                                color:#98a2b3;
                            "
                        >
                            You can use this link to review your order details at any time.
                        </div>

                    </td>

                </tr>

            </table>

        </td>

    </tr>


    {{-- ======================================================
        FOOTER
    ======================================================= --}}
    <tr>

        <td
            align="center"
            style="
                padding:22px 24px 0;
            "
        >

            <div
                style="
                    margin-bottom:5px;
                    font-size:12px;
                    line-height:1.5;
                    font-weight:700;
                    color:#475467;
                "
            >
                {{ $merchantName }}
            </div>


            <div
                style="
                    font-size:11px;
                    line-height:1.6;
                    color:#98a2b3;
                "
            >
                This email was sent because an order was placed with
                {{ $merchantName }}.
            </div>

        </td>

    </tr>

</table>

</td>

</tr>

</table>

</body>

</html>