<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Créer un compte | DataCenter</title>
</head>
<body>

<div class="register-container">
    <div class="register-box">
        <div class="header-zone">
            <i class='bx bxs-user-plus icon-main'></i>
            <h2>Rejoignez-nous</h2>
            <p>Créez votre accès au DataCenter en quelques secondes</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="regForm">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nom complet</label>
                    <input type="text" name="name" class="form-control" placeholder="Ali Alami" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email Professionnel</label>
                    <input type="email" name="email" class="form-control" placeholder="ali@company.com" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Votre Type d'Utilisateur <span style="color: #999; font-size: 0.85rem;">(Optionnel - pour les utilisateurs internes)</span></label>
                <select name="user_type" class="form-control">
                    <option value="">-- Sélectionnez votre type (optionnel) --</option>
                    <option value="Ingénieur">Ingénieur</option>
                    <option value="Doctorant">Doctorant</option>
                    <option value="Enseignant">Enseignant</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Mot de passe</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="pass" class="form-control" required>
                    <i class='bx bx-hide toggle-pass' onclick="toggle('pass')"></i>
                </div>
                <div class="pass-strength mt-2">
                    <div class="strength-bar" id="strengthBar"></div>
                </div>
            </div>

            <div class="mb-4">
                <label>Confirmer le mot de passe</label>
                <div class="input-wrapper">
                    <input type="password" name="password_confirmation" id="pass_confirm" class="form-control" required>
                    <i class='bx bx-hide toggle-pass' onclick="toggle('pass_confirm')"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="submitBtn">
                Créer mon compte
            </button>

            <p class="text-center mt-3 mb-0">Déjà inscrit ? <a href="{{ route('login') }}" class="text-primary fw-bold">Se connecter</a></p>
        </form>
    </div>
</div>

<script src="{{ asset('js/register.js') }}"></script>
</body>
</html>