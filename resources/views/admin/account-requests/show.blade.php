<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails de la Demande | Admin</title>
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
        .container { max-width: 900px; margin: 0 auto; padding: 0 20px; }
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

        /* --- DETAIL CARD --- */
        .detail-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .detail-row { display: grid; grid-template-columns: 200px 1fr; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid var(--border); }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; }
        .detail-value { color: var(--text-main); }

        /* --- BADGES --- */
        .badge { display: inline-block; padding: 8px 16px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }

        /* --- MOTIVATION BOX --- */
        .motivation-box { background: #f8f9fa; border-left: 4px solid var(--primary); padding: 20px; border-radius: 8px; margin: 20px 0; }
        .motivation-label { font-weight: 600; margin-bottom: 10px; }
        .motivation-text { line-height: 1.8; color: var(--text-main); }

        /* --- ADMIN COMMENT --- */
        .admin-comment { background: #fff3cd; border-left: 4px solid var(--warning); padding: 20px; border-radius: 8px; margin: 20px 0; }
        .admin-comment-label { font-weight: 600; color: #856404; margin-bottom: 10px; }
        .admin-comment-text { color: #856404; line-height: 1.8; }

        /* --- ACTIONS --- */
        .actions { display: flex; gap: 10px; margin-top: 30px; }
        .btn-sm { padding: 10px 20px; font-size: 0.9rem; }

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
    </style>
</head>
<body>
<header class="admin-header">
    <div class="container">
        <div class="header-content">
            <h1 class="header-title"><i class='bx bx-file'></i> Détails de la Demande</h1>
            <div class="header-actions">
                <a href="{{ route('admin.account-requests.index') }}" class="btn btn-primary"><i class='bx bx-arrow-back'></i> Retour</a>
            </div>
        </div>
    </div>
</header>

<main class="container">
    <div class="detail-card">
        <!-- STATUS BADGE -->
        <div style="text-align: center; margin-bottom: 30px;">
            @php
                $statusClass = match($accountRequest->status) {
                    'EN ATTENTE' => 'badge-pending',
                    'APPROUVÉE' => 'badge-approved',
                    'REFUSÉE' => 'badge-rejected',
                    default => 'badge-pending'
                };
            @endphp
            <span class="badge {{ $statusClass }}" style="font-size: 1.1rem; padding: 10px 20px;">
                {{ $accountRequest->status }}
            </span>
        </div>

        <!-- INFORMATIONS DE CONTACT -->
        <h3 style="margin-bottom: 20px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
            <i class='bx bx-user'></i> Informations personnelles
        </h3>

        <div class="detail-row">
            <div class="detail-label"><i class='bx bx-user-circle'></i> Nom complet</div>
            <div class="detail-value"><strong>{{ $accountRequest->name }}</strong></div>
        </div>

        <div class="detail-row">
            <div class="detail-label"><i class='bx bx-envelope'></i> Email</div>
            <div class="detail-value">
                <a href="mailto:{{ $accountRequest->email }}" style="color: var(--primary);">{{ $accountRequest->email }}</a>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label"><i class='bx bx-phone'></i> Téléphone</div>
            <div class="detail-value">{{ $accountRequest->phone ?? '<em style="color: var(--text-muted);">Non renseigné</em>' }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label"><i class='bx bx-badge'></i> Type d'utilisateur</div>
            <div class="detail-value">
                <span style="display: inline-block; padding: 4px 8px; background: #e3f2fd; color: #1976d2; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">
                    {{ $accountRequest->user_type }}
                </span>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label"><i class='bx bx-calendar'></i> Date de demande</div>
            <div class="detail-value">{{ $accountRequest->created_at->format('d/m/Y à H:i') }}</div>
        </div>

        <!-- MOTIVATION -->
        <h3 style="margin: 30px 0 20px; border-bottom: 2px solid var(--primary); padding-bottom: 10px;">
            <i class='bx bx-comment-detail'></i> Motivation
        </h3>

        <div class="motivation-box">
            <div class="motivation-text">
                {{ $accountRequest->motivation ?? '<em style="color: var(--text-muted);">Aucune motivation fournie</em>' }}
            </div>
        </div>

        <!-- ADMIN COMMENT (if exists) -->
        @if($accountRequest->admin_comment)
            <h3 style="margin: 30px 0 20px; border-bottom: 2px solid var(--warning); padding-bottom: 10px;">
                <i class='bx bx-comment'></i> Commentaire de l'administrateur
            </h3>

            <div class="admin-comment">
                <div class="admin-comment-text">
                    {{ $accountRequest->admin_comment }}
                </div>
            </div>
        @endif

        <!-- ACTIONS -->
        @if($accountRequest->status === 'EN ATTENTE')
            <div class="actions">
                <form action="{{ route('admin.account-requests.approve', $accountRequest) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Confirmer l\'approbation ?')">
                        <i class='bx bx-check-circle'></i> Approuver cette demande
                    </button>
                </form>

                <button type="button" class="btn btn-danger btn-sm" onclick="openRejectModal()">
                    <i class='bx bx-x-circle'></i> Refuser cette demande
                </button>
            </div>
        @elseif($accountRequest->status === 'APPROUVÉE')
            <div style="background: #d4edda; border-left: 4px solid var(--success); padding: 20px; border-radius: 8px; margin-top: 30px;">
                <p style="color: #155724; margin: 0;">
                    <i class='bx bx-check-circle'></i> <strong>Cette demande a été approuvée.</strong> Un compte utilisateur a été créé pour {{ $accountRequest->name }}.
                </p>
            </div>
        @elseif($accountRequest->status === 'REFUSÉE')
            <div style="background: #f8d7da; border-left: 4px solid var(--danger); padding: 20px; border-radius: 8px; margin-top: 30px;">
                <p style="color: #721c24; margin: 0;">
                    <i class='bx bx-x-circle'></i> <strong>Cette demande a été refusée.</strong>
                </p>
            </div>
        @endif
    </div>
</main>

<!-- REJECT MODAL -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">Refuser la demande</div>
        <form id="rejectForm" action="{{ route('admin.account-requests.reject', $accountRequest) }}" method="POST">
            @csrf
            <div class="modal-body">
                <p>Vous êtes sur le point de refuser la demande de <strong>{{ $accountRequest->name }}</strong>.</p>
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
    function openRejectModal() {
        document.getElementById('rejectModal').classList.add('show');
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
