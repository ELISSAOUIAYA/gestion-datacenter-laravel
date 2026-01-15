<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique IT | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #3498db;
            --bg: #f4f7f6;
            --white: #ffffff;
            --dark: #2c3e50;
            --text-muted: #7f8c8d;
            --danger: #e74c3c;
            --border: #dee2e6;
        }

        body { font-family: 'Segoe UI', sans-serif; background-color: var(--bg); color: var(--dark); padding: 30px; }
        .container { max-width: 1100px; margin: 0 auto; }

        /* Header Section */
        .header-section { 
            display: flex; justify-content: space-between; align-items: center; 
            background: var(--white); padding: 20px 30px; border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; 
        }
        .nav-link { color: var(--dark); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; }

        /* Card Style */
        .card { background: var(--white); padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }

        /* Table Style */
        .res-table { width: 100%; border-collapse: collapse; }
        .res-table th { 
            text-align: left; padding: 12px; background: #f1f3f5; color: #495057; 
            text-transform: uppercase; font-size: 11px; letter-spacing: 1px; 
        }
        .res-table td { padding: 15px 12px; border-bottom: 1px solid var(--border); font-size: 14px; }
        
        /* Badge Statuts (Indispensable pour l'affichage) */
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; }
        .status-en-attente { background-color: #fef9c3; color: #854d0e; }
        .status-validee { background-color: #dcfce7; color: #166534; }
        .status-refusee { background-color: #fee2e2; color: #991b1b; }

        .btn-delete { 
            background: #fff5f5; color: var(--danger); border: 1px solid #fed7d7; 
            padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: 0.3s;
        }
        .btn-delete:hover { background: var(--danger); color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <div>
            <h1 style="margin:0; font-size: 24px;">Historique des Réservations</h1>
            <p style="margin:5px 0 0; color: var(--text-muted);">Consultation de toutes vos demandes passées</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="nav-link">
            <i class='bx bx-left-arrow-alt'></i> Retour au Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="margin:0;"><i class='bx bx-list-ul'></i> Liste complète</h3>
        </div>

        <table class="res-table">
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Période</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr>
                    <td><strong>{{ $res->resource->name }}</strong></td>
                    <td>
                        <i class='bx bx-calendar' style="color: var(--primary);"></i> 
                        Du {{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y') }} 
                        au {{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y') }}
                    </td>
                    <td>
                        @php $statusClass = str_replace(' ', '-', strtolower($res->status)); @endphp
                        <span class="badge status-{{ $statusClass }}">
                            @if($res->status == 'EN ATTENTE') <i class='bx bx-time'></i> 
                            @elseif($res->status == 'VALIDÉE') <i class='bx bx-check-circle'></i> 
                            @elseif($res->status == 'REFUSÉE') <i class='bx bx-x-circle'></i> 
                            @endif
                            {{ $res->status }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette archive ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"><i class='bx bx-trash'></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        Aucun historique disponible pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>