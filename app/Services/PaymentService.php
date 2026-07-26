<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentService
{
    /**
     * Record a payment against an order.
     */
    public static function makePayment(
        Order $order,
        string $paymentMethod,
        float $amount,
        ?string $reference = null,
        ?string $remarks = null
    ): Payment {

        return DB::transaction(function () use (
            $order,
            $paymentMethod,
            $amount,
            $reference,
            $remarks
        ) {

            if ($amount <= 0) {
                throw new Exception('Payment amount must be greater than zero.');
            }

            $payment = Payment::create([

                'company_id' => $order->company_id,

                'branch_id' => $order->branch_id,

                'order_id' => $order->id,

                'payment_no' => DocumentNumberService::generate('payment'),

                'payment_method' => $paymentMethod,

                'amount' => $amount,

                'reference' => $reference,

                'remarks' => $remarks,

                'received_by' => auth()->id(),

            ]);

            self::updateOrder($order);

            return $payment;

        });

    }

    /**
     * Update payment figures on the order.
     */
    protected static function updateOrder(Order $order): void
    {
        $paid = $order->payments()->sum('amount');

        $balance = max(
            0,
            $order->total - $paid
        );

        $status = 'Pending';

        if ($paid >= $order->total) {

            $status = 'Paid';

        } elseif ($paid > 0) {

            $status = 'Partial';

        }

        $order->update([

            'amount_paid' => $paid,

            'balance' => $balance,

            'payment_status' => $status,

        ]);
    }
}