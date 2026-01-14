<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | DataCenter Pro</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .invalid-feedback strong { color: #ff4d4d !important; }
        .input-group-text { background-color: #f8f9fa; border: none; }
        .form-control { border-left: none; }
        .form-label { font-weight: 500; margin-bottom: 5px; display: block; }
    </style>
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
            
            <div class="mb-3">
                <label for="email" class="form-label text-white">Adresse Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bxs-user'></i></span>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="votre@email.com" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus>
                </div>
                @error('email')
                <span class="invalid-feedback" role="alert" style="color: #ff4d4d; font-size: 0.8rem; margin-top: 5px; display: block;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-white">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bxs-lock-alt'></i></span>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Mot de passe" 
                           required>
                    <span class="input-group-text toggle-password" style="cursor: pointer;">
                        <i class='bx bxs-show' id="toggleIcon"></i>
                    </span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert" style="color: #ff4d4d; font-size: 0.8rem; margin-top: 5px; display: block;">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-white" for="remember" style="margin-left: 5px;">Rester connecté</label>
                </div>
                <a href="#" class="small text-decoration-none" style="color: #5e5ce6;">Mot de passe oublié?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100" id="loginBtn" style="background-color: #5e5ce6; border: none; padding: 10px; color: white; cursor: pointer; border-radius: 4px;">
                <span class="btn-text">Se Connecter</span>
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('js/login.js') }}"></script>
<script>
    // Script pour l'affichage du mot de passe
    const togglePassword = document.querySelector('.toggle-password');
    if(togglePassword) {
        togglePassword.addEventListener('click', function () {
            const passwordField = document.querySelector('#password');
            const icon = document.querySelector('#toggleIcon');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            icon.classList.toggle('bxs-show');
            icon.classList.toggle('bxs-hide');
        });
    }
</script>
</body>
</html>