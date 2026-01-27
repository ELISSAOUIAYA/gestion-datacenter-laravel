<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Ajouter support pour les Account Requests (Demandes d'ouverture de compte)
     */
    public function up(): void
    {
        // Créer la table pour les demandes d'ouverture de compte
        Schema::create('account_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('user_type', ['Ingénieur', 'Enseignant', 'Doctorant', 'Autre'])->default('Autre');
            $table->text('motivation')->nullable();
            $table->enum('status', ['EN ATTENTE', 'APPROUVÉE', 'REFUSÉE'])->default('EN ATTENTE');
            $table->text('admin_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_requests');
    }
};
