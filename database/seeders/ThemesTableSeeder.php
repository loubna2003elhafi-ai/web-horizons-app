<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemesTableSeeder extends Seeder
{
    public function run()
    {
        $themes = [
            'Intelligence Artificielle',
            'Développement Web',
            'Cybersécurité',
            'Cloud Computing',
            'Blockchain',
            'IoT',
            'Mobile Development',
            'Data Science'
        ];

        foreach ($themes as $theme) {
            Theme::create([
                'nom_theme' => $theme,
                'description' => "Articles sur $theme",
                'responsable_id' => 1, // L'éditeur créé dans UsersTableSeeder
            ]);
        }
    }
} 