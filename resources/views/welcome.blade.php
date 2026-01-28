<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DataCenter Pro | Infrastructure Cloud</title>

    

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    

    <style>

/* --- ENHANCED FOOTER --- */
footer {
    background: rgba(15, 23, 42, 0.9);
    border-top: 1px solid var(--border);
    padding: 80px 0 40px;
    margin-top: 100px;
    position: relative;
}

footer::before {
    content: "";
    position: absolute;
    top: -1px; left: 0; width: 100%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--primary), transparent);
}

.footer-grid {
    display: grid;
    /* بدلت هادي لـ 3 ديال الأعمدة */
    grid-template-columns: 1.5fr 1fr 1fr; 
    gap: 40px;
    margin-bottom: 60px;
}

.footer-about .logo { margin-bottom: 20px; }
.footer-about p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 25px; max-width: 300px; }

.footer-column h4 {
    color: var(--text-main);
    font-size: 1rem;
    font-weight: 800;
    margin-bottom: 25px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.footer-links { list-style: none; }
.footer-links li { margin-bottom: 12px; }
.footer-links a { color: var(--text-muted); font-size: 0.9rem; transition: 0.3s; }
.footer-links a:hover { color: var(--primary); padding-left: 5px; }

.social-links { display: flex; gap: 15px; margin-top: 20px; }
.social-links a {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.05);
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px; border: 1px solid var(--border);
    font-size: 1.2rem; color: var(--primary); transition: 0.3s;
}
.social-links a:hover { background: var(--primary); color: var(--bg-body); transform: translateY(-5px); }

.footer-bottom {
    padding-top: 40px;
    border-top: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    color: var(--text-muted); font-size: 0.85rem;
}

/* Responsiveness */
@media (max-width: 992px) {
    .footer-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 576px) {
    .footer-grid { grid-template-columns: 1fr; }
    .footer-bottom { flex-direction: column; gap: 20px; text-align: center; }
}





        :root {

            --primary: #38bdf8;

            --primary-dark: #0ea5e9;

            --bg-body: #020617;

            --bg-card: #0f172a;

            --text-main: #f8fafc;

            --text-muted: #94a3b8;

            --border: rgba(255, 255, 255, 0.08);

            --glass: rgba(15, 23, 42, 0.8);

            --success: #22c55e;

            --danger: #ef4444;

            --notif-bg: #1e293b;

        }



        /* --- RESET & GLOBAL --- */

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body { background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; overflow-x: hidden; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        a { text-decoration: none; color: inherit; transition: 0.3s; }



        /* --- NAVIGATION (GLASS EFFECT) --- */

        .navbar { 

            background: var(--glass); 

            backdrop-filter: blur(12px); 

            border-bottom: 1px solid var(--border);

            color: white; padding: 18px 0; position: sticky; top: 0; z-index: 1000; 

        }

        .nav-content { display: flex; justify-content: space-between; align-items: center; }

        .logo { font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; gap: 10px; letter-spacing: -1px; }

        .logo i { color: var(--primary); font-size: 1.8rem; }

        .logo span { color: var(--primary); }



        .nav-links { display: flex; gap: 20px; align-items: center; list-style: none; }

        .nav-links a:hover { color: var(--primary); }



        /* --- HERO SECTION --- */

        .hero { 

            position: relative; height: 60vh; display: flex; align-items: center; justify-content: center;

            text-align: center; color: white; margin-bottom: 40px;

            background: linear-gradient(rgba(2, 6, 23, 0.8), rgba(2, 6, 23, 0.8)), 

                        url('https://images.unsplash.com/photo-1597852074816-d933c7d2b988?q=80&w=1600') center/cover no-repeat;

        }

        .hero-content { z-index: 2; max-width: 800px; }

        .hero h1 { font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 20px; letter-spacing: -2px; }

        .hero p { color: var(--text-muted); font-size: 1.2rem; }



        /* --- CATEGORY CARDS --- */

        .category-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: -80px; position: relative; z-index: 5; }

        

        .cat-card { 

            background: var(--bg-card); border-radius: 24px; padding: 35px 25px; text-align: center; 

            border: 1px solid var(--border); cursor: pointer; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);

            overflow: hidden; position: relative;

        }

        .cat-card::before {

            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%;

            background: linear-gradient(45deg, transparent, rgba(56, 189, 248, 0.05)); opacity: 0; transition: 0.4s;

        }

        .cat-card:hover { transform: translateY(-10px); border-color: var(--primary); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }

        .cat-card:hover::before { opacity: 1; }

        .cat-card.active { border-color: var(--primary); background: rgba(56, 189, 248, 0.05); }



        .cat-img { width: 80px; height: 80px; margin: 0 auto 20px; display: block; filter: drop-shadow(0 0 10px var(--primary)); }

        .cat-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 8px; color: var(--text-main); }

        .cat-card p { font-size: 0.85rem; color: var(--text-muted); }



        .spec-item { 

            display: inline-flex; align-items: center; gap: 6px; 

            background: rgba(255,255,255,0.05); padding: 5px 12px; 

            border-radius: 8px; margin-right: 8px; font-size: 0.8rem; 

            border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;

            margin-bottom: 4px;

        }

        .spec-item i { color: var(--primary); font-size: 1rem; }



        /* --- INVENTORY TABLE --- */

        .inventory-section { 

            background: var(--bg-card); border-radius: 24px; padding: 40px; margin: 60px 0; 

            border: 1px solid var(--border); display: none; animation: fadeInUp 0.6s ease;

        }

        #table-title { margin-bottom: 30px; font-size: 1.5rem; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 10px; }

        #table-title::before { content: ""; width: 5px; height: 25px; background: var(--primary); border-radius: 10px; }



        table { width: 100%; border-collapse: collapse; }

        th { text-align: left; padding: 18px; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--border); }

        td { padding: 20px 18px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }

        

        .resource-row { display: none; }

        .resource-row.visible { display: table-row; }



        /* --- BADGES & BUTTONS --- */

        .status-pill { padding: 6px 14px; border-radius: 10px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }

        .status-available { background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2); }

        .status-occupied { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

        

        .btn { padding: 12px 24px; border-radius: 12px; font-weight: 700; font-size: 0.85rem; border: none; cursor: pointer; transition: 0.3s; display: inline-block; text-align: center; }

        .btn-success { background: var(--primary); color: var(--bg-body); }

        .btn-success:hover { background: white; transform: scale(1.05); }

        

        .btn-action {

            background: var(--primary);

            color: var(--bg-body);

            padding: 8px 16px;

            border-radius: 8px;

            font-weight: 800;

            font-size: 0.75rem;

            transition: 0.3s;

        }

        .btn-action:hover { background: white; color: var(--bg-body); }



        /* --- NOTIFICATIONS --- */

        .notif-wrapper { position: relative; }

        .notif-badge { 

            position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; 

            font-size: 0.65rem; padding: 2px 6px; border-radius: 10px; font-weight: 800;

            border: 2px solid var(--bg-body);

        }



        .notif-dropdown {

            position: absolute; top: 150%; right: 0; width: 320px; background: var(--notif-bg);

            border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.5);

            display: none; z-index: 2000; overflow: hidden;

        }

        .notif-dropdown.show { display: block; animation: fadeIn 0.3s ease; }

        

        .notif-header { padding: 15px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; font-weight: 700; font-size: 0.85rem; }

        .notif-body { max-height: 300px; overflow-y: auto; }

        .notif-item { padding: 15px; border-bottom: 1px solid var(--border); cursor: pointer; }

        .notif-item:hover { background: rgba(56, 189, 248, 0.05); }

        .notif-item.unread { border-left: 4px solid var(--primary); background: rgba(56, 189, 248, 0.02); }

        .notif-item strong { display: block; font-size: 0.85rem; color: var(--primary); }

        .notif-item p { font-size: 0.75rem; color: var(--text-muted); margin: 4px 0; }



        footer { text-align: center; padding: 60px; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid var(--border); }



        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

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

    <div class="hero-content container">

        <h1>Pilotez votre <span style="color: var(--primary);">Infrastructure</span></h1>

        <p>Ressources Bare Metal, Cloud et Réseau à la demande.</p>

    </div>

</header>



<main class="container">

    <div class="category-grid">

        <div class="cat-card" onclick="filterResources('SERVEUR', this)">

            <img src="https://cdn-icons-png.flaticon.com/512/2333/2333244.png" class="cat-img" alt="Servers">

            <h3>SERVEURS</h3>

            <p>Bare Metal haute performance</p>

        </div>

        <div class="cat-card" onclick="filterResources('VM', this)">

            <img src="https://cdn-icons-png.flaticon.com/512/2172/2172835.png" class="cat-img" alt="Cloud">

            <h3>INSTANCES VM</h3>

            <p>Flexibilité & Scalabilité</p>

        </div>

        <div class="cat-card" onclick="filterResources('STOCKAGE', this)">

            <img src="https://cdn-icons-png.flaticon.com/512/2906/2906231.png" class="cat-img" alt="Storage">

            <h3>STOCKAGE</h3>

            <p>Unités NAS & SAN NVMe</p>

        </div>

        <div class="cat-card" onclick="filterResources('RESEAU', this)">

            <img src="https://cdn-icons-png.flaticon.com/512/3122/3122421.png" class="cat-img" alt="Network">

            <h3>RÉSEAU</h3>

            <p>VLAN & IP Dédiées</p>

        </div>

    </div>



    <div class="inventory-section" id="inventory-section">

        <h4 id="table-title">Équipements filtrés</h4>

        <table>

            <thead>

                <tr>

                    <th>Désignation</th>

                    <th>Spécifications Techniques</th>

                    <th>Statut</th>

                    <th style="text-align: right;">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($resources as $resource)

                    @php

                        $catName = optional($resource->category)->name ?? 'inconnu';

                        $normalizedCat = strtolower(str_replace(['é', 'è', 'ê'], 'e', $catName));

                    @endphp

                    <tr class="resource-row" data-category="{{ $normalizedCat }}">

                        <td style="font-weight: 800; font-size: 1.1rem;">{{ $resource->name }}</td>

                        <td>

                            <div style="display: flex; flex-wrap: wrap; gap: 5px;">

                                @if($resource->cpu) <span class="spec-item"><i class='bx bxs-chip'></i> {{ $resource->cpu }}</span> @endif

                                @if($resource->ram) <span class="spec-item"><i class='bx bxs-memory-card'></i> {{ $resource->ram }}</span> @endif

                                @if($resource->capacity) <span class="spec-item"><i class='bx bxs-save'></i> {{ $resource->capacity }}</span> @endif

                                @if($resource->bandwidth) <span class="spec-item"><i class='bx bx-wifi'></i> {{ $resource->bandwidth }}</span> @endif

                                @if($resource->os) 

                                    <span class="spec-item os-badge"><i class='bx bx-desktop'></i> OS: {{ $resource->os }}</span> 

                                @endif 

                            </div>

                        </td>

                        <td>

                            <span class="status-pill status-{{ $resource->status }}">

                                {{ $resource->status == 'available' ? 'Disponible' : 'Occupé' }}

                            </span>

                        </td>

                        <td style="text-align: right;">

                            @auth

                                @if($resource->status == 'available')

                                    <a href="{{ route('user.create-reservation-with-resource', $resource->id) }}" class="btn-action">RÉSERVER</a>

                                @else

                                    <i class='bx bxs-lock' style="color: var(--text-muted); font-size: 1.5rem;"></i>

                                @endif

                            @else

                                <a href="{{ route('login') }}" style="color: var(--primary); font-size: 0.8rem; font-weight: 700;">SE CONNECTER</a>

                            @endauth

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</main>



<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-about">
                <a href="/" class="logo"><i class='bx bxs-terminal'></i> DataCenter <span>Pro</span></a>
                <p>Infrastructure Cloud de nouvelle génération. Performance, sécurité et scalabilité au service de vos ambitions digitales.</p>
                <div class="social-links">
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                    <a href="#"><i class='bx bxl-twitter'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                    <a href="#"><i class='bx bxl-discord-alt'></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Plateforme</h4>
                <ul class="footer-links">
                    <li><a href="#">Serveurs Dédiés</a></li>
                    <li><a href="#">Instances Cloud</a></li>
                    <li><a href="#">Stockage NVMe</a></li>
                    <li><a href="#">Réseau & IP</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Support</h4>
                <ul class="footer-links">
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">API Status</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2026 DataCenter Pro. Tous droits réservés.</p>
            <div style="display: flex; gap: 20px;">
                <a href="#" style="color: var(--text-muted);">Mentions Légales</a>
                <a href="#" style="color: var(--text-muted);">Confidentialité</a>
            </div>
        </div>
    </div>
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