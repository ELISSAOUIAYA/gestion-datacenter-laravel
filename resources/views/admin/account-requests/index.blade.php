<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Demandes de Compte | Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        :root {
            --primary: #007bff;
            --primary-dark: #0056b3;
            --bg-body: #f4f7f6;
            --bg-card: #ffffff;
            --text-main: #333;
            --text-muted: #777;
            --border: #eeeeee;
            --dark: #1a1d20;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Arial, sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); line-height: 1.6; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        a { text-decoration: none; color: inherit; }

        /* --- HEADER --- */
        .admin-header { background: var(--dark); color: white; padding: 20px 0; margin-bottom: 30px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .header-title { font-size: 1.8rem; font-weight: 700; }
        .header-actions { display: flex; gap: 15px; }
        .btn { display: inline-block; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s ease; text-align: center; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { background: #218838; }

        /* --- STATS CARDS --- */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; border-left: 4px solid var(--primary); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .stat-card.pending { border-left-color: var(--warning); }
        .stat-card.approved { border-left-color: var(--success); }
        .stat-card.rejected { border-left-color: var(--danger); }
        .stat-value { font-size: 2.5rem; font-weight: 700; color: var(--primary); }
        .stat-label { font-size: 0.9rem; color: var(--text-muted); margin-top: 5px; }

        /* --- FILTERS --- */
        .filter-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .filter-group { display: flex; gap: 15px; align-items: center; flex-wrap: wrap; }
        .filter-input { padding: 10px 15px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9rem; }
        .filter-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 5px rgba(0,123,255,0.3); }

        /* --- TABLE --- */
        .table-wrapper { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #f8f9fa; border-bottom: 2px solid var(--border); }
        th { padding: 15px; text-align: left; font-weight: 600; color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid var(--border); }
        tr:hover { background: #f8f9fa; }

        /* --- STATUS BADGES --- */
        .badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }

        /* --- ACTIONS --- */
        .action-buttons { display: flex; gap: 8px; }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
        .btn-view { background: var(--primary); color: white; }
        .btn-view:hover { background: var(--primary-dark); }
        .btn-approve { background: var(--success); color: white; }
        .btn-approve:hover { background: #218838; }
        .btn-reject { background: var(--danger); color: white; }
        .btn-reject:hover { background: #c82333; }

        /* --- EMPTY STATE --- */
        .empty-state { padding: 60px 20px; text-align: center; color: var(--text-muted); }
        .empty-state i { font-size: 4rem; color: #ddd; margin-bottom: 20px; }
        .empty-state p { font-size: 1.1rem; }

        /* --- MODAL --- */
        .modal { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 3000; align-items: center; justify-content: center; }
        .modal.show { display: flex; }
        .modal-content { background: white; border-radius: 10px; padding: 30px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .modal-header { font-size: 1.3rem; font-weight: 700; margin-bottom: 20px; }
        .modal-body { margin-bottom: 20px; }
        .modal-body p { margin-bottom: 15px; line-height: 1.7; }
        .modal-footer { display: flex; gap: 10px; justify-content: flex-end; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 5px; }
        .form-group textarea { width: 100%; padding: 10px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; resize: vertical; min-height: 100px; }
        .form-group textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 5px rgba(0,123,255,0.3); }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: 1fr; }
            .filter-group { flex-direction: column; align-items: stretch; }
            .filter-input { width: 100%; }
            table { font-size: 0.85rem; }
            th, td { padding: 10px; }
            .action-buttons { flex-direction: column; }
            .btn-sm { width: 100%; }
        }
    </style>
</head>
<body>
<header class="admin-header">
    <div class="container">
        <div class="header-content">
            <h1 class="header-title"><i class='bx bxs-user-check'></i> Gestion des Demandes de Compte</h1>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary"><i class='bx bx-arrow-back'></i> Retour</a>
            </div>
        </div>
    </div>
</header>

<main class="container">
    <!-- STATISTICS -->
    <div class="stats-grid">
        <div class="stat-card pending">
            <div class="stat-value">{{ $pending }}</div>
            <div class="stat-label">En attente</div>
        </div>
        <div class="stat-card approved">
            <div class="stat-value">{{ $approved }}</div>
            <div class="stat-label">Approuvées</div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-value">{{ $rejected }}</div>
            <div class="stat-label">Refusées</div>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="filter-section">
        <div class="filter-group">
            <form method="GET" action="{{ route('admin.account-requests.index') }}" style="display: flex; gap: 15px; width: 100%; flex-wrap: wrap; align-items: center;">
                <input type="text" name="search" placeholder="Chercher par nom ou email..." class="filter-input" value="{{ request('search') }}" style="flex: 1; min-width: 200px;">
                
                <select name="status" class="filter-input">
                    <option value="">-- Tous les statuts --</option>
                    <option value="EN ATTENTE" {{ request('status') === 'EN ATTENTE' ? 'selected' : '' }}>En attente</option>
                    <option value="APPROUVÉE" {{ request('status') === 'APPROUVÉE' ? 'selected' : '' }}>Approuvée</option>
                    <option value="REFUSÉE" {{ request('status') === 'REFUSÉE' ? 'selected' : '' }}>Refusée</option>
                </select>

                <select name="user_type" class="filter-input">
                    <option value="">-- Tous les types --</option>
                    <option value="Ingénieur" {{ request('user_type') === 'Ingénieur' ? 'selected' : '' }}>Ingénieur</option>
                    <option value="Enseignant" {{ request('user_type') === 'Enseignant' ? 'selected' : '' }}>Enseignant</option>
                    <option value="Doctorant" {{ request('user_type') === 'Doctorant' ? 'selected' : '' }}>Doctorant</option>
                    <option value="Autre" {{ request('user_type') === 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>

                <button type="submit" class="btn btn-primary"><i class='bx bx-search'></i> Filtrer</button>
                <a href="{{ route('admin.account-requests.index') }}" class="btn btn-primary" style="background: #6c757d;"><i class='bx bx-reset'></i> Réinitialiser</a>
            </form>
        </div>
    </div>

    <!-- REQUESTS TABLE -->
    <div class="table-wrapper">
        @if($accountRequests->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accountRequests as $request)
                        <tr>
                            <td><strong>{{ $request->name }}</strong></td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->phone ?? '-' }}</td>
                            <td>
                                <span style="display: inline-block; padding: 4px 8px; background: #e3f2fd; color: #1976d2; border-radius: 4px; font-size: 0.8rem;">
                                    {{ $request->user_type }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($request->status) {
                                        'EN ATTENTE' => 'badge-pending',
                                        'APPROUVÉE' => 'badge-approved',
                                        'REFUSÉE' => 'badge-rejected',
                                        default => 'badge-pending'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $request->status }}</span>
                            </td>
                            <td style="font-size: 0.85rem; color: var(--text-muted);">
                                {{ $request->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.account-requests.show', $request) }}" class="btn btn-sm btn-view"><i class='bx bx-show'></i> Voir</a>
                                    @if($request->status === 'EN ATTENTE')
                                        <form action="{{ route('admin.account-requests.approve', $request) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-approve" onclick="return confirm('Confirmer l\'approbation ?')"><i class='bx bx-check'></i> Approuver</button>
                                        </form>
                                        <button class="btn btn-sm btn-reject" onclick="openRejectModal({{ $request->id }}, '{{ $request->name }}')"><i class='bx bx-x'></i> Refuser</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div style="padding: 20px; text-align: center;">
                {{ $accountRequests->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class='bx bx-inbox'></i>
                <p>Aucune demande trouvée avec ces critères</p>
            </div>
        @endif
    </div>
</main>

<!-- REJECT MODAL -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Refuser la demande</div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <p id="requestName"></p>
                <div class="form-group">
                    <label for="admin_comment">Motif du refus <span style="color: var(--danger);">*</span></label>
                    <textarea id="admin_comment" name="admin_comment" required placeholder="Expliquez pourquoi cette demande est refusée..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="background: #6c757d;" onclick="closeRejectModal()">Annuler</button>
                <button type="submit" class="btn btn-danger">Refuser</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(requestId, requestName) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        const nameEl = document.getElementById('requestName');

        nameEl.textContent = `Demande de ${requestName}`;
        form.action = `/admin/account-requests/${requestId}/reject`;
        modal.classList.add('show');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('show');
    }

    window.addEventListener('click', (e) => {
        const modal = document.getElementById('rejectModal');
        if (e.target === modal) {
            closeRejectModal();
        }
    });
</script>
</body>
</html>
