@extends('layouts.subscriber')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/discussions.css') }}">
@endsection

@section('page-title', 'Discussion - ' . $article->titre)

@section('content')
<div class="discussion-container">
    <header class="discussion-header">
        <div class="article-info">
            <a href="{{ route('subscriber.articles.show', $article) }}" class="back-link">
                <span class="icon">←</span>
                Retour à l'article
            </a>
            <h1>{{ $article->titre }}</h1>
            <div class="meta">
                <span class="theme">{{ $article->theme->nom_theme }}</span>
                <span class="author">Par {{ $article->auteur->nom }}</span>
            </div>
        </div>

        <div class="rating-section">
            <h3>Noter cet article</h3>
            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                    <button class="star-btn {{ $article->notes()->where('user_id', Auth::id())->first()?->note >= $i ? 'active' : '' }}"
                            onclick="rateArticle({{ $i }})">★</button>
                @endfor
            </div>
            <span class="average-rating">
                Note moyenne : {{ number_format($article->averageRating(), 1) }}/5
            </span>
        </div>
    </header>

    <div class="messages-section">
        <div class="messages-list">
            @forelse($messages as $message)
                <div class="message-card">
                    <div class="message-header">
                        <div class="user-info">
                            <span class="user-name">{{ $message->user->nom }}</span>
                            <span class="message-date">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="message-content">
                        {{ $message->message }}
                    </div>
                </div>
            @empty
                <p class="no-messages">Aucun message dans cette discussion.</p>
            @endforelse
        </div>

        <form action="{{ route('subscriber.discussions.store', $article) }}" method="POST" class="message-form">
            @csrf
            <div class="form-group">
                <label for="message">Votre message</label>
                <textarea name="message" 
                          id="message" 
                          rows="3" 
                          required 
                          class="form-control @error('message') is-invalid @enderror"
                          placeholder="Écrivez votre message..."></textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn-submit">Envoyer</button>
        </form>
    </div>

    <div class="pagination">
        {{ $messages->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
function rateArticle(note) {
    fetch('{{ route('subscriber.articles.rate', $article) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ note: note })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'affichage des étoiles
            document.querySelectorAll('.star-btn').forEach((btn, index) => {
                btn.classList.toggle('active', index < note);
            });
            // Mettre à jour la note moyenne
            document.querySelector('.average-rating').textContent = 
                `Note moyenne : ${parseFloat(data.newAverage).toFixed(1)}/5`;
        }
    })
    .catch(error => console.error('Erreur:', error));
}
</script>
@endsection 