<?php
namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    public function run()
    {
        Rating::create([
            'user_id' => 1, // ID_Utilisateur
            'article_id' => 1, // ID_Article
            'rating' => 5, // Note
        ]);

        Rating::create([
            'user_id' => 2,
            'article_id' => 2,
            'rating' => 4,
        ]);
    }
}
