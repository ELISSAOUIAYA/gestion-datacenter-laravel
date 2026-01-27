<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historique - DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f9f9f9; color: #333; }
        
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        
        /* HEADER */
        .header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 5px solid #2c3e50;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .header h1 { font-size: 1.8rem; margin-bottom: 8px; }
        .header p { color: #666; font-size: 0.95rem; }
        
        /* FILTERS */
        .filters-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .filters-title { font-size: 1rem; font-weight: 700; margin-bottom: 15px; }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .filter-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            font-size: 0.85rem;
        }
        
        .filter-group select, .filter-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            transition: 0.2s;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
        }
        
        /* TABLE */
        .table-wrapper {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead th {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        
        tbody td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        tbody tr:hover {
            background: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-ATTENTE { background: #fff3cd; color: #856404; }
        .status-VALIDÉE { background: #d4edda; color: #155724; }
        .status-REFUSÉE { background: #f8d7da; color: #842029; }
        
        .back-button {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    
    <!-- BACK BUTTON -->
    <div class="back-button">
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
            <i class='bx bxs-chevron-left'></i> Retour au tableau de bord
        </a>
    </div>

    <!-- HEADER -->
    <div class="header">
        <h1><i class='bx bx-history'></i> Historique de Mes Réservations</h1>
        <p>Consultez et filtrez vos réservations passées et présentes</p>
    </div>

    <!-- FILTERS -->
    <div class="filters-section">
        <div class="filters-title">Filtrer</div>
        <form method="GET" action="{{ route('user.history') }}">
            <div class="filters-grid">
                <div class="filter-group">
                    <label for="status">Statut</label>
                    <select id="status" name="status">
                        <option value="">-- Tous les statuts --</option>
                        <option value="EN ATTENTE" {{ request('status') == 'EN ATTENTE' ? 'selected' : '' }}>En Attente</option>
                        <option value="VALIDÉE" {{ request('status') == 'VALIDÉE' ? 'selected' : '' }}>Validée</option>
                        <option value="REFUSÉE" {{ request('status') == 'REFUSÉE' ? 'selected' : '' }}>Refusée</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="resource_id">Ressource</label>
                    <select id="resource_id" name="resource_id">
                        <option value="">-- Toutes les ressources --</option>
                        @foreach($resources as $res)
                            <option value="{{ $res->id }}" {{ request('resource_id') == $res->id ? 'selected' : '' }}>
                                {{ $res->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="start_date">À partir du</label>
                    <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
                
                <div class="filter-group">
                    <label for="end_date">Jusqu'au</label>
                    <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bxs-filter-alt'></i> FILTRER
                </button>
                <a href="{{ route('user.history') }}" class="btn btn-secondary">
                    <i class='bx bxs-refresh'></i> RÉINITIALISER
                </a>
            </div>
        </form>
    </div>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Période</th>
                    <th>Statut</th>
                    <th>Créée le</th>
                    <th>Justification</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td><strong>{{ $res->resource->name }}</strong></td>
                        <td>
                            <small>
                                {{ $res->start_date->format('d/m/Y') }} à {{ $res->start_date->format('H:i') }}<br>
                                au {{ $res->end_date->format('d/m/Y') }} à {{ $res->end_date->format('H:i') }}
                            </small>
                        </td>
                        <td>
                            <span class="status-badge status-{{ str_replace(' ', '-', $res->status) }}">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td>{{ $res->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $res->justification ?? 'Non spécifié' }}</td>
                        <td>
                            <form action="{{ route('user.cancel-reservation', $res->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer l\'annulation ?')">
                                    <i class='bx bxs-trash'></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                            <i class='bx bxs-inbox' style="font-size: 2rem; display: block; margin-bottom: 10px; color: #ddd;"></i>
                            Aucune réservation trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

</body>
</html>