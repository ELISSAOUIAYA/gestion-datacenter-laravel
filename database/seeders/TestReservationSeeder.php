<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use Carbon\Carbon;

class TestReservationSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Récupérer l'utilisateur interne
        $user = User::where('email', 'user@test.com')->first();
        
        // Récupérer les ressources supervisées par le responsable technique
        $supervisedResources = Resource::where('tech_manager_id', 2)->get();

        if ($user && $supervisedResources->count() > 0) {
            // Créer des demandes de réservation
            foreach ($supervisedResources->take(3) as $resource) {
                Reservation::create([
                    'user_id' => $user->id,
                    'resource_id' => $resource->id,
                    'start_date' => Carbon::now()->addDay()->setHour(10)->setMinute(0)->setSecond(0),
                    'end_date' => Carbon::now()->addDays(2)->setHour(14)->setMinute(0)->setSecond(0),
                    'status' => 'EN ATTENTE',
                    'justification' => 'Test de demande de réservation pour ' . $resource->name
                ]);
            }
        }
    }
}
