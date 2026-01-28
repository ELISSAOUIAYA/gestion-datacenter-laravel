@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --primary-hover: #0ea5e9;
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Fond des sections */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.08);
        --input-bg: #1e293b;        /* Fond des champs */
        --danger: #ef4444;
        --success: #22c55e;
        --warning: #f59e0b;
    }

    body { 
        margin: 0; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

    /* BOUTON RETOUR */
    .back-button { margin-bottom: 25px; }
    
    /* HEADER SECTION */
    .header {
        background: var(--bg-card);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        border-left: 6px solid var(--primary);
        border-top: 1px solid var(--border);
        border-right: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }
    .header h1 { font-size: 1.8rem; margin-bottom: 8px; font-weight: 800; }
    .header p { color: var(--text-muted); font-size: 0.95rem; }

    /* FILTERS SECTION */
    .filters-section {
        background: var(--bg-card);
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        border: 1px solid var(--border);
    }
    .filters-title { 
        font-size: 1rem; 
        font-weight: 800; 
        margin-bottom: 20px; 
        color: var(--primary); 
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .filter-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 0.8rem;
        color: var(--text-muted);
        text-transform: uppercase;
    }
    
    .filter-group select, .filter-group input {
        width: 100%;
        padding: 12px;
        background: var(--input-bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        color: white;
        font-size: 0.9rem;
        outline: none;
        transition: 0.3s;
    }
    .filter-group select:focus, .filter-group input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    /* TABLE STYLE */
    .table-wrapper {
        background: var(--bg-card);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }
    
    table { width: 100%; border-collapse: separate; border-spacing: 0; }
    thead th {
        background: rgba(255, 255, 255, 0.03);
        color: var(--primary);
        padding: 18px;
        text-align: left;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }
    
    tbody td {
        padding: 18px;
        border-bottom: 1px solid var(--border);
        color: var(--text-main);
        font-size: 0.9rem;
    }
    
    tbody tr:hover { background: rgba(255, 255, 255, 0.02); }
    tbody tr:last-child td { border-bottom: none; }

    /* STATUS BADGES */
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .status-EN-ATTENTE, .status-ATTENTE { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
    .status-VALIDÉE { background: rgba(34, 197, 94, 0.2); color: var(--success); }
    .status-REFUSÉE { background: rgba(239, 68, 68, 0.2); color: var(--danger); }

    /* BUTTONS */
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        transition: 0.2s;
        text-transform: uppercase;
        text-decoration: none;
    }
    .btn-primary { background: var(--primary); color: #020617; }
    .btn-secondary { background: #1e293b; color: white; border: 1px solid var(--border); }
    .btn-danger { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid var(--danger); }
    .btn-sm { padding: 6px 12px; font-size: 0.75rem; }
    
    .btn:hover { opacity: 0.9; transform: translateY(-2px); }

    /* EMPTY STATE */
    .empty-icon { font-size: 3rem; color: var(--text-muted); opacity: 0.3; margin-bottom: 15px; }

    .sidebar, .left-sidebar { display: none !important; }
</style>

<div class="container">
    
    <div class="back-button">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
            <i class='bx bxs-chevron-left'></i> Retour au tableau de bord
        </a>
    </div>

    <div class="header">
        <h1><i class='bx bx-history' style="color: var(--primary);"></i> Historique de Mes Réservations</h1>
        <p>Consultez et gérez l'ensemble de vos demandes passées et présentes</p>
    </div>

    <div class="filters-section">
        <div class="filters-title">Filtrer les archives</div>
        <form method="GET" action="{{ route('user.history') }}">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="status">Statut de la demande</label>
                    <select id="status" name="status">
                        <option value="">-- Tous les statuts --</option>
                        <option value="EN ATTENTE" {{ request('status') == 'EN ATTENTE' ? 'selected' : '' }}>En Attente</option>
                        <option value="VALIDÉE" {{ request('status') == 'VALIDÉE' ? 'selected' : '' }}>Validée</option>
                        <option value="REFUSÉE" {{ request('status') == 'REFUSÉE' ? 'selected' : '' }}>Refusée</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="resource_id">Équipement</label>
                    <select id="resource_id" name="resource_id">
                        <option value="">-- Toutes les ressources --</option>
                        @foreach($resources as $res)
                            <option value="{{ $res->id }}" {{ request('resource_id') == $res->id ? 'selected' : '' }}>
                                {{ $res->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="start_date">Date début</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                
                <div class="filter-group">
                    <label for="end_date">Date fin</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bxs-filter-alt'></i> APPLIQUER LES FILTRES
                </button>
                <a href="{{ route('user.history') }}" class="btn btn-secondary">
                    <i class='bx bxs-refresh'></i> RÉINITIALISER
                </a>
            </div>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Ressource IT</th>
                    <th>Période d'utilisation</th>
                    <th>Statut</th>
                    <th>Date de création</th>
                    <th>Justification</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td><strong style="color: var(--primary);">{{ $res->resource->name }}</strong></td>
                        <td>
                            <div style="font-size: 0.85rem;">
                                Du {{ $res->start_date->format('d/m/Y') }} à {{ $res->start_date->format('H:i') }}<br>
                                au {{ $res->end_date->format('d/m/Y') }} à {{ $res->end_date->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ str_replace(' ', '-', $res->status) }}">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td style="color: var(--text-muted);">{{ $res->created_at->format('d/m/Y H:i') }}</td>
                        <td style="max-width: 200px; font-size: 0.85rem; color: var(--text-muted);">
                            {{ Str::limit($res->justification ?? 'Non spécifiée', 50) }}
                        </td>
                        <td>
                            <form action="{{ route('user.cancel-reservation', $res->id) }}" method="POST" onsubmit="return confirm('Voulez-vous supprimer définitivement cette entrée de l\'historique ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class='bx bxs-trash'></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 60px;">
                            <i class='bx bxs-folder-open empty-icon'></i>
                            <p style="color: var(--text-muted); font-size: 1.1rem;">Aucun enregistrement trouvé dans l'historique.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection