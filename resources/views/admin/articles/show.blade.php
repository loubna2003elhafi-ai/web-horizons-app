@extends('layouts.editor')

@section('title', $article->titre . ' - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editor/article-detail.css') }}">
@endsection

@section('page-title', 'Détail de l\'article')

@section('content')
<div class="article-detail-container">
    <div class="article-actions-header">
        <a href="{{ route('editor.articles.index') }}" class="btn-back">
            <span class="icon">←</span>
            Retour à la liste
        </a>

        <div class="action-buttons">
            <form action="{{ route('editor.articles.toggle-status', $article) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-toggle">
                    {{ $article->statut === 'Publié' ? 'Désactiver' : 'Activer' }}
                </button>
            </form>

            @if(!$article->numero_id && $article->statut === 'Publié')
            <form action="{{ route('editor.articles.assign-to-numero', $article) }}" method="POST" class="inline">
                @csrf
                <select name="numero_id" required class="form-control">
                    <option value="">Assigner à un numéro</option>
                    @foreach($numeros as $numero)
                        <option value="{{ $numero->Id_numero }}">
                            N°{{ $numero->numero_edition }} - {{ $numero->titre_numero }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-assign">Assigner au numéro</button>
            </form>
            @endif
        </div>
    </div>

    <div class="article-detail">
        <div class="article-header">
            <div class="article-meta">
                <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                <span class="status-badge {{ $article->statut }}">{{ $article->statut }}</span>
            </div>
            <h1>{{ $article->titre }}</h1>
            <div class="author-info">
                <div class="author">
                    <span class="label">Auteur</span>
                    <span class="value">{{ $article->auteur->nom }}</span>
                </div>
                <div class="submission-date">
                    <span class="label">Soumis le</span>
                    <span class="value">{{ $article->created_at->format('d/m/Y') }}</span>
                </div>
                @if($article->numero)
                <div class="issue-info">
                    <span class="label">Numéro</span>
                    <span class="value">N°{{ $article->numero->numero_edition }} - {{ $article->numero->titre_numero }}</span>
                </div>
                @endif
            </div>
        </div>

        @if($article->image_couverture)
            <div class="article-cover">
                <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                     alt="Image de couverture"
                     style="width: 100%; height: auto;">
            </div>
        @endif

        <div class="article-content">
            {!! nl2br(e($article->contenu)) !!}
        </div>

        @if($article->conversations->isNotEmpty())
        <div class="article-discussions">
            <h2>Discussions</h2>
            @foreach($article->conversations as $conversation)
            <div class="discussion-item">
                <div class="discussion-header">
                    <span class="author">{{ $conversation->user->nom }}</span>
                    <span class="date">{{ $conversation->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="discussion-content">
                    {{ $conversation->message }}
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection 