<!DOCTYPE html>
<html lang="fr">
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
            --error: #fb7185;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(56, 189, 248, 0.07) 0%, transparent 35%),
                radial-gradient(circle at 100% 100%, rgba(56, 189, 248, 0.07) 0%, transparent 35%);
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

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header { text-align: center; margin-bottom: 35px; }
        
         .brand-icon {
            width: 72px; 
            height: 72px;
            background: var(--primary-glow);
            border-radius: 20px;
            display: flex !important;  
            align-items: center; 
            justify-content: center;
            margin: 0 auto 20px;
            border: 1px solid rgba(56, 189, 248, 0.4);
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.15);
        }

        .brand-icon i { 
            font-size: 2.8rem !important; 
            color: var(--primary); 
            filter: drop-shadow(0 0 10px var(--primary));
            display: inline-block !important;
            line-height: 1;
        }

        .login-header h2 { font-size: 1.75rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 8px; }
        .login-header p { color: var(--text-muted); font-size: 0.95rem; }

        .form-group { margin-bottom: 24px; position: relative; }
        .form-label { font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; display: block; color: var(--text-muted); }

        .input-wrapper { position: relative; display: flex; align-items: center; }
        
        .input-wrapper i.main-icon { 
            position: absolute; left: 16px; 
            font-size: 1.25rem; color: var(--text-muted); 
            transition: 0.3s; pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: rgba(0, 0, 0, 0.3);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            color: white; font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none; border-color: var(--primary);
            background: var(--input-focus);
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .form-control.is-invalid { border-color: var(--error) !important; }
        .invalid-feedback { 
            color: var(--error); font-size: 0.78rem; 
            margin-top: 8px; font-weight: 500; 
            display: flex; align-items: center; gap: 5px;
        }

        .toggle-password { position: absolute; right: 16px; cursor: pointer; color: var(--text-muted); padding: 4px; display: flex; align-items: center; }

        .btn-submit {
            width: 100%; padding: 16px; background: var(--primary); color: #020617; 
            border: none; border-radius: 14px; font-size: 1rem; font-weight: 700;
            cursor: pointer; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-top: 10px;
        }

        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px var(--primary-glow); filter: brightness(1.1); }

        .footer-links { margin-top: 25px; display: flex; justify-content: center; gap: 15px; font-size: 0.85rem; }
        .footer-links a { color: var(--text-muted); text-decoration: none; transition: 0.3s; }
        .footer-links a:hover { color: var(--primary); }

        .checkbox-group { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: var(--text-muted); cursor: pointer; }
        .checkbox-group input { accent-color: var(--primary); width: 16px; height: 16px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="login-header">
            <div class="brand-icon">
                <i class='bx bxs-shield-alt-2'></i> 
            </div>
            <h2>Bienvenue</h2>
            <p>Connectez-vous à votre infrastructure</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Adresse Email</label>
                <div class="input-wrapper">
                    <i class='bx bxs-user-circle main-icon'></i>
                    <input type="email" name="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="admin@test.com" 
                           value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="invalid-feedback">
                        <i class='bx bx-error-alt'></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div class="input-wrapper">
                    <i class='bx bxs-lock-alt main-icon'></i>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                    <span class="toggle-password" id="togglePassword">
                        <i class='bx bxs-show' id="toggleIcon"></i>
                    </span>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <label class="checkbox-group">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 
                    Se souvenir de moi
                </label>
                <a href="{{ route('password.request') }}" style="font-size: 0.85rem; color: var(--primary); text-decoration: none; font-weight: 600;">Oublié ?</a>
            </div>

            <button type="submit" class="btn-submit">
                Connexion Sécurisée
            </button>
        </form>

        <div class="footer-links">
            <a href="{{ route('register') }}">Créer un compte</a>
            <span style="color: var(--border)">|</span>
            <a href="#">Support Technique</a>
        </div>
    </div>

    <script>
      
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bxs-show');
            icon.classList.toggle('bxs-hide');
        });

       
        const controls = document.querySelectorAll('.form-control');
        controls.forEach(control => {
            control.addEventListener('focus', () => {
                control.parentElement.querySelector('.main-icon').style.color = 'var(--primary)';
            });
            control.addEventListener('blur', () => {
                control.parentElement.querySelector('.main-icon').style.color = 'var(--text-muted)';
            });
        });
    </script>
</body>
</html>