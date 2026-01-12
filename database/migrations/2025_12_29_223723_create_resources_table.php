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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom de la ressource
            $table->enum('type', ['Serveur', 'VM', 'Stockage', 'Réseau']); // Type demandé
        
            // Caractéristiques techniques (selon tes captures)
            $table->string('cpu')->nullable();
            $table->string('ram')->nullable();
            $table->string('bandwidth')->nullable(); // Bande passante
            $table->string('capacity')->nullable();  // Capacité stockage
            $table->string('os')->nullable();        // Système d'exploitation
            $table->string('location')->nullable();  // Emplacement
        
            $table->enum('status', ['available', 'maintenance', 'occupied'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
