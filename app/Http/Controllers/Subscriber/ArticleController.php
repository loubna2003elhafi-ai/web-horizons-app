<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedTheme = $request->query('theme');
        
        // Récupérer les thèmes auxquels l'utilisateur est abonné
        $subscribedThemes = $user->subscribedThemes;
        
        // Construire la requête des articles
        $articlesQuery = Article::where('statut', 'Publié')
            ->whereIn('theme_id', $subscribedThemes->pluck('id'))
            ->with(['theme', 'auteur'])
            ->latest('date_publication');
            
        // Filtrer par thème si sélectionné
        if ($selectedTheme) {
            $articlesQuery->where('theme_id', $selectedTheme);
        }
        
        $articles = $articlesQuery->paginate(9);
        
        return view('subscriber.articles.index', [
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
            return redirect()->route('subscriber.subscriptions')
                ->with('error', 'Vous devez être abonné au thème pour lire cet article.');
        }

        // Enregistrer dans l'historique
        $user->navigationHistory()->create([
            'article_id' => $article->id,
            'date_consultation' => now()
        ]);

        // Récupérer les articles similaires
        $similarArticles = Article::where('theme_id', $article->theme_id)
            ->where('id', '!=', $article->id)
            ->where('statut', 'Publié')
            ->latest('date_publication')
            ->take(3)
            ->get();

        return view('subscriber.articles.show', [
            'article' => $article->load(['theme', 'auteur']),
            'similarArticles' => $similarArticles
        ]);
    }

    public function rate(Request $request, Article $article)
    {
        $request->validate([
            'note' => 'required|integer|between:1,5'
        ]);

        $user = Auth::user();
        
        $article->notes()->updateOrCreate(
            ['user_id' => $user->id],
            ['note' => $request->note]
        );

        return response()->json([
            'success' => true,
            'message' => 'Note enregistrée',
            'newAverage' => $article->averageRating()
        ]);
    }

    
} 