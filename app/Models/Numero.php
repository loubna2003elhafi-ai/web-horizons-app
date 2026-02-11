<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Numero extends Model
{
    protected $table = 'numeros';
    protected $primaryKey = 'Id_numero';

    protected $fillable = [
        'titre_numero',
        'description',
        'image_couverture',
        'date_publication',
        'is_published',
        'statut',
        'visibilite',
        'theme_central',
        'numero_edition'
    ];

    protected $dates = [
        'date_publication',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'date_publication' => 'date',
        'is_published' => 'boolean'
    ];

    // Relations
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'numero_id', 'Id_numero');
    }

    // Méthodes utilitaires
    public function isPublic(): bool
    {
        return $this->visibilite === 'Public';
    }

    public function isPublished(): bool
    {
        return $this->statut === 'Publié';
    }

    public function totalArticles(): int
    {
        return $this->articles()->count();
    }

    public function publishedArticles(): HasMany
    {
        return $this->articles()->where('statut', 'Publié');
    }
} 