
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Center Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Style temporaire pour ton test technique */
        .debug-zone { background: #f8f9fa; border: 2px dashed #ff0000; padding: 20px; margin: 20px; }
        .debug-table { width: 100%; border-collapse: collapse; background: white; }
        .debug-table th, .debug-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter Pro | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#"><i class='bx bxs-server text-primary'></i> DataCenter Pro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#ressources">Ressources</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-primary btn-sm me-2" href="{{ route('login') }}">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Inscription</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section text-white d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-3 fw-bold mb-3">Bienvenue sur la plateforme de réservation</h1>
            <p class="lead mb-5 text-light">Consultez nos serveurs, machines virtuelles et capacités de stockage en temps réel.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#ressources" class="btn btn-primary btn-lg px-4 shadow">Explorer les ressources</a>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">Démarrer maintenant</a>
            </div>
        </div>
    </header>

    <main>
        <h2>Bienvenue sur la plateforme de réservation</h2>
        <p>Consultez nos serveurs, machines virtuelles et capacités de stockage en temps réel.</p>

        <section class="debug-zone">
            <h3 style="color: red;">🛠 ZONE DE TEST : Réservations en Base</h3>
            <table class="debug-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Ressource</th>
                        <th>Statut (Enum)</th>
                        <th>Dates</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $res)
                        <tr>
                            <td>{{ $res->user->name ?? 'N/A' }}</td>
                            <td>{{ $res->resource->name ?? 'N/A' }}</td>
                            <td><strong>{{ $res->status }}</strong></td>
                            <td>Du {{ $res->start_date }} au {{ $res->end_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucune réservation trouvée. As-tu bien fait le test Tinker ?</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
        </main>
    <section id="ressources" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Nos Ressources Disponibles</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card resource-card border-0 shadow-sm h-100 p-4">
                        <i class='bx bxs-chip display-4 text-primary mb-3'></i>
                        <h4>Serveurs Physiques</h4>
                        <p class="text-muted">Des performances brutes pour vos calculs intensifs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card resource-card border-0 shadow-sm h-100 p-4">
                        <i class='bx bxs-cloud display-4 text-info mb-3'></i>
                        <h4>Machines Virtuelles</h4>
                        <p class="text-muted">Flexibilité totale avec nos instances cloud scalables.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card resource-card border-0 shadow-sm h-100 p-4">
                        <i class='bx bxs-hdd display-4 text-success mb-3'></i>
                        <h4>Stockage SSD</h4>
                        <p class="text-muted">Capacités de stockage haute vitesse redondées.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0">© 2026 - Système de Gestion de Data Center</p>
            <small class="text-secondary">Conçu pour la haute performance.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('shadow-lg', 'bg-dark'); // زدنا حتى اللون باش يبان التغيير
            } else {
                document.querySelector('.navbar').classList.remove('shadow-lg');
            }
        });
    </script>
    <button id="theme-toggle" class="btn btn-outline-secondary btn-sm">
    <i class='bx bx-moon' id="theme-icon"></i>
    <span id="theme-text">Mode Sombre</span>
</button>
</body>
</html>
</body>
</html>
