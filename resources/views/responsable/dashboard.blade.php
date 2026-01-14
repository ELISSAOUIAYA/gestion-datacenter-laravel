@extends('layouts.app')

@section('content')
<style>
    /* Design sans Bootstrap */
    .dashboard-container { padding: 30px; font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    
    .header-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 25px; border-left: 5px solid #2c3e50; }
    
    .res-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .res-table th, .res-table td { padding: 15px; border-bottom: 1px solid #eee; text-align: left; }
    .res-table th { background-color: #2c3e50; color: white; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
    
    .btn { padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; font-weight: bold; font-size: 11px; text-transform: uppercase; transition: 0.3s; }
    .btn-success { background-color: #27ae60; color: white; }
    .btn-success:hover { background-color: #219150; }
    .btn-danger { background-color: #e74c3c; color: white; margin-left: 5px; }
    .btn-danger:hover { background-color: #c0392b; }
    
    .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; color: white; text-transform: uppercase; }
    .bg-pending { background-color: #f1c40f; }
    .bg-approved { background-color: #2ecc71; }
    .bg-rejected { background-color: #e74c3c; }
</style>

<div class="dashboard-container">
    <div class="header-box">
        <h1 style="margin:0;"><i class='bx bxs-dashboard'></i> Dashboard Technique</h1>
        <p style="margin:5px 0 0; color: #7f8c8d;">Bienvenue, <strong>{{ Auth::user()->name }}</strong>. Gestion des réservations en attente.</p>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    <table class="res-table">
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Ressource demandée</th>
                <th>Période</th>
                <th>Statut actuel</th>
                <th>Actions de décision</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
                <tr>
                    <td>
                        <i class='bx bxs-user-circle'></i> {{ $res->user->name }}<br>
                        <small style="color: #95a5a6;">{{ $res->user->email }}</small>
                    </td>
                    <td><strong>{{ $res->resource->name }}</strong></td>
                    <td>
                        <small>Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y') }}<br>
                        au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        <span class="status-badge bg-{{ $res->status }}">
                            @if($res->status == 'pending') EN ATTENTE
                            @elseif($res->status == 'approved') VALIDÉE
                            @elseif($res->status == 'rejected') REFUSÉE
                            @else {{ $res->status }} @endif
                        </span>
                    </td>
                    <td>
                        {{-- On n'affiche les boutons que si le statut est 'pending' --}}
                        @if($res->status == 'pending')
                            <div style="display: flex;">
                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-success">✅ Accepter</button>
                                </form>

                                <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-danger">❌ Refuser</button>
                                </form>
                            </div>
                        @else
                            <span style="color: #bdc3c7; font-size: 11px; font-style: italic;">
                                <i class='bx bx-check-double'></i> Traitée
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #95a5a6;">
                        <i class='bx bx-info-circle' style="font-size: 20px;"></i><br>
                        Aucune demande de réservation à traiter pour le moment.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection