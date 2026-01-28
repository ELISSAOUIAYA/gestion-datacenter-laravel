
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

    /* Grille des cartes de résumé */
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
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    
    .summary-card:hover {
        transform: translateY(-5px);
        border-color: rgba(56, 189, 248, 0.3);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-info p { 
        color: var(--text-muted); 
        font-size: 0.7rem; 
        font-weight: 800; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        margin: 0;
    }
    .stat-info h2 { font-size: 1.8rem; font-weight: 800; margin: 5px 0 0 0; }

    /* Section Occupation par Ressource */
    .occupancy-section { 
        background: var(--bg-card); 
        padding: 35px; 
        border-radius: 24px; 
        border: 1px solid var(--border); 
    }
    .occupancy-section h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 30px; }

    .resource-item { margin-bottom: 25px; }
    
    .resource-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .resource-name { font-weight: 700; font-size: 1rem; }
    .resource-count { color: var(--text-muted); font-size: 0.85rem; margin-left: 8px; font-weight: 400; }
    .resource-pct { color: var(--primary); font-weight: 800; font-size: 1rem; }

    .progress-track { 
        height: 10px; 
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 20px; 
        overflow: hidden; 
    }
    .progress-fill { 
        height: 100%; 
        background: var(--primary); 
        box-shadow: 0 0 15px rgba(56, 189, 248, 0.4);
        border-radius: 20px; 
        transition: width 1.5s cubic-bezier(0.1, 0, 0.1, 1);
    }
</style>

<div class="stats-page">
    <div class="container-stats">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class='bx bx-left-arrow-alt'></i> RETOUR AU DASHBOARD
        </a>

        <h1>Statistiques <span>Globales</span></h1>

        <div class="stats-grid">
            <div class="summary-card">
                <div class="stat-icon" style="background: rgba(168, 85, 247, 0.1); color: var(--purple);">
                    <i class='bx bx-list-ul'></i>
                </div>
                <div class="stat-info">
                    <p>Total Réservations</p>
                    <h2>{{ $totalReservations }}</h2>
                </div>
            </div>

            <div class="summary-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                    <i class='bx bx-time'></i>
                </div>
                <div class="stat-info">
                    <p>En Attente</p>
                    <h2 style="color: var(--warning);">{{ $pendingReservations }}</h2>
                </div>
            </div>

            <div class="summary-card">
                <div class="stat-icon" style="background: rgba(34, 197, 94, 0.1); color: var(--success);">
                    <i class='bx bx-check-circle'></i>
                </div>
                <div class="stat-info">
                    <p>Validées / Actives</p>
                    <h2 style="color: var(--success);">{{ $activeReservations }}</h2>
                </div>
            </div>

            <div class="summary-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                    <i class='bx bx-x-circle'></i>
                </div>
                <div class="stat-info">
                    <p>Refusées</p>
                    <h2 style="color: var(--danger);">{{ $rejectedReservations }}</h2>
                </div>
            </div>
        </div>

        <div class="occupancy-section">
            <h2>Taux d'occupation par Ressource</h2>

            @foreach($resourceOccupancy as $resource)
            <div class="resource-item">
                <div class="resource-header">
                    <div>
                        <span class="resource-name">{{ $resource['name'] }}</span>
                        <span class="resource-count">({{ $resource['reservations_count'] }} réservations validées)</span>
                    </div>
                    <span class="resource-pct">{{ $resource['occupancy'] }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $resource['occupancy'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection