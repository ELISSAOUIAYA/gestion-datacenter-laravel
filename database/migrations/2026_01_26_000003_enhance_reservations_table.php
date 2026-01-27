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
        Schema::table('reservations', function (Blueprint $table) {
            // Ajouter colonne pour la justification de la demande
            $table->text('justification')->nullable();
            // Ajouter colonne pour tracker les changements de statut
            $table->enum('status', ['EN ATTENTE', 'VALIDÉE', 'REFUSÉE'])->default('EN ATTENTE')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('justification');
        });
    }
};
