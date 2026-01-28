
@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #38bdf8;
        --bg-body: #020617;
        --bg-card: #0f172a;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --success: #22c55e;
        --danger: #ef4444;
        --warning: #f59e0b;
        --purple: #a855f7;
    }

    .stats-page {
        background-color: var(--bg-body);
        color: var(--text-main);
        min-height: 100vh;
        padding: 40px 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .container-stats { max-width: 1200px; margin: 0 auto; }

    /* Bouton Retour */
    .btn-back {
        background: rgba(255, 255, 255, 0.03);
        color: var(--text-muted);
        padding: 12px 24px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border);
        margin-bottom: 30px;
        transition: 0.3s;
    }
    .btn-back:hover { 
        background: var(--primary); 
        color: #020617; 
        border-color: var(--primary);
    }

    h1 { font-size: 2.5rem; font-weight: 800; letter-spacing: -1.5px; margin-bottom: 40px; }
    h1 span { color: var(--primary); }

    /* Cards de Résumé */
    .stats-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
        gap: 20px; 
        margin-bottom: 40px; 
    }
    .summary-card { 
        background: var(--bg-card); 
        padding: 25px; 
        border-radius: 20px; 
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
    }
    .summary-card::after {
        content: ""; position: absolute; top: 0; left: 0; width: 4px; height: 100%;
    }
    .summary-card.total::after { background: var(--purple); }
    .summary-card.pending::after { background: var(--warning); }
    .summary-card.active::after { background: var(--success); }
    .summary-card.rejected::after { background: var(--danger); }

    .summary-card p { 
        color: var(--text-muted); 
        font-size: 0.75rem; 
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
    }
    .summary-card h2 { font-size: 2.2rem; font-weight: 800; margin-top: 10px; }

    /* Section Occupation */
    .occupancy-section { 
        background: var(--bg-card); 
        padding: 35px; 
        border-radius: 24px; 
        border: 1px solid var(--border); 
    }
    .occupancy-section h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 30px; }

    .resource-item { margin-bottom: 25px; }
    .resource-info { 
        display: flex; 
        justify-content: space-between; 
        margin-bottom: 10px; 
        font-weight: 600; 
    }
    .progress-track { 
        height: 10px; 
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 20px; 
        overflow: hidden; 
    }
    .progress-fill { 
        height: 100%; 
        background: var(--primary); 
        box-shadow: 0 0 15px var(--primary);
        border-radius: 20px; 
        transition: width 1s ease-in-out;
    }
</style>



<div class="stats-page">
    <div class="container-stats">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class='bx bx-left-arrow-alt'></i> RETOUR AU DASHBOARD
        </a>

        <h1>Statistiques <span>Globales</span></h1>

        <div class="stats-grid">
            <div class="summary-card total">
                <p>Réservations Totales</p>
                <h2>{{ $totalReservations }}</h2>
            </div>
            <div class="summary-card pending">
                <p>En Attente</p>
                <h2 style="color: var(--warning);">{{ $pendingReservations }}</h2>
            </div>
            <div class="summary-card active">
                <p>Actives</p>
                <h2 style="color: var(--success);">{{ $activeReservations }}</h2>
            </div>
            <div class="summary-card rejected">
                <p>Refusées</p>
                <h2 style="color: var(--danger);">{{ $rejectedReservations }}</h2>
            </div>
        </div>

        <div class="occupancy-section">
            <h2><i class='bx bx-line-chart' style="color: var(--primary);"></i> Taux d'Occupation par Ressource</h2>
            <div style="display: grid; gap: 5px;">
                @foreach($resourceOccupancy as $item)
                <div class="resource-item">
                    <div class="resource-info">
                        <span style="color: var(--text-main);">{{ $item['name'] }}</span>
                        <span style="color: var(--primary);">{{ $item['occupancy'] }}%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: {{ $item['occupancy'] }}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection