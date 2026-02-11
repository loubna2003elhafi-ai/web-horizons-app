<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Tech Horizons')</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        <nav class="main-nav">
            <div class="nav-container">
                <div class="logo">
                    <a href="/">
                        <span class="logo-icon">⚡</span>
                        Tech Horizons
                    </a>
                </div>
                <div class="nav-links">
                    @auth
                        <a href="{{ match(auth()->user()->role) {
                            'Éditeur' => route('editor.dashboard'),
                            'Responsable de thème' => route('responsable.dashboard'),
                            default => route('subscriber.dashboard')
                        } }}" class="btn dashboard-btn">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="btn logout-btn">Logout</button>
                        </form>
                    @else
                        <a href="{{route('login')}}" class="btn login-btn">Sign In</a>
                        <a href="{{route('register')}}" class="btn signup-btn">Get Started</a>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>

        <footer class="main-footer">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>À Propos</h4>
                    <ul>
                        <li><a href="">Notre Histoire</a></li>
                        <li><a href="">L'Équipe</a></li>
                        <li><a href="">Carrières</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Ressources</h4>
                    <ul>
                        <li><a href="">Documentation</a></li>
                        <li><a href="">Guide de Publication</a></li>
                        <li><a href="">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="mailto:contact@techhorizons.com">Email</a></li>
                        <li><a href="">Twitter</a></li>
                        <li><a href="">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Tech Horizons. Tous droits réservés.</p>
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>
</html> 