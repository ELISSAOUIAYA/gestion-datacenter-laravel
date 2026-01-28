@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Cartes / Formulaire */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.1);
        --input-bg: #1e293b;        /* Fond des champs */
        --danger: #ef4444;
        --success: #22c55e;
        --info-bg: rgba(56, 189, 248, 0.1);
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
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }
    .header-box h1 { margin: 0; font-weight: 800; color: var(--text-main); font-size: 1.8rem; }
    .header-box p { margin: 8px 0 0; color: var(--text-muted); }

    /* Formulaire */
    .form-box { 
        background: var(--bg-card); 
        padding: 40px; 
        border-radius: 16px;
        border: 1px solid var(--border);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3); 
        max-width: 700px; 
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

    .form-group textarea { resize: vertical; min-height: 120px; }

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
    .btn-success { background-color: var(--primary); color: #020617; }
    .btn-secondary { background-color: transparent; color: var(--text-muted); border: 1px solid var(--border); }
    .btn:hover { transform: translateY(-2px); opacity: 0.9; }

    .btn-group { display: flex; gap: 15px; margin-top: 30px; }

    /* Alertes & Infos */
    .errors { 
        background-color: rgba(239, 68, 68, 0.1); 
        border: 1px solid var(--danger); 
        color: #fca5a5; 
        padding: 15px; 
        border-radius: 10px; 
        margin-bottom: 25px; 
    }
    .errors ul { margin: 10px 0 0; padding-left: 20px; }

    .info-box { 
        background-color: var(--info-bg); 
        border: 1px solid var(--primary); 
        padding: 20px; 
        border-radius: 10px; 
        margin-bottom: 30px; 
    }
    .info-box p { margin: 0; color: var(--primary); font-size: 0.95rem; line-height: 1.5; }

    .required { color: var(--danger); margin-left: 4px; }

    /* FAQ Section */
    .faq-section { 
        margin-top: 40px; 
        padding: 25px; 
        background-color: rgba(255, 255, 255, 0.02); 
        border-radius: 12px; 
        border: 1px dashed var(--border);
    }
    .faq-section h3 { color: var(--text-main); margin-top: 0; font-size: 1.1rem; border-bottom: 1px solid var(--border); padding-bottom: 10px; }
    .faq-list { color: var(--text-muted); padding-left: 20px; line-height: 1.8; font-size: 0.9rem; }
    .faq-list strong { color: var(--primary); }
</style>

<div class="form-container">
    <div class="header-box">
        <h1><i class='bx bx-user-plus' style="color: var(--primary);"></i> Demande d'Ouverture de Compte</h1>
        <p>Soumettez votre profil pour accéder aux infrastructures du Data Center</p>
    </div>

    <div class="form-box">
        <div class="info-box">
            <p><i class='bx bx-info-circle'></i> <strong>Information :</strong> Votre demande sera examinée par un administrateur système. Une confirmation vous sera envoyée par email après validation de votre motif.</p>
        </div>

        {{-- GESTION DES ERREURS --}}
        @if ($errors->any())
            <div class="errors">
                <strong><i class='bx bx-error-circle'></i> Erreurs détectées :</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('account-request.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nom Complet <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Jean Dupont" required>
                @error('name')<small style="color: var(--danger); display: block; margin-top: 5px;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="email">Adresse Email Professionnelle <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Ex: jean.dupont@univ.fr" required>
                @error('email')<small style="color: var(--danger); display: block; margin-top: 5px;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="phone">Numéro de Téléphone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Ex: +212 6 00 00 00 00">
                @error('phone')<small style="color: var(--danger); display: block; margin-top: 5px;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="user_type">Profil Utilisateur <span class="required">*</span></label>
                <select id="user_type" name="user_type" required>
                    <option value="" style="background: var(--bg-card);">-- Sélectionnez votre profil --</option>
                    <option value="Ingénieur" {{ old('user_type') == 'Ingénieur' ? 'selected' : '' }} style="background: var(--bg-card);">Ingénieur</option>
                    <option value="Enseignant" {{ old('user_type') == 'Enseignant' ? 'selected' : '' }} style="background: var(--bg-card);">Enseignant</option>
                    <option value="Doctorant" {{ old('user_type') == 'Doctorant' ? 'selected' : '' }} style="background: var(--bg-card);">Doctorant</option>
                    <option value="Autre" {{ old('user_type') == 'Autre' ? 'selected' : '' }} style="background: var(--bg-card);">Autre</option>
                </select>
                @error('user_type')<small style="color: var(--danger); display: block; margin-top: 5px;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="motivation">Motivation & Justification <span class="required">*</span></label>
                <textarea id="motivation" name="motivation" placeholder="Expliquez brièvement l'usage prévu des ressources (projets, recherches...)" required>{{ old('motivation') }}</textarea>
                <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                    <small style="color: var(--text-muted);">Minimum 50 caractères requis</small>
                </div>
                @error('motivation')<small style="color: var(--danger); display: block; margin-top: 5px;">{{ $message }}</small>@enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-send'></i> Envoyer la Demande
                </button>
                <a href="{{ route('guest.resources') }}" class="btn btn-secondary">
                    <i class='bx bx-x'></i> Annuler
                </a>
            </div>
        </form>

        {{-- FAQ SECTION --}}
        <div class="faq-section">
            <h3><i class='bx bx-help-circle' style="color: var(--primary);"></i> Questions Fréquentes</h3>
            <ul class="faq-list">
                <li><strong>Qui peut demander un compte ?</strong> Tout personnel académique ou technique justifiant d'un besoin de calcul ou de stockage.</li>
                <li><strong>Délai d'approbation :</strong> Les demandes sont traitées sous <strong>24 à 48 heures</strong> ouvrées.</li>
                <li><strong>Refus de demande :</strong> En cas de refus, un motif technique vous sera communiqué par email.</li>
                <li><strong>Support :</strong> Pour toute assistance technique : <span style="color: var(--primary);">admin@datacenter.local</span></li>
            </ul>
        </div>
    </div>
</div>
@endsection