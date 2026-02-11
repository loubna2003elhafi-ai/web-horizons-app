<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationHistory;

class NavigationHistorySeeder extends Seeder
{
    public function run()
    {
        // Pour chaque abonné
        for ($user_id = 1; $user_id <= 6; $user_id++) {
            // Créer 5 entrées d'historique
            for ($i = 0; $i < 5; $i++) {
                NavigationHistory::create([
                    'user_id' => $user_id,
                    'article_id' => rand(1, 24), // Il y a 24 articles au total (8 thèmes * 3 articles)
                    'created_at' => now()->subDays(rand(0, 30)), // Date aléatoire dans les 30 derniers jours
                    'date_consultation' => now(),
                ]);
            }
        }
    }
} 