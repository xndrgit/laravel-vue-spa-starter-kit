<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'pending_email')) {
                $table->string('pending_email')->nullable()->unique()->after('email_verified_at');
            }

            if (! Schema::hasColumn('users', 'pending_email_token')) {
                $table->string('pending_email_token')->nullable()->after('pending_email');
            }

            if (! Schema::hasColumn('users', 'pending_email_requested_at')) {
                $table->timestamp('pending_email_requested_at')->nullable()->after('pending_email_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'pending_email')) {
                $table->dropUnique(['pending_email']);
            }

            $table->dropColumn([
                'pending_email',
                'pending_email_token',
                'pending_email_requested_at',
            ]);
        });
    }
};
