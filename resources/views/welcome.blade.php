
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter Pro | Accueil</title>
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
