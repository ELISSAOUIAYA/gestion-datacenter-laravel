@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0; color: #1a1a1a; display: flex; align-items: center; gap: 1rem;">
                <i class='bx bxs-user-badge' style="font-size: 2rem; color: var(--primary);"></i>
                Gestion des Utilisateurs
            </h1>
            <a href="{{ route('admin.dashboard') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                ← Retour
            </a>
        </div>

        <!-- Filtres -->
        <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <input type="text" name="search" placeholder="Rechercher par nom ou email..." value="{{ request('search') }}" 
                    style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                
                <select name="role" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                    <option value="">Tous les rôles</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>

                <select name="status" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;">
                    <option value="">Tous les status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
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
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Email</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Rôle</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Status</th>
                        <th style="padding: 1rem; text-align: center; color: #666; font-weight: 600; font-size: 0.9rem; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="border-bottom: 1px solid #ecf0f1; transition: background 0.2s;">
                        <td style="padding: 1rem; color: #333;">
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $user->email }}
                        </td>
                        <td style="padding: 1rem;">
                            <span style="display: inline-block; background: #e8f4f8; color: #3498db; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                {{ $user->role->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="display: inline-block; background: {{ $user->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $user->is_active ? '#155724' : '#721c24' }}; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('admin.users.show', $user) }}" style="display: inline-block; padding: 0.5rem 0.75rem; background: #3498db; color: white; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem; margin: 0 0.25rem;">
                                <i class='bx bx-show'></i> Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">
                            Aucun utilisateur trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div style="margin-top: 2rem;">
            {{ $users->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
