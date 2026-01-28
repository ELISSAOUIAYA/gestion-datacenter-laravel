<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        :root {
            --bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.8);
            --primary: #38bdf8;
            --primary-glow: rgba(56, 189, 248, 0.3);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            background-image: radial-gradient(circle at top right, rgba(56, 189, 248, 0.06), transparent);
        }

        .register-box {
            width: 100%;
            max-width: 450px; 
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            padding: 35px; 
            border-radius: 28px;
            border: 1px solid var(--border);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        .header { text-align: center; margin-bottom: 25px; }
        .brand-icon {
            width: 55px; height: 55px; 
            background: var(--primary-glow);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 15px;
            border: 1px solid rgba(56, 189, 248, 0.2);
        }
        .brand-icon i { font-size: 1.8rem; color: var(--primary); filter: drop-shadow(0 0 5px var(--primary)); }

        .header h2 { font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 6px; color: var(--text-main); }
        .header p { color: var(--text-muted); font-size: 0.9rem; }

        .form-group { margin-bottom: 18px; } 
        .form-label { 
            font-size: 0.75rem; font-weight: 700; color: var(--text-muted); 
            margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;
        }

        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper i.main-icon { position: absolute; left: 15px; color: var(--text-muted); font-size: 1.2rem; transition: 0.3s; }

        .form-control {
            width: 100%; padding: 13px 15px 13px 45px;
            background: rgba(0, 0, 0, 0.3); border: 1.5px solid var(--border);
            border-radius: 12px; color: white; font-size: 0.95rem; transition: 0.3s ease;
        }

        select.form-control { appearance: none; cursor: pointer; }

        .form-control:focus { outline: none; border-color: var(--primary); background: rgba(56, 189, 248, 0.05); }
        .form-control:focus + i.main-icon { color: var(--primary); }

        .toggle-btn { position: absolute; right: 15px; cursor: pointer; color: var(--text-muted); font-size: 1.1rem; }

        .strength-container { width: 100%; height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px; margin-top: 10px; overflow: hidden; }
        .strength-bar { height: 100%; width: 0%; transition: 0.5s ease; }

        .btn-submit {
            width: 100%; padding: 15px; background: var(--primary); color: #020617;
            border: none; border-radius: 12px; font-size: 1rem; font-weight: 800;
            cursor: pointer; transition: 0.4s ease; margin-top: 10px;
        }

        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px var(--primary-glow); filter: brightness(1.1); }

        .footer-link { text-align: center; margin-top: 25px; font-size: 0.85rem; color: var(--text-muted); }
        .footer-link a { color: var(--primary); text-decoration: none; font-weight: 700; }
        
        /* Style for Select Option (Dark) */
        option { background: #0f172a; color: white; }
    </style>
</head>
<body>

<div class="register-box">
    <div class="header">
        <div class="brand-icon"><i class='bx bxs-rocket'></i></div>
        <h2>Nouveau Compte</h2>
        <p>Accédez à l'infrastructure Cloud</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Nom complet</label>
            <div class="input-wrapper">
                <input type="text" name="name" class="form-control" placeholder="Ex: Ali Alami" required>
                <i class='bx bx-user main-icon'></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email Professionnel</label>
            <div class="input-wrapper">
                <input type="email" name="email" class="form-control" placeholder="nom@site.com" required>
                <i class='bx bx-envelope main-icon'></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Type d'Utilisateur <span style="text-transform: lowercase; font-weight: 400; opacity: 0.7;">(optionnel)</span></label>
            <div class="input-wrapper">
                <select name="user_type" class="form-control">
                    <option value="" selected>Utilisateur Normal</option>
                    <option value="Ingénieur">Ingénieur</option>
                    <option value="Doctorant">Doctorant</option>
                    <option value="Enseignant">Enseignant</option>
                </select>
                <i class='bx bx-briefcase-alt-2 main-icon'></i>
                <i class='bx bx-chevron-down' style="position: absolute; right: 15px; color: var(--text-muted); pointer-events: none;"></i>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <div class="input-wrapper">
                <input type="password" name="password" id="p1" class="form-control" placeholder="••••••••" required oninput="checkP(this.value)">
                <i class='bx bx-lock-alt main-icon'></i>
                <span class="toggle-btn" onclick="toggle('p1', this)"><i class='bx bx-hide'></i></span>
            </div>
            <div class="strength-container"><div class="strength-bar" id="sb"></div></div>
        </div>

        <div class="form-group">
            <label class="form-label">Confirmation</label>
            <div class="input-wrapper">
                <input type="password" name="password_confirmation" id="p2" class="form-control" placeholder="••••••••" required>
                <i class='bx bx-check-shield main-icon'></i>
                <span class="toggle-btn" onclick="toggle('p2', this)"><i class='bx bx-hide'></i></span>
            </div>
        </div>

        <button type="submit" class="btn-submit">Créer mon compte</button>

        <p class="footer-link">Déjà membre ? <a href="{{ route('login') }}">Se connecter</a></p>
    </form>
</div>

<script>
    // Toggle Password Visibility
    function toggle(id, el) {
        const inp = document.getElementById(id);
        const ic = el.querySelector('i');
        inp.type = inp.type === "password" ? "text" : "password";
        ic.classList.toggle('bx-hide'); 
        ic.classList.toggle('bx-show');
    }

    // Password Strength Indicator
    function checkP(v) {
        const b = document.getElementById('sb');
        if(v.length === 0) b.style.width = '0%';
        else if(v.length < 6) { b.style.width = '35%'; b.style.background = '#ef4444'; }
        else if(v.length < 10) { b.style.width = '65%'; b.style.background = '#f59e0b'; }
        else { b.style.width = '100%'; b.style.background = '#10b981'; }
    }
</script>

</body>
</html>