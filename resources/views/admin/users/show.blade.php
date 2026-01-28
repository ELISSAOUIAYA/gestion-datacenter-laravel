
@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES & SYSTÈME --- */
    :root {
        --primary: #38bdf8;
        --primary-glow: rgba(56, 189, 248, 0.15);
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
        padding: 40px 20px; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        position: relative; 
        min-height: 100vh;
    }

    /* --- NAVIGATION (Format Pill Unifié) --- */
    .header-actions {
        position: absolute;
        top: 40px;
        right: 20px;
        display: flex;
        gap: 12px;
        z-index: 1000;
    }

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
    }
    .btn-dashboard { background-color: var(--stats-purple); color: white; }
    .btn-back { background-color: #1e293b; color: var(--text-muted); border: 1px solid var(--border); }
    .btn-nav:hover { background-color: white; color: #020617; transform: translateY(-2px); }

    /* --- ALERTES --- */
    .alert { padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; font-weight: 600; font-size: 0.9rem; border: 1px solid transparent; }
    .alert-success { background: rgba(34, 197, 94, 0.1); color: var(--success); border-color: rgba(34, 197, 94, 0.2); }

    /* --- CARTE PROFIL --- */
    .profile-container { max-width: 900px; margin: 0 auto; }
    .profile-card {
        background: var(--bg-card);
        padding: 40px;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    .profile-header-flex { display: flex; align-items: center; gap: 25px; margin-bottom: 40px; }
    .avatar-placeholder { width: 80px; height: 80px; background: var(--primary); color: #020617; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 800; box-shadow: 0 0 20px var(--primary-glow); }

    .section-title {
        display: flex; align-items: center; gap: 12px; font-size: 1.1rem; font-weight: 700; margin: 30px 0 20px 0;
        padding-bottom: 10px; border-bottom: 1px solid var(--border); color: var(--primary);
    }

    /* --- FORMULAIRE --- */
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 700; margin-bottom: 8px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }
    .form-control { width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); padding: 14px; border-radius: 12px; color: white; outline: none; transition: 0.3s; font-size: 0.95rem; }
    .form-control:focus { border-color: var(--primary); background: rgba(255, 255, 255, 0.06); box-shadow: 0 0 15px var(--primary-glow); }
    
    /* Correction invisibilité des options */
    .form-control option { background-color: #0f172a; color: white; }

    /* --- MÉTA INFRASTRUCTURE --- */
    .tech-meta { background: rgba(255,255,255,0.02); padding: 25px; border-radius: 18px; margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; border: 1px solid var(--border); }
    .meta-item { text-align: center; }
    .meta-item span { display: block; font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
    .meta-item strong { color: var(--primary); font-size: 1rem; font-weight: 800; }

    /* --- ACTIONS --- */
    .btn-group { display: flex; justify-content: space-between; align-items: center; margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--border); }
    .btn-save { background: var(--success); color: #020617; border: none; padding: 15px 30px; border-radius: 12px; font-weight: 800; cursor: pointer; transition: 0.3s; display: flex; align-items: center; gap: 10px; text-transform: uppercase; font-size: 0.85rem; }
    .btn-delete { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid var(--danger); padding: 12px 22px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 0.8rem; transition: 0.3s; }
    .btn-save:hover { background: white; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(34, 197, 94, 0.2); }
    .btn-delete:hover { background: var(--danger); color: white; }

    /* Nettoyage UI */
    .sidebar, .left-sidebar, .datacenter-info { display: none !important; }
</style>

<div class="admin-body">
    <div class="header-actions">
        <a href="{{ route('admin.users.index') }}" class="btn-nav btn-back">
            <i class='bx bx-left-arrow-alt'></i> Retour
        </a>
        <a href="{{ route('admin.dashboard') }}" class="btn-nav btn-dashboard">
            <i class='bx bxs-dashboard'></i> Dashboard
        </a>
    </div>

    <div class="profile-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        <div class="profile-card">
            <div class="profile-header-flex">
                <div class="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div>
                    <h1 style="margin:0; font-weight: 800; letter-spacing: -1.5px;">{{ $user->name }}</h1>
                    <p style="color: var(--text-muted); margin: 5px 0 0 0; font-family: monospace;">UUID: DC-USR-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="section-title">
                    <i class='bx bx-id-card'></i> Paramètres de l'Identité
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nom Complet</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Adresse Email Professionnelle</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Rôle Infrastructure</label>
                        <select name="role_id" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>État du Flux</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>OPÉRATIONNEL (ACTIF)</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>SUSPENDU (INACTIF)</option>
                        </select>
                    </div>
                </div>

                <div class="section-title">
                    <i class='bx bx-lock-open-alt'></i> Protocoles de Sécurité
                </div>
                <p style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 20px;">Laissez les champs vides si vous ne souhaitez pas modifier les accès actuels.</p>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nouveau Mot de Passe</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••">
                    </div>
                    <div class="form-group">
                        <label>Confirmation du Protocole</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••">
                    </div>
                </div>

                <div class="tech-meta">
                    <div class="meta-item">
                        <span>Déploiement initial</span>
                        <strong>{{ $user->created_at->format('d/m/Y') }}</strong>
                    </div>
                    <div class="meta-item">
                        <span>Dernière synchro</span>
                        <strong>{{ $user->updated_at->diffForHumans() }}</strong>
                    </div>
                    <div class="meta-item">
                        <span>État Système</span>
                        <strong style="color: {{ $user->is_active ? 'var(--success)' : 'var(--danger)' }}">
                            {{ $user->is_active ? 'ONLINE' : 'OFFLINE' }}
                        </strong>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-save">
                        <i class='bx bx-save'></i> Mettre à jour le profil
                    </button>
                    
                    <a href="#" class="btn-delete" onclick="event.preventDefault(); if(confirm('ALERTE : Cette action supprimera définitivement cet utilisateur de l\'infrastructure. Confirmer ?')) { document.getElementById('delete-form').submit(); }">
                        <i class='bx bx-trash'></i> Supprimer l'accès
                    </a>
                </div>
            </form>

            <form id="delete-form" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection