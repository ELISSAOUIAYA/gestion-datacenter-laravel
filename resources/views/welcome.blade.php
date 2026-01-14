<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataCenter Pro | Infrastructure</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        /* Variables de design et thèmes */
        :root {
            --primary: #007bff;
            --primary-hover: #0056b3;
            --bg-body: #f4f7f6;
            --bg-card: #ffffff;
            --text-main: #333;
            --text-muted: #666;
            --border-color: #eee;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --dark: #1a1d20;
        }

        [data-theme="dark"] {
            --bg-body: #121212;
            --bg-card: #1e1e1e;
            --text-main: #e0e0e0;
            --text-muted: #aaa;
            --border-color: #333;
            --dark: #000;
        }

        /* Reset & Base */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); transition: 0.3s; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        /* Layout */
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* Navbar */
        .navbar { background: var(--dark); color: white; padding: 1rem 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; display: flex; align-items: center; gap: 8px; }
        .logo span { color: var(--primary); }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        /* --- STYLE DU SYSTÈME DE NOTIFICATIONS --- */
.notif-wrapper { 
    position: relative; 
    cursor: pointer; 
    display: flex;
    align-items: center;
}

.notif-trigger { 
    font-size: 1.3rem; 
    display: flex; 
    align-items: center; 
    color: white; 
    padding: 5px; 
    position: relative;
}

.notif-badge { 
    position: absolute; 
    top: 0; 
    right: -2px; 
    background: var(--danger); 
    color: white; 
    font-size: 0.6rem; 
    padding: 2px 5px; 
    border-radius: 10px; 
    font-weight: bold;
    line-height: 1;
}

/* Le menu caché par défaut */
.notif-dropdown { 
    position: absolute; 
    top: 100%; 
    right: 0; 
    width: 280px; 
    background: var(--bg-card); 
    border: 1px solid var(--border-color);
    border-radius: 8px; 
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    display: none; /* Caché */
    color: var(--text-main); 
    margin-top: 15px;
    z-index: 2000;
}


.notif-header { 
    padding: 12px; 
    font-weight: bold; 
    border-bottom: 1px solid var(--border-color); 
    display: flex; 
    justify-content: space-between; 
    align-items: center;
    background: rgba(0,0,0,0.02);
}

.notif-body { 
    max-height: 300px; 
    overflow-y: auto; 
}

.notif-item { 
    padding: 12px; 
    border-bottom: 1px solid var(--border-color); 
    font-size: 0.85rem; 
    transition: 0.2s;
}

.notif-item:hover {
    background: rgba(0,0,0,0.02);
}

.notif-item.unread { 
    border-left: 4px solid var(--primary); 
    background: rgba(0,123,255,0.05); 
}

.notif-item strong {
    display: block;
    margin-bottom: 3px;
    font-size: 0.85rem;
}

.notif-item p { 
    margin: 0; 
    color: var(--text-muted); 
    font-size: 0.8rem; 
    line-height: 1.3; 
}

.notif-item small { 
    display: block;
    margin-top: 5px;
    font-size: 0.7rem; 
    opacity: 0.6; 
}
.notif-badge {
    transition: opacity 0.3s ease;
}
.notif-item.unread {
    background-color: #f0f7ff; /* Un léger bleu pour les messages non lus */
}

        /* Hero Section */
        .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1558494949-ef010cbdcc51?q=80&w=1600') no-repeat center/cover;
                color: white; text-align: center; padding: 80px 20px; }
        .hero h1 { font-size: 2.5rem; margin-bottom: 10px; }

        /* Tables & Sections */
        section { margin: 40px 0; }
        h4 { margin-bottom: 20px; font-size: 1.3rem; border-left: 4px solid var(--primary); padding-left: 10px; }

        .table-container { background: var(--bg-card); border-radius: 10px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border-color); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: rgba(0,0,0,0.02); padding: 15px; font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); border-bottom: 2px solid var(--border-color); }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 0.9rem; }

        /* Status & Badges */
        .status-pill { padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }
        .status-available { background: #d4edda; color: #155724; }
        .status-occupied { background: #fff3cd; color: #856404; }
        .status-maintenance { background: #f8d7da; color: #721c24; }

        /* Buttons */
        .btn { padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; border: none; transition: 0.2s; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 5px; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-success { background: var(--success); color: white; }
        .btn-outline-danger { background: transparent; border: 1px solid var(--danger); color: var(--danger); }

        .theme-toggle { position: fixed; bottom: 30px; right: 30px; padding: 12px 20px; border-radius: 50px; background: var(--dark); color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 1000; }
        footer { text-align: center; padding: 40px; background: var(--dark); color: white; font-size: 0.8rem; margin-top: 60px; }
        .notif-dropdown.show {
    display: block !important; /* Force l'affichage */
}
    </style>
</head>

<body data-theme="light">

    <<nav class="navbar">
    <div class="container nav-content">
        <a href="{{ url('/') }}" class="logo">
            <i class='bx bxs-server'></i> DataCenter <span>Pro</span>
        </a>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Accueil</a></li>
            
            @guest
                <li><a href="{{ route('login') }}">Connexion</a></li>
                <li><a href="{{ route('register') }}" class="btn btn-primary">Inscription</a></li>
            @else
                <li class="notif-wrapper" id="notifBtn">
                    <div class="notif-trigger">
                        <i class='bx bxs-bell'></i>
                        @php 
                            $uCount = Auth::user()->notifications()->where('is_read', false)->count(); 
                        @endphp
                        @if($uCount > 0) 
                            <span class="notif-badge">{{ $uCount }}</span> 
                        @endif
                    </div>
                    <div class="notif-dropdown">
                        <div class="notif-header">
                            <span>Messages</span> 
                            <small style="color: var(--primary);">{{ $uCount }} nouveaux</small>
                        </div>
                        <div class="notif-body">
                            @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $n)
                                <div class="notif-item {{ $n->is_read ? '' : 'unread' }}">
                                    <strong>{{ $n->title }}</strong>
                                    <p>{{ $n->message }}</p>
                                    <small>{{ $n->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <div style="padding:20px; text-align:center; color:gray; font-size: 0.8rem;">
                                    Aucune notification
                                </div>
                            @endforelse
                        </div>
                    </div>
                </li>

                <li><a href="{{ route('user.dashboard') }}"><strong>Mon Dashboard</strong></a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Quitter</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>
    <header class="hero">
        <div class="container">
            <h1>Supervision de l'Infrastructure</h1>
            <p>Accès en temps réel aux ressources critiques du Data Center.</p>
        </div>
    </header>

    <main class="container">
        
        @if(session('success'))
            <div style="background: var(--success); color: white; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <i class='bx bxs-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        <section id="ressources">
            <h4><i class='bx bx-hdd'></i> Inventaire des Ressources</h4>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Capacité / Spécifications</th>
                            <th>État</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $resource)
                        <tr>
                            <td><strong>{{ $resource->name }}</strong></td>
                            <td>
                                <span style="color: var(--primary); font-weight: 600; font-size: 0.8rem; text-transform: uppercase;">
                                    {{ $resource->type ?? 'Serveur' }}
                                </span>
                            </td>
                            <td>
                                <small>
                                    @if($resource->cpu) CPU: {{ $resource->cpu }} | @endif
                                    @if($resource->ram) RAM: {{ $resource->ram }} | @endif
                                    {{ $resource->capacity ?? 'N/A' }}
                                </small>
                            </td>
                            <td>
                                <span class="status-pill status-{{ $resource->status }}">
                                    @if($resource->status == 'available') DISPONIBLE 
                                    @elseif($resource->status == 'occupied') OCCUPÉ
                                    @else MAINTENANCE @endif
                                </span>
                            </td>
                            <td style="text-align: center;">
                                @auth
                                    @if($resource->status == 'available')
                                        <a href="{{ route('reservations.create', ['resource' => $resource->id]) }}" class="btn btn-success">
                                            RESERVER
                                        </a>
                                    @else
                                        <span style="font-size: 0.7rem; color: var(--text-muted);">INDISPONIBLE</span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">LOGIN</a>
                                @endauth
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    const notifBtn = document.getElementById('notifBtn');
    
    if (notifBtn) {
        notifBtn.addEventListener('click', function() {
            // 1. Envoyer la requête au serveur
            fetch("{{ route('notifications.markRead') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // 2. Cacher le badge rouge visuellement
                    const badge = document.querySelector('.notif-badge');
                    if (badge) badge.style.display = 'none';
                    
                    // 3. Mettre à jour le texte "X nouveaux" en "0 nouveaux"
                    const counterText = document.querySelector('.notif-header small');
                    if (counterText) counterText.textContent = '0 nouveaux';
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    }
});
</script>
    </main>

    <button id="theme-toggle" class="theme-toggle btn">
        <i class='bx bx-moon' id="theme-icon"></i> <span id="theme-text">Mode Sombre</span>
    </button>

    <footer>
        <p>© 2026 Projet DataCenter Pro - Ingénierie des Applications Informatiques</p>
    </footer>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const themeText = document.getElementById('theme-text');

        themeToggle.addEventListener('click', () => {
            const currentTheme = document.body.getAttribute('data-theme');
            if (currentTheme === 'light') {
                document.body.setAttribute('data-theme', 'dark');
                themeIcon.classList.replace('bx-moon', 'bx-sun');
                themeText.innerText = "Mode Clair";
            } else {
                document.body.setAttribute('data-theme', 'light');
                themeIcon.classList.replace('bx-sun', 'bx-moon');
                themeText.innerText = "Mode Sombre";
            }
        });
        // --- SCRIPT POUR LES NOTIFICATIONS ---
const btnNotif = document.getElementById('notifBtn');
const dropdownNotif = document.querySelector('.notif-dropdown');

if (btnNotif && dropdownNotif) {
    // Ouvrir/Fermer au clic
    btnNotif.addEventListener('click', function(event) {
        event.stopPropagation(); // Empêche la fermeture immédiate
        dropdownNotif.classList.toggle('show');
    });

    // Empêcher la fermeture quand on clique dans le menu pour scroller
    dropdownNotif.addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Fermer si on clique ailleurs sur la page
    document.addEventListener('click', function() {
        dropdownNotif.classList.remove('show');
    });
}
    </script>
</body>
</html>