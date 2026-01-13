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
        $incidents = Incident::with('resource', 'user')->get();
        return response()->json($incidents);
    }

    public function create()
    {
        $resources = Resource::all();
        return response()->json($resources);
    }

    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'description' => 'required|string',
        ]);

        $incident = Incident::create([
            'resource_id' => $request->resource_id,
            'user_id' => Auth::id(),
            'description' => $request->description,
        ]);

        return response()->json($incident, 201);
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

    public function destroy(Incident $incident)
    {
        $incident->delete();
        return response()->json(['message' => 'Incident deleted']);
    }
}
