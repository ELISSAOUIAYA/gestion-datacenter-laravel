<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        // On utilise EXACTEMENT les clés de ton ENUM : Serveur, VM, Stockage, Réseau
        $types = [
            'Serveur' => ['Dell PowerEdge', 'HP ProLiant', 'IBM SystemX'],
            'VM' => ['Ubuntu Server', 'Windows Core', 'Docker Host'],
            'Stockage' => ['NetApp SAN', 'Synology NAS', 'PureStorage'],
            'Réseau' => ['Cisco Switch', 'Juniper Router', 'Firewall Fortinet']
        ];

        for ($i = 1; $i <= 50; $i++) {
            // Sélection d'une catégorie au hasard parmi les 4
            $category = array_keys($types)[rand(0, 3)]; 
            $model = $types[$category][array_rand($types[$category])];

            DB::table('resources')->insert([
                'name' => $model . " #" . $i,
                'type' => $category, // Doit être 'Serveur', 'VM', 'Stockage' ou 'Réseau'
                'capacity' => rand(10, 500) . " Go",
                'status' => 'available', 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}