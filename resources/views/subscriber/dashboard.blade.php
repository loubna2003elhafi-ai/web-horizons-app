@extends('layouts.subscriber')

@section('title', 'Tableau de bord - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/dashboard.css') }}">
@endsection

@section('page-title', 'Tableau de bord')

@section('content')
<div class="dashboard-grid">
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $articlesCount }}</span>
                <span class="stat-label">Articles lus</span>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: {{ min(($articlesCount/100) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $subscriptionsCount }}</span>
                <span class="stat-label">Abonnements actifs</span>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: {{ ($subscriptionsCount/10) * 100 }}%"></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $readArticlesCount }}</span>
                <span class="stat-label">Dans l'historique</span>
                <div class="stat-progress">
                    <div class="progress-bar" style="width: {{ min(($readArticlesCount/200) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="recent-activity">
            <div class="section-header">
                <h2><i class="fas fa-clock"></i> Activités récentes</h2>
                <a href="{{ route('subscriber.history') }}" class="btn-link">Voir tout <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="activity-list">
                @forelse($recentActivities as $activity)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div class="activity-content">
                            <h4>{{ $activity->article->titre }}</h4>
                            <div class="activity-meta">
                                <span><i class="fas fa-calendar"></i> {{ $activity->date_consultation->format('d/m/Y') }}</span>
                                <span><i class="fas fa-clock"></i> {{ $activity->date_consultation->format('H:i') }}</span>
                            </div>
                            <a href="{{ route('subscriber.articles.show', $activity->article) }}" class="btn-read">
                                Relire l'article <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="no-activity">
                        <i class="fas fa-inbox"></i>
                        <p>Aucune activité récente</p>
                        <a href="{{ route('subscriber.articles') }}" class="btn-primary">
                            Découvrir des articles
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des barres de progression
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });
});
</script>
@endsection 


