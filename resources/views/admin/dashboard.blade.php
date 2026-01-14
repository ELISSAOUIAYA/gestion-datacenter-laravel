@extends('layouts.app')

@section('content')
<style>
    .admin-body { background: #f0f2f5; padding: 20px; font-family: sans-serif; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: white; padding: 15px; border-radius: 8px; border-left: 5px solid #3498db; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .section-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .table { width: 100%; border-collapse: collapse; }
    .table th { background: #f8f9fa; padding: 12px; text-align: left; font-size: 13px; color: #666; }
    .table td { padding: 12px; border-top: 1px solid #eee; vertical-align: middle; }
    .btn-toggle { padding: 5px 10px; border-radius: 4px; border: none; cursor: pointer; color: white; font-size: 11px; }
    .btn-logout {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    font-size: 13px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-logout:hover {
    background-color: #c0392b;
}
</style>


<form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn-logout">
        <i class='bx bx-log-out'></i> Déconnexion
    </button>
</form>


<div class="admin-body">
    <h1><i class='bx bxs-shield-quarter'></i> Administration Globale</h1>

    <div class="stats-grid">
        <div class="stat-card"><h3>{{ $stats['total_users'] }}</h3><p>Utilisateurs</p></div>
        <div class="stat-card" style="border-color: #2ecc71;"><h3>{{ $stats['total_resources'] }}</h3><p>Catalogue IT</p></div>
        <div class="stat-card" style="border-color: #f1c40f;"><h3>{{ $stats['occupied_rate'] }}%</h3><p>Taux d'occupation</p></div>
        <div class="stat-card" style="border-color: #e74c3c;"><h3>{{ $stats['maintenance_count'] }}</h3><p>En Maintenance</p></div>
    </div>

    <div class="section-card">
        <h3>Gestion des Comptes & Permissions</h3>
        <table class="table">
            <thead><tr><th>Utilisateur</th><th>Email</th><th>Rôle Actuel</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="role_id" onchange="this.form.submit()" style="padding: 5px; border-radius: 4px;">
                                <option value="">-- Assigner rôle --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <span style="color: {{ $user->status === 'active' ? 'green' : 'red' }}; font-weight: bold;">{{ ucfirst($user->status) }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-toggle" style="background: {{ $user->status === 'active' ? '#e74c3c' : '#27ae60' }}">
                                {{ $user->status === 'active' ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-card">
        <h3>Maintenance & Catalogue des Ressources</h3>
        <table class="table">
            <thead><tr><th>Équipement</th><th>Catégorie</th><th>État</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($resources as $resource)
                <tr>
                    <td>{{ $resource->name }}</td>
                    <td>{{ $resource->category->name ?? 'N/A' }}</td>
                    <td><strong>{{ strtoupper($resource->status) }}</strong></td>
                    <td>
                        <form action="{{ route('admin.resources.maintenance', $resource->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-toggle" style="background: #f39c12;">
                                {{ $resource->status === 'maintenance' ? 'Remettre en ligne' : 'Planifier Maintenance' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection