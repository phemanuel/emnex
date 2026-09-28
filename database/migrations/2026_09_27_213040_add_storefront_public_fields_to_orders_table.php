<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string(
                'public_token',
                64
            )
                ->nullable()
                ->unique()
                ->after('order_no');

            $table->timestamp(
                'confirmation_email_sent_at'
            )
                ->nullable()
                ->after('completed_at');

        });
    }


    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropUnique([
                'public_token'
            ]);

            $table->dropColumn([
                'public_token',
                'confirmation_email_sent_at',
            ]);

        });
    }
};