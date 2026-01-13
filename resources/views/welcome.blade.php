<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

    <footer>
        <p>&copy; 2025 - Système de Gestion de Data Center</p>
    </footer>
</body>
</html>
