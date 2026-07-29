<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->string('record_type')
                ->nullable()
                ->after('description');

            $table->unsignedBigInteger('record_id')
                ->nullable()
                ->after('record_type');

        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {

            $table->dropColumn([
                'record_type',
                'record_id',
            ]);

        });
    }
};
