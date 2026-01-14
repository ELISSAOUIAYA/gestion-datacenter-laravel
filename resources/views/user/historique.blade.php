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
                            <th>Période</th>
                            <th>Ressource</th>
                            <th>Statut</th>
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
                               @if($reservation->status == 'pending')
                            <span class="status-badge bg-pending">EN ATTENTE</span>
                             @elseif($reservation->status == 'approved')
                             <span class="status-badge bg-approved" style="background-color: #2ecc71; color: white; padding: 5px 10px; border-radius: 4px;">Validée</span>
                        @elseif($reservation->status == 'rejected')
                              <span class="status-badge bg-rejected" style="background-color: #e74c3c; color: white; padding: 5px 10px; border-radius: 4px;">Refusée</span>
                            @endif
                              </td>
                               <td>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette opération de votre historique ?');">
                                 @csrf
                                     @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" style="background-color: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">
                                    <i class='bx bx-trash'></i> Supprimer
                                     </button>
                                     </form>
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