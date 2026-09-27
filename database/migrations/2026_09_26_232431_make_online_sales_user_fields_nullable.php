<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropForeign([
                'cashier_id'
            ]);

            $table->unsignedBigInteger(
                'cashier_id'
            )
            ->nullable()
            ->change();

            $table->foreign(
                'cashier_id'
            )
            ->references('id')
            ->on('users')
            ->nullOnDelete();
        });


        Schema::table('payments', function (Blueprint $table) {

            $table->dropForeign([
                'received_by'
            ]);

            $table->unsignedBigInteger(
                'received_by'
            )
            ->nullable()
            ->change();

            $table->foreign(
                'received_by'
            )
            ->references('id')
            ->on('users')
            ->nullOnDelete();
        });
    }


    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {

            $table->dropForeign([
                'received_by'
            ]);

            $table->unsignedBigInteger(
                'received_by'
            )
            ->nullable(false)
            ->change();

            $table->foreign(
                'received_by'
            )
            ->references('id')
            ->on('users')
            ->cascadeOnDelete();
        });


        Schema::table('orders', function (Blueprint $table) {

            $table->dropForeign([
                'cashier_id'
            ]);

            $table->unsignedBigInteger(
                'cashier_id'
            )
            ->nullable(false)
            ->change();

            $table->foreign(
                'cashier_id'
            )
            ->references('id')
            ->on('users')
            ->cascadeOnDelete();
        });
    }
};