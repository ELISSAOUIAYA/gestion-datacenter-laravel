@extends('layouts.app')

@section('content')
<style>
    /* Structure Globale */
    .form-container { padding: 30px; font-family: 'Segoe UI', system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    
    /* En-tête */
    .header-box { 
        background: white; padding: 20px 30px; border-radius: 12px; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; 
        border-left: 6px solid #2c3e50;
    }

    /* Formulaire */
    .form-box { 
        background: white; padding: 30px; border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 700px; margin: 0 auto;
    }

    .form-group { margin-bottom: 20px; }
    .form-group label { 
        display: block; margin-bottom: 8px; font-weight: 700; color: #2c3e50; 
        text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;
    }
    .form-group input, .form-group select, .form-group textarea { 
        width: 100%; padding: 12px; border: 2px solid #e2e8f0; border-radius: 8px; 
        font-size: 14px; font-family: inherit; transition: all 0.2s ease;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { 
        border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

    /* Boutons */
    .btn { padding: 12px 24px; border-radius: 8px; border: none; cursor: pointer; font-weight: 800; font-size: 11px; text-transform: uppercase; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; }
    .btn-success { background-color: #22c55e; color: white; box-shadow: 0 4px 6px rgba(34, 197, 94, 0.2); }
    .btn-secondary { background-color: #64748b; color: white; }

    .btn-group { display: flex; gap: 10px; margin-top: 30px; }

    .errors { background-color: #fee2e2; border: 2px solid #fca5a5; color: #dc2626; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
    .errors li { margin-bottom: 5px; }
</style>

<div class="form-container">
    <div class="header-box">
        <h1 style="margin:0; font-weight: 800; color: #2c3e50;"><i class='bx bx-plus-circle'></i> Ajouter une Nouvelle Ressource</h1>
        <p style="margin:5px 0 0; color: #64748b;">Créez une nouvelle ressource pour la superviser</p>
    </div>

    <div class="form-box">
        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tech.resources.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Nom de la Ressource *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Ex: Serveur Web 01" required>
            </div>

            <div class="form-group">
                <label for="resource_category_id">Catégorie *</label>
                <select id="resource_category_id" name="resource_category_id" required>
                    <option value="">-- Sélectionner une catégorie --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('resource_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="cpu">Processeur (CPU)</label>
                    <input type="text" id="cpu" name="cpu" value="{{ old('cpu') }}" placeholder="Ex: Intel Xeon 16 cores">
                </div>

                <div class="form-group">
                    <label for="ram">Mémoire (RAM)</label>
                    <input type="text" id="ram" name="ram" value="{{ old('ram') }}" placeholder="Ex: 128 GB">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="bandwidth">Bande Passante</label>
                    <input type="text" id="bandwidth" name="bandwidth" value="{{ old('bandwidth') }}" placeholder="Ex: 10 Gbps">
                </div>

                <div class="form-group">
                    <label for="capacity">Capacité de Stockage</label>
                    <input type="text" id="capacity" name="capacity" value="{{ old('capacity') }}" placeholder="Ex: 2 TB">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="os">Système d'Exploitation</label>
                    <input type="text" id="os" name="os" value="{{ old('os') }}" placeholder="Ex: Ubuntu 22.04 LTS">
                </div>

                <div class="form-group">
                    <label for="location">Localisation</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Ex: Salle 3, Rack 12">
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class='bx bx-check'></i> Créer la Ressource
                </button>
                <a href="{{ route('tech.dashboard') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Retour au Dashboard
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
