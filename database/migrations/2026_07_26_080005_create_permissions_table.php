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
        Schema::create('permissions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('module');

            $table->string('name');

            $table->string('display_name');

            $table->text('description')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->softDeletes();

            $table->unique(['company_id','name']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
