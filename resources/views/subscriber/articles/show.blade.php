@extends('layouts.subscriber')

@section('title', $article->titre . ' - Tech Horizons')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/article-detail.css') }}">
@endsection

@section('content')
<div class="article-container">
    <div class="article-header">
        <a href="{{ route('subscriber.articles') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Retour aux articles
        </a>

        <div class="article-meta">
            <div class="meta-badges">
                <span class="theme-badge">
                    <i class="fas fa-bookmark"></i>
                    {{ $article->theme->nom_theme }}
                </span>
                <span class="date-badge">
                    <i class="fas fa-calendar"></i>
                    {{ $article->date_publication }}
                </span>
            </div>

            <div class="article-stats">
                <span class="stat-item">
                    <i class="fas fa-eye"></i>
                    {{ $article->vues_count ?? 0 }} lectures
                </span>
                <span class="stat-item">
                    <i class="fas fa-star"></i>
                    {{ number_format($article->moyenne_notes, 1) }} / 5
                </span>
            </div>
        </div>

        <h1>{{ $article->titre }}</h1>

        <div class="author-info">
            <div class="author-avatar">
                {{ substr($article->auteur->prenom, 0, 1) }}{{ substr($article->auteur->nom, 0, 1) }}
            </div>
            <div class="author-details">
                <span class="author-name">{{ $article->auteur->prenom }} {{ $article->auteur->nom }}</span>
                <span class="author-role">Auteur</span>
            </div>
        </div>
    </div>

    @if($article->image_couverture)
        <div class="article-cover">
            <img src="{{ asset('storage/' . $article->image_couverture) }}" alt="{{ $article->titre }}">
        </div>
    @endif

    <div class="article-content">
        {!! $article->contenu !!}
    </div>

    <div class="article-actions">
        <div class="rating-section">
            <h3>Noter cet article</h3>
            <div class="rating-stars" data-article="{{ $article->id }}">
                @for($i = 1; $i <= 5; $i++)
                    <button class="star-btn {{ $article->notes()->where('user_id', Auth::id())->first()?->note >= $i ? 'active' : '' }}"
                            onclick="window.location.href='{{ route('subscriber.discussions.show', $article) }}#rating'">★</button>
                @endfor
            </div>
            <span class="rating-text">
                Note moyenne : {{ number_format($article->averageRating(), 1) }}/5
            </span>
        </div>

        <div class="discussion-section">
            <h3>Discussion</h3>
            <div class="discussion-preview">
                @if($article->conversations()->count() > 0)
                    <p>{{ $article->conversations()->count() }} message(s) dans la discussion</p>
                @else
                    <p>Soyez le premier à participer à la discussion</p>
                @endif
                <a href="{{ route('subscriber.discussions.show', $article) }}" class="btn-primary">
                    <i class="fas fa-comments"></i>
                    Participer à la discussion
                </a>
            </div>
        </div>
    </div>

    @if($similarArticles->count() > 0)
        <div class="similar-articles">
            <h2>Articles similaires</h2>
            <div class="articles-grid">
                @foreach($similarArticles as $similarArticle)
                    <div class="article-card">
                        @if($similarArticle->image_couverture)
                            <div class="article-image">
                                <img src="{{ asset('storage/' . $similarArticle->image_couverture) }}" 
                                     alt="{{ $similarArticle->titre }}">
                            </div>
                        @endif
                        <div class="article-content">
                            <h3>{{ $similarArticle->titre }}</h3>
                            <p>{{ Str::limit(strip_tags($similarArticle->contenu), 100) }}</p>
                            <a href="{{ route('subscriber.articles.show', $similarArticle) }}" class="btn-read">
                                Lire l'article <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

   
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelector('.rating-stars');
    const stars = ratingStars.querySelectorAll('.star-btn');
    
    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const value = this.dataset.value;
            highlightStars(value);
        });
        
        star.addEventListener('click', function() {
            const value = this.dataset.value;
            const articleId = ratingStars.dataset.article;
            submitRating(articleId, value);
        });
    });
    
    ratingStars.addEventListener('mouseleave', function() {
        stars.forEach(star => star.classList.remove('active'));
    });
    
    function highlightStars(value) {
        stars.forEach(star => {
            star.classList.toggle('active', star.dataset.value <= value);
        });
    }
    
    function submitRating(articleId, rating) {
        fetch(`/subscriber/articles/${articleId}/rate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ rating: rating })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage de la note moyenne
                document.querySelector('.stat-item .fa-star').parentElement.textContent = 
                    `${Number(data.newAverage).toFixed(1)} / 5`;
                    
                // Feedback visuel
                const ratingText = document.querySelector('.rating-text');
                ratingText.textContent = 'Merci pour votre note !';
                ratingText.classList.add('success');
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
</script>
@endsection 