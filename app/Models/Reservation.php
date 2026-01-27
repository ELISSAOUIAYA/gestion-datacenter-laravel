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
        'status',
        'justification',          // Justification de la demande
        'rejection_reason',       // Motif du refus
        'approved_at'             // Date d'approbation
    ];

    // Caster les dates en instances Carbon
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    // app/Models/Reservation.php

public function user()
{
    return $this->belongsTo(User::class);
}

// Ajoute aussi celle pour la ressource si ce n'est pas fait
public function resource()
{
    return $this->belongsTo(Resource::class);
}
}
