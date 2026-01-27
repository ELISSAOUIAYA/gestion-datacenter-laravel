<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'user_type',
        'motivation',
        'status',
        'admin_comment'
    ];

    /**
     * Les statuts possibles
     */
    public static function statuses()
    {
        return ['EN ATTENTE', 'APPROUVÉE', 'REFUSÉE'];
    }

    /**
     * Les types d'utilisateurs
     */
    public static function userTypes()
    {
        return ['Ingénieur', 'Enseignant', 'Doctorant', 'Autre'];
    }
}
