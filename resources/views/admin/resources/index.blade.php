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
        --warning: #f59e0b;
        --stats-purple: #a855f7;
        --btn-accueil-custom: #6366f1; /* Indigo comme demandé */
    }

    /* --- LAYOUT PLEINE PAGE --- */
    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        padding: 40px 0; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        position: relative; 
        min-height: 100vh;
        width: 100%;
        overflow-x: hidden;
    }
    
    .admin-body h1 { font-weight: 800; letter-spacing: -1.5px; margin-bottom: 20px; padding: 0 40px; }
    .admin-body h1 span { color: var(--primary); }

    /* --- 1. BOUTONS TOUT EN HAUT À DROITE --- */
    .top-right-nav {
        position: absolute;
        top: 30px;
        right: 40px;
        display: flex;
        gap: 12px;
        z-index: 1001;
    }

    /* --- 2. BOUTONS DE GESTION AU MILIEU SOUS LE TITRE --- */
    .management-nav-centered {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 0 40px;
        margin-bottom: 40px;
    }

    /* Style unifié Pill */
    .btn-nav {
        padding: 10px 22px;
        border-radius: 50px;
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
        white-space: nowrap;
    }
    
    .btn-accueil { background-color: var(--btn-accueil-custom); color: white; }
    .btn-logout { background-color: #1e293b; color: var(--danger); border: 1px solid var(--border); }
    .btn-stats { background-color: var(--stats-purple) !important; color: white !important; }
    .btn-demandes { background-color: var(--warning); color: #020617; }
    .btn-users { background-color: var(--success); color: #020617; }
    .btn-resources-nav { background-color: var(--primary); color: #020617; }
    .btn-categories { background-color: var(--success); color: #020617; }

    .btn-nav:hover { background-color: white; color: #020617; transform: translateY(-2px); }

    /* --- SECTION FILTRES --- */
    .filter-card { 
        background: var(--bg-card); 
        padding: 25px 40px; 
        margin-bottom: 30px; 
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        width: 100%;
    }

    .filter-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; }
    
    .filter-input, .filter-select {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border);
        padding: 12px 15px;
        border-radius: 12px;
        color: white;
        font-size: 0.9rem;
        outline: none;
    }
    .filter-select option { background-color: #0f172a; }

    .btn-filter {
        background: var(--primary);
        color: #020617;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        cursor: pointer;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    /* --- SECTIONS FULL WIDTH (Tableaux bord à bord) --- */
    .section-card { 
        background: var(--bg-card); 
        padding: 30px 40px; 
        margin-bottom: 30px; 
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        border-left: none;
        border-right: none;
        width: 100%;
        border-radius: 0;
    }

    /* --- TABLEAUX --- */
    .table { width: 100%; border-collapse: collapse; table-layout: auto; }
    .table th { 
        background: rgba(255, 255, 255, 0.03); 
        padding: 15px 20px; 
        text-align: left; 
        font-size: 0.7rem; 
        color: var(--text-muted); 
        text-transform: uppercase; 
        border-bottom: 1px solid var(--border);
    }
    .table td { padding: 18px 20px; border-top: 1px solid var(--border); vertical-align: middle; color: var(--text-main); font-size: 0.9rem; }
    
    .col-stretch { width: auto; } 
    .col-actions { width: 1%; white-space: nowrap; text-align: right !important; }

    /* Badges État */
    .badge-status {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-active { background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2); }
    .status-inactive { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

    .btn-view {
        background: var(--primary);
        color: #020617;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 800;
        font-size: 0.75rem;
    }

    .sidebar, .left-sidebar, .datacenter-info { display: none !important; }
</style>

<div class="admin-body">
    <div class="top-right-nav">
        <a href="{{ url('/') }}" class="btn-nav btn-accueil">
            <i class='bx bx-home-alt-2'></i> Accueil
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-nav btn-logout">
                <i class='bx bx-power-off'></i> Déconnexion
            </button>
        </form>
    </div>

    <h1><i class='bx bxs-server'></i> Gestion des <span>Ressources IT</span></h1>

    <div class="management-nav-centered">
        <a href="{{ route('admin.statistics') }}" class="btn-nav btn-stats"><i class='bx bx-bar-chart-alt-2'></i> Statistiques</a> 
        <a href="{{ route('admin.users.index') }}" class="btn-nav btn-users"><i class='bx bx-group'></i> Utilisateurs</a>
        <a href="{{ route('admin.resources.index') }}" class="btn-nav btn-resources-nav"><i class='bx bxs-server'></i> Ressources</a>
        <a href="{{ route('admin.categories.index') }}" class="btn-nav btn-categories"><i class='bx bx-folder'></i> Catégories</a>
    </div>

    <div class="filter-card">
        <form method="GET" class="filter-form">
            <input type="text" name="search" class="filter-input" placeholder="Rechercher une ressource..." value="{{ request('search') }}">
            
            <select name="category" class="filter-select">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <select name="active" class="filter-select">
                <option value="">Tous les états</option>
                <option value="active" {{ request('active') === 'active' ? 'selected' : '' }}>Opérationnelles (Actives)</option>
                <option value="inactive" {{ request('active') === 'inactive' ? 'selected' : '' }}>En maintenance (Inactives)</option>
            </select>

            <button type="submit" class="btn-filter">
                <i class='bx bx-search'></i> Filtrer le catalogue
            </button>
        </form>
    </div>

    <div class="section-card">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-stretch">Désignation</th>
                    <th>Catégorie</th>
                    <th>Manager Technique</th>
                    <th>État Système</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                <tr>
                    <td><strong style="color: var(--primary);">{{ $resource->name }}</strong></td>
                    <td><span style="color: var(--text-muted);">{{ $resource->category->name ?? 'NON CATÉGORISÉ' }}</span></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <i class='bx bx-user-circle' style="color: var(--primary);"></i>
                            {{ $resource->techManager->name ?? 'ADMIN SYSTEM' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-status {{ $resource->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $resource->is_active ? 'Online' : 'Offline' }}
                        </span>
                    </td>
                    <td class="col-actions">
                        <a href="{{ route('admin.resources.show', $resource) }}" class="btn-view">
                            <i class='bx bx-show'></i> DÉTAILS
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem; text-align: center; color: var(--text-muted);">
                        Aucune ressource détectée dans l'infrastructure.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($resources->hasPages())
    <div style="padding: 0 40px; display: flex; justify-content: center;">
        {{ $resources->links() }}
    </div>
    @endif
</div>
@endsection