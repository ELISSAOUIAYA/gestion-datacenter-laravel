
<style>
 
    :root {
        --bg-body: #020617;
        --bg-card: #0f172a;
        --color-primary: #38bdf8;
        --color-success: #10b981;
        --color-danger: #ef4444;
        --color-warning: #f59e0b;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border-color: rgba(255, 255, 255, 0.1);
        --transition: all 0.3s ease;
    }

    .dashboard-container { 
        padding: 40px 20px; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    }
    
 
    .header-box { 
        background: var(--bg-card); 
        padding: 25px 35px; 
        border-radius: 20px; 
        border: 1px solid var(--border-color);
        margin-bottom: 35px; 
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        backdrop-filter: blur(10px);
    }

    
    .table-wrapper {
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .res-table { width: 100%; border-collapse: collapse; }
    .res-table th { 
        background-color: rgba(255, 255, 255, 0.03); 
        color: var(--color-primary); 
        padding: 18px 20px;
        text-align: left;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        border-bottom: 1px solid var(--border-color);
    }
    .res-table td { 
        padding: 20px; 
        border-bottom: 1px solid var(--border-color); 
        font-size: 0.9rem;
    }
    .res-table tr:last-child td { border-bottom: none; }
    .res-table tr:hover { background-color: rgba(255, 255, 255, 0.01); }
    
    
    .btn { 
        padding: 10px 20px; 
        border-radius: 10px; 
        border: none; 
        cursor: pointer; 
        font-weight: 700; 
        font-size: 0.75rem; 
        text-transform: uppercase; 
        transition: var(--transition); 
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
    }
    .btn-success { background-color: var(--color-success); color: #000; }
    .btn-success:hover { background-color: #059669; transform: translateY(-2px); }
    
    .btn-danger { background-color: rgba(239, 68, 68, 0.2); color: var(--color-danger); border: 1px solid var(--color-danger); }
    .btn-danger:hover { background-color: var(--color-danger); color: #fff; transform: translateY(-2px); }

    .btn-logout { 
        background-color: rgba(255, 255, 255, 0.05); 
        color: var(--text-main); 
        border: 1px solid var(--border-color);
        padding: 10px 20px; 
        border-radius: 12px; 
        font-weight: 600; 
        cursor: pointer; 
        text-decoration: none; 
        display: flex; 
        align-items: center; 
        gap: 10px;
    }
    .btn-logout:hover { background-color: var(--color-danger); border-color: var(--color-danger); }

 
    .status-badge { 
        padding: 6px 14px; border-radius: 10px; font-size: 0.7rem; font-weight: 800; 
        display: inline-flex; align-items: center; gap: 6px;
    }
    .bg-attente { background-color: rgba(245, 158, 11, 0.15); color: var(--color-warning); }
    .bg-validee { background-color: rgba(16, 185, 129, 0.15); color: var(--color-success); }
    .bg-refusee { background-color: rgba(239, 68, 68, 0.15); color: var(--color-danger); }

    .section-title { 
        color: var(--text-main); 
        margin-bottom: 25px; 
        font-weight: 800; 
        font-size: 1.3rem; 
        display: flex; 
        align-items: center; 
        gap: 12px; 
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1); 
        color: var(--color-success); 
        padding: 16px; 
        border-radius: 15px; 
        margin-bottom: 30px; 
        border: 1px solid var(--color-success);
        display: flex; align-items: center; gap: 12px; font-weight: 600;
    }
</style>

<div class="dashboard-container">
    <div class="header-box">
        <div>
            <h1 style="margin:0; font-weight: 800; color: var(--color-primary); font-size: 1.6rem;">
                <i class='bx bxs-dashboard'></i> Espace Responsable
            </h1>
            <p style="margin:5px 0 0; color: var(--text-muted); font-size: 0.9rem;">
                Bienvenue, <strong>{{ Auth::user()->name }}</strong>
            </p>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class='bx bx-log-out-circle'></i> Déconnexion
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class='bx bxs-check-shield' style="font-size: 1.5rem;"></i> {{ session('success') }}
        </div>
    @endif

    <h2 class="section-title"><i class='bx bx-time-five' style="color: var(--color-warning);"></i> Demandes à traiter</h2>
    <div class="table-wrapper">
        <table class="res-table">
            <thead>
                <tr>
                    <th>Demandeur</th>
                    <th>Équipement IT</th>
                    <th>Période</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td>
                            <div style="font-weight: 700; color: var(--text-main);">{{ $res->user->name }}</div>
                            <small style="color: var(--text-muted);">{{ $res->user->email }}</small>
                        </td>
                        <td><strong style="color: var(--color-primary);">{{ $res->resource->name }}</strong></td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                <div><i class='bx bx-calendar-event'></i> Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y H:i') }}</div>
                                <div><i class='bx bx-calendar-check'></i> Au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y H:i') }}</div>
                            </div>
                        </td>
                        <td>
                            @php 
                                $classStatus = $res->status == 'VALIDÉE' ? 'validee' : ($res->status == 'REFUSÉE' ? 'refusee' : 'attente');
                                $icon = $res->status == 'VALIDÉE' ? 'bx-check-double' : ($res->status == 'REFUSÉE' ? 'bx-x-circle' : 'bx-loader-circle');
                            @endphp
                            <span class="status-badge bg-{{ $classStatus }}">
                                <i class='bx {{ $icon }}'></i> {{ $res->status }}
                            </span>
                        </td>
                        <td>
                            @if($res->status == 'EN ATTENTE' || $res->status == 'ATTENTE')
                                <div style="display: flex; gap: 10px;">
                                    <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="VALIDÉE">
                                        <button type="submit" class="btn btn-success"><i class='bx bx-check'></i> Valider</button>
                                    </form>

                                    <form action="{{ route('reservations.update', $res->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="REFUSÉE">
                                        <button type="submit" class="btn btn-danger"><i class='bx bx-block'></i> Refuser</button>
                                    </form>
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.75rem; font-style: italic; display: flex; align-items: center; gap: 5px;">
                                    <i class='bx bx-lock-alt'></i> Dossier traité
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align: center; padding: 60px; color: var(--text-muted);">Aucune demande en attente.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h2 class="section-title"><i class='bx bxs-zap' style="color: var(--color-danger);"></i> Alertes Incidents</h2>
    <div class="table-wrapper">
        <table class="res-table">
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Détails</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incidents as $incident)
                    <tr>
                        <td><span style="color: var(--color-danger); font-weight: 800;">{{ $incident->resource->name }}</span></td>
                        <td style="max-width: 300px; color: var(--text-muted); font-size: 0.85rem;">{{ $incident->description }}</td>
                        <td style="color: var(--text-muted); font-size: 0.8rem;"><i class='bx bx-time'></i> {{ $incident->created_at->format('d/m H:i') }}</td>
                        <td>
                            <form action="{{ route('manager.incidents.destroy', $incident->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la résolution ?')">
                                    <i class='bx bx-check-shield'></i> Résolu
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align: center; padding: 60px; color: var(--text-muted);">Aucun incident signalé.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
