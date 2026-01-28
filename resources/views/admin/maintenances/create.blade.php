
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
        max-width: 700px;
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

    h1 { font-weight: 800; letter-spacing: -1.5px; margin-bottom: 30px; color: var(--text-main); }
    h1 i { color: var(--primary); margin-right: 10px; }

    /* --- BOUTONS --- */
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
        margin-bottom: 20px;
    }
    .btn-back { background-color: #1e293b; color: var(--text-muted); border: 1px solid var(--border); }
    .btn-submit { background-color: var(--success); color: #020617; width: 100%; justify-content: center; margin-top: 10px; }
    .btn-nav:hover { transform: translateY(-2px); filter: brightness(1.1); }

    /* --- INPUTS & LABELS --- */
    .form-group { margin-bottom: 1.5rem; }
    
    label { 
        display: block; 
        font-weight: 700; 
        margin-bottom: 0.75rem; 
        color: var(--primary); 
        font-size: 0.85rem;
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
        font-size: 1rem;
        transition: 0.3s;
        outline: none;
    }

    input:focus, select:focus, textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }

    option { background-color: var(--bg-card); }

    .grid-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .error-msg { color: var(--danger); font-size: 0.8rem; font-weight: 600; margin-top: 5px; display: block; }
</style>

<div class="admin-body">
    <div class="form-container">
        <a href="{{ route('admin.maintenances.index') }}" class="btn-nav btn-back">
            <i class='bx bx-left-arrow-alt'></i> Retour au Dashboard
        </a>

        <div class="section-card">
            <h1><i class='bx bx-wrench'></i> Planifier une Maintenance</h1>
            
            <form method="POST" action="{{ route('admin.maintenances.store') }}">
                @csrf

                <div class="form-group">
                    <label>Ressource IT à maintenir</label>
                    <select name="resource_id" required>
                        <option value="" disabled selected>Choisir un équipement...</option>
                        @foreach($resources as $res)
                            <option value="{{ $res->id }}">{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('resource_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="grid-inputs">
                    <div class="form-group">
                        <label>Date & Heure Début</label>
                        <input type="datetime-local" name="start_date" required>
                        @error('start_date') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Date & Heure Fin</label>
                        <input type="datetime-local" name="end_date" required>
                        @error('end_date') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Description de l'intervention</label>
                    <textarea name="description" placeholder="Ex: Mise à jour du noyau, remplacement de disque..." rows="4"></textarea>
                    @error('description') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-nav btn-submit">
                    <i class='bx bx-calendar-check'></i> Confirmer la planification
                </button>
            </form>
        </div>
    </div>
</div>
@endsection