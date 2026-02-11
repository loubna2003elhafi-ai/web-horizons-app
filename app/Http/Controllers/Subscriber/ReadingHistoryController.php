<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Start with user's reading history
        $query = $user->navigationHistory()
            ->with(['article.theme', 'article.auteur']);

        // Theme filter
        if ($request->theme) {
            $query->whereHas('article', function($q) use ($request) {
                $q->where('theme_id', $request->theme);
            });
        }

        // Date filters
        if ($request->date_start) {
            $query->whereDate('date_consultation', '>=', $request->date_start);
        }
        if ($request->date_end) {
            $query->whereDate('date_consultation', '<=', $request->date_end);
        }

        // Search filter
        if ($request->search) {
            $query->whereHas('article', function($q) use ($request) {
                $q->where('titre', 'like', "%{$request->search}%")
                    ->orWhere('contenu', 'like', "%{$request->search}%");
            });
        }

        // Get paginated history
        $history = $query->orderBy('date_consultation', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get themes for filter dropdown
        $themes = Theme::all();

        return view('subscriber.history.index', [
            'history' => $history,
            'themes' => $themes
        ]);
    }
} 