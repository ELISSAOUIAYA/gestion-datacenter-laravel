<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataCenter Pro | Infrastructure</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        :root {
            --primary: #007bff; --bg-body: #f4f7f6; --bg-card: #ffffff;
            --text-main: #333; --border-color: #eee; --dark: #1a1d20;
        }
        [data-theme="dark"] {
            --bg-body: #121212; --bg-card: #1e1e1e; --text-main: #e0e0e0; --border-color: #333;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); transition: 0.3s; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* Navbar */
        .navbar { background: var(--dark); color: white; padding: 1rem 0; position: sticky; top: 0; z-index: 1000; }
        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: bold; color: white; text-decoration: none; }
        .logo span { color: var(--primary); }
        .nav-links { display: flex; gap: 20px; align-items: center; list-style: none; }

        /* Notifications */
        .notif-wrapper { position: relative; cursor: pointer; }
        .notif-trigger { font-size: 1.3rem; color: white; position: relative; }
        .notif-badge { position: absolute; top: 0; right: -2px; background: #dc3545; color: white; font-size: 0.6rem; padding: 2px 5px; border-radius: 10px; }
        .notif-dropdown { 
            position: absolute; top: 100%; right: 0; width: 280px; background: var(--bg-card); 
            border: 1px solid var(--border-color); border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); 
            display: none; margin-top: 15px; z-index: 2000; color: var(--text-main);
        }
        .notif-dropdown.show { display: block; }

        /* Hero */
        .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1558494949-ef010cbdcc51?q=80&w=1600') no-repeat center/cover;
                color: white; text-align: center; padding: 60px 20px; margin-bottom: 50px; }

        /* Categories */
        .category-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-top: -80px; }
        .cat-card { 
            background: var(--bg-card); padding: 30px; border-radius: 15px; text-align: center; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1); cursor: pointer; transition: 0.3s; border: 3px solid transparent; 
        }
        .cat-card:hover { transform: translateY(-5px); }
        .cat-card.active { border-color: var(--primary); background: rgba(0, 123, 255, 0.05); }
        .cat-card i { font-size: 3rem; color: var(--primary); margin-bottom: 15px; }

        /* Table Section */
        .inventory-section { background: var(--bg-card); border-radius: 12px; padding: 25px; margin-top: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 15px; background: rgba(0,0,0,0.02); text-align: left; font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); }

        .resource-row { display: none; } /* CACHÉ AU DÉBUT */
        .resource-row.visible { display: table-row; }
        
        #empty-message { text-align: center; padding: 40px; color: var(--text-muted); }

        .btn { padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; }
        .btn-success { background: #28a745; color: white; }
        .btn-primary { background: var(--primary); color: white; }
        
        .status-pill { padding: 4px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800; }
        .status-available { background: #d4edda; color: #155724; }
        .status-occupied { background: #fff3cd; color: #856404; }

        footer { text-align: center; padding: 40px; background: var(--dark); color: white; margin-top: 50px; }
    </style>
</head>
<body data-theme="light">

<nav class="navbar">
    <div class="container nav-content">
        <a href="/" class="logo"><i class='bx bxs-server'></i> DataCenter <span>Pro</span></a>
        <ul class="nav-links">
            @guest
                <li><a href="{{ route('login') }}">Connexion</a></li>
                <li><a href="{{ route('register') }}" class="btn btn-primary">Inscription</a></li>
            @else
                <li class="notif-wrapper" id="notifBtn">
                    <div class="notif-trigger">
                        <i class='bx bxs-bell'></i>
                        @php $uCount = Auth::user()->notifications()->where('is_read', false)->count(); @endphp
                        @if($uCount > 0) <span class="notif-badge">{{ $uCount }}</span> @endif
                    </div>
                    <div class="notif-dropdown">
                        <div class="notif-header">Messages</div>
                        <div class="notif-body">
                            @forelse(Auth::user()->notifications()->latest()->take(5)->get() as $n)
                                <div style="padding:10px; border-bottom:1px solid #eee;">
                                    <strong>{{ $n->title }}</strong><br><small>{{ $n->message }}</small>
                                </div>
                            @empty
                                <div style="padding:20px; text-align:center;">Rien de neuf</div>
                            @endforelse
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('user.dashboard') }}"><strong>Mon Dashboard</strong></a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer; font-weight:bold;">Quitter</button>
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

<header class="hero">
    <div class="container">
        <h1>Infrastructure Supervision</h1>
        <p>Sélectionnez une catégorie pour voir les équipements disponibles.</p>
    </div>
</header>

<main class="container">
    <div class="category-grid">
        <div class="cat-card" onclick="filterResources('SERVEUR', this)">
            <i class='bx bxs-chip'></i>
            <h3>SERVEURS</h3>
            <p>Physiques & Bare Metal</p>
        </div>
        <div class="cat-card" onclick="filterResources('VM', this)">
            <i class='bx bxs-cloud'></i>
            <h3>MACHINES VIRTUELLES</h3>
            <p>Instances Cloud</p>
        </div>
        <div class="cat-card" onclick="filterResources('STOCKAGE', this)">
            <i class='bx bxs-hdd'></i>
            <h3>STOCKAGE</h3>
            <p>Volumes SSD & NAS</p>
        </div>
        <div class="cat-card" onclick="filterResources('RESEAU', this)">
            <i class='bx bx-transfer-alt'></i>
            <h3>RÉSEAU</h3>
            <p>Switchs & Routeurs</p>
        </div>
    </div>

    <div class="inventory-section">
        <div id="empty-message">
            <i class='bx bx-mouse-alt' style="font-size: 3rem; opacity: 0.3;"></i>
            <p>Veuillez cliquer sur une catégorie ci-dessus pour afficher les équipements.</p>
        </div>

        <div id="table-wrapper" style="display: none;">
            <h4 id="table-title">Équipements</h4>
            <table>
            <thead>
                <tr>
                  <th>Nom</th>
                  <th>Spécifications Techniques</th>
                  <th>État</th>
                  <th style="text-align: center;">Action</th>
                </tr>
              </thead>
                  <tbody>
    @foreach($resources as $resource)
        @php
            // 1. Normalisation du nom de la catégorie pour le filtrage JavaScript
            $catName = optional($resource->category)->name ?? 'inconnu';
            $normalizedCat = strtolower(str_replace(['é', 'è', 'ê', 'É', 'È', 'Ê'], 'e', $catName));

            // 2. Construction dynamique de la liste des spécifications (élimine les "null")
            $specs = [];
            if (!empty($resource->cpu)) {
                $specs[] = "<strong>CPU:</strong> " . $resource->cpu;
            }
            if (!empty($resource->ram)) {
                $specs[] = "<strong>RAM:</strong> " . $resource->ram;
            }
            if (!empty($resource->bandwidth)) {
                $specs[] = "<strong>Débit:</strong> " . $resource->bandwidth;
            }
            if (!empty($resource->capacity)) {
                $specs[] = "<strong>Capacité:</strong> " . $resource->capacity;
            }
            if (!empty($resource->os)) {
                $specs[] = "<strong>OS:</strong> " . $resource->os;
            }
        @endphp

        <tr class="resource-row" data-category="{{ $normalizedCat }}">
            
            <td><strong>{{ $resource->name }}</strong></td>

            <td style="font-size: 0.85rem; color: #555;">
                @if(count($specs) > 0)
                    {{-- On joint les éléments avec une barre grise discrète --}}
                    {!! implode(' <span style="color: #d1d1d1; margin: 0 5px;">|</span> ', $specs) !!}
                @else
                    <span style="color: #aaa; font-style: italic;">Aucune spécification technique</span>
                @endif
            </td>

            <td>
                <span class="status-pill status-{{ $resource->status }}">
                    {{ strtoupper($resource->status == 'available' ? 'Disponible' : ($resource->status == 'occupied' ? 'Occupé' : 'Maintenance')) }}
                </span>
            </td>

            <td style="text-align: center;">
                @auth
                    @if($resource->status == 'available')
                        <a href="{{ route('reservations.create', ['resource_id' => $resource->id]) }}" class="btn btn-success" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 4px; text-decoration: none; color: white; background-color: #28a745;">
                            RÉSERVER
                        </a>
                    @else
                        <span style="font-size: 0.75rem; color: #95a5a6; font-weight: bold;">INDISPONIBLE</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.8rem; border-radius: 4px; text-decoration: none; color: white; background-color: #007bff;">
                        LOGIN
                    </a>
                @endauth
            </td>
        </tr>
    @endforeach
</tbody>
           
                
</table>
        </div>
    </div>
</main>

<footer><p>© 2026 Projet DataCenter Pro</p></footer>

<script>
    function filterResources(category, element) {
        // 1. Normaliser la catégorie cliquée
        const target = category.toLowerCase().replace(/[éèê]/g, 'e');

        // 2. Gérer l'UI des cartes
        document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active'));
        element.classList.add('active');

        // 3. Afficher le tableau et masquer le message vide
        document.getElementById('empty-message').style.display = 'none';
        document.getElementById('table-wrapper').style.display = 'block';
        document.getElementById('table-title').innerText = "Liste des équipements : " + category;

        // 4. Filtrer les lignes
        const rows = document.querySelectorAll('.resource-row');
        rows.forEach(row => {
            if (row.getAttribute('data-category').includes(target)) {
                row.classList.add('visible');
            } else {
                row.classList.remove('visible');
            }
        });
    }

    // Gestion des notifications
    const btnNotif = document.getElementById('notifBtn');
    if (btnNotif) {
        btnNotif.addEventListener('click', (e) => {
            e.stopPropagation();
            document.querySelector('.notif-dropdown').classList.toggle('show');
        });
        document.addEventListener('click', () => document.querySelector('.notif-dropdown').classList.remove('show'));
    }
</script>
</body>
</html>