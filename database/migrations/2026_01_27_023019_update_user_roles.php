<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer les IDs des rôles
        $normalRoleId = DB::table('roles')->where('name', 'Utilisateur Normal')->value('id');
        $interneRoleId = DB::table('roles')->where('name', 'Utilisateur Interne')->value('id');

        // Assigner le rôle "Utilisateur Normal" aux utilisateurs sans user_type
        DB::table('users')
            ->whereNull('user_type')
            ->where('role_id', $interneRoleId)
            ->update(['role_id' => $normalRoleId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to "Utilisateur Interne" role
        $normalRoleId = DB::table('roles')->where('name', 'Utilisateur Normal')->value('id');
        $interneRoleId = DB::table('roles')->where('name', 'Utilisateur Interne')->value('id');

        DB::table('users')
            ->where('role_id', $normalRoleId)
            ->whereNull('user_type')
            ->update(['role_id' => $interneRoleId]);
    }
};
