<?php

namespace App\Http\Controllers;

use App\Models\Resource; // Importation du modèle que tu as créé
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        // On récupère toutes les lignes de ta table 'resources'
        $serveurs = Resource::all(); 
        
        // On les envoie à une page nommée 'test_view'
        return view('test_view', compact('serveurs'));
    }
}