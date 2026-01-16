<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Sécurisé | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        :root {
            --bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.8);
            --primary: #38bdf8;
            --primary-glow: rgba(56, 189, 248, 0.3);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
            --input-focus: rgba(56, 189, 248, 0.1);
        }

        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(56, 189, 248, 0.07) 0%, transparent 35%),
                radial-gradient(circle at 100% 100%, rgba(56, 189, 248, 0.07) 0%, transparent 35%);
        }

        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-box {
            width: 100%;
            max-width: 440px;
            background: var(--card-bg);
            backdrop-filter: blur(20px); 
            padding: 50px 40px;
            border-radius: 32px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-header {
            margin-bottom: 35px;
            text-align: center;
        }

        .brand-icon {
            width: 64px; height: 64px;
            background: var(--primary-glow);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(56, 189, 248, 0.2);
        }

        .brand-icon i {
            font-size: 2rem; color: var(--primary);
            filter: drop-shadow(0 0 8px var(--primary));
        }

        .login-header h2 {
            font-size: 1.75rem; font-weight: 800;
            letter-spacing: -0.025em; margin-bottom: 8px;
        }

        .login-header p {
            color: var(--text-muted); font-size: 0.95rem;
        }

        
        .form-group { margin-bottom: 24px; position: relative; }

        .form-label {
            font-size: 0.85rem; font-weight: 600;
            margin-bottom: 8px; display: block;
            color: var(--text-muted); transition: 0.3s;
        }

        .input-wrapper {
            position: relative;
            display: flex; align-items: center;
        }

        .input-wrapper i.main-icon {
            position: absolute; left: 16px;
            font-size: 1.25rem; color: var(--text-muted);
            transition: 0.3s;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: rgba(0, 0, 0, 0.2);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            color: white; font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--input-focus);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        
        .form-control:focus + i.main-icon,
        .form-group:focus-within .form-label {
            color: var(--primary);
        }

        .toggle-password {
            position: absolute; right: 16px;
            cursor: pointer; color: var(--text-muted);
            display: flex; align-items: center;
            padding: 4px;
        }

        .toggle-password:hover { color: var(--primary); }

        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary);
            color: #020617; 
            border: none; border-radius: 14px;
            font-size: 1rem; font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px var(--primary-glow);
            filter: brightness(1.1);
        }

        .btn-submit:active { transform: translateY(0); }

        .footer-links {
            margin-top: 25px;
            display: flex; justify-content: center;
            gap: 15px; font-size: 0.85rem;
        }

        .footer-links a {
            color: var(--text-muted); text-decoration: none;
            transition: 0.3s;
        }

        .footer-links a:hover { color: var(--primary); }

        /* Error Message Style */
        .error-hint {
            color: #fb7185; font-size: 0.75rem;
            margin-top: 6px; display: flex; align-items: center; gap: 4px;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="login-header">
            <div class="brand-icon">
                <i class='bx bxs-lock-open-alt'></i>
            </div>
            <h2>Accès Client</h2>
            <p>Identifiez-vous pour continuer</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Email Professionnel</label>
                <div class="input-wrapper">
                    <input type="email" name="email" class="form-control" placeholder="nom@entreprise.com" required autofocus>
                    <i class='bx bx-envelope main-icon'></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                    <i class='bx bx-key main-icon'></i>
                    <span class="toggle-password">
                        <i class='bx bx-show' id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); cursor: pointer;">
                    <input type="checkbox" name="remember" style="accent-color: var(--primary);"> Se souvenir
                </label>
                <a href="#" style="font-size: 0.85rem; color: var(--primary); text-decoration: none; font-weight: 600;">Oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">
                Connexion Sécurisée
            </button>
        </form>

        <div class="footer-links">
            <a href="{{ route('register') }}">Créer un compte</a>
            <span style="color: var(--border)">|</span>
            <a href="#">Support 24/7</a>
        </div>
    </div>

    <script>
        const toggleBtn = document.querySelector('.toggle-password');
        const passwordField = document.querySelector('#password');
        const icon = document.querySelector('#toggleIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bx-show');
            icon.classList.toggle('bx-hide');
        });
    </script>
</body>
</html>