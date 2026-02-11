@extends('layouts.editor')

@section('title', 'Demandes en attente - Éditeur')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endsection

@section('page-title', 'Demandes d\'inscription en attente')

@section('header-actions')
<a href="{{ route('editor.users.index') }}" class="btn-back">
    <span class="icon">←</span>
    Retour à la liste
</a>
@endsection

@section('content')
<div class="users-container">
    <a href="{{ route('editor.users.index') }}" class="btn-back">
        <span class="icon">←</span>
        Retour à la liste
    </a>
    <br><br>
    <div class="users-grid">
        @forelse($users as $user)
        <div class="user-card pending">
            <div class="user-header">
                <div class="user-avatar">
                    {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                </div>
                <div class="user-info">
                    <h3>{{ $user->prenom }} {{ $user->nom }}</h3>
                    <span class="user-email">{{ $user->email }}</span>
                </div>
                <div class="user-status pending">
                    En attente
                </div>
            </div>

            <div class="user-details">
                <div class="detail-item">
                    <span class="label">Demandé le</span>
                    <span class="value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="detail-item">
                    <span class="label">Rôle souhaité</span>
                    <span class="value">{{ $user->role }}</span>
                </div>
            </div>

            <div class="user-actions">
                <form action="{{ route('editor.users.update-role', $user) }}" method="POST" class="role-form">
                    @csrf
                    <select name="role" class="form-control">
                        <option value="Abonné" {{ $user->role == 'Abonné' ? 'selected' : '' }}>Abonné</option>
                        <option value="Responsable de thème" {{ $user->role == 'Responsable de thème' ? 'selected' : '' }}>Responsable de thème</option>
                    </select>
                </form>

                <div class="approval-actions">
                    <form action="{{ route('editor.users.unblock', $user) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-approve">Approuver</button>
                    </form>

                    <form action="{{ route('editor.users.destroy', $user) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-reject">Rejeter</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="no-users">
            <p>Aucune demande en attente</p>
            <a href="{{ route('editor.users.index') }}" class="btn-back">Retour à la liste des utilisateurs</a>
        </div>
        @endforelse
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>
@endsection 