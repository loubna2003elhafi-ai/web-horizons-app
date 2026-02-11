@extends('layouts.responsable')

@section('title', 'Dashboard - Theme Manager')


@section('styles')
<link href="{{ asset('css/responsable/dashboard.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Tableau de bord - ' . $theme->nom_theme)

@section('content')
<div class="dashboard-grid">
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['total_subscribers'] }}</span>
                <span class="stat-label">Abonnés</span>
            </div>
        </div>
        <br>
        <div class="stat-card">
            <div class="stat-icon">📝</div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['pending_articles'] }}</span>
                <span class="stat-label">Articles en attente</span>
            </div>
        </div>
        <br>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['published_articles'] }}</span>
                <span class="stat-label">Articles publiés</span>
            </div>
        </div>
        <br>
        <div class="stat-card">
            <div class="stat-icon">👁️</div>
            <div class="stat-info">
                <span class="stat-value">{{ $stats['total_views'] }}</span>
                <span class="stat-label">Vues totales</span>
            </div>
        </div>
    </div>

    <div class="dashboard-sections">
        <div class="recent-activity">
            <h2>Articles Récents à Modérer</h2>
            <div class="activity-list">
                @forelse($stats['recent_articles'] as $article)
                    <div class="activity-item">
                        <div class="activity-icon">📝</div>
                        <div class="activity-content">
                            <h4>{{ $article->titre }}</h4>
                            <p>Par {{ $article->auteur->nom }} - {{ $article->created_at->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('responsable.content.show', $article) }}" class="btn-review">
                            Examiner
                        </a>
                    </div>
                @empty
                    <p class="no-activity">Aucun article en attente de modération</p>
                @endforelse
            </div>
        </div>

        <div class="recent-activity">
            <h2>Nouveaux Abonnés</h2>
            <div class="activity-list">
                @forelse($stats['recent_subscriptions'] as $subscriber)
                    <div class="activity-item">
                        <div class="activity-icon">👤</div>
                        <div class="activity-content">
                            <h4>{{ $subscriber->nom }}</h4>
                            <p>Abonné le {{ $subscriber->pivot->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="no-activity">Aucun nouvel abonné</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 