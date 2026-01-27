@extends('layouts.app')

@section('content')
<style>
    /* Structure Globale */
    .resource-container { padding: 30px; font-family: 'Segoe UI', system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    
    /* En-tête */
    .header-box { 
        background: white; padding: 20px 30px; border-radius: 12px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; 
        border-left: 6px solid #2c3e50; display: flex; justify-content: space-between; align-items: center;
    }

    /* Tableaux */
    .res-table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); margin-bottom: 40px; }
    .res-table th, .res-table td { padding: 18px 20px; border-bottom: 1px solid #edf2f7; text-align: left; }
    .res-table th { background-color: #2c3e50; color: #ffffff; text-transform: uppercase; font-size: 11px; letter-spacing: 1.2px; font-weight: 700; }
    .res-table tr:hover { background-color: #f8fafc; }
    
    /* Boutons d'action */
    .btn { padding: 10px 18px; border-radius: 8px; border: none; cursor: pointer; font-weight: 800; font-size: 11px; text-transform: uppercase; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; }
    .btn-success { background-color: #22c55e; color: white; box-shadow: 0 4px 6px rgba(34, 197, 94, 0.2); }
    .btn-danger { background-color: #ef4444; color: white; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2); }
    .btn-warning { background-color: #f59e0b; color: white; }
    .btn-info { background-color: #3b82f6; color: white; }

    /* BADGES */
    .status-badge { 
        padding: 8px 16px; border-radius: 50px; font-size: 11px; font-weight: 800; 
        color: white; text-transform: uppercase; letter-spacing: 0.5px;
        display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .bg-available { background-color: #10b981 !important; border: 2px solid #059669; }
    .bg-maintenance { background-color: #64748b !important; border: 2px solid #475569; }
    .bg-inactive { background-color: #ef4444 !important; border: 2px solid #dc2626; }

    .section-title { color: #1e293b; margin-bottom: 20px; font-weight: 800; font-size: 1.25rem; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
</style>

<div class="resource-container">
    <div class="header-box">
        <div>
            <h1 style="margin:0; font-weight: 800; color: #2c3e50;"><i class='bx bx-hdd'></i> Mes Ressources Supervisées</h1>
            <p style="margin:5px 0 0; color: #64748b;">Gérez les ressources assignées à votre responsabilité</p>
        </div>
        
        <a href="{{ route('tech.resources.create') }}" class="btn btn-info"><i class='bx bx-plus'></i> Ajouter une Ressource</a>
    </div>

    @if ($message = Session::get('success'))
        <div style="background-color: #10b981; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class='bx bx-check-circle'></i> {{ $message }}
        </div>
    @endif

    <table class="res-table">
        <thead>
            <tr>
                <th>Nom de la Ressource</th>
                <th>Catégorie</th>
                <th>Spécifications</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resources as $resource)
            <tr>
                <td><strong>{{ $resource->name }}</strong></td>
                <td>{{ $resource->category->name ?? 'N/A' }}</td>
                <td>
                    <small style="display: block;">CPU: {{ $resource->cpu ?? 'N/A' }}</small>
                    <small style="display: block;">RAM: {{ $resource->ram ?? 'N/A' }}</small>
                    <small style="display: block;">Localisation: {{ $resource->location ?? 'N/A' }}</small>
                </td>
                <td>
                    <span class="status-badge bg-{{ $resource->status == 'available' ? 'available' : ($resource->status == 'maintenance' ? 'maintenance' : 'inactive') }}">
                        {{ ucfirst($resource->status) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="{{ route('tech.resources.edit', $resource->id) }}" class="btn btn-warning" style="padding: 5px 10px;">
                            <i class='bx bx-edit'></i> Modifier
                        </a>
                        
                        @if($resource->status !== 'maintenance')
                            <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px;">
                                    <i class='bx bx-wrench'></i> Maintenance
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success" style="padding: 5px 10px;">
                                    <i class='bx bx-check'></i> Disponible
                                </button>
                            </form>
                        @endif

                        @if($resource->is_active)
                            <form action="{{ route('tech.resources.deactivate', $resource->id) }}" method="POST" style="display: inline;" onclick="return confirm('Êtes-vous sûr de vouloir désactiver cette ressource ?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger" style="padding: 5px 10px;">
                                    <i class='bx bx-power-off'></i> Désactiver
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.activate', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success" style="padding: 5px 10px;">
                                    <i class='bx bx-power-off'></i> Réactiver
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                    <i class='bx bx-inbox' style="font-size: 2rem;"></i>
                    <p>Aucune ressource supervisée</p>
                    <a href="{{ route('tech.resources.create') }}" class="btn btn-info" style="margin-top: 15px;">
                        <i class='bx bx-plus'></i> Créer une ressource
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="{{ route('tech.dashboard') }}" class="btn btn-warning" style="background: #2c3e50;">
            <i class='bx bx-arrow-back'></i> Retour au Tableau de Bord
        </a>
    </div>
</div>
@endsection
