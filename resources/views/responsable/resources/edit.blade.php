
@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Fond des cartes */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.1);
        --input-bg: #1e293b;        /* Fond des champs */
        --danger: #ef4444;
        --success: #22c55e;
    }

    /* Structure Globale */
    .form-container { 
        padding: 40px 20px; 
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; 
        background-color: var(--bg-body); 
        min-height: 100vh; 
        color: var(--text-main);
    }
    
    /* En-tête */
    .header-box { 
        background: var(--bg-card); 
        padding: 25px 35px; 
        border-radius: 12px; 
        border: 1px solid var(--border);
        margin-bottom: 30px; 
        border-left: 6px solid var(--primary);
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Formulaire */
    .form-box { 
        background: var(--bg-card); 
        padding: 40px; 
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); 
        max-width: 800px; 
        margin: 0 auto;
    }

    .form-group { margin-bottom: 25px; }
    .form-group label { 
        display: block; 
        margin-bottom: 10px; 
        font-weight: 700; 
        color: var(--primary); 
        text-transform: uppercase; 
        font-size: 11px; 
        letter-spacing: 1px;
    }

    .form-group input, .form-group select, .form-group textarea { 
        width: 100%; 
        padding: 14px; 
        background-color: var(--input-bg);
        border: 1px solid var(--border); 
        border-radius: 10px; 
        font-size: 14px; 
        color: white;
        font-family: inherit; 
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
        border-color: var(--primary); 
        outline: none; 
        background-color: #0f172a;
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15);
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

    /* Boutons */
    .btn { 
        padding: 12px 24px; 
        border-radius: 10px; 
        border: none; 
        cursor: pointer; 
        font-weight: 800; 
        font-size: 11px; 
        text-transform: uppercase; 
        transition: all 0.3s ease; 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        text-decoration: none;
    }
    .btn-success { background-color: var(--primary); color: #020617; }
    .btn-secondary { background-color: transparent; color: var(--text-muted); border: 1px solid var(--border); }
    .btn-danger { background-color: var(--danger); color: white; }
    
    .btn:hover { transform: translateY(-2px); opacity: 0.9; }

    .btn-group { 
        display: flex; 
        gap: 15px; 
        margin-top: 40px; 
        border-top: 1px solid var(--border); 
        padding-top: 30px; 
        flex-wrap: wrap;
    }

    /* Erreurs */
    .errors { 
        background-color: rgba(239, 68, 68, 0.1); 
        border: 1px solid #ef4444; 
        color: #fca5a5; 
        padding: 15px; 
        border-radius: 10px; 
        margin-bottom: 25px; 
        font-size: 14px;
    }
    .errors ul { margin: 0; padding-left: 20px; }
</style>

<div class="form-container">
    <div class="header-box">
        <h1 style="margin:0; font-weight: 800; color: var(--text-main);">
            <i class='bx bx-edit' style="color: var(--primary);"></i> Édition Technique
        </h1>
        <p style="margin:8px 0 0; color: var(--text-muted); font-size: 0.95rem;">
            Ressource : <strong style="color: var(--primary);">{{ $resource->name }}</strong>
        </p>
    </div>

    <div class="form-box">
        {{-- AFFICHAGE DES ERREURS --}}
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tech.resources.update', $resource->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NOM ET CATÉGORIE --}}
            <div class="form-group">
                <label for="name">Désignation de la Ressource *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $resource->name) }}" required>
            </div>

            <div class="form-group">
                <label for="resource_category_id">Catégorie Technique *</label>
                <select id="resource_category_id" name="resource_category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('resource_category_id', $resource->resource_category_id) == $category->id ? 'selected' : '' }} style="background: #1e293b;">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SPÉCIFICATIONS TECHNIQUES --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="cpu">Architecture CPU</label>
                    <input type="text" id="cpu" name="cpu" value="{{ old('cpu', $resource->cpu) }}">
                </div>

                <div class="form-group">
                    <label for="ram">Volume Mémoire (RAM)</label>
                    <input type="text" id="ram" name="ram" value="{{ old('ram', $resource->ram) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bandwidth">Débit Réseau</label>
                    <input type="text" id="bandwidth" name="bandwidth" value="{{ old('bandwidth', $resource->bandwidth) }}">
                </div>

                <div class="form-group">
                    <label for="capacity">Capacité de Stockage</label>
                    <input type="text" id="capacity" name="capacity" value="{{ old('capacity', $resource->capacity) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="os">Système / OS</label>
                    <input type="text" id="os" name="os" value="{{ old('os', $resource->os) }}">
                </div>

                <div class="form-group">
                    <label for="location">Emplacement Physique</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $resource->location) }}">
                </div>
            </div>

            {{-- ÉTAT DE LA RESSOURCE --}}
            <div class="form-group">
                <label for="status">Statut Opérationnel *</label>
                <select id="status" name="status" required>
                    <option value="available" {{ old('status', $resource->status) == 'available' ? 'selected' : '' }} style="background: #1e293b;">Disponible</option>
                    <option value="maintenance" {{ old('status', $resource->status) == 'maintenance' ? 'selected' : '' }} style="background: #1e293b;">En Maintenance</option>
                    <option value="inactive" {{ old('status', $resource->status) == 'inactive' ? 'selected' : '' }} style="background: #1e293b;">Inactive</option>
                </select>
            </div>

            {{-- ACTIONS --}}
            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-save'></i> Enregistrer les modifications
                </button>
                
                <a href="{{ route('tech.dashboard') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Retour
                </a>

                {{-- FORMULAIRE DE SUPPRESSION INTÉGRÉ --}}
                <button type="button" class="btn btn-danger" onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')) { document.getElementById('delete-form').submit(); }">
                    <i class='bx bx-trash'></i> Supprimer
                </button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('tech.resources.destroy', $resource->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection