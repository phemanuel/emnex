<?php

namespace App\Services\Sync\Handlers;

use App\Contracts\Sync\SyncHandler;
use App\Models\Branch;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\SyncDevice;
use App\Models\Terminal;
use App\Services\DocumentNumberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RuntimeException;

class CompletedSaleSyncHandler implements SyncHandler
{
    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {
        $this->validatePayload($payload);

        return DB::transaction(
            function () use (
                $syncUuid,
                $payload,
                $device
            ) {
                $companyId =
                    (int) $device->company_id;

                $order =
                    Order::withTrashed()
                        ->where(
                            'company_id',
                            $companyId
                        )
                        ->where(
                            'sync_uuid',
                            $syncUuid
                        )
                        ->first();

                $action =
                    'created';

                if ($order) {
                    $action =
                        $order->trashed()
                            ? 'restored'
                            : 'updated';

                    if ($order->trashed()) {
                        $order->restore();
                    }
                }

                return $this->persistSnapshot(
                    $syncUuid,
                    $payload,
                    $companyId,
                    $order,
                    $action
                );
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {
        $this->validatePayload($payload);

        return DB::transaction(
            function () use (
                $syncUuid,
                $payload,
                $device
            ) {
                $companyId =
                    (int) $device->company_id;

                $order =
                    Order::withTrashed()
                        ->where(
                            'company_id',
                            $companyId
                        )
                        ->where(
                            'sync_uuid',
                            $syncUuid
                        )
                        ->first();

                if (! $order) {
                    throw new RuntimeException(
                        "Sale [{$syncUuid}] does not exist for this company."
                    );
                }

                if ($order->trashed()) {
                    throw new RuntimeException(
                        "Sale [{$syncUuid}] is deleted and cannot be updated."
                    );
                }

                return $this->persistSnapshot(
                    $syncUuid,
                    $payload,
                    $companyId,
                    $order,
                    'updated'
                );
            }
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete(
        string $syncUuid,
        array $payload,
        SyncDevice $device
    ): array {
        throw new RuntimeException(
            "Completed sale [{$syncUuid}] cannot be deleted through synchronization."
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Persist Snapshot
    |--------------------------------------------------------------------------
    */

    protected function persistSnapshot(
        string $syncUuid,
        array $payload,
        int $companyId,
        ?Order $order,
        string $action
    ): array {
        /*
        |--------------------------------------------------------------------------
        | Resolve Order Relationships
        |--------------------------------------------------------------------------
        */

        $branch =
            $this->resolveBranch(
                $companyId,
                $payload['branch_sync_uuid']
            );

        $terminal =
            $this->resolveTerminal(
                $companyId,
                $payload['terminal_sync_uuid']
                    ?? null
            );

        $orderPayload =
            $payload['order'];

        $sourceOrderNo =
            trim(
                $orderPayload['order_no']
            );

        /*
        |--------------------------------------------------------------------------
        | Order Number
        |--------------------------------------------------------------------------
        |
        | Existing synced Orders retain their Central document number.
        |
        | New Orders preserve the source number when it is free.
        | If Central already owns that number, a Central number is generated.
        |
        */

        $orderNo =
            $order
                ? $order->order_no
                : $this->resolveOrderNumber(
                    $companyId,
                    $sourceOrderNo
                );

        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        if (! $order) {
            $order =
                new Order();

            $order->sync_uuid =
                $syncUuid;
        }

        $order->forceFill([
            'company_id' =>
                $companyId,

            'branch_id' =>
                $branch->id,

            'terminal_id' =>
                $terminal?->id,

            'customer_id' =>
                null,

            'cashier_id' =>
                null,

            'order_no' =>
                $orderNo,

            'source_order_no' =>
                $sourceOrderNo,

            'subtotal' =>
                $orderPayload['subtotal'],

            'discount' =>
                $orderPayload['discount'],

            'discount_id' =>
                null,

            'tax_rate_id' =>
                null,

            'tax' =>
                $orderPayload['tax'],

            'total' =>
                $orderPayload['total'],

            'amount_paid' =>
                $orderPayload['amount_paid'],

            'balance' =>
                $orderPayload['balance'],

            'total_items' =>
                $orderPayload['total_items'],

            'total_quantity' =>
                $orderPayload['total_quantity'],

            'change_given' =>
                $orderPayload['change_given'],

            'grand_total' =>
                $orderPayload['grand_total'],

            'completed_at' =>
                $orderPayload['completed_at'],

            'payment_status' =>
                $orderPayload['payment_status'],

            'order_status' =>
                $orderPayload['order_status'],

            'sales_channel' =>
                $orderPayload['sales_channel'],

            'receipt_printed' =>
                $orderPayload['receipt_printed'],

            'remarks' =>
                $orderPayload['remarks']
                    ?? null,

            'created_by' =>
                null,

            'updated_by' =>
                null,

            'shipping_method' =>
                $orderPayload['shipping_method']
                    ?? null,

            'shipping_location_id' =>
                null,

            'shipping_location_name' =>
                $orderPayload['shipping_location_name']
                    ?? null,

            'shipping_address' =>
                $orderPayload['shipping_address']
                    ?? null,

            'shipping_city' =>
                $orderPayload['shipping_city']
                    ?? null,

            'shipping_state' =>
                $orderPayload['shipping_state']
                    ?? null,

            'shipping_fee' =>
                $orderPayload['shipping_fee']
                    ?? 0,

            'fulfilment_status' =>
                $orderPayload['fulfilment_status']
                    ?? null,

            'tracking_reference' =>
                $orderPayload['tracking_reference']
                    ?? null,

            'shipping_notes' =>
                $orderPayload['shipping_notes']
                    ?? null,

            'shipped_at' =>
                $orderPayload['shipped_at']
                    ?? null,

            'delivered_at' =>
                $orderPayload['delivered_at']
                    ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Never Allow Payload To Replace Sync Identity
        |--------------------------------------------------------------------------
        */

        $order->sync_uuid =
            $syncUuid;

        $order->save();

        /*
        |--------------------------------------------------------------------------
        | Order Items
        |--------------------------------------------------------------------------
        |
        | The Order is the aggregate sync identity.
        | Child snapshots are rebuilt from the authoritative source snapshot.
        |
        */

        OrderItem::query()
            ->where(
                'company_id',
                $companyId
            )
            ->where(
                'order_id',
                $order->id
            )
            ->delete();

        foreach (
            $payload['items']
            as $itemPayload
        ) {
            $product =
                $this->resolveProduct(
                    $companyId,
                    $itemPayload['product_sync_uuid']
                );

            $item =
                new OrderItem();

            $item->forceFill([
                'company_id' =>
                    $companyId,

                'order_id' =>
                    $order->id,

                'product_id' =>
                    $product->id,

                'product_name' =>
                    $itemPayload['product_name'],

                'product_barcode' =>
                    $itemPayload['product_barcode']
                        ?? null,

                'quantity' =>
                    $itemPayload['quantity'],

                'unit_price' =>
                    $itemPayload['unit_price'],

                'unit_cost' =>
                    $itemPayload['unit_cost'],

                'discount' =>
                    $itemPayload['discount'],

                'tax' =>
                    $itemPayload['tax'],

                'total' =>
                    $itemPayload['total'],
            ]);

            $item->save();
        }

        /*
        |--------------------------------------------------------------------------
        | Invoice
        |--------------------------------------------------------------------------
        */

        $invoicePayload =
            $payload['invoice'];

        $invoice =
            Invoice::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'order_id',
                    $order->id
                )
                ->first();

        if (
            $invoice
            && $invoice->trashed()
        ) {
            $invoice->restore();
        }

        $invoiceBranch =
            $this->resolveBranch(
                $companyId,
                $invoicePayload['branch_sync_uuid']
            );

        $invoiceTerminal =
            $this->resolveTerminal(
                $companyId,
                $invoicePayload['terminal_sync_uuid']
                    ?? null
            );

        $sourceInvoiceNo =
            trim(
                $invoicePayload['invoice_no']
            );

        $invoiceNo =
            $invoice
                ? $invoice->invoice_no
                : $this->resolveInvoiceNumber(
                    $companyId,
                    $sourceInvoiceNo
                );

        if (! $invoice) {
            $invoice =
                new Invoice();
        }

        $invoice->forceFill([
            'company_id' =>
                $companyId,

            'branch_id' =>
                $invoiceBranch->id,

            'terminal_id' =>
                $invoiceTerminal?->id,

            'order_id' =>
                $order->id,

            'customer_id' =>
                null,

            'invoice_no' =>
                $invoiceNo,

            'source_invoice_no' =>
                $sourceInvoiceNo,

            'invoice_date' =>
                $invoicePayload['invoice_date'],

            'subtotal' =>
                $invoicePayload['subtotal'],

            'discount' =>
                $invoicePayload['discount'],

            'tax' =>
                $invoicePayload['tax'],

            'total' =>
                $invoicePayload['total'],

            'amount_paid' =>
                $invoicePayload['amount_paid'],

            'balance' =>
                $invoicePayload['balance'],

            'total_quantity' =>
                $invoicePayload['total_quantity'],

            'total_items' =>
                $invoicePayload['total_items'],

            'grand_total' =>
                $invoicePayload['grand_total'],

            'payment_status' =>
                $invoicePayload['payment_status'],

            'invoice_status' =>
                $invoicePayload['invoice_status'],

            'remarks' =>
                $invoicePayload['remarks']
                    ?? null,

            'created_by' =>
                null,

            'updated_by' =>
                null,
        ]);

        $invoice->save();

        /*
        |--------------------------------------------------------------------------
        | Invoice Items
        |--------------------------------------------------------------------------
        */

        InvoiceItem::query()
            ->where(
                'company_id',
                $companyId
            )
            ->where(
                'invoice_id',
                $invoice->id
            )
            ->delete();

        foreach (
            $invoicePayload['items']
            as $itemPayload
        ) {
            $product =
                $this->resolveProduct(
                    $companyId,
                    $itemPayload['product_sync_uuid']
                );

            $invoiceItem =
                new InvoiceItem();

            $invoiceItem->forceFill([
                'company_id' =>
                    $companyId,

                'invoice_id' =>
                    $invoice->id,

                'product_id' =>
                    $product->id,

                'product_name' =>
                    $itemPayload['product_name'],

                'product_barcode' =>
                    $itemPayload['product_barcode']
                        ?? null,

                'quantity' =>
                    $itemPayload['quantity'],

                'unit_price' =>
                    $itemPayload['unit_price'],

                'discount' =>
                    $itemPayload['discount'],

                'tax' =>
                    $itemPayload['tax'],

                'total' =>
                    $itemPayload['total'],
            ]);

            $invoiceItem->save();
        }

        /*
        |--------------------------------------------------------------------------
        | Preserve Existing Central Payment Numbers
        |--------------------------------------------------------------------------
        |
        | If this snapshot is resent, keep whatever Central payment number was
        | previously assigned to each source payment.
        |
        */

        $existingPaymentNumbers =
            Payment::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'order_id',
                    $order->id
                )
                ->whereNotNull(
                    'source_payment_number'
                )
                ->get([
                    'payment_number',
                    'source_payment_number',
                ])
                ->keyBy(
                    'source_payment_number'
                )
                ->map(
                    fn (Payment $payment) =>
                        $payment->payment_number
                );

        /*
        |--------------------------------------------------------------------------
        | Replace Payment Snapshot
        |--------------------------------------------------------------------------
        */

        Payment::query()
            ->where(
                'company_id',
                $companyId
            )
            ->where(
                'order_id',
                $order->id
            )
            ->delete();

        foreach (
            $payload['payments']
            as $paymentPayload
        ) {
            $paymentBranch =
                $this->resolveBranch(
                    $companyId,
                    $paymentPayload['branch_sync_uuid']
                );

            $paymentTerminal =
                $this->resolveTerminal(
                    $companyId,
                    $paymentPayload['terminal_sync_uuid']
                        ?? null
                );

            $paymentMethod =
                $this->resolvePaymentMethod(
                    $companyId,
                    $paymentPayload['payment_method_code']
                );

            $sourcePaymentNumber =
                trim(
                    $paymentPayload['payment_number']
                );

            $paymentNumber =
                $existingPaymentNumbers->get(
                    $sourcePaymentNumber
                );

            if (! $paymentNumber) {
                $paymentNumber =
                    $this->resolvePaymentNumber(
                        $companyId,
                        $sourcePaymentNumber
                    );
            }

            $payment =
                new Payment();

            $payment->forceFill([
                'company_id' =>
                    $companyId,

                'branch_id' =>
                    $paymentBranch->id,

                'order_id' =>
                    $order->id,

                'customer_id' =>
                    null,

                'terminal_id' =>
                    $paymentTerminal?->id,

                'amount' =>
                    $paymentPayload['amount'],

                'payment_status' =>
                    $paymentPayload['payment_status'],

                'payment_method_id' =>
                    $paymentMethod->id,

                /*
                |--------------------------------------------------------------------------
                | Historical Display Value
                |--------------------------------------------------------------------------
                |
                | Keep the exact payment method label recorded by the source sale.
                |
                */

                'payment_method' =>
                    $paymentPayload['payment_method'],

                'payment_date' =>
                    $paymentPayload['payment_date'],

                'transaction_reference' =>
                    $paymentPayload['transaction_reference']
                        ?? null,

                'payment_gateway' =>
                    $paymentPayload['payment_gateway']
                        ?? null,

                'reference_no' =>
                    $paymentPayload['reference_no']
                        ?? null,

                'remarks' =>
                    $paymentPayload['remarks']
                        ?? null,

                'received_by' =>
                    null,

                'payment_number' =>
                    $paymentNumber,

                'source_payment_number' =>
                    $sourcePaymentNumber,
            ]);

            $payment->save();
        }

        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        |
        | No ProductStock mutation.
        | No StockMovement creation.
        | No CashDrawer mutation.
        | No CashDrawerTransaction creation.
        |
        | This is a historical transaction snapshot only.
        |
        */

        return [
            'entity' =>
                'sale',

            'sync_uuid' =>
                $order->sync_uuid,

            'action' =>
                $action,

            'order_id' =>
                $order->id,

            'order_no' =>
                $order->order_no,

            'source_order_no' =>
                $order->source_order_no,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    protected function resolveBranch(
        int $companyId,
        string $syncUuid
    ): Branch {
        $branch =
            Branch::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (! $branch) {
            throw new RuntimeException(
                "Branch [{$syncUuid}] does not exist for this company."
            );
        }

        return $branch;
    }

    protected function resolveTerminal(
        int $companyId,
        ?string $syncUuid
    ): ?Terminal {
        if ($syncUuid === null) {
            return null;
        }

        $terminal =
            Terminal::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (! $terminal) {
            throw new RuntimeException(
                "Terminal [{$syncUuid}] does not exist for this company."
            );
        }

        return $terminal;
    }

    protected function resolveProduct(
        int $companyId,
        string $syncUuid
    ): Product {
        $product =
            Product::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'sync_uuid',
                    $syncUuid
                )
                ->first();

        if (! $product) {
            throw new RuntimeException(
                "Product [{$syncUuid}] does not exist for this company."
            );
        }

        return $product;
    }

    protected function resolvePaymentMethod(
        int $companyId,
        string $code
    ): PaymentMethod {
        $paymentMethod =
            PaymentMethod::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'code',
                    $code
                )
                ->first();

        if (! $paymentMethod) {
            throw new RuntimeException(
                "Payment method [{$code}] does not exist for this company."
            );
        }

        return $paymentMethod;
    }

    /*
    |--------------------------------------------------------------------------
    | Document Numbers
    |--------------------------------------------------------------------------
    */

    protected function resolveOrderNumber(
        int $companyId,
        string $sourceNumber
    ): string {
        $exists =
            Order::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'order_no',
                    $sourceNumber
                )
                ->exists();

        if (! $exists) {
            return $sourceNumber;
        }

        return $this->generateUniqueOrderNumber(
            $companyId
        );
    }

    protected function resolveInvoiceNumber(
        int $companyId,
        string $sourceNumber
    ): string {
        $exists =
            Invoice::withTrashed()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'invoice_no',
                    $sourceNumber
                )
                ->exists();

        if (! $exists) {
            return $sourceNumber;
        }

        return $this->generateUniqueInvoiceNumber(
            $companyId
        );
    }

    protected function resolvePaymentNumber(
        int $companyId,
        string $sourceNumber
    ): string {
        $exists =
            Payment::query()
                ->where(
                    'company_id',
                    $companyId
                )
                ->where(
                    'payment_number',
                    $sourceNumber
                )
                ->exists();

        if (! $exists) {
            return $sourceNumber;
        }

        return $this->generateUniquePaymentNumber(
            $companyId
        );
    }

    protected function generateUniqueOrderNumber(
        int $companyId
    ): string {
        for ($attempt = 1; $attempt <= 20; $attempt++) {
            $number =
                DocumentNumberService::generate(
                    'order',
                    $companyId
                );

            $exists =
                Order::withTrashed()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->where(
                        'order_no',
                        $number
                    )
                    ->exists();

            if (! $exists) {
                return $number;
            }
        }

        throw new RuntimeException(
            'Unable to generate a unique Central order number.'
        );
    }

    protected function generateUniqueInvoiceNumber(
        int $companyId
    ): string {
        for ($attempt = 1; $attempt <= 20; $attempt++) {
            $number =
                DocumentNumberService::generate(
                    'invoice',
                    $companyId
                );

            $exists =
                Invoice::withTrashed()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->where(
                        'invoice_no',
                        $number
                    )
                    ->exists();

            if (! $exists) {
                return $number;
            }
        }

        throw new RuntimeException(
            'Unable to generate a unique Central invoice number.'
        );
    }

    protected function generateUniquePaymentNumber(
        int $companyId
    ): string {
        for ($attempt = 1; $attempt <= 20; $attempt++) {
            $number =
                DocumentNumberService::generate(
                    'payment',
                    $companyId
                );

            $exists =
                Payment::query()
                    ->where(
                        'company_id',
                        $companyId
                    )
                    ->where(
                        'payment_number',
                        $number
                    )
                    ->exists();

            if (! $exists) {
                return $number;
            }
        }

        throw new RuntimeException(
            'Unable to generate a unique Central payment number.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    protected function validatePayload(
        array $payload
    ): void {
        Validator::make(
            $payload,
            [
                'branch_sync_uuid' =>
                    ['required', 'uuid'],

                'terminal_sync_uuid' =>
                    ['nullable', 'uuid'],

                /*
                |--------------------------------------------------------------------------
                | Order
                |--------------------------------------------------------------------------
                */

                'order' =>
                    ['required', 'array'],

                'order.order_no' =>
                    ['required', 'string', 'max:255'],

                'order.subtotal' =>
                    ['required', 'numeric'],

                'order.discount' =>
                    ['required', 'numeric'],

                'order.tax' =>
                    ['required', 'numeric'],

                'order.total' =>
                    ['required', 'numeric'],

                'order.amount_paid' =>
                    ['required', 'numeric'],

                'order.balance' =>
                    ['required', 'numeric'],

                'order.total_items' =>
                    ['required', 'integer', 'min:1'],

                'order.total_quantity' =>
                    ['required', 'numeric', 'gt:0'],

                'order.change_given' =>
                    ['required', 'numeric'],

                'order.grand_total' =>
                    ['required', 'numeric'],

                'order.completed_at' =>
                    ['required', 'date'],

                'order.payment_status' =>
                    ['required', 'string'],

                'order.order_status' =>
                    ['required', 'in:Completed'],

                'order.sales_channel' =>
                    ['required', 'string'],

                'order.receipt_printed' =>
                    ['required', 'boolean'],

                'order.remarks' =>
                    ['nullable', 'string'],

                'order.shipping_method' =>
                    ['nullable', 'string'],

                'order.shipping_location_name' =>
                    ['nullable', 'string'],

                'order.shipping_address' =>
                    ['nullable', 'string'],

                'order.shipping_city' =>
                    ['nullable', 'string'],

                'order.shipping_state' =>
                    ['nullable', 'string'],

                'order.shipping_fee' =>
                    ['nullable', 'numeric'],

                'order.fulfilment_status' =>
                    ['nullable', 'string'],

                'order.tracking_reference' =>
                    ['nullable', 'string'],

                'order.shipping_notes' =>
                    ['nullable', 'string'],

                'order.shipped_at' =>
                    ['nullable', 'date'],

                'order.delivered_at' =>
                    ['nullable', 'date'],

                /*
                |--------------------------------------------------------------------------
                | Order Items
                |--------------------------------------------------------------------------
                */

                'items' =>
                    ['required', 'array', 'min:1'],

                'items.*.product_sync_uuid' =>
                    ['required', 'uuid'],

                'items.*.product_name' =>
                    ['required', 'string'],

                'items.*.product_barcode' =>
                    ['nullable', 'string'],

                'items.*.quantity' =>
                    ['required', 'numeric', 'gt:0'],

                'items.*.unit_price' =>
                    ['required', 'numeric'],

                'items.*.unit_cost' =>
                    ['required', 'numeric'],

                'items.*.discount' =>
                    ['required', 'numeric'],

                'items.*.tax' =>
                    ['required', 'numeric'],

                'items.*.total' =>
                    ['required', 'numeric'],

                /*
                |--------------------------------------------------------------------------
                | Invoice
                |--------------------------------------------------------------------------
                */

                'invoice' =>
                    ['required', 'array'],

                'invoice.branch_sync_uuid' =>
                    ['required', 'uuid'],

                'invoice.terminal_sync_uuid' =>
                    ['nullable', 'uuid'],

                'invoice.invoice_no' =>
                    ['required', 'string', 'max:50'],

                'invoice.invoice_date' =>
                    ['required', 'date'],

                'invoice.subtotal' =>
                    ['required', 'numeric'],

                'invoice.discount' =>
                    ['required', 'numeric'],

                'invoice.tax' =>
                    ['required', 'numeric'],

                'invoice.total' =>
                    ['required', 'numeric'],

                'invoice.amount_paid' =>
                    ['required', 'numeric'],

                'invoice.balance' =>
                    ['required', 'numeric'],

                'invoice.total_quantity' =>
                    ['required', 'numeric'],

                'invoice.total_items' =>
                    ['required', 'integer'],

                'invoice.grand_total' =>
                    ['required', 'numeric'],

                'invoice.payment_status' =>
                    ['required', 'string'],

                'invoice.invoice_status' =>
                    ['required', 'string'],

                'invoice.remarks' =>
                    ['nullable', 'string'],

                'invoice.items' =>
                    ['required', 'array', 'min:1'],

                'invoice.items.*.product_sync_uuid' =>
                    ['required', 'uuid'],

                'invoice.items.*.product_name' =>
                    ['required', 'string'],

                'invoice.items.*.product_barcode' =>
                    ['nullable', 'string'],

                'invoice.items.*.quantity' =>
                    ['required', 'numeric', 'gt:0'],

                'invoice.items.*.unit_price' =>
                    ['required', 'numeric'],

                'invoice.items.*.discount' =>
                    ['required', 'numeric'],

                'invoice.items.*.tax' =>
                    ['required', 'numeric'],

                'invoice.items.*.total' =>
                    ['required', 'numeric'],

                /*
                |--------------------------------------------------------------------------
                | Payments
                |--------------------------------------------------------------------------
                */

                'payments' =>
                    ['required', 'array', 'min:1'],

                'payments.*.branch_sync_uuid' =>
                    ['required', 'uuid'],

                'payments.*.terminal_sync_uuid' =>
                    ['nullable', 'uuid'],

                'payments.*.payment_number' =>
                    ['required', 'string', 'max:255'],

                'payments.*.payment_method_code' =>
                    ['required', 'string'],

                'payments.*.payment_method' =>
                    ['required', 'string'],

                'payments.*.amount' =>
                    ['required', 'numeric'],

                'payments.*.payment_status' =>
                    ['required', 'string'],

                'payments.*.payment_date' =>
                    ['required', 'date'],

                'payments.*.transaction_reference' =>
                    ['nullable', 'string'],

                'payments.*.payment_gateway' =>
                    ['nullable', 'string'],

                'payments.*.reference_no' =>
                    ['nullable', 'string'],

                'payments.*.remarks' =>
                    ['nullable', 'string'],
            ]
        )->validate();
    }
}