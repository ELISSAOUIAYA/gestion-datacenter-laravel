@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES & GLOBAL --- */
    :root {
        --primary: #38bdf8;
        --primary-dark: #0ea5e9;
        --bg-body: #020617;
        --bg-card: #0f172a;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --success: #22c55e;
        --danger: #ef4444;
        --warning: #f59e0b;
        --stats-purple: #a855f7;
    }

    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        padding: 40px 20px; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        position: relative; 
        min-height: 100vh;
    }

    /* --- NAVIGATION HAUTE --- */
    .header-actions {
        position: absolute;
        top: 40px;
        right: 20px;
        display: flex;
        gap: 12px;
        z-index: 1000;
    }

    .btn-nav {
        padding: 10px 20px;
        border-radius: 10px;
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
    .btn-dashboard { background-color: var(--stats-purple); color: white; }
    .btn-home { background-color: var(--primary); color: #020617; }
    .btn-logout { background-color: #1e293b; color: var(--danger); border: 1px solid var(--border); }
    .btn-nav:hover { background-color: white; color: #020617; transform: translateY(-2px); }

    /* --- TITRE & SECTIONS --- */
    h1 { font-weight: 800; letter-spacing: -1.5px; margin-bottom: 30px; display: flex; align-items: center; gap: 15px; }
    h1 i { color: var(--primary); font-size: 2.5rem; }

    .section-card { 
        background: var(--bg-card); 
        padding: 30px; 
        border-radius: 20px; 
        margin-bottom: 30px; 
        border: 1px solid var(--border);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    }

    /* --- FILTRES (TEXTE & OPTIONS VISIBLES) --- */
    .filter-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; }
    
    .filter-input, .filter-select {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border);
        padding: 12px 15px;
        border-radius: 12px;
        color: white;
        font-size: 0.9rem;
        outline: none;
    }

    /* Important : Fond des options pour qu'elles ne soient plus invisibles */
    .filter-select option {
        background-color: #0f172a; 
        color: white;
    }

    .btn-filter {
        background: var(--primary);
        color: #020617;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        cursor: pointer;
        text-transform: uppercase;
        font-size: 0.8rem;
        transition: 0.3s;
    }
    .btn-filter:hover { background: white; transform: scale(1.02); }

    /* --- TABLEAU --- */
    .table { width: 100%; border-collapse: collapse; }
    .table th { 
        background: rgba(255, 255, 255, 0.02); 
        padding: 18px; 
        text-align: left; 
        font-size: 0.7rem; 
        color: var(--text-muted); 
        text-transform: uppercase; 
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }
    .table td { padding: 20px 18px; border-bottom: 1px solid var(--border); font-size: 0.95rem; color: var(--text-main); }
    .table tr:hover { background: rgba(56, 189, 248, 0.02); }

    /* --- BADGES --- */
    .badge { padding: 6px 14px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; display: inline-block; }
    .badge-role { background: rgba(56, 189, 248, 0.1); color: var(--primary); border: 1px solid rgba(56, 189, 248, 0.2); }
    .badge-active { background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2); }
    .badge-inactive { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

    .btn-action { 
        background: var(--primary); color: #020617; 
        padding: 8px 16px; border-radius: 8px; 
        text-decoration: none; font-weight: 800; 
        font-size: 0.75rem; transition: 0.3s;
    }
    .btn-action:hover { background: white; }

    /* Masquage des éléments inutiles */
    .sidebar, .left-sidebar { display: none !important; }
</style>

<div class="admin-body">
    <div class="header-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn-nav btn-dashboard">
            <i class='bx bxs-dashboard'></i> Dashboard
        </a>
        <a href="{{ url('/') }}" class="btn-nav btn-home">
            <i class='bx bx-home-alt-2'></i> Accueil
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-nav btn-logout">
                <i class='bx bx-power-off'></i> Déconnexion
            </button>
        </form>
    </div>

    <h1><i class='bx bxs-user-badge'></i> Gestion des <span>Utilisateurs</span></h1>

    <div class="section-card">
        <form method="GET" class="filter-form">
            <input type="text" name="search" class="filter-input" placeholder="Rechercher par nom ou email..." value="{{ request('search') }}">
            
            <select name="role" class="filter-select">
                <option value="">Tous les rôles</option>
                @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
                @endforeach
            </select>

            <select name="status" class="filter-select">
                <option value="">Tous les status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
            </select>

            <button type="submit" class="btn-filter">
                <i class='bx bx-search'></i> Filtrer
            </button>
        </form>
    </div>

    <div class="section-card" style="padding: 0; overflow: hidden;">
        <table class="table">
            <thead>
                <tr>
                    <th>Identité</th>
                    <th>Coordonnées</th>
                    <th>Rôle Système</th>
                    <th>État</th>
                    <th style="text-align: center;">Détails</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td><strong style="color: var(--primary);">{{ $user->name }}</strong></td>
                    <td style="color: var(--text-muted); font-family: monospace;">{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-role">
                            {{ $user->role->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $user->is_active ? 'ACTIF' : 'INACTIF' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn-action">
                            <i class='bx bx-show'></i> Voir profil 
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 4rem; text-align: center; color: var(--text-muted);">
                        <i class='bx bx-ghost' style="font-size: 3rem; display: block; margin-bottom: 10px; opacity: 0.2;"></i>
                        Aucun utilisateur trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection