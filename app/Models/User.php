<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // On utilise l'ID de la table roles
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS (Fusion de ton travail et celui de ta collègue)
    |--------------------------------------------------------------------------
    */

    /**
     * Relation vers le rôle (Ton travail)
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation vers les réservations (Travail de ta collègue)
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS (Mis à jour avec tes vrais noms de rôles en BDD)
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'Admin';
    }

    public function isTech(): bool // Remplacé isManager par isTech
    {
        return $this->role && $this->role->name === 'Responsable Technique';
    }

    public function isUser(): bool
    {
        return $this->role && $this->role->name === 'Utilisateur Interne';
    }
}