<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver {{ $resource->name }} | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        :root {
            --bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.7);
            --primary: #38bdf8;
            --primary-glow: rgba(56, 189, 248, 0.15);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            padding: 40px 20px;
            background-image: radial-gradient(circle at 50% -10%, rgba(56, 189, 248, 0.1), transparent);
        }

        .container-res { max-width: 1000px; margin: 0 auto; animation: fadeIn 0.8s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Navigation */
        .top-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .back-link { 
            color: var(--primary); text-decoration: none; font-weight: 700; 
            display: flex; align-items: center; gap: 8px; font-size: 0.9rem;
            transition: 0.3s;
        }
        .back-link:hover { transform: translateX(-5px); opacity: 0.8; }

        .resource-info span { color: var(--text-muted); font-size: 0.8rem; display: block; text-transform: uppercase; letter-spacing: 1px; }
        .resource-info strong { color: #fff; font-size: 1.8rem; font-weight: 800; filter: drop-shadow(0 0 10px rgba(56, 189, 248, 0.3)); }

        /* Card Style */
        .card-res { 
            background: var(--card-bg); 
            backdrop-filter: blur(20px);
            border-radius: 24px; 
            margin-bottom: 25px; 
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-res-header { 
            padding: 20px 30px; 
            display: flex; align-items: center; gap: 12px; 
            background: rgba(255, 255, 255, 0.02);
            border-bottom: 1px solid var(--border);
        }
        .card-res-header i { font-size: 1.5rem; color: var(--primary); }
        .card-res-header h3 { font-size: 1rem; font-weight: 700; color: var(--text-main); text-transform: uppercase; letter-spacing: 1px; }

        /* Table Style */
        .table-container { padding: 20px 30px; overflow-x: auto; }
        .res-table { width: 100%; border-collapse: collapse; }
        .res-table th { 
            text-align: left; padding: 12px 10px; color: var(--text-muted); 
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        }
        .res-table td { padding: 16px 10px; color: var(--text-main); font-size: 0.9rem; border-bottom: 1px solid var(--border); }

        /* Badges */
        .status-pill { 
            padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; 
            display: inline-flex; align-items: center; gap: 5px; 
        }
        .pill-success { background: rgba(52, 211, 153, 0.1); color: #34d399; }
        .pill-waiting { background: rgba(251, 191, 36, 0.1); color: #fbbf24; }

        /* Form */
        .form-content { padding: 30px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

        .form-group label { display: block; color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 10px; }
        .form-group input { 
            width: 100%; padding: 14px; border: 1px solid var(--border); 
            border-radius: 12px; background: rgba(0, 0, 0, 0.2);
            color: #fff; font-size: 0.95rem; outline: none; transition: 0.3s;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 4px var(--primary-glow); }

        .note-box { 
            background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.1);
            border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; 
            color: #fca5a5; font-size: 0.85rem; line-height: 1.5;
        }

        .btn-main { 
            width: 100%; background: var(--primary); color: #020617; 
            border: none; padding: 16px; border-radius: 12px; 
            font-size: 1rem; font-weight: 800; cursor: pointer; 
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: 0.3s;
        }
        .btn-main:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px var(--primary-glow); filter: brightness(1.1); }
    </style>
</head>
<body>

<div class="container-res">
    <div class="top-nav">
        <a href="{{ route('welcome') }}" class="back-link">
            <i class='bx bx-left-arrow-alt'></i> Retour à l'accueil
        </a>
        <div class="resource-info">
            <span>Équipement :</span>
            <strong>{{ $resource->name }}</strong>
        </div>
    </div>

    <div class="card-res">
        <div class="card-res-header">
            <i class='bx bx-calendar-event'></i>
            <h3>Plages Horaires Occupées</h3>
        </div>
        <div class="table-container">
            <table class="res-table">
                <thead>
                    <tr>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Heures (Start - End)</th>
                        <th>État du Slot</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($existingReservations as $res)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($res->start_date)->format('d M, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($res->end_date)->format('d M, Y') }}</td>
                        <td>
                            <span style="color: var(--primary)">{{ \Carbon\Carbon::parse($res->start_date)->format('H:i') }}</span> 
                            - {{ \Carbon\Carbon::parse($res->end_date)->format('H:i') }}
                        </td>
                        <td>
                            @if($res->status == 'VALIDÉE')
                                <span class="status-pill pill-success"><i class='bx bx-check-circle'></i> Occupé</span>
                            @else
                                <span class="status-pill pill-waiting"><i class='bx bx-timer'></i> En attente</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class='bx bx-Select-multiple' style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                            Aucun créneau réservé pour le moment.
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
            <h3>Nouvelle Réservation</h3>
        </div>
        <div class="form-content">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Date & Heure de début</label>
                        <input type="datetime-local" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label>Date & Heure de fin</label>
                        <input type="datetime-local" name="end_date" required>
                    </div>
                </div>

                <div class="note-box">
                    <strong>Attention :</strong> Système de validation automatique activé. Assurez-vous que votre créneau ne chevauche pas une réservation existante.
                </div>

                <button type="submit" class="btn-main">
                    <i class='bx bx-send'></i> Confirmer la réservation
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>