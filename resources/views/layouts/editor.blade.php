<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Horizons - Éditeur')</title>
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
</head>
<body>
    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="brand">
                    <i class="fas fa-book-open"></i>
                    <span>Tech Horizons</span>
                </div>
            </div>
            
            <div class="user-profile">
                <div class="avatar">
                    {{ substr(Auth::user()->prenom, 0, 1) }}{{ substr(Auth::user()->nom, 0, 1) }}
                </div>
                <div class="user-info">
                    <h3>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h3>
                    <span>Éditeur en chef</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('editor.dashboard') }}" class="nav-item {{ request()->routeIs('editor.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('editor.articles.index') }}" class="nav-item {{ request()->routeIs('editor.articles.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Articles proposés</span>
                </a>
                <a href="{{ route('editor.issues.index') }}" class="nav-item {{ request()->routeIs('editor.issues.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Numéros</span>
                </a>
                <a href="{{ route('editor.users.index') }}" class="nav-item {{ request()->routeIs('editor.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Utilisateurs</span>
                </a>
            </nav>

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
                    <div class="notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </div>
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