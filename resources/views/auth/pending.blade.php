<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En attente de validation - Tech Horizons</title>
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
                <div class="pending-status">
                    <div class="pending-icon">⏳</div>
                    <h1 class="auth-title">Compte en attente</h1>
                    <p class="auth-subtitle">Votre compte est en cours de validation</p>
                </div>
            </div>

            <div class="info-box">
                <h3>Que se passe-t-il maintenant ?</h3>
                <ul>
                    <li>Notre équipe examine votre demande d'inscription</li>
                    <li>Vous recevrez un email dès que votre compte sera validé</li>
                    <li>Le processus prend généralement moins de 24 heures</li>
                </ul>
            </div>

            <div class="contact-info">
                <p>Une question ? Contactez-nous à <a href="mailto:support@gmail.com">support@gmail.com</a></p>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn-secondary">Se déconnecter</button>
            </form>

            <div class="home-link">
                <a href="{{ route('home') }}">
                    <span>←</span> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>

</body>
</html>