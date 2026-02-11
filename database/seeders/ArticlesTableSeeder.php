<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        // Récupérer quelques utilisateurs et thèmes pour les articles
        $users = User::where('role', 'Abonné')->take(3)->get();
        $themes = Theme::all();

        foreach ($themes as $theme) {
            // Créer 2-3 articles publiés par thème
            for ($i = 1; $i <= rand(2, 3); $i++) {
                Article::create([
                    'titre' => "l'Article $i du thème {$theme->nom_theme}",
                    'contenu' => "Contenu de l'article $i du thème {$theme->nom_theme}...",
                    'statut' => 'Publié',
                    'date_proposition' => now(),
                    'date_proposition_editeur' => now(),
                    'date_publication' => now(),
                    'image_couverture' => 'articles/IOT.png',
                    'temps_lecture' => rand(5, 15),
                    'vues' => rand(50, 200),
                    'theme_id' => $theme->id,
                    'user_id' => $users->random()->id
                ]);
            }

            // Créer 1-2 articles en cours
            for ($i = 1; $i <= rand(1, 2); $i++) {
                Article::create([
                    'titre' => "Article en cours $i du thème {$theme->nom_theme}",
                    'contenu' => "Contenu de l'article en cours $i du thème {$theme->nom_theme}...",
                    'statut' => 'En cours',
                    'date_proposition' => now(),
                    'date_proposition_editeur' => now(),
                    'image_couverture' => 'articles/default.jpg',
                    'temps_lecture' => rand(5, 15),
                    'theme_id' => $theme->id,
                    'user_id' => $users->random()->id
                ]);
            }

            // Créer 1 article retenu (proposé)
            Article::create([
                'titre' => "Article proposé du thème {$theme->nom_theme}",
                'contenu' => "Contenu de l'article proposé du thème {$theme->nom_theme}...",
                'statut' => 'Retenu',
                'date_proposition' => now(),
                'date_proposition_editeur' => now(),
                'image_couverture' => 'articles/default.jpg',
                'temps_lecture' => rand(5, 15),
                'theme_id' => $theme->id,
                'user_id' => $users->random()->id
            ]);
        }
    }
} 