<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    // Lister toutes les ressources
    public function index()
    {
<<<<<<< HEAD
        // On récupère toutes les lignes de ta table 'resources'
        $serveurs = Resource::all(); 
        
 
       return view('resources.index', ['resources' => $serveurs]);
=======
        $resources = Resource::with('category')->get(); // charger la catégorie liée
        return response()->json($resources);
>>>>>>> 13c9a2bcad9fb762335b5a6440755449cd5fffda
    }

    // Formulaire de création (juste pour API, renvoie les catégories)
    public function create()
    {
        $categories = ResourceCategory::all();
        return response()->json($categories);
    }

    // Stocker une nouvelle ressource
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:resource_categories,id',
        ]);

        $resource = Resource::create($request->all());
        return response()->json($resource, 201);
    }

    // Afficher une ressource
    public function show(Resource $resource)
    {
        return response()->json($resource->load('category'));
    }

    // Formulaire édition
    public function edit(Resource $resource)
    {
        return response()->json($resource);
    }

    // Mettre à jour
    public function update(Request $request, Resource $resource)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:resource_categories,id',
        ]);

        $resource->update($request->all());
        return response()->json($resource);
    }

    // Supprimer
    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(['message' => 'Resource deleted']);
    }
}
