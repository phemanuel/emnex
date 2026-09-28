<?php

namespace App\Jobs;

use App\Mail\StorefrontOrderConfirmation;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendStorefrontOrderConfirmation implements ShouldQueue
{
    use Queueable;


    public int $tries = 3;


    public function __construct(
        public int $orderId
    ) {
    }


    public function handle(): void
    {
        $order =
            Order::query()
                ->with([
                    'company',
                    'customer',
                    'orderItems',
                    'payments',
                    'invoice',
                ])
                ->find(
                    $this->orderId
                );


        if (
            !$order ||
            $order->sales_channel !== 'Online' ||
            $order->payment_status !== 'Paid'
        ) {

            return;
        }


        if (
            $order->confirmation_email_sent_at
        ) {

            return;
        }


        if (
            !$order->customer ||
            !$order->customer->email
        ) {

            return;
        }


        Mail::to(
            $order->customer->email
        )->send(
            new StorefrontOrderConfirmation(
                $order
            )
        );


        $order->forceFill([
            'confirmation_email_sent_at' =>
                now(),
        ])->save();
    }


    public function failed(
        ?Throwable $exception
    ): void {

        report(
            $exception
        );

    }
}