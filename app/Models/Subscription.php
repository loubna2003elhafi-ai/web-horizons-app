<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $fillable = [
        'date_abonnement',
        'user_id',
        'theme_id',
        
    ];

    // Subscription belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Subscription belongs to a theme
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
