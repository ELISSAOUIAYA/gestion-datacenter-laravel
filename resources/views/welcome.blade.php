<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DataCenter Pro | Accueil</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        .debug-zone { background: #f8f9fa; border: 2px dashed #0d6efd; padding: 20px; margin: 20px; border-radius: 10px; }
        .res-table { width: 100%; border-collapse: collapse; background: white; margin-top: 15px; }
        .res-table th, .res-table td { border: 1px solid #ddd; padding: 12px; text-align: left; vertical-align: middle; }
        .res-table th { background-color: #f4f4f4; text-transform: uppercase; font-size: 11px; color: #555; }
        
        /* Badges de statut traduits */
        .status { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .status-available { background: #d4edda; color: #155724; } /* Disponible */
        .status-maintenance { background: #f8d7da; color: #721c24; } /* Maintenance */
        .status-occupied { background: #fff3cd; color: #856404; } /* Occupé */
        
        .type-tag { color: #666; font-style: italic; font-size: 13px; }
        .btn-reserve { font-size: 12px; font-weight: bold; text-transform: uppercase; }
    </style>
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
                    @guest
                        <li class="nav-item ms-lg-3"><a class="btn btn-outline-primary btn-sm me-2" href="{{ route('login') }}">Connexion</a></li>
                        <li class="nav-item"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Inscription</a></li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Déconnexion</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section text-white d-flex align-items-center bg-dark py-5">
        <div class="container text-center py-5">
            <h1 class="display-3 fw-bold mb-3">Gestion de Data Center</h1>
            <p class="lead mb-5 text-light">Consultez nos serveurs, machines virtuelles et capacités de stockage en temps réel.</p>
        </div>
    </header>

    <main class="container my-5">
        <section class="debug-zone shadow-sm">
            <h3 class="mb-4"><i class='bx bx-bug'></i> Zone de Test : Monitoring de la Base</h3>
            
            <h5 class="mt-4">1. Réservations en cours</h5>
            <table class="res-table mb-5">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Ressource</th>
                        <th>Statut</th>
                        <th>Période</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $res)
                        <tr>
                            <td>{{ $res->user->name ?? 'N/A' }}</td>
                            <td>{{ $res->resource->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-primary">{{ $res->status == 'confirmed' ? 'Confirmée' : 'En attente' }}</span></td>
                            <td>Du {{ $res->start_date }} au {{ $res->end_date }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Aucune réservation trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <h5 class="mt-4">2. Ressources disponibles ({{ count($resources) }} éléments)</h5>
            <table class="res-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Capacité</th>
                        <th>État</th>
                        <th class="text-center">Réserver</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resources as $resource)
                    <tr>
                        <td><strong>{{ $resource->name }}</strong></td>
                        <td>
                            <span class="type-tag">
                                @switch($resource->type)
                                    @case('server') Serveur @break
                                    @case('vm') Machine Virtuelle @break
                                    @case('storage') Stockage @break
                                    @case('network') Réseau @break
                                    @default {{ $resource->type }}
                                @endswitch
                            </span>
                        </td>
                        <td>{{ $resource->capacity }}</td>
                        <td>
                            <span class="status status-{{ $resource->status }}">
                                @if($resource->status == 'available') DISPONIBLE 
                                @elseif($resource->status == 'occupied') OCCUPÉ
                                @else MAINTENANCE @endif
                            </span>
                        </td>
                        <td class="text-center">
                            @auth
                                <a href="{{ route('reservations.create', ['resource_id' => $resource->id]) }}" class="btn btn-sm btn-success btn-reserve">
                                    <i class='bx bx-calendar-check'></i> Réserver
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 9px;">
                                    Connexion requise
                                </a>
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>

    <footer class="bg-dark text-white py-4 text-center">
        <p class="mb-0">© 2026 - Système de Gestion de Data Center</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>