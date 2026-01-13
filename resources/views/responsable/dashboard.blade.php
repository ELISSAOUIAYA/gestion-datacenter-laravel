@extends('layouts.app')

@section('content')
<style>
    /* Design sans Bootstrap */
    .dashboard-container { padding: 20px; font-family: sans-serif; }
    .res-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .res-table th, .res-table td { padding: 12px; border: 1px solid #eee; text-align: left; }
    .res-table th { background-color: #2c3e50; color: white; text-transform: uppercase; font-size: 12px; }
    .btn { padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; font-weight: bold; font-size: 12px; }
    .btn-success { background-color: #27ae60; color: white; }
    .btn-danger { background-color: #e74c3c; color: white; margin-left: 5px; }
    .status-badge { padding: 4px 8px; border-radius: 12px; font-size: 11px; color: white; background: #95a5a6; }
</style>

<div class="dashboard-container">
    <h1><i class='bx bxs-dashboard'></i> Dashboard Technique</h1>
    <p>Bienvenue, <strong>{{ Auth::user()->name }}</strong>. Voici les demandes en attente :</p>

    <table class="res-table">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Ressource demandée</th>
                <th>Date début</th>
                <th>Statut actuel</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
                <tr>
                    <td>{{ $res->user->name }}</td>
                    <td><strong>{{ $res->resource->name }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y') }}</td>
                    <td><span class="status-badge">{{ $res->status }}</span></td>
                    <td>
                        @if($res->status == 'en_attente')
                            <div style="display: flex;">
                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="validée">
                                    <button type="submit" class="btn btn-success">Accepter</button>
                                </form>

                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="refusée">
                                    <button type="submit" class="btn btn-danger">Refuser</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #7f8c8d; font-style: italic;">Déjà traitée</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">Aucune demande de réservation pour le moment.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection