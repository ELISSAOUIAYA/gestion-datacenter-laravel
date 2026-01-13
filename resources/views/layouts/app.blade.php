<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter Admin</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7fa; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #0f172a; color: white; transition: all 0.3s; }
        .sidebar-header { padding: 20px; font-weight: bold; font-size: 1.2rem; border-bottom: 1px solid #1e293b; }
        .nav-link { color: #94a3b8; padding: 12px 20px; border-radius: 8px; margin: 5px 15px; }
        .nav-link:hover, .nav-link.active { background: #1e293b; color: white; }
        .main-content { margin-left: 260px; padding: 30px; }
        .top-nav { background: white; padding: 15px 30px; border-bottom: 1px solid #e2e8f0; margin-left: 260px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">🛡️ DataCenter Pro</div>
        <nav class="nav flex-column mt-3">
            <a href="#" class="nav-link active">🏠 Dashboard</a>
            <a href="#" class="nav-link">🖥️ Serveurs</a>
            <a href="#" class="nav-link">📊 Rapports</a>
            <a href="#" class="nav-link">⚙️ Paramètres</a>
        </nav>
    </div>

    <div class="top-nav d-flex justify-content-between align-items-center">
        <span class="text-muted">Tableau de bord / Accueil</span>
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button">Admin</button>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

<div class="sidebar d-flex flex-column flex-shrink-0 p-3 shadow">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class='bx bxs-data fs-3 me-2 text-primary'></i>
        <span class="fs-4 fw-bold">DataCenter<span class="text-primary">X</span></span>
    </a>
    <hr class="text-secondary">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="#" class="nav-link active d-flex align-items-center">
                <i class='bx bxs-dashboard me-2'></i> Dashboard
            </a>
        </li>
        <li class="mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class='bx bxs-server me-2'></i> Liste des Serveurs
            </a>
        </li>
        <li class="mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class='bx bx-pulse me-2'></i> Monitoring
            </a>
        </li>
        <li class="mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center">
                <i class='bx bxs-group me-2'></i> Utilisateurs
            </a>
        </li>
        <li class="mb-2">
            <a href="#" class="nav-link text-white d-flex align-items-center text-warning">
                <i class='bx bxs-error me-2'></i> Alertes (3)
            </a>
        </li>
    </ul>
    <hr class="text-secondary">
    <div class="dropdown">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                <i class='bx bx-log-out-circle me-2'></i> Déconnexion
            </button>
        </form>
    </div>
</div>
</body>
</html>