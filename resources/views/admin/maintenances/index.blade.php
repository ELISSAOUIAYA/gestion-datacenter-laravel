@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0; color: #1a1a1a;">Maintenances Planifiées</h1>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.dashboard') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                    ← Retour au Dashboard
                </a>
                <a href="{{ route('admin.maintenances.create') }}" style="background: #2ecc71; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                    + Planifier une Maintenance
                </a>
            </div>
        </div>

        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #ecf0f1;">
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600;">Ressource</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600;">Début</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600;">Fin</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600;">Description</th>
                        <th style="padding: 1rem; text-align: center; color: #666; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $maintenance)
                    <tr style="border-bottom: 1px solid #ecf0f1;">
                        <td style="padding: 1rem; color: #333;">
                            <strong>{{ $maintenance->resource->name ?? 'N/A' }}</strong>
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $maintenance->start_date->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $maintenance->end_date->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $maintenance->description ?? '-' }}
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('admin.maintenances.edit', $maintenance) }}" style="display: inline-block; padding: 0.5rem 0.75rem; background: #3498db; color: white; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem; margin: 0 0.25rem;">
                                Éditer
                            </a>
                            <form method="POST" action="{{ route('admin.maintenances.destroy', $maintenance) }}" style="display: inline-block; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 0.5rem 0.75rem; background: #e74c3c; color: white; border-radius: 4px; border: none; font-weight: 600; font-size: 0.85rem; margin: 0 0.25rem; cursor: pointer;" onclick="return confirm('Confirmer?')">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">
                            Aucune maintenance planifiée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($maintenances->hasPages())
        <div style="margin-top: 2rem;">
            {{ $maintenances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
