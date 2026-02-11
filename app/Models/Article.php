<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'contenu',
        'statut',
        'date_proposition',
        'date_proposition_editeur',
        'date_publication',
        'image_couverture',
        'temps_lecture',
        'vues',
        'theme_id',
        'user_id',
        'numero_id',
        'motif_rejet'
    ];

    protected $casts = [
        'date_publication' => 'datetime',
        'date_proposition' => 'datetime',
        'date_proposition_editeur' => 'datetime',
    ];

    // Article belongs to a theme
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    // Article belongs to a user (author)
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Article's notes
    public function notes(): HasMany
    {
        return $this->hasMany(ArticleNote::class);
    }

    // Article's conversations
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    // Article's navigation history
    public function navigationHistory(): HasMany
    {
        return $this->hasMany(NavigationHistory::class);
    }

    // Article's tags
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // Article's numero
    public function numero(): BelongsTo
    {
        return $this->belongsTo(Numero::class, 'numero_id', 'Id_numero');
    }

    // Méthode pour calculer la note moyenne
    public function averageRating()
    {
        return $this->notes()->avg('note');
    }

    // Lecteurs de l'article (via l'historique de navigation)
    public function lecteurs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'navigation_history')
            ->withPivot('date_consultation')
            ->withTimestamps();
    }
}
