@extends('layouts.app')

@section('content')
<style>
    body { margin: 0; padding: 0; }
    .dashboard-container { 
        padding: 30px 40px; 
        font-family: 'Segoe UI', system-ui, sans-serif; 
        background-color: #f4f7f6; 
        min-height: 100vh;
        width: 100%;
        box-sizing: border-box;
    }

    /* Barre de navigation top */
    .top-bar { 
        background: white; 
        padding: 15px 30px; 
        border-radius: 8px; 
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .top-bar-left { display: flex; gap: 15px; align-items: center; }
    .top-bar-right { display: flex; gap: 10px; }

    /* Statistiques */
    .stats-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
        gap: 20px; 
        margin-bottom: 30px; 
    }
    .stat-card { 
        background: white; 
        padding: 20px; 
        border-radius: 10px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
        border-left: 5px solid #3b82f6;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-2px); }
    .stat-card h3 { margin: 0; font-size: 2rem; font-weight: 800; color: #2c3e50; }
    .stat-card p { margin: 8px 0 0; color: #64748b; font-size: 0.9rem; }

    /* Titres des sections */
    .section-title { 
        color: #1e293b; 
        margin-bottom: 18px; 
        margin-top: 25px;
        font-weight: 800; 
        font-size: 1.3rem; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
    }
    .section-title-left { display: flex; align-items: center; gap: 12px; }

    /* Tableaux */
    .res-table { 
        width: 100%; 
        border-collapse: collapse; 
        background: white; 
        border-radius: 10px; 
        overflow: hidden; 
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); 
        margin-bottom: 35px;
    }
    .res-table th, .res-table td { 
        padding: 16px 18px; 
        border-bottom: 1px solid #edf2f7; 
        text-align: left; 
    }
    .res-table th { 
        background-color: #2c3e50; 
        color: #ffffff; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
        font-weight: 700; 
    }
    .res-table tr:hover { background-color: #f8fafc; }

    /* Boutons */
    .btn { 
        padding: 8px 16px; 
        border-radius: 6px; 
        border: none; 
        cursor: pointer; 
        font-weight: 700; 
        font-size: 11px; 
        text-transform: uppercase; 
        transition: all 0.2s; 
        display: inline-flex; 
        align-items: center; 
        gap: 6px;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 10px rgba(0,0,0,0.12); }
    .btn-primary { background-color: #3b82f6; color: white; }
    .btn-success { background-color: #22c55e; color: white; }
    .btn-danger { background-color: #ef4444; color: white; }
    .btn-warning { background-color: #f59e0b; color: white; }
    .btn-secondary { background-color: #6b7280; color: white; }
    .btn-logout { background-color: #1e293b; color: white; }
    .btn-home { background-color: #0ea5e9; color: white; }

    /* Badges */
    .status-badge { 
        padding: 6px 12px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: 800; 
        color: white; 
        text-transform: uppercase; 
        display: inline-flex; 
        align-items: center; 
    }
    .bg-attente { background-color: #f59e0b; }
    .bg-validee { background-color: #10b981; }
    .bg-refusee { background-color: #ef4444; }
    .bg-maintenance { background-color: #64748b; }
    .bg-available { background-color: #10b981; }
    .bg-inactive { background-color: #ef4444; }

    .actions-group { 
        display: flex; 
        gap: 6px; 
        flex-wrap: wrap;
    }
    .actions-group .btn { 
        padding: 6px 10px; 
        font-size: 10px;
    }

    .sidebar { display: none !important; }
    .left-sidebar { display: none !important; }
    .datacenter-info { display: none !important; }
</style>

<div class="dashboard-container">
    <!-- Barre de navigation top simple -->
    <div class="top-bar">
        <div class="top-bar-left">
            <h2 style="margin: 0; color: #2c3e50; font-weight: 800; font-size: 1.3rem;">
                <i class='bx bxs-dashboard'></i> Responsable Technique
            </h2>
            <span style="color: #94a3b8;">{{ Auth::user()->name }}</span>
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

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>{{ count($resources) }}</h3>
            <p>Ressources</p>
        </div>
        <div class="stat-card" style="border-left-color: #f59e0b;">
            <h3>{{ $reservations->where('status', 'EN ATTENTE')->count() }}</h3>
            <p>Demandes en attente</p>
        </div>
        <div class="stat-card" style="border-left-color: #ef4444;">
            <h3>{{ $incidents->count() }}</h3>
            <p>Alertes</p>
        </div>
        <div class="stat-card" style="border-left-color: #22c55e;">
            <h3>{{ $reservations->where('status', 'VALIDÉE')->count() }}</h3>
            <p>Approuvées</p>
        </div>
    </div>

    <!-- SECTION 1: DEMANDES À TRAITER -->
    <div class="section-title">
        <div class="section-title-left">
            <i class='bx bx-time-five' style="color: #f59e0b; font-size: 1.5rem;"></i>
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
                        <div style="font-weight: 700; color: #2c3e50; font-size: 0.95rem;">{{ $res->user->name }}</div>
                        <small style="color: #94a3b8;">{{ $res->user->email }}</small>
                    </td>
                    <td><strong style="color: #2c3e50;">{{ $res->resource->name }}</strong></td>
                    <td style="font-size: 0.9rem; color: #64748b;">
                        Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m H:i') }}<br>
                        Au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m H:i') }}
                    </td>
                    <td>
                        @php 
                            $classStatus = $res->status == 'VALIDÉE' ? 'validee' : ($res->status == 'REFUSÉE' ? 'refusee' : 'attente');
                        @endphp
                        <span class="status-badge bg-{{ $classStatus }}">{{ $res->status }}</span>
                    </td>
                    <td style="font-size: 0.85rem; max-width: 200px;">
                        @if($res->status == 'REFUSÉE' && $res->rejection_reason)
                            <div style="padding: 6px; background-color: #fee2e2; border-left: 3px solid #ef4444; border-radius: 3px; color: #7f1d1d; max-height: 60px; overflow: auto;">
                                <strong>Motif:</strong> {{ Str::limit($res->rejection_reason, 50) }}
                            </div>
                        @elseif($res->status == 'VALIDÉE')
                            <small style="color: #d1d5db;">—</small>
                        @elseif($res->justification)
                            <small style="color: #64748b;">{{ Str::limit($res->justification, 50) }}</small>
                        @else
                            <small style="color: #d1d5db;">—</small>
                        @endif
                    </td>
                    <td>
                        @if($res->status == 'EN ATTENTE')
                            <div style="display: flex; gap: 6px;">
                                <form action="{{ route('reservations.update', $res->id) }}" method="POST" style="display: inline;">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="VALIDÉE">
                                    <button type="submit" class="btn btn-success" title="Approuver">
                                        ✓
                                    </button>
                                </form>
                                <button type="button" class="btn btn-danger" onclick="openRefusalModal({{ $res->id }})" title="Refuser">
                                    ✕
                                </button>
                            </div>
                        @else
                            <small style="color: #94a3b8;">{{ $res->updated_at->format('d/m H:i') }}</small>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">
                        Aucune demande à traiter
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SECTION 2: ALERTES & MODÉRATION -->
    <div class="section-title">
        <div class="section-title-left">
            <i class='bx bxs-zap' style="color: #ef4444; font-size: 1.5rem;"></i>
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
                    <td><strong style="color: #ef4444;">{{ $incident->resource->name }}</strong></td>
                    <td style="font-size: 0.9rem; color: #64748b; max-width: 250px;">{{ Str::limit($incident->description, 80) }}</td>
                    <td style="color: #2c3e50;">{{ $incident->user->name }}</td>
                    <td style="color: #94a3b8; font-size: 0.9rem;">{{ $incident->created_at->format('d/m H:i') }}</td>
                    <td>
                        <form action="{{ route('manager.incidents.destroy', $incident->id) }}" method="POST" style="display: inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr?')" title="Clôturer">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">
                        Aucune alerte
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- SECTION 3: GESTION DES RESSOURCES -->
    <div class="section-title">
        <div class="section-title-left">
            <i class='bx bx-hdd' style="color: #3b82f6; font-size: 1.5rem;"></i>
            <span>Mes Ressources Supervisées</span>
        </div>
        <a href="{{ route('tech.resources.create') }}" class="btn btn-primary">
            <i class='bx bx-plus'></i> Ajouter
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
                <td><strong style="color: #2c3e50;">{{ $resource->name }}</strong></td>
                <td><span style="background: #e0e7ff; color: #4f46e5; padding: 3px 8px; border-radius: 15px; font-size: 0.8rem;">{{ $resource->category->name ?? 'N/A' }}</span></td>
                <td style="color: #64748b; font-size: 0.9rem;">{{ $resource->location ?? '—' }}</td>
                <td>
                    <span class="status-badge bg-{{ $resource->status == 'available' ? 'available' : ($resource->status == 'maintenance' ? 'maintenance' : 'inactive') }}">
                        {{ ucfirst($resource->status) }}
                    </span>
                </td>
                <td><strong style="color: #3b82f6;">{{ $reservations->where('resource_id', $resource->id)->count() }}</strong></td>
                <td>
                    <div class="actions-group" style="display: flex; gap: 5px; flex-wrap: wrap;">
                        <a href="{{ route('tech.resources.edit', $resource->id) }}" class="btn btn-warning btn-sm" title="Modifier">
                            <i class='bx bx-edit'></i> Modifier
                        </a>
                        
                        @if($resource->status !== 'maintenance')
                            <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-secondary btn-sm" title="Mettre en maintenance">
                                    <i class='bx bx-wrench'></i> Maintenance
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.toggleMaintenance', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm" title="Activer">
                                    <i class='bx bx-check'></i> Activer
                                </button>
                            </form>
                        @endif

                        @if($resource->status !== 'inactive')
                            <form action="{{ route('tech.resources.deactivate', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm" title="Désactiver">
                                    <i class='bx bx-block'></i> Désactiver
                                </button>
                            </form>
                        @else
                            <form action="{{ route('tech.resources.activate', $resource->id) }}" method="POST" style="display: inline;">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm" title="Réactiver">
                                    <i class='bx bx-check-circle'></i> Réactiver
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">
                    Aucune ressource supervisée
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- MODALE POUR REFUSER UNE DEMANDE -->
<div id="refusalModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 10px; padding: 25px; max-width: 450px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h2 style="margin: 0; color: #2c3e50; font-weight: 800; font-size: 1.15rem;">Refuser la demande</h2>
            <button type="button" onclick="closeRefusalModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #94a3b8;">✕</button>
        </div>

        <form id="refusalForm" method="POST" style="margin: 0;">
            @csrf @method('PUT')
            <input type="hidden" name="status" value="REFUSÉE">

            <div style="margin-bottom: 18px;">
                <label style="display: block; font-weight: 700; color: #2c3e50; margin-bottom: 8px; font-size: 0.9rem;">Motif du refus *</label>
                <textarea name="rejection_reason" placeholder="Décrivez les raisons du refus..." required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-family: 'Segoe UI', system-ui, sans-serif; font-size: 0.9rem; min-height: 100px; resize: vertical; box-sizing: border-box;"></textarea>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeRefusalModal()" class="btn" style="background-color: #e5e7eb; color: #2c3e50;">
                    Annuler
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class='bx bx-block'></i> Refuser
                </button>
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
        document.querySelector('textarea[name=rejection_reason]').focus();
    }

    function closeRefusalModal() {
        document.getElementById('refusalModal').style.display = 'none';
        document.getElementById('refusalForm').reset();
    }

    document.getElementById('refusalModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeRefusalModal();
        }
    });
</script>

@endsection
