<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Horizons - Responsable de thème')</title>
    <link href="{{ asset('css/responsable/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="brand">
                    <i class="fas fa-bolt"></i>
                    <span>Tech Horizons</span>
                </div>
            </div>
            
            <div class="user-profile">
                <div class="avatar">
                    {{ substr(Auth::user()->prenom, 0, 1) }}{{ substr(Auth::user()->nom, 0, 1) }}
                </div>
                <div class="user-info">
                    <h3>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h3>
                    <span>Responsable de thème</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('responsable.dashboard') }}" class="nav-item {{ request()->routeIs('responsable.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('responsable.content.index') }}" class="nav-item {{ request()->routeIs('responsable.content.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Articles</span>
                </a>
                <a href="{{ route('responsable.members.index') }}" class="nav-item {{ request()->routeIs('responsable.members.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Abonnés</span>
                </a>
                
            </nav>
            <br>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-search">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher...">
                </div>
                <div class="header-actions">
                    <button class="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </header>

            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html> 