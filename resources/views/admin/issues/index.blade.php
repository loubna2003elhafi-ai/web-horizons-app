@extends('layouts.editor')

@section('title', 'Gestion des Numéros - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/issues.css') }}">
@endsection

@section('page-title', 'Gestion des Numéros')

@section('header-actions')
<a href="{{ route('editor.issues.create') }}" class="btn-primary">
    <i class="fas fa-plus"></i>
    Nouveau numéro
</a>
@endsection

@section('content')
<div class="issues-container">
    <div class="issues-header">
        <h1>Gestion des Numéros</h1>
        <a href="{{ route('editor.issues.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i>
            Nouveau numéro
        </a>
    </div>

    <div class="issues-grid">
        @forelse($numeros as $numero)
            <div class="issue-card">
                <div class="issue-cover">
                    @if($numero->image_couverture)
                        <img src="{{ asset('storage/' . $numero->image_couverture) }}" alt="Couverture {{ $numero->titre_numero }}">
                    @else
                        <div class="placeholder-cover">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                </div>

                <div class="issue-content">
                    <div class="issue-header">
                        <h3 class="issue-title">{{ $numero->titre_numero }}</h3>
                        <span class="issue-number">#{{ $numero->numero_edition }}</span>
                    </div>
                    
                    <p class="issue-description">{{ Str::limit($numero->description, 120) }}</p>
                    
                    <div class="issue-meta">
                        <div class="meta-item">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $numero->date_publication->format('d/m/Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-newspaper"></i>
                            <span>{{ $numero->articles->count() }} articles</span>
                        </div>
                        <div class="meta-item">
                        <i class="fas {{ $numero->visibilite === 'Public' ? 'fa-globe' : ' fa-lock' }}"></i>
                            <span>{{ $numero->visibilite }} </span>
                        </div>
                    </div>
                </div>

                <div class="issue-actions">
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('editor.issues.edit', $numero) }}" class="btn-action">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                        @if(!$numero->is_published)
                            <form action="{{ route('editor.issues.publish', $numero) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-publish">Publier</button>
                            </form>
                        @else
                            <form action="{{ route('editor.issues.unpublish', $numero) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-unpublish">Dépublier</button>
                            </form>
                        @endif
                    </div>
                    <form action="{{ route('editor.issues.toggle-visibility', $numero) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-action {{ $numero->visibilite === 'Public' ? 'btn-warning' : 'btn-success' }}">
                            <i class="fas {{ $numero->visibilite === 'Public' ? 'fa-lock' : 'fa-globe' }}"></i>
                            {{ $numero->visibilite === 'Public' ? 'Rendre privé' : 'Rendre public' }}
                        </button>
                    </form>

                    <form action="{{ route('editor.issues.destroy', $numero) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce numéro ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-danger">
                            <i class="fas fa-trash"></i>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-book"></i>
                <h3>Aucun numéro</h3>
                <p>Commencez par créer votre premier numéro</p>
                <a href="{{ route('editor.issues.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>
                    Créer un numéro
                </a>
            </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $numeros->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 