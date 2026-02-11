@extends('layouts.subscriber')

@section('title', 'Mes propositions d\'articles')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/submissions.css') }}">
@endsection

@section('content')
<div class="submissions-container">
    <div class="submissions-header">
        <h1>Mes propositions d'articles</h1>
        <a href="{{ route('subscriber.submissions.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i>
            Proposer un article
        </a>
    </div>

    @if($propositions->isEmpty())
        <div class="no-submissions">
            <i class="fas fa-pen-fancy"></i>
            <h3>Aucune proposition</h3>
            <p>Vous n'avez pas encore proposé d'articles</p>
            <a href="{{ route('subscriber.submissions.create') }}" class="btn-primary">
                Proposer mon premier article
            </a>
        </div>
    @else
        @foreach($propositions as $statut => $articles)
            <div class="status-section">
                <h2 class="status-title">{{ $statut }}</h2>
                <div class="submissions-grid">
                    @foreach($articles as $article)
                        <div class="submission-card" data-article-id="{{ $article->id }}">
                            <div class="submission-header">
                                <span class="status-badge {{ $article->statut }}">
                                    {{ $article->statut }}
                                </span>
                                <span class="date">
                                    Proposé le {{ $article->date_proposition->format('d/m/Y') }}
                                </span>
                            </div>

                            <h3>{{ $article->titre }}</h3>
                            <p>{{ Str::limit(strip_tags($article->contenu), 150) }}</p>

                            <div class="submission-meta">
                                <span class="theme">
                                    <i class="fas fa-bookmark"></i>
                                    {{ $article->theme->nom_theme }}
                                </span>
                                <span class="reading-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $article->temps_lecture }} min
                                </span>
                            </div>

                            <div class="submission-footer">
                                <a href="{{ route('subscriber.submissions.show', $article) }}" class="btn-view">
                                    Voir détails
                                </a>
                                
                                <button onclick="deleteArticle({{ $article->id }})" class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@section('scripts')
<script>
function deleteArticle(articleId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')) {
        fetch(`/subscriber/submissions/${articleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Supprimer la carte de l'article du DOM
                document.querySelector(`[data-article-id="${articleId}"]`).remove();
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la suppression de l\'article');
        });
    }
}
</script>
@endsection 