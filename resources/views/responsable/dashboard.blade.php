@extends('layouts.app')

@section('content')
<style>
    .dashboard-container { padding: 30px; font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    .header-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 25px; border-left: 5px solid #2c3e50; }
    .res-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-bottom: 40px; }
    .res-table th, .res-table td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
    .res-table th { background-color: #2c3e50; color: white; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
    .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; font-weight: bold; font-size: 11px; text-transform: uppercase; transition: 0.3s; }
    .btn-success { background-color: #27ae60; color: white; }
    .btn-danger { background-color: #e74c3c; color: white; }
    .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; color: white; text-transform: uppercase; }
    .bg-pending { background-color: #f1c40f; }
    .bg-approved { background-color: #2ecc71; }
    .bg-rejected { background-color: #e74c3c; }
    .btn-logout {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-logout:hover {
    background-color: #c0392b;
}
</style>

<div class="dashboard-container">
    <div class="header-box">
        <h1 style="margin:0;"><i class='bx bxs-dashboard'></i> Dashboard Responsable</h1>
        <p style="margin:5px 0 0; color: #7f8c8d;">Gestion des réservations et des incidents.</p>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn-logout">
        <i class='bx bx-log-out'></i> Déconnexion
    </button>
</form>

    <h2 style="color: #2c3e50;"><i class='bx bx-list-ul'></i> Demandes de réservations</h2>
<table class="res-table">
    <thead>
        <tr>
            <th>Utilisateur</th>
            <th>Ressource</th>
            <th>Période</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reservations as $res)
            <tr>
                <td>{{ $res->user->name }}</td>
                <td><strong>{{ $res->resource->name }}</strong></td>
                <td>Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m') }} au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m') }}</td>
                <td>
                    {{-- Affichage du badge standardisé en Français --}}
                    <span class="status-badge bg-{{ $res->status }}">
                        @if($res->status == 'pending') 
                            EN ATTENTE 
                        @elseif($res->status == 'approved') 
                            VALIDÉE 
                        @elseif($res->status == 'rejected') 
                            REFUSÉE 
                        @else 
                            {{ strtoupper($res->status) }} 
                        @endif
                    </span>
                </td>
                <td>
                    @if($res->status == 'pending')
                        <div style="display: flex; gap: 5px;">
                            {{-- Bouton pour Valider --}}
                            <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-success">Valider</button>
                            </form>
                            {{-- Bouton pour Refuser --}}
                            <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger">Refuser</button>
                            </form>
                        </div>
                    @else
                        <small style="color: #95a5a6; font-style: italic;">Traité</small>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align: center; padding: 20px;">Aucune réservation.</td></tr>
        @endforelse
    </tbody>
</table>

    <h2 style="color: #c0392b;"><i class='bx bx-error'></i> Incidents signalés</h2>
    <table class="res-table">
        <thead>
            <tr>
                <th>Ressource</th>
                <th>Description</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidents as $incident)
                <tr>
                    <td><strong>{{ $incident->resource->name }}</strong></td>
                    <td>{{ $incident->description }}</td>
                    <td>{{ $incident->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('manager.incidents.destroy', $incident->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; padding: 20px;">Aucun incident à signaler.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection