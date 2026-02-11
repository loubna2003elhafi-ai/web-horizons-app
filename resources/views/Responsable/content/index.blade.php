@extends('layouts.responsable')

@section('title', 'Gestion des Articles - Responsable de thème')

@section('styles')
<link href="{{ asset('css/responsable/content.css') }}" rel="stylesheet">
<link href="{{ asset('css/subscriber/pagination.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="content-container">
    <div class="content-header">
        <h1>Gestion des Articles</h1>
        <div class="header-actions">
            <div class="filters">
                <select class="filter-select" name="status">
                    <option value="">Tous les statuts</option>
                    <option value="En cours" {{ request('status') == 'En cours' ? 'selected' : '' }}>En attente</option>
                    <option value="Publié" {{ request('status') == 'Publié' ? 'selected' : '' }}>Publiés</option>
                    <option value="Refusé" {{ request('status') == 'Refusé' ? 'selected' : '' }}>Refusés</option>
                </select>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher un article..." value="{{ request('search') }}">
                </div>
            </div>
        </div>
    </div>

    <div class="articles-grid">
        @forelse($articles as $article)
        <div class="article-card">
            <div class="article-header">
                <div class="article-meta">
                    <span class="status-badge status-{{ strtolower($article->statut) }}">
                        {{ $article->statut }}
                    </span>
                    <span class="date">{{ $article->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="article-actions">
                    <button class="btn-icon" title="Plus d'options">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>

            <div class="article-content">
                <h3 class="article-title">{{ $article->titre }}</h3>
                <p class="article-excerpt">{{ Str::limit($article->contenu, 150) }}</p>
                
                <div class="article-footer">
                    <div class="author-info">
                        <div class="author-avatar">
                            {{ substr($article->auteur->prenom, 0, 1) }}{{ substr($article->auteur->nom, 0, 1) }}
                        </div>
                        <span class="author-name">{{ $article->auteur->nom }}</span>
                    </div>
                    
                    <div class="article-stats">
                        <span class="stat">
                            <i class="fas fa-eye"></i>
                            {{ $article->vues }}
                        </span>
                        <span class="stat">
                            <i class="fas fa-comments"></i>
                            {{ $article->conversations_count }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="article-actions-menu">
                <a href="{{ route('responsable.content.show', $article) }}" class="btn-action">
                    <i class="fas fa-eye"></i>
                    Voir l'article
                </a>
                @if($article->statut === 'En cours')
                    <form action="{{ route('responsable.content.accept', $article) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-action btn-success">
                            <i class="fas fa-check"></i>
                            Accepter
                        </button>
                    </form>

                    <form action="{{ route('responsable.content.reject', $article) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-action btn-danger">
                            <i class="fas fa-times"></i>
                            Refuser
                        </button>
                    </form>
                @endif
                @if($article->statut === 'Publié')
                    <form action="{{ route('responsable.content.propose', $article) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-action btn-primary">
                            <i class="fas fa-star"></i>
                            Proposer à l'éditeur
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-newspaper"></i>
            <h3>Aucun article trouvé</h3>
            <p>Il n'y a pas encore d'articles dans votre thème.</p>
        </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $articles->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 