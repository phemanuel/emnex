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
        Schema::create('sync_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Company / Device
            |--------------------------------------------------------------------------
            */

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('device_id')
                ->nullable()
                ->constrained('sync_devices')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Mutation
            |--------------------------------------------------------------------------
            */

            $table->uuid('mutation_uuid')
                ->nullable();

            $table->uuid('entity_sync_uuid')
                ->nullable();

            $table->string('entity')
                ->nullable();

            $table->string('operation')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Direction
            |--------------------------------------------------------------------------
            */

            $table->string('direction')
                ->default('push');

            /*
            |--------------------------------------------------------------------------
            | Result
            |--------------------------------------------------------------------------
            */

            $table->string('status');

            $table->text('message')
                ->nullable();

            $table->text('error')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timing
            |--------------------------------------------------------------------------
            */

            $table->unsignedInteger('duration_ms')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'company_id',
                'created_at',
            ]);

            $table->index([
                'device_id',
                'created_at',
            ]);

            $table->index('mutation_uuid');

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};

