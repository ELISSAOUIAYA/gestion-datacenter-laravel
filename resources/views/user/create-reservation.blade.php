<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle Réservation - DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f5f5f5; color: #333; }
        
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        
        /* BACK LINK */
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: #007bff; text-decoration: none; font-weight: 600; margin-bottom: 30px; }
        .back-link:hover { color: #0056b3; }
        
        /* HEADER */
        .header {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .header h1 { font-size: 2rem; margin-bottom: 10px; }
        .header p { color: #666; }
        
        .resource-info {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .resource-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 20px;
        }
        
        /* AVAILABILITIES TABLE */
        .availabilities-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #1a1d20;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            text-align: left;
            padding: 15px;
            background: #f8f9fa;
            border-bottom: 2px solid #ddd;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #888;
            font-weight: 600;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-validated { background: #d4edda; color: #155724; }
        
        /* FORM */
        .form-section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1d20;
            font-size: 0.9rem;
        }
        
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: 'Segoe UI', Arial, sans-serif;
            transition: 0.2s;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }
        
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .note {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            color: #856404;
            font-size: 0.9rem;
        }
        
        .note strong {
            color: #333;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            transition: 0.2s;
            text-transform: uppercase;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .error {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        .errors {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .errors ul {
            margin: 10px 0 0 20px;
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- BACK LINK -->
    <a href="{{ route('user.dashboard') }}" class="back-link">
        <i class='bx bxs-chevron-left'></i> Retour au tableau de bord
    </a>

    <!-- HEADER -->
    <div class="header">
        <h1>Nouvelle Demande de Réservation</h1>
        <p>Consultez les disponibilités et soumettez votre demande</p>
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

    <!-- FORM -->
    <form action="{{ route('user.store-reservation') }}" method="POST">
        @csrf

        <!-- SELECT RESOURCE -->
        <div class="resource-info">
            <div class="form-group">
                <label for="resource_id">Sélectionnez une ressource *</label>
                <select id="resource_id" name="resource_id" onchange="loadAvailabilities()" required>
                    <option value="">-- Sélectionnez une ressource --</option>
                    @foreach($resources as $res)
                        <option value="{{ $res->id }}" {{ (isset($resource) && $resource->id == $res->id) || old('resource_id') == $res->id ? 'selected' : '' }}>
                            {{ $res->name }} ({{ $res->category->name ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('resource_id') <span class="error">{{ $message }}</span> @enderror
            </div>

            <!-- RESOURCE NAME DISPLAY -->
            <div id="selected-resource" style="display: {{ isset($resource) ? 'block' : 'none' }};">
                <p style="color: #999; margin-bottom: 10px;">Équipement sélectionné :</p>
                <div class="resource-name" id="resource-name-display">{{ isset($resource) ? $resource->name : '-' }}</div>
            </div>
        </div>

        <!-- AVAILABILITIES -->
        <div class="availabilities-section" id="availabilities-section" style="display: none;">
            <div class="section-title">
                <i class='bx bxs-calendar'></i> Disponibilités de l'équipement
            </div>
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
                    <!-- Loaded dynamically -->
                </tbody>
            </table>
        </div>

        <!-- RESERVATION FORM -->
        <div class="form-section">
            <div class="section-title">
                <i class='bx bxs-pencil'></i> Nouvelle demande de réservation
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

            <!-- NOTE -->
            <div class="note">
                <strong>Note :</strong> Avant de valider, vérifiez que vos horaires ne tombent pas dans les créneaux déjà réservés affichés ci-dessus.
            </div>

            <!-- BUTTONS -->
            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bxs-check-circle'></i> Confirmer ma demande de réservation
                </button>
            </div>
        </div>

    </form>

</div>

<script>
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
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: #999;">Pas de réservations. Ressource disponible.</td></tr>';
        } else {
            resource.reservations.forEach(res => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${res.start}</td>
                    <td>${res.end}</td>
                    <td>${res.start_time}</td>
                    <td>${res.end_time}</td>
                    <td><span class="status-badge status-validated">VALIDÉE</span></td>
                `;
                tbody.appendChild(row);
            });
        }
        
        document.getElementById('availabilities-section').style.display = 'block';
    }

    // Load on page load if resource was previously selected
    window.addEventListener('load', loadAvailabilities);
</script>

</body>
</html>