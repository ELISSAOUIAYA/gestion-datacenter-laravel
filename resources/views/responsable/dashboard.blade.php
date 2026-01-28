@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;
        --primary-hover: #0ea5e9;
        --bg-body: #020617;
        --bg-card: #0f172a;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --danger: #ef4444;
        --success: #22c55e;
        --warning: #f59e0b;
    }

    body { 
        margin: 0; 
        padding: 0; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    .dashboard-container { 
        padding: 30px 40px; 
        min-height: 100vh;
        width: 100%;
        box-sizing: border-box;
    }

    /* Barre de navigation top */
    .top-bar { 
        background: var(--bg-card); 
        padding: 15px 30px; 
        border-radius: 12px; 
        border: 1px solid var(--border);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .top-bar-left h2 { color: var(--text-main); }
    .top-bar-left span { color: var(--text-muted); }

    /* Statistiques */
    .stats-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
        gap: 20px; 
        margin-bottom: 30px; 
    }
    .stat-card { 
        background: var(--bg-card); 
        padding: 20px; 
        border-radius: 12px; 
        border: 1px solid var(--border);
        border-left: 5px solid var(--primary);
        transition: all 0.3s ease;
    }
    .stat-card:hover { transform: translateY(-3px); border-color: var(--primary); }
    .stat-card h3 { margin: 0; font-size: 2rem; font-weight: 800; color: var(--text-main); }
    .stat-card p { margin: 8px 0 0; color: var(--text-muted); font-size: 0.9rem; }

    /* Titres des sections */
    .section-title { 
        color: var(--text-main); 
        margin-bottom: 18px; 
        margin-top: 35px;
        font-weight: 800; 
        font-size: 1.3rem; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
    }

    /* Tableaux */
    .res-table { 
        width: 100%; 
        border-collapse: separate; 
        border-spacing: 0;
        background: var(--bg-card); 
        border-radius: 12px; 
        overflow: hidden; 
        border: 1px solid var(--border);
        margin-bottom: 35px;
    }
    .res-table th, .res-table td { 
        padding: 16px 18px; 
        border-bottom: 1px solid var(--border); 
        text-align: left; 
    }
    .res-table th { 
        background-color: rgba(255,255,255,0.03); 
        color: var(--primary); 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        font-weight: 700; 
    }
    .res-table tr:hover { background-color: rgba(255,255,255,0.02); }
    .res-table td { color: var(--text-main); }

    /* Boutons */
    .btn { 
        padding: 10px 20px; 
        border-radius: 8px; 
        font-weight: 700; 
        font-size: 11px; 
        text-transform: uppercase; 
        cursor: pointer;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-home { 
        background-color: var(--primary); 
        color: var(--bg-body); 
    }

    .btn-logout { 
        background-color: #1e293b; 
        color: white; 
        border: 1px solid var(--border);
    }
    .btn-primary { background-color: var(--primary); color: var(--bg-body); }
    .btn-primary:hover { background-color: var(--primary-hover); }
    .btn-success { background-color: var(--success); color: white; }
    .btn-danger { background-color: var(--danger); color: white; }
    .btn-warning { background-color: var(--warning); color: var(--bg-body); }
    .btn-secondary { background-color: rgba(255,255,255,0.1); color: var(--text-main); }
    .btn-logout { background-color: #1e293b; color: white; }
    .btn-home { border: 1px solid var(--border); color: var(--text-main); }

    /* Badges */
    .status-badge { 
        padding: 4px 10px; 
        border-radius: 6px; 
        font-size: 10px; 
        font-weight: 800; 
        color: white; 
        text-transform: uppercase;
    }
    .bg-attente { background-color: var(--warning); color: var(--bg-body); }
    .bg-validee { background-color: var(--success); }
    .bg-refusee { background-color: var(--danger); }
    .bg-maintenance { background-color: var(--text-muted); }
    .bg-available { background-color: var(--success); }
    .bg-inactive { background-color: var(--text-muted); opacity: 0.5; }

    .sidebar, .left-sidebar, .datacenter-info { display: none !important; }
</style>

<div class="dashboard-container">
    <div class="top-bar">
        <div class="top-bar-left">
            <h2 style="margin: 0; font-weight: 800; font-size: 1.3rem;">
                <i class='bx bxs-dashboard' style="color: var(--primary);"></i> Responsable Technique
            </h2>
            <span>{{ Auth::user()->name }}</span>
        </div>
        <div class="top-bar-right">
            <a href="{{ route('welcome') }}" class="btn btn-home">
                <i class='bx bx-home'></i> Accueil
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class='bx bx-log-out-circle'></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ count($resources) }}</h3>
            <p>Ressources Total</p>
        </div>
        <div class="stat-card" style="border-left-color: var(--warning);">
            <h3>{{ $reservations->where('status', 'EN ATTENTE')->count() }}</h3>
            <p>Demandes en attente</p>
        </div>
        <div class="stat-card" style="border-left-color: var(--danger);">
            <h3>{{ $incidents->count() }}</h3>
            <p>Alertes Incidents</p>
        </div>
        <div class="stat-card" style="border-left-color: var(--success);">
            <h3>{{ $reservations->where('status', 'VALIDÉE')->count() }}</h3>
            <p>Réservations Actives</p>
        </div>
    </div>

    <div class="section-title">
        <div class="section-title-left">
            <i class='bx bx-time-five' style="color: var(--warning); font-size: 1.5rem;"></i>
            <span>Demandes de Réservations</span>
        </div>
    </div>
    <table class="res-table">
        <thead>
            <tr>
                <th>Demandeur</th>
                <th>Équipement</th>
                <th>Période</th>
                <th>Statut</th>
                <th>Justification</th>
                <th>Décision</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
                <tr>
                    <td>
    <div style="font-weight: 700; color: var(--text-main); font-size: 0.95rem;">
        {{ $res->user->name ?? 'Utilisateur supprimé' }}
    </div>
    <small style="color: var(--text-muted);">
        {{ $res->user->email ?? 'N/A' }}
    </small>
</td>
                    <td><strong style="color: var(--primary);">{{ $res->resource->name }}</strong></td>
                    <td style="font-size: 0.9rem; color: var(--text-muted);">
                        Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m H:i') }}<br>
                        Au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m H:i') }}
                    </td>
                    <td>
                        @php 
                            $classStatus = $res->status == 'VALIDÉE' ? 'validee' : ($res->status == 'REFUSÉE' ? 'refusee' : 'attente');
                        @endphp
                        <span class="status-badge bg-{{ $classStatus }}">{{ $res->status }}</span>
                    </td>
                    <td style="font-size: 0.85rem; max-width: 200px; color: var(--text-muted);">
                        @if($res->status == 'REFUSÉE' && $res->rejection_reason)
                            <div style="padding: 6px; background-color: rgba(239, 68, 68, 0.1); border-left: 3px solid var(--danger); border-radius: 3px; color: var(--danger);">
                                <strong>Motif:</strong> {{ Str::limit($res->rejection_reason, 50) }}
                            </div>
                        @elseif($res->justification)
                            {{ Str::limit($res->justification, 50) }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        @if($res->status == 'EN ATTENTE')
                            <div style="display: flex; gap: 6px;">
                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="VALIDÉE">
                                    <button type="submit" class="btn btn-success">✓</button>
                                </form>
                                <button type="button" class="btn btn-danger" onclick="openRefusalModal({{ $res->id }})">✕</button>
                            </div>
                        @else
                            <small style="color: var(--text-muted);">Traité le {{ $res->updated_at->format('d/m') }}</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">Aucune demande en cours</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">
        <div class="section-title-left">
            <i class='bx bxs-zap' style="color: var(--danger); font-size: 1.5rem;"></i>
            <span>Alertes & Modération</span>
        </div>
    </div>
    <table class="res-table">
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Description</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidents as $incident)
                <tr>
                    <td><strong style="color: var(--danger);">{{ $incident->resource->name }}</strong></td>
                    <td style="font-size: 0.9rem; color: var(--text-muted);">{{ Str::limit($incident->description, 80) }}</td>
                    <td>{{ $incident->user->name }}</td>
                    <td style="color: var(--text-muted);">{{ $incident->created_at->format('d/m H:i') }}</td>
                    <td>
                        <form action="{{ route('manager.incidents.destroy', $incident->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Clôturer cet incident ?')">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center; padding: 30px; color: var(--text-muted);">Aucun incident signalé</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">
        <div class="section-title-left">
            <i class='bx bx-hdd' style="color: var(--primary); font-size: 1.5rem;"></i>
            <span>Mes Ressources Supervisées</span>
        </div>
        <a href="{{ route('tech.resources.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> Ajouter une ressource
        </a>
    </div>
    <table class="res-table">
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Catégorie</th>
                <th>Localisation</th>
                <th>État</th>
                <th>Demandes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resources as $resource)
            <tr>
                <td><strong>{{ $resource->name }}</strong></td>
                <td><span style="background: rgba(56, 189, 248, 0.1); color: var(--primary); padding: 3px 8px; border-radius: 15px; font-size: 0.8rem;">{{ $resource->category->name ?? 'N/A' }}</span></td>
                <td>{{ $resource->location ?? '—' }}</td>
                <td>
                    <span class="status-badge bg-{{ $resource->status }}">
                        {{ ucfirst($resource->status) }}
                    </span>
                </td>
                <td><strong>{{ $reservations->where('resource_id', $resource->id)->count() }}</strong></td>
                <td>
                    <div class="actions-group" style="display: flex; gap: 5px;">
                        <a href="{{ route('tech.resources.edit', $resource->id) }}" class="btn btn-warning">Modifier</a>
                        
                        <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-secondary">
                                <i class='bx bx-wrench'></i>
                            </button>
                        </form>

                        @if($resource->status !== 'inactive')
                            <form action="{{ route('tech.resources.deactivate', $resource->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger">Désactiver</button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.activate', $resource->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success">Activer</button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
                <tr><td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">Aucune ressource supervisée</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="refusalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; padding: 25px; max-width: 450px; width: 90%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h2 style="margin: 0; color: var(--text-main); font-weight: 800; font-size: 1.15rem;">Refuser la demande</h2>
            <button type="button" onclick="closeRefusalModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-muted);">✕</button>
        </div>

        <form id="refusalForm" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="REFUSÉE">

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-weight: 700; color: var(--text-muted); margin-bottom: 8px; font-size: 0.9rem;">Motif du refus *</label>
                <textarea name="rejection_reason" placeholder="Justification du refus..." required style="width: 100%; padding: 12px; background: var(--bg-body); border: 1px solid var(--border); border-radius: 8px; color: var(--text-main); font-size: 0.9rem; min-height: 100px; outline: none;"></textarea>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeRefusalModal()" class="btn btn-secondary">Annuler</button>
                <button type="submit" class="btn btn-danger">Confirmer le refus</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRefusalModal(reservationId) {
        const modal = document.getElementById('refusalModal');
        const form = document.getElementById('refusalForm');
        form.action = `/reservations/${reservationId}/update`;
        modal.style.display = 'flex';
    }

    function closeRefusalModal() {
        document.getElementById('refusalModal').style.display = 'none';
        document.getElementById('refusalForm').reset();
    }
</script>
@endsection