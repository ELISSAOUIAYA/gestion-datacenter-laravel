@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;
        --bg-body: #020617;
        --bg-card: #0f172a;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --success: #22c55e;
        --danger: #ef4444;
        --stats-purple: #a855f7;
    }

    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        min-height: 100vh; 
        padding: 40px 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        position: relative;
    }

    .container-large { max-width: 1200px; margin: 0 auto; }

    /* --- BARRE D'ACTIONS HAUTE (Navigation Unifiée sans chevauchement) --- */
    .header-actions {
        position: absolute;
        top: 40px;
        right: 20px;
        display: flex;
        gap: 12px;
        z-index: 1000;
        align-items: center;
    }

    .btn-nav {
        padding: 10px 22px;
        border-radius: 50px; /* Format Pill */
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        text-transform: uppercase;
        border: none;
    }

    .btn-create-pill { background-color: var(--success); color: #020617; }
    .btn-dashboard { background-color: var(--stats-purple); color: white; }
    .btn-home { background-color: var(--primary); color: #020617; }
    .btn-nav:hover { background-color: white; color: #020617; transform: translateY(-2px); }

    /* --- EN-TÊTE DE PAGE --- */
    .page-header { margin-bottom: 40px; }
    .page-header h1 { font-size: 2.5rem; font-weight: 800; letter-spacing: -1.5px; }
    .page-header h1 span { color: var(--primary); }

    /* --- TABLEAU STYLE INFRASTRUCTURE --- */
    .table-container {
        background: var(--bg-card);
        border-radius: 24px;
        border: 1px solid var(--border);
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .custom-table { width: 100%; border-collapse: collapse; }
    .custom-table th {
        background: rgba(255, 255, 255, 0.02);
        padding: 20px;
        text-align: left;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }
    .custom-table td { padding: 22px 20px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
    .custom-table tr:hover { background: rgba(56, 189, 248, 0.02); }

    /* --- BADGES & ACTIONS --- */
    .badge-count {
        background: rgba(56, 189, 248, 0.1);
        color: var(--primary);
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 800;
        font-size: 0.8rem;
        border: 1px solid rgba(56, 189, 248, 0.2);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .description-cell { color: var(--text-muted); font-size: 0.85rem; line-height: 1.4; max-width: 400px; }

    .action-group { display: flex; gap: 8px; justify-content: flex-end; }
    
    .btn-edit {
        background: rgba(56, 189, 248, 0.1);
        color: var(--primary);
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid var(--primary);
    }
    .btn-edit:hover { background: var(--primary); color: #020617; }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid var(--danger);
        font-weight: 700;
        font-size: 0.75rem;
        cursor: pointer;
    }
    .btn-delete:hover { background: var(--danger); color: white; }

    .sidebar, .left-sidebar, .datacenter-info { display: none !important; }
</style>

<div class="admin-body">
    <div class="header-actions">
        <a href="{{ route('admin.categories.create') }}" class="btn-nav btn-create-pill">
            <i class='bx bx-plus-circle'></i> Nouvelle catégorie
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn-nav btn-dashboard">
            <i class='bx bxs-dashboard'></i> Dashboard
        </a>
        <a href="{{ url('/') }}" class="btn-nav btn-home">
            <i class='bx bx-home-alt-2'></i> Accueil
        </a>
    </div>

    <div class="container-large">
        <div class="page-header">
            <h1>Infrastructure <span>Catégories</span></h1>
            <p style="color: var(--text-muted); margin-top: 5px;">Déploiement et gestion des types de ressources IT.</p>
        </div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Description du Segment</th>
                        <th>Inventaire</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr>
                        <td>
                            <strong style="color: var(--primary); font-size: 1.1rem;">{{ $cat->name }}</strong>
                        </td>
                        <td class="description-cell">
                            {{ $cat->description ?: 'Aucun détail technique fourni.' }}
                        </td>
                        <td>
                            <span class="badge-count">
                                <i class='bx bx-server'></i> {{ $cat->resources_count ?? 0 }} unités
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-edit">
                                    <i class='bx bx-edit-alt'></i> MODIFIER
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Attention : Cette action est irréversible. Confirmer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class='bx bx-trash'></i> SUPPRIMER
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 5rem; text-align: center; color: var(--text-muted);">
                            <i class='bx bx-folder-open' style="font-size: 3rem; display: block; margin-bottom: 15px; opacity: 0.1;"></i>
                            Aucun segment de catégorie détecté dans la base.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection