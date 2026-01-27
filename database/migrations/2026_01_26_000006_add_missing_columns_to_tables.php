<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add is_active to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }
        });

        // Add is_active and tech_manager_id to resources table
        Schema::table('resources', function (Blueprint $table) {
            if (!Schema::hasColumn('resources', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('status');
            }
            if (!Schema::hasColumn('resources', 'tech_manager_id')) {
                $table->foreignId('tech_manager_id')->nullable()->constrained('users')->onDelete('set null')->after('resource_category_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });

        Schema::table('resources', function (Blueprint $table) {
            if (Schema::hasColumn('resources', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('resources', 'tech_manager_id')) {
                $table->dropForeign(['tech_manager_id']);
                $table->dropColumn('tech_manager_id');
            }
        });
    }
};
