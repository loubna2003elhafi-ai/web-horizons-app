<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['theme', 'auteur', 'numero'])
            ->where('statut', '!=', 'En cours')
            ->orderBy('date_proposition_editeur', 'desc')
            ->get()
            ->groupBy('statut');

        $numeros = Numero::where('is_published', false)->get();

        return view('admin.articles.index', compact('articles', 'numeros'));
    }

    public function show(Article $article)
    {
        $article->load(['auteur', 'theme', 'numero', 'conversations.user']);
        return view('admin.articles.show', compact('article'));
    }

    public function assignToNumero(Request $request, Article $article)
    {
        $validated = $request->validate([
            'numero_id' => 'required|exists:numeros,Id_numero'
        ], [
            'numero_id.required' => 'Veuillez sélectionner un numéro',
            'numero_id.exists' => 'Le numéro sélectionné n\'existe pas'
        ]);

        try {
            $article->update([
                'numero_id' => $validated['numero_id'],
            ]);

            return back()->with('success', 'Article affecté au numéro avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'affectation de l\'article.');
        }
    }

    public function toggleStatus(Article $article)
    {
        if ($article->statut === 'Publié') {
            $article->update([
                'statut' => 'Désactivé'
            ]);
            $message = 'Article désactivé avec succès.';
        } else {
            $article->update([
                'statut' => 'Publié',
                'date_publication' => now()
            ]);
            $message = 'Article activé avec succès.';
        }
            
        return back()->with('success', $message);
    }

    public function destroy(Article $article)
    {
        // Supprimer l'image de couverture si elle existe
        if ($article->image_couverture) {
            Storage::disk('public')->delete($article->image_couverture);
        }

        $article->delete();

        return back()->with('success', 'Article supprimé avec succès.');
    }
} 