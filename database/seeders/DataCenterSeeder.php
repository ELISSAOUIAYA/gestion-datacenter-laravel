<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataCenterSeeder extends Seeder
{
    public function run(): void{

    // 1. Création des Rôles (incluant le Manager)
    $adminId = \DB::table('roles')->insertGetId(['name' => 'Admin']);
    $managerId = \DB::table('roles')->insertGetId(['name' => 'Manager']);
    $techId = \DB::table('roles')->insertGetId(['name' => 'Responsable Technique']);
    $userId = \DB::table('roles')->insertGetId(['name' => 'Utilisateur Interne']);

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
        'name' => 'Admin Test',
        'email' => 'admin@test.com',
        'password' => bcrypt('admin123'),
        'role_id' => $adminId,
        'status' => 'active'
    ]);

    \App\Models\User::create([
        'name' => 'Manager Test',
        'email' => 'manager@test.com',
        'password' => bcrypt('manager123'),
        'role_id' => $managerId,
        'status' => 'active'
    ]);
}
    }
?>
