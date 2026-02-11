@extends('layouts.subscriber')

@section('title', 'Historique de lecture')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/history.css') }}">
<link rel="stylesheet" href="{{ asset('css/subscriber/pagination.css') }}">
@endsection

@section('content')
<div class="history-container">
    <div class="history-header">
        <h1>Historique de lecture</h1>
        
        <form action="{{ route('subscriber.history') }}" method="GET" class="filters-form">
            <div class="form-group">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Rechercher un article..."
                       value="{{ request('search') }}">
            </div>

            <div class="form-group">
                <select name="theme" class="form-control">
                    <option value="">Tous les thèmes</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->id }}" {{ request('theme') == $theme->id ? 'selected' : '' }}>
                            {{ $theme->nom_theme }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="date-filters">
                <div class="form-group">
                    <input type="date" 
                           name="date_start" 
                           class="form-control"
                           value="{{ request('date_start') }}">
                </div>
                <div class="form-group">
                    <input type="date" 
                           name="date_end" 
                           class="form-control"
                           value="{{ request('date_end') }}">
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-filter"></i>
                Filtrer
            </button>
        </form>
    </div>

    <div class="history-list">
        @forelse($history as $item)
            <div class="history-item">
                <div class="article-info">
                    <h3>
                        <a href="{{ route('subscriber.articles.show', $item->article) }}">
                            {{ $item->article->titre }}
                        </a>
                    </h3>
                    <div class="meta">
                        <span class="theme">
                            <i class="fas fa-bookmark"></i>
                            {{ $item->article->theme->nom_theme }}
                        </span>
                        <span class="author">
                            <i class="fas fa-user"></i>
                            {{ $item->article->auteur->nom }}
                        </span>
                        <span class="date">
                            <i class="fas fa-clock"></i>
                            Lu le {{ $item->date_consultation->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-history">
                <i class="fas fa-history"></i>
                <h3>Aucun historique</h3>
                <p>Vous n'avez pas encore lu d'articles</p>
                <a href="{{ route('subscriber.articles') }}" class="btn-primary">
                    Découvrir les articles
                </a>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $history->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 