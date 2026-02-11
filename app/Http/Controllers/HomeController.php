<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Numero;
use App\Models\Theme;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les thèmes avec le nombre d'articles
        $themes = Theme::withCount(['articles' => function($query) {
            $query->where('statut', 'Publié');
        }])->get();

        // Récupérer les articles des numéros publiés
        $latestArticles = Article::whereHas('numero', function($query) {
                return $query->where('is_published', true);
            })
            ->where('statut', 'Publié')
            ->with(['auteur', 'theme', 'numero'])
            ->latest('date_publication')
            ->take(3)
            ->get();

        return view('home', compact('latestArticles', 'themes'));
    }

    public function showArticle(Article $article)
    {
        // Vérifier si l'article est publié et appartient à un numéro publié
        if ($article->statut !== 'Publié' || !$article->numero || !$article->numero->is_published) {
            abort(404);
        }

        return view('articles.public.show', compact('article'));
    }
} 