@extends('layouts.subscriber')

@section('title', 'Mes abonnements')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/subscriber/memberships.css') }}">
@endsection

@section('content')
<div class="memberships-container">
    <div class="memberships-header">
        <h1>Mes abonnements aux thèmes</h1>
        <p>Gérez vos abonnements pour personnaliser votre flux d'articles</p>
    </div>

    <div class="themes-grid">
        @foreach($themes as $theme)
            <div class="theme-card">
                <div class="theme-content">
                    <h3>{{ $theme->nom_theme }}</h3>
                    <p>{{ $theme->description }}</p>
                </div>
                
                <div class="theme-actions">
                    @if(in_array($theme->id, $subscribedThemeIds))
                        <button onclick="unsubscribeFromTheme({{ $theme->id }})" 
                                class="btn-unsubscribe">
                            <i class="fas fa-times"></i>
                            Se désabonner
                        </button>
                    @else
                        <button onclick="subscribeToTheme({{ $theme->id }})" 
                                class="btn-subscribe">
                            <i class="fas fa-plus"></i>
                            S'abonner
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
function subscribeToTheme(themeId) {
    fetch(`/subscriber/subscriptions/${themeId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    });
}

function unsubscribeFromTheme(themeId) {
    if (confirm('Êtes-vous sûr de vouloir vous désabonner de ce thème ?')) {
        fetch(`/subscriber/subscriptions/${themeId}`, {
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
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        });
    }
}
</script>
@endsection 