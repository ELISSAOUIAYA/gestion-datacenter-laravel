<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un utilisateur test s'il n'existe pas
        $user = User::where('email', 'user@test.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Utilisateur Test',
                'email' => 'user@test.com',
                'password' => bcrypt('user123456'),
                'role_id' => 4  // Utilisateur Interne
            ]);
        }

        // Obtenir la première ressource
        $resource = Resource::first();

        if ($resource && !Reservation::where('user_id', $user->id)->first()) {
            Reservation::create([
                'user_id' => $user->id,
                'resource_id' => $resource->id,
                'start_date' => now()->addDays(1)->setHour(12)->setMinute(0)->setSecond(0),
                'end_date' => now()->addDays(2)->setHour(12)->setMinute(0)->setSecond(0),
                'justification' => 'Non spécifié',
                'status' => 'EN ATTENTE'
            ]);
        }
    }
}
