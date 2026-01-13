<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    // On autorise ces colonnes à recevoir des données
    protected $fillable = [
        'name', 
        'type', 
        'cpu', 
        'ram', 
        'capacity', 
        'os', 
        'status'
    ];
}
