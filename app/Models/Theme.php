<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_theme',
        'description',
        'responsable_id'
    ];

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriptions')
                    ->withPivot('date_abonnement')
                    ->withTimestamps();
    }

    public function abonnements(): HasMany
    {
        return $this->hasMany(Subscription::class, 'theme_id');
    }

  
}
