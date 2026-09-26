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
        Schema::create('sync_queue', function (Blueprint $table) {

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
                ->constrained('sync_devices')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Mutation Identity
            |--------------------------------------------------------------------------
            |
            | mutation_uuid identifies this specific synchronization operation.
            |
            | It is deliberately different from the eventual entity sync_uuid.
            |
            */

            $table->uuid('mutation_uuid')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Entity Identity
            |--------------------------------------------------------------------------
            |
            | These remain generic because we are not attaching modules yet.
            |
            */

            $table->string('entity');

            $table->uuid('entity_sync_uuid');

            /*
            |--------------------------------------------------------------------------
            | Operation
            |--------------------------------------------------------------------------
            */

            $table->string('operation');

            /*
            |--------------------------------------------------------------------------
            | Mutation Data
            |--------------------------------------------------------------------------
            |
            | Snapshot of the information required to replay the mutation.
            |
            */

            $table->json('payload')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Processing
            |--------------------------------------------------------------------------
            */

            $table->string('status')
                ->default('pending');

            $table->unsignedInteger('attempts')
                ->default(0);

            $table->timestamp('available_at')
                ->nullable();

            $table->timestamp('processing_started_at')
                ->nullable();

            $table->timestamp('processed_at')
                ->nullable();

            $table->timestamp('failed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Error
            |--------------------------------------------------------------------------
            */

            $table->text('last_error')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'company_id',
                'status',
            ]);

            $table->index([
                'device_id',
                'status',
            ]);

            $table->index([
                'entity',
                'entity_sync_uuid',
            ]);

            $table->index([
                'status',
                'available_at',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_queue');
    }
};

