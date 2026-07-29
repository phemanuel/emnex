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
        Schema::table('users', function (Blueprint $table) {

            $table->string('other_name')
                ->nullable()
                ->after('first_name');

            $table->text('address')
                ->nullable()
                ->after('employment_date');

            $table->text('notes')
                ->nullable()
                ->after('address');

            $table->timestamp('last_activity_at')
                ->nullable()
                ->after('last_login_at');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([

                'other_name',
                'address',
                'notes',
                'last_activity_at',

            ]);

        });
    }
};
