<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceManagerController extends Controller
{
    /**
     * Affiche les ressources supervisées par le responsable technique
     */
    public function index()
    {
        $resources = Auth::user()->supervises()->with('category')->get();
        return view('responsable.resources.index', compact('resources'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle ressource
     */
    public function create()
    {
        $categories = ResourceCategory::all();
        return view('responsable.resources.create', compact('categories'));
    }

    /**
     * Enregistre une nouvelle ressource supervisée
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'resource_category_id' => 'required|exists:resource_categories,id',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'bandwidth' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // Ajouter l'ID du responsable technique
        $validated['tech_manager_id'] = Auth::id();
        $validated['status'] = 'available';
        $validated['is_active'] = true;

        Resource::create($validated);

        return redirect()->route('tech.resources.index')->with('success', 'Ressource créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'une ressource
     */
    public function edit(Resource $resource)
    {
        // Vérifier que le responsable technique ne peut éditer que ses propres ressources
        if ($resource->tech_manager_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $categories = ResourceCategory::all();
        return view('responsable.resources.edit', compact('resource', 'categories'));
    }

    /**
     * Met à jour une ressource
     */
    public function update(Request $request, Resource $resource)
    {
        // Vérifier que le responsable technique ne peut éditer que ses propres ressources
        if ($resource->tech_manager_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'resource_category_id' => 'required|exists:resource_categories,id',
            'cpu' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'bandwidth' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:available,maintenance,inactive',
        ]);

        $resource->update($validated);

        return redirect()->route('tech.resources.index')->with('success', 'Ressource mise à jour avec succès.');
    }

    /**
     * Bascule la ressource en mode maintenance
     */
    public function toggleMaintenance(Resource $resource)
    {
        if ($resource->tech_manager_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $resource->update([
            'status' => $resource->status === 'maintenance' ? 'available' : 'maintenance'
        ]);

        return back()->with('success', 'Statut de maintenance mis à jour.');
    }

    /**
     * Désactive une ressource
     */
    public function deactivate(Resource $resource)
    {
        if ($resource->tech_manager_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $resource->update([
            'is_active' => false,
            'status' => 'inactive'
        ]);

        return back()->with('success', 'Ressource désactivée.');
    }

    /**
     * Réactive une ressource
     */
    public function activate(Resource $resource)
    {
        if ($resource->tech_manager_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $resource->update([
            'is_active' => true,
            'status' => 'available'
        ]);

        return back()->with('success', 'Ressource réactivée.');
    }

    /**
     * Supprime une ressource
     */
    public function destroy(Resource $resource)
    {
        if ($resource->tech_manager_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $resource->delete();

        return redirect()->route('tech.resources.index')->with('success', 'Ressource supprimée avec succès.');
    }
}
