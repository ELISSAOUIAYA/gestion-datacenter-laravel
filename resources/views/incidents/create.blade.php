@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Fond des cartes */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.08);
        --input-bg: #1e293b;        /* Fond des champs */
        --danger: #ef4444;          /* Rouge (Urgence) */
    }

    body { 
        margin: 0; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    .container { 
        max-width: 700px; 
        margin: 40px auto; 
        padding: 0 20px; 
    }

    /* BOUTON RETOUR */
    .back-link { 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        color: var(--primary); 
        text-decoration: none; 
        font-weight: 700; 
        margin-bottom: 25px; 
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .back-link:hover { transform: translateX(-5px); color: var(--text-main); }

    /* CARD STYLE */
    .incident-card { 
        background: var(--bg-card); 
        padding: 40px; 
        border-radius: 16px; 
        border: 1px solid var(--border);
        border-top: 6px solid var(--danger); /* Accent rouge pour l'incident */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
    }

    .incident-card h2 { 
        margin: 0 0 15px 0; 
        font-weight: 800; 
        font-size: 1.6rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .resource-box {
        background: rgba(239, 68, 68, 0.05);
        border: 1px solid rgba(239, 68, 68, 0.1);
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .resource-box p { margin: 0; color: var(--text-muted); font-size: 0.9rem; }
    .resource-box strong { color: var(--danger); font-size: 1.1rem; }

    hr { border: none; border-top: 1px solid var(--border); margin: 25px 0; }

    /* FORM ELEMENTS */
    .form-group { margin-bottom: 25px; }
    label { 
        display: block; 
        font-weight: 700; 
        margin-bottom: 10px; 
        color: var(--text-muted); 
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    textarea { 
        width: 100%; 
        padding: 15px; 
        background-color: var(--input-bg);
        border: 1px solid var(--border); 
        border-radius: 12px; 
        color: white;
        font-family: inherit; 
        font-size: 1rem;
        transition: 0.3s;
        resize: vertical;
        min-height: 150px;
        outline: none;
    }

    textarea:focus { 
        border-color: var(--danger); 
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    /* BUTTONS */
    .btn-send { 
        background: var(--danger); 
        color: white; 
        border: none; 
        padding: 16px 20px; 
        border-radius: 12px; 
        cursor: pointer; 
        width: 100%; 
        font-weight: 800; 
        text-transform: uppercase;
        letter-spacing: 1px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
    }

    .btn-send:hover { 
        opacity: 0.9; 
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.3);
    }

    .sidebar, .left-sidebar { display: none !important; }
</style>

<div class="container">
    
    <a href="{{ route('user.dashboard') }}" class="back-link">
        <i class='bx bxs-chevron-left'></i> Retour au Tableau de Bord
    </a>

    <div class="incident-card">
        <h2><i class='bx bxs-error-alt' style="color: var(--danger);"></i> Signaler un problème</h2>
        
        <div class="resource-box">
            <p>Ressource concernée :</p>
            <strong>{{ $resource->name }}</strong>
        </div>

        <form action="{{ route('incidents.store') }}" method="POST">
            @csrf
            <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            
            <div class="form-group">
                <label for="description">Description du problème technique</label>
                <textarea 
                    id="description"
                    name="description" 
                    required 
                    placeholder="Décrivez précisément la panne, le message d'erreur ou le conflit constaté..."
                >{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn-send">
                <i class='bx bx-paper-plane'></i> ENVOYER LE SIGNALEMENT
            </button>
        </form>
    </div>
</div>

@endsection