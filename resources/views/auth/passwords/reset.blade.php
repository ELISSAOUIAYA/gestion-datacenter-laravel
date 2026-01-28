@extends('layouts.app')

@section('content')
<style>
    :root {
        --bg: #020617;
        --card-bg: rgba(15, 23, 42, 0.8);
        --primary: #38bdf8;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
        --border: rgba(255, 255, 255, 0.08);
    }

    .reset-wrapper {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background-image: radial-gradient(circle at top right, rgba(56, 189, 248, 0.05), transparent);
    }

    .reset-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border: 1px solid var(--border);
        border-radius: 28px;
        padding: 40px;
        max-width: 450px;
        width: 100%;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .header-zone { text-align: center; margin-bottom: 30px; }
    .icon-circle {
        width: 65px; height: 65px;
        background: rgba(56, 189, 248, 0.1);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 15px;
        color: var(--primary);
        font-size: 2rem;
        border: 1px solid rgba(56, 189, 248, 0.2);
    }

    .form-label {
        font-size: 0.75rem; font-weight: 700; color: var(--text-muted);
        text-transform: uppercase; margin-bottom: 8px; display: block;
    }

    .input-group { position: relative; margin-bottom: 20px; }
    .input-group i {
        position: absolute; left: 15px; top: 50%;
        transform: translateY(-50%); color: var(--text-muted); font-size: 1.2rem;
    }

    .form-control {
        width: 100%; padding: 13px 15px 13px 45px;
        background: rgba(0, 0, 0, 0.3); border: 1.5px solid var(--border);
        border-radius: 12px; color: white; transition: 0.3s;
    }

    .form-control:focus {
        outline: none; border-color: var(--primary); background: rgba(56, 189, 248, 0.05);
    }

    .btn-reset {
        width: 100%; padding: 15px; background: var(--primary); color: #020617;
        border: none; border-radius: 12px; font-weight: 800;
        cursor: pointer; transition: 0.3s; margin-top: 10px;
    }

    .btn-reset:hover {
        transform: translateY(-2px); box-shadow: 0 10px 20px rgba(56, 189, 248, 0.3);
    }

    .error-msg { color: #ef4444; font-size: 0.75rem; margin-top: 5px; display: block; }
</style>

<div class="reset-wrapper">
    <div class="reset-card">
        <div class="header-zone">
            <div class="icon-circle"><i class='bx bx-shield-quarter'></i></div>
            <h2 style="color: white; font-weight: 800;">Nouveau mot de passe</h2>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Dernière étape pour sécuriser votre accès</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label class="form-label">Email</label>
                <div class="input-group">
                    <i class='bx bx-envelope'></i>
                    <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                </div>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div class="input-group">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password" autofocus>
                </div>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Confirmer</label>
                <div class="input-group">
                    <i class='bx bx-check-shield'></i>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn-reset">
                Réinitialiser le mot de passe
            </button>
        </form>
    </div>
</div>
@endsection