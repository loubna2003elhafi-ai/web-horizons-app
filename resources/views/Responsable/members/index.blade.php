@extends('layouts.responsable')

@section('title', 'Gestion des Abonnés - Responsable de thème')

@section('styles')
<link href="{{ asset('css/responsable/members.css') }}" rel="stylesheet">
<link href="{{ asset('css/subscriber/pagination.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="members-container">
    <div class="members-header">
        <h1>Gestion des Abonnés</h1>
        <div class="header-actions">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher un abonné..." value="{{ request('search') }}">
            </div>
        </div>
    </div>

    <div class="members-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $totalSubscribers }}</span>
                <span class="stat-label">Total Abonnés</span>
            </div>
        </div>
    </div>

    <div class="members-table-container">
        <table class="members-table">
            <thead>
                <tr>
                    <th>Abonné</th>
                    <th>Email</th>
                    <th>Date d'abonnement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr>
                        <td>
                            <div class="subscriber-info">
                                <div class="subscriber-avatar">
                                    {{ substr($subscriber->prenom, 0, 1) }}{{ substr($subscriber->nom, 0, 1) }}
                                </div>
                                <div class="subscriber-details">
                                    <span class="subscriber-name">{{ $subscriber->nom }} {{ $subscriber->prenom }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->pivot->date_abonnement }}</td>
                        <td>
                            <div class="table-actions">
                                <form action="{{ route('responsable.members.remove', $subscriber) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon text-danger" title="Supprimer" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir retirer cet abonné ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>Aucun abonné trouvé</h3>
                                <p>Il n'y a pas encore d'abonnés dans votre thème.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $subscribers->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection 