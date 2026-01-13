<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import des modèles liés
use App\Models\ResourceCategory;
use App\Models\Reservation;
use App\Models\Incident;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'status', // actif, en maintenance, indisponible…
    ];

    // Une ressource appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }

    // Une ressource peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Une ressource peut avoir plusieurs incidents
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
}
