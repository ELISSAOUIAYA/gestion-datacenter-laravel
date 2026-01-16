<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique IT | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.8);
            --primary: #38bdf8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --danger: #fb7185;
            --success: #34d399;
            --warning: #fbbf24;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { 
            background-color: var(--bg); 
            color: var(--text-main); 
            padding: 30px; 
            background-image: radial-gradient(circle at bottom left, rgba(56, 189, 248, 0.05) 0%, transparent 40%);
        }

        .container { max-width: 1100px; margin: 0 auto; animation: fadeIn 0.6s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Header Section */
        .header-section { 
            display: flex; justify-content: space-between; align-items: center; 
            background: var(--card-bg); backdrop-filter: blur(20px); 
            padding: 25px 35px; border-radius: 20px; border: 1px solid var(--border);
            margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .header-title h1 { font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .header-title p { color: var(--text-muted); font-size: 14px; margin-top: 4px; }

        .nav-link { 
            color: var(--primary); text-decoration: none; font-weight: 700; 
            display: flex; align-items: center; gap: 8px; font-size: 14px;
            transition: 0.3s; padding: 10px 18px; border-radius: 12px; background: rgba(56, 189, 248, 0.05);
        }
        .nav-link:hover { background: rgba(56, 189, 248, 0.15); transform: translateX(-5px); }

        /* Card Style */
        .card { 
            background: var(--card-bg); backdrop-filter: blur(20px); 
            padding: 30px; border-radius: 24px; border: 1px solid var(--border); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        .card-header { margin-bottom: 25px; display: flex; align-items: center; gap: 12px; }
        .card-header i { font-size: 24px; color: var(--primary); }
        .card-header h3 { font-size: 16px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }

        /* Table Style */
        .res-table { width: 100%; border-collapse: collapse; }
        .res-table th { 
            text-align: left; padding: 15px; color: var(--text-muted); 
            text-transform: uppercase; font-size: 11px; font-weight: 700; 
            letter-spacing: 1px; border-bottom: 2px solid var(--border);
        }
        .res-table td { padding: 20px 15px; border-bottom: 1px solid var(--border); font-size: 14px; color: var(--text-main); }
        .res-table tr:last-child td { border-bottom: none; }

        /* Badge Statuts */
        .badge { 
            padding: 6px 14px; border-radius: 10px; font-size: 11px; font-weight: 800; 
            display: inline-flex; align-items: center; gap: 6px; text-transform: uppercase;
        }
        .status-en-attente { background: rgba(251, 191, 36, 0.1); color: var(--warning); border: 1px solid rgba(251, 191, 36, 0.1); }
        .status-validee { background: rgba(52, 211, 153, 0.1); color: var(--success); border: 1px solid rgba(52, 211, 153, 0.1); }
        .status-refusee { background: rgba(251, 113, 133, 0.1); color: var(--danger); border: 1px solid rgba(251, 113, 133, 0.1); }

        /* Action Buttons */
        .btn-delete { 
            background: rgba(251, 113, 133, 0.1); color: var(--danger); border: 1px solid rgba(251, 113, 133, 0.2); 
            padding: 10px; border-radius: 10px; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .btn-delete:hover { background: var(--danger); color: var(--bg); transform: scale(1.1); }

        .resource-name { display: flex; align-items: center; gap: 10px; font-weight: 700; }
        .resource-icon { width: 32px; height: 32px; background: rgba(255,255,255,0.05); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary); }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <div class="header-title">
            <h1>Archives & Historique</h1>
            <p>Historique complet de vos interactions DataCenter</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="nav-link">
            <i class='bx bx-left-arrow-alt'></i> Retour Dashboard
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class='bx bx-time-five'></i>
            <h3>Journal des Réservations</h3>
        </div>

        <div style="overflow-x: auto;">
            <table class="res-table">
                <thead>
                    <tr>
                        <th>Équipement</th>
                        <th>Période de Location</th>
                        <th>Statut Final</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $res)
                    <tr>
                        <td>
                            <div class="resource-name">
                                <div class="resource-icon"><i class='bx bx-hdd'></i></div>
                                {{ $res->resource->name }}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <span style="font-size: 13px;"><i class='bx bx-calendar' style="color: var(--primary); margin-right: 5px;"></i>{{ \Carbon\Carbon::parse($res->start_date)->format('d M Y') }}</span>
                                <span style="font-size: 11px; opacity: 0.6;">au {{ \Carbon\Carbon::parse($res->end_date)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td>
                            @php 
                                $statusSlug = str_replace(' ', '-', strtolower($res->status));
                                $icon = 'bx-loader-circle';
                                if($res->status == 'VALIDÉE') $icon = 'bx-check-double';
                                if($res->status == 'REFUSÉE') $icon = 'bx-error-circle';
                            @endphp
                            <span class="badge status-{{ $statusSlug }}">
                                <i class='bx {{ $icon }}'></i> {{ $res->status }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; justify-content: center;">
                                <form action="{{ route('reservations.destroy', $res->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette archive ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete" title="Supprimer de l'historique">
                                        <i class='bx bx-trash-alt'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 60px;">
                            <i class='bx bx-folder-open' style="font-size: 3rem; color: var(--border); display: block; margin-bottom: 15px;"></i>
                            <p style="color: var(--text-muted); font-style: italic;">Aucune archive trouvée.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>