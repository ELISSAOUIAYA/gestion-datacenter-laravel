<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidentController extends Controller
{
   
    public function index()
{
    // On récupère les incidents avec les infos de l'utilisateur et de la ressource
    $incidents = Incident::with(['user', 'resource'])->latest()->get();
    return view('manager.incidents.index', compact('incidents'));
}
public function destroy(Incident $incident)
{
    $incident->delete();
    return back()->with('success', 'Le signalement a été supprimé par la modération.');
}
   // app/Http/Controllers/IncidentController.php

public function create(Request $request)
{
    // On récupère la ressource concernée par le problème
    $resource = Resource::findOrFail($request->resource_id);
    return view('incidents.create', compact('resource'));
}

   public function store(Request $request)
   {
    $request->validate([
        'resource_id' => 'required|exists:resources,id',
        'description' => 'required|string|min:10',
    ]);

    Incident::create([
        'resource_id' => $request->resource_id,
        'user_id' => Auth::id(),
        'description' => $request->description,
        'status' => 'ouvert',
    ]);

    // Redirection vers le dashboard utilisateur avec un message de succès
    return redirect()->route('user.dashboard')->with('success', 'Incident signalé au Responsable Technique.');
   }

    public function show(Incident $incident)
    {
        return response()->json($incident->load('resource', 'user'));
    }

    public function edit(Incident $incident)
    {
        return response()->json($incident);
    }

    public function update(Request $request, Incident $incident)
    {
        $request->validate([
            'description' => 'sometimes|required|string',
        ]);

        $incident->update($request->all());
        return response()->json($incident);
    }

    
}
