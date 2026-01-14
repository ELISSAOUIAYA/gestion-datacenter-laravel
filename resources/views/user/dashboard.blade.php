@extends('layouts.app')

@section('content')
<style>
    /* Structure Globale */
    .user-dashboard { 
        padding: 30px; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        background-color: #f8f9fa; 
        min-height: 100vh; 
    }
    
    /* En-tête (Zone de Navigation) */
    .header-section { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 30px; 
        background: white; 
        padding: 20px 30px; 
        border-radius: 12px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .nav-group { display: flex; align-items: center; gap: 20px; }
    
    .nav-link { 
        color: #2c3e50; 
        text-decoration: none; 
        font-weight: 600; 
        font-size: 14px; 
    }
    .nav-link:hover { color: #3498db; }
    
    .btn-logout { 
        background: #fff5f5; 
        color: #e74c3c; 
        border: 1px solid #fed7d7; 
        padding: 8px 15px; 
        border-radius: 8px; 
        cursor: pointer; 
        font-weight: bold; 
    }
    .btn-logout:hover { background: #e74c3c; color: white; }

    /* Carte et Tableau */
    .card { 
        background: white; 
        padding: 25px; 
        border-radius: 12px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
    }
    
    .res-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .res-table th { 
        text-align: left; 
        padding: 12px; 
        background: #f1f3f5; 
        color: #495057; 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px; 
    }
    .res-table td { 
        padding: 15px 12px; 
        border-bottom: 1px solid #dee2e6; 
        vertical-align: middle; 
        font-size: 14px;
    }
    
    /* Badges de Statut (Base de données) */
    .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; color: white; display: inline-block; }
    .status-pending { background-color: #f1c40f; }  /* Jaune pour En attente */
    .status-approved { background-color: #27ae60; } /* Vert pour Validée */
    .status-rejected { background-color: #e74c3c; } /* Rouge pour Refusée */
    
    .btn-incident { 
        background: #e74c3c; 
        color: white; 
        padding: 6px 12px; 
        border-radius: 6px; 
        text-decoration: none; 
        font-size: 11px; 
        font-weight: bold; 
    }
</style>

<div class="user-dashboard">
    <div class="header-section">
        <div>
            <h1 style="margin:0; font-size: 22px; color: #2c3e50;">Mon Espace IT</h1>
            <p style="margin:5px 0 0; color: #7f8c8d;">Utilisateur : <strong>{{ Auth::user()->name }}</strong></p>
        </div>

        <div class="nav-group">
            <a href="{{ route('welcome') }}" class="nav-link">🏠 Accueil</a>
            <a href="{{ route('user.dashboard') }}" class="nav-link" style="color: #3498db; border-bottom: 2px solid #3498db;">📊 Dashboard</a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">DÉCONNEXION</button>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Mes Réservations</h1>
    <a href="{{ route('user.historique') }}" class="btn btn-info" style="background-color: #3498db; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">
        <i class='bx bx-history'></i> Voir mon Historique
    </a>


    
     </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin:0;">Suivi de mes demandes</h3>
            <a href="{{ route('welcome') }}" style="background: #3498db; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 13px;">
                + Nouvelle Réservation
            </a>
        </div>

        <table class="res-table">
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Période</th>
                    <th>Justification</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr>
                    <td><strong>{{ $res->resource->name }}</strong></td>
                    <td>Du {{ $res->start_date }} au {{ $res->end_date }}</td>
                    <td><small>{{ $res->justification ?? '---' }}</small></td>
                    <td>
                        <span class="badge status-{{ $res->status }}">
                            @if($res->status == 'pending') En attente
                            @elseif($res->status == 'approved') Validée
                            @elseif($res->status == 'rejected') Refusée
                            @else {{ $res->status }} @endif
                        </span>
                    </td>
                    <td>
                        @if($res->status == 'approved')
                            <a href="{{ route('incidents.create', ['resource_id' => $res->resource_id]) }}" class="btn-incident">
                                ⚠️ Signaler Incident
                            </a>
                        @else
                            <span style="color: #adb5bd; font-size: 11px;">Aucune action</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #6c757d;">
                        Vous n'avez aucune réservation enregistrée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection