<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récupération | DataCenter Pro</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        :root {
            --bg: #020617;
            --card-bg: rgba(15, 23, 42, 0.9);
            --primary: #38bdf8;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(255, 255, 255, 0.08);
        }

        body {
            margin: 0;
            background-color: var(--bg);
            color: var(--text-main);
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: radial-gradient(circle at top right, rgba(56, 189, 248, 0.05), transparent);
        }

        .forgot-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 28px;
            border: 1px solid var(--border);
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .icon-box {
            width: 60px; height: 60px;
            background: rgba(56, 189, 248, 0.1);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary);
            font-size: 2rem;
            border: 1px solid rgba(56, 189, 248, 0.2);
        }

        .form-group { text-align: left; margin-bottom: 20px; }
        
        label { 
            font-size: 0.75rem; font-weight: 700; color: var(--text-muted); 
            text-transform: uppercase; margin-bottom: 8px; display: block;
        }

        .input-wrapper { position: relative; }
        
        .input-wrapper i {
            position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 1.2rem;
        }

        input {
            width: 100%; padding: 12px 15px 12px 45px;
            background: rgba(0, 0, 0, 0.3); border: 1.5px solid var(--border);
            border-radius: 12px; color: white; box-sizing: border-box;
        }

        input:focus { outline: none; border-color: var(--primary); }

        button {
            width: 100%; padding: 14px; background: var(--primary); color: #020617;
            border: none; border-radius: 12px; font-weight: 800; cursor: pointer;
            transition: 0.3s; margin-top: 10px;
        }

        button:hover { transform: translateY(-2px); opacity: 0.9; }

        .status-alert {
            background: rgba(16, 185, 129, 0.1); color: #10b981;
            padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="forgot-card">
    <div class="icon-box"><i class='bx bx-mail-send'></i></div>
    <h2 style="margin-bottom: 10px;">Mot de passe oublié</h2>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 25px;">Entrez votre email pour réinitialiser votre accès.</p>

    @if (session('status'))
        <div class="status-alert">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label>Adresse Email</label>
            <div class="input-wrapper">
                <i class='bx bx-envelope'></i>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="nom@example.com">
            </div>
            @error('email')
                <span style="color: #ef4444; font-size: 0.7rem;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Envoyer le lien</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-size: 0.85rem;">Retour à la connexion</a>
    </div>
</div>

</body>
</html>