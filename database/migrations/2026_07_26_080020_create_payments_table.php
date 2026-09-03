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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('terminal_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('amount',15,2);

            $table->enum('payment_method',[
                'Cash',
                'POS',
                'Transfer',
                'Wallet',
                'Credit',
                'Cheque',
                'Card'
            ]);

            $table->string('transaction_reference')
                ->nullable();

            $table->string('payment_gateway')
                ->nullable();

            $table->string('reference_no')->nullable();

            $table->text('remarks')->nullable();

            $table->foreignId('received_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
