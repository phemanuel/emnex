<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::first();

        if (!$company) {
            $this->command->error('Company not found. Please run CompanySeeder first.');
            return;
        }

        Setting::updateOrCreate(

            [
                'company_id' => $company->id,
            ],

            [
                // Company Information
                'company_name'      => $company->name,
                'company_email'     => $company->email,
                'company_phone'     => $company->phone,
                'company_address'   => $company->address,
                'company_logo'      => $company->logo,

                // Business Information
                'currency'          => $company->currency,
                'currency_symbol'   => $company->currency_symbol,
                'tax_rate'          => 7.50,
                'tax_enabled'       => true,

                // Receipt Settings
                'receipt_footer'    => 'Thank you for shopping with us.',
                'print_logo'        => true,
                'print_barcode'     => false,

                // Inventory
                'allow_negative_stock' => false,
                'allow_price_change'   => false,
                'enable_discounts'     => true,
                'enable_customer_credit' => false,
                'default_customer'     => 'Walk-in Customer',

                // System
                'timezone'          => $company->timezone,
                'maintenance_mode' => false,
            ]

        );
    }
}