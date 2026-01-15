@extends('layouts.app')

@section('content')
<style>
    /* Structure Globale */
    .dashboard-container { padding: 30px; font-family: 'Segoe UI', system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    
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
    .btn-success:hover { background-color: #16a34a; transform: translateY(-2px); }
    .btn-danger { background-color: #ef4444; color: white; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.2); }
    .btn-danger:hover { background-color: #dc2626; transform: translateY(-2px); }

    /* BADGES HAUTE VISIBILITÉ */
    .status-badge { 
        padding: 8px 16px; border-radius: 50px; font-size: 11px; font-weight: 800; 
        color: white; text-transform: uppercase; letter-spacing: 0.5px;
        display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .bg-attente { background-color: #f59e0b !important; border: 2px solid #d97706; color: #ffffff !important; }
    .bg-validee { background-color: #10b981 !important; border: 2px solid #059669; color: #ffffff !important; }
    .bg-refusee { background-color: #ef4444 !important; border: 2px solid #dc2626; color: #ffffff !important; }

    .btn-logout { background-color: #1e293b; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-size: 13px; font-weight: bold; cursor: pointer; transition: 0.3s; text-decoration: none; display: flex; align-items: center; gap: 8px; }
    .btn-logout:hover { background-color: #0f172a; }

    .section-title { color: #1e293b; margin-bottom: 20px; font-weight: 800; font-size: 1.25rem; display: flex; align-items: center; gap: 10px; }
</style>

<div class="dashboard-container">
    <div class="header-box">
        <div>
            <h1 style="margin:0; font-weight: 800; color: #2c3e50;"><i class='bx bxs-dashboard'></i> Espace Responsable</h1>
            <p style="margin:5px 0 0; color: #64748b;">Connecté en tant que : <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class='bx bx-log-out-circle'></i> Déconnexion
            </button>
        </form>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 16px; border-radius: 12px; margin-bottom: 25px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 12px; font-weight: 600;">
            <i class='bx bxs-check-shield' style="font-size: 1.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    <h2 class="section-title"><i class='bx bx-time-five' style="color: #f59e0b;"></i> Demandes à traiter</h2>
    <table class="res-table">
        <thead>
            <tr>
                <th>Demandeur</th>
                <th>Équipement IT</th>
                <th>Période Demandée</th>
                <th>État Actuel</th>
                <th>Actions de décision</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
                <tr>
                    <td>
                        <div style="font-weight: 700;">{{ $res->user->name }}</div>
                        <small style="color: #64748b;">{{ $res->user->email }}</small>
                    </td>
                    <td><strong style="color: #2c3e50;">{{ $res->resource->name }}</strong></td>
                    <td>
                        <div style="font-size: 0.85rem;">
                            <i class='bx bx-right-arrow-alt'></i> Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y H:i') }}<br>
                            <i class='bx bx-left-arrow-alt'></i> Au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y H:i') }}
                        </div>
                    </td>
                    <td>
                        @php 
                            $classStatus = $res->status == 'VALIDÉE' ? 'validee' : ($res->status == 'REFUSÉE' ? 'refusee' : 'attente');
                            $icon = $res->status == 'VALIDÉE' ? 'bx-check-double' : ($res->status == 'REFUSÉE' ? 'bx-x-circle' : 'bx-loader-circle');
                        @endphp
                        <span class="status-badge bg-{{ $classStatus }}">
                            <i class='bx {{ $icon }}'></i> {{ $res->status }}
                        </span>
                    </td>
                    <td>
                        @if($res->status == 'EN ATTENTE' || $res->status == 'ATTENTE')
                            <div style="display: flex; gap: 10px;">
                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="VALIDÉE">
                                    <button type="submit" class="btn btn-success"><i class='bx bx-check'></i> Valider</button>
                                </form>

                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="REFUSÉE">
                                    <button type="submit" class="btn btn-danger"><i class='bx bx-block'></i> Refuser</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #94a3b8; font-size: 0.8rem; font-style: italic; display: flex; align-items: center; gap: 5px;">
                                <i class='bx bx-lock-alt'></i> Dossier traité
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center; padding: 50px; color: #94a3b8;">Aucune nouvelle demande dans la file d'attente.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2 class="section-title"><i class='bx bxs-zap' style="color: #ef4444;"></i> Alertes Incidents</h2>
    <table class="res-table">
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Détails du problème</th>
                <th>Signalé le</th>
                <th>Maintenance</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidents as $incident)
                <tr>
                    <td><span style="color: #ef4444; font-weight: 800;">{{ $incident->resource->name }}</span></td>
                    <td style="max-width: 300px; color: #475569; font-size: 0.9rem;">{{ $incident->description }}</td>
                    <td><i class='bx bx-time'></i> {{ $incident->created_at->format('d/m/Y à H:i') }}</td>
                    <td>
                        <form action="{{ route('manager.incidents.destroy', $incident->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la résolution de l\'incident ?')">
                                <i class='bx bx-check-shield'></i> Marquer Résolu
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; padding: 50px; color: #94a3b8;">Parfait ! Aucun incident technique n'est actuellement signalé.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection