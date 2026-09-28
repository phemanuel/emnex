<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_settings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete()
                ->unique();

            $table->boolean('enabled')
                ->default(false);

            $table->string('shipping_mode', 30)
                ->default('location');

            $table->decimal(
                'manual_shipping_fee',
                15,
                2
            )->default(0);

            $table->unsignedBigInteger('created_by')
                ->nullable();

            $table->unsignedBigInteger('updated_by')
                ->nullable();

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};