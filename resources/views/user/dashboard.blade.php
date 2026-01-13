@extends('layouts.app')

@section('content')
<style>
    .user-dashboard { padding: 30px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; min-height: 100vh; }
    .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 20px; }
    
    /* Styles du Tableau */
    .res-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .res-table th { text-align: left; padding: 12px; background: #f1f3f5; color: #495057; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
    .res-table td { padding: 15px 12px; border-bottom: 1px solid #dee2e6; vertical-align: middle; }
    
    /* Badges de Statut */
    .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; color: white; }
    .status-en_attente { background-color: #f1c40f; }
    .status-validée { background-color: #27ae60; }
    .status-refusée { background-color: #e74c3c; }
    
    .btn-incident { background: #e74c3c; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 11px; display: inline-block; }
    .btn-incident:hover { background: #c0392b; }
</style>

<div class="user-dashboard">
    <div class="header-section">
        <div>
            <h1>Mon Espace IT</h1>
            <p>Bienvenue, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <a href="{{ route('welcome') }}" style="background: #3498db; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
            + Nouvelle Réservation
        </a>
    </div>

    <div class="card">
        <h3><i class='bx bx-history'></i> Suivi de mes demandes</h3>
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
                    <td><small>{{ $res->justification ?? 'Aucune justification' }}</small></td>
                    <td>
                        <span class="badge status-{{ $res->status }}">
                            {{ ucfirst(str_replace('_', ' ', $res->status)) }}
                        </span>
                    </td>
                    <td>
                        @if($res->status == 'validée')
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
                    <td colspan="5" style="text-align: center; padding: 30px; color: #6c757d;">
                        Vous n'avez aucune réservation pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection