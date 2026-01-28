@extends('layouts.app')

@section('content')
<style>
    /* --- THÈME DATACENTER PRO --- */
    :root {
        --primary: #38bdf8;
        --bg-body: #020617;
        --bg-card: #0f172a;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --success: #22c55e;
        --danger: #ef4444;
        --warning: #f59e0b;
        --stats-purple: #a855f7;
    }

    .admin-body { 
        background-color: var(--bg-body); 
        color: var(--text-main); 
        padding: 40px 20px; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        position: relative; 
        min-height: 100vh;
    }

    /* --- NAVIGATION (Boutons Arrondis Pill) --- */
    .header-actions {
        position: absolute;
        top: 40px;
        right: 20px;
        display: flex;
        gap: 12px;
        z-index: 1000;
    }

    .btn-nav {
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        text-transform: uppercase;
        border: none;
    }
    .btn-back { background-color: var(--primary); color: #020617; }
    .btn-back:hover { background-color: white; transform: translateY(-2px); }

    /* --- STATS --- */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .stat-card { 
        background: var(--bg-card); padding: 25px; border-radius: 16px; 
        border: 1px solid var(--border); border-left: 4px solid var(--primary); 
    }
    .stat-card.pending { border-left-color: var(--warning); }
    .stat-card.approved { border-left-color: var(--success); }
    .stat-card.rejected { border-left-color: var(--danger); }
    .stat-value { font-size: 2.2rem; font-weight: 800; color: var(--text-main); }
    .stat-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; margin-top: 5px; }

    /* --- FILTRES (Correction Invisibilité) --- */
    .section-card { background: var(--bg-card); padding: 30px; border-radius: 20px; margin-bottom: 30px; border: 1px solid var(--border); }
    .filter-input {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--border);
        padding: 12px 15px;
        border-radius: 12px;
        color: white;
        outline: none;
    }
    .filter-input option { background-color: #0f172a; color: white; }

    /* --- TABLEAU --- */
    .table-wrapper { background: var(--bg-card); border-radius: 24px; border: 1px solid var(--border); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: rgba(255, 255, 255, 0.02); padding: 18px; text-align: left; color: var(--text-muted); font-size: 0.7rem; text-transform: uppercase; border-bottom: 1px solid var(--border); }
    td { padding: 20px 18px; border-bottom: 1px solid var(--border); font-size: 0.9rem; }
    tr:hover { background: rgba(56, 189, 248, 0.02); }

    /* --- BADGES --- */
    .badge { padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
    .badge-pending { background: rgba(245, 158, 11, 0.1); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2); }
    .badge-approved { background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2); }
    .badge-rejected { background: rgba(239, 68, 68, 0.1); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.2); }

    .btn-action { background: var(--primary); color: #020617; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 0.75rem; border: none; cursor: pointer; transition: 0.3s; }
    .btn-action:hover { background: white; transform: scale(1.05); }

    /* --- MODAL --- */
    .modal { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 3000; align-items: center; justify-content: center; }
    .modal.show { display: flex; }
    .modal-content { background: var(--bg-card); border: 1px solid var(--border); border-radius: 24px; padding: 35px; max-width: 500px; width: 90%; }
    textarea { width: 100%; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border); color: white; padding: 15px; border-radius: 12px; margin-top: 10px; min-height: 120px; }

    .sidebar, .left-sidebar, .datacenter-info { display: none !important; }
</style>

<div class="admin-body">
    <div class="header-actions">
        <a href="{{ route('admin.dashboard') }}" class="btn-nav btn-back"><i class='bx bx-arrow-back'></i> Retour</a>
    </div>

    <h1><i class='bx bxs-user-check'></i> Gestion des <span>Demandes</span></h1>

    <div class="stats-grid">
        <div class="stat-card pending"><div class="stat-value">{{ $pending }}</div><div class="stat-label">En attente</div></div>
        <div class="stat-card approved"><div class="stat-value">{{ $approved }}</div><div class="stat-label">Approuvées</div></div>
        <div class="stat-card rejected"><div class="stat-value">{{ $rejected }}</div><div class="stat-label">Refusées</div></div>
    </div>

    <div class="section-card">
        <form method="GET" action="{{ route('admin.account-requests.index') }}" style="display: flex; gap: 15px; flex-wrap: wrap;">
            <input type="text" name="search" placeholder="Nom ou email..." class="filter-input" value="{{ request('search') }}" style="flex: 1;">
            <select name="status" class="filter-input">
                <option value="">Tous les statuts</option>
                <option value="EN ATTENTE" {{ request('status') === 'EN ATTENTE' ? 'selected' : '' }}>En attente</option>
                <option value="APPROUVÉE" {{ request('status') === 'APPROUVÉE' ? 'selected' : '' }}>Approuvée</option>
                <option value="REFUSÉE" {{ request('status') === 'REFUSÉE' ? 'selected' : '' }}>Refusée</option>
            </select>
            <select name="user_type" class="filter-input">
                <option value="">Tous les types</option>
                <option value="Ingénieur" {{ request('user_type') === 'Ingénieur' ? 'selected' : '' }}>Ingénieur</option>
                <option value="Enseignant" {{ request('user_type') === 'Enseignant' ? 'selected' : '' }}>Enseignant</option>
                <option value="Doctorant" {{ request('user_type') === 'Doctorant' ? 'selected' : '' }}>Doctorant</option>
            </select>
            <button type="submit" class="btn-action">Filtrer</button>
            <a href="{{ route('admin.account-requests.index') }}" class="btn-nav" style="background: #334155; color: white;">Reset</a>
        </form>
    </div>

    <div class="table-wrapper">
        @if($accountRequests->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>Candidat / Email</th>
                        <th>Téléphone</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accountRequests as $request)
                        <tr>
                            <td>
                                <strong style="color: var(--primary);">{{ $request->name }}</strong><br>
                                <small style="color: var(--text-muted);">{{ $request->email }}</small>
                            </td>
                            <td style="font-family: monospace;">{{ $request->phone ?? '-- -- --' }}</td>
                            <td><span style="background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">{{ $request->user_type }}</span></td>
                            <td>
                                <span class="badge {{ $request->status === 'EN ATTENTE' ? 'badge-pending' : ($request->status === 'APPROUVÉE' ? 'badge-approved' : 'badge-rejected') }}">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->created_at->format('d/m/Y') }}</td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <a href="{{ route('admin.account-requests.show', $request) }}" class="btn-action" style="background: #334155; color: white;"><i class='bx bx-show'></i></a>
                                    @if($request->status === 'EN ATTENTE')
                                        <form action="{{ route('admin.account-requests.approve', $request) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-action" style="background: var(--success); color: #020617;"><i class='bx bx-check'></i></button>
                                        </form>
                                        <button class="btn-action" style="background: var(--danger); color: white;" onclick="openRejectModal({{ $request->id }}, '{{ $request->name }}')"><i class='bx bx-x'></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: 20px;">{{ $accountRequests->links() }}</div>
        @else
            <div style="padding: 80px; text-align: center; color: var(--text-muted);"><i class='bx bx-mail-send' style="font-size: 4rem; opacity: 0.1; display: block; margin-bottom: 20px;"></i><p>Aucune demande trouvée.</p></div>
        @endif
    </div>
</div>

<div id="rejectModal" class="modal">
    <div class="modal-content">
        <h2 style="font-weight: 800; margin-bottom: 10px;">Refuser la demande</h2>
        <p id="requestName" style="color: var(--primary); font-weight: 700; margin-bottom: 20px;"></p>
        <form id="rejectForm" method="POST">
            @csrf
            <label style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800;">Motif du refus *</label>
            <textarea name="admin_comment" required placeholder="Expliquez la raison au candidat..."></textarea>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 25px;">
                <button type="button" class="btn-nav" onclick="closeRejectModal()" style="background: #334155; color: white;">Annuler</button>
                <button type="submit" class="btn-nav" style="background: var(--danger); color: white;">Confirmer le refus</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(id, name) {
        document.getElementById('requestName').innerText = `Candidat : ${name}`;
        document.getElementById('rejectForm').action = `/admin/account-requests/${id}/reject`;
        document.getElementById('rejectModal').classList.add('show');
    }
    function closeRejectModal() { document.getElementById('rejectModal').classList.remove('show'); }
    window.onclick = function(event) { if (event.target == document.getElementById('rejectModal')) closeRejectModal(); }
</script>
@endsection