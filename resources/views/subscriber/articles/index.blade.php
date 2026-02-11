@extends('layouts.subscriber')

@section('title', 'Articles - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/articles.css') }}">
<link rel="stylesheet" href="{{ asset('css/subscriber/pagination.css') }}">
@endsection

@section('page-title', 'Articles')

@section('content')
<div class="articles-container">
    <div class="filters-section">
        <form action="{{ route('subscriber.articles') }}" method="GET" class="filters-form">
            <div class="search-group">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Rechercher un article..." 
                       value="{{ request('search') }}" class="form-control">
            </div>
            <div class="filter-group">
                <label for="theme">
                    <i class="fas fa-filter"></i>
                    Filtrer par thème
                </label>
                <select name="theme" id="theme" class="form-control" onchange="this.form.submit()">
                    <option value="">Tous les thèmes</option>
                    @foreach($subscribedThemes as $theme)
                        <option value="{{ $theme->id }}" {{ $selectedTheme == $theme->id ? 'selected' : '' }}>
                            {{ $theme->nom_theme }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <div class="articles-grid">
        @forelse($articles as $article)
            <div class="article-card">
                <div class="article-header">
                    @if($article->image_couverture)
                        <div class="article-image">
                            <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                                 alt="{{ $article->titre }}">
                        </div>
                    @endif
                    <div class="article-badges">
                        <span class="theme-badge">
                            <i class="fas fa-bookmark"></i>
                            {{ $article->theme->nom_theme }}
                        </span>
                        <span class="date-badge">
                            <i class="fas fa-calendar"></i>
                            {{ $article->date_publication->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
                
                <div class="article-content">
                    <h3>{{ $article->titre }}</h3>
                    <p>{{ Str::limit(strip_tags($article->contenu), 30) }}</p>
                    
                    <div class="article-meta">
                        <div class="author-info">
                            <div class="author-avatar">
                                {{ substr($article->auteur->prenom, 0, 1) }}{{ substr($article->auteur->nom, 0, 1) }}
                            </div>
                            <span>{{ $article->auteur->prenom }} {{ $article->auteur->nom }}</span>
                        </div>
                        
                        <div class="article-stats">
                            <span><i class="fas fa-eye"></i> {{ $article->vues_count ?? 0 }}</span>
                            <span><i class="fas fa-star"></i> {{ number_format($article->moyenne_notes, 1) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('subscriber.articles.show', $article) }}" class="btn-read">
                        Lire l'article
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="no-articles">
                <i class="fas fa-newspaper"></i>
                <h3>Aucun article trouvé</h3>
                <p>Essayez de modifier vos filtres ou abonnez-vous à plus de thèmes</p>
                <a href="{{ route('subscriber.subscriptions') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Gérer mes abonnements
                </a>
            </div>
        @endforelse
    </div>

    
        <div class="pagination-wrapper">
            {{ $articles->links('vendor.pagination.custom') }}
        </div>
    
</div>
@endsection 