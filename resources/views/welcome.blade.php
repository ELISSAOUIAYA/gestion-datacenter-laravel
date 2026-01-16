<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataCenter Pro | Infrastructure Cloud</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        /* --- 1. MODERN DESIGN SYSTEM --- */
        :root[data-theme="light"] {
            --bg-body: #f8fafc;
            --bg-navbar: rgba(255, 255, 255, 0.95);
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #2563eb;
            --border: rgba(0, 0, 0, 0.08);
            --shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        :root[data-theme="dark"] {
            --bg-body: #020617;
            --bg-navbar: rgba(2, 6, 23, 0.95);
            --bg-card: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #38bdf8;
            --border: rgba(255, 255, 255, 0.1);
            --shadow: 0 20px 50px rgba(0,0,0,0.3);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', system-ui, sans-serif; transition: all 0.3s ease; }
        body { background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

        /* --- 2. NAVBAR & BUTTONS --- */
        .navbar {
            background: var(--bg-navbar); backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border); padding: 15px 0;
            position: fixed; top: 0; width: 100%; z-index: 1000;
        }
        .nav-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.5rem; font-weight: 800; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 8px; }
        .logo span { color: var(--primary); }

        .nav-right { display: flex; align-items: center; gap: 20px; }
        
        /* Connexion Link Style */
        .nav-link { 
            text-decoration: none; color: var(--text-main); font-weight: 600; 
            font-size: 0.9rem; padding: 8px 12px; border-radius: 8px;
        }
        .nav-link:hover { background: var(--border); }

        .btn-main { 
            padding: 10px 24px; border-radius: 10px; font-weight: 700; cursor: pointer; 
            border: none; font-size: 0.9rem; background: var(--primary); color: white; text-decoration: none;
            display: inline-block;
        }

        .theme-toggle {
            background: var(--bg-card); border: 1px solid var(--border); color: var(--text-main);
            padding: 8px; border-radius: 50%; cursor: pointer; font-size: 1.2rem; display: flex;
        }

        /* --- 3. HERO SECTION --- */
        .hero {
            position: relative; height: 60vh; display: flex; align-items: center;
            justify-content: center; text-align: center;
            background: url('https://images.unsplash.com/photo-1551434678-e076c223a692?q=80&w=2000') center/cover no-repeat;
            margin-bottom: 80px; padding-top: 80px;
        }
        .hero::before {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(to bottom, rgba(2, 6, 23, 0.7) 0%, var(--bg-body) 100%);
            z-index: 1;
        }
        .hero-content { position: relative; z-index: 2; max-width: 800px; }
        .hero h1 { font-size: 3.5rem; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: -1px; }
        .hero p { color: rgba(255,255,255,0.8); margin-top: 10px; font-size: 1.1rem; }

        /* --- 4. CATEGORY CARDS --- */
        .category-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px; margin-top: -100px; position: relative; z-index: 10;
        }
        .cat-card {
            background: var(--bg-card); border-radius: 24px; overflow: hidden;
            border: 1px solid var(--border); box-shadow: var(--shadow); cursor: pointer;
        }
        .cat-card:hover { transform: translateY(-10px); border-color: var(--primary); }
        
        .cat-img-box { height: 180px; width: 100%; overflow: hidden; position: relative; background: #111; }
        .cat-img-box img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .cat-img-box::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, var(--bg-card), transparent); }

        .cat-body { padding: 25px; text-align: center; }
        .cat-body i { font-size: 2.2rem; color: var(--primary); margin-bottom: 12px; display: block; }
        .cat-body h3 { font-size: 1.2rem; margin-bottom: 5px; }

        /* --- 5. INVENTORY TABLE --- */
        .inventory-section {
            background: var(--bg-card); border-radius: 24px; padding: 40px;
            margin: 60px 0; border: 1px solid var(--border); box-shadow: var(--shadow);
            display: none; animation: fadeInUp 0.6s ease;
        }
        #table-title { font-size: 1.4rem; margin-bottom: 30px; border-left: 5px solid var(--primary); padding-left: 15px; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; border-bottom: 1px solid var(--border); }
        td { padding: 20px 15px; border-bottom: 1px solid var(--border); font-size: 0.95rem; }
        
        .resource-row { display: none; }
        .resource-row.visible { display: table-row; }

        .status-badge { padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }
        .status-available { background: rgba(34, 197, 94, 0.1); color: #22c55e; }
        .status-occupied { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        footer { text-align: center; padding: 50px; color: var(--text-muted); border-top: 1px solid var(--border); }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container nav-content">
        <a href="/" class="logo"><i class='bx bxs-bolt-circle'></i> DATA<span>PRO</span></a>
        <div class="nav-right">
            <button class="theme-toggle" id="themeBtn"><i class='bx bx-moon'></i></button>
            @guest
                <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                <a href="{{ route('register') }}" class="btn-main">Démarrer</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">@csrf
                    <button type="submit" class="nav-link" style="background:none; border:none; cursor:pointer;">Sortir</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

<header class="hero">
    <div class="hero-content">
        <h1>Infrastructure <br><span style="color: var(--primary);">Cloud Future</span></h1>
        <p>Réservez des ressources haute performance en un clic.</p>
    </div>
</header>

<main class="container">
    <div class="category-grid">
        <div class="cat-card" onclick="filterResources('SERVEUR', this)">
            <div class="cat-img-box">
                <img src= "https://cdn.pixabay.com/photo/2023/04/29/16/10/ai-generated-7958873_1280.jpg"alt="Serveur Image">
            </div>
            <div class="cat-body">
                <i class='bx bxs-server'></i>
                <h3>SERVEURS</h3>
                <p>Bare Metal Performance</p>
            </div>
        </div>

        <div class="cat-card" onclick="filterResources('VM', this)">
            <div class="cat-img-box">
                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=800" alt="VM Image">
            </div>
            <div class="cat-body">
                <i class='bx bxs-cloud'></i>
                <h3>INSTANCES VM</h3>
                <p>Scalabilité Cloud</p>
            </div>
        </div>

        <div class="cat-card" onclick="filterResources('STOCKAGE', this)">
            <div class="cat-img-box">
                <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=800" alt="Storage Image">
            </div>
            <div class="cat-body">
                <i class='bx bxs-hdd'></i>
                <h3>STOCKAGE</h3>
                <p>NVMe Flash Storage</p>
            </div>
        </div>

        <div class="cat-card" onclick="filterResources('RESEAU', this)">
            <div class="cat-img-box">
                <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=800" alt="Network Image">
            </div>
            <div class="cat-body">
                <i class='bx bx-transfer-alt'></i>
                <h3>RÉSEAU</h3>
                <p>100Gbps Fibre</p>
            </div>
        </div>
    </div>

    <section class="inventory-section" id="inventory-section">
        <h2 id="table-title">Liste des équipements</h2>
        <table>
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Spécifications</th>
                    <th>Statut</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                    @php $cat = strtolower(str_replace(['é','è','ê'], 'e', $resource->category->name)); @endphp
                    <tr class="resource-row" data-category="{{ $cat }}">
                        <td><strong>{{ $resource->name }}</strong></td>
                        <td><small>{{ $resource->cpu }} | {{ $resource->ram }}</small></td>
                        <td>
                            <span class="status-badge {{ $resource->status == 'available' ? 'status-available' : 'status-occupied' }}">
                                {{ $resource->status == 'available' ? 'Disponible' : 'Occupé' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            @if($resource->status == 'available')
                                <a href="{{ route('reservations.create', ['resource_id' => $resource->id]) }}" class="btn-main" style="padding: 7px 15px; font-size: 0.75rem;">
                                    RÉSERVER
                                </a>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.75rem; font-weight: 700;">OCCUPÉ</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</main>

<footer><p>© 2026 DataCenter Pro • Infrastructure de Pointe</p></footer>

<script>
    const themeBtn = document.getElementById('themeBtn');
    const html = document.documentElement;

    themeBtn.addEventListener('click', () => {
        const isDark = html.getAttribute('data-theme') === 'dark';
        html.setAttribute('data-theme', isDark ? 'light' : 'dark');
        themeBtn.innerHTML = isDark ? "<i class='bx bx-sun'></i>" : "<i class='bx bx-moon'></i>";
    });

    function filterResources(category, el) {
        document.getElementById('inventory-section').style.display = 'block';
        document.getElementById('table-title').innerText = "Ressources : " + category;
        const target = category.toLowerCase().replace(/[éèê]/g, 'e');
        
        document.querySelectorAll('.resource-row').forEach(row => {
            row.classList.toggle('visible', row.getAttribute('data-category').includes(target));
        });
        window.scrollTo({ top: document.getElementById('inventory-section').offsetTop - 100, behavior: 'smooth' });
    }
</script>
</body>
</html>