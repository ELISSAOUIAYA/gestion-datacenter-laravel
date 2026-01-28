
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
    }

    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        min-height: 100vh; 
        padding: 40px 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .container-small { max-width: 600px; margin: 0 auto; }

    /* Bouton Retour (Format Pill) */
    .btn-nav-back {
        background: rgba(255, 255, 255, 0.03);
        color: var(--text-muted);
        padding: 10px 22px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 800;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border);
        margin-bottom: 25px;
        transition: 0.3s;
        text-transform: uppercase;
    }
    .btn-nav-back:hover { 
        background: var(--primary); 
        color: #020617; 
        border-color: var(--primary);
    }

    /* Carte du Formulaire */
    .glass-card {
        background: var(--bg-card);
        padding: 40px;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    }

    h1 { font-size: 2rem; font-weight: 800; letter-spacing: -1.5px; margin-bottom: 30px; }
    h1 span { color: var(--primary); }

    /* Formulaire */
    .form-group { margin-bottom: 25px; }
    label { 
        display: block; 
        font-weight: 700; 
        margin-bottom: 10px; 
        color: var(--text-muted); 
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border);
        padding: 15px;
        border-radius: 12px;
        color: white;
        font-size: 1rem;
        outline: none;
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.06);
        box-shadow: 0 0 15px rgba(56, 189, 248, 0.1);
    }

    /* Bouton Enregistrer (Succès) */
    .btn-save {
        background: var(--success);
        color: #020617;
        border: none;
        padding: 15px 30px;
        border-radius: 12px;
        font-weight: 800;
        cursor: pointer;
        width: 100%;
        font-size: 0.9rem;
        text-transform: uppercase;
        transition: 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-save:hover {
        background: white;
        transform: translateY(-2px);
    }

    /* Erreur */
    .error-msg { color: var(--danger); font-size: 0.8rem; margin-top: 5px; font-weight: 600; }
</style>



<div class="admin-body">
    <div class="container-small">
        <a href="{{ route('admin.categories.index') }}" class="btn-nav-back">
            <i class='bx bx-left-arrow-alt'></i> Retour
        </a>

        <div class="glass-card">
            <h1>Éditer : <span>{{ $category->name }}</span></h1>
            
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Nom de la catégorie</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                    @error('name') 
                        <div class="error-msg"><i class='bx bx-error-circle'></i> {{ $message }}</div> 
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" style="min-height: 120px;">{{ old('description', $category->description) }}</textarea>
                    @error('description') 
                        <div class="error-msg"><i class='bx bx-error-circle'></i> {{ $message }}</div> 
                    @enderror
                </div>

                <button type="submit" class="btn-save">
                    <i class='bx bx-save'></i> Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>
</div>
@endsection