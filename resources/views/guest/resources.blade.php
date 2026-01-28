@extends('layouts.app')

@section('content')
<style>
    /* --- VARIABLES DU THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;          /* Cyan */
        --primary-hover: #0ea5e9;
        --bg-body: #020617;         /* Fond Ultra Dark */
        --bg-card: #0f172a;         /* Cartes & Sections */
        --text-main: #f8fafc;       /* Blanc */
        --text-muted: #94a3b8;      /* Gris bleu */
        --border: rgba(255, 255, 255, 0.08);
        --input-bg: #1e293b;
        --success: #22c55e;
    }

    body { 
        margin: 0; 
        background-color: var(--bg-body); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    .guest-container { padding: 30px 40px; min-height: 100vh; }

    /* En-tête */
    .header-box { 
        background: var(--bg-card); 
        padding: 25px 35px; 
        border-radius: 12px; 
        border: 1px solid var(--border);
        margin-bottom: 25px; 
        border-left: 6px solid var(--primary); 
    }
    .header-box h1 { margin: 0; font-weight: 800; color: var(--text-main); font-size: 1.8rem; }
    .header-box p { margin: 8px 0 0; color: var(--text-muted); }

    /* Info Box */
    .info-box { 
        background-color: rgba(56, 189, 248, 0.1); 
        border: 1px solid var(--primary); 
        padding: 18px; 
        border-radius: 10px; 
        margin-bottom: 25px; 
        color: var(--primary);
        display: flex;
        align-items: center;
    }

    /* Filtres */
    .filters-section { 
        background: var(--bg-card); 
        padding: 25px; 
        border-radius: 12px; 
        margin-bottom: 30px; 
        border: 1px solid var(--border); 
    }
    .filter-group label { display: block; font-weight: 700; color: var(--primary); margin-bottom: 8px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
    .filter-group input, .filter-group select { 
        width: 100%; 
        padding: 12px; 
        background: var(--input-bg); 
        border: 1px solid var(--border); 
        border-radius: 8px; 
        color: white; 
        font-size: 0.9rem; 
        outline: none;
    }
    .filter-group input:focus, .filter-group select:focus { border-color: var(--primary); }

    /* Boutons */
    .btn { padding: 12px 20px; border-radius: 8px; border: none; cursor: pointer; font-weight: 800; font-size: 11px; text-transform: uppercase; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; }
    .btn-primary { background-color: var(--primary); color: #020617; }
    .btn-success { background-color: var(--success); color: white; }
    .btn-reset { background: #334155; color: white; }

    /* Grille de ressources */
    .resources-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; margin-bottom: 40px; }
    .resource-card { 
        background: var(--bg-card); 
        border-radius: 15px; 
        overflow: hidden; 
        border: 1px solid var(--border); 
        transition: all 0.3s ease; 
    }
    .resource-card:hover { transform: translateY(-5px); border-color: var(--primary); box-shadow: 0 10px 30px -10px rgba(56, 189, 248, 0.2); }

    .resource-header { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-bottom: 1px solid var(--border); padding: 20px; }
    .resource-header h3 { margin: 0; font-size: 1.25rem; font-weight: 800; color: var(--primary); }
    .resource-category { font-size: 0.75rem; color: var(--text-muted); margin-top: 5px; text-transform: uppercase; letter-spacing: 1px; }

    .resource-body { padding: 20px; }
    .resource-spec { display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border); }
    .resource-spec-label { font-weight: 600; color: var(--text-muted); font-size: 0.85rem; }
    .resource-spec-value { color: var(--text-main); font-size: 0.85rem; font-weight: 700; }

    /* Badges Statut */
    .status-badge { padding: 5px 12px; border-radius: 6px; font-size: 10px; font-weight: 800; text-transform: uppercase; }
    .status-available { background-color: rgba(34, 197, 94, 0.2); color: #4ade80; }
    .status-maintenance { background-color: rgba(245, 158, 11, 0.2); color: #fbbf24; }

    /* Règles */
    .rules-section { background: var(--bg-card); padding: 35px; border-radius: 12px; border: 1px solid var(--border); margin-top: 40px; }
    .rules-section h2 { color: var(--text-main); margin-bottom: 25px; font-size: 1.4rem; font-weight: 800; }
    .rules-list li { padding: 15px 0; border-bottom: 1px solid var(--border); display: flex; gap: 15px; align-items: center; color: var(--text-muted); }
    .rules-list i { color: var(--primary); font-size: 1.2rem; }

    .sidebar, .left-sidebar { display: none !important; }
</style>

<div class="guest-container">
    {{-- EN-TÊTE --}}
    <div class="header-box">
        <h1><i class='bx bx-hdd'></i> Infrastructure Cloud & Matériel</h1>
        <p>Explorez les ressources disponibles dans notre centre de données de recherche.</p>
    </div>

    {{-- MESSAGE SUCCÈS --}}
    @if (session('success'))
        <div style="background-color: rgba(34, 197, 94, 0.2); border: 1px solid var(--success); color: #4ade80; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class='bx bx-check-circle'></i> <strong>Succès :</strong> {{ session('success') }}
        </div>
    @endif

    {{-- INFO BOX --}}
    <div class="info-box">
        <i class='bx bx-info-circle' style="font-size: 1.5rem; margin-right: 15px;"></i>
        <div>
            <strong>Mode Consultation :</strong> Vous explorez le catalogue en tant qu'invité. 
            Pour réserver un équipement, <a href="{{ route('guest.account-request.create') }}" style="color: var(--primary); font-weight: 800; text-decoration: underline;">soumettez une demande de compte</a>.
        </div>
    </div>

    {{-- FILTRES --}}
    <div class="filters-section">
        <form method="GET" action="{{ route('guest.resources') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
            <div class="filter-group" style="flex: 2; min-width: 250px;">
                <label for="search">Recherche textuelle</label>
                <input type="text" id="search" name="search" placeholder="Nom de l'équipement..." value="{{ request('search') }}">
            </div>
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label for="category">Catégorie</label>
                <select id="category" name="category">
                    <option value="">Tous les types</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label for="status">État</label>
                <select id="status" name="status">
                    <option value="">Tous les états</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>En Maintenance</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i> Filtrer</button>
                <a href="{{ route('guest.resources') }}" class="btn btn-reset"><i class='bx bx-reset'></i></a>
            </div>
        </form>
    </div>

    {{-- GRILLE DE RESSOURCES --}}
    @if($resources->count() > 0)
        <div class="resources-grid">
            @foreach($resources as $resource)
                <div class="resource-card">
                    <div class="resource-header">
                        <h3>{{ $resource->name }}</h3>
                        <div class="resource-category">
                            <i class='bx bx-chip'></i> {{ $resource->category->name ?? 'Système' }}
                        </div>
                    </div>
                    <div class="resource-body">
                        @if($resource->cpu)
                            <div class="resource-spec">
                                <span class="resource-spec-label">Processeur</span>
                                <span class="resource-spec-value">{{ $resource->cpu }}</span>
                            </div>
                        @endif

                        @if($resource->ram)
                            <div class="resource-spec">
                                <span class="resource-spec-label">Mémoire Vive</span>
                                <span class="resource-spec-value">{{ $resource->ram }}</span>
                            </div>
                        @endif

                        @if($resource->os)
                            <div class="resource-spec">
                                <span class="resource-spec-label">Système</span>
                                <span class="resource-spec-value">{{ $resource->os }}</span>
                            </div>
                        @endif

                        @if($resource->location)
                            <div class="resource-spec">
                                <span class="resource-spec-label">Site / Rack</span>
                                <span class="resource-spec-value">{{ $resource->location }}</span>
                            </div>
                        @endif

                        @if($resource->capacity)
                            <div class="resource-spec">
                                <span class="resource-spec-label">Stockage</span>
                                <span class="resource-spec-value">{{ $resource->capacity }}</span>
                            </div>
                        @endif

                        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                            <span class="status-badge status-{{ $resource->status }}">
                                {{ $resource->status == 'available' ? 'Disponible' : 'Maintenance' }}
                            </span>
                            <a href="{{ route('guest.account-request.create') }}" class="btn btn-success" style="padding: 8px 12px; font-size: 9px;">
                                <i class='bx bx-lock-open-alt'></i> Réserver
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 100px 20px; background: var(--bg-card); border-radius: 12px; border: 1px dashed var(--border);">
            <i class='bx bx-search-alt' style="font-size: 4rem; color: var(--text-muted); margin-bottom: 20px; display: block;"></i>
            <p style="color: var(--text-muted); font-size: 1.2rem;">Aucun équipement ne correspond à votre recherche.</p>
            <a href="{{ route('guest.resources') }}" class="btn btn-primary" style="margin-top: 20px;">Voir tout le catalogue</a>
        </div>
    @endif

    {{-- RÈGLES D'UTILISATION --}}
    <div class="rules-section">
        <h2><i class='bx bx-shield-quarter' style="color: var(--primary);"></i> Protocole d'Utilisation</h2>
        <ul class="rules-list">
            <li><i class='bx bx-check-shield'></i> <strong>Identification :</strong> L'accès complet nécessite un compte validé par le département IT.</li>
            <li><i class='bx bx-git-pull-request'></i> <strong>Réservations :</strong> Priorité accordée aux projets de recherche critiques et examens.</li>
            <li><i class='bx bx-timer'></i> <strong>Limites :</strong> Durée standard de 30 jours, renouvelable selon disponibilité.</li>
            <li><i class='bx bx-wrench'></i> <strong>Maintenance :</strong> Des fenêtres de maintenance hebdomadaires peuvent impacter l'accès.</li>
        </ul>
    </div>
</div>
@endsection