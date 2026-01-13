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

        $categories = [$catSrv, $catVM, $catSto, $catNet];

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
            'status' => 'active'
        ]);

        // 4. GÉNÉRATION DES 50 RESSOURCES (Correction de l'erreur SQL 'type')
        $models = [
            'Serveur' => ['Dell PowerEdge', 'HP ProLiant'],
            'VM' => ['Ubuntu Server', 'Windows Core'],
            'Stockage' => ['NetApp SAN', 'Synology NAS'],
            'Réseau' => ['Cisco Switch', 'Juniper Router']
        ];

        for ($i = 1; $i <= 50; $i++) {
            $catObj = $categories[array_rand($categories)];
            
            Resource::create([
                'name' => "Equipement-IT-" . $i,
                'resource_category_id' => $catObj->id, // On utilise l'ID, pas 'type'
                'cpu' => rand(4, 32) . " Cores",
                'ram' => rand(8, 128) . " Go",
                'capacity' => rand(100, 2000) . " Go",
                'os' => (rand(0, 1) ? 'Linux' : 'Windows'),
                'location' => 'Rack-' . rand(1, 20),
                'status' => 'available'
            ]);
        }
    }
}