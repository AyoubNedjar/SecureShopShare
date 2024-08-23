<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Boutique;
use Illuminate\Http\Request;

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

        Article::create($request->all());

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    // Affiche les détails d'un article spécifique
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
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
}
