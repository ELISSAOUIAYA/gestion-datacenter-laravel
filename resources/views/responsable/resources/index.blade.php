@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Fond des cartes et tableaux */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.08);
        --danger: #ef4444;          /* Rouge */
        --success: #22c55e;         /* Vert */
        --warning: #f59e0b;         /* Orange */
    }

    .resource-container { 
        padding: 30px 40px; 
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; 
        background-color: var(--bg-body); 
        min-height: 100vh; 
        color: var(--text-main);
    }
    
    /* En-tête */
    .header-box { 
        background: var(--bg-card); 
        padding: 25px 35px; 
        border-radius: 12px; 
        border: 1px solid var(--border);
        margin-bottom: 30px; 
        border-left: 6px solid var(--primary);
        display: flex; 
        justify-content: space-between; 
        align-items: center;
    }

    /* Tableaux style DataCenter */
    .res-table { 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0;
        background: var(--bg-card); 
        border-radius: 12px; 
        overflow: hidden; 
        border: 1px solid var(--border);
        margin-bottom: 40px; 
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3);
    }
    .res-table th, .res-table td { 
        padding: 18px 20px; 
        border-bottom: 1px solid var(--border); 
        text-align: left; 
    }
    .res-table th { 
        background-color: rgba(255, 255, 255, 0.03); 
        color: var(--primary); 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1.2px; 
        font-weight: 700; 
    }
    .res-table tr:hover { background-color: rgba(255, 255, 255, 0.02); }
    
    /* Boutons */
    .btn { 
        padding: 10px 18px; 
        border-radius: 8px; 
        border: none; 
        cursor: pointer; 
        font-weight: 800; 
        font-size: 11px; 
        text-transform: uppercase; 
        transition: all 0.2s ease; 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        text-decoration: none;
    }
    .btn-success { background-color: var(--success); color: white; }
    .btn-danger { background-color: var(--danger); color: white; }
    .btn-warning { background-color: var(--warning); color: #020617; }
    .btn-info { background-color: var(--primary); color: #020617; }
    .btn-back { background-color: #1e293b; color: white; border: 1px solid var(--border); }

    .btn:hover { transform: translateY(-2px); opacity: 0.9; }

    /* BADGES STATUT */
    .status-badge { 
        padding: 6px 14px; 
        border-radius: 6px; 
        font-size: 11px; 
        font-weight: 800; 
        color: white; 
        text-transform: uppercase; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px; 
    }
    .bg-available { background-color: var(--success); }
    .bg-maintenance { background-color: var(--text-muted); }
    .bg-inactive { background-color: #334155; }

    /* Alert Success */
    .alert-success {
        background-color: rgba(34, 197, 94, 0.1); 
        border: 1px solid var(--success); 
        color: var(--success); 
        padding: 15px; 
        border-radius: 12px; 
        margin-bottom: 25px; 
        display: flex; 
        align-items: center; 
        gap: 12px;
        font-weight: 600;
    }
</style>

<div class="resource-container">
    <div class="header-box">
        <div>
            <h1 style="margin:0; font-weight: 800; color: var(--text-main);">
                <i class='bx bx-hdd' style="color: var(--primary);"></i> Parc de Ressources
            </h1>
            <p style="margin:5px 0 0; color: var(--text-muted);">Gestion technique des équipements supervisés</p>
        </div>
        
        <a href="{{ route('tech.resources.create') }}" class="btn btn-info">
            <i class='bx bx-plus'></i> Ajouter une Ressource
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert-success">
            <i class='bx bx-check-circle' style="font-size: 1.4rem;"></i> {{ $message }}
        </div>
    @endif

    <table class="res-table">
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Catégorie</th>
                <th>Spécifications Techniques</th>
                <th>État Opérationnel</th>
                <th>Actions de Supervision</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resources as $resource)
            <tr>
                <td><strong style="color: var(--text-main); font-size: 1rem;">{{ $resource->name }}</strong></td>
                <td>
                    <span style="background: rgba(56, 189, 248, 0.1); color: var(--primary); padding: 4px 10px; border-radius: 20px; font-size: 0.8rem;">
                        {{ $resource->category->name ?? 'N/A' }}
                    </span>
                </td>
                <td>
                    <div style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.6;">
                        <div><i class='bx bx-microchip'></i> CPU: {{ $resource->cpu ?? 'N/A' }}</div>
                        <div><i class='bx bx-memory-card'></i> RAM: {{ $resource->ram ?? 'N/A' }}</div>
                        <div><i class='bx bx-map-pin'></i> Localisation: {{ $resource->location ?? 'N/A' }}</div>
                    </div>
                </td>
                <td>
                    <span class="status-badge bg-{{ $resource->status == 'available' ? 'available' : ($resource->status == 'maintenance' ? 'maintenance' : 'inactive') }}">
                        {{ ucfirst($resource->status) }}
                    </span>
                </td>
                <td>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        {{-- Bouton Modifier --}}
                        <a href="{{ route('tech.resources.edit', $resource->id) }}" class="btn btn-warning" style="padding: 8px 12px;">
                            <i class='bx bx-edit'></i> Edit
                        </a>
                        
                        {{-- Toggle Maintenance --}}
                        @if($resource->status !== 'maintenance')
                            <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-back" style="padding: 8px 12px;">
                                    <i class='bx bx-wrench'></i> Maintenance
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success" style="padding: 8px 12px;">
                                    <i class='bx bx-play-circle'></i> Activer
                                </button>
                            </form>
                        @endif

                        {{-- Toggle Activation/Désactivation --}}
                        @if($resource->is_active)
                            <form action="{{ route('tech.resources.deactivate', $resource->id) }}" method="POST" onsubmit="return confirm('Confirmer la mise hors tension de cette ressource ?');">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger" style="padding: 8px 12px;">
                                    <i class='bx bx-power-off'></i> OFF
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.activate', $resource->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success" style="padding: 8px 12px;">
                                    <i class='bx bx-power-off'></i> ON
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 60px; color: var(--text-muted);">
                    <i class='bx bx-server' style="font-size: 3rem; opacity: 0.2; margin-bottom: 15px; display: block;"></i>
                    <p>Aucun équipement assigné à votre supervision.</p>
                    <a href="{{ route('tech.resources.create') }}" class="btn btn-info" style="margin-top: 20px;">
                        <i class='bx bx-plus'></i> Créer ma première ressource
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; border-top: 1px solid var(--border); padding-top: 20px;">
        <a href="{{ route('tech.dashboard') }}" class="btn btn-back">
            <i class='bx bx-left-arrow-alt'></i> Retour au Tableau de Bord
        </a>
    </div>
</div>
@endsection