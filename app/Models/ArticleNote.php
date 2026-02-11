<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleNote extends Model
{
    protected $table = 'notes_des_articles';

    protected $fillable = [
        'article_id',
        'user_id',
        'note'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

