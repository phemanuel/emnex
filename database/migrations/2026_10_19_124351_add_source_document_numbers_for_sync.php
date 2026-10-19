<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table
                ->string('source_order_no', 255)
                ->nullable()
                ->after('order_no');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table
                ->string('source_invoice_no', 50)
                ->nullable()
                ->after('invoice_no');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table
                ->string('source_payment_number', 255)
                ->nullable()
                ->after('payment_number');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('source_payment_number');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('source_invoice_no');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('source_order_no');
        });
    }
};