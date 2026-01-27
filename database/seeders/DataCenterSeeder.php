<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Support\Facades\Hash;

class DataCenterSeeder extends Seeder
{
    public function run(): void
    {
        // 0. NETTOYAGE (Évite les erreurs de clés étrangères)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        User::truncate();
        Resource::truncate();
        ResourceCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. CRÉATION DES RÔLES (Sans la colonne 'description' qui cause l'erreur)
        $adminRole = Role::create(['name' => 'Admin']);
        $techRole  = Role::create(['name' => 'Responsable Technique']);
        $userRole  = Role::create(['name' => 'Utilisateur Interne']);

        // 2. CRÉATION DES CATÉGORIES
        $catSrv = ResourceCategory::create(['name' => 'Serveur']);
        $catVM  = ResourceCategory::create(['name' => 'VM']);
        $catSto = ResourceCategory::create(['name' => 'Stockage']);
        $catNet = ResourceCategory::create(['name' => 'Réseau']);

  

        // 3. CRÉATION DES UTILISATEURS
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Responsable technique',
            'email' => 'tech@test.com',
            'password' => Hash::make('tech123'),
            'role_id' => $techRole->id,
            'status' => 'active'
        ]);

        User::create([
            'name' => 'Utilisateur Interne',
            'email' => 'user@test.com',
            'password' => Hash::make('user123'),
            'role_id' => $userRole->id,
            'user_type' => 'Ingénieur',
            'status' => 'active'
        ]);

        // 4. GÉNÉRATION DES 50 RESSOURCES (Correction de l'erreur SQL 'type')
        $models = [
           
            'VM' => ['Ubuntu Server', 'Windows Core'],
            'Stockage' => ['NetApp SAN', 'Synology NAS'],
            'Réseau' => ['Cisco Switch', 'Juniper Router']
        ];

        $techUserId = $techRole->users()->first()->id ?? 2; // ID du responsable technique

// 1. SERVEURS (ID: 1) - 15 équipements
    for ($i = 1; $i <= 15; $i++) {
        Resource::create([
            'name' => "Equipement-IT-$i",
            'resource_category_id' => 1,
            'cpu' => rand(8, 32) . ' Cores',
            'ram' => rand(16, 128) . ' Go',
            'os' => 'Linux / Windows',
            'location' => 'Rack-' . rand(1, 20),
            'status' => 'available',
            'bandwidth' => null, 'capacity' => null, // Non compatibles
            'tech_manager_id' => ($i <= 5) ? $techUserId : null // Assigner les 5 premiers au responsable technique
        ]);
    }

    // 2. VM (ID: 2) - 15 équipements
    for ($i = 16; $i <= 30; $i++) {
        Resource::create([
            'name' => "Equipement-IT-$i",
            'resource_category_id' => 2,
            'cpu' => rand(2, 8) . ' vCPU',
            'ram' => rand(4, 32) . ' Go',
            'capacity' => rand(100, 2000) . ' Go',
            'os' => 'Ubuntu / Debian',
            'location' => 'Virtual-Cluster',
            'status' => 'available',
            'bandwidth' => null,
            'tech_manager_id' => ($i <= 20) ? $techUserId : null // Assigner les 5 premiers au responsable technique
        ]);
    }

    // 3. STOCKAGE (ID: 3) - 10 équipements
    for ($i = 31; $i <= 40; $i++) {
        Resource::create([
            'name' => "Equipement-IT-$i",
            'resource_category_id' => 3,
            'capacity' => rand(1, 100) . ' To',
            'location' => 'Baie-Stockage-' . rand(1, 5),
            'status' => 'available',
            'cpu' => null, 'ram' => null, 'bandwidth' => null, 'os' => null,
            'tech_manager_id' => ($i <= 33) ? $techUserId : null // Assigner les 3 premiers au responsable technique
        ]);
    }

    // 4. RÉSEAU (ID: 4) - 10 équipements
    for ($i = 41; $i <= 50; $i++) {
        Resource::create([
            'name' => "Equipement-IT-$i",
            'resource_category_id' => 4,
            'bandwidth' => rand(1, 100) . ' Gbps',
            'location' => 'Rack-Network-' . rand(1, 10),
            'status' => 'available',
            'cpu' => null, 'ram' => null, 'capacity' => null, 'os' => 'Cisco IOS',
            'tech_manager_id' => ($i <= 43) ? $techUserId : null // Assigner les 3 premiers au responsable technique
        ]);
    }
       
    }
}