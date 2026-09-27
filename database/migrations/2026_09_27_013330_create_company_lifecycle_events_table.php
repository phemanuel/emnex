<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'company_lifecycle_events',
            function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger(
                    'company_id'
                )->index();

                $table->unsignedBigInteger(
                    'archive_id'
                )->nullable()
                ->index();

                $table->string(
                    'event',
                    80
                );

                $table->string(
                    'from_status',
                    40
                )->nullable();

                $table->string(
                    'to_status',
                    40
                )->nullable();

                $table->text(
                    'description'
                )->nullable();

                $table->json(
                    'metadata'
                )->nullable();

                $table->foreignId(
                    'platform_admin_id'
                )
                ->nullable()
                ->constrained(
                    'platform_admins'
                )
                ->nullOnDelete();

                $table->timestamps();

            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'company_lifecycle_events'
        );
    }
};