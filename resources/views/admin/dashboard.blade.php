@extends('layouts.editor')

@section('title', 'Tableau de bord - Éditeur')

@section('styles')
<link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Tableau de bord</h1>
    </div>

    <div class="dashboard-grid">
        <!-- Exemple de carte -->
        <div class="dashboard-card">
            <h2 class="card-title">Articles Proposés</h2>
            <p class="card-content">Vous avez <b> {{ $articlesCount }} </b> articles proposés en attente de validation.</p>
            <div class="card-actions">
                <a href="{{ route('editor.articles.index') }}" class="btn-action">Voir les articles</a>
            </div>
        </div>

        <div class="dashboard-card">
            <h2 class="card-title">Utilisateurs</h2>
            <p class="card-content">Vous avez <b>{{ $usersCount }} </b> utilisateurs enregistrés.</p>
            <div class="card-actions">
                <a href="{{ route('editor.users.index') }}" class="btn-action">Gérer les utilisateurs</a>
            </div>
        </div>

        <div class="dashboard-card">
            <h2 class="card-title">Numéros</h2>
            <p class="card-content">Vous avez <b>{{ $numerosCount }} </b> numéros disponibles.</p>
            <div class="card-actions">
                <a href="{{ route('editor.issues.index') }}" class="btn-action">Gérer les numéros</a>
            </div>
        </div>
    </div>

    @if($isEmpty)
        <div class="empty-state">
            <i class="fas fa-chart-line"></i>
            <h3>Aucune donnée disponible</h3>
            <p>Commencez par ajouter des articles, des utilisateurs ou des numéros.</p>
        </div>
    @endif
</div>

<div class="recent-section">
    <div class="section-header">
        <h2>Articles récemment soumis</h2>
        <br><br>
        <a href="{{ route('editor.articles.index') }}" class="btn-view-all">Voir tout</a>
    </div>
    <br>
    <div class="articles-grid">
        @forelse($stats['derniers_articles_proposes'] as $article)
            <div class="article-card">
                @if($article->image_couverture)
                    <div class="article-image">
                        <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}"
                        style="width: 100%; height: auto;">
                    </div>
                @endif
                <div class="article-content">
                    <div class="article-header">
                        <h3>{{ $article->titre }}</h3>
                        <div class="article-badges">
                            <span class="theme-badge">{{ $article->theme->nom_theme }}</span>
                            <span class="status-badge {{ $article->statut }}">{{ $article->statut }}</span>
                        </div>
                    </div>
                    <div class="article-meta">
                        <span>Par {{ $article->auteur->nom }}</span>
                        <span>{{ $article->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="article-actions">
                        <a href="{{ route('editor.articles.show', $article) }}" class="btn-action">
                            Examiner
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="no-articles">Aucun article récent</p>
        @endforelse
    </div>
</div>
@endsection 