<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Center Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Gestion du Data Center</h1>
        <nav>
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Ressources disponibles</a></li>
                <li><a href="#">Connexion / Inscription</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Bienvenue sur la plateforme de réservation</h2>
        <p>Consultez nos serveurs, machines virtuelles et capacités de stockage en temps réel.</p>
    </main>

    <footer>
        <p>&copy; 2025 - Système de Gestion de Data Center</p>
    </footer>
</body>
</html>
