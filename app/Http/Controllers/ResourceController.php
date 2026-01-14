<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Lister toutes les ressources pour l'interface d'accueil
     * Triées par catégorie (1, 2, 3, 4) et filtrées par disponibilité
     */
    public function index()
    {
        // On récupère les ressources avec leur catégorie liée
        // On filtre uniquement les disponibles et on trie par ID de catégorie
        $resources = Resource::with('category')
            ->where('status', 'available')
            ->orderBy('resource_category_id', 'asc')
            ->get();

        // On renvoie vers la vue welcome (ou resources.index selon ton choix)
        // compact('resources') permet de passer la variable à la vue
        return view('welcome', compact('resources'));
    }

    /**
     * Formulaire de création / API catégories
     */
    public function create()
    {
        $categories = ResourceCategory::all();
        return response()->json($categories);
    }

    /**
     * Stocker une nouvelle ressource
     */
    public function store(Request $request)
    {
        // Validation avec la notation resource_category_id
        $request->validate([
            'name' => 'required|string',
            'resource_category_id' => 'required|exists:resource_categories,id',
            'status' => 'required|string'
        ]);

        $resource = Resource::create($request->all());

        return response()->json([
            'message' => 'Ressource créée avec succès',
            'resource' => $resource
        ], 201);
    }

    /**
     * Afficher une ressource spécifique
     */
    public function show(Resource $resource)
    {
        return response()->json($resource->load('category'));
    }

    /**
     * Formulaire d'édition
     */
    public function edit(Resource $resource)
    {
        return response()->json($resource);
    }

    /**
     * Mettre à jour une ressource
     */
    public function update(Request $request, Resource $resource)
    {
        // Validation avec la notation resource_category_id
        $request->validate([
            'name' => 'sometimes|required|string',
            'resource_category_id' => 'sometimes|required|exists:resource_categories,id',
        ]);

        $resource->update($request->all());

        return response()->json([
            'message' => 'Ressource mise à jour',
            'resource' => $resource
        ]);
    }

    /**
     * Supprimer une ressource
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(['message' => 'Ressource supprimée avec succès']);
    }
}