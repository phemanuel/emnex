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
        Schema::table('payments', function (Blueprint $table) {

            $table->foreignId('customer_id')
                ->nullable()
                ->after('order_id')
                ->constrained()
                ->nullOnDelete();

            $table->string('payment_number')
                ->unique()
                ->after('received_by');

            $table->enum('payment_status', [
                'Pending',
                'Completed',
                'Failed',
                'Cancelled',
                'Refunded',
            ])->default('Completed')
              ->after('payment_method');

            $table->dateTime('payment_date')
                ->after('payment_status');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->renameColumn('reference_number', 'reference_no');

            $table->dropForeign(['customer_id']);
            $table->dropColumn([
                'customer_id',
                'payment_number',
                'payment_status',
                'payment_date',
            ]);
        });
    }
};