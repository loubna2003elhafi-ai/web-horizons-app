<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Numero;

class NumerosTableSeeder extends Seeder
{
    public function run()
    {
        Numero::create([
            'titre_numero' => 'Intelligence Artificielle : Les Avancées de 2024',
            'description' => 'Découvrez les dernières innovations en IA et leur impact sur notre société',
            'date_publication' => now(),
            'is_published' => true,
            'visibilite' => 'Public',
            'theme_central' => 'Intelligence Artificielle',
            'numero_edition' => 1,
            'image_couverture' => 'numeros/janvier2024.jpg'
        ]);

        Numero::create([
            'titre_numero' => 'Cybersécurité : Enjeux et Solutions',
            'description' => 'Un aperçu complet des défis actuels en cybersécurité',
            'date_publication' => now()->addMonth(),
            'is_published' => false,
            'visibilite' => 'Privé',
            'theme_central' => 'Cybersécurité',
            'numero_edition' => 2,
            'image_couverture' => 'numeros/fevrier2024.jpg'
        ]);
    }
} 