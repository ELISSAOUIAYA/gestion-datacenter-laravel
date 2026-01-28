
@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;
        --primary-hover: #0ea5e9;
        --bg-body: #020617;
        --bg-card: #0f172a;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --danger: #ef4444;
        --success: #22c55e;
        --info: #3b82f6;
    }

    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        padding: 40px 0; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
    }

    /* --- EN-TÊTE DE PAGE --- */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 40px 30px 40px;
    }

    .page-header h1 { font-weight: 800; letter-spacing: -1.5px; margin: 0; }
    .page-header h1 i { color: var(--primary); margin-right: 10px; }

    /* --- BOUTONS NAVIGATION (PILL) --- */
    .header-actions { display: flex; gap: 12px; }

    .btn-nav {
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        text-transform: uppercase;
        border: none;
        white-space: nowrap;
    }
    .btn-back { background-color: #1e293b; color: var(--text-muted); border: 1px solid var(--border); }
    .btn-create { background-color: var(--success); color: #020617; }
    
    .btn-nav:hover { transform: translateY(-2px); filter: brightness(1.1); box-shadow: 0 10px 15px rgba(0,0,0,0.3); }

    /* --- SECTION TABLEAU (Bord à Bord) --- */
    .section-card { 
        background: var(--bg-card); 
        padding: 20px 40px; 
        margin-bottom: 30px; 
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        border-left: none;
        border-right: none;
        width: 100%;
        border-radius: 0;
    }

    .table { width: 100%; border-collapse: collapse; }
    .table th { 
        background: rgba(255, 255, 255, 0.03); 
        padding: 15px 20px; 
        text-align: left; 
        font-size: 0.7rem; 
        color: var(--text-muted); 
        text-transform: uppercase; 
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }
    .table td { padding: 18px 20px; border-top: 1px solid var(--border); vertical-align: middle; color: var(--text-main); font-size: 0.9rem; }
    .table tr:hover { background: rgba(56, 189, 248, 0.02); }

    /* Colonnes Spécifiques */
    .col-resource { color: var(--primary); font-weight: 700; }
    .col-date { color: var(--text-muted); font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; }
    .col-desc { font-size: 0.85rem; max-width: 400px; color: #cbd5e1; }

    /* --- ACTIONS COMPACTES --- */
    .col-actions { width: 1%; white-space: nowrap; text-align: center; }
    .btn-group-actions { display: flex; gap: 8px; justify-content: center; }

    .btn-action {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-edit { background-color: var(--info); color: white; }
    .btn-delete { background-color: var(--danger); color: white; }
    .btn-action:hover { opacity: 0.9; transform: scale(1.05); }

    /* --- PAGINATION --- */
    .pagination-container { padding: 20px 40px; }
    /* Adaptation des liens de pagination de Laravel au mode sombre */
    .pagination-container nav svg { width: 20px; }
    .pagination-container nav div { color: var(--text-muted) !important; }
</style>

<div class="admin-body">
    <div class="page-header">
        <h1><i class='bx bx-wrench'></i> Maintenances Planifiées</h1>
        <div class="header-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn-nav btn-back">
                <i class='bx bx-left-arrow-alt'></i> Dashboard
            </a>
            <a href="{{ route('admin.maintenances.create') }}" class="btn-nav btn-create">
                <i class='bx bx-plus'></i> Nouvelle Maintenance
            </a>
        </div>
    </div>

    <div class="section-card">
        <table class="table">
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Description de l'intervention</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $maintenance)
                <tr>
                    <td class="col-resource">
                        {{ $maintenance->resource->name ?? 'N/A' }}
                    </td>
                    <td class="col-date">
                        <i class='bx bx-calendar-event'></i> {{ $maintenance->start_date->format('d/m/Y H:i') }}
                    </td>
                    <td class="col-date">
                        <i class='bx bx-calendar-check'></i> {{ $maintenance->end_date->format('d/m/Y H:i') }}
                    </td>
                    <td class="col-desc">
                        {{ $maintenance->description ?? '-' }}
                    </td>
                    <td class="col-actions">
                        <div class="btn-group-actions">
                            <a href="{{ route('admin.maintenances.edit', $maintenance) }}" class="btn-action btn-edit">
                                <i class='bx bx-edit-alt'></i> Éditer
                            </a>
                            <form method="POST" action="{{ route('admin.maintenances.destroy', $maintenance) }}" onsubmit="return confirm('Supprimer cette maintenance définitivement ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <i class='bx bx-trash'></i> Suppr
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: var(--text-muted);">
                        <i class='bx bx-info-circle' style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                        Aucune maintenance planifiée dans le système
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($maintenances->hasPages())
    <div class="pagination-container">
        {{ $maintenances->links() }}
    </div>
    @endif
</div>
@endsection