<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mon Espace IT - DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f9f9f9; color: #333; }
        
        /* HEADER */
        .header {
            background: white;
            padding: 20px 40px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .header-left h1 { 
            font-size: 1.4rem; 
            font-weight: 700;
            margin-bottom: 5px; 
            color: #1a1d20;
        }
        
        .header-left p { 
            font-size: 0.85rem; 
            color: #777; 
        }
        
        .header-right { 
            display: flex; 
            gap: 25px; 
            align-items: center; 
        }
        
        .header-right a { 
            color: #007bff; 
            text-decoration: none; 
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        
        .header-right a:hover { 
            color: #0056b3; 
        }
        
        .logout-btn { 
            color: #dc3545; 
            background: none; 
            border: none; 
            cursor: pointer; 
            font-weight: 500;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        
        .logout-btn:hover {
            color: #c82333;
        }
        
        /* MAIN CONTAINER */
        .container { 
            max-width: 1200px; 
            margin: 30px auto; 
            padding: 0 20px; 
        }
        
        /* SECTION */
        .section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 30px;
        }
        
        /* SECTION HEADER */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a1d20;
        }
        
        .section-actions {
            display: flex;
            gap: 15px;
        }
        
        /* BUTTONS */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            transition: 0.2s;
            white-space: nowrap;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background: #0056b3;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
        }
        
        /* SUBSECTION */
        .subsection-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1a1d20;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }
        
        thead th {
            text-align: left;
            padding: 12px 15px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        tbody td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
        }
        
        tbody tr:hover {
            background: #f9f9f9;
        }
        
        tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* STATUS BADGE */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-EN-ATTENTE { 
            background: #fff3cd; 
            color: #856404; 
        }
        
        .status-APPROUVÉE { 
            background: #d4edda; 
            color: #155724; 
        }
        
        .status-ACTIVE { 
            background: #d4edda; 
            color: #155724; 
        }
        
        .status-VALIDÉE { 
            background: #d4edda; 
            color: #155724; 
        }
        
        .status-TERMINÉE { 
            background: #e2e3e5; 
            color: #383d41; 
        }
        
        .status-REFUSÉE { 
            background: #f8d7da; 
            color: #842029; 
        }
        
        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #ddd;
        }
        
        .empty-state p {
            font-size: 1rem;
            margin-bottom: 20px;
        }
        
        .bottom-action {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <div class="header-left">
        <h1>Mon Espace IT</h1>
        <p>Bienvenue, <strong>{{ Auth::user()->name }}</strong></p>
    </div>
    <div class="header-right">
        <a href="{{ route('welcome') }}"><i class='bx bxs-home'></i> Accueil</a>
        <a href="{{ route('user.history') }}"><i class='bx bx-history'></i> Historique</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">DÉCONNEXION</button>
        </form>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- CARTE DE PROFIL UTILISATEUR INTERNE (Affichée seulement pour les utilisateurs avec user_type) -->
    @if(Auth::user()->user_type)
    <div class="section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 30px;">
        <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 30px; align-items: center;">
            <!-- Avatar -->
            <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                <i class='bx bxs-user'></i>
            </div>
            
            <!-- Infos -->
            <div>
                <h3 style="margin: 0 0 10px 0; font-size: 1.5rem;">{{ Auth::user()->name }}</h3>
                <p style="margin: 0 0 5px 0; font-size: 0.9rem;"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p style="margin: 0; font-size: 0.9rem;">
                    <strong>Profil:</strong> 
                    <span style="background: rgba(255,255,255,0.3); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem;">
                        {{ Auth::user()->user_type }}
                    </span>
                </p>
            </div>

            <!-- Stats -->
            <div style="text-align: right;">
                <div style="margin-bottom: 15px;">
                    <div style="font-size: 2rem; font-weight: 700;">{{ Auth::user()->reservations()->count() }}</div>
                    <div style="font-size: 0.85rem; opacity: 0.9;">Réservations Totales</div>
                </div>
                <div>
                    <div style="font-size: 2rem; font-weight: 700;">{{ Auth::user()->reservations()->where('status', 'EN ATTENTE')->count() }}</div>
                    <div style="font-size: 0.85rem; opacity: 0.9;">En Attente</div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- MES RÉSERVATIONS EN COURS -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Mes Réservations en cours</h2>
            <div class="section-actions">
                <a href="{{ route('user.history') }}" class="btn btn-success">
                    <i class='bx bxs-time'></i> Voir mon Historique
                </a>
                <a href="{{ route('user.create-reservation') }}" class="btn btn-primary">
                    <i class='bx bxs-plus-circle'></i> Nouvelle Réservation
                </a>
            </div>
        </div>

        <!-- SUIVI DE MES DEMANDES -->
        <div class="subsection-title">Suivi de mes demandes</div>

        @if($reservations->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Ressource</th>
                        <th>Période</th>
                        <th>Justification</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>
                                <strong>{{ $reservation->resource->name }}</strong>
                            </td>
                            <td>
                                <small>
                                    Du {{ $reservation->start_date->format('d/m/Y H:i') }}<br>
                                    au {{ $reservation->end_date->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                {{ $reservation->justification ?? 'Non spécifié' }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ str_replace(' ', '-', $reservation->status) }}">
                                    {{ $reservation->status }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->status === 'EN ATTENTE')
                                    <form action="{{ route('user.cancel-reservation', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer l\'annulation ?')">
                                            <i class='bx bxs-trash'></i> Annuler
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('incidents.create', $reservation->resource_id) }}" class="btn btn-danger btn-sm">
                                        <i class='bx bxs-error'></i> Signaler Incident
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class='bx bxs-inbox'></i>
                <p>Aucune réservation pour le moment</p>
                <a href="{{ route('user.create-reservation') }}" class="btn btn-primary">
                    <i class='bx bxs-plus-circle'></i> Créer une demande
                </a>
            </div>
        @endif
    </div>

</div>

</body>
</html>
