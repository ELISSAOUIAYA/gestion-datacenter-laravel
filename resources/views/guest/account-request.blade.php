@extends('layouts.app')

@section('content')
<style>
    .form-container { padding: 30px; font-family: 'Segoe UI', system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    .header-box { background: white; padding: 25px 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; border-left: 6px solid #2c3e50; }
    .header-box h1 { margin: 0; font-weight: 800; color: #2c3e50; }
    .header-box p { margin: 8px 0 0; color: #64748b; }

    .form-box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }

    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 700; color: #2c3e50; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
    .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-family: inherit; transition: all 0.2s ease; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .form-group textarea { resize: vertical; min-height: 120px; }

    .btn { padding: 12px 24px; border-radius: 8px; border: none; cursor: pointer; font-weight: 800; font-size: 11px; text-transform: uppercase; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; }
    .btn-success { background-color: #22c55e; color: white; }
    .btn-secondary { background-color: #64748b; color: white; }

    .btn-group { display: flex; gap: 10px; margin-top: 30px; }

    .errors { background-color: #fee2e2; border: 2px solid #fca5a5; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .errors li { margin-bottom: 5px; }

    .info-box { background-color: #dbeafe; border: 2px solid #3b82f6; padding: 15px; border-radius: 8px; margin-bottom: 25px; }
    .info-box strong { color: #1e40af; }
    .info-box p { margin: 8px 0; color: #1e40af; }

    .required { color: #ef4444; }
</style>

<div class="form-container">
    <div class="header-box">
        <h1><i class='bx bx-user-plus'></i> Demande d'Ouverture de Compte</h1>
        <p>Remplissez ce formulaire pour demander l'accès aux ressources du Data Center</p>
    </div>

    <div class="form-box">
        <div class="info-box">
            <p><strong>📋 Information :</strong> Votre demande sera examinée par un administrateur dans les plus brefs délais. Vous recevrez une confirmation par email.</p>
        </div>

        @if ($errors->any())
            <div class="errors">
                <strong>Erreurs détectées :</strong>
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
                @error('name')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="email">Adresse Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Ex: jean.dupont@example.com" required>
                @error('email')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="phone">Numéro de Téléphone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Ex: +33 6 12 34 56 78">
                @error('phone')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="user_type">Type d'Utilisateur <span class="required">*</span></label>
                <select id="user_type" name="user_type" required>
                    <option value="">-- Sélectionnez votre profil --</option>
                    <option value="Ingénieur" {{ old('user_type') == 'Ingénieur' ? 'selected' : '' }}>Ingénieur</option>
                    <option value="Enseignant" {{ old('user_type') == 'Enseignant' ? 'selected' : '' }}>Enseignant</option>
                    <option value="Doctorant" {{ old('user_type') == 'Doctorant' ? 'selected' : '' }}>Doctorant</option>
                    <option value="Autre" {{ old('user_type') == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('user_type')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="motivation">Motivation / Justification <span class="required">*</span></label>
                <textarea id="motivation" name="motivation" placeholder="Décrivez pourquoi vous avez besoin d'accéder aux ressources du Data Center..." required>{{ old('motivation') }}</textarea>
                <small style="color: #64748b;">Minimum 50 caractères requis</small>
                @error('motivation')<small style="color: #dc2626;">{{ $message }}</small>@enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-check'></i> Soumettre la Demande
                </button>
                <a href="{{ route('guest.resources') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Annuler
                </a>
            </div>
        </form>

        <div style="margin-top: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
            <h3 style="color: #2c3e50; margin-top: 0;">Questions fréquemment posées</h3>
            <ul style="color: #64748b; line-height: 1.8;">
                <li><strong>Qui peut demander un compte ?</strong> Tout ingénieur, enseignant, doctorant ou chercheur ayant besoin d'accéder aux ressources.</li>
                <li><strong>Combien de temps pour l'approbation ?</strong> Généralement 24 à 48 heures.</li>
                <li><strong>Que faire si ma demande est refusée ?</strong> Vous recevrez un email expliquant le motif. Vous pouvez la renouveler après correction.</li>
                <li><strong>Besoin d'aide ?</strong> Contactez l'administrateur système : admin@datacenter.local</li>
            </ul>
        </div>
    </div>
</div>
@endsection
