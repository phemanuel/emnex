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
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('customer_code');

            $table->unique([
                'company_id',
                'customer_code'
            ]);

            $table->string('first_name');

            $table->string('last_name')->nullable();

            $table->string('email')->nullable();

            $table->string('phone',30)->nullable();

            $table->text('address')->nullable();

            $table->decimal('credit_limit',15,2)->default(0);

            $table->decimal('current_balance',15,2)->default(0);

            $table->string('customer_type')
                ->default('Walk-in');

            $table->integer('loyalty_points')
                ->default(0);

            $table->date('last_purchase_date')
                ->nullable();

            $table->boolean('status')->default(true);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
