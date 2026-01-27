@extends('layouts.app')

@section('content')
<div style="background: #f5f7fa; min-height: 100vh; padding: 2rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="margin: 0; color: #1a1a1a;">
                {{ $user->name }}
            </h1>
            <a href="{{ route('admin.users.index') }}" style="background: #95a5a6; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600;">
                ← Retour
            </a>
        </div>

        <!-- Informations -->
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <h2 style="color: #1a1a1a; margin: 0 0 1.5rem 0;">Informations Générales</h2>
            
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Nom</label>
                        <input type="text" name="name" value="{{ $user->name }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;" required>
                        @error('name') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;" required>
                        @error('email') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Rôle</label>
                        <select name="role_id" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;" required>
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Status</label>
                        <select name="is_active" style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem;" required>
                            <option value="1" {{ $user->is_active ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactif</option>
                        </select>
                        @error('is_active') <small style="color: #e74c3c;">{{ $message }}</small> @enderror
                    </div>
                </div>

                <button type="submit" style="background: #2ecc71; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">
                    <i class='bx bx-save'></i> Enregistrer
                </button>
            </form>
        </div>

        <!-- Réservations -->
        @if($user->reservations->count() > 0)
        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 2rem;">
            <h2 style="color: #1a1a1a; margin: 0 0 1.5rem 0;">Réservations de l'Utilisateur</h2>
            
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #ecf0f1;">
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem;">Ressource</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem;">Période</th>
                        <th style="padding: 1rem; text-align: left; color: #666; font-weight: 600; font-size: 0.9rem;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->reservations as $reservation)
                    <tr style="border-bottom: 1px solid #ecf0f1;">
                        <td style="padding: 1rem; color: #333;">
                            {{ $reservation->resource->name ?? 'N/A' }}
                        </td>
                        <td style="padding: 1rem; color: #666; font-size: 0.9rem;">
                            {{ $reservation->start_date->format('d/m/Y H:i') }} → {{ $reservation->end_date->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 1rem;">
                            <span style="display: inline-block; background: 
                                @switch($reservation->status)
                                    @case('EN ATTENTE') #fff3cd @break
                                    @case('APPROUVÉE') #d4edda @break
                                    @case('REFUSÉE') #f8d7da @break
                                    @default #e8f4f8
                                @endswitch
                            ; color: 
                                @switch($reservation->status)
                                    @case('EN ATTENTE') #856404 @break
                                    @case('APPROUVÉE') #155724 @break
                                    @case('REFUSÉE') #721c24 @break
                                    @default #0c5460
                                @endswitch
                            ; padding: 0.35rem 0.75rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                                {{ $reservation->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div>
@endsection
