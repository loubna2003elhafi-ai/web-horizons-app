<?php

namespace App\Http\Controllers\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Responsable de thème') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function deleteMessage(Conversation $message)
    {
        $theme = Auth::user()->managedTheme;
        
        // Vérifier si le message appartient à un article du thème
        if ($message->article->theme_id !== $theme->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à modérer ce message.');
        }

        $message->delete();
        return back()->with('success', 'Message supprimé avec succès.');
    }

    public function addComment(Request $request, Article $article)
    {
        $theme = Auth::user()->managedTheme;
        
        if ($article->theme_id !== $theme->id) {
            return back()->with('error', 'Vous n\'êtes pas autorisé à commenter cet article.');
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $article->conversations()->create([
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        return back()->with('success', 'Commentaire ajouté avec succès.');
    }
} 