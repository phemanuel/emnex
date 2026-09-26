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
        Schema::create('sync_devices', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Company / Location
            |--------------------------------------------------------------------------
            */

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            $table->foreignId('terminal_id')
                ->nullable()
                ->constrained('terminals')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Device Identity
            |--------------------------------------------------------------------------
            |
            | This UUID identifies the EMNEX installation/device across databases.
            | It must never be regenerated during normal operation.
            |
            */

            $table->uuid('device_uuid')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Device Information
            |--------------------------------------------------------------------------
            */

            $table->string('device_name')
                ->nullable();

            $table->string('device_type')
                ->default('local');

            $table->string('app_version')
                ->nullable();

            $table->string('database_version')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            |
            | The raw sync token is never stored.
            | Only its hash is persisted.
            |
            */

            $table->string('sync_token_hash')
                ->nullable();

            $table->timestamp('token_created_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            $table->timestamp('last_seen_at')
                ->nullable();

            $table->timestamp('last_sync_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'company_id',
                'branch_id',
            ]);

            $table->index([
                'company_id',
                'is_active',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_devices');
    }
};

