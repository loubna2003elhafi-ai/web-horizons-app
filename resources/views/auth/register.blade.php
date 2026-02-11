<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Tech Horizons</title>
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="logo">
                    ⚡ Tech Horizons
                </a>
                <h1 class="auth-title">Créez votre compte</h1>
                <p class="auth-subtitle">Rejoignez notre communauté tech</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" 
                        class="form-control @error('nom') is-invalid @enderror" 
                        id="nom" 
                        name="nom" 
                        value="{{ old('nom') }}" 
                        required>
                    @error('nom')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" 
                        class="form-control @error('prenom') is-invalid @enderror" 
                        id="prenom" 
                        name="prenom" 
                        value="{{ old('prenom') }}" 
                        required>
                    @error('prenom')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input type="password" 
                        class="form-control" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required>
                </div>

                <button type="submit" class="btn-primary">
                    Créer mon compte
                </button>
            </form>

            <div class="auth-footer">
                <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
                <p class="auth-redirect">
                         
                         <a href="{{route('home')}}">return to home page</a>
                     </p>
            </div>
        </div>
    </div>
    
</body>
</html>