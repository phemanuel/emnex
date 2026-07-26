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
        Schema::create('document_sequences', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();

            // Document Type
            $table->string('document_type');

            // Number Format
            $table->string('prefix');
            $table->string('suffix')->nullable();
            $table->string('separator', 5)->default('-');

            // Sequence
            $table->unsignedBigInteger('current_number')->default(1);
            $table->unsignedInteger('number_length')->default(6);

            // Reset Policy
            $table->enum('reset_frequency', [
                'Never',
                'Daily',
                'Monthly',
                'Yearly',
            ])->default('Never');           

            // Status
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->unique([
                'company_id',
                'document_type'
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_sequences');
    }
};
