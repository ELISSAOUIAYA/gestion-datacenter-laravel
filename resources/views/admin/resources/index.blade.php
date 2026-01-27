@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0; color: #1a1a1a; display: flex; align-items: center; gap: 1rem;">
                <i class='bx bxs-server' style="font-size: 2rem; color: var(--primary);"></i>
                Gestion des Ressources
            </h1>
            <a href="{{ route('admin.dashboard') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                ← Retour
            </a>
        </div>

        <!-- Filtres -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}" 
                    style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                
                <select name="category" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>

                <select name="active" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                    <option value="">Tous</option>
                    <option value="active" {{ request('active') === 'active' ? 'selected' : '' }}>Actives</option>
                    <option value="inactive" {{ request('active') === 'inactive' ? 'selected' : '' }}>Inactives</option>
                </select>

                <button type="submit" style="background: #3498db; color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; padding: 0.75rem;">
                    <i class='bx bx-search'></i> Filtrer
                </button>
            </form>
        </div>

        <!-- Tableau -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #ecf0f1;">
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Nom</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Catégorie</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Manager</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Status</th>
                        <th style="padding: 1rem; text-align: center; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($resources as $resource)
                    <tr style="border-bottom: 1px solid #ecf0f1;">
                        <td style="padding: 1rem; color: #333;">
                            <strong>{{ $resource->name }}</strong>
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $resource->category->name ?? 'N/A' }}
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $resource->techManager->name ?? 'Non assigné' }}
                        </td>
                        <td style="padding: 1rem;">
                            <span style="display: inline-block; background: {{ $resource->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $resource->is_active ? '#155724' : '#721c24' }}; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                {{ $resource->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('admin.resources.show', $resource) }}" style="display: inline-block; padding: 0.5rem 0.75rem; background: #3498db; color: white; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem; margin: 0 0.25rem;">
                                <i class='bx bx-show'></i> Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">
                            Aucune ressource trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($resources->hasPages())
        <div style="margin-top: 2rem;">
            {{ $resources->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
