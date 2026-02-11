@extends('layouts.app')

@section('title', $article->titre)

@section('content')
<div class="article-container">
    <div class="article-header">
        <div class="article-meta">
            <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
            <span class="numero-badge">{{ $article->numero->titre_numero }}</span>
        </div>
        <h1>{{ $article->titre }}</h1>
        <div class="article-info">
            <span class="author">Par {{ $article->auteur->nom }}</span>
            <span class="date">{{ $article->date_publication->format('d/m/Y') }}</span>
        </div>
    </div>

    @if($article->image_couverture)
        <div class="article-cover">
            <img src="{{ asset('storage/' . $article->image_couverture) }}" 
                 alt="Image de couverture de {{ $article->titre }}"
                 style="width: 100%; height: auto;">
        </div>
    @endif

    <div class="article-content">
        {!! nl2br(e($article->contenu)) !!}
    </div>
</div>

<style>
.article-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.article-header {
    margin-bottom: 2rem;
}

.article-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.theme-badge, .numero-badge {
    font-size: 0.875rem;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
}

.theme-badge {
    color: #2563eb;
    background: #dbeafe;
}

.numero-badge {
    color: #059669;
    background: #d1fae5;
}

.article-info {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 1rem;
}

.article-cover {
    margin: 2rem 0;
}

.article-cover img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 8px;
}

.article-content {
    line-height: 1.8;
    color: #374151;
}
</style>
@endsection 