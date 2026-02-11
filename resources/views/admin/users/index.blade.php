@extends('layouts.editor')

@section('title', 'Gestion des Utilisateurs - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editor/users.css') }}">
<link href="{{ asset('css/admin/users.css') }}" rel="stylesheet">
@endsection

@section('page-title', 'Gestion des Utilisateurs')

@section('header-actions')

@endsection

@section('content')
<div class="users-container">
@if($pendingUsers > 0)
    <a href="{{ route('editor.users.pending') }}" class="btn-pending" style="float:right">
        <span class="icon">🔔</span>
        {{ $pendingUsers }} demande(s) en attente
    </a>
@endif
<br>

    <div class="filters-section">
        <form action="{{ route('editor.users.index') }}" method="GET" class="filters-form">
            <div class="form-group">
                <label for="role">Filtrer par rôle</label>
                <select name="role" id="role" class="form-control">
                    <option value="">Tous les rôles</option>
                    <option value="Abonné" {{ request('role') == 'Abonné' ? 'selected' : '' }}>Abonné</option>
                    <option value="Responsable de thème" {{ request('role') == 'Responsable de thème' ? 'selected' : '' }}>Responsable de thème</option>
                    <option value="Éditeur" {{ request('role') == 'Éditeur' ? 'selected' : '' }}>Éditeur</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Filtrer par statut</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="Actif" {{ request('status') == 'Actif' ? 'selected' : '' }}>Actif</option>
                    <option value="Inactif" {{ request('status') == 'Inactif' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-filter">Filtrer</button>
                <a href="{{ route('editor.users.index') }}" class="btn-reset">Réinitialiser</a>
            </div>
        </form>
    </div>

    <div class="users-grid">
        @forelse($users as $user)
        <div class="user-card">
            <div class="user-header">
                <div class="user-avatar">
                    {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                </div>
                <div class="user-info">
                    <h3>{{ $user->prenom }} {{ $user->nom }}</h3>
                    <span class="user-email">{{ $user->email }}</span>
                </div>
                <div class="user-status {{ $user->statut }}">
                    {{ $user->statut }}
                </div>
            </div>

            <div class="user-details">
                <div class="detail-item">
                    <span class="label">Rôle</span>
                    <span class="value">{{ $user->role }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Inscrit le</span>
                    <span class="value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="user-actions">
                <form action="{{ route('editor.users.update-role', $user) }}" method="POST" class="role-form">
                    @csrf
                    <select name="role" class="form-control" onchange="this.form.submit()">
                        <option value="Abonné" {{ $user->role == 'Abonné' ? 'selected' : '' }}>Abonné</option>
                        <option value="Responsable de thème" {{ $user->role == 'Responsable de thème' ? 'selected' : '' }}>Responsable de thème</option>
                        <option value="Éditeur" {{ $user->role == 'Éditeur' ? 'selected' : '' }}>Éditeur</option>
                    </select>
                </form>

                @if($user->statut === 'Actif')
                    <form action="{{ route('editor.users.block', $user) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-block">Bloquer</button>
                    </form>
                @else
                    <form action="{{ route('editor.users.unblock', $user) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-unblock">Débloquer</button>
                    </form>
                @endif

                <form action="{{ route('editor.users.destroy', $user) }}" 
                      method="POST" 
                      class="inline"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Supprimer</button>
                </form>
            </div>
        </div>
        @empty
        <div class="no-users">
            <p>Aucun utilisateur trouvé</p>
        </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection 