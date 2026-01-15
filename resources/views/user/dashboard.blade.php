<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace IT | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #3498db;
            --bg: #f4f7f6;
            --white: #ffffff;
            --dark: #2c3e50;
            --text-muted: #7f8c8d;
            --danger: #e74c3c;
            --success: #27ae60;
            --warning: #f1c40f;
            --border: #dee2e6;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, sans-serif; }
        body { background-color: var(--bg); color: var(--dark); padding: 30px; }

        /* En-tête (Zone de Navigation) */
        .header-section { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            background: white; 
            padding: 20px 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .nav-group { display: flex; align-items: center; gap: 20px; }
        .nav-link { color: var(--dark); text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .nav-link:hover { color: var(--primary); }
        .nav-active { color: var(--primary); border-bottom: 2px solid var(--primary); }

        .btn-logout { background: #fff5f5; color: var(--danger); border: 1px solid #fed7d7; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-logout:hover { background: var(--danger); color: white; }

        /* Titre et Historique */
        .title-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-history { background-color: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; display: flex; align-items: center; gap: 8px; font-size: 14px; }

        /* Carte de données */
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-header-table { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        
        /* Tableau */
        .res-table { width: 100%; border-collapse: collapse; }
        .res-table th { text-align: left; padding: 12px; background: #f1f3f5; color: #495057; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; border-bottom: 2px solid var(--border); }
        .res-table td { padding: 15px 12px; border-bottom: 1px solid var(--border); font-size: 14px; vertical-align: middle; }

        /* Badges de Statut HAUTE VISIBILITÉ */
        .badge { 
            padding: 8px 15px; 
            border-radius: 50px; 
            font-size: 11px; 
            font-weight: 800; 
            display: inline-flex; 
            align-items: center; 
            gap: 6px; 
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* VERT ÉCLATANT pour Validée */
        .status-validee { 
            background-color: #2ecc71 !important; 
            color: #ffffff !important; 
            border: 2px solid #27ae60; 
        }

        /* JAUNE AMBRE pour En attente */
        .status-en-attente { 
            background-color: #f1c40f !important; 
            color: #000000 !important; 
            border: 2px solid #f39c12; 
        }

        /* ROUGE CORAIL pour Refusée */
        .status-refusee { 
            background-color: #e74c3c !important; 
            color: #ffffff !important; 
            border: 2px solid #c0392b; 
        }

        /* Boutons Actions */
        .btn-incident { 
            background: #fff1f2; 
            color: #e11d48; 
            padding: 8px 12px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-size: 11px; 
            font-weight: bold; 
            transition: 0.3s; 
            display: inline-flex; 
            align-items: center; 
            gap: 5px;
            border: 1px solid #fda4af;
        }
        .btn-incident:hover { background: #e11d48; color: white; }
        
        .btn-new { background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 13px; }
        .no-action { color: #adb5bd; font-size: 11px; font-style: italic; }
    </style>
</head>
<body>

<div class="user-dashboard">
    <div class="header-section">
        <div>
            <h1 style="margin:0; font-size: 22px; color: var(--dark);">Mon Espace IT</h1>
            <p style="margin:5px 0 0; color: var(--text-muted);">Bienvenue, <strong>{{ Auth::user()->name }}</strong></p>
        </div>

        <div class="nav-group">
            <a href="{{ route('welcome') }}" class="nav-link">🏠 Accueil</a>
            <a href="{{ route('user.dashboard') }}" class="nav-link nav-active">📊 Dashboard</a>
            
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">DÉCONNEXION</button>
            </form>
        </div>
    </div>

    <div class="title-bar">
        <h2 style="font-size: 20px;">Mes Réservations en cours</h2>
        <a href="{{ route('user.historique') }}" class="btn-history">
            <i class='bx bx-history'></i> Voir mon Historique
        </a>
    </div>

    <div class="card">
        <div class="card-header-table">
            <h3 style="margin:0; font-size: 16px;">Suivi de mes demandes</h3>
            <a href="{{ route('welcome') }}" class="btn-new">
                <i class='bx bx-plus'></i> Nouvelle Réservation
            </a>
        </div>

        <table class="res-table">
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Période</th>
                    <th>Justification</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr>
                    <td><strong>{{ $res->resource->name }}</strong></td>
                    
                    <td>
                        <span style="font-size: 13px;">
                            <i class='bx bx-calendar-event' style="color: var(--primary);"></i> Du <strong>{{ \Carbon\Carbon::parse($res->start_date)->format('d/m/Y H:i') }}</strong><br>
                            <i class='bx bx-calendar-check' style="color: var(--danger);"></i> au <strong>{{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y H:i') }}</strong>
                        </span>
                    </td>

                    <td><small>{{ $res->justification ?? 'Non spécifiée' }}</small></td>

                    <td>
                        @php 
                            // Mapping manuel pour garantir la couleur même avec les accents
                            $classeBadge = '';
                            $icone = '';

                            if ($res->status == 'VALIDÉE') {
                                $classeBadge = 'status-validee';
                                $icone = 'bx-check-circle';
                            } elseif ($res->status == 'REFUSÉE') {
                                $classeBadge = 'status-refusee';
                                $icone = 'bx-x-circle';
                            } else {
                                $classeBadge = 'status-en-attente';
                                $icone = 'bx-time-five';
                            }
                        @endphp
                        
                        <span class="badge {{ $classeBadge }}">
                            <i class='bx {{ $icone }}'></i> {{ $res->status }}
                        </span>
                    </td>

                    <td>
                        @if($res->status == 'VALIDÉE')
                            <a href="{{ route('incidents.create', ['resource_id' => $res->resource_id]) }}" class="btn-incident">
                                <i class='bx bx-error-alt'></i> Signaler Incident
                            </a>
                        @else
                            <span class="no-action">En attente de validation</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 60px; color: var(--text-muted);">
                        <i class='bx bx-folder-open' style="font-size: 3.5rem; display: block; margin-bottom: 15px; opacity: 0.2;"></i>
                        Vous n'avez aucune réservation enregistrée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>