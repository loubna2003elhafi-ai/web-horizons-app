<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Theme;
use App\Models\Article;
use App\Models\Numero;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Éditeur') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $articlesCount = Article::count();
        $usersCount = User::count();
        $numerosCount = Numero::count();
        $isEmpty = $articlesCount === 0 && $usersCount === 0 && $numerosCount === 0;

        $stats = [
            'total_abonnes' => User::where('role', 'Abonné')
                                  ->where('statut', 'actif')
                                  ->count(),
            'total_responsables' => User::where('role', 'Responsable de thème')->count(),
            'total_numeros' => Numero::count(),
            'total_themes' => Theme::count(),
            
            // Statistiques des articles par statut
            'total_articles' => Article::whereIn('statut', ['Publié', 'En cours', 'Retenu'])->count(),
            'articles_publies' => Article::where('statut', 'Publié')->count(),
            'articles_en_cours' => Article::where('statut', 'En cours')->count(),
            'articles_proposes' => Article::where('statut', 'Retenu')
                                        ->whereNotNull('date_proposition_editeur')
                                        ->count(),
            
            // Articles par thème avec comptage direct via la base de données
            'articles_par_theme' => Theme::select('themes.nom_theme', DB::raw('COUNT(articles.id) as articles_count'))
                ->leftJoin('articles', 'themes.id', '=', 'articles.theme_id')
                ->whereIn('articles.statut', ['Publié', 'En cours'])
                ->groupBy('themes.id', 'themes.nom_theme')
                ->get(),
            
            // Abonnements par thème avec comptage direct
            'abonnements_par_theme' => Theme::select('themes.nom_theme', DB::raw('COUNT(subscriptions.id) as abonnements_count'))
                ->leftJoin('subscriptions', 'themes.id', '=', 'subscriptions.theme_id')
                ->groupBy('themes.id', 'themes.nom_theme')
                ->get(),
            
            // Derniers articles avec leurs relations
            'derniers_articles' => Article::with(['auteur', 'theme'])
                ->whereIn('statut', ['Publié', 'En cours'])
                ->latest()
                ->take(5)
                ->get(),
            
            // Articles proposés récemment
            'derniers_articles_proposes' => Article::with(['auteur', 'theme'])
                ->where('statut', 'Retenu')
                ->whereNotNull('date_proposition_editeur')
                ->latest('date_proposition_editeur')
                ->take(4)
                ->get(),
            
            // Derniers utilisateurs inscrits
            'derniers_utilisateurs' => User::latest()
                ->take(5)
                ->get(),
            
            // Statistiques supplémentaires
            'numeros_publies' => Numero::where('is_published', true)->count(),
            'abonnements_mois' => Subscription::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.dashboard', compact('stats', 'articlesCount', 'usersCount', 'numerosCount', 'isEmpty'));
    }
} 