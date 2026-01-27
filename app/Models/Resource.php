<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être remplis massivement.
     * Note : On remplace 'type' par 'resource_category_id' pour lier à la table des catégories.
     */
    protected $fillable = [
        'name',
        'resource_category_id', // Clé étrangère vers ResourceCategory
        'tech_manager_id',       // Responsable technique assigné
        'cpu',
        'ram',
        'bandwidth',
        'capacity',
        'os',
        'location',
        'status',
        'is_active'              // Activation/Désactivation
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Relation avec le responsable technique (Une ressource peut être assignée à un responsable)
     */
    public function techManager()
    {
        return $this->belongsTo(User::class, 'tech_manager_id');
    }

    /**
     * Relation avec la catégorie (Une ressource appartient à une catégorie)
     */
   public function category()
{
    return $this->belongsTo(ResourceCategory::class, 'resource_category_id');
}

    /**
     * Relation avec les réservations (Une ressource peut avoir plusieurs réservations)
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}