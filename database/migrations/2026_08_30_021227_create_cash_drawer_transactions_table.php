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
        Schema::create('cash_drawer_transactions', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Ownership
            |--------------------------------------------------------------------------
            */

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('terminal_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Drawer
            |--------------------------------------------------------------------------
            */

            $table->foreignId('cash_drawer_id')
                ->constrained('cash_drawers')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Related Transaction
            |--------------------------------------------------------------------------
            */

            $table->foreignId('payment_id')
                ->nullable()
                ->constrained('payments')
                ->nullOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->constrained('users');

            /*
            |--------------------------------------------------------------------------
            | Transaction
            |--------------------------------------------------------------------------
            */

            $table->enum('transaction_type', [
                'Opening',
                'Sale',
                'Refund',
                'Cash In',
                'Cash Out',
                'Adjustment',
                'Closing',
            ]);

            $table->decimal('amount', 15, 2);

            $table->decimal('balance_before', 15, 2);

            $table->decimal('balance_after', 15, 2);

            /*
            |--------------------------------------------------------------------------
            | Reference
            |--------------------------------------------------------------------------
            */

            $table->string('reference_no')
                ->nullable();

            $table->text('remarks')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'cash_drawer_id',
                'transaction_type',
            ]);

            $table->index([
                'company_id',
                'branch_id',
                'terminal_id',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_drawer_transactions');
    }
};