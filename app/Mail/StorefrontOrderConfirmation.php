<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Storefront;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StorefrontOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;


    public string $orderUrl;

    public string $merchantName;

    public string $currencySymbol;
  
    public ?string $logoPath = null;


    public function __construct(
        Order $order
    ) {

    $this->order =
        $order->fresh();

        $storefront =
            Storefront::query()
                ->with('company')
                ->where(
                    'company_id',
                    $order->company_id
                )
                ->firstOrFail();


        $company =
            $storefront->company;


        /*
        |--------------------------------------------------------------------------
        | Merchant Branding
        |--------------------------------------------------------------------------
        */

        $this->merchantName =
            $company->name
            ?: $storefront->name
            ?: config('app.name');


        $this->currencySymbol =
            $company->currency_symbol
            ?: '₦';


        /*
        |--------------------------------------------------------------------------
        | Company Logo
        |--------------------------------------------------------------------------
        */

        if ($company->logo) {

            $logoPath =
                public_path(
                    'uploads/company/' .
                    $company->logo
                );


            if (file_exists($logoPath)) {

                $this->logoPath =
                    $logoPath;

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Secure Order URL
        |--------------------------------------------------------------------------
        */

        $this->orderUrl =
            route(
                'storefront.public.order.show',
                [
                    'storefrontSlug' =>
                        $storefront->slug,

                    'token' =>
                        $order->public_token,
                ]
            );
    }


    public function envelope(): Envelope
    {
        return new Envelope(

            from: new Address(
                config('mail.from.address'),
                $this->merchantName
            ),

            subject:
                'Your order ' .
                $this->order->order_no .
                ' is confirmed',

        );
    }


    public function content(): Content
    {
        $order =
            $this->order
                ->fresh()
                ->load([
                    'customer',
                    'orderItems',
                    'invoice',
                    'payments',
                ]);


        return new Content(
            view:
                'emails.storefront.order-confirmation',

            with: [
                'order' =>
                    $order,

                'orderUrl' =>
                    $this->orderUrl,

                'merchantName' =>
                    $this->merchantName,

                'currencySymbol' =>
                    $this->currencySymbol,

                'logoPath' =>
                    $this->logoPath,
            ],
        );
    }


    public function attachments(): array
    {
        return [];
    }
}