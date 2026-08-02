<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {

        $paymentMethods = [

            [
                'name' => 'Cash',
                'code' => 'CASH',
                'icon' => 'bi-cash',
                'color' => 'success',
                'requires_reference' => false,
                'is_cash' => true,
                'allow_change' => true,
                'display_order' => 1,
            ],

            [
                'name' => 'POS',
                'code' => 'POS',
                'icon' => 'bi-credit-card',
                'color' => 'primary',
                'requires_reference' => true,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 2,
            ],

            [
                'name' => 'Transfer',
                'code' => 'TRANSFER',
                'icon' => 'bi-bank',
                'color' => 'info',
                'requires_reference' => true,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 3,
            ],

            [
                'name' => 'Wallet',
                'code' => 'WALLET',
                'icon' => 'bi-wallet2',
                'color' => 'warning',
                'requires_reference' => false,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 4,
            ],

            [
                'name' => 'Credit',
                'code' => 'CREDIT',
                'icon' => 'bi-person-lines-fill',
                'color' => 'secondary',
                'requires_reference' => false,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 5,
            ],

            [
                'name' => 'Cheque',
                'code' => 'CHEQUE',
                'icon' => 'bi-receipt',
                'color' => 'dark',
                'requires_reference' => true,
                'is_cash' => false,
                'allow_change' => false,
                'display_order' => 6,
            ],

        ];


        Company::each(function ($company) use ($paymentMethods) {


            foreach ($paymentMethods as $method) {


                PaymentMethod::updateOrCreate(

                    [
                        'company_id' => $company->id,

                        'code' => $method['code'],
                    ],

                    [

                        ...$method,

                        'status' => true,

                    ]

                );

            }


        });

    }
}