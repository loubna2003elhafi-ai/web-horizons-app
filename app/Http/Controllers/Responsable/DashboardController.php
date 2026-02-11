<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\Theme;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Responsable de thème') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $theme = Auth::user()->managedTheme;
        if (!$theme) {
            return back()->with('error', 'Vous n\'êtes pas responsable d\'un thème.');
        }

        $stats = [
            'total_subscribers' => $theme->subscribers()->count(),
            'pending_articles' => $theme->articles()->where('statut', 'En cours')->count(),
            'published_articles' => $theme->articles()->where('statut', 'Publié')->count(),
            'total_views' => $theme->articles()->sum('vues'),
            'recent_subscriptions' => $theme->subscribers()
                ->orderBy('subscriptions.created_at', 'desc')
                ->take(5)
                ->get(),
            'recent_articles' => $theme->articles()
                ->with('auteur')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        ];

        return view('responsable.dashboard', compact('theme', 'stats'));
    }
} 