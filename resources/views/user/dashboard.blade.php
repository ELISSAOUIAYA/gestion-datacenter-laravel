<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace IT | Dark Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        :root {
            --bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.9);
            --primary: #38bdf8;
            --primary-hover: #0ea5e9;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.1);
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body { 
            background-color: var(--bg); 
            color: var(--text-main); 
            padding: 20px;
            background-image: radial-gradient(circle at 80% 20%, rgba(56, 189, 248, 0.05), transparent 50%);
            min-height: 100vh;
        }

        .container { max-width: 1150px; margin: 0 auto; }

        /* --- NAVIGATION --- */
        .nav-bar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px 30px; background: var(--card-bg); border-radius: 20px;
            border: 1px solid var(--border); margin-bottom: 35px; backdrop-filter: blur(12px);
            position: sticky; top: 20px; z-index: 1000;
        }

        .nav-left { display: flex; align-items: center; gap: 10px; font-weight: 800; font-size: 1.3rem; color: var(--primary); }
        .nav-right { display: flex; align-items: center; gap: 25px; }
        .nav-link { color: var(--text-main); text-decoration: none; font-size: 0.9rem; font-weight: 600; transition: 0.3s; }
        .nav-link:hover { color: var(--primary); }

        /* Notification System */
        .notif-container { position: relative; }
        .notif-trigger { 
            font-size: 1.5rem; color: var(--text-muted); cursor: pointer; transition: 0.3s; position: relative;
        }
        .notif-trigger:hover { color: var(--primary); }
        .badge-dot { 
            position: absolute; top: 2px; right: 2px; width: 10px; height: 10px; 
            background: var(--danger); border-radius: 50%; border: 2px solid var(--bg);
        }

        .notif-dropdown {
            position: absolute; top: 160%; right: 0; width: 320px; background: #0f172a;
            border: 1px solid var(--border); border-radius: 15px; display: none;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); overflow: hidden;
        }
        .notif-dropdown.active { display: block; animation: fadeIn 0.3s ease; }

        .notif-header { padding: 15px; font-weight: 800; font-size: 0.8rem; border-bottom: 1px solid var(--border); background: rgba(255,255,255,0.02); color: var(--primary); }
        .notif-item { padding: 15px; border-bottom: 1px solid var(--border); transition: 0.3s; cursor: pointer; }
        .notif-item:hover { background: rgba(56, 189, 248, 0.05); }
        .notif-item strong { display: block; color: var(--primary); font-size: 0.85rem; margin-bottom: 3px; }
        .notif-item p { font-size: 0.75rem; color: var(--text-muted); line-height: 1.4; }

        /* --- CARDS & TABLES --- */
        .card { 
            background: var(--card-bg); border-radius: 24px; border: 1px solid var(--border);
            padding: 30px; margin-bottom: 30px; backdrop-filter: blur(10px);
        }

        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .card-title { display: flex; align-items: center; gap: 12px; font-size: 1.1rem; font-weight: 700; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1.5px; border-bottom: 1px solid var(--border); }
        td { padding: 20px 15px; border-bottom: 1px solid var(--border); font-size: 0.9rem; }

        .status { padding: 6px 14px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
        .status-valid { background: rgba(16, 185, 129, 0.1); color: var(--success); }
        .status-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning); }

        .btn { padding: 10px 20px; border-radius: 12px; border: none; font-weight: 700; cursor: pointer; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; font-size: 0.85rem; }
        .btn-primary { background: var(--primary); color: #000; }
        .btn-logout { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<div class="container">
    <nav class="nav-bar">
        <div class="nav-left">
            <i class='bx bxs-bolt-circle'></i> SMART RESERVATION
        </div>
        
        <div class="nav-right">
            <a href="{{ route('welcome') }}" class="nav-link">Accueil</a>
            <a href="{{ route('user.dashboard') }}" class="nav-link" style="color: var(--primary);">Tableau de bord</a>
            <a href="{{ route('user.historique') }}" class="nav-link"><i class='bx bx-history'></i> Historique</a>
            
            <div class="notif-container" id="notifContainer">
                <div class="notif-trigger" id="notifBtn">
                    <i class='bx bxs-bell'></i>
                    @if(auth()->user()->notifications()->where('is_read', false)->count() > 0)
                        <span class="badge-dot" id="notifBadge"></span>
                    @endif
                </div>
                <div class="notif-dropdown" id="notifDropdown">
                    <div class="notif-header">NOTIFICATIONS RÉCENTES</div>
                    <div id="notifList">
                        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notif)
                            <div class="notif-item" style="{{ !$notif->is_read ? 'border-left: 3px solid var(--primary); background: rgba(56, 189, 248, 0.02);' : '' }}">
                                <strong>{{ $notif->title }}</strong>
                                <p>{{ $notif->message }}</p>
                                <small style="display:block; margin-top:5px; opacity:0.6; font-size:10px;">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                        @empty
                            <div class="notif-item" style="text-align: center;">Aucune notification</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class='bx bx-log-out'></i> Quitter
                </button>
            </form>
        </div>
    </nav>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class='bx bx-list-ul' style="color: var(--primary); font-size: 1.5rem;"></i>
                Mes Réservations Actives
            </div>
            <a href="{{ route('welcome') }}" class="btn btn-primary">
                <i class='bx bx-plus'></i> Nouveau Projet
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Équipement</th>
                    <th>Période</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                <tr>
                    <td>
                        <div style="font-weight: 700;">{{ $res->resource->name }}</div>
                        <div style="color: var(--text-muted); font-size: 0.75rem;">ID: #{{ $res->id }}</div>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem;">
                            {{ \Carbon\Carbon::parse($res->start_date)->format('d M, H:i') }} 
                            <i class='bx bx-right-arrow-alt' style="color: var(--primary);"></i>
                            {{ \Carbon\Carbon::parse($res->end_date)->format('d M, H:i') }}
                        </div>
                    </td>
                    <td>
                        <span class="status {{ $res->status == 'VALIDÉE' ? 'status-valid' : 'status-pending' }}">
                            <i class='bx {{ $res->status == "VALIDÉE" ? "bx-check-circle" : "bx-time-five" }}'></i>
                            {{ $res->status }}
                        </span>
                    </td>
                    <td>
                        @if($res->status == 'VALIDÉE')
                            <a href="{{ route('incidents.create', ['resource_id' => $res->resource_id]) }}" class="btn" style="border: 1px solid var(--border); color: var(--text-main);">
                                <i class='bx bx-error'></i> Signaler
                            </a>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.8rem; font-style: italic;">En attente...</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">Aucune réservation active.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    const badge = document.getElementById('notifBadge');

    notifBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        notifDropdown.classList.toggle('active');

        
        if (notifDropdown.classList.contains('active') && badge) {
            
            fetch("{{ route('notifications.markRead') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    badge.style.display = 'none'; ا
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });

    document.addEventListener('click', (e) => {
        if (!notifDropdown.contains(e.target) && e.target !== notifBtn) {
            notifDropdown.classList.remove('active');
        }
    });
</script>

</body>
</html>