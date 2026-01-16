
<style>
    
    :root {
        --bg-body: #020617;
        --bg-card: #0f172a;
        --color-primary: #38bdf8;
        --color-success: #10b981;
        --color-danger: #ef4444;
        --color-warning: #f59e0b;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border-color: rgba(255, 255, 255, 0.1);
        --transition: all 0.3s ease;
    }

    .admin-container {
        background-color: var(--bg-body);
        color: var(--text-main);
        min-height: 100vh;
        padding: 40px 20px;
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

  
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .header-flex h1 {
        font-size: 1.8rem;
        color: var(--color-primary);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-logout {
        background: rgba(239, 68, 68, 0.15);
        color: var(--color-danger);
        border: 1px solid var(--color-danger);
        padding: 10px 20px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        text-decoration: none;
    }

    .btn-logout:hover {
        background: var(--color-danger);
        color: white;
    }

  
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--bg-card);
        padding: 25px;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        transition: var(--transition);
    }

    .stat-card:hover {
        border-color: var(--color-primary);
        transform: translateY(-5px);
    }

    .stat-card h3 {
        font-size: 2rem;
        margin-bottom: 5px;
    }

    .stat-card p {
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.9rem;
    }

    
    .section-card {
        background: var(--bg-card);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        padding: 30px;
        margin-bottom: 30px;
        overflow-x: auto;
    }

    .section-card h2 {
        font-size: 1.2rem;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--color-primary);
    }

    .pure-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .pure-table th {
        padding: 15px;
        color: var(--text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border-color);
    }

    .pure-table td {
        padding: 20px 15px;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.9rem;
    }

   
    .pure-select {
        background: var(--bg-body);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .badge-success { background: rgba(16, 185, 129, 0.15); color: var(--color-success); }
    .badge-danger { background: rgba(239, 68, 68, 0.15); color: var(--color-danger); }

    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .btn-primary { background: var(--color-primary); color: #000; }
    .btn-warning { background: var(--color-warning); color: #000; }

</style>

<div class="admin-container">
    <div class="header-flex">
        <h1><i class='bx bxs-dashboard'></i> Panel Admin IT</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class='bx bx-log-out-circle'></i> Déconnexion
            </button>
        </form>
    </div>

    <div class="stats-grid">
        <div class="stat-card" style="border-top: 4px solid var(--color-primary);">
            <h3>{{ $stats['total_users'] }}</h3>
            <p>Utilisateurs</p>
        </div>
        <div class="stat-card" style="border-top: 4px solid var(--color-success);">
            <h3>{{ $stats['total_resources'] }}</h3>
            <p>Ressources IT</p>
        </div>
        <div class="stat-card" style="border-top: 4px solid var(--color-warning);">
            <h3>{{ $stats['occupied_rate'] }}%</h3>
            <p>Utilisation</p>
        </div>
        <div class="stat-card" style="border-top: 4px solid var(--color-danger);">
            <h3>{{ $stats['maintenance_count'] }}</h3>
            <p>Maintenance</p>
        </div>
    </div>

    <div class="section-card">
        <h2><i class='bx bxs-user-detail'></i> Utilisateurs & Permissions</h2>
        <table class="pure-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="font-weight: 700;">{{ $user->name }}</div>
                        <div style="color: var(--text-muted); font-size: 0.75rem;">{{ $user->email }}</div>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.role', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="role_id" onchange="this.form.submit()" class="pure-select">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td>
                        <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($user->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-action" style="background: {{ $user->status === 'active' ? 'rgba(239, 68, 68, 0.2)' : 'rgba(16, 185, 129, 0.2)' }}; color: {{ $user->status === 'active' ? 'var(--color-danger)' : 'var(--color-success)' }}; border: 1px solid currentColor;">
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
        <h2><i class='bx bxs-wrench'></i> Catalogue & Maintenance</h2>
        <table class="pure-table">
            <thead>
                <tr>
                    <th>Équipement</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                <tr>
                    <td style="font-weight: 700;">{{ $resource->name }}</td>
                    <td>
                        <span style="color: {{ $resource->status === 'maintenance' ? 'var(--color-warning)' : 'var(--color-success)' }}">
                            ● {{ strtoupper($resource->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.resources.maintenance', $resource->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-action btn-warning">
                                <i class='bx bx-cog'></i> {{ $resource->status === 'maintenance' ? 'Remettre en ligne' : 'Maintenance' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
