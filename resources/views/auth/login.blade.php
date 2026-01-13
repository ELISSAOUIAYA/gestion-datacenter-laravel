<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | DataCenter Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <div class="logo">
                <i class='bx bxs-shield-quarter'></i>
            </div>
            <h2>Bienvenue</h2>
            <p>Connectez-vous pour gérer votre infrastructure</p>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            <div class="input-group mb-3">
                <span class="input-group-text"><i class='bx bxs-user'></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text"><i class='bx bxs-lock-alt'></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                <span class="input-group-text toggle-password" style="cursor: pointer;">
                    <i class='bx bxs-show' id="toggleIcon"></i>
                </span>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">Rester connecté</label>
                </div>
                <a href="#" class="small text-decoration-none">Mot de passe oublié?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                <span class="btn-text">Se Connecter</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>