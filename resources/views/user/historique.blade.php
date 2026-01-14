@extends('layouts.app') 

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class='bx bx-history'></i> Mon Historique de Réservations</h2>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class='bx bx-arrow-back'></i> Retour au Dashboard
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <a href="?sort=start_date&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}" class="text-white text-decoration-none">
                                    Période <i class='bx bx-sort'></i>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=resource_id&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}" class="text-white text-decoration-none">
                                    Ressource <i class='bx bx-laptop'></i>
                                </a>
                            </th>
                            <th>
                                <a href="?sort=status&order={{ request('order') == 'asc' ? 'desc' : 'asc' }}" class="text-white text-decoration-none">
                                    Statut <i class='bx bx-info-circle'></i>
                                </a>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td>
                                    Du {{ \Carbon\Carbon::parse($reservation->start_date)->format('d/m/Y') }}<br>
                                    au {{ \Carbon\Carbon::parse($reservation->end_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <strong>{{ $reservation->resource->name }}</strong>
                                </td>
                                <td>
                                    @if($reservation->status == 'validée')
                                        <span class="badge bg-success">Validée</span>
                                    @elseif($reservation->status == 'en_attente')
                                        <span class="badge bg-warning text-dark">En attente</span>
                                    @else
                                        <span class="badge bg-danger">Refusée</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Ajoute ici un bouton si tu veux permettre d'annuler une réservation en attente --}}
                                    <button class="btn btn-sm btn-outline-primary"><i class='bx bx-show'></i> Détails</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Vous n'avez effectué aucune réservation pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection