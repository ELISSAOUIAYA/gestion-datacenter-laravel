<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataCenter Pro | Infrastructure</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        /* --- VARIABLES & THEME --- */
        :root {
            --primary: #007bff;
            --primary-dark: #0056b3;
            --bg-body: #f4f7f6;
            --bg-card: #ffffff;
            --text-main: #333;
            --text-muted: #777;
            --border: #eeeeee;
            --dark: #1a1d20;
            --success: #28a745;
            --danger: #dc3545;
        }

        /* --- RESET & LAYOUT --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        a { text-decoration: none; color: inherit; }

        /* --- NAVIGATION --- */
        .navbar { background: var(--dark); color: white; padding: 15px 0; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 10px; }
        .logo span { color: var(--primary); }
        .nav-links { display: flex; gap: 25px; align-items: center; list-style: none; }

        /* --- NOTIFICATIONS --- */
        .notif-wrapper { position: relative; }
        .notif-trigger { font-size: 1.4rem; cursor: pointer; display: flex; align-items: center; }
        .notif-badge { position: absolute; top: -5px; right: -5px; background: var(--danger); color: white; font-size: 0.6rem; padding: 2px 6px; border-radius: 10px; font-weight: bold; }
        .notif-dropdown { 
            position: absolute; top: 130%; right: 0; width: 300px; background: white; border-radius: 10px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.15); display: none; z-index: 2000; border: 1px solid var(--border); overflow: hidden;
        }
        .notif-dropdown.show { display: block; }
        .notif-header { padding: 12px; background: #f8f9fa; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; font-weight: bold; font-size: 0.9rem; }
        .notif-item { padding: 12px; border-bottom: 1px solid #f0f0f0; font-size: 0.85rem; color: #444; }
        .notif-item.unread { background: #f0f7ff; border-left: 4px solid var(--primary); }

        /* --- HERO --- */
        .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1558494949-ef010cbdcc51?q=80&w=1600') center/cover;
                color: white; text-align: center; padding: 80px 20px; margin-bottom: 60px; }
        .hero h1 { font-size: 2.5rem; margin-bottom: 10px; }

        /* --- CATEGORY CARDS (GRID) --- */
        .category-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; margin-top: -110px; }
        .cat-card { 
            background: white; padding: 40px 20px; border-radius: 20px; text-align: center; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); cursor: pointer; transition: all 0.3s ease; border: 3px solid transparent; 
        }
        .cat-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.12); }
        .cat-card.active { border-color: var(--primary); background: #f0f7ff; }
        .cat-card i { font-size: 3.5rem; color: var(--primary); margin-bottom: 20px; }
        .cat-card h3 { font-size: 1.1rem; color: var(--dark); margin-bottom: 5px; }
        .cat-card p { font-size: 0.8rem; color: var(--text-muted); }

        /* --- INVENTORY TABLE --- */
        .inventory-section { background: white; border-radius: 15px; padding: 35px; margin: 40px 0; box-shadow: 0 5px 25px rgba(0,0,0,0.05); display: none; }
        #table-title { margin-bottom: 30px; font-size: 1.3rem; font-weight: 700; color: var(--dark); border-left: 5px solid var(--primary); padding-left: 15px; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; background: #fafafa; color: #888; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #eee; }
        td { padding: 20px 15px; border-bottom: 1px solid #f5f5f5; font-size: 0.9rem; }

        .resource-row { display: none; }
        .resource-row.visible { display: table-row; }

        /* --- COMPONENTS --- */
        .status-pill { padding: 5px 15px; border-radius: 30px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
        .status-available { background: #d4edda; color: #155724; }
        .status-occupied { background: #fff3cd; color: #856404; }
        
        .btn { padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 0.8rem; border: none; cursor: pointer; transition: 0.2s; }
        .btn-success { background: var(--success); color: white; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-success:hover { background: #218838; }

        footer { text-align: center; padding: 50px; color: #aaa; font-size: 0.8rem; border-top: 1px solid #eee; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container nav-content">
        <a href="/" class="logo"><i class='bx bxs-server'></i> DataCenter <span>Pro</span></a>
        <ul class="nav-links">
            @auth
                <li class="notif-wrapper" id="notifBtn">
                    <div class="notif-trigger">
                        <i class='bx bxs-bell'></i>
                        @php $uCount = Auth::user()->notifications()->where('is_read', false)->count(); @endphp
                        @if($uCount > 0) <span class="notif-badge">{{ $uCount }}</span> @endif
                    </div>
                    <div class="notif-dropdown">
                        <div class="notif-header">
                            <span>Notifications</span>
                            <small id="notif-count" style="color: var(--primary);">{{ $uCount }} nouveaux</small>
                        </div>
                        <div class="notif-body">
                            @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $n)
                                <div class="notif-item {{ $n->is_read ? '' : 'unread' }}">
                                    <strong>{{ $n->title }}</strong>
                                    <p style="font-size: 0.8rem; margin: 4px 0; color: #666;">{{ $n->message }}</p>
                                    <small style="font-size: 0.7rem; opacity: 0.6;">{{ $n->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <div style="padding:20px; text-align:center; color:#999;">Aucune alerte</div>
                            @endforelse
                        </div>
                    </div>
                </li>
                <li>
                    @auth
                        @if(Auth::user()->role && Auth::user()->role->name === 'Utilisateur Interne')
                            <a href="{{ route('user.dashboard') }}"><strong>Espace personnel</strong></a>
                        @elseif(Auth::user()->role && Auth::user()->role->name === 'Responsable Technique')
                            <a href="{{ route('tech.dashboard') }}"><strong>Dashboard Technique</strong></a>
                        @elseif(Auth::user()->role && Auth::user()->role->name === 'Admin')
                            <a href="{{ route('admin.dashboard') }}"><strong>Dashboard Admin</strong></a>
                        @else
                            <a href="{{ route('user.dashboard') }}"><strong>Espace personnel</strong></a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"><strong>Connexion requise</strong></a>
                    @endauth
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button type="submit" style="background:none; border:none; color:var(--danger); cursor:pointer; font-weight:bold; font-size:0.9rem;">Déconnexion</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}"><strong>Connexion</strong></a></li>
                <li><a href="{{ route('register') }}"><strong>Inscription</strong></a></li>
            @endauth
        </ul>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <h1>Infrastructure de Pointe</h1>
        <p>Explorez et réservez nos ressources haute performance en un clic.</p>
    </div>
</header>

<main class="container">
    <div class="category-grid">
        <div class="cat-card" onclick="filterResources('SERVEUR', this)">
            <i class='bx bxs-chip'></i>
            <h3>SERVEURS</h3>
            <p>Calcul intensif & Bare Metal</p>
        </div>
        <div class="cat-card" onclick="filterResources('VM', this)">
            <i class='bx bxs-cloud'></i>
            <h3>VM</h3>
            <p>Instances Cloud flexibles</p>
        </div>
        <div class="cat-card" onclick="filterResources('STOCKAGE', this)">
            <i class='bx bxs-hdd'></i>
            <h3>STOCKAGE</h3>
            <p>Unités NAS & SAN sécurisées</p>
        </div>
        <div class="cat-card" onclick="filterResources('RESEAU', this)">
            <i class='bx bx-transfer-alt'></i>
            <h3>RÉSEAU</h3>
            <p>Interconnexion haute vitesse</p>
        </div>
    </div>

    <div class="inventory-section" id="inventory-section">
        <h4 id="table-title">Liste des équipements</h4>
        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Spécifications Techniques</th>
                    <th>Statut</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    @php
                        $catName = optional($resource->category)->name ?? 'inconnu';
                        $normalizedCat = strtolower(str_replace(['é', 'è', 'ê', 'É', 'È', 'Ê'], 'e', $catName));

                        $specs = [];
                        if($resource->cpu) $specs[] = "<strong>CPU:</strong> {$resource->cpu}";
                        if($resource->ram) $specs[] = "<strong>RAM:</strong> {$resource->ram}";
                        if($resource->bandwidth) $specs[] = "<strong>Débit:</strong> {$resource->bandwidth}";
                        if($resource->capacity) $specs[] = "<strong>Capacité:</strong> {$resource->capacity}";
                        if($resource->os) $specs[] = "<strong>OS:</strong> {$resource->os}";
                    @endphp

                    <tr class="resource-row" data-category="{{ $normalizedCat }}">
                        <td><strong>{{ $resource->name }}</strong></td>
                        <td style="font-size: 0.85rem; color: #555;">
                            @if(count($specs) > 0)
                                {!! implode(' <span style="color: #ddd; margin: 0 5px;">|</span> ', $specs) !!}
                            @else
                                <span style="color: #ccc; font-style: italic;">Non renseigné</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-pill status-{{ $resource->status }}">
                                {{ $resource->status == 'available' ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            @auth
                                @php
                                    $isInterneUser = Auth::user()->role->name === 'Utilisateur Interne';
                                    $isNormalUser = Auth::user()->role->name === 'Utilisateur Normal';
                                    $isAuthorizedCategory = in_array($resource->resource_category_id, [2, 3, 4]); // VM, Stockage, Réseau
                                    $canReserve = $isInterneUser || ($isNormalUser && $isAuthorizedCategory);
                                @endphp
                                
                                @if($canReserve)
                                    @if($resource->status == 'available')
                                        <a href="{{ route('user.create-reservation-with-resource', $resource->id) }}" class="btn btn-success">RÉSERVER</a>
                                    @else
                                        <span style="font-size: 0.75rem; color: #aaa;">OCCUPÉ</span>
                                    @endif
                                @else
                                    <span style="font-size: 0.75rem; color: #999;">Non autorisé</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">SE CONNECTER</a>
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<footer>
    <p>© 2026 DataCenter Pro - Projet Licence Génie Logiciel</p>
</footer>

<script>
    // --- VANILLA JS : FILTRAGE & TITRE DYNAMIQUE ---
    function filterResources(category, element) {
        // 1. Normalisation de la catégorie (ex: RÉSEAU -> reseau)
        const target = category.toLowerCase().replace(/[éèê]/g, 'e');

        // 2. Gestion visuelle des cartes (Active state)
        document.querySelectorAll('.cat-card').forEach(card => card.classList.remove('active'));
        element.classList.add('active');

        // 3. Affichage du tableau et mise à jour du titre
        document.getElementById('inventory-section').style.display = 'block';
        document.getElementById('table-title').innerText = "Liste des équipements : " + category;

        // 4. Filtrage des lignes du tableau
        const rows = document.querySelectorAll('.resource-row');
        rows.forEach(row => {
            if (row.getAttribute('data-category').includes(target)) {
                row.classList.add('visible');
            } else {
                row.classList.remove('visible');
            }
        });

        // 5. Scroll fluide vers la liste
        window.scrollTo({
            top: document.getElementById('inventory-section').offsetTop - 100,
            behavior: 'smooth'
        });
    }

    // --- VANILLA JS : NOTIFICATIONS ---
    document.addEventListener('DOMContentLoaded', function() {
        const notifBtn = document.getElementById('notifBtn');
        const dropdown = document.querySelector('.notif-dropdown');

        if (notifBtn) {
            notifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('show');

                // Mark as read AJAX (Framework-free fetch)
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
                        const badge = document.querySelector('.notif-badge');
                        if (badge) badge.style.display = 'none';
                        document.getElementById('notif-count').innerText = '0 nouvelles';
                    }
                });
            });
        }

        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', () => {
            if(dropdown) dropdown.classList.remove('show');
        });
    });
</script>
</body>
</html>