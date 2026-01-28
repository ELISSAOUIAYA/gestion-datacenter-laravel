
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
        --success: #22c55e;
        --danger: #ef4444;
        --input-bg: #1e293b;
    }

    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        padding: 60px 20px; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        min-height: 100vh;
    }

    .form-container {
        max-width: 850px;
        margin: 0 auto;
    }

    /* --- STYLE DE LA CARTE --- */
    .section-card { 
        background: var(--bg-card); 
        padding: 40px; 
        border-radius: 24px; 
        border: 1px solid var(--border);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); 
    }

    h1 { font-weight: 800; letter-spacing: -1.5px; margin-bottom: 35px; color: var(--text-main); }
    h1 span { color: var(--primary); }

    /* --- NAVIGATION (Format Pill) --- */
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
        margin-bottom: 25px;
    }
    .btn-back { background-color: #1e293b; color: var(--text-muted); border: 1px solid var(--border); }
    .btn-save { background-color: var(--success); color: #020617; width: 100%; justify-content: center; margin-top: 20px; }
    
    .btn-nav:hover { transform: translateY(-2px); filter: brightness(1.1); box-shadow: 0 10px 15px rgba(0,0,0,0.2); }

    /* --- INPUTS & LABELS --- */
    .form-group { margin-bottom: 1.8rem; }
    
    label { 
        display: block; 
        font-weight: 700; 
        margin-bottom: 0.75rem; 
        color: var(--primary); 
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    input, select, textarea {
        width: 100%;
        padding: 14px 18px;
        background-color: var(--input-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: white;
        font-size: 0.95rem;
        transition: 0.3s;
        outline: none;
    }

    input:focus, select:focus, textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        background-color: rgba(56, 189, 248, 0.02);
    }

    /* Fix visibilité des options dans le menu sombre */
    option { background-color: #0f172a; color: white; }

    /* Grille pour CPU / RAM comme sur ton image */
    .grid-specs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .sidebar, .left-sidebar, .datacenter-info { display: none !important; }
</style>

<div class="admin-body">
    <div class="form-container">
        <a href="{{ route('admin.resources.index') }}" class="btn-nav btn-back">
            <i class='bx bx-arrow-back'></i> Retour au catalogue
        </a>

        <div class="section-card">
            <h1><i class='bx bx-chip'></i> Détails de <span>{{ $resource->name }}</span></h1>
            
            <form action="{{ route('admin.resources.update', $resource) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nom de l'équipement</label>
                    <input type="text" name="name" value="{{ $resource->name }}" required>
                </div>

                <div class="form-group">
                    <label>Catégorie</label>
                    <select name="category_id">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $resource->category_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Manager Technique</label>
                    <select name="tech_manager_id">
                        @foreach($techManagers as $manager)
                            <option value="{{ $manager->id }}" {{ $resource->tech_manager_id == $manager->id ? 'selected' : '' }}>
                                {{ $manager->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid-specs">
                    <div class="form-group">
                        <label>CPU</label>
                        <input type="text" name="cpu" value="{{ $resource->cpu ?? 'N/A' }}" placeholder="Ex: 32 Cores">
                    </div>
                    <div class="form-group">
                        <label>RAM</label>
                        <input type="text" name="ram" value="{{ $resource->ram ?? 'N/A' }}" placeholder="Ex: 128 Go">
                    </div>
                </div>

                <div class="form-group">
                    <label>Statut opérationnel</label>
                    <select name="status">
                        <option value="available" {{ $resource->status == 'available' ? 'selected' : '' }}>ACTIF</option>
                        <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>EN MAINTENANCE</option>
                        <option value="offline" {{ $resource->status == 'offline' ? 'selected' : '' }}>HORS LIGNE</option>
                    </select>
                </div>

                <button type="submit" class="btn-nav btn-save">
                    <i class='bx bx-save'></i> Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>
</div>
@endsection