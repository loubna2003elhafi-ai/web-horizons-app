<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationHistory extends Model
{
    protected $table = 'navigation_history';

    protected $fillable = [
        'user_id',
        'article_id',
        'date_consultation'
    ];

    protected $casts = [
        'date_consultation' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
