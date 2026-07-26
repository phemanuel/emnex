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
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
            ->unique()
            ->constrained()
            ->cascadeOnDelete();

            // Company Information
            $table->string('company_name');
            $table->string('company_email')->nullable();
            $table->string('company_phone')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_logo')->nullable();

            // Business Information
            $table->string('currency', 10)->default('NGN');
            $table->string('currency_symbol', 10)->default('₦');
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->boolean('tax_enabled')->default(false);

            // Receipt Settings
            $table->string('receipt_footer')->nullable();
            $table->boolean('print_logo')->default(true);
            $table->boolean('print_barcode')->default(false);

            $table->boolean('allow_negative_stock')
            ->default(false);

            $table->boolean('allow_price_change')
                ->default(false);

            $table->boolean('enable_discounts')
                ->default(true);

            $table->boolean('enable_customer_credit')
                ->default(false);

            $table->string('default_customer')
                ->nullable();

            // System
            $table->string('timezone')->default('Africa/Lagos');
            $table->boolean('maintenance_mode')->default(false);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
