<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'data_lifecycle_settings',
            function (Blueprint $table) {

                $table->id();

                $table->boolean('enabled')
                    ->default(true);

                $table->unsignedInteger('inactivity_days')
                    ->default(540);

                $table->unsignedInteger('grace_period_days')
                    ->default(30);

                $table->json('warning_days')
                    ->nullable();

                $table->boolean('automatic_scheduling')
                    ->default(false);

                $table->boolean('automatic_purge')
                    ->default(false);

                $table->string('archive_disk')
                    ->default('local');

                $table->string('archive_directory')
                    ->default('company-archives');

                $table->unsignedInteger('archive_retention_days')
                    ->nullable();

                $table->foreignId('updated_by')
                    ->nullable()
                    ->constrained('platform_admins')
                    ->nullOnDelete();

                $table->timestamps();

            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'data_lifecycle_settings'
        );
    }
};