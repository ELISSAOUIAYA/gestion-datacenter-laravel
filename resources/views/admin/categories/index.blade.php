@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0; color: #1a1a1a;">Catégories de Ressources</h1>
            <a href="{{ route('admin.categories.create') }}" style="background: #2ecc71; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                + Nouvelle Catégorie
            </a>
        </div>

        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #ecf0f1;">
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600;">Nom</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600;">Ressources</th>
                        <th style="padding: 1rem; text-align: center; color: #666; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                    <tr style="border-bottom: 1px solid #ecf0f1;">
                        <td style="padding: 1rem; color: #333;">
                            <strong>{{ $cat->name }}</strong>
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $cat->resources_count }} ressources
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('admin.categories.edit', $cat) }}" style="display: inline-block; padding: 0.5rem 0.75rem; background: #3498db; color: white; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem; margin: 0 0.25rem;">
                                Éditer
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" style="display: inline-block; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 0.5rem 0.75rem; background: #e74c3c; color: white; border-radius: 4px; border: none; font-weight: 600; font-size: 0.85rem; margin: 0 0.25rem; cursor: pointer;" onclick="return confirm('Confirmer la suppression?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 2rem; text-align: center; color: #999;">
                            Aucune catégorie
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div style="margin-top: 2rem;">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
