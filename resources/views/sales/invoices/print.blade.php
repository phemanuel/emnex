@extends('layouts.app')

@section('title', 'Print Invoice')

@section('content')

<div class="invoice-print-wrapper">

    {{-- ==============================================================
        Print Toolbar
    =============================================================== --}}

    <div class="invoice-print-toolbar d-print-none">

        <div>

            <div class="text-muted small">
                Sales Invoice
            </div>

            <div class="fw-semibold">
                {{ $invoice->invoice_no }}
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
                class="btn btn-primary btn-sm"
                onclick="window.print()"
            >

                <i class="bi bi-printer me-1"></i>

                Print Invoice

            </button>

        </div>

    </div>


    {{-- ==============================================================
        Invoice Document
    =============================================================== --}}

    <div class="invoice-print-document">

        {{-- ==========================================================
            Header
        =========================================================== --}}

        <div class="invoice-print-header">

            <div>

                <div class="invoice-print-company-name">

                    {{ $invoice->branch?->company?->name
                        ?? config('app.name') }}

                </div>


                <div class="invoice-print-company-details">

                    @if ($invoice->branch?->name)

                        <div>
                            {{ $invoice->branch->name }}
                        </div>

                    @endif

                    @if ($invoice->branch?->address)

                        <div>
                            {{ $invoice->branch->address }}
                        </div>

                    @endif

                    @if ($invoice->branch?->phone)

                        <div>
                            {{ $invoice->branch->phone }}
                        </div>

                    @endif

                </div>

            </div>


            <div class="invoice-print-title">

                <div class="invoice-print-title-label">
                    INVOICE
                </div>


                <div class="invoice-print-number">

                    {{ $invoice->invoice_no }}

                </div>


                <div class="invoice-print-date">

                    {{ optional($invoice->invoice_date)
                        ->format('d M Y, h:i A') }}

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Information
        =========================================================== --}}

        <div class="invoice-print-info-grid">

            <div>

                <div class="invoice-print-section-label">
                    BILL TO
                </div>


                <div class="invoice-print-value">

                    {{ $invoice->customer?->displayName()
                        ?? 'Walk-in Customer' }}

                </div>


                @if ($invoice->customer?->customer_code)

                    <div class="invoice-print-muted">

                        {{ $invoice->customer->customer_code }}

                    </div>

                @endif

            </div>


            <div>

                <div class="invoice-print-section-label">
                    ORDER
                </div>


                <div class="invoice-print-value">

                    {{ $invoice->order?->order_no ?? '—' }}

                </div>


                <div class="invoice-print-muted">

                    Status:
                    {{ $invoice->order?->order_status ?? '—' }}

                </div>

            </div>


            <div>

                <div class="invoice-print-section-label">
                    BRANCH
                </div>


                <div class="invoice-print-value">

                    {{ $invoice->branch?->name ?? '—' }}

                </div>


                <div class="invoice-print-muted">

                    Terminal:
                    {{ $invoice->terminal?->displayName() ?? '—' }}

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Items
        =========================================================== --}}

        <div class="invoice-print-items">

            <table>

                <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Product
                        </th>

                        <th class="text-end">
                            Qty
                        </th>

                        <th class="text-end">
                            Unit Price
                        </th>

                        <th class="text-end">
                            Discount
                        </th>

                        <th class="text-end">
                            Tax
                        </th>

                        <th class="text-end">
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse (
                        $invoice->order?->orderItems ?? []
                        as $index => $item
                    )

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>


                            <td>

                                <div class="fw-semibold">

                                    {{ $item->product_name
                                        ?? $item->product?->name
                                        ?? 'Unknown Product' }}

                                </div>


                                @if ($item->product_barcode)

                                    <div class="invoice-print-muted">

                                        {{ $item->product_barcode }}

                                    </div>

                                @endif

                            </td>


                            <td class="text-end">

                                {{ number_format(
                                    (float) $item->quantity,
                                    2
                                ) }}

                            </td>


                            <td class="text-end">

                                {{ number_format(
                                    (float) $item->unit_price,
                                    2
                                ) }}

                            </td>


                            <td class="text-end">

                                {{ number_format(
                                    (float) $item->discount,
                                    2
                                ) }}

                            </td>


                            <td class="text-end">

                                {{ number_format(
                                    (float) $item->tax,
                                    2
                                ) }}

                            </td>


                            <td class="text-end fw-semibold">

                                {{ number_format(
                                    (float) $item->total,
                                    2
                                ) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center"
                            >

                                No items available.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- ==========================================================
            Bottom Section
        =========================================================== --}}

        <div class="invoice-print-bottom">

            {{-- Payment --}}

            <div>

                <div class="invoice-print-section-label mb-2">
                    PAYMENT
                </div>


                <div class="invoice-print-payment-row">

                    <span>
                        Payment Status
                    </span>

                    <strong>
                        {{ $invoice->payment_status ?? 'Pending' }}
                    </strong>

                </div>


                <div class="invoice-print-payment-row">

                    <span>
                        Amount Paid
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $invoice->amount_paid,
                            2
                        ) }}
                    </strong>

                </div>


                <div class="invoice-print-payment-row">

                    <span>
                        Balance
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $invoice->balance,
                            2
                        ) }}
                    </strong>

                </div>

            </div>


            {{-- Summary --}}

            <div class="invoice-print-summary">

                <div class="invoice-print-summary-row">

                    <span>
                        Subtotal
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $invoice->subtotal,
                            2
                        ) }}
                    </strong>

                </div>


                <div class="invoice-print-summary-row">

                    <span>
                        Discount
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $invoice->discount,
                            2
                        ) }}
                    </strong>

                </div>


                <div class="invoice-print-summary-row">

                    <span>
                        Tax
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $invoice->tax,
                            2
                        ) }}
                    </strong>

                </div>


                <div class="invoice-print-summary-total">

                    <span>
                        Grand Total
                    </span>

                    <strong>
                        {{ number_format(
                            (float) $invoice->grand_total,
                            2
                        ) }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ==========================================================
            Remarks
        =========================================================== --}}

        @if ($invoice->remarks)

            <div class="invoice-print-remarks">

                <div class="invoice-print-section-label">
                    REMARKS
                </div>


                <div>
                    {{ $invoice->remarks }}
                </div>

            </div>

        @endif


        {{-- ==========================================================
            Footer
        =========================================================== --}}

        <div class="invoice-print-footer">

            <div>
                Thank you for your business.
            </div>


            <div>
                {{ $invoice->invoice_no }}
            </div>

        </div>

    </div>

</div>


<style>

.invoice-print-wrapper {
    padding: 24px;
}


.invoice-print-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}


.invoice-print-document {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}


.invoice-print-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 30px;
    padding-bottom: 28px;
    border-bottom: 2px solid #111827;
}


.invoice-print-company-name {
    font-size: 22px;
    font-weight: 700;
}


.invoice-print-company-details {
    margin-top: 8px;
    color: #6b7280;
    font-size: 13px;
    line-height: 1.6;
}


.invoice-print-title {
    text-align: right;
}


.invoice-print-title-label {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: .08em;
}


.invoice-print-number {
    margin-top: 4px;
    font-weight: 600;
}


.invoice-print-date {
    margin-top: 4px;
    color: #6b7280;
    font-size: 13px;
}


.invoice-print-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    padding: 28px 0;
}


.invoice-print-section-label {
    margin-bottom: 6px;
    color: #6b7280;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
}


.invoice-print-value {
    font-weight: 600;
}


.invoice-print-muted {
    color: #6b7280;
    font-size: 12px;
    margin-top: 3px;
}


.invoice-print-items {
    margin-top: 4px;
}


.invoice-print-items table {
    width: 100%;
    border-collapse: collapse;
}


.invoice-print-items th {
    padding: 10px 8px;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
}


.invoice-print-items td {
    padding: 12px 8px;
    border-bottom: 1px solid #e9ecef;
    font-size: 13px;
}


.invoice-print-bottom {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 50px;
    margin-top: 30px;
}


.invoice-print-payment-row,
.invoice-print-summary-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    padding: 7px 0;
    font-size: 13px;
}


.invoice-print-summary {
    border-top: 1px solid #dee2e6;
}


.invoice-print-summary-total {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    padding: 14px 0;
    border-top: 2px solid #111827;
    font-size: 17px;
    font-weight: 700;
}


.invoice-print-remarks {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #dee2e6;
    font-size: 13px;
}


.invoice-print-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 40px;
    padding-top: 16px;
    border-top: 1px solid #dee2e6;
    color: #6b7280;
    font-size: 11px;
}


/*
|--------------------------------------------------------------------------
| Print
|--------------------------------------------------------------------------
*/

@media print {

    /*
    |--------------------------------------------------------------------------
    | Hide Application Shell
    |--------------------------------------------------------------------------
    */

    body > * {
        visibility: hidden !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Show Only Invoice Wrapper
    |--------------------------------------------------------------------------
    */

    .invoice-print-wrapper,
    .invoice-print-wrapper * {
        visibility: visible !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Position Invoice At Print Origin
    |--------------------------------------------------------------------------
    */

    .invoice-print-wrapper {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Hide Toolbar
    |--------------------------------------------------------------------------
    */

    .invoice-print-toolbar {
        display: none !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Invoice Document
    |--------------------------------------------------------------------------
    */

    .invoice-print-document {
        width: 100% !important;
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }


    /*
    |--------------------------------------------------------------------------
    | Page
    |--------------------------------------------------------------------------
    */

    @page {
        margin: 12mm;
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Bad Page Breaks
    |--------------------------------------------------------------------------
    */

    .invoice-print-items {
        break-inside: auto;
    }


    .invoice-print-items tr {
        break-inside: avoid;
        page-break-inside: avoid;
    }


    .invoice-print-bottom {
        break-inside: avoid;
        page-break-inside: avoid;
    }


    .invoice-print-remarks {
        break-inside: avoid;
        page-break-inside: avoid;
    }


    .invoice-print-footer {
        break-inside: avoid;
        page-break-inside: avoid;
    }

}

</style>


<!-- <script>

document.addEventListener(
    'DOMContentLoaded',
    () => {

        setTimeout(
            () => {

                window.print();

            },
            300
        );

    }
);

</script> -->

@endsection