<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Boutique;
use Illuminate\Http\Request;
use App\Models\User; 

class ArticleController extends Controller
{
    // Affiche la liste des articles
    public function index()
    {
        $articles = Article::where('user_id', auth()->id())->get();
        return view('articles.index', compact('articles'));
    }

    // Affiche le formulaire de création d'un article
    public function create()
    {
        $boutiques = Boutique::where('user_id', auth()->id())->get();
        return view('articles.create', compact('boutiques'));
    }

    // Stocke un nouvel article
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'boutique_id' => 'required|exists:boutiques,id',
        ]);
    
        // Créer un nouvel article en ajoutant manuellement l'user_id
        $article = new Article($request->all());
        $article->user_id = auth()->id(); // Associe l'article à l'utilisateur connecté
        $article->save();

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    // Affiche les détails d'un article spécifique
    public function show(Article $article)
{
    // Récupère tous les utilisateurs sauf l'utilisateur actuel
    $users = User::all();
    
    // Passe l'article et les utilisateurs à la vue
    return view('articles.show', compact('article', 'users'));
}

    // Affiche le formulaire d'édition d'un article spécifique
    public function edit(Article $article)
    {
        $boutiques = Boutique::all();
        return view('articles.edit', compact('article', 'boutiques'));
    }

    // Met à jour un article existant
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'boutique_id' => 'required|exists:boutiques,id',
        ]);

        $article->update($request->all());

        return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    // Supprime un article
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
    // App/Http/Controllers/ArticleController.php

    public function share(Request $request, Article $article)
    {
        $request->validate([
            'share_type' => 'required|in:public,private',
            'shared_with_user_id' => 'nullable|exists:users,id',
        ]);

        $article->update([
            'share_type' => $request->input('share_type'),
            'shared_with_user_id' => $request->input('share_type') === 'private' ? $request->input('shared_with_user_id') : null,
        ]);

        return redirect()->route('articles.show', $article->id)->with('success', 'Article shared successfully.');
    }

}
