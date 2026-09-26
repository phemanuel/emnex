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
        Schema::create('sync_mutations', function (Blueprint $table) {

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
            | This is the idempotency key.
            |
            */

            $table->uuid('mutation_uuid')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Entity
            |--------------------------------------------------------------------------
            */

            $table->string('entity');

            $table->uuid('entity_sync_uuid');

            $table->string('operation');

            /*
            |--------------------------------------------------------------------------
            | Request / Response
            |--------------------------------------------------------------------------
            |
            | The response is stored so a repeated request can receive
            | the same result without executing the mutation again.
            |
            */

            $table->json('payload')
                ->nullable();

            $table->json('response')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Processing
            |--------------------------------------------------------------------------
            */

            $table->string('status')
                ->default('processing');

            $table->text('error')
                ->nullable();

            $table->timestamp('processed_at')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'company_id',
                'device_id',
            ]);

            $table->index([
                'entity',
                'entity_sync_uuid',
            ]);

            $table->index([
                'device_id',
                'created_at',
            ]);

            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_mutations');
    }
};

