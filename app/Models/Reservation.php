<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // C'est cette liste qui autorise l'enregistrement des données
    protected $fillable = [
        'user_id', 
        'resource_id', 
        'start_date', 
        'end_date', 
        'status'
    ];

    // Une réservation appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une réservation concerne une ressource
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
