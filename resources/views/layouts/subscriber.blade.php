<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Horizons')</title>
    <link href="{{ asset('css/subscriber/style.css') }}" rel="stylesheet">
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
                    <span>Abonné</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('subscriber.dashboard') }}" class="nav-item {{ request()->routeIs('subscriber.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('subscriber.articles') }}" class="nav-item {{ request()->routeIs('subscriber.articles*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i>
                    <span>Articles</span>
                </a>
                <a href="{{ route('subscriber.submissions.index') }}" class="nav-item {{ request()->routeIs('subscriber.propositions*') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i>
                    <span>Proposition</span>
                </a>
                <a href="{{ route('subscriber.subscriptions') }}" class="nav-item {{ request()->routeIs('subscriber.subscriptions') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Abonnements</span>
                </a>
                <a href="{{ route('subscriber.history') }}" class="nav-item {{ request()->routeIs('subscriber.history') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
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
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </header>

            <div class="content-wrapper">
                <div class="content-header">
                    <h1 class="page-title">@yield('page-title')</h1>
                    @yield('header-actions')
                </div>

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