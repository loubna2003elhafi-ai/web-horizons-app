@extends('layouts.editor')

@section('title', 'Articles Proposés - Éditeur')

@section('styles')
<link href="{{ asset('css/admin/articles.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="articles-container">
    <div class="articles-header">
        <h1>Articles Proposés</h1>
        <div class="header-actions">
            <div class="filters">
                <select class="filter-select" name="status">
                    <option value="">Tous les statuts</option>
                    <option value="Retenu" {{ request('status') == 'Retenu' ? 'selected' : '' }}>Retenu</option>
                    <option value="Publié" {{ request('status') == 'Publié' ? 'selected' : '' }}>Publiés</option>
                    <option value="Désactivé" {{ request('status') == 'Désactivé' ? 'selected' : '' }}>Désactivés</option>
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="articles-grid">
        @forelse($articles['Retenu'] ?? [] as $article)
            <div class="article-card">
                <div class="article-image">
                    <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}">
                </div>
                
                <h3 class="article-title">{{ $article->titre }}</h3>
                <div class="article-theme">{{ $article->theme->nom }}</div>
                
                <div class="article-meta">
                    <span class="article-author">Par {{ $article->auteur->nom }} {{ $article->auteur->prenom }}</span>
                    <span class="article-date">{{ $article->date_proposition_editeur->format('d/m/Y') }}</span>
                </div>

                <div class="article-actions">
                    <a href="{{ route('editor.articles.show', $article) }}" class="btn-action">
                        <i class="fas fa-eye"></i>
                        Examiner l'article
                    </a>

                    <form action="{{ route('editor.articles.toggle-status', $article) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-action">
                            <i class="fas {{ $article->statut === 'Publié' ? 'fa-times' : 'fa-check' }}"></i>
                            {{ $article->statut === 'Publié' ? 'Désactiver' : 'Publier' }}
                        </button>
                    </form>

                    <form action="{{ route('editor.articles.assign-to-numero', $article) }}" method="POST">
                        @csrf
                        <select name="numero_id" class="select-numero">
                            <option value="">Assigner à un numéro</option>
                            @foreach($numeros as $numero)
                                <option value="{{ $numero->Id_numero }}" {{ $article->numero_id == $numero->Id_numero ? 'selected' : '' }}>
                                    {{ $numero->titre_numero }} (#{{ $numero->numero_edition }})
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-assign">
                            <i class="fas fa-plus"></i>
                            Assigner
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <h3>Aucun article proposé</h3>
                <p>Il n'y a pas d'articles proposés pour le moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection 