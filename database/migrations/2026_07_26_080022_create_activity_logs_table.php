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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

             $table->foreignId('company_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->foreignId('branch_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();        
           
            $table->string('module');

            $table->string('action');

            $table->text('description');

            $table->string('url')->nullable();

            $table->string('method')->nullable();

            $table->text('user_agent')->nullable();

            $table->foreignId('terminal_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

            $table->ipAddress('ip_address')->nullable();

            $table->string('browser')->nullable();

            $table->string('platform')->nullable();

            $table->string('device')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
