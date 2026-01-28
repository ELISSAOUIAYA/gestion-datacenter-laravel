
@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Cartes / Formulaire */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.1);
        --input-bg: #1e293b;        /* Fond des champs */
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
        padding: 14px 28px; 
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
    .btn-success { background-color: var(--primary); color: #020617; } /* Bouton principal en Cyan */
    .btn-secondary { background-color: transparent; color: var(--text-muted); border: 1px solid var(--border); }
    .btn:hover { transform: translateY(-2px); opacity: 0.9; }

    .btn-group { display: flex; gap: 15px; margin-top: 40px; border-top: 1px solid var(--border); padding-top: 30px; }

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
            <i class='bx bx-plus-circle' style="color: var(--primary);"></i> Nouveau Matériel
        </h1>
        <p style="margin:8px 0 0; color: var(--text-muted); font-size: 0.95rem;">
            Enregistrez un nouvel équipement dans l'infrastructure du DataCenter.
        </p>
    </div>

    <div class="form-box">
        {{-- AFFICHAGE DES ERREURS --}}
        @if ($errors->any())
            <div class="errors">
                <strong>Oups ! Veuillez corriger les erreurs suivantes :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tech.resources.store') }}" method="POST">
            @csrf

            {{-- NOM ET CATÉGORIE --}}
            <div class="form-group">
                <label for="name">Désignation de la Ressource *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Serveur de Calcul Haute Performance" required>
            </div>

            <div class="form-group">
                <label for="resource_category_id">Catégorie Technique *</label>
                <select id="resource_category_id" name="resource_category_id" required>
                    <option value="" style="background: #1e293b;">-- Sélectionnez une catégorie --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('resource_category_id') == $category->id ? 'selected' : '' }} style="background: #1e293b;">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SPÉCIFICATIONS TECHNIQUES --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="cpu">Architecture CPU</label>
                    <input type="text" id="cpu" name="cpu" value="{{ old('cpu') }}" placeholder="Ex: AMD EPYC 32-Cores">
                </div>

                <div class="form-group">
                    <label for="ram">Volume Mémoire (RAM)</label>
                    <input type="text" id="ram" name="ram" value="{{ old('ram') }}" placeholder="Ex: 256 GB DDR5">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bandwidth">Débit Réseau</label>
                    <input type="text" id="bandwidth" name="bandwidth" value="{{ old('bandwidth') }}" placeholder="Ex: 40 Gbps">
                </div>

                <div class="form-group">
                    <label for="capacity">Stockage Total</label>
                    <input type="text" id="capacity" name="capacity" value="{{ old('capacity') }}" placeholder="Ex: 10 TB NVMe">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="os">Système / OS</label>
                    <input type="text" id="os" name="os" value="{{ old('os') }}" placeholder="Ex: Debian 12 / Proxmox">
                </div>

                <div class="form-group">
                    <label for="location">Emplacement Physique</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Ex: Rack A-04, Unité 2">
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-cloud-upload'></i> Enregistrer l'équipement
                </button>
                <a href="{{ route('tech.dashboard') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection