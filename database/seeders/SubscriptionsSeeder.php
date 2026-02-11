<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionsSeeder extends Seeder
{
    public function run()
    {
        // Pour chaque abonné (ID 2-6)
        for ($user_id = 1; $user_id <= 6; $user_id++) {
            // S'abonner à 3 thèmes aléatoires
            $theme_ids = range(1, 8);
            shuffle($theme_ids);
            $selected_themes = array_slice($theme_ids, 0, 3);

            foreach ($selected_themes as $theme_id) {
                Subscription::create([
                    'user_id' => $user_id,
                    'theme_id' => $theme_id,
                    'date_abonnement' => now(),
                ]);
            }
        }
    }
} 