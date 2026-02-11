@extends('layouts.subscriber')

@section('title', 'Proposer un article')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/submissions.css') }}">
@endsection

@section('content')
<div class="submission-form-container">
    <div class="form-header">
        <h1>Proposer un article</h1>
        <a href="{{ route('subscriber.submissions.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Retour aux propositions
        </a>
    </div>

    <form action="{{ route('subscriber.submissions.store') }}" method="POST" enctype="multipart/form-data" class="submission-form">
        @csrf
        
        <div class="form-group">
            <label for="titre">Titre de l'article</label>
            <input type="text" 
                   id="titre" 
                   name="titre" 
                   class="form-control @error('titre') is-invalid @enderror"
                   value="{{ old('titre') }}" 
                   required>
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="theme_id">Thème</label>
            <select id="theme_id" 
                    name="theme_id" 
                    class="form-control @error('theme_id') is-invalid @enderror" 
                    required>
                <option value="">Sélectionnez un thème</option>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" {{ old('theme_id') == $theme->id ? 'selected' : '' }}>
                        {{ $theme->nom_theme }}
                    </option>
                @endforeach
            </select>
            @error('theme_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contenu">Contenu de l'article</label>
            <textarea id="contenu" 
                      name="contenu" 
                      class="form-control @error('contenu') is-invalid @enderror" 
                      rows="10" 
                      required>{{ old('contenu') }}</textarea>
            @error('contenu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="temps_lecture">Temps de lecture (en minutes)</label>
            <input type="number" 
                   id="temps_lecture" 
                   name="temps_lecture" 
                   class="form-control @error('temps_lecture') is-invalid @enderror"
                   value="{{ old('temps_lecture') }}" 
                   min="1"
                   required>
            @error('temps_lecture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="image_couverture">Image de couverture (optionnelle)</label>
            <input type="file" 
                   id="image_couverture" 
                   name="image_couverture" 
                   class="form-control @error('image_couverture') is-invalid @enderror"
                   accept="image/*">
            @error('image_couverture')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" name="action" value="draft" class="btn-secondary">
                Enregistrer comme brouillon
            </button>
            <button type="submit" name="action" value="submit" class="btn-primary">
                Soumettre l'article
            </button>
        </div>
    </form>
</div>
@endsection 