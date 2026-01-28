@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --primary-hover: #0ea5e9;
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Fond des cartes */
        --text-main: #f8fafc;       /* Texte blanc */
        --text-muted: #94a3b8;      /* Texte gris bleu */
        --border: rgba(255, 255, 255, 0.08);
        --danger: #ef4444;
        --success: #22c55e;
        --warning: #f59e0b;
    }

    body { 
        margin: 0; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    /* HEADER STYLE */
    .header {
        background: var(--bg-card);
        padding: 20px 40px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .header-left h1 { 
        font-size: 1.4rem; 
        font-weight: 800;
        margin: 0;
        color: var(--text-main);
    }
    
    .header-left p { font-size: 0.85rem; color: var(--text-muted); margin-top: 5px; }
    
    .header-right { display: flex; gap: 25px; align-items: center; }
    
    .header-right a { 
        color: var(--text-main); 
        text-decoration: none; 
        font-weight: 700;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }
    .header-right a:hover { color: var(--primary); }
    
    .logout-btn { 
        color: var(--danger); 
        background: rgba(239, 68, 68, 0.1); 
        border: 1px solid var(--danger); 
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer; 
        font-weight: 700;
        font-size: 0.8rem;
        transition: 0.3s;
    }
    .logout-btn:hover { background: var(--danger); color: white; }

    /* MAIN CONTAINER */
    .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
    
    /* SECTION BOX */
    .section {
        background: var(--bg-card);
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    /* PROFILE CARD WITH GRADIENT */
    .profile-card {
        background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%); 
        color: white; 
        padding: 35px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 10px 20px -5px rgba(14, 165, 233, 0.3);
    }

    .avatar-circle {
        width: 80px; height: 80px; 
        background: rgba(255,255,255,0.2); 
        border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; 
        font-size: 2.5rem;
    }

    .profile-stat-box { text-align: right; }
    .profile-stat-value { font-size: 2.2rem; font-weight: 900; line-height: 1; }
    .profile-stat-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; margin-top: 5px; }

    /* TABLE STYLE */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    
    .section-title { font-size: 1.25rem; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 10px; }
    
    table { width: 100%; border-collapse: separate; border-spacing: 0; }
    thead th {
        text-align: left;
        padding: 15px;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid var(--border);
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        letter-spacing: 1px;
    }
    
    tbody td { padding: 15px; border-bottom: 1px solid var(--border); font-size: 0.9rem; color: var(--text-main); }
    tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

    /* BUTTONS */
    .btn {
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        transition: 0.2s;
        text-decoration: none;
        border: none;
    }
    .btn-primary { background: var(--primary); color: #020617; }
    .btn-success { background: var(--success); color: white; }
    .btn-danger { background: var(--danger); color: white; }
    .btn-sm { padding: 6px 12px; font-size: 0.75rem; }
    .btn:hover { opacity: 0.9; transform: translateY(-2px); }

    /* STATUS BADGES */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
    }
    .status-EN-ATTENTE { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
    .status-APPROUVÉE, .status-ACTIVE, .status-VALIDÉE { background: rgba(34, 197, 94, 0.2); color: var(--success); }
    .status-TERMINÉE { background: rgba(148, 163, 184, 0.2); color: var(--text-muted); }
    .status-REFUSÉE { background: rgba(239, 68, 68, 0.2); color: var(--danger); }

    /* EMPTY STATE */
    .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 3.5rem; margin-bottom: 20px; opacity: 0.2; }

    /* Hide redundant elements if any */
    .sidebar, .left-sidebar { display: none !important; }
</style>

<div class="header">
    <div class="header-left">
        <h1>Mon Espace IT</h1>
        <p>Bienvenue dans votre centre de contrôle, <strong>{{ Auth::user()->name }}</strong></p>
    </div>
    <div class="header-right">
        <a href="{{ route('welcome') }}"><i class='bx bxs-home'></i> ACCUEIL</a>
        <a href="{{ route('user.history') }}"><i class='bx bx-history'></i> HISTORIQUE</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">DÉCONNEXION</button>
        </form>
    </div>
</div>

<div class="container">

    @if(Auth::user()->user_type)
    <div class="profile-card">
        <div style="display: grid; grid-template-columns: auto 1fr auto; gap: 30px; align-items: center;">
            <div class="avatar-circle">
                <i class='bx bxs-user-badge'></i>
            </div>
            
            <div>
                <h3 style="margin: 0 0 5px 0; font-size: 1.6rem; font-weight: 800;">{{ Auth::user()->name }}</h3>
                <p style="margin: 0 0 10px 0; font-size: 0.9rem; opacity: 0.9;">{{ Auth::user()->email }}</p>
                <span style="background: rgba(255,255,255,0.25); padding: 5px 15px; border-radius: 30px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                    Profil: {{ Auth::user()->user_type }}
                </span>
            </div>

            <div style="display: flex; gap: 40px;">
                <div class="profile-stat-box">
                    <div class="profile-stat-value">{{ Auth::user()->reservations()->count() }}</div>
                    <div class="profile-stat-label">Total Réservations</div>
                </div>
                <div class="profile-stat-box">
                    <div class="profile-stat-value">{{ Auth::user()->reservations()->where('status', 'EN ATTENTE')->count() }}</div>
                    <div class="profile-stat-label">Demandes en cours</div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="section">
        <div class="section-header">
            <h2 class="section-title"><i class='bx bx-calendar-check'></i> Mes Réservations en cours</h2>
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('user.history') }}" class="btn btn-success">
                    <i class='bx bxs-time'></i> Historique
                </a>
                <a href="{{ route('user.create-reservation') }}" class="btn btn-primary">
                    <i class='bx bxs-plus-circle'></i> Nouvelle demande
                </a>
            </div>
        </div>

        <div style="margin: 20px 0 15px; font-size: 0.8rem; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">
            Suivi temps réel de mes demandes
        </div>

        @if($reservations->count() > 0)
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Équipement IT</th>
                            <th>Période d'utilisation</th>
                            <th>Justification</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                            <tr>
                                <td><strong style="color: var(--primary);">{{ $reservation->resource->name }}</strong></td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        Du {{ $reservation->start_date->format('d/m/Y H:i') }}<br>
                                        au {{ $reservation->end_date->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td style="max-width: 250px; color: var(--text-muted);">
                                    {{ Str::limit($reservation->justification ?? 'Non spécifié', 60) }}
                                </td>
                                <td>
                                    <span class="status-badge status-{{ str_replace(' ', '-', $reservation->status) }}">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($reservation->status === 'EN ATTENTE')
                                        <form action="{{ route('user.cancel-reservation', $reservation->id) }}" method="POST" onsubmit="return confirm('Souhaitez-vous vraiment annuler cette demande ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class='bx bxs-trash'></i> Annuler
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('incidents.create', $reservation->resource_id) }}" class="btn btn-danger btn-sm" style="background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid var(--danger);">
                                            <i class='bx bxs-error-circle'></i> Signaler Incident
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class='bx bxs-inbox'></i>
                <p>Vous n'avez aucune réservation active ou en attente pour le moment.</p>
                <a href="{{ route('user.create-reservation') }}" class="btn btn-primary">
                    <i class='bx bxs-plus-circle'></i> Créer ma première demande
                </a>
            </div>
        @endif
    </div>

</div>



@endsection