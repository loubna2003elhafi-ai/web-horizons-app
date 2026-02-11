@extends('layouts.app')

@section('title', 'Tech Horizons - Votre Magazine Tech')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="hero">
    <div class="hero-content">
        <h1>Explorez l'Avenir de la Technologie</h1>
        <p>Découvrez les dernières innovations et tendances tech à travers des articles rédigés par des experts passionnés.</p>
        <div class="cta-buttons">
            <a href="{{ route('register') }}" class="btn-primary">Commencer l'aventure</a>
            <a href="{{ route('login') }}" class="btn-secondary">Se connecter</a>
        </div>
    </div>
</section>

<section class="features">
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">📚</div>
            <h3>Articles Experts</h3>
            <p>Des contenus de qualité rédigés par des professionnels du secteur.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🎯</div>
            <h3>Thèmes Variés</h3>
            <p>De l'IA au développement web, trouvez les sujets qui vous passionnent.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">💡</div>
            <h3>Veille Technologique</h3>
            <p>Restez à jour sur les dernières avancées technologiques.</p>
        </div>
    </div>
</section>

<section class="themes-section">
    <div class="section-header">
        <h2>Nos Thématiques</h2>
        <p>Explorez nos différents domaines d'expertise</p>
    </div>
    <div class="themes-grid">
        @foreach($themes as $theme)
        <div class="theme-card">
            <div class="theme-icon">{{ $theme->icon ?? '🔥' }}</div>
            <h3>{{ $theme->nom_theme }}</h3>
            <p>{{ $theme->description }}</p>
            <span class="article-count">{{ $theme->articles_count }} articles</span>
        </div>
        @endforeach
    </div>
</section>

<section class="articles-section">
    <div class="section-header">
        <h2>Articles Récents</h2>
        <p>Les dernières publications de nos experts</p>
    </div>
    <div class="articles-grid">
        @foreach($latestArticles as $article)
        <div class="article-card">
            @if($article->image_couverture)
            <div class="article-image">
                <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}">
            </div>
            @endif
            <div class="article-content">
                <div class="article-meta">
                    <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                    <span class="date">{{ $article->date_publication->format('d M Y') }}</span>
                </div>
                <h3>{{ $article->titre }}</h3>
                <p>{{ Str::limit($article->contenu, 150) }}</p>
                <div class="article-footer">
                    <span class="author">Par {{ $article->auteur->nom }}</span>
                    <a href="{{ route('public.articles.show', $article) }}" class="read-more">Lire la suite →</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection