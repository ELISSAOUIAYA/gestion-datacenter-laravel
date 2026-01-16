<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

    :root {
        --bg: #020617;
        --card-bg: rgba(15, 23, 42, 0.8);
        --primary: #38bdf8;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
        --danger: #fb7185;
    }

    body { 
        background-color: var(--bg); 
        color: var(--text-main);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .incident-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 20px;
    }

    .incident-card { 
        width: 100%;
        max-width: 550px; 
        background: var(--card-bg); 
        padding: 35px; 
        border-radius: 24px; 
        border: 1px solid var(--border);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    
    .incident-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--danger), transparent);
    }

    .header-icon {
        background: rgba(251, 113, 133, 0.1);
        color: var(--danger);
        width: 50px; height: 50px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 10px; }
    .resource-name { color: var(--primary); font-weight: 700; }

    .form-group { margin: 25px 0; }
    label { display: block; font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; color: var(--text-muted); }

    textarea { 
        width: 100%; 
        padding: 15px; 
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--border); 
        border-radius: 12px; 
        color: white;
        font-family: inherit;
        resize: vertical;
        transition: 0.3s;
    }

    textarea:focus {
        outline: none;
        border-color: var(--danger);
        box-shadow: 0 0 10px rgba(251, 113, 133, 0.1);
    }

    .btn-send { 
        background: var(--danger); 
        color: white; 
        border: none; 
        padding: 14px; 
        border-radius: 12px; 
        cursor: pointer; 
        width: 100%; 
        font-weight: 800; 
        font-size: 0.9rem;
        transition: 0.3s;
        display: flex; align-items: center; justify-content: center; gap: 10px;
    }

    .btn-send:hover { 
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(251, 113, 133, 0.2);
        filter: brightness(1.1);
    }

    .btn-back {
        display: inline-block;
        margin-top: 20px;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-back:hover { color: white; }
</style>

<div class="incident-container">
    <div class="incident-card">
        <div class="header-icon">
            <i class='bx bxs-error-alt'></i>
        </div>

        <h2>Signaler un problème</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            Ressource : <span class="resource-name">{{ $resource->name }}</span>
        </p>

        <form action="{{ route('incidents.store') }}" method="POST">
            @csrf
            <input type="hidden" name="resource_id" value="{{ $resource->id }}">
            
            <div class="form-group">
                <label for="description">Description technique du problème</label>
                <textarea 
                    id="description"
                    name="description" 
                    rows="6" 
                    required 
                    placeholder="Détaillez la panne (ex: Serveur inaccessible, écran noir, erreur 500...)"
                ></textarea>
            </div>

            <button type="submit" class="btn-send">
                <i class='bx bxs-paper-plane'></i> ENVOYER LE SIGNALEMENT
            </button>
        </form>

        <div style="text-align: center;">
            <a href="{{ route('user.dashboard') }}" class="btn-back">
                <i class='bx bx-arrow-back'></i> Retour au Dashboard
            </a>
        </div>
    </div>
</div>
