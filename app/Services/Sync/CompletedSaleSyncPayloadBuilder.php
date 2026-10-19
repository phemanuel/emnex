<?php

namespace App\Services\Sync;

use App\Models\Branch;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Terminal;
use DateTimeInterface;
use RuntimeException;

class CompletedSaleSyncPayloadBuilder
{
    public function build(Order $order): array
    {
        if ($order->order_status !== 'Completed') {
            throw new RuntimeException(
                "Order [{$order->id}] is not completed and cannot be synchronized as a completed sale."
            );
        }

        if (empty($order->sync_uuid)) {
            throw new RuntimeException(
                "Order [{$order->id}] does not have a sync UUID."
            );
        }

        if ($order->customer_id !== null) {
            throw new RuntimeException(
                "Order [{$order->id}] has a customer. Customer synchronization must be implemented before this sale can be synchronized."
            );
        }

        $branchSyncUuid = $this->branchSyncUuid(
            $order->company_id,
            $order->branch_id
        );

        $terminalSyncUuid = $this->terminalSyncUuid(
            $order->company_id,
            $order->terminal_id
        );

        $orderItems = OrderItem::query()
            ->where('company_id', $order->company_id)
            ->where('order_id', $order->id)
            ->orderBy('id')
            ->get();

        if ($orderItems->isEmpty()) {
            throw new RuntimeException(
                "Order [{$order->id}] does not have any order items."
            );
        }

        $invoice = Invoice::withTrashed()
            ->where('company_id', $order->company_id)
            ->where('order_id', $order->id)
            ->first();

        if (! $invoice) {
            throw new RuntimeException(
                "Order [{$order->id}] does not have an invoice."
            );
        }

        $invoiceItems = InvoiceItem::query()
            ->where('company_id', $order->company_id)
            ->where('invoice_id', $invoice->id)
            ->orderBy('id')
            ->get();

        $payments = Payment::query()
            ->where('company_id', $order->company_id)
            ->where('order_id', $order->id)
            ->orderBy('id')
            ->get();

        if ($payments->isEmpty()) {
            throw new RuntimeException(
                "Order [{$order->id}] does not have any payments."
            );
        }

        return [
            'branch_sync_uuid' => $branchSyncUuid,

            'terminal_sync_uuid' => $terminalSyncUuid,

            'order' => [
                'order_no' => $order->order_no,

                'subtotal' => $order->subtotal,
                'discount' => $order->discount,
                'tax' => $order->tax,
                'total' => $order->total,

                'amount_paid' => $order->amount_paid,
                'balance' => $order->balance,

                'total_items' => $order->total_items,
                'total_quantity' => $order->total_quantity,

                'change_given' => $order->change_given,
                'grand_total' => $order->grand_total,

                'completed_at' => $this->dateTime(
                    $order->completed_at
                ),

                'payment_status' => $order->payment_status,
                'order_status' => $order->order_status,
                'sales_channel' => $order->sales_channel,

                'receipt_printed' => (bool) $order->receipt_printed,

                'remarks' => $order->remarks,

                'shipping_method' => $order->shipping_method,
                'shipping_location_name' => $order->shipping_location_name,
                'shipping_address' => $order->shipping_address,
                'shipping_city' => $order->shipping_city,
                'shipping_state' => $order->shipping_state,
                'shipping_fee' => $order->shipping_fee,

                'fulfilment_status' => $order->fulfilment_status,
                'tracking_reference' => $order->tracking_reference,
                'shipping_notes' => $order->shipping_notes,

                'shipped_at' => $this->dateTime(
                    $order->shipped_at
                ),

                'delivered_at' => $this->dateTime(
                    $order->delivered_at
                ),
            ],

            'items' => $orderItems
                ->map(function (OrderItem $item) use ($order) {
                    return [
                        'product_sync_uuid' =>
                            $this->productSyncUuid(
                                $order->company_id,
                                $item->product_id
                            ),

                        'product_name' => $item->product_name,
                        'product_barcode' => $item->product_barcode,

                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'unit_cost' => $item->unit_cost,

                        'discount' => $item->discount,
                        'tax' => $item->tax,
                        'total' => $item->total,
                    ];
                })
                ->values()
                ->all(),

            'invoice' => [
                'branch_sync_uuid' =>
                    $this->branchSyncUuid(
                        $order->company_id,
                        $invoice->branch_id
                    ),

                'terminal_sync_uuid' =>
                    $this->terminalSyncUuid(
                        $order->company_id,
                        $invoice->terminal_id
                    ),

                'invoice_no' => $invoice->invoice_no,

                'invoice_date' => $this->date(
                    $invoice->invoice_date
                ),

                'subtotal' => $invoice->subtotal,
                'discount' => $invoice->discount,
                'tax' => $invoice->tax,
                'total' => $invoice->total,

                'amount_paid' => $invoice->amount_paid,
                'balance' => $invoice->balance,

                'total_quantity' => $invoice->total_quantity,
                'total_items' => $invoice->total_items,

                'grand_total' => $invoice->grand_total,

                'payment_status' => $invoice->payment_status,
                'invoice_status' => $invoice->invoice_status,

                'remarks' => $invoice->remarks,

                'items' => $invoiceItems
                    ->map(function (InvoiceItem $item) use ($order) {
                        return [
                            'product_sync_uuid' =>
                                $this->productSyncUuid(
                                    $order->company_id,
                                    $item->product_id
                                ),

                            'product_name' => $item->product_name,
                            'product_barcode' => $item->product_barcode,

                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,

                            'discount' => $item->discount,
                            'tax' => $item->tax,
                            'total' => $item->total,
                        ];
                    })
                    ->values()
                    ->all(),
            ],

            'payments' => $payments
                ->map(function (Payment $payment) use ($order) {
                    $paymentMethod =
                        PaymentMethod::withTrashed()
                            ->where(
                                'company_id',
                                $order->company_id
                            )
                            ->whereKey(
                                $payment->payment_method_id
                            )
                            ->first();

                    if (! $paymentMethod) {
                        throw new RuntimeException(
                            "Payment [{$payment->id}] has an invalid payment method."
                        );
                    }

                    return [
                        'branch_sync_uuid' =>
                            $this->branchSyncUuid(
                                $order->company_id,
                                $payment->branch_id
                            ),

                        'terminal_sync_uuid' =>
                            $this->terminalSyncUuid(
                                $order->company_id,
                                $payment->terminal_id
                            ),

                        'payment_number' =>
                            $payment->payment_number,

                        'payment_method_code' =>
                            $paymentMethod->code,

                        'payment_method' =>
                            $payment->payment_method,

                        'amount' =>
                            $payment->amount,

                        'payment_status' =>
                            $payment->payment_status,

                        'payment_date' =>
                            $this->dateTime(
                                $payment->payment_date
                            ),

                        'transaction_reference' =>
                            $payment->transaction_reference,

                        'payment_gateway' =>
                            $payment->payment_gateway,

                        'reference_no' =>
                            $payment->reference_no,

                        'remarks' =>
                            $payment->remarks,
                    ];
                })
                ->values()
                ->all(),
        ];
    }

    protected function branchSyncUuid(
        int $companyId,
        ?int $branchId
    ): ?string {
        if ($branchId === null) {
            return null;
        }

        $branch = Branch::withTrashed()
            ->where('company_id', $companyId)
            ->whereKey($branchId)
            ->first();

        if (! $branch || empty($branch->sync_uuid)) {
            throw new RuntimeException(
                "Branch [{$branchId}] does not have a valid sync UUID."
            );
        }

        return $branch->sync_uuid;
    }

    protected function terminalSyncUuid(
        int $companyId,
        ?int $terminalId
    ): ?string {
        if ($terminalId === null) {
            return null;
        }

        $terminal = Terminal::withTrashed()
            ->where('company_id', $companyId)
            ->whereKey($terminalId)
            ->first();

        if (! $terminal || empty($terminal->sync_uuid)) {
            throw new RuntimeException(
                "Terminal [{$terminalId}] does not have a valid sync UUID."
            );
        }

        return $terminal->sync_uuid;
    }

    protected function productSyncUuid(
        int $companyId,
        int $productId
    ): string {
        $product = Product::withTrashed()
            ->where('company_id', $companyId)
            ->whereKey($productId)
            ->first();

        if (! $product || empty($product->sync_uuid)) {
            throw new RuntimeException(
                "Product [{$productId}] does not have a valid sync UUID."
            );
        }

        return $product->sync_uuid;
    }

    protected function dateTime(
        mixed $value
    ): ?string {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        return (string) $value;
    }

    protected function date(
        mixed $value
    ): ?string {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        return (string) $value;
    }
}