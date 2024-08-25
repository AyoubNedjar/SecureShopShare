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
    $boutiques = Boutique::where('status', 'pending')
                             ->where('share_type', 'public')  // Assurez-vous que votre modèle a un champ share_type pour les boutiques
                             ->get();

        // Récupérer les articles en attente d'approbation et partagés publiquement
        $articles = Article::where('status', 'pending')
                           ->where('share_type', 'public')  // Assurez-vous que votre modèle a un champ share_type pour les articles
                           ->get();


    // Debugging: check if any article or boutique is missing a user


    return view('moderations.index', compact('boutiques', 'articles'));
}

    // Met à jour le statut d'une boutique ou d'un article (approbation/rejet)
    public function update(Request $request, $id)
    {
        $type = $request->input('type');
        $status = $request->input('status');

        if ($type === 'article') {
            $item = Article::findOrFail($id);
        } elseif ($type === 'boutique') {
            $item = Boutique::findOrFail($id);
        } else {
            return redirect()->back()->with('error', 'Invalid type.');
        }

        // Mettre à jour le statut
        $item->status = $status;
        $item->save();

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Item updated successfully.');
    }
}
