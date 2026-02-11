@extends('layouts.responsable')

@section('title', $article->titre . ' - Gestion Article')

@section('styles')
<link href="{{ asset('css/responsable/content-detail.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="article-container">
    <div class="article-header">
        <div class="header-top">
            <a href="{{ route('responsable.content.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Retour aux articles
            </a>
            <div class="article-status">
                <span class="status-badge status-{{ strtolower($article->statut) }}">
                    {{ $article->statut }}
                </span>
            </div>
        </div>
        
        <h1>{{ $article->titre }}</h1>
        
        <div class="article-meta">
            <div class="meta-item">
                <i class="fas fa-user"></i>
                <span>{{ $article->auteur->nom }}</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-calendar"></i>
                <span>{{ $article->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-eye"></i>
                <span>{{ $article->vues }} vues</span>
            </div>
            <div class="meta-item">
                <i class="fas fa-clock"></i>
                <span>{{ $article->temps_lecture }} min de lecture</span>
            </div>
        </div>
    </div>

    <div class="article-content">
        @if($article->image_couverture)
            <div class="article-cover">
                <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="Image de couverture">
            </div>
        @endif

        <div class="article-text">
            {!! nl2br(e($article->contenu)) !!}
        </div>
    </div>

    <div class="article-actions">
        @if($article->statut === 'En cours')
            <form action="{{ route('responsable.content.accept', $article) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-action btn-success">
                    <i class="fas fa-check"></i>
                    Accepter l'article
                </button>
            </form>

            <form action="{{ route('responsable.content.reject', $article) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-action btn-danger">
                    <i class="fas fa-times"></i>
                    Refuser l'article
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

    <div class="comments-section">
        <h2>Commentaires ({{ $article->conversations->count() }})</h2>
        
        <form action="{{ route('responsable.moderation.comment', $article) }}" method="POST" class="comment-form">
            @csrf
            <div class="form-group">
                <textarea 
                    name="message" 
                    id="message" 
                    rows="3" 
                    placeholder="Ajouter un commentaire..."
                    required
                ></textarea>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-paper-plane"></i>
                Envoyer
            </button>
        </form>

        <div class="comments-list">
            @forelse($article->conversations->sortByDesc('created_at') as $comment)
                <div class="comment-card" id="comment-{{ $comment->id }}">
                    <div class="comment-header">
                        <div class="comment-author">
                            <div class="author-avatar">
                                {{ substr($comment->user->prenom, 0, 1) }}{{ substr($comment->user->nom, 0, 1) }}
                            </div>
                            <div class="author-info">
                                <span class="author-name">{{ $comment->user->nom }}</span>
                                <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @if($comment->user_id === auth()->id() || auth()->user()->role === 'Responsable de thème')
                            <form action="{{ route('responsable.moderation.delete-message', $comment) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="comment-content">
                        {{ $comment->message }}
                    </div>
                </div>
            @empty
                <div class="empty-comments">
                    <i class="fas fa-comments"></i>
                    <p>Aucun commentaire pour le moment</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 