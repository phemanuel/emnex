<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->timestamp('last_activity_at')
                ->nullable()
                ->after('status')
                ->index();

            $table->string('lifecycle_status', 40)
                ->default('Active')
                ->after('last_activity_at')
                ->index();

            $table->timestamp('archive_eligible_at')
                ->nullable()
                ->after('lifecycle_status');

            $table->timestamp('archive_scheduled_at')
                ->nullable()
                ->after('archive_eligible_at');

            $table->timestamp('archived_at')
                ->nullable()
                ->after('archive_scheduled_at');

            $table->boolean('lifecycle_locked')
                ->default(false)
                ->after('archived_at');

        });
    }


    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {

            $table->dropColumn([
                'last_activity_at',
                'lifecycle_status',
                'archive_eligible_at',
                'archive_scheduled_at',
                'archived_at',
                'lifecycle_locked',
            ]);

        });
    }
};