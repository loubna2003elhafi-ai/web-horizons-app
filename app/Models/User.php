<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    protected $fillable = [
        'nom',
        'email',
        'password',
        'role',
        'date_inscription',
        'statut'
    ];

    // User can have many articles
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    // User can be subscribed to many themes
    public function subscribedThemes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'subscriptions')
                    ->withPivot('date_abonnement')
                    ->withTimestamps();
    }

    // User's navigation history
    public function navigationHistory(): HasMany
    {
        return $this->hasMany(NavigationHistory::class);
    }

    // User's article notes
    public function articleNotes(): HasMany
    {
        return $this->hasMany(ArticleNote::class);
    }

    // User's conversations
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Get the theme managed by the user.
     */
    public function managedTheme()
    {
        return $this->hasOne(Theme::class, 'responsable_id');
    }
}

