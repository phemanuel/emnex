<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            // Localization
            $table->string('date_format')
                ->default('d-m-Y')
                ->after('timezone');

            $table->string('time_format')
                ->default('h:i A')
                ->after('date_format');


            // Receipt Settings
            $table->string('receipt_header')
                ->nullable()
                ->after('receipt_footer');

            $table->integer('receipt_width')
                ->default(80)
                ->after('receipt_header');


            // Inventory Settings
            $table->integer('low_stock_alert')
                ->default(10)
                ->after('allow_negative_stock');


            // Sales Settings
            $table->boolean('allow_price_override')
                ->default(false)
                ->after('allow_price_change');

            $table->boolean('allow_discount')
                ->default(true)
                ->after('enable_discounts');


            $table->foreignId('default_customer_id')
                ->nullable()
                ->after('default_customer')
                ->constrained('customers')
                ->nullOnDelete();


            // System
            $table->boolean('status')
                ->default(true)
                ->after('maintenance_mode');

        });
    }


    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {

            $table->dropForeign([
                'default_customer_id'
            ]);

            $table->dropColumn([

                'date_format',

                'time_format',

                'receipt_header',

                'receipt_width',

                'low_stock_alert',

                'allow_price_override',

                'allow_discount',

                'default_customer_id',

                'status',

            ]);

        });
    }
};
