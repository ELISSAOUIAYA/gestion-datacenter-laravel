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
        --btn-accueil: #6366f1; /* Indigo professionnel */
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
    .admin-body h1 i { color: var(--primary); }

    /* --- 1. POSITIONNEMENT HAUT À DROITE (Accueil / Déco) --- */
    .top-right-nav {
        position: absolute;
        top: 30px;
        right: 40px;
        display: flex;
        gap: 12px;
        z-index: 1001;
    }

    /* --- 2. POSITIONNEMENT SOUS LE TITRE (Gestion - Centré) --- */
    .management-nav-centered {
        display: flex;
        justify-content: center; 
        gap: 12px;
        flex-wrap: wrap;
        padding: 0 40px;
        margin-bottom: 40px;
    }

    /* Style unifié (Format Pill) */
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
    
    .btn-accueil { background-color: var(--btn-accueil); color: white; }
    .btn-logout { background-color: #1e293b; color: var(--danger); border: 1px solid var(--border); }
    .btn-stats { background-color: var(--stats-purple) !important; color: white !important; }
    .btn-users { background-color: var(--success); color: #020617; }
    .btn-resources-nav { background-color: var(--primary); color: #020617; }
    .btn-categories { background-color: var(--success); color: #020617; }

    .btn-nav:hover { background-color: white; color: #020617; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(0,0,0,0.4); }

    /* Statistiques */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 0 40px 40px 40px; }
    .stat-card { 
        background: var(--bg-card); padding: 25px 20px; border-radius: 16px; 
        border: 1px solid var(--border); border-left: 4px solid var(--primary); 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); 
    }
    .stat-card h3 { font-size: 2rem; font-weight: 800; margin: 0; color: var(--text-main); }
    .stat-card p { color: var(--text-muted); margin-top: 5px; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; }

    /* --- SECTIONS FULL WIDTH --- */
    .section-card { 
        background: var(--bg-card); padding: 30px 40px; margin-bottom: 30px; 
        border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
        border-left: none; border-right: none; width: 100%; border-radius: 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
    }
    .section-card h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 25px; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 15px; }

    /* --- TABLEAUX OPTIMISÉS --- */
    .table { width: 100%; border-collapse: collapse; table-layout: auto; }
    .table th { 
        background: rgba(255, 255, 255, 0.03); padding: 15px 20px; text-align: left; 
        font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; 
        border-bottom: 1px solid var(--border);
    }
    .table td { padding: 18px 20px; border-top: 1px solid var(--border); vertical-align: middle; color: var(--text-main); font-size: 0.9rem; }
    
    .col-stretch { width: auto; } 
    .col-actions { width: 1%; white-space: nowrap; text-align: right !important; }

    .btn-group-actions { display: flex; gap: 8px; justify-content: flex-end; }
    select { background: #1e293b; color: white; border: 1px solid var(--border); padding: 6px; border-radius: 8px; outline: none; }
    select option { background-color: #0f172a; }
    
    .btn-toggle { 
        padding: 8px 14px; border-radius: 8px; border: none; cursor: pointer; 
        color: #020617; font-size: 0.75rem; font-weight: 800; text-transform: uppercase;
        transition: 0.3s;
    }
    .btn-toggle:hover { opacity: 0.9; transform: translateY(-1px); }

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

    <h1><i class='bx bxs-shield-quarter'></i> Administration Globale</h1>

    <div class="management-nav-centered">
        <a href="{{ route('admin.statistics') }}" class="btn-nav btn-stats"><i class='bx bx-bar-chart-alt-2'></i> Statistiques</a> 
        <a href="{{ route('admin.users.index') }}" class="btn-nav btn-users"><i class='bx bx-group'></i> Utilisateurs</a>
        <a href="{{ route('admin.resources.index') }}" class="btn-nav btn-resources-nav"><i class='bx bxs-server'></i> Ressources</a>
        <a href="{{ route('admin.categories.index') }}" class="btn-nav btn-categories"><i class='bx bx-folder'></i> Catégories</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card"><h3>{{ $stats['total_users'] }}</h3><p>Utilisateurs</p></div>
        <div class="stat-card" style="border-left-color: var(--success);"><h3>{{ $stats['total_resources'] }}</h3><p>Catalogue IT</p></div>
        <div class="stat-card" style="border-left-color: var(--warning);"><h3>{{ $stats['occupied_rate'] }}%</h3><p>Taux d'occupation</p></div>
        <div class="stat-card" style="border-left-color: var(--danger);"><h3>{{ $stats['maintenance_count'] }}</h3><p>En Maintenance</p></div>
    </div>

    <div class="section-card">
        <h3><i class='bx bx-group'></i> Gestion des Comptes & Permissions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-stretch">Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle Actuel</th>
                    <th>Statut</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><strong style="color: var(--primary);">{{ $user->name }}</strong></td>
                    <td style="color: var(--text-muted);">{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="role_id" onchange="this.form.submit()">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td><span style="color: {{ $user->status === 'active' ? 'var(--success)' : 'var(--danger)' }}; font-weight: 800;">{{ strtoupper($user->status) }}</span></td>
                    <td class="col-actions">
                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-toggle" style="background: {{ $user->status === 'active' ? 'var(--danger)' : 'var(--success)' }}">
                                {{ $user->status === 'active' ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-card">
        <h3><i class='bx bx-server'></i> Maintenance & Catalogue des Ressources</h3>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-stretch">Équipement</th>
                    <th>Catégorie</th>
                    <th>État</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                <tr>
                    <td><strong>{{ $resource->name }}</strong></td>
                    <td style="color: var(--text-muted);">{{ $resource->category->name ?? 'N/A' }}</td>
                    <td><span style="color: {{ $resource->status === 'available' ? 'var(--success)' : 'var(--warning)' }}; font-weight: 800;">{{ strtoupper($resource->status) }}</span></td>
                    <td class="col-actions">
                        <div class="btn-group-actions">
                            <form action="{{ route('admin.resources.maintenance', $resource->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-toggle" style="background: var(--warning);">
                                  {{ $resource->status === 'Planifier maintenance' ? 'En maintenance' : 'Maintenance' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.resources.toggle', $resource->id) }}" method="POST">
                                @csrf @method('POST')
                                <button type="submit" class="btn-toggle" style="background: {{ $resource->is_active ? 'var(--danger)' : 'var(--success)' }};">
                                    {{ $resource->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-card">
        <h3><i class='bx bx-wrench'></i> Gestion des Périodes de Maintenance Planifiée</h3>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-stretch">Ressource</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Description</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($maintenances as $maintenance)
                <tr>
                    <td><strong style="color: var(--primary);">{{ $maintenance->resource->name ?? 'N/A' }}</strong></td>
                    <td style="color: var(--text-muted);">{{ $maintenance->start_date->format('d/m/Y H:i') }}</td>
                    <td style="color: var(--text-muted);">{{ $maintenance->end_date->format('d/m/Y H:i') }}</td>
                    <td style="font-size: 0.8rem;">{{ $maintenance->description ?? '-' }}</td>
                    <td class="col-actions">
                        <div class="btn-group-actions">
                            <a href="{{ route('admin.maintenances.edit', $maintenance->id) }}" class="btn-toggle" style="background: #3498db; text-decoration: none;">Modifier</a>
                            <form action="{{ route('admin.maintenances.destroy', $maintenance->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-toggle" style="background: var(--danger);">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; color: var(--text-muted); padding: 40px;">Aucune maintenance planifiée</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 25px;">
            <a href="{{ route('admin.maintenances.create') }}" class="btn-toggle" style="background: var(--success); text-decoration: none; display: inline-block;">+ Planifier Maintenance</a>
        </div>
    </div>
</div>
@endsection