<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'company_archives',
            function (Blueprint $table) {

                $table->id();

                /*
                 * Deliberately NOT a foreign key.
                 *
                 * After a company is eventually purged,
                 * this archive record must survive.
                 */
                $table->unsignedBigInteger(
                    'original_company_id'
                )->index();

                $table->string(
                    'company_name'
                );

                $table->string(
                    'company_code'
                )->nullable();

                $table->string(
                    'status',
                    40
                )
                ->default('Pending')
                ->index();

                $table->string(
                    'archive_format',
                    20
                )
                ->default('zip-json');

                $table->string(
                    'storage_disk'
                );

                $table->text(
                    'storage_path'
                )->nullable();

                $table->unsignedBigInteger(
                    'archive_size'
                )->nullable();

                $table->string(
                    'checksum',
                    128
                )->nullable();

                $table->json(
                    'manifest'
                )->nullable();

                $table->json(
                    'verification'
                )->nullable();

                $table->text(
                    'error_message'
                )->nullable();

                $table->timestamp(
                    'requested_at'
                )->nullable();

                $table->timestamp(
                    'started_at'
                )->nullable();

                $table->timestamp(
                    'completed_at'
                )->nullable();

                $table->timestamp(
                    'verified_at'
                )->nullable();

                $table->timestamp(
                    'purged_at'
                )->nullable();

                $table->foreignId(
                    'requested_by'
                )
                ->nullable()
                ->constrained(
                    'platform_admins'
                )
                ->nullOnDelete();

                $table->timestamps();

            }
        );
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'company_archives'
        );
    }
};