<?php

namespace App\Http\Controllers\Editeur;

use App\Http\Controllers\Controller;
use App\Models\Numero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NumeroController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'Éditeur') {
            abort(403, 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $numeros = Numero::with(['articles'])
            ->orderBy('numero_edition', 'desc')
            ->paginate(12);
        return view('admin.issues.index', compact('numeros'));
    }

    public function create()
    {
        return view('admin.issues.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre_numero' => 'required|string|max:255',
            'description' => 'nullable|string',
            'theme_central' => 'nullable|string|max:255',
            'numero_edition' => 'required|integer|unique:numeros,numero_edition',
            'date_publication' => 'nullable|date',
            'visibilite' => 'required|in:Public,Privé',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        // Set the current date and time for 'date_publication' if it's not provided
        if (empty($validated['date_publication'])) {
            $validated['date_publication'] = now(); // or use Carbon\Carbon::now()
        }

        if ($request->hasFile('image_couverture')) {
            $path = $request->file('image_couverture')->store('numeros', 'public');
            $validated['image_couverture'] = $path;
        }

        $numero = Numero::create($validated);

        return redirect()
            ->route('editor.issues.index')
            ->with('success', 'Numéro créé avec succès.');
    }

    public function edit(Numero $numero)
    {
        return view('admin.issues.form', compact('numero'));
    }

    public function update(Request $request, Numero $numero)
    {
        $validated = $request->validate([
            'titre_numero' => 'required|string|max:255',
            'description' => 'nullable|string',
            'theme_central' => 'nullable|string|max:255',
            'numero_edition' => 'required|integer|unique:numeros,numero_edition,' . $numero->Id_numero . ',Id_numero',
            'date_publication' => 'nullable|date',
            'visibilite' => 'required|in:Public,Privé',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Set the current date and time for 'date_publication' if it's not provided
        if (empty($validated['date_publication'])) {
            $validated['date_publication'] = now(); // or use Carbon\Carbon::now()
        }

        if ($request->hasFile('image_couverture')) {
            // Supprimer l'ancienne image si elle existe
            if ($numero->image_couverture) {
                Storage::disk('public')->delete($numero->image_couverture);
            }
            $path = $request->file('image_couverture')->store('numeros', 'public');
            $validated['image_couverture'] = $path;
        }

        $numero->update($validated);

        return redirect()
            ->route('editor.issues.index')
            ->with('success', 'Numéro mis à jour avec succès.');
    }

    public function publish(Numero $numero)
    {
        // Vérifier si le numéro a des articles
        if ($numero->articles()->count() === 0) {
            return back()->with('error', 'Impossible de publier un numéro sans articles.');
        }

        $numero->update([
            'is_published' => true,
            'date_publication' => now()
        ]);

        // Publier tous les articles du numéro
        $numero->articles()->update(['statut' => 'Publié']);

        return back()->with('success', 'Numéro publié avec succès.');
    }

    public function unpublish(Numero $numero)
    {
        $numero->update([
            'is_published' => false
        ]);

        return back()->with('success', 'Numéro dépublié avec succès.');
    }

    public function toggleVisibility(Numero $numero)
    {
        $newVisibility = $numero->visibilite === 'Public' ? 'Privé' : 'Public';
        
        $numero->update(['visibilite' => $newVisibility]);

        return back()->with('success', 'Visibilité du numéro mise à jour.');
    }

    public function destroy(Numero $numero)
    {
        // Vérifier si le numéro peut être supprimé
        if ($numero->articles()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un numéro contenant des articles.');
        }

        // Supprimer l'image de couverture
        if ($numero->image_couverture) {
            Storage::disk('public')->delete($numero->image_couverture);
        }

        $numero->delete();

        return back()->with('success', 'Numéro supprimé avec succès.');
    }

    public function manageArticles(Numero $numero)
    {
        $articles = $numero->articles()->with(['auteur', 'theme'])->paginate(10);
        return view('admin.issues.articles', compact('numero', 'articles'));
    }

    public function addArticle(Request $request, Numero $numero)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id'
        ]);

        $article = Article::findOrFail($validated['article_id']);
        $article->update(['numero_id' => $numero->Id_numero]);

        return back()->with('success', 'Article ajouté au numéro avec succès.');
    }

    public function removeArticle(Numero $numero, Article $article)
    {
        if ($article->numero_id !== $numero->Id_numero) {
            return back()->with('error', 'Cet article n\'appartient pas à ce numéro.');
        }

        $article->update(['numero_id' => null]);

        return back()->with('success', 'Article retiré du numéro avec succès.');
    }
} 