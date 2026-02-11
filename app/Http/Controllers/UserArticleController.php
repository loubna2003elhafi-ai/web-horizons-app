<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserArticleController extends Controller
{
    public function index(Request $request)
    {
        echo 'selectedTheme : ';
        $user = Auth::user();
        $selectedTheme = $request->query('theme');
        // Récupérer les thèmes auxquels l'utilisateur est abonné
        $subscribedThemes = $user->subscribedThemes;
        
        // Construire la requête des articles
        $articlesQuery = Article::where('statut', 'publié')
            ->whereIn('theme_id', $subscribedThemes->pluck('id'))
            ->with(['theme', 'auteur'])
            ->latest('date_publication');
            
        // Filtrer par thème si sélectionné
        if ($selectedTheme) {
            $articlesQuery->where('theme_id', $selectedTheme);
        }
        
        // Paginer les résultats
        $articles = $articlesQuery->paginate(12);
        
        return view('user.articles', [
            'articles' => $articles,
            'subscribedThemes' => $subscribedThemes,
            'selectedTheme' => $selectedTheme
        ]);
    }

    public function show(Article $article)
    {
        // Vérifier si l'utilisateur est abonné au thème de l'article
        $user = Auth::user();
        if (!$user->subscribedThemes->contains('id', $article->theme_id)) {
            return redirect()->route('user.subscriptions')
                ->with('error', 'Vous devez être abonné au thème pour lire cet article.');
        }

        // Enregistrer dans l'historique
        $user->navigationHistory()->create([
            'article_id' => $article->id,
            'date_consultation' => now()
        ]);

        return view('user.article-detail', [
            'article' => $article->load(['theme', 'auteur'])
        ]);
    }
} 