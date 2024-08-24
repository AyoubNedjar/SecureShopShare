<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ModerationController extends Controller
{
    // Affiche la liste des éléments à modérer
    public function index()
{
    $boutiques = Boutique::with('user')->where('status', 'pending')->get();
    $articles = Article::with(['user'])->where('status', 'pending')->get();


    // Debugging: check if any article or boutique is missing a user


    return view('moderations.index', compact('boutiques', 'articles'));
}

    // Met à jour le statut d'une boutique ou d'un article (approbation/rejet)
    public function update(Request $request, $id)
    {
        $type = $request->input('type');
        $status = $request->input('status');

        if ($type == 'boutique') {
            $boutique = Boutique::findOrFail($id);
            $boutique->update(['status' => $status]);
        } elseif ($type == 'article') {
            $article = Article::findOrFail($id);
            $article->update(['status' => $status]);
        }

        return redirect()->route('moderations.index')->with('success', 'Statut mis à jour avec succès.');
    }
}
