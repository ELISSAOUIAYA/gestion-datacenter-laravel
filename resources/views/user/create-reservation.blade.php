@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --primary-hover: #0ea5e9;
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Fond des cartes */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.08);
        --input-bg: #1e293b;        /* Fond des champs */
        --success: #22c55e;
        --warning: #f59e0b;
        --danger: #ef4444;
    }

    body { 
        margin: 0; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }

    /* BACK LINK */
    .back-link { 
        display: inline-flex; 
        align-items: center; 
        gap: 8px; 
        color: var(--primary); 
        text-decoration: none; 
        font-weight: 700; 
        margin-bottom: 30px; 
        transition: 0.3s;
    }
    .back-link:hover { color: var(--primary-hover); transform: translateX(-5px); }

    /* SECTIONS (HEADER, INFO, FORM) */
    .section-box {
        background: var(--bg-card);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        border: 1px solid var(--border);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }

    .header-box { border-left: 6px solid var(--primary); }
    .header-box h1 { font-size: 2rem; margin-bottom: 10px; font-weight: 800; }
    .header-box p { color: var(--text-muted); }

    .resource-name {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 20px;
        text-shadow: 0 0 10px rgba(56, 189, 248, 0.2);
    }

    /* TITRE DE SECTION AVEC ICONE */
    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* TABLEAU DES DISPONIBILITÉS */
    table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; }
    th {
        text-align: left;
        padding: 15px;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 2px solid var(--border);
        font-size: 0.75rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        letter-spacing: 1px;
    }
    td { padding: 15px; border-bottom: 1px solid var(--border); color: var(--text-main); font-size: 0.9rem; }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .status-validated { background: rgba(34, 197, 94, 0.2); color: var(--success); }

    /* FORMULAIRE */
    .form-group { margin-bottom: 25px; }
    label {
        display: block;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--text-muted);
        font-size: 0.85rem;
        text-transform: uppercase;
    }
    input, select, textarea {
        width: 100%;
        padding: 14px;
        background-color: var(--input-bg);
        border: 1px solid var(--border);
        border-radius: 10px;
        color: white;
        font-size: 0.95rem;
        font-family: inherit;
        transition: 0.3s;
    }
    input:focus, select:focus, textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
    }
    textarea { resize: vertical; min-height: 120px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media(max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

    /* NOTE & ALERTES */
    .note {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid var(--warning);
        padding: 15px;
        border-radius: 10px;
        margin-top: 25px;
        color: var(--warning);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .note i { font-size: 1.2rem; }

    .btn {
        padding: 14px 30px;
        border: none;
        border-radius: 10px;
        font-weight: 800;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.9rem;
        transition: 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-primary { background: var(--primary); color: #020617; }
    .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }

    .error { color: var(--danger); font-size: 0.85rem; margin-top: 5px; }
    .errors {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid var(--danger);
        color: #fca5a5;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
    }
    .errors ul { margin: 10px 0 0 20px; }

    /* Hide redundant elements if any */
    .sidebar, .left-sidebar { display: none !important; }
</style>

<div class="container">
    
    <a href="{{ route('user.dashboard') }}" class="back-link">
        <i class='bx bxs-chevron-left'></i> Retour au tableau de bord
    </a>

    <div class="section-box header-box">
        <h1>Nouvelle Demande de Réservation</h1>
        <p>Consultez les disponibilités et soumettez votre demande</p>
    </div>

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

    <form action="{{ route('user.store-reservation') }}" method="POST">
        @csrf

        <div class="section-box">
            <div class="form-group">
                <label for="resource_id">Sélectionnez une ressource *</label>
                <select id="resource_id" name="resource_id" onchange="loadAvailabilities()" required>
                    <option value="" style="background: var(--bg-card);">-- Sélectionnez une ressource --</option>
                    @foreach($resources as $res)
                        <option value="{{ $res->id }}" {{ (isset($resource) && $resource->id == $res->id) || old('resource_id') == $res->id ? 'selected' : '' }} style="background: var(--bg-card);">
                            {{ $res->name }} ({{ $res->category->name ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('resource_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div id="selected-resource" style="display: {{ isset($resource) ? 'block' : 'none' }}; border-top: 1px solid var(--border); padding-top: 20px;">
                <p style="color: var(--text-muted); margin-bottom: 10px; font-size: 0.8rem;">Équipement sélectionné :</p>
                <div class="resource-name" id="resource-name-display">{{ isset($resource) ? $resource->name : '-' }}</div>
            </div>
        </div>

        <div class="section-box" id="availabilities-section" style="display: none;">
            <div class="section-title">
                <i class='bx bxs-calendar'></i> Disponibilités de l'équipement
            </div>
            <div style="overflow-x: auto;">
                <table id="availabilities-table">
                    <thead>
                        <tr>
                            <th>Date Début</th>
                            <th>Date Fin</th>
                            <th>Heure Début</th>
                            <th>Heure Fin</th>
                            <th>État</th>
                        </tr>
                    </thead>
                    <tbody id="availabilities-body">
                        </tbody>
                </table>
            </div>
        </div>

        <div class="section-box">
            <div class="section-title">
                <i class='bx bxs-pencil'></i> Paramètres de la réservation
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">Début de la réservation *</label>
                    <input type="datetime-local" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Fin de la réservation *</label>
                    <input type="datetime-local" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                    @error('end_date') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="justification">Justification / Motif de la demande *</label>
                <textarea id="justification" name="justification" required placeholder="Décrivez pourquoi vous avez besoin de cette ressource...">{{ old('justification') }}</textarea>
                @error('justification') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="note">
                <i class='bx bx-info-circle'></i>
                <span><strong>Note :</strong> Avant de valider, vérifiez que vos horaires ne tombent pas dans les créneaux déjà réservés affichés ci-dessus.</span>
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bxs-check-circle'></i> Confirmer ma demande de réservation
                </button>
            </div>
        </div>

    </form>

</div>



<script>
    /* CONSERVATION DE LA LOGIQUE JAVASCRIPT ORIGINALE */
    const resourcesData = {!! json_encode($resources->keyBy('id')->map(fn($r) => [
        'id' => $r->id,
        'name' => $r->name,
        'reservations' => $r->reservations()->where('status', '!=', 'REFUSÉE')->get()->map(fn($res) => [
            'start' => $res->start_date->format('d/m/Y'),
            'end' => $res->end_date->format('d/m/Y'),
            'start_time' => $res->start_date->format('H:i'),
            'end_time' => $res->end_date->format('H:i'),
        ])
    ])) !!};

    function loadAvailabilities() {
        const resourceId = document.getElementById('resource_id').value;
        
        if (!resourceId) {
            document.getElementById('availabilities-section').style.display = 'none';
            document.getElementById('selected-resource').style.display = 'none';
            return;
        }

        const resource = resourcesData[resourceId];
        
        // Show resource name
        document.getElementById('resource-name-display').textContent = resource.name;
        document.getElementById('selected-resource').style.display = 'block';
        
        // Load reservations
        const tbody = document.getElementById('availabilities-body');
        tbody.innerHTML = '';
        
        if (resource.reservations.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Pas de réservations. Ressource disponible.</td></tr>';
        } else {
            resource.reservations.forEach(res => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${res.start}</td>
                    <td>${res.end}</td>
                    <td>${res.start_time}</td>
                    <td>${res.end_time}</td>
                    <td><span class="status-badge status-validated">VALIDÉE / OCCUPÉ</span></td>
                `;
                tbody.appendChild(row);
            });
        }
        
        document.getElementById('availabilities-section').style.display = 'block';
    }

    // Load on page load if resource was previously selected
    window.addEventListener('load', loadAvailabilities);
</script>

@endsection