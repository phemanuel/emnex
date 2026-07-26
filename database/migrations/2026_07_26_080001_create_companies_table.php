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
        Schema::create('companies', function (Blueprint $table) {

            $table->id();

            // Identification
            $table->string('company_code')->unique();
            $table->string('name');
            $table->string('slug')->unique();

            // Contact
            $table->string('email')->nullable();
            $table->string('phone',30)->nullable();
            $table->text('address')->nullable();

            // Branding
            $table->string('logo')->nullable();

            // Business
            $table->string('currency',10)->default('NGN');
            $table->string('currency_symbol',10)->default('₦');
            $table->string('timezone')->default('Africa/Lagos');

            $table->date('subscription_start')->nullable();
            $table->date('subscription_end')->nullable();

            $table->enum('subscription_status', [
                'Trial',
                'Active',
                'Expired',
                'Suspended'
            ])->default('Trial');

            $table->string('business_type')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('tin')->nullable();

            // Status
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
