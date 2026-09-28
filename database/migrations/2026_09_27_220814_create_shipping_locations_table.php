<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_locations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('description')
                ->nullable();

            $table->decimal(
                'shipping_fee',
                15,
                2
            )->default(0);

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('status')
                ->default(true);

            $table->unsignedBigInteger('created_by')
                ->nullable();

            $table->unsignedBigInteger('updated_by')
                ->nullable();

            $table->timestamps();

            $table->index([
                'company_id',
                'status',
            ]);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('shipping_locations');
    }
};