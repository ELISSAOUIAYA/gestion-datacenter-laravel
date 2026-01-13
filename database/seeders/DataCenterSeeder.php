<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Resource;

class DataCenterSeeder extends Seeder
{
    public function run(): void
    {
    // 1. Création des Rôles (Pour les utilisateurs authentifiés)
        $adminRole = Role::create(['name' => 'Admin']);
        $techRole  = Role::create(['name' => 'Responsable Technique']);
        $userRole  = Role::create(['name' => 'Utilisateur Interne']);


    // 2. Création des Catégories de ressources
    \DB::table('resource_categories')->insert([
        ['name' => 'Serveurs Physiques'],
        ['name' => 'Machines Virtuelles (VM)'],
        ['name' => 'Stockage Cloud'],
    ]);

    // 3. Ajout de plusieurs ressources de test
    \App\Models\Resource::create([
        'name' => 'Dell-PowerEdge-R740',
        'type' => 'Serveur',
        'cpu' => '48 Cores',
        'ram' => '256 Go',
        'capacity' => '4 TB',
        'os' => 'VMware ESXi',
        'status' => 'available'
    ]);

    \App\Models\Resource::create([
        'name' => 'SRV-WEB-PROD',
        'type' => 'VM',
        'cpu' => '8 Cores',
        'ram' => '32 Go',
        'capacity' => '500 GB',
        'os' => 'Ubuntu 22.04',
        'status' => 'available'
    ]);

    \App\Models\Resource::create([
        'name' => 'NAS-Backup-01',
        'type' => 'Stockage',
        'cpu' => 'N/A',
        'ram' => '16 Go',
        'capacity' => '20 TB',
        'os' => 'TrueNAS',
        'status' => 'maintenance'
    ]);

    // 4. Création des utilisateurs liés aux rôles
    \App\Models\User::create([
        'name' => 'Admin ',
        'email' => 'admin@test.com',
        'password' => bcrypt('admin123'),
        'role_id' => $adminRole->id,
        'status' => 'active'
    ]);

    \App\Models\User::create([
        'name' => 'Responsable Technique',
        'email' => 'tech@test.com',
        'password' => bcrypt('tech123'),
        'role_id' => $techRole->id,
        'status' => 'active'
    ]);
    // 4. Création d'un Utilisateur Interne (Enseignant/Chercheur)
        User::create([
            'name' => 'Utilisateur Interne',
            'email' => 'user@datacenter.com',
            'password' => bcrypt('user123'),
            'role_id' => $userRole->id,
            'status' => 'active'
        ]);

    }
}