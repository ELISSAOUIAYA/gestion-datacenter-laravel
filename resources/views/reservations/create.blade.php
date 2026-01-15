<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver {{ $resource->name }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { 
            background-color: #f8fafc; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 40px 20px;
        }

        .container-res { max-width: 950px; margin: 0 auto; }

        /* Navigation */
        .top-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .back-link { color: #3b82f6; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 15px; }
        .resource-info { text-align: right; }
        .resource-info span { color: #94a3b8; font-size: 13px; display: block; }
        .resource-info strong { color: #1d76f2; font-size: 24px; font-weight: 800; }

        /* Style des Cartes */
        .card-res { 
            background: white; 
            border-radius: 20px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.02); 
            margin-bottom: 30px; 
            border: 1px solid #f1f5f9;
        }
        .card-res-header { 
            padding: 25px 35px; 
            display: flex; 
            align-items: center; 
            gap: 15px; 
            border-bottom: 1px solid #f8fafc;
        }
        .card-res-header i { font-size: 24px; color: #1d76f2; }
        .card-res-header h3 { 
            font-size: 17px; 
            font-weight: 800; 
            color: #334155; 
            text-transform: uppercase; 
            letter-spacing: 0.8px;
            margin: 0;
        }

        /* Tableau mis à jour avec Date Début et Fin */
        .table-container { padding: 10px 35px 30px 35px; }
        .res-table { width: 100%; border-collapse: collapse; }
        .res-table th { 
            text-align: left; 
            padding: 15px 5px; 
            color: #94a3b8; 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase; 
        }
        .res-table td { padding: 20px 5px; color: #334155; font-size: 14px; font-weight: 600; border-bottom: 1px solid #f8fafc; }
      /* Badge État Dynamique */
.status-pill { 
    padding: 6px 14px; 
    border-radius: 20px; 
    font-size: 11px; 
    font-weight: 700; 
    display: inline-flex; 
    align-items: center; 
    gap: 6px; 
}

/* Style pour VALIDÉE (Vert) */
.pill-success { 
    background-color: #dcfce7; 
    color: #166534; 
}

/* Style pour EN ATTENTE (Jaune) */
.pill-waiting { 
    background-color: #fef9c3; 
    color: #854d0e; 
} 
        /* Formulaire */
        .form-content { padding: 30px 35px 35px 35px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .form-group label { display: block; color: #64748b; font-size: 14px; font-weight: 600; margin-bottom: 12px; }
        .form-group input { 
            width: 100%; 
            padding: 15px; 
            border: 1.5px solid #f1f5f9; 
            border-radius: 12px; 
            background: #f8fafc;
            color: #334155;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
        }

        /* Note Rouge */
        .note-box { 
            background-color: #fef2f2; 
            border-radius: 12px; 
            padding: 20px 25px; 
            margin-bottom: 30px; 
            color: #b91c1c; 
            font-size: 14px;
            line-height: 1.5;
        }
        .note-box strong { font-weight: 800; }

        /* Bouton Bleu */
        .btn-main { 
            width: 100%; 
            background-color: #1d76f2; 
            color: white; 
            border: none; 
            padding: 20px; 
            border-radius: 15px; 
            font-size: 16px; 
            font-weight: 700; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 12px;
            transition: background 0.2s;
        }
        .btn-main:hover { background-color: #1a6bd9; }
    </style>
</head>
<body>

<div class="container-res">
    <div class="top-nav">
        <a href="{{ route('welcome') }}" class="back-link">
            <i class='bx bx-left-arrow-alt'></i> Retour à l'accueil
        </a>
        <div class="resource-info">
            <span>Équipement sélectionné :</span>
            <strong>{{ $resource->name }}</strong>
        </div>
    </div>

    <div class="card-res">
        <div class="card-res-header">
            <i class='bx bx-calendar'></i>
            <h3>Disponibilités de l'équipement</h3>
        </div>
        <div class="table-container">
            <table class="res-table">
                <thead>
                    <tr>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Heure début</th>
                        <th>Heure fin</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
    @forelse($existingReservations as $res)
    <tr>
        <td>{{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($res->start_date)->format('H:i') }}</td>
        <td>{{ \Carbon\Carbon::parse($res->end_date)->format('H:i') }}</td>
        <td>
            @if($res->status == 'VALIDÉE')
                <span class="status-pill pill-success">
                    <i class='bx bx-check'></i> VALIDÉE
                </span>
            @else
                <span class="status-pill pill-waiting">
                    <i class='bx bx-time'></i> EN ATTENTE
                </span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" style="text-align: center; color: #94a3b8; padding: 30px;">
            Aucune réservation occupée.
        </td>
    </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>

    

    <div class="card-res">
        <div class="card-res-header">
            <i class='bx bx-edit-alt'></i>
            <h3>Nouvelle demande de réservation</h3>
        </div>
        <div class="form-content">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Début de la réservation</label>
                        <input type="datetime-local" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label>Fin de la réservation</label>
                        <input type="datetime-local" name="end_date" required>
                    </div>
                </div>

                <div class="note-box">
                    <strong>Note :</strong> Avant de valider, vérifiez que vos horaires ne tombent pas dans les créneaux déjà réservés affichés ci-dessus.
                </div>

                <button type="submit" class="btn-main">
                    <i class='bx bx-paper-plane'></i> Confirmer ma demande de réservation
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>