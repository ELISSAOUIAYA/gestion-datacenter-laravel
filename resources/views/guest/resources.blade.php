@extends('layouts.app')

@section('content')
<style>
    .guest-container { padding: 30px; font-family: 'Segoe UI', system-ui, sans-serif; background-color: #f4f7f6; min-height: 100vh; }
    .header-box { background: white; padding: 25px 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 25px; border-left: 6px solid #2c3e50; }
    .header-box h1 { margin: 0; font-weight: 800; color: #2c3e50; }
    .header-box p { margin: 8px 0 0; color: #64748b; font-size: 0.95rem; }

    .filters-section { background: white; padding: 20px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .filters-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
    .filter-group label { display: block; font-weight: 700; color: #2c3e50; margin-bottom: 8px; font-size: 0.9rem; }
    .filter-group input, .filter-group select { width: 100%; padding: 10px; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; }
    .filter-group input:focus, .filter-group select:focus { border-color: #3b82f6; outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }

    .btn { padding: 10px 18px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700; font-size: 11px; text-transform: uppercase; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 6px; }
    .btn-primary { background-color: #3b82f6; color: white; }
    .btn-primary:hover { background-color: #2563eb; }
    .btn-success { background-color: #22c55e; color: white; }

    .resources-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; margin-bottom: 40px; }
    .resource-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: all 0.3s ease; border-top: 4px solid #3b82f6; }
    .resource-card:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.1); transform: translateY(-5px); }

    .resource-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; }
    .resource-header h3 { margin: 0; font-size: 1.3rem; font-weight: 800; }
    .resource-category { font-size: 0.8rem; opacity: 0.9; margin-top: 5px; }

    .resource-body { padding: 20px; }
    .resource-spec { display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e2e8f0; }
    .resource-spec-label { font-weight: 700; color: #2c3e50; font-size: 0.9rem; }
    .resource-spec-value { color: #64748b; font-size: 0.9rem; }

    .status-badge { padding: 6px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 800; display: inline-block; }
    .status-available { background-color: #dcfce7; color: #166534; }
    .status-maintenance { background-color: #fef3c7; color: #92400e; }
    .status-inactive { background-color: #fee2e2; color: #991b1b; }

    .resource-actions { margin-top: 15px; display: flex; gap: 10px; }
    .btn-small { padding: 8px 12px; font-size: 10px; }

    .info-box { background-color: #dbeafe; border: 2px solid #3b82f6; padding: 15px; border-radius: 8px; margin-bottom: 25px; }
    .info-box strong { color: #1e40af; }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 3rem; color: #94a3b8; margin-bottom: 20px; }
    .empty-state p { color: #64748b; font-size: 1.1rem; }

    .rules-section { background: white; padding: 30px; border-radius: 12px; margin-top: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .rules-section h2 { color: #2c3e50; margin-bottom: 20px; font-size: 1.3rem; }
    .rules-list { list-style: none; }
    .rules-list li { padding: 12px 0; border-bottom: 1px solid #e2e8f0; display: flex; gap: 12px; }
    .rules-list li:last-child { border-bottom: none; }
    .rules-list i { color: #22c55e; font-weight: 800; }
    .rules-list strong { color: #2c3e50; }
</style>

<div class="guest-container">
    <div class="header-box">
        <h1><i class='bx bx-hdd'></i> Ressources Disponibles</h1>
        <p>Consultez nos équipements informatiques en libre accès. Pour faire une demande de réservation, veuillez vous inscrire.</p>
    </div>

    @if (session('success'))
        <div style="background-color: #dcfce7; border: 2px solid #22c55e; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>Succès :</strong> {{ session('success') }}
        </div>
    @endif

    {{-- INFO BOX POUR INVITÉS --}}
    <div class="info-box">
        <i class='bx bx-info-circle' style="color: #3b82f6; margin-right: 10px;"></i>
        <strong>Vous êtes invité(e) :</strong> Vous pouvez consulter les ressources ci-dessous.
        Pour faire des demandes de réservation, vous devez d'abord 
        <a href="{{ route('account-request.create') }}" style="color: #3b82f6; text-decoration: underline; font-weight: 700;">demander l'ouverture d'un compte</a>.
    </div>

    {{-- SECTION FILTRES --}}
    <div class="filters-section">
        <h3 style="margin-top: 0; color: #2c3e50; margin-bottom: 15px;">
            <i class='bx bx-filter'></i> Filtrer les Ressources
        </h3>
        <form method="GET" action="{{ route('guest.resources') }}" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;">
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label for="search">Rechercher par nom</label>
                <input type="text" id="search" name="search" placeholder="Ex: Serveur, VM..." value="{{ request('search') }}">
            </div>
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label for="category">Catégorie</label>
                <select id="category" name="category">
                    <option value="">-- Toutes les catégories --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group" style="flex: 1; min-width: 200px;">
                <label for="status">État</label>
                <select id="status" name="status">
                    <option value="">-- Tous les états --</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>En Maintenance</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-search'></i> Filtrer
            </button>
            <a href="{{ route('guest.resources') }}" class="btn" style="background: #64748b; color: white;">
                <i class='bx bx-reset'></i> Réinitialiser
            </a>
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
                            <i class='bx bx-tag'></i> {{ $resource->category->name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="resource-body">
                        @if($resource->cpu)
                            <div class="resource-spec">
                                <span class="resource-spec-label"><i class='bx bx-microchip'></i> CPU</span>
                                <span class="resource-spec-value">{{ $resource->cpu }}</span>
                            </div>
                        @endif

                        @if($resource->ram)
                            <div class="resource-spec">
                                <span class="resource-spec-label"><i class='bx bx-memory-card'></i> RAM</span>
                                <span class="resource-spec-value">{{ $resource->ram }}</span>
                            </div>
                        @endif

                        @if($resource->os)
                            <div class="resource-spec">
                                <span class="resource-spec-label"><i class='bx bx-laptop'></i> OS</span>
                                <span class="resource-spec-value">{{ $resource->os }}</span>
                            </div>
                        @endif

                        @if($resource->location)
                            <div class="resource-spec">
                                <span class="resource-spec-label"><i class='bx bx-map'></i> Localisation</span>
                                <span class="resource-spec-value">{{ $resource->location }}</span>
                            </div>
                        @endif

                        @if($resource->capacity)
                            <div class="resource-spec">
                                <span class="resource-spec-label"><i class='bx bx-hdd'></i> Capacité</span>
                                <span class="resource-spec-value">{{ $resource->capacity }}</span>
                            </div>
                        @endif

                        <div style="margin-top: 15px;">
                            <span class="status-badge status-{{ $resource->status == 'available' ? 'available' : ($resource->status == 'maintenance' ? 'maintenance' : 'inactive') }}">
                                {{ ucfirst($resource->status) }}
                            </span>
                        </div>

                        <div class="resource-actions">
                            <a href="{{ route('account-request.create') }}" class="btn btn-small btn-success">
                                <i class='bx bx-plus'></i> Demander un compte
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class='bx bx-inbox'></i>
            <p>Aucune ressource trouvée selon vos critères de filtrage.</p>
            <a href="{{ route('guest.resources') }}" class="btn btn-primary" style="margin-top: 15px;">
                <i class='bx bx-reset'></i> Réinitialiser les filtres
            </a>
        </div>
    @endif

    {{-- RÈGLES D'UTILISATION --}}
    <div class="rules-section">
        <h2><i class='bx bx-list-check'></i> Règles d'Utilisation des Ressources</h2>
        <ul class="rules-list">
            <li>
                <i class='bx bx-check-circle'></i>
                <div>
                    <strong>Demande Écrite :</strong> Toute utilisation doit faire l'objet d'une demande de réservation préalable avec justification.
                </div>
            </li>
            <li>
                <i class='bx bx-check-circle'></i>
                <div>
                    <strong>Priorité :</strong> Les ressources sont allouées selon le principe du "premier arrivé, premier servi", sauf priorité spéciale.
                </div>
            </li>
            <li>
                <i class='bx bx-check-circle'></i>
                <div>
                    <strong>Durée :</strong> Les réservations sont limitées à une durée maximale de 30 jours consécutifs.
                </div>
            </li>
            <li>
                <i class='bx bx-check-circle'></i>
                <div>
                    <strong>Entretien :</strong> Les ressources sont périodiquement placées en maintenance pour mise à jour et entretien.
                </div>
            </li>
            <li>
                <i class='bx bx-check-circle'></i>
                <div>
                    <strong>Responsabilité :</strong> L'utilisateur est responsable de l'utilisation appropriée des ressources allouées.
                </div>
            </li>
            <li>
                <i class='bx bx-check-circle'></i>
                <div>
                    <strong>Signalement :</strong> Tout problème technique doit être signalé rapidement via la plateforme.
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
