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
        * { margin: 0; padding: 0; box-box: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); transition: 0.3s; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }

        /* Layout */
        .container { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* Navbar Custom */
        .navbar { background: var(--dark); color: white; padding: 1rem 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.3); }
        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; display: flex; align-items: center; gap: 8px; }
        .logo span { color: var(--primary); }
        .nav-links { display: flex; gap: 20px; align-items: center; }

        /* Hero Section */
        .hero { background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1558494949-ef010cbdcc51?q=80&w=1600') no-repeat center/cover;
                color: white; text-align: center; padding: 80px 20px; }
        .hero h1 { font-size: 2.5rem; margin-bottom: 10px; }
        .hero p { font-size: 1.1rem; opacity: 0.8; }

        /* Alerts */
        .alert { padding: 15px; margin: 20px 0; border-radius: 8px; background: var(--success); color: white; display: flex; align-items: center; gap: 10px; }

        /* Tables & Sections */
        section { margin: 40px 0; }
        h4 { margin-bottom: 20px; font-size: 1.3rem; border-left: 4px solid var(--primary); padding-left: 10px; }

        .table-container { background: var(--bg-card); border-radius: 10px; overflow-x: auto; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid var(--border-color); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: rgba(0,0,0,0.02); padding: 15px; font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); border-bottom: 2px solid var(--border-color); }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 0.95rem; }

        /* Status & Badges */
        .badge { padding: 4px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; }
        .bg-pending { background: var(--warning); color: #333; }
        .bg-valid { background: var(--success); color: white; }
        
        .status-pill { padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }
        .status-available { background: #d4edda; color: #155724; }
        .status-occupied { background: #fff3cd; color: #856404; }
        .status-maintenance { background: #f8d7da; color: #721c24; }

        /* Buttons */
        .btn { padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; border: none; transition: 0.2s; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 5px; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-hover); }
        .btn-outline-danger { background: transparent; border: 1px solid var(--danger); color: var(--danger); }
        .btn-outline-danger:hover { background: var(--danger); color: white; }
        .btn-success { background: var(--success); color: white; }

        /* Mode Sombre Toggle */
        .theme-toggle { position: fixed; bottom: 30px; right: 30px; padding: 12px 20px; border-radius: 50px; background: var(--dark); color: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }

        footer { text-align: center; padding: 40px; background: var(--dark); color: white; font-size: 0.8rem; margin-top: 60px; }
    </style>
</head>
<body data-theme="light">

    <nav class="navbar">
        <div class="container nav-content">
            <a href="{{ url('/') }}" class="logo">
                <i class='bx bxs-server'></i> DataCenter <span>Pro</span>
            </a>
            <ul class="nav-links">
                @guest
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-primary">Inscription</a></li>
                @else
                    <li><small>Utilisateur : <strong>{{ Auth::user()->name }}</strong></small></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
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
            <p>Accès en temps réel aux serveurs physiques et virtuels du Data Center.</p>
        </div>
    </header>

    <main class="container">
        
        @if(session('success'))
            <div class="alert">
                <i class='bx bxs-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        <section>
            <h4><i class='bx bx-time-five'></i> Flux des Réservations</h4>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Technicien</th>
                            <th>Équipement</th>
                            <th>Catégorie</th>
                            <th>Statut</th>
                            <th>Échéance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $res)
                            <tr>
                                <td>{{ $res->user->name }}</td>
                                <td><strong>{{ $res->resource->name }}</strong></td>
                                <td>{{ $res->resource->category->name }}</td>
                                <td>
                                    <span class="badge {{ $res->status == 'validée' ? 'bg-valid' : 'bg-pending' }}">
                                        {{ ucfirst($res->status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($res->end_date)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Aucune donnée active.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section id="ressources">
            <h4><i class='bx bx-hdd'></i> Inventaire des Ressources</h4>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom & Localisation</th>
                            <th>Catégorie</th>
                            <th>Spécifications</th>
                            <th>État</th>
                            <th style="text-align: center;">Demande</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resources as $resource)
                        <tr>
                            <td>
                                <strong>{{ $resource->name }}</strong><br>
                                <small style="color: var(--text-muted);">{{ $resource->location ?? 'Site Principal' }}</small>
                            </td>
                            <td><span style="color: var(--primary); font-weight: 600;">{{ $resource->category->name }}</span></td>
                            <td>
                                <small>
                                    @if($resource->cpu) CPU: {{ $resource->cpu }} @endif
                                    @if($resource->ram) | RAM: {{ $resource->ram }} @endif
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
                                        <form action="{{ route('reservations.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                                            <button type="submit" class="btn btn-success">RESERVER</button>
                                        </form>
                                    @else
                                        <span style="font-size: 0.7rem; color: var(--text-muted);">INDISPONIBLE</span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" style="font-size: 0.7rem; text-decoration: underline;">Se connecter</a>
                                @endauth
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
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
    </script>
</body>
</html>