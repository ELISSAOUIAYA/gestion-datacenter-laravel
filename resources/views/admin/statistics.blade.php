@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <a href="{{ route('admin.dashboard') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 1.5rem;">
            ← Tableau de Bord
        </a>

        <h1 style="margin: 0 0 2rem 0; color: #1a1a1a;">Statistiques Globales</h1>

        <!-- Cartes de résumé -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #9b59b6;">
                <p style="color: #999; margin: 0; font-size: 0.9rem; text-transform: uppercase; font-weight: 600;">Réservations Totales</p>
                <h2 style="color: #1a1a1a; margin: 0.5rem 0; font-size: 2rem;">{{ $totalReservations }}</h2>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #e74c3c;">
                <p style="color: #999; margin: 0; font-size: 0.9rem; text-transform: uppercase; font-weight: 600;">En Attente</p>
                <h2 style="color: #1a1a1a; margin: 0.5rem 0; font-size: 2rem;">{{ $pendingReservations }}</h2>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #2ecc71;">
                <p style="color: #999; margin: 0; font-size: 0.9rem; text-transform: uppercase; font-weight: 600;">Actives</p>
                <h2 style="color: #1a1a1a; margin: 0.5rem 0; font-size: 2rem;">{{ $activeReservations }}</h2>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #95a5a6;">
                <p style="color: #999; margin: 0; font-size: 0.9rem; text-transform: uppercase; font-weight: 600;">Refusées</p>
                <h2 style="color: #1a1a1a; margin: 0.5rem 0; font-size: 2rem;">{{ $rejectedReservations }}</h2>
            </div>
        </div>

        <!-- Occupation par ressource -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h2 style="color: #1a1a1a; margin: 0 0 1.5rem 0;">Taux d'Occupation par Ressource</h2>
            <div style="display: grid; gap: 1rem;">
                @foreach($resourceOccupancy as $item)
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <strong style="color: #333;">{{ $item['name'] }}</strong>
                        <span style="color: #666;">{{ $item['occupancy'] }}%</span>
                    </div>
                    <div style="height: 8px; background: #ecf0f1; border-radius: 4px;">
                        <div style="height: 100%; background: #3498db; width: {{ $item['occupancy'] }}%; border-radius: 4px;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
