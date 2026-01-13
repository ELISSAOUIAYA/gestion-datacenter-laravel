<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être remplis (Mass Assignable)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // AJOUTER CECI : indispensable pour le Seeder
        'status',  // AJOUTER CECI : indispensable pour le Seeder
    ];

    /**
     * Les attributs cachés (pour la sécurité)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Le cast des attributs
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * La relation avec le modèle Role
     */
    public function role() 
    {
        return $this->belongsTo(Role::class);
    }
}