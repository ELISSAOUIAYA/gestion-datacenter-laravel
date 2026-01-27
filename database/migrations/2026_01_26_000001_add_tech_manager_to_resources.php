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
        Schema::table('resources', function (Blueprint $table) {
            // Ajouter une colonne pour assigner un responsable technique à une ressource
            $table->foreignId('tech_manager_id')->nullable()->constrained('users')->cascadeOnDelete();
            // Ajouter une colonne pour tracker si la ressource est désactivée
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            // Supprimer seulement si les colonnes existent
            if (Schema::hasColumn('resources', 'tech_manager_id')) {
                $table->dropForeign(['tech_manager_id']);
                $table->dropColumn('tech_manager_id');
            }
            if (Schema::hasColumn('resources', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
